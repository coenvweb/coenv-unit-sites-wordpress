<?php
/**
 * The sidebar template
 *
 * Serves up sidebar widgets for individual top level pages
 */
?>
<aside id="sidebar" class="small-12 medium-pull-8 large-pull-9 medium-4 large-3 columns">
<?php
$menu_id = $GLOBALS['post']->ID;    
if (is_singular('courses')) {
    $menu_id = 3473;
}
if (!is_front_page()) {
	echo '<div class="coenv_base_subnav show-for-medium-up">';
		/*if ($GLOBALS['post']->post_parent) {
			echo coenv_base_section_title($GLOBALS['post']->ID);
		}*/
        echo coenv_base_section_title($GLOBALS['post']->ID);
		echo coenv_base_hierarchical_submenu($menu_id);
	echo '</div>';
}
?>
<?php dynamic_sidebar('sidebar-widgets'); ?>
<?php
$ancestor_id = coenv_base_get_ancestor('ID');

if (!function_exists('dynamic_sidebar') || !dynamic_sidebar( $ancestor_id )):

	dynamic_sidebar( $ancestor_id );
endif;
?>
</aside>
