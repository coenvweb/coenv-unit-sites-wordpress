<?php
/*
Template Name: Homepage
*/
?>
<?php get_header(); ?>
<div class="full-feature">
	<div class="row">
		<div class="large-12 homepage-features columns">
			<div class="boundless-1">
				<p>Together We Will</p>
			</div>
			<h3>Increase resilience to climate variability and change</h3>
			<p><a class="more" href="/about-cig/">Learn More</a></p>
		</div>
	</div>
</div>			
<div class="full-news">
	<div class="row">
		<div class="large-12 home-news-section columns">
			<div class="home-news-header">
				<h2 class="left'">News &amp; Events</h2>


			<?php
			// News query
			$featured_news_args = array(
			    'post_type' => 'post',
			    'post_status' => 'publish',
			    'posts_per_page' => 1,
			    'category_name' => 'featured'
			);
			$wp_query = new WP_Query( $featured_news_args );
			?>
			</div>
			<?php
			# The Loop
			while ( $wp_query->have_posts() ) { // start featured news loop
				$wp_query->the_post();
				$featured[] = $post->ID;

			 	// Link field display
		        if (get_field('story_link_url')) {
					$post_link_url = get_field('story_link_url');
					$post_link_target = ' target="_blank" ';
		            $post_link = '<p><a class="button" href="' . $post_link_url . '"' . $post_link_target . '>' . get_field('story_source_name') . '</a></p>';
		        } else {
		        	$post_link_url = get_the_permalink();
		            $post_link = '<a class="button left" href="' . $post_link_url . '">Read more</a>';
		        }

				// Category display
		        $terms = wp_get_post_terms(get_the_id(), 'category');

		        // Filter display of administrative post categories
		        $terms = wp_list_filter($terms, array('slug'=>'uncategorized','slug'=>'featured'),'NOT');

				if (!empty($terms)) {
					$terms_arr = array();
					
					foreach ($terms as &$term) {
						if ( $term->slug != 'uncategorized') {
							$terms_arr[] = '<a href="/news-and-events/?tax=category&amp;term=' . $term->slug . '">' . $term->name . '</a>';
						}
					}
				}
				if (!empty($terms_arr)) {
					$terms_str = '<div class="terms">' . implode(', ', $terms_arr) . '</div>';
				} else {
					$terms_str = '';
				}
				?>

	        	<div class="medium-6 small-12 columns">
	                <div class="featured-news">
	                	<?php if ( has_post_thumbnail() ) {
						$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'home_news' );
						?>
						<div class="featured-thumbnail"><a href="<?php echo $post_link_url; ?>" class="img" <?php echo $post_link_target; ?>>
						<img src="<?php echo $thumbnail['0']; ?>" class="feature-img" /></a></div>
						<?php } ?>
					
						<div class="post-content">
							<div class="post-meta">
								<?php echo $terms_str; ?>
	               				<time class="article__time" datetime="<?php echo get_the_date('Y-m-d h:i:s'); ?>"><?php echo get_the_date('M j, Y'); ?></time>
							</div>
							<h3><a href="<?php echo $post_link_url; ?>" <?php echo $post_link_target; ?>><?php echo get_the_title(); ?></a></h3>
		            		<span class="show-for-medium-up"><?php echo the_advanced_excerpt('length=60&finish=sentence'); ?></span>
		            		<div class="news-link show-for-medium-up"><?php echo $post_link; ?></div>

		            	</div>
		            	
	    			</div>
				<?php } // end featured news loop ?>
				</div>

			<?php
			// Other news
			if( !empty( $featured ) ) {
			    $news_args = array(
			        'post_type' => 'post',
			        'post_status' => 'publish',
			        'posts_per_page' => 5,
			        'post__not_in' => $featured,
			    );
			}
			else {
			    $news_args = array(
			        'post_type' => 'post',
			        'posts_per_page' => 3,
			        'post_status' => 'publish',
			        'cat' => -30,
			    );
			}
			$wp_query = new WP_Query( $news_args );
			if ( $wp_query->have_posts() ) {
			?>

			<?php if ( !empty ( $featured ) ): ?><div class="medium-6 columns small-w-featured"><?php endif; ?>

			<?php
			# The Loop
			while ( $wp_query->have_posts() ) { // start other news loop

				$wp_query->the_post();
				if ( get_field( 'story_link_url' ) ) {
					$post_link_url = get_field( 'story_link_url' );
					$post_link_target = ' target="_blank" ';
		            $post_link = '<p><a class="button" href="' . $post_link_url . '"' . $post_link_target . '>' . get_field( 'story_source_name' ) . '</a></p>';
		        } else {
		        	$post_link_url = get_the_permalink();
		            $post_link = '<a class="svg-link right" href="' . $post_link_url . '">More';
		        }
		        // Get categories
		        $more_terms = wp_get_post_terms( get_the_id(), 'category' );

		         // Filter display of administrative post categories
		        $terms = wp_list_filter($more_terms, array('slug'=>'uncategorized','slug'=>'featured'),'NOT');

				if (!empty($more_terms)) {
					$more_terms_arr = array();
					
					foreach ($more_terms as &$term) {
						if ( $term->slug != 'uncategorized') {
							$more_terms_arr[] = '<a href="/about/news/?tax=category&amp;term=' . $term->slug . '">' . $term->name . '</a>';
						}
					}
				}
				if (!empty($more_terms_arr)) {
					$more_terms_str = '<div class="terms">' . implode(', ', $more_terms_arr) . '</div>';
				} else {
					$more_terms_str = '';
				}
        	?>
    		<?php if ( empty( $featured ) ): ?><div class="large-4 medium-12 columns"><?php endif; ?>
		     <div class="small-news">
		     	<div class="post-content">
					<div class="post-meta">
						<?php echo $more_terms_str; ?>
						<time class="article__time" datetime="<?php echo get_the_date('Y-m-d h:i:s'); ?>"><?php echo get_the_date('M j, Y'); ?></time>
					</div>
					<h3><a href="<?php echo $post_link_url; ?>"><?php echo get_the_title(); ?></a></h3>
					<?php if ( !$featured ) { ?>
						<div class="show-for-medium-up"><?php echo the_advanced_excerpt( 'length=15&finish=sentence' ); ?></div>
		    			<div class="show-for-medium-up"><?php echo $post_link; ?></div>
		    		<?php } ?>
		    	</div>
			</div>
			<?php if ( empty( $featured ) ): ?></div><?php endif; ?>
		<?php } // end other news loop ?>
		<div class="more-news column"><a class="button" href="/news-and-events/">See All News</a></div>







		</div>
		<?php if ( !empty( $featured ) ): ?></div><?php endif; ?>










































			<?php } ?>













































		<?php if ( !empty( $featured ) ): ?></div><?php endif; ?>
	</div>
