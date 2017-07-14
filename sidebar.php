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
<aside id="sidebar" class="small-12 medium-4 large-3 columns left">
<?php
if (!is_front_page()) {
	echo '<div class="coenv_base_subnav">';
        if ((!is_single()) && (!is_page_template( 'templates/news.php' ) )) {
            $ancestor_post = $GLOBALS['post']->ID;
        }elseif ((is_singular('faculty')) ) {
            $ancestor_post = 24463;
        }else {
            $ancestor_post = 24459;
        }
        echo coenv_base_section_title($ancestor_post);
		echo coenv_base_hierarchical_submenu($ancestor_post);
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