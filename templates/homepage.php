<?php
/*
Template Name: Homepage
*/
?>
<?php get_header(); ?>
<div role="main" id="main-col">
	
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
<div class="hero">
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

		echo '<div class="feature-info-container row">';
		echo '<p class="feature-image-caption right">' . $feature_caption . '</p>';
if($rows)
					{
						foreach($rows as $row) {
                    $link_title =  $row['feature_link_to_a_page_on_this_site'][0]['feature_link_title_internal'];
                    $link_url = get_permalink($row['feature_link_to_a_page_on_this_site'][0]['feature_select_page'][0]);
                    $link_target = 'self';
						}
					}
                echo '<div class="feature-info">';
			echo '<div class="feature-content">';
				echo '<a href="' . $link_url . '"><h2 class="feature-title"><span class="feature-white">' . get_the_title() . '</span></h2></a>';
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
            <h2>News & Stories</h2>
        </a>
    </div>
    <div class="news-stories" data-equalizer>
    <?php
        # Student/Alumni Spotlight or Research/Faculty Spotlight

        $sticky = get_option( 'sticky_posts' );
        $sticky_count = count($sticky);
        $posts_on_home = 1; //set posts_per_page here

        $home_args = array(
            'post_type' => 'post',
            'posts_per_page' => $posts_on_home - $sticky_count,
            'post_status' => 'publish',
            'cat' => '136, 137',
        );

        $wp_query = new WP_Query( $home_args );
        ?>
        <?php if ($wp_query->have_posts()): ?>
		<div class="medium-6 columns">
            <div class="white-container" data-equalizer-watch>
                <?php
                while ( $wp_query->have_posts() ) :
                $wp_query->the_post();
                    $feature_post = get_the_ID();
                    if(in_category(136)) { ?>
                        <a name="More student & alumni stories" class="fake-cat button left" href="/news-stories/category/student-spotlight/">Student Spotlights</a>
                    <?php } ?>
                    <?php if(in_category(137)) { ?>
                        <a name="More research news" class="fake-cat button left" href="/news-stories/category/research-faculty-spotlight/">Research News</a>
                    <?php }
                    # The Loop
                    if (get_field('story_link_url')) {
                        $post_link_url = get_field('story_link_url');
                        $post_link_target = ' target="_blank" ';
                        $post_link = '<p><a class="read-more button" href="' . $post_link_url . '"' . $post_link_target . '>' . get_field('story_source_name') . '</a></p>';
                    } else {
                        $post_link_url = get_the_permalink();
                        $post_link_target = '';
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
        # News Feed

        $posts_on_home = 3; //set posts_per_page here

        $home_args = array(
            'post_type' => 'post',
            'posts_per_page' => $posts_on_home,
            'post_status' => 'publish',
            'post__not_in' => array($feature_post),
        );

        $wp_query = new WP_Query( $home_args );
        ?>
        <?php if ($wp_query->have_posts()): ?>
            <div class="medium-6 columns" style="margin-top: 0; padding-top: 0;">
                <div class="home-post" data-equalizer-watch>
                    <?php
                    # The Loop
                    while ( $wp_query->have_posts() ) :
                        $wp_query->the_post();
						$rows = get_field('blog_link');
                        $terms = wp_get_post_terms( get_the_ID(), 'category');
                        if (get_field('story_link_url')) {
                            $post_link_url = get_field('story_link_url');
                            $post_link_target = ' target="_blank" ';
                            $post_link = '<p><a class="read-more button left" href="' . $post_link_url . '"' . $post_link_target . '>' . get_field('story_source_name') . '</a></p>';
                        } else {
                            $post_link_url = get_the_permalink();
                            $post_link = '<a class="read-more button left" href="' . $post_link_url . '">Read more</a>';
                        }
						?>
						<div class="blog-list-item clearfix">
						<!--
							<div class="share right" data-article-id="<?php the_ID(); ?>" data-article-title="<?php //echo get_the_title(); ?>"
							data-article-shortlink="<?php //echo wp_get_shortlink(); ?>"
							data-article-permalink="<?php //echo the_permalink(); ?>"><a href="#"><i class="fi-share"></i>Share</a>
							</div>
							-->
							

							<?php
								echo '<h3><a href="' . $post_link_url . '"' . $post_link_target . '>' . get_the_title() . '</a></h3>';
                                if(has_excerpt()) {
                                    
                                    echo '<p>'.get_the_excerpt().'</p>';
                                } else {
                                    echo the_advanced_excerpt('length=5&finish=sentence');
                                }
								echo $post_link;
							'</div>';
                            ?>
                            <div class="news-meta">
								<div class="blog-meta small-8 columns right">
									<?php
										echo '<p><span class="time">' . get_the_date('M j, Y');
												$terms = wp_get_post_terms( get_the_ID(), 'category');
												$termlist = '';
												foreach ($terms as $term) {
													$termlist .= '<a href="/news-stories/category/' . $term->slug . '">' . $term->name . '</a>, ';
												}
												$termlist = rtrim($termlist,', ');
												if (strpos($termlist,'uncategorized') == false)  {
													echo '</span>  | ' . $termlist;
												}
										?>
									</p>
								</div>
							</div>
                            <?php
							echo '<div class="blog-links right">';
							if($rows) {
								foreach($rows as $row) {
									if($row['blog_link_type'] == 'upload') {
										echo '<a class="button" href="' . $row['blog_upload_file'] . '" target="_blank">' . $row['blog_file_link_text'] . '</a>';
									} elseif ($row['blog_link_type'] == 'link') {
										echo '<a class="button" href="' . $row['blog_link_url'] . '" target="_blank">' . $row['blog_link_text'] . '</a>';
									}
								}
							} ?>
							</div>
						</div>
				<?php
                    endwhile;
                ?>
                </div>
            </div>
    <?php endif; ?>
    </div>
</div>

<div class="row events" style="min-height: 200px;">
<?php
	$ctx = stream_context_create(array('http'=>
		array(
			'timeout' => 3,  //1200 Seconds is 20 Minutes
		),
        'ssl' => array('verify_peer' => false, 'verify_peer_name' => false),
	));
    $events_xml = file_get_contents('https://www.trumba.com/calendars/sea_marinebio.rss', false, $ctx );
	$xml = new SimpleXmlElement($events_xml);
    $events = array();

    foreach ($xml->channel->item as $item) {
      $events[] = array(
        'title' => $item->title,
        'date'  => $item->category,
        'url' => $item->link
      );
    }
	if(!empty($events)) {
?>

    <a href="/news-stories/events" id="More Events"><?php include(get_template_directory() . "/assets/img/events-icon.svg"); ?></a>
    <a href="/news-stories/events" class="more hide-for-small-only" id="More Events">More Events <?php include(get_template_directory() . "/assets/img/circle-arrow-icon.svg"); ?></a>
    <a href="/news-stories/events" id="More Events"><h2>Events</h2></a>
    <div class="list columns large-12">
        <?php the_widget('CoEnv_Widget_Events', 'feed_url=https://www.trumba.com/calendars/sea_marinebio.rss&posts_per_page=3'); ?>
    </div>      
<?php 
	}
?>
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
