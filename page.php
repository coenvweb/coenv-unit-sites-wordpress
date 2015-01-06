<?php get_header(); ?>
<?php 
        $banner = coenv_banner();
        $banner_class = $banner ? 'has-banner' : '';
        $banner_class .= ' template-print';
?>
<div class="page-row"
    <?php if ( $banner ) {
            echo 'style="background-image: url(' . $banner['url'] . '); min-height: 200px;">';
            echo '<div class="teal-wedge">';
        }
     ?>
     <?php if (empty($banner)) {
            echo 'style="background-color: #4b2e83;">';
            echo '<div class="teal-wedge">';
     }
     ?>
    <div class="section-row row">
        <?php echo coenv_base_section_title($post->ID); ?>
        <?php 
        $title = get_the_title();
        $shortlink = wp_get_shortlink();
        ?>
        <div class="sharing right">Share
            <a href=<?php echo 'http://twitter.com/home?status=' . $title . ' ' . $shortlink . ' from @SMEAatUW" target="_blank">' ?>
               <i class="fi-social-twitter"></i></a>
            <a href=<?php echo 'http://www.facebook.com/sharer/sharer.php?s=100&p[url]=' . $shortlink . '&p[images][0]=&p[title]=' . $title . ' from UW School of Marine and Environmental Affairs" target="_blank">'; ?>
               <i class="fi-social-facebook"></i></a>
            <a href=<?php echo 'mailto:?subject=' . $title . '&body=Check%20out%20this%20article%20from%20the%20UW%20School%20of%20Marine%20and%20Environmental%20Affairs:%20' . $shortlink . '>'; ?>
         <i class="fi-mail"></i></a>
        </div>
    </div>
    </div>
</div>

<div class="row">
	<?php //coenv_base_section_title($post->ID); ?>
	<?php //if (!is_front_page() && function_exists('bcn_display')): ?>
	<!--<div class="breadcrumbs"><?php //bcn_display(); ?></div>-->
	<?php //endif; ?>
	<div class="small-12 medium-8 columns right main" role="main">
	
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