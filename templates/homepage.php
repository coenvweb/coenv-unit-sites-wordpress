<?php
/*
Template Name: Homepage
*/
?>
<?php get_header(); ?>
<div role="main">
	
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
			'orderby' => 'menu_order',
			);
		$feature_query = new WP_Query( $feature_args ); ?>
		<?php //if ($feature_query->have_posts()) { ?>
<div class="hero row">
<div class="small-12 large-12 columns">
		<div class="playpause"></div>
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
			if (get_the_post_thumbnail()) {
				$feature_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail-size', true);
				$feature_caption = get_post(get_post_thumbnail_id());
				$feature_caption = $feature_caption->post_excerpt;
			}
			$rows = get_field('feature_add_links');
			
echo '<div class="feature">';
	echo '<div class="feature-image" style="background-image:url(' . $feature_image[0] . ')">';

		echo '<div class="feature-info-container">';
		echo '<p class="feature-image-caption right">' . $feature_caption . '</p>';
if($rows)
					{
						foreach($rows as $row) {
                    $link_title =  $row['feature_link_to_a_page_on_this_site'][0]['feature_link_title_internal'];
                    $link_url = get_permalink($row['feature_link_to_a_page_on_this_site'][0]['feature_select_page'][0]);
                    $link_target = 'self';
						}
					}
echo '<a href="' . $link_url . '">';
		echo '<div class="feature-info" style="background-color:' . $feature_color . '">';
			echo '<div class="feature-content">';
				echo '<h2 class="feature-title"><span class="feature-white">' . get_the_title() . '</span></h2></a>';
                echo '<a class="button" href="' . $link_url . '">' . $link_title . '</a>';

			echo '</div><!-- .feature-content -->';

		echo '</div><!-- .feature-info -->';

	echo '</div><!-- .feature-info-container -->';
echo '</div>';


echo '</div><!-- .feature -->';
endwhile;
wp_reset_postdata();
?>
        </div>
    </div>
</div>
                
<div class="row about-summary">
    <div class="summary columns large-12">
        <?php the_widget('custom_post_widget', 'custom_post_id=2742&show_featured_image=false'); ?>
    </div>
</div>
                
<div class="row programs">
    <a href="/students/related-majors/" id="Majors in Marine Science" class="program">
    <div class="columns large-6 major">
        <h3>Majors in<br />Marine Science</h3>
    </div></a>
    <a href="/students/marine-biology-minor/" id="Minor in Marine Biology"  class="program">
    <div class="columns large-6 minor">
        <h3>Minor in<br />Marine Biology</h3>
    </div></a>
</div>
                
<div class="row news">
    <div class="medium-12 columns" style="margin-top: 0; padding-top: 0;">
        <a name="More News & Stories" href="/news-stories"><?php include(get_template_directory() . "/assets/img/news-icon.svg"); ?></a>
        <a href="/news-stories/" class="more hide-for-small-only" id="More Events">More News & Stories <?php include(get_template_directory() . "/assets/img/circle-arrow-icon.svg"); ?></a>
            <a name="More News & Stories" href="/news-stories">
            <h2>News & Stories</h2></a>
    </div>
                <div class="news-stories" data-equalizer>
                <?php
# Student/Alumni Spotlight
		
$sticky = get_option( 'sticky_posts' );
$sticky_count = count($sticky);
$posts_on_home = 1; //set posts_per_page here

$home_args = array(
    'post_type' => 'post',
    'posts_per_page' => $posts_on_home - $sticky_count,
    'post_status' => 'publish',
    'cat' => 136,
);

