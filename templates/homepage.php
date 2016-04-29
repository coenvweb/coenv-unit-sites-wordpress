<?php
/*
 * Template Name: Homepage
 */

get_header();

// Query for homepage features.

$feature_args = array(
	'post_type'	=> 'features',
	'post_status' => 'publish',
	'posts_per_page' => 4,
	'orderby' => 'menu_order',
);

$feature_query = new WP_Query( $feature_args );
?>
<div class="full-feature" id="main-col">
	<!--<div class="playpause"></div>-->
	<div class="homepage-features">

	<?php
	
	// Homepage feature loop

	while ( $feature_query->have_posts() ) :
		$feature_query->the_post();

		if (get_field( 'feature_add_links' )) {
			$feature_link_type = get_field( 'feature_link_type' );
			$feature_link_type_internal = get_field( 'feature_link_page' );
		}
		if ( get_field( 'feature_color' ) ) {
			$feature_color = get_field( 'feature_color' );
		}
		if (get_field( 'feature_excerpt' ) ) {
			$feature_excerpt = get_field( 'feature_excerpt' );
		}
		if ( get_the_post_thumbnail() ) {
            $thumb_id = get_post_thumbnail_id();
			$feature_image = wp_get_attachment_image_src( $thumb_id, 'thumbnail-size', true );
            $alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
			$feature_caption = get_post( get_post_thumbnail_id() );
			$feature_caption = $feature_caption->post_excerpt;
		}
		
		$rows = get_field('feature_add_links');
		?>
			
		<div class="feature">
			<!--
			<div class="feature-controls hide-for-medium-up">
				<a class="slick-p" href="#">Previous</a>
				<a class="slick-n" href="#">Next</a>
			</div>
		-->
			<div class="feature-image" id="pid-<?php echo $feature_query->post->ID; ?>" data-interchange="['/wp-content/themes/coenv-fish/assets/img/black.png', (default)][<?php echo $feature_image[0]; ?>, (medium)]">
				<div class="feature-info-container">
					<img class="show-for-small-only mobile-hero" src="<?php echo $feature_image[0]; ?>" alt="<?php echo $alt; ?>" />
					<div class="feature-info row" style="background-color:<?php $feature_color; ?>">
						<div class="feature-content">
							<h2><?php echo get_the_title(); ?></h2>
							<p class="feature-excerpt"><?php echo $feature_excerpt; ?></p>
							
							<?php

							// Feature links

							if($rows) {
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
							} ?>

						</div>
						<div class="feature-controls show-for-medium-up">
							<a class="slick-p" href="#">Previous</a>
							<a class="slick-n" href="#">Next</a>
						</div>
					</div><!-- .feature-info -->
				</div><!-- .feature-info-container -->
				
			</div><!-- .feature -->
		</div>

	<?php 
	endwhile;
	wp_reset_postdata();
	?>

	</div><!-- homepage-features -->
	<div id="feature-mask"></div>
</div> <!-- end .full-feature -->
<div class="full-intro clearfix">
	<div class="row">				
		<?php if ( is_active_sidebar( 'home-content' ) ) : ?>
		<div class="large-12 columns programs">
		<div class="widget-area home-content" role="complementary">
	<div class="solid-widget">
		<div class="widget-title">
			<h4><a title="Learn more about the School of Aquatic and Fishery Sciences" href="/about/" target="_self">Join our community</a></h4>
		</div>
		<div class="widget-content">
			<p><span class="intro">The School of Aquatic and Fishery Sciences (SAFS) is dedicated to sustaining healthy marine and freshwater environments. Our faculty conduct innovative research from the organism to the ecosystem scale, and are recognized leaders in aquatic biology, sustainable fisheries management and aquatic resource conservation.</span></p>
			<ul class="widget_links">
				<li class="visible-for-small-only"><a class="button" href="/students">Explore our Programs</a></li>
				<li class="visible-for-small-only"><a class="button" href="/faculty-research">Meet Our Faculty</a></li>
				<li><a class="button" title="Learn more about the School of Aquatic and Fishery Sciences" href="/about/" target="_self">Learn more</a></li>
			</ul>
		</div>
	</div>							
</div>
		</div>
		<?php endif; ?>
	</div>
