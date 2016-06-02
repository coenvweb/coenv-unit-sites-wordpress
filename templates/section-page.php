<?php
/*
Template Name: Section Page
*/
?>
<?php get_header(); ?>
<?php if( !empty( get_field( 'intro_text') ) ) { ?>
<div class="full-intro" id="main-col">
	<div class="row">
		<p><?php the_field( 'intro_text' ); ?></p>
	</div>
</div>
<?php } ?>
<div class="row page-content">

	<div class="columns" role="main">
	
	<?php do_action('foundationPress_before_content'); ?>
	<?php dynamic_sidebar("before-content"); ?>
	<?php while (have_posts()) : the_post(); ?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>" class="template-page">
			<?php do_action('foundationPress_page_before_entry_content'); ?>
			<div class="entry-content">

						<?php get_template_part( 'partials/partial', 'article' ) ?>

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