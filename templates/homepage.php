<?php
/*
Template Name: Homepage
*/
?>
<?php get_header(); ?>
<div class="feature-row row">
	
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
	echo '<div class="feature-info-container medium-6 small-12 columns right">';
		echo '<div class="feature-info" style="background-color:' . $feature_color . '">';
        echo '<p class="feature-image-caption right">' . $feature_caption . '</p>';
			echo '<div class="feature-content">';
                get_template_part('assets/img/icons/inline', 'smea-white-slash.svg');
				echo '<h2>' . get_the_title() . '</h2>';
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
echo '</div>';
endwhile;
wp_reset_postdata();
echo '</div>';
echo '<div class="row news-row" id="main-col">';

# Featured News

$feat_args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'category_name' => 'featured',
    'cat' => -19,
);

$wp_query = new WP_Query( $feat_args );
?>
	<?php if ($wp_query->have_posts()): ?>
	<div class="home-news-section clearfix">
    <div class="columns large-12"><a href="/about/news/" name="News & Events" class="news-title-link"><h2 class="news-title">News & Events</h2></a></div>
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
        $featured[] = $post->ID;
		if (get_field('story_link_url')) {
			$post_link_url = get_field('story_link_url');
			$post_link_target = ' target="_blank" ';
            $post_link = '<p><a class="button" href="' . $post_link_url . '"' . $post_link_target . '>' . get_field('story_source_name') . '</a></p>';
        } else {
        	$post_link_url = get_the_permalink();
            $post_link = '<a class="button left" href="' . $post_link_url . '">Read more</a>';
        } if ( has_post_thumbnail()) {
                
                $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumb' );
                echo '<div class="featured-section">';
                echo '<div class="medium-6 large-7 columns">';
                echo '<div class="featured-news">';
				echo '<div class="featured-thumbnail">';
				echo '<a href="' . $post_link_url . '" class="img"' . $post_link_target . '>';
				echo '<img src="' . $thumbnail['0'] . '" class="feature-img" />';
				echo '</a></div>';
                echo '<div class="post-content">';
				echo '<div class="post-meta">';
                echo '<time class="article__time" datetime="' . get_the_date('Y-m-d h:i:s') . '">' . get_the_date('M j, Y') . '</time>';
                // Get categories
                $terms = wp_get_post_terms(get_the_id(), 'category');
				if (!empty($terms)) {
					$terms_arr = array();
					
					foreach ($terms as &$term) {
						if ($term->slug != 'uncategorized') {
							$terms_arr[] = '<a href="/about/news/?tax=category&amp;term=' . $term->slug . '">' . $term->name . '</a>';
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
                echo '</div>';
            	echo '</div>';
                ?>
                    <!--Social Media Box-->

    <div class="social-news show-for-medium-up">
    <div class="post-content">
        <div class="social-statement left"><h5>Keep up-to-date with us</h5></div>
        <div class="social-buttons right">
            <a href="http://twitter.com/<?php echo get_option('twitter') ?>" target="_blank" title="Follow us on Twitter">
            <?php get_template_part('assets/img/icons/inline', 'twitter-circle.svg'); ?></a>
            <a href="<?php echo get_option('facebook'); ?>" target="_blank" title="Like us on Facebook">
            <?php get_template_part('assets/img/icons/inline', 'facebook-circle.svg'); ?></a>
            <a href="<?php bloginfo('rss2_url'); ?>" title="Subscribe to our RSS Feed" target="_blank">
            <?php get_template_part('assets/img/icons/inline', 'rss-circle.svg'); ?></a>
        </div>
    </div>
    </div>
    </div>
        <?php
                
			}
            else {
                echo '<div class="large-4 medium-6 columns">';
                echo '<div class="small-news">';
                echo '<div class="post-content">';
                echo '<div class="post-meta">';
                echo '<time class="article__time" datetime="' . get_the_date('Y-m-d h:i:s') . '">' . get_the_date('M j, Y') . '</time>';
                // Get categories
                $terms = wp_get_post_terms(get_the_id(), 'category');
				if (!empty($terms)) {
					$terms_arr = array();
					
					foreach ($terms as &$term) {
						if ($term->slug != 'uncategorized') {
							$terms_arr[] = '<a href="/about/news/?tax=category&amp;term=' . $term->slug . '">' . $term->name . '</a>';
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
                echo '</div>';
            	echo '</div>';
                echo '</div>';  
            }
	endwhile;
endif; ?>



<?php
# Other News
if( $featured ) {
    $home_args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 2,
        'post__not_in' => $featured,
        'cat' => -19, //hide q+a posts
    );
}
else {
    $home_args = array(
        'post_type' => 'post',
        'posts_per_page' => 3,
        'post_status' => 'publish',
        'cat' => -19,
    );
   echo '<div class="home-news-section clearfix">';
}

$wp_query = new WP_Query( $home_args );
?>
	<?php if ($wp_query->have_posts()): ?>
		<?php
        if( $featured ) {
            echo '<div class="large-4 medium-6 columns right">';
        }
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
		if (get_field('story_link_url')) {
			$post_link_url = get_field('story_link_url');
			$post_link_target = ' target="_blank" ';
            $post_link = '<p><a class="button" href="' . $post_link_url . '"' . $post_link_target . '>' . get_field('story_source_name') . '</a></p>';
        } else {
        	$post_link_url = get_the_permalink();
            $post_link = '<a class="svg-link right" href="' . $post_link_url . '">More';
        }	
        if (empty( $featured )) {
            echo '<div class="large-4 medium-6 columns right">';
        }
        echo '<div class="small-news">';
        echo '<div class="post-content">';
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
		echo '<a href="' . $post_link_url . '"><h5>' . get_the_title() . '</h5></a>';
		echo '<p>' . the_advanced_excerpt('length=15&finish=sentence') . '</p>';
       	echo $post_link;
        if (strpos($post_link, 'svg') !== false) { get_template_part('assets/img/icons/inline', 'more-arrow.svg'); };
        echo '</a></div></div>'; 
        endwhile;
        ?>
        <!--Small Social Media Box-->

        <div class="social-news visible-for-small-only">
        <div class="post-content">
            <div class="social-statement center"><h3>Keep up-to-date with us</h3></div>
            <div class="social-buttons center">
                <a href="http://twitter.com/<?php echo get_option('twitter') ?>" target="_blank" title="Follow us on Twitter">
                <?php get_template_part('assets/img/icons/inline', 'twitter-circle.svg'); ?></a>
                <a href="<?php echo get_option('facebook'); ?>" target="_blank" title="Like us on Facebook">
                <?php get_template_part('assets/img/icons/inline', 'facebook-circle.svg'); ?></a>
                <a href="<?php bloginfo('rss2_url'); ?>" title="Subscribe to our RSS Feed" target="_blank">
                <?php get_template_part('assets/img/icons/inline', 'rss-circle.svg'); ?></a>
            </div>
        </div>
        </div>
        <?php
        if (empty( $featured )) {
            echo '</div>';
        }       
    if ( $featured ) {
        echo '<a href=/about/news" name="All Posts"><div class="all-news"><span class="button white">See All Posts</span></div></a>';
        echo '</div>';
    }
    echo '</div></div></section>';
    endif;
	?>

<?php if ($featured) : ?>
    </div>
<?php endif; ?>
        
<?php if ( is_active_sidebar( 'student-spotlight' ) ) : ?>
<div class="profiles">
    <div class="row">
        <div class="medium-6 columns student-title"><h3>Student Spotlight</h3>
        <div class="large-12 columns profile-widget">
            <div class="widget-area student-spotlight" role="complementary">
                <?php dynamic_sidebar( 'student-spotlight' ); ?>
            </div><!-- .widget-area -->
        </div>
        </div>
        <div class="medium-6 columns right faculty-title"><h3>Featured Faculty</h3>
        <div class="large-12 columns profile-widget">
            <div class="widget-area featured-faculty" role="complementary">
                <?php dynamic_sidebar( 'featured-faculty' ); ?>
            </div><!-- .widget-area -->
        </div>
        </div>
    </div>
</div>
<?php endif; ?>
<div class="get-started">
    <div class="row">
        <div class="large-12 columns">
            <?php get_template_part('assets/img/icons/inline', 'white-slash.svg'); ?>
            <?php the_widget('custom_post_widget', 'custom_post_id=2690'); ?>
        </div>
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
<?php wp_reset_postdata(); wp_reset_query(); //roll back query vars to as per the request ?>
</div>
</div>
<?php get_footer(); ?>