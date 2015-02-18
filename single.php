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
                                <div class="blog-meta clearfix">
                                    <div class="small-6 columns left">
                                        <p><time class="article__time" datetime="<?php echo get_the_date('Y-m-d h:i:s') ?>"><?php echo get_the_date('M j, Y') ?></time> 
                                        <?php $terms = wp_get_post_terms( get_the_ID(), 'category'); ?>
                                        <?php if ( $terms ) : ?>
                                            | <?php 
                                                foreach ($terms as $term) {
                                                    $termlist .= '<a href="' . get_permalink( '2966' ) . '?tax='. $term->taxonomy . '&term=' . $term->slug . '">' . $term->name . '</a>, ';
                                                };
                                            $termlist = rtrim($termlist,', ');
                                            echo $termlist; ?>
                                        </p>
                                        <?php endif ?> 
                                    </div>
                                    <div class="small-6 columns sharer right">
                                        <?php $title = rawurlencode(get_the_title());
                                        $shortlink = rawurlencode(wp_get_shortlink());
                                        $site_name = rawurlencode(get_bloginfo('name'));
                                        $twitter = get_option('twitter');
                                        ?>
                                        <a href=<?php echo 'http://twitter.com/home?status=' . $title . '%20' . $shortlink . '%20from%20' . $twitter . ' target="_blank">' ?>
                                        <?php get_template_part('assets/img/icons/inline', 'twitter-circle.svg'); ?></a>
                                        <a href=<?php echo 'http://www.facebook.com/sharer/sharer.php?s=100&p[url]=' . $shortlink . '&p[images][0]=&p[title]=' . $title . '%20from%20' . $site_name .'" target="_blank">'; ?>
                                        <?php get_template_part('assets/img/icons/inline', 'facebook-circle.svg'); ?></a>
                                        <a href=<?php echo 'mailto:?subject=' . $title . '&body=Check%20out%20this%20article%20from%20the%20' . $site_name .':%20' . $shortlink . '>'; ?>
                                        <?php get_template_part('assets/img/icons/inline', 'email-circle.svg'); ?></a>
                                    </div>
                                </div>
                                <?php endif ?>
                                </div>
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