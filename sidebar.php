<!--
	<?php //do_action('foundationPress_before_sidebar'); ?>
	<?php //dynamic_sidebar("sidebar-widgets"); ?>
	<?php //do_action('foundationPress_after_sidebar'); ?>
</aside>-->
<?php  
/**
 * The sidebar template
 *
 * Serves up sidebar widgets for individual top level pages
 */
?>
<aside id="sidebar" class="small-12 medium-3 columns">
<?php dynamic_sidebar('sidebar-widgets'); ?>
<?php
$ancestor_id = coenv_base_get_ancestor('ID');
if (!function_exists('dynamic_sidebar') || !dynamic_sidebar( $ancestor_id )):

	dynamic_sidebar( $ancestor_id );
endif;
?>
</aside>