$wp_query = new WP_Query( $home_args );
?>
	<?php if ($wp_query->have_posts()): ?>
		<div class="medium-6 columns">
        <div class="white-container" data-equalizer-watch>
        <a name="More student & alumni stories" class="fake-cat button left" href="/news-stories">Student Spotlights</a>
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
		if (get_field('story_link_url')) {
			$post_link_url = get_field('story_link_url');
			$post_link_target = ' target="_blank" ';
            $post_link = '<p><a class="read-more button" href="' . $post_link_url . '"' . $post_link_target . '>' . get_field('story_source_name') . '</a></p>';
        } else {
        	$post_link_url = get_the_permalink();
            $post_link = '<a class="read-more button" href="' . $post_link_url . '">Read more</a>';
        }
        echo '<div class="featured-thumbnail">';
        echo '<a href="' . $post_link_url . '" class="img"' . $post_link_target . '>';
        the_post_thumbnail( 'large-sq' );
        echo '<h3 class="news-title"><span class="white-title">' . get_the_title() . '</span></h3>';
        echo '</a></div>';
        echo '<span class="excerpt">';
        echo the_advanced_excerpt('length=20&finish=sentence');
        echo '<time class="article__time right" datetime="' . get_the_date('Y-m-d h:i:s') . '">' . get_the_date('M j, Y') . '</time>';
        echo $post_link . '</span>';
	endwhile;
	?>
</div>
</div>
<?php endif; ?>
                
<?php
# Research / Faculty Spotlight
		
$sticky = get_option( 'sticky_posts' );
$sticky_count = count($sticky);
$posts_on_home = 1; //set posts_per_page here

$home_args = array(
    'post_type' => 'post',
    'posts_per_page' => $posts_on_home - $sticky_count,
    'post_status' => 'publish',
    'cat' => 137,
);

$wp_query = new WP_Query( $home_args );
?>
	<?php if ($wp_query->have_posts()): ?>
		<div class="medium-6 columns" style="margin-top: 0; padding-top: 0;">
        <div class="white-container" data-equalizer-watch>
                <a name="More research news" class="fake-cat button left" href="/news-stories">Research News</a>
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
		if (get_field('story_link_url')) {
			$post_link_url = get_field('story_link_url');
			$post_link_target = ' target="_blank" ';
            $post_link = '<p><a class="read-more button" href="' . $post_link_url . '"' . $post_link_target . '>' . get_field('story_source_name') . '</a></p>';
        } else {
        	$post_link_url = get_the_permalink();
            $post_link = '<a class="read-more button" href="' . $post_link_url . '">Read more</a>';
        }
        echo '<div class="featured-thumbnail">';
        echo '<a href="' . $post_link_url . '" class="img"' . $post_link_target . '>';
        the_post_thumbnail( 'large-sq' );
        echo '<h3 class="news-title"><span class="white-title">' . get_the_title() . '</span></h3>';
        echo '</a></div>';
        echo '<span class="excerpt">';
        echo the_advanced_excerpt('length=20&finish=sentence');
        echo '<time class="article__time right" datetime="' . get_the_date('Y-m-d h:i:s') . '">' . get_the_date('M j, Y') . '</time>';
        echo $post_link . '</span>';
	endwhile;
	?>
    </div>
</div>
<?php endif; ?>
</div>
    <div class="special-announcement columns large-12">
        <div class="white-container">
            <h4 class="announcement-title">Announcement</h3>
            <?php the_widget('custom_post_widget', 'custom_post_id=3193'); ?>
        </div>
    </div>
</div>


<div class="row events">
    <a href="/news-stories/events" id="More Events"><?php include(get_template_directory() . "/assets/img/events-icon.svg"); ?></a>
    <a href="/news-stories/events" class="more hide-for-small-only" id="More Events">More Events <?php include(get_template_directory() . "/assets/img/circle-arrow-icon.svg"); ?></a>
    <a href="/news-stories/events" id="More Events"><h2>Events</h2></a>
    <div class="list columns large-12">
        <?php the_widget('CoEnv_Widget_Events', 'feed_url=http://www.trumba.com/calendars/sea_marinebio.rss&posts_per_page=3'); ?>
    </div>      
</div>

<div class="row fhl">
    <div class="columns large-12">
        <?php the_widget('custom_post_widget', 'custom_post_id=3154&show_featured_image=true'); ?>
    </div>      
</div>
    
<div class="row adviser">
    <div class="columns large-12">
        <?php the_widget('custom_post_widget', 'custom_post_id=3151&show_featured_image=true'); ?>
    </div>      
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
</div>
<?php wp_reset_postdata(); wp_reset_query(); //roll back query vars to as per the request ?>
</div>
</div>
<?php get_footer(); ?>