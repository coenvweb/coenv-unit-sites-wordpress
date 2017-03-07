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
			<h3>Increase climate resilience</h3>
			<p><a class="button" href="/about/">Learn More</a></p>
		</div>
	</div>
</div>			
<div class="full-news">
	<div class="row">
		<div class="large-12 home-news-section columns">
			<div class="home-news-header">
				<h2 class="left'">News &amp; Events</h2>
				<div class="more-news right show-for-medium-up"><a class="button" href="/news-and-events/">All News &amp; Events</a></div>
			</div>


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
			
			<?php
			# The Loop
			while ( $wp_query->have_posts() ) { // start featured news loop
				$wp_query->the_post();
				$featured[] = $post->ID;

			 	// Link field display
		        if (get_field('story_link_url')) {
					$post_link_url = get_field('story_link_url');
					if ( !strpos( $post_link_url, 'cig.uw' ) ) {
						$post_link_target = ' target="_blank" ';
					} else {
						$post_link_target = '';
					}
					$source_link = '<a href="' . $post_link_url . '" target="_blank">' . get_field('story_source_name') . '</a>';
		            $post_link = '<p><a class="button" href="' . $post_link_url . '"' . $post_link_target . '>' . get_field('story_source_name') . '</a></p>';
		        } else {
		        	$post_link_url = get_the_permalink();
		            $post_link = '<a class="button right" href="' . $post_link_url . '">Read more</a>';
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
								<time class="article__time" datetime="<?php echo get_the_date('Y-m-d h:i:s'); ?>"><?php echo get_the_date('M j, Y'); ?></time>
								<?php echo $terms_str; ?>
							</div>
							<h3><a href="<?php echo $post_link_url; ?>" <?php echo $post_link_target; ?>><?php echo get_the_title(); ?></a></h3>
		            		<span class="show-for-medium-up"><?php echo the_advanced_excerpt('length=40&length_type=words&finish=word&no_custom=1&allowed_tags=p,a'); ?></span>
		            		<div class="news-link show-for-medium-up"><?php echo $post_link; ?></div>

		            	</div>
		            					<?php } // end featured news loop ?>
		            				        <div class="social-news left show-for-medium-up">
			        	<div class="left large-6 small-12">
			        	<h3>Get Connected</h3>
			        	<p>Follow or subscribe for updates</p>
			        	</div>
			        	<div class="right large-6 small-12">
			        		<a href="https://twitter.com/CIG_UW" target="_blank">
			        			<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 								width="65px" height="65px" viewBox="0 0 100 100" enable-background="new 0 0 65 65" xml:space="preserve">
								<path d="M88.5,26.12c-2.833,1.256-5.877,2.105-9.073,2.486c3.261-1.955,5.767-5.051,6.945-8.738
									c-3.052,1.81-6.434,3.126-10.031,3.832c-2.881-3.068-6.987-4.988-11.531-4.988c-8.724,0-15.798,7.072-15.798,15.798
									c0,1.237,0.14,2.444,0.41,3.601c-13.13-0.659-24.77-6.949-32.562-16.508c-1.36,2.334-2.139,5.049-2.139,7.943
									c0,5.481,2.789,10.315,7.028,13.149c-2.589-0.083-5.025-0.794-7.155-1.976c-0.002,0.066-0.002,0.131-0.002,0.199
									c0,7.652,5.445,14.037,12.671,15.49c-1.325,0.359-2.72,0.553-4.161,0.553c-1.019,0-2.008-0.098-2.973-0.283
									c2.01,6.275,7.844,10.844,14.757,10.972c-5.407,4.236-12.218,6.763-19.62,6.763c-1.275,0-2.532-0.074-3.769-0.221
									c6.991,4.482,15.295,7.096,24.216,7.096c29.058,0,44.948-24.071,44.948-44.945c0-0.684-0.016-1.367-0.046-2.046
									C83.704,32.071,86.383,29.288,88.5,26.12z"/>
								</svg>
			        		</a>
			        		<a href="http://mailman13.u.washington.edu/mailman/listinfo/climateupdate?listserve=Join+the+CIG%27s+listserve" target="_blank">

			        			<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 								width="65px" height="65px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
								<g>
									<path d="M87.5,50.002C87.5,29.293,70.712,12.5,50,12.5c-20.712,0-37.5,16.793-37.5,37.502C12.5,70.712,29.288,87.5,50,87.5
										c6.668,0,12.918-1.756,18.342-4.809c0.61-0.22,1.049-0.799,1.049-1.486c0-0.622-0.361-1.153-0.882-1.413l0.003-0.004l-6.529-4.002
										L61.98,75.79c-0.274-0.227-0.621-0.369-1.005-0.369c-0.238,0-0.461,0.056-0.663,0.149l-0.014-0.012
										C57.115,76.847,53.64,77.561,50,77.561c-15.199,0-27.56-12.362-27.56-27.559c0-15.195,12.362-27.562,27.56-27.562
										c14.322,0,26.121,10.984,27.434,24.967C77.428,57.419,73.059,63,69.631,63c-1.847,0-3.254-1.23-3.254-3.957
										c0-0.527,0.176-1.672,0.264-2.111l4.163-19.918l-0.018,0c0.012-0.071,0.042-0.136,0.042-0.21c0-0.734-0.596-1.33-1.33-1.33h-7.23
										c-0.657,0-1.178,0.485-1.286,1.112l-0.025-0.001l-0.737,3.549c-1.847-3.342-5.629-5.893-10.994-5.893
										c-10.202,0-19.877,9.764-19.877,21.549c0,8.531,5.101,14.775,13.632,14.775c4.75,0,9.587-2.727,12.665-7.035l0.088,0.527
										c0.615,3.342,9.843,7.576,15.121,7.576c7.651,0,16.617-5.156,16.617-19.932l-0.022-0.009C87.477,51.13,87.5,50.569,87.5,50.002z
										 M56.615,56.844c-1.935,2.727-5.101,5.805-9.763,5.805c-4.486,0-7.212-3.166-7.212-7.738c0-6.422,5.013-12.754,12.049-12.754
										c3.958,0,6.245,2.551,7.124,4.486L56.615,56.844z"/>
								</g>
								</svg>



			        		</a>
			        		<a href="/feed/" target="_blank">
			        		<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 							width="65px" height="65px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
								<g>
									<path d="M26.258,64.949c-4.848,0-8.78,3.93-8.78,8.784c0,4.848,3.932,8.782,8.78,8.782c4.855,0,8.784-3.934,8.784-8.782
										C35.042,68.878,31.113,64.949,26.258,64.949z"/>
									<path d="M23.536,40.801c-0.046,0-0.09,0.006-0.135,0.007v-0.007h-3.464v0.039c-1.698,0.193-3.021,1.603-3.056,3.344h-0.007v6.159
										h0.041c0.19,1.581,1.437,2.822,3.021,3.002v0.039h3.464v-0.048c0.045,0.001,0.09,0.007,0.135,0.007
										c12.772,0,23.173,10.321,23.311,23.061h-0.033v3.464h0.039c0.193,1.698,1.603,3.021,3.344,3.056v0.007h6.158v-0.041
										c1.581-0.19,2.822-1.437,3.002-3.021h0.039v-3.464h-0.006C59.252,56.748,43.223,40.801,23.536,40.801z"/>
									<path d="M83.119,76.403C82.98,43.664,56.308,17.07,23.536,17.07c-0.046,0-0.09,0.006-0.135,0.007V17.07h-3.464v0.039
										c-1.698,0.193-3.021,1.603-3.056,3.344h-0.007v6.159h0.041c0.19,1.582,1.437,2.822,3.021,3.002v0.039h3.464v-0.048
										c0.045,0.001,0.09,0.007,0.135,0.007c25.857,0,46.902,20.967,47.041,46.792h-0.035v3.464h0.039
										c0.193,1.698,1.603,3.021,3.344,3.056v0.007h6.159v-0.041c1.581-0.19,2.822-1.437,3.002-3.021h0.039v-3.464H83.119z"/>
								</g>
							</svg>
							</a>
			        	</div>
			        </div>
	    			</div>


				</div>

			<?php
			// Other news
			if( !empty( $featured ) ) {
			    $news_args = array(
			        'post_type' => 'post',
			        'post_status' => 'publish',
			        'posts_per_page' => 4,
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
				// Link field display
		        if (get_field('story_link_url')) {
					$post_link_url = get_field('story_link_url');
					if ( !strpos( $post_link_url, 'cig.uw' ) ) {
						$post_link_target = ' target="_blank" ';
					} else {
						$post_link_target = '';
					}
					$source_link = '<a href="' . $post_link_url . '" target="_blank">' . get_field('story_source_name') . '</a>';
		            $post_link = '<p><a class="button" href="' . $post_link_url . '"' . $post_link_target . '>' . get_field('story_source_name') . '</a></p>';
		        } else {
		        	$post_link_url = get_the_permalink();
		            $post_link = '<a class="button left" href="' . $post_link_url . '">Read more</a>';
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
		     <li class="small-news">
					<div class="post-meta">
						<time class="article__time" datetime="<?php echo get_the_date('Y-m-d h:i:s'); ?>"><?php echo get_the_date('M j, Y'); ?></time>
						<?php echo $more_terms_str; ?>
					</div>
					<h3><a href="<?php echo $post_link_url . '" ' . $post_link_target; ?>><?php echo get_the_title(); ?></a></h3>
					<?php if ( !$featured ) { ?>
						<div class="show-for-medium-up"><?php echo the_advanced_excerpt( 'length=15&finish=sentence' ); ?></div>
		    			
		    		<?php } ?>
		    			<div class="show-for-medium-up"><?php echo $post_link; ?></div>
			</li>
			<?php if ( empty( $featured ) ): ?></div><?php endif; ?>
		<?php } // end other news loop ?>
		
		 <div class="social-news left show-for-small-only">
			        	<div class="left medium-6 small-12">
			        	<h3>Get Connected</h3>
			        	<p>Follow or subscribe for updates</p>
			        	</div>
			        	<div class="right large-6 small-12">
			        		<a href="https://twitter.com/CIG_UW" target="_blank">
			        			<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 								width="65px" height="65px" viewBox="0 0 100 100" enable-background="new 0 0 65 65" xml:space="preserve">
								<path d="M88.5,26.12c-2.833,1.256-5.877,2.105-9.073,2.486c3.261-1.955,5.767-5.051,6.945-8.738
									c-3.052,1.81-6.434,3.126-10.031,3.832c-2.881-3.068-6.987-4.988-11.531-4.988c-8.724,0-15.798,7.072-15.798,15.798
									c0,1.237,0.14,2.444,0.41,3.601c-13.13-0.659-24.77-6.949-32.562-16.508c-1.36,2.334-2.139,5.049-2.139,7.943
									c0,5.481,2.789,10.315,7.028,13.149c-2.589-0.083-5.025-0.794-7.155-1.976c-0.002,0.066-0.002,0.131-0.002,0.199
									c0,7.652,5.445,14.037,12.671,15.49c-1.325,0.359-2.72,0.553-4.161,0.553c-1.019,0-2.008-0.098-2.973-0.283
									c2.01,6.275,7.844,10.844,14.757,10.972c-5.407,4.236-12.218,6.763-19.62,6.763c-1.275,0-2.532-0.074-3.769-0.221
									c6.991,4.482,15.295,7.096,24.216,7.096c29.058,0,44.948-24.071,44.948-44.945c0-0.684-0.016-1.367-0.046-2.046
									C83.704,32.071,86.383,29.288,88.5,26.12z"/>
								</svg>
			        		</a>
			        		<a href="http://mailman13.u.washington.edu/mailman/listinfo/climateupdate?listserve=Join+the+CIG%27s+listserve" target="_blank">

			        			<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 								width="65px" height="65px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
								<g>
									<path d="M87.5,50.002C87.5,29.293,70.712,12.5,50,12.5c-20.712,0-37.5,16.793-37.5,37.502C12.5,70.712,29.288,87.5,50,87.5
										c6.668,0,12.918-1.756,18.342-4.809c0.61-0.22,1.049-0.799,1.049-1.486c0-0.622-0.361-1.153-0.882-1.413l0.003-0.004l-6.529-4.002
										L61.98,75.79c-0.274-0.227-0.621-0.369-1.005-0.369c-0.238,0-0.461,0.056-0.663,0.149l-0.014-0.012
										C57.115,76.847,53.64,77.561,50,77.561c-15.199,0-27.56-12.362-27.56-27.559c0-15.195,12.362-27.562,27.56-27.562
										c14.322,0,26.121,10.984,27.434,24.967C77.428,57.419,73.059,63,69.631,63c-1.847,0-3.254-1.23-3.254-3.957
										c0-0.527,0.176-1.672,0.264-2.111l4.163-19.918l-0.018,0c0.012-0.071,0.042-0.136,0.042-0.21c0-0.734-0.596-1.33-1.33-1.33h-7.23
										c-0.657,0-1.178,0.485-1.286,1.112l-0.025-0.001l-0.737,3.549c-1.847-3.342-5.629-5.893-10.994-5.893
										c-10.202,0-19.877,9.764-19.877,21.549c0,8.531,5.101,14.775,13.632,14.775c4.75,0,9.587-2.727,12.665-7.035l0.088,0.527
										c0.615,3.342,9.843,7.576,15.121,7.576c7.651,0,16.617-5.156,16.617-19.932l-0.022-0.009C87.477,51.13,87.5,50.569,87.5,50.002z
										 M56.615,56.844c-1.935,2.727-5.101,5.805-9.763,5.805c-4.486,0-7.212-3.166-7.212-7.738c0-6.422,5.013-12.754,12.049-12.754
										c3.958,0,6.245,2.551,7.124,4.486L56.615,56.844z"/>
								</g>
								</svg>



			        		</a>
			        		<a href="/feed/" target="_blank">
			        		<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 							width="65px" height="65px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
								<g>
									<path d="M26.258,64.949c-4.848,0-8.78,3.93-8.78,8.784c0,4.848,3.932,8.782,8.78,8.782c4.855,0,8.784-3.934,8.784-8.782
										C35.042,68.878,31.113,64.949,26.258,64.949z"/>
									<path d="M23.536,40.801c-0.046,0-0.09,0.006-0.135,0.007v-0.007h-3.464v0.039c-1.698,0.193-3.021,1.603-3.056,3.344h-0.007v6.159
										h0.041c0.19,1.581,1.437,2.822,3.021,3.002v0.039h3.464v-0.048c0.045,0.001,0.09,0.007,0.135,0.007
										c12.772,0,23.173,10.321,23.311,23.061h-0.033v3.464h0.039c0.193,1.698,1.603,3.021,3.344,3.056v0.007h6.158v-0.041
										c1.581-0.19,2.822-1.437,3.002-3.021h0.039v-3.464h-0.006C59.252,56.748,43.223,40.801,23.536,40.801z"/>
									<path d="M83.119,76.403C82.98,43.664,56.308,17.07,23.536,17.07c-0.046,0-0.09,0.006-0.135,0.007V17.07h-3.464v0.039
										c-1.698,0.193-3.021,1.603-3.056,3.344h-0.007v6.159h0.041c0.19,1.582,1.437,2.822,3.021,3.002v0.039h3.464v-0.048
										c0.045,0.001,0.09,0.007,0.135,0.007c25.857,0,46.902,20.967,47.041,46.792h-0.035v3.464h0.039
										c0.193,1.698,1.603,3.021,3.344,3.056v0.007h6.159v-0.041c1.581-0.19,2.822-1.437,3.002-3.021h0.039v-3.464H83.119z"/>
								</g>
							</svg>
							</a>
			        	</div>
			        </div>
		</div>
		<?php if ( !empty( $featured ) ): ?></div><?php endif; ?>
			<?php } ?>
		<?php if ( !empty( $featured ) ): ?></div><?php endif; ?>
	</div>
</div>

<?php if(have_rows('homepage_statistics', 'options')) { ?>

<div class="full-stats">
	<div class="row">
		<div class="small-12 columns">
				<h2>Stats &amp; Info</h2>
				<div class="large-12">
					<div class="row stats">
                        <?php while(have_rows('homepage_statistics', 'options')): the_row(); ?>
						<div class="large-4 medium-4 small-12 columns">
							<div class="stat-value"><?php echo get_sub_field('value'); ?></div>
							<div class="stat-label"><?php echo get_sub_field('label'); ?></div>
						</div>
                        <?php endwhile; ?>
					</div>
                    <?php while(have_rows('homepage_statistics_link', 'options')): the_row(); ?>
					    <div class="large-12 text-center"><a class="button" href="<?php echo get_sub_field('link_to'); ?>"><?php echo get_sub_field('link_label'); ?></a></div>
                    <?php endwhile; ?>
				</div>
		</div>
	</div>
</div>
<?php } ?>
<div class="full-learn-more">
	<div class="row">
		<div class="small-12 columns">
			<h2>Learn More About the Climate Impacts Group</h2>
			<p><?php echo get_field('meta_description', 'options'); ?></p>
			<ul class="links">
				<li><a class="button" href="/about/what-we-do/">Learn More</a></li>
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