</div>

<div class="full-stats">
	<div class="row">
		<div class="small-12 columns">
				<h2>Stats &amp; Info</h2>
				<div class="large-12">
					<div class="row stats">
						<div class="large-4 medium-4 small-12 columns">
							<div class="stat-value">17</div>
							<div class="stat-label">Projects in 2014</div>
						</div>
						<div class="large-4 medium-4 small-12 columns">
							<div class="stat-value">56</div>
							<div class="stat-label">Partners in the Field</div>
						</div>
						<div class="large-4 medium-4 small-12 columns">
							<div class="stat-value">724</div>
							<div class="stat-label">Publications</div>	
						</div>
					</div>
					<div class="row" style="text-align: center;">
						<div class="large-12"><a class="button">Learn More About Our Partners</a></div>
					</div>
				</div>
		</div>
	</div>
</div>
<div class="full-learn-more">
	<div class="row">
		<div class="small-12 columns">
			<h2>Learn More About the Climate Impacts Group</h2>
			<p>The Climate Impacts Group (CIG) conducts pioneering research on climate variability, climate change, and climate impacts, and works with public and private entities to apply this information in risk assessment, planning, and decision making. Through research and interaction with stakeholders, we work to increase community and ecosystem resilience to fluctuations in climate.</p>
			<ul class="links">
				<li><a class="button" href="/about-cig/">Learn More</a></li>
				<li><a class="button" href="/about-cig/contact-us/">Contact Us</a></li>
			</ul>
		</div>
	</div>
</div>	


</div>
<?php //endif; ?>
</div>
<?php wp_reset_postdata(); wp_reset_query(); //roll back query vars to as per the request ?>
</div>
</div>
<?php get_footer(); ?>
