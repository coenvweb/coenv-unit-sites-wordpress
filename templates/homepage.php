<?php
/*
Template Name: Homepage
*/
?>
<?php get_header(); ?>
<div class="row">
	<div class="small-12 large-12 columns" role="main" id="main-col">
	
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
			'orderby' => 'menu_order',
			);
		$feature_query = new WP_Query( $feature_args ); ?>
		<?php //if ($feature_query->have_posts()) { ?>
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
			
echo '<div class="feature large-12 columns">';
    echo '<div class="feature-image" style="background-image:url('.$feature_image[0].')">';
    echo '</div>';
		
    echo '<div class="feature-info-container">';
		echo '<div class="feature-info" style="background-color:' . $feature_color . '">';
			echo '<div class="feature-content">';
				echo '<h2>' . get_the_title() . '</h2>';
				echo '<p class="feature-excerpt">' . $feature_excerpt . '</p>';
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
<hr />
<?php
/*
    Journal Info from Options Page
*/

$journal_desc = get_field('journal_description', 'option');
$journal_date = get_field('journal_date', 'option');
$journal_volume = get_field('journal_volume', 'option');
$journal_issue = get_field('journal_issue', 'option');
$journal_cover = get_field('journal_cover', 'option');
$journal_link = get_field('latest_issue_link', 'option');

?>
    <div class="large-6 columns home-journal">
        <h2 class="journal-title">Quaternary Research: An Interdisciplinary Journal</h2>
        <ul class="journal-meta">
            <li class="journal-date"><span class="meta-label">Published: </span><?php echo $journal_date; ?></li>
            <li class="journal-volume"><span class="meta-label">Volume: </span><?php echo $journal_volume; ?></li>
            <li class="journal-issue"><span class="meta-label">Issue: </span><?php echo $journal_issue; ?></li>
        </ul>

        <div class="journal-cover">
            <img class="" src="<?php echo $journal_cover['url']; ?>" alt="<?php echo $journal_cover['alt']; ?>" />
        </div>

        <p class="journal-desc"><?php echo $journal_desc; ?></p>

        <div class="journal-links">
            <a class="button" href="<?php echo $journal_link; ?>">View the Journal Publication Site</a>
            <a class="button" href="<?php echo home_url() . '/journal/'; ?>">Learn More</a>
        </div>

    </div>

<?php
# News with featured news

$sticky = get_option( 'sticky_posts' );
$posts_on_home = 3; //set posts_per_page here

$home_args = array(
    'post_type' => 'post',
    'posts_per_page' => $posts_on_home - count($sticky),
    'post_status' => 'publish',
);

$wp_query = new WP_Query( $home_args );
?>
	<?php if ($wp_query->have_posts()): ?>
	<div class="home-news-section large-6 columns">
        <div class="events">
		    <h2 style="margin-top: 0; padding-top: 0;">Events</h2>
            <?php the_widget('CoEnv_Widget_Events', 'feed_url=http://www.trumba.com/calendars/coenveventscalendar.rss&posts_per_page=3'); ?>
        </div>
		<h2 style="margin-top: 0; padding-top: 0;">News</h2>
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
        $terms = wp_get_post_terms( get_the_ID(), 'blog_category');
        if (get_field('story_link_url')) {
            $post_link_url = get_field('story_link_url');
            $post_link_target = ' target="_blank" ';
            $post_link = '<p><a class="button full_button" href="' . $post_link_url . '"' . $post_link_target . '>' . get_field('story_source_name') . '</a></p>';
        } else {
            $post_link_url = get_the_permalink();
            $post_link = '<a class="button full_button" href="' . $post_link_url . '">Read more</a>';
        }

        if(is_sticky(get_the_ID())) {
            echo '<div class="featured-news home-news">';
            if(has_post_thumbnail() ) {
                $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumb' );
                $alt = get_post_meta(get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true);
                echo '<div class="featured-thumbnail">';
                    echo '<a href="' . $post_link_url . '" class="img"' . $post_link_target . '>';
                        echo '<img src="' . $thumbnail[0] . '" class="feature-img" alt="' . $alt . '" />';
                    echo '</a>';
                echo '</div>';
            }
        } else {
            echo '<div class="small-news home-news">';
        }
            echo '<div class="post-meta">';
                echo '<time class="article__time" datetime="' . get_the_date('Y-m-d h:i:s') . '">' . get_the_date('M j, Y') . '</time>';
                // Get categories
                $more_terms = wp_get_post_terms(get_the_id(), 'category');
                if (!empty($more_terms)) {
                    $more_terms_arr = array();

                    foreach ($more_terms as &$term) {
                        if ($term->slug != 'uncategorized') {
                            $more_terms_arr[] = '<a href="/news-and-events/?tax=category&amp;term=' . $term->slug . '">' . $term->name . '</a>';
                        }
                    }   
                    $more_terms_str = ' | ' . implode(', ', $more_terms_arr);

                } else {
                    $more_terms_str = '';
                }
                $more_terms = "";
                echo $more_terms_str;
            echo '</div>';
            echo '<a href="' . $post_link_url . '"><h4>' . get_the_title() . '</h4></a>';
            echo '<div class="featured-content">';
                
                echo '<p>' . the_advanced_excerpt('length=20&finish=sentence') . '</p>';
            echo '</div>';
            echo $post_link;
        echo '</div>';

	endwhile;
	?>
<?php endif; ?>
</div>
<?php wp_reset_postdata(); 
wp_reset_query(); //roll back query vars to as per the request ?>
</div>
</div>
<?php get_footer(); ?>
