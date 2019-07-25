<?php
/**
 * Copy Rows Background Process
 *
 * @package NS_Cloner
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * NS_Cloner_Rows Process class.
 *
 * Processes a queue of table rows and copies each one from a source table to a target table.
 */
class NS_Cloner_Rows_Process extends NS_Cloner_Process {

	/**
	 * Ajax action hook
	 *
	 * @var string
	 */
	protected $action = 'rows_process';

	/**
	 * Initialize and set label
	 */
	public function __construct() {
		parent::__construct();
		$this->report_label = __( 'Rows', 'ns-cloner' );

		// Create dependency - this will auto-dispatch when table processing is complete.
		add_action( 'ns_cloner_tables_process_complete', [ $this, 'dispatch'] );
	}

	/**
	 * Task
	 *
	 * Override this method to perform any actions required on each
	 * queue item. Return the modified item for further processing
	 * in the next pass through. Or, return false to remove the
	 * item from the queue.
	 *
	 * @param mixed $item Queue item to iterate over.
	 *
	 * @return mixed
	 */
	protected function task( $item ) {

		$source_table = $item['source_table'];
		$target_table = $item['target_table'];
		$source_id    = $item['source_id'];
		$target_id    = $item['target_id'];
		$row_num      = $item['row_num'];

		// Get data for row.
		$query = "SELECT * FROM `$source_table` LIMIT $row_num, 1";
		$row   = ns_cloner()->db->get_row( $query, ARRAY_A );

		// Set flag to skip any junk rows which shouldn't/needn't be copied.
		$is_cloner_data = isset( $row['option_name'] ) && preg_match( '/^ns_cloner/', $row['option_name'] );
		$is_transient   = isset( $row['option_name'] ) && preg_match( '/(_transient_rss_|_transient_(timeout_)?feed_)/', $row['option_name'] );
		$is_edit_meta   = isset( $row['meta_key'] ) && preg_match( '/(_edit_lock|_edit_last)/', $row['meta_key'] );
		$do_copy_row    = apply_filters( 'ns_cloner_do_copy_row', ( ! $is_cloner_data && ! $is_transient && ! $is_edit_meta ), $row, $item );
		if ( ! $do_copy_row ) {
			ns_cloner()->log->log( [ "SKIPPING row in *$source_table* because do_copy_row was false:", $row ] );
			return parent::task( $item );
		}

		// Perform replacements.
		$replaced_in_row = 0;
		$search_replace  = ns_cloner_request()->get_search_replace( $source_id, $target_id );
		foreach ( $row as $field => $value ) {
			$replaced_in_column = ns_recursive_search_replace(
				$value,
				$search_replace['search'],
				$search_replace['replace'],
				ns_cloner_request()->get( 'case_sensitive', false )
			);
			$replaced_in_row   += $replaced_in_column;
			$row[ $field ]      = $value;
		}
		if ( $replaced_in_row > 0 ) {
			ns_cloner()->log->log( "PERFORMED *$replaced_in_row* replacements in *$target_table*" );
			ns_cloner()->report->increment_report( '_replacements', $replaced_in_row );
		}

		// Insert new row.
		$row    = apply_filters( 'ns_cloner_insert_values', $row, $target_table );
		$format = apply_filters( 'ns_cloner_insert_format', null, $target_table );
		ns_cloner()->db->insert( $target_table, $row, $format );
		ns_cloner()->log->handle_any_db_errors();

		return parent::task( $item );

	}

}
