<?php get_header(); ?>
<div class="row">
	<div class="small-12 medium-push-4 large-push-3 medium-8 large-9 columns" role="main" id="main-col">
	    <?php do_action('foundationPress_before_content'); ?>
			<div class="entry-content">
			    <?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post() ?>
						<?php get_template_part( 'partials/partial', 'article' ) ?>
					<?php endwhile ?>
					<?php if ( get_field('story_link_url') ) : 
                        echo '<p><a class="button" href="' . get_field('story_link_url') . '" target="_blank">' . get_field('story_source_name') . '</a></p>'; 
                    endif; ?>
			    <?php endif ?>
			</div>
			<?php if ( is_active_sidebar( 'after-content' ) ) : ?>
				<div id="after-content" class="after-content widget-area" role="complementary">
					<?php dynamic_sidebar( 'after-content' ); ?>
				</div><!-- #after-content -->
			<?php endif; ?>
		</article>
	    <?php do_action('foundationPress_after_content'); ?>
	</div>
	<?php get_sidebar(); ?>
</div>	
<?php get_footer(); ?>
