<?php get_header(); ?>
<div class="row">
	<?php //coenv_base_section_title($post->ID); ?>
	<?php //if (!is_front_page() && function_exists('bcn_display')): ?>
	<!--<div class="breadcrumbs"><?php //bcn_display(); ?></div>-->
	<?php //endif; ?>
	<div class="small-12 medium-8 columns right" role="main">
	<h1 class="small-page-title show-for-small-only"><?php the_title(); ?></h1>
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
	<?php do_action('foundationPress_before_content'); ?>

	</div>
	<?php get_sidebar(); ?>
</div>
</div>
<?php if ( is_active_sidebar( 'after-content' ) ) : ?>
<div class="row after-widget">
    <div id="after-content" class="after-content widget-area" role="complementary">
        <?php dynamic_sidebar( 'after-content' ); ?>
    </div><!-- #after-content -->
</div>
<?php endif; ?>
<?php get_footer(); ?>