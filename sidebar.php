<?php  
/**
 * The sidebar template
 *
 * Serves up sidebar widgets for individual top level pages
 */
?>
<aside id="sidebar" class="small-12 medium-4 columns">
<?php dynamic_sidebar('sidebar-widgets'); ?>
<?php
$ancestor_id = coenv_base_get_ancestor('ID');
if (!function_exists('dynamic_sidebar') || !dynamic_sidebar( $ancestor_id )):

	dynamic_sidebar( $ancestor_id );
endif;
?>
</aside>