<?php
/*
Template Name: Homepage
*/
?>
<?php get_header(); ?>
<div class="hero-row row" id="main-col">
	
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
		echo '<div class="feature-info">';
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
    
    <div class="news-events-row">
            <div class="row news-wrap">
                <div class="large-8 medium-8 columns">
                    <div class="news-section">
    <div class="news-header">
        <a class="button right" href="/about/news-events"><div class="button-background "><p>More stories »</p></div></a>
        <a href="/about/news-events"><h4>What's New</h4></a>
    </div>
                
<?php

# Featured News

$feat_args = array(
    'post_type' => array('post'),
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'tax_query' => array(
        'relation' => 'OR',
        array(
            'taxonomy' => 'category',
            'terms' => 'featured',
            'field' => 'slug'
        ),
    )
);
    

$wp_query = new WP_Query( $feat_args );
?>
	<?php if ($wp_query->have_posts()): ?>
	<div class="home-news-section clearfix">
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
            $post_link_target = null;
            $post_link = '<a class="button left" href="' . $post_link_url . '">Read more</a>';
        } if ( has_post_thumbnail()) {
                $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumb' );
                $alt = get_post_meta(get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true);
                echo '<div class="medium-12 large-7 columns featured-news">';
				echo '<div class="featured-thumbnail">';
				echo '<a href="' . $post_link_url . '" class="img"' . $post_link_target . '>';
				echo '<img src="' . $thumbnail[0] . '" class="feature-img" alt="' . $alt . '" />';
				echo '</a></div>';
                echo '<div class="post-content">';
				echo '<div class="post-meta">';
                echo '<time class="article__time" datetime="' . get_the_date('Y-m-d h:i:s') . '">' . get_the_date('M j, Y') . '</time>';
                // Get categories
                $terms = wp_get_post_terms(get_the_id(), 'category');
                // Filter display of administrative post categories
                $terms = wp_list_filter($terms, array('slug'=>'uncategorized','slug'=>'featured'),'NOT');
				if (!empty($terms)) {
					$terms_arr = array();
					
					foreach ($terms as &$term) {
						// exclude administrative terms
						//if ($term->slug != 'uncategorized' || $term->slug != 'featured') {
							$terms_arr[] = '<a href="/about/news/?tax=category&amp;term=' . $term->slug . '">' . $term->name . '</a>';
						//}
					}
					$terms_str = ' / ' . implode(', ', $terms_arr);

				} else {
					$terms_str = '';
				}
				$terms = "";
				echo $terms_str;
	            echo '</div>';
                echo '<a href="' . $post_link_url . '"' . $post_link_target . '><h5>' . get_the_title() . '</h5></a>';
	            echo '<p>' . the_advanced_excerpt('length=60&finish=sentence') . '</p>';
	            echo $post_link;
                echo '</div>';
                ?>
    </div>
        <?php
                
			}
            else {
                if (get_field('story_link_url')) {
                    $post_link_url = get_field('story_link_url');
                    $post_link_target = ' target="_blank" ';
                    $post_link = '<p><a class="button" href="' . $post_link_url . '"' . $post_link_target . '>' . get_field('story_source_name') . '</a></p>';
                } else {
                    $post_link_url = get_the_permalink();
                    $post_link = '<a class="svg-link" href="' . $post_link_url . '">More';
                }	
                echo '<div class="featured-section">';
                echo '<div class="large-7 medium-12 columns left no-feature">';
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
                            $more_terms_arr[] = '<a href="/about/news/?tax=category&amp;term=' . $term->slug . '">' . $term->name . '</a>';
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
                ?>
    </div>
                <?php
            }
	endwhile;
endif; ?>



<?php
# Other News
$sticky = count(get_option('sticky_posts')); 
if ($sticky > 2) {
    $sticky = 2;
} else {
    $sticky = 1;
}
if(!empty($featured)) {
    $home_args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 3 - $sticky,
        'post__not_in' => $featured,
        'cat' => -19, //hide q+a posts]
        'orderby' => 'date',
        'order' => 'DESC'
    );
}
else {
    $home_args = array(
        'post_type' => 'post',
        'posts_per_page' => 3,
        'post_status' => 'publish',
        'cat' => -19,
    );
   echo '<div class="home-news-section clearfix" data-equalizer data-equalizer-mq="large-up">';
}

