<?php
/*
Template Name: Events Index
*/
if($_SERVER['HTTPS']) {
	$coenv_protocol = 'https';
} else {
	$coenv_protocol = 'http';
}
get_header(); 
?>
<div class="row page-content">
	<div class="columns" role="main">
	<?php do_action('foundationPress_before_content'); ?>
	<?php dynamic_sidebar("before-content"); ?>
	<?php while (have_posts()) : the_post(); ?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>" class="template-page">
			<div class="entry-content">
				<div role="region" aria-labelledby="calendar_display_view_selector"><script type="text/javascript" src="<?php echo $coenv_protocol; ?>://www.trumba.com/scripts/spuds.js"></script>
				<script type="text/javascript">// <![CDATA[
				$Trumba.addSpud({
				webName: "sea_fish",
				spudType : "chooser" });
				// ]]></script>
				</div>
				<div role="region" aria-labelledby="main_calendar_view">
				<script type="text/javascript">// <![CDATA[
				$Trumba.addSpud({
				webName: "sea_fish",
				spudType : "main" });
				// ]]></script>
				</div>
				<noscript>Your browser must support JavaScript to view this content. Please enable JavaScript in your browser settings then try again.</noscript>
				<p>To suggest additions to this calendar, email <a href="mailto:<?php echo antispambot('safsdesk@uw.edu')?>"><?php echo antispambot('safsdesk@uw.edu')?></a>.</p>
			</div>
			<footer>
				<?php wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'FoundationPress'), 'after' => '</p></nav>' )); ?>
				<p><?php the_tags(); ?></p>
			</footer>
		</article>
	<?php endwhile;?>
	<?php if ( is_active_sidebar( 'after-content' ) ) : ?>
		<div id="after-content" class="before-content widget-area" role="complementary">
			<?php dynamic_sidebar( 'after-content' ); ?>
		</div><!-- #after-content -->
	<?php endif; ?>
	<a href="#" class="back-to-top">Back to Top</a>
	<?php do_action('foundationPress_before_content'); ?>
	</div>
	<aside id="sidebar" class="columns show-for-medium-up">
	<?php
	if (!is_front_page()) {
		echo '<div class="coenv_base_subnav">';
		//if ($GLOBALS['post']->post_parent) {
		echo '<div class="section-title">';
		echo coenv_base_section_title($GLOBALS['post']->ID);
		echo '</div>';
		//}
		echo coenv_base_hierarchical_submenu($GLOBALS['post']->ID);
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
</div>
<?php get_footer(); ?>
