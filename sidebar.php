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
<aside id="sidebar" class="small-12 medium-4 large-3 left columns">
<?php
if (!is_front_page()) {
	echo '<div class="coenv_base_subnav">';
        if (is_singular('faculty')) {
            $ancestor_post = 3013;
            echo '<div class="section-title"><a href="/faculty-research">Faculty &amp; Research</a></div>';
            echo coenv_base_hierarchical_submenu($ancestor_post);
        }
        if ((!is_singular('post')) && (!is_page_template( 'templates/news.php' )) && (!is_singular('faculty'))) {
            echo coenv_base_section_title($id);
            echo coenv_base_hierarchical_submenu($GLOBALS['post']->ID);
        }
	echo '</div>';
}
?>
<?php dynamic_sidebar('sidebar-widgets'); ?>
<?php
$ancestor_id = coenv_base_get_ancestor('ID');
if (is_singular('post')){
    dynamic_sidebar( 3179 );
}
if (is_singular('faculty')){
    
}
if (!function_exists('dynamic_sidebar') || !dynamic_sidebar( $ancestor_id )):

	dynamic_sidebar( $ancestor_id );
endif;
?>
</aside>