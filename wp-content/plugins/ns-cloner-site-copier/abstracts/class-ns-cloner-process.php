<?php
/**
 * Cloner Background Process base class.
 *
 * @package NS_Cloner
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * NS_Cloner_Process base class.
 *
 * Extends WP_Background_Process with progress-tracking framework to enable individual
 * Cloner child processes to automatically track and report their progress.
 */
abstract class NS_Cloner_Process extends WP_Background_Process {

	/**
	 * Prefix for saved options
	 *
	 * @var string
	 */
	protected $prefix = 'ns_cloner';

	/**
	 * Unique key for the current batch
	 *
	 * @var string
	 */
	protected $batch_key = '';

	/**
	 * Unique value for transient lock to differentiate dispatches/instances
	 *
	 * @var string
	 */
	protected $lock_id = '';

	/**
	 * Number of completed tasks in the current session
	 *
	 * @var int
	 */
	protected $task_count = 0;

	/**
	 * User friendly label for what type of object this process handles
	 *
	 * @var string
	 */
	public $report_label = '';

	/**
	 * Save queue
	 *
	 * @return $this
	 */
	public function save() {
		$this->batch_key = $this->generate_key();
		if ( ! empty( $this->data ) ) {
			// Save the batch/queue items themselves.
			update_site_option( $this->batch_key, $this->data );
			ns_cloner()->log->log( "SAVING batch for $this->identifier with " . count( $this->data ) . ' items.' );
			// Save progress data for this batch.
			// If we want to have an item whose progress is not tracked, we can add 'ignore_progress' to it.
			// Only items without an ignore_progress key will affect the total and completed progress values.
			$tracked_items = array_filter(
				$this->data,
				function( $item ) {
					return ! isset( $item['ignore_progress'] );
				}
			);
			$this->update_batch_progress(
				$this->batch_key,
				[
					'total'     => count( $tracked_items ),
					'completed' => 0,
				]
			);
			// Clear the data in case this process is reused on the same request for another batch.
			$this->data = [];
		}
		return $this;
	}

	/**
	 * Dispatch process
	 *
	 * Modify this to immediately run complete if the queue is empty,
	 * so that other dependent background processes can begin.
	 */
	public function dispatch() {
		if ( $this->is_queue_empty() ) {
			$this->complete();
		} else {
			parent::dispatch();
		}
		return $this;
	}

	/**
	 * Lock process
	 *
	 * Add delay to locking to prevent race conditions
	 */
	protected function lock_process() {
		$this->start_time = time(); // Set start time of current process.
		$this->lock_id    = wp_generate_password();

		$lock_duration = ( property_exists( $this, 'queue_lock_time' ) ) ? $this->queue_lock_time : 60; // 1 minute
		$lock_duration = apply_filters( $this->identifier . '_queue_lock_time', $lock_duration );
		$lock_delay    = apply_filters( 'ns_cloner_process_delay', 1 );
		$lock_key      = $this->identifier . '_process_lock';

		// Set lock, then wait 1 second to make sure a simultaneous lock hasn't been set.
		// Query DB directly because cache won't know if another instance overwrote the lock.
		set_site_transient( $lock_key, $this->lock_id, $lock_duration );
		ns_cloner()->log->log( "LOCKING *$this->identifier* instance $this->lock_id" );
		sleep( $lock_delay );
		$table        = is_multisite() ? ns_cloner()->db->sitemeta : ns_cloner()->db->options;
		$key_column   = is_multisite() ? 'meta_key' : 'option_name';
		$val_column   = is_multisite() ? 'meta_value' : 'option_value';
		$current_lock = ns_cloner()->db->get_var(
			ns_cloner()->db->prepare(
				"SELECT {$val_column} FROM {$table} WHERE {$key_column} = %s",
				'_site_transient_' . $lock_key
			)
		);
		ns_cloner()->log->log( "CHECKING for lock on $this->lock_id. Current lock: $current_lock" );

		// If the set lock isn't from this (earlier) instance, bail and let the later instance take over.
		if ( $current_lock !== $this->lock_id ) {
			ns_cloner()->log->log( "DETECTED simultaneous *$this->identifier* - ending" );
			exit;
		}
	}

