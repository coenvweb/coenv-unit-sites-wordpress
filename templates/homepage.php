<?php
/*
Template Name: Homepage
*/
?>
<?php get_header(); ?>
<div class="row">
	<div class="small-12 large-12 columns" role="main">
	
	<?php do_action('foundationPress_before_content'); ?>
	<?php dynamic_sidebar("before-content"); ?>
		<?php

		/**
		 * Loop for homepage features.
		 */
		$feature_args = array(
			'post_type'	=> 'features',
			'post_status' => 'publish',
			'posts_per_page' => 4,
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
	echo '<div class="feature-info-container">';
		echo '<p class="feature-image-caption right">' . $feature_caption . '</p>';
		echo '<div class="feature-info" style="background-color:' . $feature_color . '">';
			echo '<div class="feature-content">';
				echo '<h2>' . get_the_title() . '</h2>';
				echo '<p>' . $feature_excerpt . '</p>';
				if($rows)
					{
						foreach($rows as $row) {
							if($row['feature_link_type'] == 'internal') {
								$link_title =  $row['feature_link_to_a_page_on_this_site'][0]['feature_link_title_internal'];
								$link_url = get_permalink($row['feature_link_to_a_page_on_this_site'][0]['feature_select_page'][0]);
								$link_target = 'self';
								echo '<a class="button" href="' . $link_url . '" target="_' . $link_target . '">' . $link_title . '</a>';
							} elseif ($row['feature_link_type'] == 'external') {
								$link_title = $row['feature_link_to_an_external_site'][0]['feature_link_title'];
								$link_url = $row['feature_link_to_an_external_site'][0]['feature_link_url'];
								$link_target ='blank';
								echo '<a class="button" href="' . $link_url . '" target="_' . $link_target . '">' . $link_title . '</a>';
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
            
<div class="large-12 columns programs">
	<?php the_widget('custom_post_widget', 'custom_post_id=2742'); ?>
</div>
<div class="large-12 columns programs">
	<?php the_widget('custom_post_widget', 'custom_post_id=2745'); ?>
</div>
<div class="large-12 columns programs">
	<?php the_widget('custom_post_widget', 'custom_post_id=2750'); ?>
</div>
<div class="large-12 columns programs">
	<?php the_widget('custom_post_widget', 'custom_post_id=2752'); ?>
</div>
	
                <?php
		
$home_args = array(
	'post_type'	=> 'post',
	'post_status' => 'publish',
	'posts_per_page' => 3,
);
$wp_query = new WP_Query( $home_args );
?>
	<?php if ($wp_query->have_posts()): ?>
	<hr />
	<div class="home-news-section clearfix">
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
		if ( $wp_query->current_post == 0 ) {
		echo '<div class="large-8 columns featured-news">';
			if ( has_post_thumbnail()) {
				echo '<div class="featured-thumbnail">';
				echo '<a href="' . get_the_permalink() . '" class="img">';
				the_post_thumbnail( 'large' );
				echo '</a></div>';
			}
		echo '<a class="button right show-for-medium-up" href="' . get_the_permalink() . '">More</a>';
		echo '<a href="' . get_the_permalink() . '"><h4>' . get_the_title() . '</h4></a>';
		echo '<div class="post-meta">';
			echo '<time class="article__time" datetime="' . get_the_date('Y-m-d h:i:s') . '">' . get_the_date('M j, Y') . '</time>';
			$categories = get_the_category_list(', ');
				if ( $categories ) {
					echo ' / ' . $categories;
				}
		echo '</div>';
		echo '<p>' . the_advanced_excerpt('length=60&finish=sentence') . '</p>';
		}

		else {
			
		echo '<div class="large-4 columns small-news">';
		echo '<div class="post-meta">';
			echo '<time class="article__time" datetime="' . get_the_date('Y-m-d h:i:s') . '">' . get_the_date('M j, Y') . '</time>';
			$categories = get_the_category_list(', ');
				if ( $categories ) {
					echo ' / ' . $categories;
				}
		echo '</div>';
		echo '<a href="' . get_the_permalink() . '"><h5>' . get_the_title() . '</h5></a>';
		echo '<p>' . the_advanced_excerpt('length=30&finish=sentence') . '</p>';
		}
	echo '</div>';
	endwhile;
	?>
<?php endif; ?>
		<div class="large-4 columns right"><a class="button" href="/news-and-events">More News</a></div>
        
<hr />
<div class="large-4 columns small-news">
<a class="button right" href="/news-and-events">More</a>
	<a href="/news-and-events"><h4>News</h4></a>
<?php
$home_args = array(
	'post_type'	=> 'post',
	'post_status' => 'publish',
	'posts_per_page' => 3,
);
$wp_query = new WP_Query( $home_args );
?>
	<?php if ($wp_query->have_posts()): ?>
	<div class="home-news-small clearfix">
		<ul class="list-news-small">
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
		echo '<li class="news-small"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
	endwhile;	
		echo '</ul></div>';
	endif;
?>
</div>
				
<div class="large-4 columns events">
	<a class="button right" href="/news-and-events/calendar">More</a>
	<h4>Events</h4>
	<?php the_widget('CoEnv_Widget_Events', 'feed_url=http://www.trumba.com/calendars/coenveventscalendar.rss&posts_per_page=3'); ?>
</div>
<div class="large-4 columns events">
	<a class="button right" href="/alumni-and-community">More</a>
	<h4>Get Connected</h4>
	<?php the_widget('CoEnv_Widget_Social'); ?>
</div>
<?php if ( is_active_sidebar( 'after-content' ) ) : ?>
	<?php do_action('foundationPress_after_content'); ?>
	<ul class="widget-area after-content">
	<?php dynamic_sidebar("after-content"); ?>
	</ul>
<?php endif; ?>
<a href="#" class="back-to-top">Back to Top</a>
<?php do_action('foundationPress_after_content'); ?>
</div>
<?php wp_reset_postdata(); wp_reset_query(); //roll back query vars to as per the request ?>
</div>
<?php get_footer(); ?>