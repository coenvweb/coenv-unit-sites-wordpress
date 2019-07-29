<?php
/**
 * Cloner Compatibility filters / functions.
 *
 * Location for any plugin-specific fixes, filters, or patches to keep them from cluttering up the main plugin.
 *
 * @package NS_Cloner
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Add known plugins with global tables to the global table list
 */
add_filter(
	'ns_cloner_global_table_patterns',
	function( $global_patterns ) {
		$plugin_patterns = [
			'domain_mapping.*',   // Domain mapping tables.
			'3wp_broadcast_.*',   // 3wp broadcast tables.
			'bp_.*',              // BuddyPress tables.
		];
		return array_merge( $global_patterns, $plugin_patterns );
	}
);

/**
 * Don't drop main slimstat table because it will cause a foreign key error
 * NOTE: this may cause problems in clone over mode - will have to address that down the road if necessary
 */
add_filter(
	'ns_cloner_do_drop_target_table',
	function( $do, $table ) {
		if ( strpos( $table, 'slim_stats' ) !== false ) {
			$do = false;
		}
		return $do;
	},
	10,
	2
);
