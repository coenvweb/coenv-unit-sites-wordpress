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
			'orderby' => 'menu_order',
			);
		$feature_query = new WP_Query( $feature_args ); ?>
		<?php //if ($feature_query->have_posts()) { ?>
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

		echo '<div class="feature-info-container">';
		echo '<p class="feature-image-caption right">' . $feature_caption . '</p>';
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
	echo '</div>';


echo '</div><!-- .feature -->';
endwhile;
wp_reset_postdata();
echo '</div>';
?>
</div>
<div class="row programs" data-equalizer data-equalizer-mq="large-up">
    <div class="columns large-4 minor" data-equalizer-watch>
        <?php the_widget('custom_post_widget', 'custom_post_id=3068&show_featured_image=true&show_custom_post_title=true'); ?>
    </div>
    <div class="columns large-4 certificate" data-equalizer-watch>
        <?php the_widget('custom_post_widget', 'custom_post_id=3070&show_featured_image=true&show_custom_post_title=true'); ?>
    </div>
    <div class="columns large-4 courses" data-equalizer-watch>
        <?php the_widget('custom_post_widget', 'custom_post_id=3072&show_featured_image=true&show_custom_post_title=true'); ?>
    </div>
</div>

				
<?php if ( is_active_sidebar( 'home-content' ) ) : ?>
<div class="large-12 columns programs">
	<div class="widget-area home-content" role="complementary">
		<?php dynamic_sidebar( 'home-content' ); ?>
	</div><!-- .widget-area -->
</div>
<?php endif; ?>
        
<div class="row news">

<?php
# News with featured news

$sticky = get_option( 'sticky_posts' );
$sticky_count = count($sticky);
$posts_on_home = 3; //set posts_per_page here

if( $sticky ) {
    $home_args = array(
        'post_type' => 'post',
        'posts_per_page' => $posts_on_home - $sticky_count,
        'post_status' => 'publish',
    );
}
else {
    $home_args = array(
        'post_type' => 'post',
        'posts_per_page' => $posts_on_home - $sticky_count,
        'post_status' => 'publish',
    );
}

$wp_query = new WP_Query( $home_args );
?>
	<?php if ($wp_query->have_posts()): ?>
	<hr />
	<div class="home-news-section clearfix">
        <div class="columns large-8 left" style="margin-top: 0; padding-top: 0;">
        <h2 class="left">News</h2>
        <a class="button right" href="/news-and-events">More News</a>
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
		if (get_field('story_link_url')) {
			$post_link_url = get_field('story_link_url');
			$post_link_target = ' target="_blank" ';
            $post_link = '<p><a class="button" href="' . $post_link_url . '"' . $post_link_target . '>' . get_field('story_source_name') . '</a></p>';
        } else {
        	$post_link_url = get_the_permalink();
            $post_link = '<a class="button left" href="' . $post_link_url . '">Read more</a>';
        }

		if ( $wp_query->current_post == 0 ) {
            if ( has_post_thumbnail()) {
                echo '<div class="first-news row">';
				echo '<div class="first-thumbnail">';
                    echo '<a href="' . $post_link_url . '" class="img"' . $post_link_target . '>';
                    the_post_thumbnail( 'large' );
				echo '</a></div>';
                
				echo '<div class="post-meta">';
                    echo '<time class="article__time" datetime="' . get_the_date('Y-m-d h:i:s') . '">' . get_the_date('M j, Y') . '</time>';
                    // Get categories
                    $terms = wp_get_post_terms(get_the_id(), 'category');
                    if (!empty($terms)) {
                        $terms_arr = array();		
                        foreach ($terms as &$term) {
                            if ($term->slug != 'uncategorized') {
                                $terms_arr[] = '<a href="/news-and-events/?tax=category&amp;term=' . $term->slug . '">' . $term->name . '</a>';
                            }
                        }
                        $terms_str = ' / ' . implode(', ', $terms_arr);
                    } else {
                        $terms_str = '';
                    }
                    $terms = "";
                    echo $terms_str;
	            echo '</div>';
                
                echo '<a href="' . $post_link_url . '"' . $post_link_target . '><h4>' . get_the_title() . '</h4></a>';
	            echo '<p>' . the_advanced_excerpt('length=60&finish=sentence') . '</p>';
	            echo $post_link;
        } else {
                echo '<div class="first-news row">';
                echo '<div class="post-meta">';
                echo '<time class="article__time" datetime="' . get_the_date('Y-m-d h:i:s') . '">' . get_the_date('M j, Y') . '</time>';
                // Get categories
                $terms = wp_get_post_terms(get_the_id(), 'category');
				if (!empty($terms)) {
					$terms_arr = array();
					
					foreach ($terms as &$term) {
						if ($term->slug != 'uncategorized') {
							$terms_arr[] = '<a href="/news-and-events/?tax=category&amp;term=' . $term->slug . '">' . $term->name . '</a>';
						}
					}
					$terms_str = ' / ' . implode(', ', $terms_arr);

				} else {
					$terms_str = '';
				}
				echo $terms_str;
				//var_dump($terms_arr);
				$terms = "";
                echo '</div>';
            echo '<a href="' . $post_link_url . '"><h5>' . get_the_title() . '</h5></a>';
            echo '<p>' . the_advanced_excerpt('length=30&finish=sentence') . '</p>';
            echo $post_link;
        }
        } else {
			
		echo '<div class="small-news row">';
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
			$more_terms_str = ' / ' . implode(', ', $more_terms_arr);

		} else {
			$more_terms_str = '';
		}
		$more_terms = "";
		echo $more_terms_str;
		echo '</div>';
		echo '<a href="' . $post_link_url . '"><h4>' . get_the_title() . '</h4></a>';
		echo '<p>' . the_advanced_excerpt('length=30&finish=sentence') . '</p>';
       	echo $post_link;
		}
	echo '</div>';
	endwhile;
	?>
    </div>
<?php endif; ?>
<div class="large-4 columns">
    <?php the_widget('wptt_TwitterTweets', 'title=twitter&name=CIG_UW&consumerKey=ivTXKU52g6Sx851RzmILf1svw&consumerSecret=6zVP3WDKPFVLhi8cI7XwiR0GNyGQF6ZIZa7mKULsxTiF6UrqdM&accessToken=47968457-Ccfpdt7oaFyoPQyOU5aNa8utxUXIzOIyKUWbAkXup&accessTokenSecret=BbefqWcc8WLG4s1iFQ1JkRWohhs0XJOXekbsGxnHjgtkV'); ?>
</div>
</div>  
        <!--&tweets_cnt=3&tweet_theme=light&tweet_border=false&store_time=4&replies_excl=true&disp_scr_name=false&dataLang=en&timeRef=false&timeAgo=true&twitterIntents=false&twitterIntentsText=false&intentColor=#999&showAvatar=false&border_rad=false&slide_style=list-->
<div class="row events">
    <a href="/news-stories/events" id="More Events"><h2>Events</h2></a>
    <div class="list columns large-12">
        <?php the_widget('CoEnv_Widget_Events', 'feed_url=http://www.trumba.com/calendars/sea_pcc.rss&posts_per_page=3'); ?>
    </div>      
</div>
<a href="#" class="back-to-top">Back to Top</a>
<?php do_action('foundationPress_after_content'); ?>
</div>
<?php wp_reset_postdata(); wp_reset_query(); //roll back query vars to as per the request ?>
</div>
</div>
<?php get_footer(); ?>