$wp_query = new WP_Query( $home_args );
?>
	<?php if ($wp_query->have_posts()): ?>
		<?php
        if(!empty($featured)) {
            echo '<div class="large-5 medium-6 columns right">';
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
            $post_link = '<a class="svg-link" href="' . $post_link_url . '">More';
        }	
        if (empty( $featured )) {
            echo '<div class="large-4 medium-6 columns left no-feature" data-equalizer-watch>';
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
					$more_terms_arr[] = '<a href="/about/news/?tax=category&amp;term=' . $term->slug . '">' . $term->name . '</a>';
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
        echo '</a></div></div>'; 
        if (empty( $featured )) {
            echo '</div>';
        }
        endwhile;
        ?>
        <?php 
        
    echo '</div></div></section>';
    endif;
	?>

<?php if (!empty($featured)) : ?>
    </div>
<?php endif; ?>
</div>
    <div class="large-4 medium-4 columns">
        <div class="events-section">
        <div class="events-header">
            <a class="button right" href="/about/news-events/events"><div class="button-background"><p>More events »</p></div></a>
            <h4>Events</h4>
        </div>
        <div class="events">
        <?php the_widget('CoEnv_Widget_Events', 'feed_url=https://www.trumba.com/calendars/sea_envir.rss&posts_per_page=3'); ?>
        </div>
    </div>
</div>
</div>
</div>

<div class="spotlight-purple">
<div class="row spotlight">
    <div class="spotlight-content">
        <?php the_widget('custom_post_widget', 'custom_post_id=26848&show_featured_image=true'); ?>
    </div>
</div>
</div>
        
<div class="row social-row">
    <div class="large-12 columns social-bar">
        <h3>Connect with us »</h3>
        <ul class="social-buttons">
        <?php if (get_option('facebook')) { ?><a href="<?php echo get_option('facebook'); ?>" title="Become a fan of <?php bloginfo('name'); ?> on Facebook" target="_blank" rel="nofollow"><li><?php include($_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/coenv-poe/assets/img/F_icon.svg'); ?><span class="visuallyhidden">Facebook</span></li></a><?php } ?>
        <?php if (get_option('twitter')) { ?><a href="<?php echo 'http://twitter.com/' .  get_option('twitter'); ?>" title="Follow <?php bloginfo('name'); ?> on Twitter" target="_blank" rel="nofollow"><li><i class="fi-social-twitter"><span class="visuallyhidden">Twitter</span></i></li></a><?php } ?>
        <?php if (get_option('youtube')) { ?><a href="<?php echo get_option('youtube'); ?>" title="<?php bloginfo('name'); ?> YouTube Channel" target="_blank" rel="nofollow"><li><i class="fi-social-youtube"><span class="visuallyhidden">YouTube</span></i></li></a><?php } ?>
        <?php if (get_option('linkedin')) { ?><a href="<?php echo get_option('linkedin'); ?>" title="<?php bloginfo('name'); ?> LinkedIn Group" target="_blank" rel="nofollow"><li><i class="fi-social-linkedin"><span class="visuallyhidden">LinkedIn</span></i></li></a><?php } ?>
        <?php if (get_option('email_newsletter')) { ?><a href="<?php echo get_option('email_newsletter'); ?>" title="Subscribe to the <?php bloginfo('name'); ?>'s Email Newsletter" target="_blank" rel="nofollow"><li><i class="fi-at-sign"><span class="visuallyhidden">Email Newsletter</span></i></li></a><?php } ?>
        <a href="<?php echo get_bloginfo('url').'/feed'; ?>" title="<?php bloginfo('name'); ?> RSS Feeds"><li><i class="fi-rss"><span class="visuallyhidden">RSS</span></i></li></a>
      </ul>
    </div>
</div>
        
<div class="row major-program">
    <div class="large-12 columns major">
        <?php the_widget('custom_post_widget', 'custom_post_id=2745&show_featured_image=true'); ?>
    </div>
</div>

<?php do_action('foundationPress_after_content'); ?>
</div>
<?php wp_reset_postdata(); wp_reset_query(); //roll back query vars to as per the request ?>
</div>
</div>
<?php get_footer(); ?>