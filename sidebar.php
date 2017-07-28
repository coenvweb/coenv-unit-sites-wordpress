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
<?php
if (!is_front_page()) {
	echo '<div class="coenv_base_subnav">';
    if (is_singular('post')) {
        $ancestor = coenv_base_section_title(28);
        echo coenv_base_hierarchical_submenu(3823);
    } elseif (is_singular('pi')) {
        $ancestor = coenv_base_section_title(3831);
        echo coenv_base_hierarchical_submenu(3857);
    } elseif (is_singular('researchers')) {
        $ancestor = coenv_base_section_title(3041);
        echo coenv_base_hierarchical_submenu(3041);
    } else {
        $ancestor = coenv_base_section_title($GLOBALS['post']->ID);
		echo coenv_base_hierarchical_submenu($GLOBALS['post']->ID);
    }
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