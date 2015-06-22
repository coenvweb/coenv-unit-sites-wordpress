<?php
/*
Template Name: Homepage
*/
?>
<?php get_header(); ?>
<div class="hero-row row">
	
	<?php do_action('foundationPress_before_content'); ?>
	<?php dynamic_sidebar("before-content"); ?>
		<?php

		/**
		 * Loop for homepage features.
		 */
		$feature_args = array(
			'post_type'	=> 'features',
			'post_status' => 'publish',
			'posts_per_page' => 1,
			);
		$feature_query = new WP_Query( $feature_args ); ?>
		<?php //if ($feature_query->have_posts()) { ?>
		<div class="playpause right"></div>
			<div class="homepage-features">
			<?php
			# The Loop
			while ( $feature_query->have_posts() ) :
				$feature_query->the_post();
			if (get_field('feature_add_links')) {
				$feature_link_type = get_field('feature_link_type');
				$feature_link_type_internal = get_field('feature_link_page');
			}
			if (get_field('feature_color')) {
				$feature_color = get_field('feature_color');
			}
			if (get_field('feature_excerpt')) {
				$feature_excerpt = get_field('feature_excerpt');
			}
			if (get_the_post_thumbnail()) {
				$feature_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail-size', true);
				$feature_caption = get_post(get_post_thumbnail_id());
				$feature_caption = $feature_caption->post_excerpt;
			}
			$rows = get_field('feature_add_links');
			
echo '<div class="feature">';
	echo '<div class="feature-image" style="background-image:url(' . $feature_image[0] . ')">';
echo '</div>';
    echo '<div class="feature-info-container light"></div>';
	echo '<div class="feature-info-container medium-6 small-12 columns">';
		echo '<div class="feature-info" style="background-color:' . $feature_color . '">';
        echo '<p class="feature-image-caption right">' . $feature_caption . '</p>';
			echo '<div class="feature-content">';
				echo '<div class="hero-white"><h2>' . get_the_title() . '</h2></div>';
				echo '<p>' . $feature_excerpt . '</p>';
				if($rows)
					{
						foreach($rows as $row) {
							if($row['feature_link_type'] == 'internal') {
								$link_title =  $row['feature_link_to_a_page_on_this_site'][0]['feature_link_title_internal'];
								$link_url = get_permalink($row['feature_link_to_a_page_on_this_site'][0]['feature_select_page'][0]);
								$link_target = 'self';
								echo '<a class="button white" href="' . $link_url . '" target="_' . $link_target . '">' . $link_title . '</a>';
							} elseif ($row['feature_link_type'] == 'external') {
								$link_title = $row['feature_link_to_an_external_site'][0]['feature_link_title'];
								$link_url = $row['feature_link_to_an_external_site'][0]['feature_link_url'];
								$link_target ='blank';
								echo '<a class="button white" href="' . $link_url . '" target="_' . $link_target . '">' . $link_title . '</a>';
							} 
						}
					}

			echo '</div><!-- .feature-content -->';

		echo '</div><!-- .feature-info -->';

	echo '</div><!-- .feature-info-container -->';

echo '</div><!-- .feature -->';
endwhile;
wp_reset_postdata();
echo '</div>';
?>
    </div>
    <div class="news-events-row row">
<div class="row">
<div class="large-7 columns">
    <div class="small-news">
        <a class="button right" href="/about/news-events"><div class="button-background "><p>Learn More »</p></div></a>
        <a href="/news-and-events"><h4>What's New</h4></a>
<?php
$home_args = array(
	'post_type'	=> 'post',
	'post_status' => 'publish',
	'posts_per_page' => 3,
);
$wp_query = new WP_Query( $home_args );
?>
	<?php if ($wp_query->have_posts()): ?>
	<div class="home-news-small">
		<ul class="list-news-small">
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
		echo '<li class="news-small">';
        echo '<div class="post-meta">';
        echo '<time class="article__time" datetime="' . get_the_date('Y-m-d h:i:s') . '">' . get_the_date('M j, Y') . '</time>';
        // Get categories
        $terms = wp_get_post_terms(get_the_id(), 'category');
        if (!empty($terms)) {
            $terms_arr = array();

            foreach ($terms as &$term) {
                if ($term->slug != 'uncategorized') {
                    $terms_arr[] = '<a href="/about/news-events/?tax=category&amp;term=' . $term->slug . '">' . $term->name . '</a>';
                }
            }
            $terms_str = ' | ' . implode(', ', $terms_arr);

        } else {
            $terms_str = '';
        }
        $terms = "";
        echo $terms_str;
        echo '</div>';
        echo '<a href="' . get_the_permalink() . '"><p>' . get_the_title() . '</p></a></li>';
	endwhile;	
		echo '</ul></div>';
	endif;
