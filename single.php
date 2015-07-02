<?php get_header(); ?>
<div class="row">
	<div class="small-12 medium-8 columns right" role="main" id="main-col">
	
	<?php do_action('foundationPress_before_content'); ?>
			<?php do_action('foundationPress_post_before_entry_content'); ?>
			<div class="entry-content">
			<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post() ?>

						<?php get_template_part( 'partials/partial', 'article' ) ?>

					<?php endwhile ?>
					<?php if ( get_field('story_link_url') ) : echo '<p><a class="button" href="' . get_field('story_link_url') . '" target="_blank">' . get_field('story_source_name') . '</a></p>'; endif; ?>

			<?php endif ?>
        </div>
		</article>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php if ( is_active_sidebar( 'after-content' ) ) : ?>
<div class="row after-widget">
    <div id="after-content" class="after-content widget-area" role="complementary">
        <?php dynamic_sidebar( 'after-content' ); ?>
    </div><!-- #after-content -->
</div>
<?php endif; ?>
<?php get_footer(); ?>