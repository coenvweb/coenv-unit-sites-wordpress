<?php get_header(); ?>
<div class="row">
	<?php //coenv_base_section_title($post->ID); ?>
	<?php //if (!is_front_page() && function_exists('bcn_display')): ?>
	<!--<div class="breadcrumbs"><?php //bcn_display(); ?></div>-->
	<?php //endif; ?>
	<div class="small-12 medium-8 columns right main" role="main" id="main-col">
	
	<?php do_action('foundationPress_before_content'); ?>
	<?php dynamic_sidebar("before-content"); ?>
	<?php while (have_posts()) : the_post(); ?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>" class="template-page">
			<?php do_action('foundationPress_page_before_entry_content'); ?>
			<div class="entry-content">

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