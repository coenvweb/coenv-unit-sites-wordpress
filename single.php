<?php get_header(); ?>
<div class="row">
	<div class="small-12 medium-8 columns right" role="main">
	
	<?php do_action('foundationPress_before_content'); ?>
			<?php do_action('foundationPress_post_before_entry_content'); ?>
			<div class="entry-content">
			<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post() ?>
                
                        <article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>

                            <header class="article__header">
                                <div class="article__meta">                                    
                                    <?php if ( !is_page() ) : ?>
                                    <div class="post-info">
                                        <time class="article__time" datetime="<?php echo get_the_date('Y-m-d h:i:s') ?>"><?php echo get_the_date('M j, Y') ?></time> 
                                        <?php $categories = get_the_category_list(' ') ?>
                                        <?php if ( $categories ) : ?>
                                        <div class="article__categories">
                                            | <?php echo $categories ?>
                                        </div>
                                    </div>
                                    <?php endif ?> 
                                </div>
                                <?php endif ?>
                                <?php if ($GLOBALS['post']->post_parent) : ?>
                                <?php if ( is_page() || is_single()) : ?>
                                    <h1 class="article__title"><?php the_title() ?></h1>
                                <?php else : ?>
                                    <h1 class="article__title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h1>
                                <?php endif ?>
                                <?php endif ?>

                            </header>

                            <section class="article__content">
                                <?php the_content() ?>
                            </section>
                            <?php remove_filter( 'the_title', 'wptexturize' );
                            remove_filter( 'the_excerpt', 'wptexturize' ); ?>

                        </article><!-- .article -->

					<?php endwhile ?>
					<?php if ( get_field('story_link_url') ) : echo '<p><a class="button" href="' . get_field('story_link_url') . '" target="_blank">' . get_field('story_source_name') . '</a></p>'; endif; ?>

			<?php endif ?>
			</div>
			<?php if ( is_active_sidebar( 'after-content' ) ) : ?>
				<div id="after-content" class="after-content widget-area" role="complementary">
					<?php dynamic_sidebar( 'after-content' ); ?>
				</div><!-- #after-content -->
			<?php endif; ?>
			<footer>
				<?php wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'FoundationPress'), 'after' => '</p></nav>' )); ?>
				<p><?php the_tags(); ?></p>
			</footer>
			<?php do_action('foundationPress_post_before_comments'); ?>
			<?php comments_template(); ?>
			<?php do_action('foundationPress_post_after_comments'); ?>
		</article>
	<?php do_action('foundationPress_after_content'); ?>

	</div>
	<?php get_sidebar(); ?>
</div>	
<?php get_footer(); ?>