</div> <!-- end full-intro -->
<div class="full-student-faculty row show-for-medium-up">

	<div class="student-container text-center columns small-12 medium-12 large-6">
		<div class="fac-stud-wrapper" style="position: relative;">
			<h2><a href="/students">Explore our Programs</a></h2>
			<div class="fac-stud-content hover-start">
				<p>SAFS students work alongside talented peers and faculty to engage in a rigorous and inclusive learning environment. Join us to connect with some of the best minds and immerse yourself in cutting-edge scientific research.</p>
				<p><a class="button" href="/students">Learn more</a></p>
			</div>
		</div>
	</div>

	<div class="faculty-container text-center columns small-12 medium-12 large-6">
		<div class="fac-stud-wrapper" style="position: relative;">
			<h2><a href="/faculty-research">Meet Our Faculty</a></h2>
			<div class="fac-stud-content">
				<p>Our faculty are committed leaders with broad academic expertise and interests. With access to a network of local, national and international leaders, we contribute influential research on topics ranging from organisms, populations, ecosystems, to human users of aquatic ecosystems.</p>
				<p><a class="button" href="/faculty-research">Learn more</a></p>
			</div>
		</div>
	</div>

</div>

<?php if( get_field('social_media', 'option') ) { ?>

<div class="full-connect clearfix">
	<h2 style="background-position: bottom center;">Connect With Us</h2>
	<div class="social-buttons">
	<?php while( has_sub_field('social_media', 'option') ) { ?>
		<a class="<?php the_sub_field('service_name'); ?> icon" href="<?php the_sub_field('url'); ?>" title="<?php the_sub_field('service_name'); ?>">
			<i class="fi-social-<?php the_sub_field('service_name'); ?>"></i>
            <span class="visuallyhidden"><?php the_sub_field('service_name'); ?></span>
		</a>
	<?php } ?>
	</div>
</div>

<?php 
} 

