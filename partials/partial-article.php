<?php  
/**
 * An individual article
 */
?>
<article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>

	<header class="article__header">
        <div class="article__meta">
            <?php if ( !is_page() ) : ?>
			<div class="post-info">
				<time class="article__time" datetime="<?php echo get_the_date('Y-m-d h:i:s') ?>"><?php echo get_the_date('M j, Y') ?></time> 
				<?php $categories = get_the_category_list(' ') ?>
				<?php if ( $categories ) : ?>
				<div class="article__categories">
				<?php
                $terms = wp_get_post_terms( get_the_ID(), 'category');
                foreach ($terms as $term) {
                    $termlist = '<a href="./news-stories/?tax='. $term->taxonomy . '&term=' . $term->slug . '">' . $term->name . '</a>, ';
                }
                $termlist = rtrim($termlist,', ');
                if (strpos($termlist,'uncategorized') == false)  {
                    echo '  | ' . $termlist;
                }
                ?>
				</div>
                <div class="blog-meta clearfix sharer small-6 columns right">
                    <?php $title = rawurlencode(get_the_title());
                    $shortlink = rawurlencode(wp_get_shortlink());
                    $site_name = rawurlencode(get_bloginfo('name'));
                    $twitter = get_option('twitter');
                    ?>
                    <a href=<?php echo 'http://twitter.com/home?status=' . $title . '%20' . $shortlink . '%20from%20' . $twitter . ' target="_blank">' ?>
                    <?php get_template_part('assets/img/icons/inline', 'twitter-circle.svg'); ?></a>
                    <a href=<?php echo 'http://www.facebook.com/sharer/sharer.php?s=100&p[url]=' . $shortlink . '&p[images][0]=&p[title]=' . $title . '%20from%20' . $site_name .'" target="_blank">'; ?>
                    <?php get_template_part('assets/img/icons/inline', 'facebook-circle.svg'); ?></a>
                    <a href=<?php echo 'mailto:?subject=' . $title . '&body=Check%20out%20this%20article%20from%20UW%20' . $site_name .':%20' . $shortlink . '>'; ?>
                    <?php get_template_part('assets/img/icons/inline', 'email-circle.svg'); ?></a>
                    </div>
			</div>
 			<?php endif ?> 
        </div>
		<?php endif ?>
		<?php if ( is_single()) : ?>
			<h1 class="article__title"><?php the_title() ?></h1>
		<?php endif ?>

	</header>

	<section class="article__content">
		<?php the_content() ?>
	</section>
    <?php remove_filter( 'the_title', 'wptexturize' );
    remove_filter( 'the_excerpt', 'wptexturize' ); ?>

</article><!-- .article -->
