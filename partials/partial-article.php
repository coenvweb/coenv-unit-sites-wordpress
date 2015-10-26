<?php  
/**
 * An individual article
 */
?>
<article id="post-<?php the_ID() ?>">

	<div class="row">
		<?php if ( !is_page() ) : ?>
		<div class="columns medium-6 left post-meta">
			<time class="article__time" datetime="<?php echo get_the_date('Y-m-d h:i:s') ?>"><?php echo get_the_date('M j, Y') ?></time> 
			<?php $categories = get_the_category_list(' ') ?>
			<?php if ( $categories ) : ?>
			<div class="article__categories">
				| <?php echo $categories ?>
			</div>
			<?php endif; ?>
		</div>
		<div class="columns medium-6 sharer">
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
<?php endif; ?>
	<div class="row">
		<div class="columns small-12">
			<h1 class="article__title"><?php the_title() ?></h1>
			<section class="article__content">
			<?php the_content(); ?>
			</section>
		</div>
	</div>

    <?php remove_filter( 'the_title', 'wptexturize' );
    remove_filter( 'the_excerpt', 'wptexturize' ); ?>

</article><!-- .article -->