// Keep track of posted news items 
$posted = array();
?>
<div class="full-news-events clearfix">
	<div class="row">
	
	<?php
	// Column 1: 2 news posts, no featured, no images
	$home_col_1_args = array(
		'post_type' => 'post',
		'category__not_in' => '922',
		'posts_per_page' => 2,
		'post_status' => 'publish',
	);
	$wp_query = new WP_Query( $home_col_1_args );
	if ($wp_query->have_posts()): 
	?>
		<div class="columns large-12">
			<h2><a href="/news-events">Latest News</a></h2>
			<a class="more-news show-for-large-up" href="/news-events">More News</a>
		</div>
		</div>
		<div class="home-news-section columns large-12 clearfix">
			<div class="row">
				<div class="columns small-12 medium-4 news-column">
				<?php
				while ( $wp_query->have_posts() ) :
					// Get field vars
					$wp_query->the_post();
					$posted[] = get_the_id();
					if (get_field('story_link_url')) {
						$post_link_url = get_field('story_link_url');
						$post_link_target = 'target="_blank"';
			            $post_link = '<p><a class="button" href="' . $post_link_url . '"' . $post_link_target . '>' . get_field('story_source_name') . '</a></p>';
			        } else {
			        	$post_link_url = get_the_permalink();
			            $post_link = '<a class="button left" href="' . $post_link_url . '">Read more</a>';
			        }
			        $terms = wp_get_post_terms(get_the_id(), 'category');
		    	    if ( !empty($terms) ) {
						$terms_list = array();
						foreach ( $terms as &$term ) {
							if ( $term->slug != 'uncategorized' ) {
								$terms_list[] = '<li><a href="/news-events/?tax=category&amp;term=' . $term->slug . '">' . $term->name . '</a></li>';
							}
						}
					} else {
						$terms_list = '';
					}
					?>

					<div class="small-news col-1">
						<h3><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>

				        <span class="show-for-medium-up"><?php strip_tags(the_advanced_excerpt('length=30&finish=sentence'),''); ?></span>

				        <div class="post-meta clearfix row show-for-medium-up">
			                <time class="article__time columns small-12 medium-5 left" datetime="<?php echo get_the_date('Y-m-d h:i:s'); ?>"><?php echo get_the_date( 'M j, Y' ); ?></time>
			               	<?php if ( !empty($terms ) ) { ?> 
							<ul class="terms right columns small-12 medium-7 right text-right">
								<?php echo implode(", ", $terms_list); ?>
				            </ul>
				            <?php } ?>
				        </div>
				    </div>

				<?php endwhile;?>
				<?php wp_reset_postdata(); ?>

				</div>
				<div class="columns small-12 medium-4 news-column">

				<?php
				// Column 2: 1 featured news post with photo, or 2 posts, no featured, no photo.
				$home_col_2_args = array(
					'post_type' => 'post',
					'category__in' => '922',
					'posts_per_page' => 1,
					'post_status' => 'publish',
				);
				$wp_query = new WP_Query( $home_col_2_args );
				if ( $wp_query->have_posts() ) {
					while ( $wp_query->have_posts() ) :
					$wp_query->the_post();
					$posted[] = get_the_id();
					if ( get_field( 'story_link_url' ) ) {
						$post_link_url = get_field('story_link_url');
						$post_link_target = 'target="_blank"';
		            	$post_link = '<p><a class="button" href="' . $post_link_url . '"' . $post_link_target . '>' . get_field('story_source_name') . '</a></p>';
		        	} else {
		        		$post_link_url = get_the_permalink();
		            	$post_link = '<a class="button left" href="' . $post_link_url . '">Read more</a>';
		        	}
	            	$terms = wp_get_post_terms(get_the_id(), 'category');
					if ( !empty($terms) ) {
						$terms_list = array();
						foreach ( $terms as &$term ) {
							if ( $term->slug != 'uncategorized' ) {
								$terms_list[] = '<li><a href="/news-events/?tax=category&amp;term=' . $term->slug . '">' . $term->name . '</a></li>';
							}
						}
					} else {
						$terms_list = '';
					}
					?>

					<div class="small-news col-2">
						<?php if ( has_post_thumbnail() ) { ?>
						<div class="featured-thumbnail show-for-medium-up" >
							<a href="<?php echo $post_link_url; ?>" class="img" <?php echo $post_link_target; ?>><?php echo the_post_thumbnail( 'news_medium' ); ?></a>
						</div>
						<?php } ?>
						<h3><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
				        <span class="show-for-medium-up"><?php strip_tags( the_advanced_excerpt( 'length=30&finish=sentence' ),'' ); ?></span>
				       <div class="post-meta clearfix row show-for-medium-up">
			                <time class="article__time columns small-12 medium-5 left" datetime="<?php echo get_the_date('Y-m-d h:i:s'); ?>"><?php echo get_the_date( 'M j, Y' ); ?></time>
			               	<?php if ( !empty($terms ) ) { ?> 
							<ul class="terms right columns small-12 medium-7 right text-right">
								<?php echo implode (", ", $terms_list); ?>
				            </ul>
				            <?php } ?>
				        </div>
				    </div>
				<?php
				endwhile;
				wp_reset_postdata();
				} else {
				wp_reset_postdata();
				$home_col_2_nofeature_args = array(
					'post_type' => 'post',
					'category__not_in' => '922',
					'post__not_in' => $posted,//$posted,
					'posts_per_page' => 2,
					'post_status' => 'publish',
				);
				$wp_query = new WP_Query( $home_col_2_nofeature_args );
				while ( $wp_query->have_posts() ) :
					// Get field vars
					$wp_query->the_post();
					$posted[] = get_the_id();
					if (get_field('story_link_url')) {
						$post_link_url = get_field('story_link_url');
						$post_link_target = 'target="_blank"';
			            $post_link = '<p><a class="button" href="' . $post_link_url . '"' . $post_link_target . '>' . get_field('story_source_name') . '</a></p>';
			        } else {
			        	$post_link_url = get_the_permalink();
			            $post_link = '<a class="button left" href="' . $post_link_url . '">Read more</a>';
			        }
			        $terms = wp_get_post_terms(get_the_id(), 'category');
		    	    if ( !empty($terms) ) {
						$terms_list = array();
						foreach ( $terms as &$term ) {
							if ( $term->slug != 'uncategorized' ) {
								$terms_list[] = '<li><a href="/news-events/?tax=category&amp;term=' . $term->slug . '">' . $term->name . '</a></li>';
							}
						}
					} else {
						$terms_list = '';
					}
					?>

					<div class="small-news col-1">
						<h3><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>

				        <span class="show-for-medium-up"><?php strip_tags(the_advanced_excerpt('length=30&finish=sentence'),''); ?></span>

				        <div class="post-meta clearfix row show-for-medium-up">
			                <time class="article__time columns small-12 medium-5 left" datetime="<?php echo get_the_date('Y-m-d h:i:s'); ?>"><?php echo get_the_date( 'M j, Y' ); ?></time>
			               	<?php if ( !empty($terms ) ) { ?> 
							<ul class="terms right columns small-12 medium-7 right text-right">
								<?php echo implode(", ", $terms_list); ?>
				            </ul>
				            <?php } ?>
				        </div>
				    </div>
				<?php
				endwhile;
				} 
				?>
				<?php wp_reset_postdata(); ?>

				</div>
				<div class="columns small-12 medium-4 news-column">
				<?php
					?>
					<?php //if ( !empty( $events ) ) { ?>
					<section class="events clearfix">
						<header>
							<h3><a href="/news-events/events/">Events</a></h3>
						</header>
						<?php the_widget('CoEnv_Widget_Events', 'feed_url=https://www.trumba.com/calendars/sea_fish.rss&posts_per_page=4&'); ?>
						<footer><a class="more-events right" href="/news-events/events/">More Events</a></footer>
					</section>
				</div>
				
				<?php endif; ?>

				</div>
			</div>
		</div>
	</div>
</div>
<a href="#" class="back-to-top">Back to Top</a>
<?php do_action('foundationPress_after_content'); ?>
</div>
<?php wp_reset_postdata(); wp_reset_query(); //roll back query vars to as per the request ?>
</div>
</div>
<?php get_footer(); ?>