	/**
	 * Unlock process
	 *
	 * Unlock the process so that other instances can spawn.
	 * Modified to include after_handle() - see that function for details.
	 *
	 * @return $this
	 */
	protected function unlock_process() {
		$this->after_handle();
		parent::unlock_process();
		return $this;
	}

	/**
	 * Handle
	 *
	 * Pass each queue item to the task handler, while remaining
	 * within server memory and time limit constraints.
	 */
	protected function handle() {
		// Initialize sections because this is what all the section hooks get set up on.
		ns_cloner()->process_manager->doing_cloning();
		ns_cloner()->log->log_break();
		ns_cloner()->log->log( "HANDLING <b>$this->action</b> async request" );
		// Pass back to parent for handling.
		parent::handle();
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
		// If we want to have an item whose progress is not tracked, we can add 'ignore_progress' to it.
		// Only items without an ignore_progress key will affect the total and completed progress values.
		if ( ! isset( $item['ignore_progress'] ) ) {
			$this->task_count++;
		}
		// Update task count only if it's above threshold. Update too often and you lose performance,
		// update too seldom and you lose responsiveness in the progress UI.
		if ( $this->task_count >= 5 ) {
			$progress = $this->get_batch_progress( $this->batch_key );
			$this->update_batch_progress(
				$this->batch_key,
				[ 'completed' => $progress['completed'] + $this->task_count ]
			);
			$this->task_count = 0;
		}
		return false;
	}

	/**
	 * Run actions after completing a set of tasks.
	 *
	 * This is so we have a way to do a complete-type action that runs not just at the veru end but after each
	 * session of the process (i.e. after resources limits are reached and it's going to dispatch a new
	 * version of itself). That's useful for submitting remote requests, saving progress, anything that
	 * needs current state of cross-task variables.
	 */
	protected function after_handle(){
		$progress = $this->get_batch_progress( $this->batch_key );
		$this->update_batch_progress(
			$this->batch_key,
			[ 'completed' => $progress['completed'] + $this->task_count ]
		);
	}

	/**
	 * Complete.
	 *
	 * Override if applicable, but ensure that the below actions are
	 * performed, or, call parent::complete().
	 */
	protected function complete() {
		parent::complete();
		// Add action so that dependent processes can start.
		do_action( $this->identifier . '_complete' );
		// Check if this was the last process to complete, and the operation can be finished.
		ns_cloner()->process_manager->maybe_finish();
	}

	/**
	 * Cancel
	 *
	 * Different from cancel_process in parent. This removes ALL batches,
	 * not just the top one, and it removes saved progress for batches that
	 * have been completed (thus should be called after progress data is no
	 * longer needed - i.e. reporting has already been made). It also clears
	 * any scheduled cron health check in the future.
	 */
	public function cancel() {
		$table  = is_multisite() ? ns_cloner()->db->sitemeta : ns_cloner()->db->options;
		$column = is_multisite() ? 'meta_key' : 'option_name';
		ns_cloner()->db->query( "DELETE FROM {$table} WHERE {$column} LIKE '{$this->identifier}_%'" );
		wp_clear_scheduled_hook( $this->cron_hook_identifier );
		ns_cloner()->log->log( "ENDING $this->action background process and clearing data." );
	}

	/**
	 * Is queue empty
	 *
	 * Change this from protected in the parent to public visibility here
	 *
	 * @return bool
	 */
	public function is_queue_empty() {
		return parent::is_queue_empty();
	}

	/**
	 * Is process running
	 *
	 * Change this from protected in the parent to public visibility here
	 *
	 * @return bool
	 */
	public function is_process_running() {
		return parent::is_process_running();
	}

