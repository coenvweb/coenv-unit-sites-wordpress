<?php get_header(); ?>
<div class="row">
	<?php //coenv_base_section_title($post->ID); ?>
	<?php //if (!is_front_page() && function_exists('bcn_display')): ?>
	<!--<div class="breadcrumbs"><?php //bcn_display(); ?></div>-->
	<?php //endif; ?>
	<div class="small-12 medium-8 columns" role="main">
	
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
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>