?>
</div>
</div>
				
<div class="large-5 columns">
    <div class="events">
    <a class="button right" href="/about/news-events/events"><div class="button-background"><p>Learn More »</p></div></a>
	<h4>Events</h4>
	<?php the_widget('CoEnv_Widget_Events', 'feed_url=http://www.trumba.com/calendars/coenveventscalendar.rss&posts_per_page=3'); ?>
    </div>
</div>
</div>
</div>
            
<div class="row spotlight">
    <div class="spotlight-content">
        <?php the_widget('custom_post_widget', 'custom_post_id=26848&show_featured_image=true'); ?>
    </div>
</div>
        
<div class="row social-row">
    <div class="large-12 columns social-bar">
        <h3>Connect with us »</h3>
        <ul class="social-buttons">
        <?php if (get_option('facebook')) { ?><a href="<?php echo get_option('facebook'); ?>" title="Become a fan of <?php bloginfo('name'); ?> on Facebook" target="_blank" rel="nofollow"><li><i class="fi-social-facebook"> </i></li></a><?php } ?>
        <?php if (get_option('twitter')) { ?><a href="<?php echo get_option('twitter'); ?>" title="Follow <?php bloginfo('name'); ?> on Twitter" target="_blank" rel="nofollow"><li><i class="fi-social-twitter"> </i></li></a><?php } ?>
        <?php if (get_option('youtube')) { ?><a href="<?php echo get_option('youtube'); ?>" title="<?php bloginfo('name'); ?> YouTube Channel" target="_blank" rel="nofollow"><li><i class="fi-social-youtube"> </i></li></a><?php } ?>
        <?php if (get_option('linkedin')) { ?><a href="<?php echo get_option('linkedin'); ?>" title="<?php bloginfo('name'); ?> LinkedIn Group" target="_blank" rel="nofollow"><li><i class="fi-social-linkedin"> </i></li></a><?php } ?>
        <?php if (get_option('email_newsletter')) { ?><li><a href="<?php echo get_option('email_newsletter'); ?>" title="Subscribe to the <?php bloginfo('name'); ?>'s Email Newsletter" target="_blank" rel="nofollow"><i class="fi-at-sign"> </i></a></li><?php } ?>
        <a href="<?php echo (get_option('feeds')) ? get_option('feeds') : get_bloginfo('url').'/feeds'; ?>" title="<?php bloginfo('name'); ?> RSS Feeds"><li><i class="fi-rss"> </i></a></li>
        <?php if (get_option('uw_social')) { ?><a href="<?php echo get_option('uw_social'); ?>" title="<?php bloginfo('name'); ?> on UW Social" target="_blank" rel="nofollow"><li><i class="icon-icon-uw"> </i></li></a><?php } ?>
      </ul>
    </div>
</div>
        
<div class="row major-program">
    <div class="large-12 columns major">
        <?php the_widget('custom_post_widget', 'custom_post_id=2745&show_featured_image=true'); ?>
    </div>
</div>
        
<div class="row minor-programs" data-equalizer data-equalizer-mq="large-up">
    <div class="large-6 columns programs" data-equalizer-watch>
        <?php the_widget('custom_post_widget', 'custom_post_id=2750'); ?>
    </div>
    <div class="large-6 columns programs" data-equalizer-watch>
        <?php the_widget('custom_post_widget', 'custom_post_id=2752'); ?>
</div>
        

<?php do_action('foundationPress_after_content'); ?>
</div>
<?php wp_reset_postdata(); wp_reset_query(); //roll back query vars to as per the request ?>
</div>
</div>
<?php get_footer(); ?>