	/**
	 * Get the next batch for this process, and save the unique batch key to reference progress
	 *
	 * @return stdClass
	 */
	public function get_batch() {
		$batch           = parent::get_batch();
		$this->batch_key = $batch->key;
		return $batch;
	}

	/**
	 * Get progress of all existing background process batches.
	 *
	 * Query for progress rows, not the batch data entries themselves, because the batch
	 * data will be deleted by handle() once the batch is complete, but the batch
	 * progress will remain saved for reference until it is cleared with cancel().
	 *
	 * Note that the result uses the batch key, but the value is the value of the
	 * progress record. Essentially this takes the two records that get saved for
	 * every batch - one to store the data and one to store the completion progress
	 * of that batch - and combines them with they key of one and that value of the
	 * other, so the data could easily be retrieved using the batch key (if it hasn't
	 * been completed and deleted yet), but the more often used progress data is the
	 * the easiest to access (provided right in the returned result).
	 *
	 * @return array
	 */
	private function get_batches() {
		$batches    = [];
		$table      = is_multisite() ? ns_cloner()->db->sitemeta : ns_cloner()->db->options;
		$column     = is_multisite() ? 'meta_key' : 'option_name';
		$key_column = is_multisite() ? 'meta_id' : 'option_id';
		$val_column = is_multisite() ? 'meta_value' : 'option_value';
		// Get all progress records for this bg process.
		$progress_rows = ns_cloner()->db->get_results(
			"SELECT {$column} as 'key', {$val_column} as 'value'
				FROM {$table}
				WHERE {$column} LIKE '{$this->identifier}_progress_%'
				ORDER BY {$key_column} ASC"
		);
		foreach ( $progress_rows as $row ) {
			$batch_key = str_replace( 'progress', 'batch', $row->key );
			$progress  = json_decode( $row->value, true );
			// Add to results - keyed by the *batch key* but the value is the *progress value*.
			$batches[ $batch_key ] = $progress;
		}
		return $batches;
	}

	/**
	 * Update information about this process' current progress
	 *
	 * @param string $batch_key Unique key of batch to get progress for.
	 * @param array  $data Progress data to update.
	 */
	public function update_batch_progress( $batch_key, $data ) {
		$progress_key = str_replace( 'batch', 'progress', $batch_key );
		if ( empty( $data ) ) {
			// Delete the progress it if was set to a blank value.
			delete_site_option( $progress_key );
			ns_cloner()->log->log( "DELETING progress for <b>$batch_key</b>" );
		} else {
			// Otherwise, update progress with the provided values.
			$progress     = $this->get_batch_progress( $batch_key );
			$new_progress = wp_json_encode( array_merge( $progress, $data ) );
			update_site_option( $progress_key, $new_progress );
			ns_cloner()->log->log( [ 'UPDATING ' . $progress_key, $new_progress ] );
		}
	}

	/**
	 * Get information about this process' current progress
	 *
	 * @param string $batch_key Unique key of batch to get progress for.
	 * @return array|mixed
	 */
	public function get_batch_progress( $batch_key ) {
		$progress_key = str_replace( 'batch', 'progress', $batch_key );
		$progress     = json_decode( get_site_option( $progress_key ), true );
		if ( ! is_array( $progress ) ) {
			$progress = [
				'total'     => 0,
				'completed' => 0,
			];
		}
		return $progress;
	}

	/**
	 * Get total progress of all batches, not just the current one
	 *
	 * @return array|mixed
	 */
	public function get_total_progress() {
		$progress = [
			'completed' => 0,
			'total'     => 0,
		];
		// Loop through each batch and aggregate progress data.
		foreach ( $this->get_batches() as $batch_key => $batch_progress ) {
			// Add item counts together.
			$progress['completed'] += $batch_progress['completed'];
			$progress['total']     += $batch_progress['total'];
		}
		return $progress;
	}

}

