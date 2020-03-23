<?php
/*
Template Name: Homepage
*/
?>
<?php get_header(); ?>
<div class="home">
<div role="main" id="main-col">
    
    <?php do_action('foundationPress_before_content'); ?>
    <?php dynamic_sidebar("before-content"); ?>
    <?php
        //Hero Area Fields
        $hero_image = get_field('hero_image');
        $hero_text = get_field('hero_text');
        $hero_buttons = get_field('hero_buttons');

    ?>

    <div class="hero">
        <div class="small-12 large-12 columns">
            <div class="feature homepage-hero-module">
            <div class="feature-image video-container">
            <div class="filter"></div>
            <video autoplay loop muted class="fillWidth fullfade show-for-medium-up" id="hero-video" poster="<?php echo get_bloginfo('template_directory'); ?>/assets/video/static.jpg">
                <source src="<?php echo get_bloginfo('template_directory'); ?>/assets/video/marbio-video.mp4" type="video/mp4" />Your browser does not support the video tag. I suggest you upgrade your browser.
                <!--<source src="/wp-content/themes/coenv-fhl/assets/video/Mp4/FHL Looper Lab Final_1.webm" type="video/webm" />Your browser does not support the video tag. I suggest you upgrade your browser.
                <source src="/wp-content/themes/coenv-fhl/assets/video/Mp4/FHL Looper Lab Final_1.ogg" type="video/ogg"/>Your browser does not support the video tag. I suggest you upgrade your browser.-->
            </video>
            <div class="poster show-for-small-only">
                <img src="<?php echo get_bloginfo('template_directory'); ?>/assets/video/static.jpg" alt="">
            </div>

                        <div class="feature-info-container">
                            <div class="play-pause-hero right show-for-medium-up"></div>
                            <div class="feature-info row">
                                <div class="feature-content">
                                    <h2 class="feature-title"><span class="feature-white"><?=$hero_text?></span></h2>
                                    <?php
                                    if($hero_buttons) {
                                        foreach($hero_buttons as $button) {
                                            echo '<a class="button" href="' . $button['button']['url'] . '">' . $button['button']['title'] . '</a>';
                                        }
                                    }
                                    ?>
                                </div><!-- .feature-content -->
                            </div><!-- .feature-info -->
                        </div><!-- .feature-info-container -->
                    </div>
                </div><!-- .feature -->
            </div>
        </div>
    </div>
<div class="about-summary">
    <div class="row">
        <div class="summary columns large-12">
            <div class="widget widget_custom_post_widget">
                <div class="widget_content">
                    <p style="text-align:center;">
                        <?=get_field('intro_statement');?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
	<?php if(get_field('enable_announcement') && get_field('announcement') && get_field('announcement_placement') == 'top') { ?>
		<div class="special-announcement columns large-12">
			<div class="white-container">
				<h4 class="announcement-title">Announcement</h4>
				<?php the_widget('custom_post_widget', 'custom_post_id='.get_field('announcement')); ?>
			</div>
		</div>
	<?php } ?>
    <div class="tiles">
        <?php
            $tiles = get_field('tiles');
            foreach($tiles as $tile) {
        ?>
            <a href="<?=$tile['link']?>" id="" class="program">
                <div class="columns large-6 tile" style="background-image: url(<?=$tile['image']['url']?>);">
                    <div class="tile-text">
                        <h3><?=$tile['text']?></h3>
                        <p><?=$tile['description']?></p>
                    </div>
                </div>
            </a>
        <?php } ?>
    </div>
                
    <?php /* Unreadable ATM - needs refactor */ ?>
    <div class="news">
        <div class="row">
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
            
            if ( $sticky ) {
                $home_args = [
                    'post_type'           => 'post',
                    'post__in'            => $sticky,
                    'posts_per_page'      => 2,
                    'ignore_sticky_posts' => 1
                ];

            $wp_query = new WP_Query( $home_args );
            ?>
            <?php if ($wp_query->have_posts()): ?>
            <div class="medium-6 columns">
                <div class="white-container" data-equalizer-watch>
                    <?php
                    while ( $wp_query->have_posts() ) :
                    $wp_query->the_post();
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
            <?php endif; 
            };
            ?>

            <?php
            # News Feed

            $posts_on_home = 2; //set posts_per_page here

            $home_args = array(
                'post_type' => 'post',
                'posts_per_page' => $posts_on_home,
                'post_status' => 'publish',
                'post__not_in' => $sticky,
                'category_name' => 'featured'
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
                                $post_link_target = ' target="" ';
                            }
                            ?>
                            <div class="blog-list-item clearfix">
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
        <?php
            wp_reset_postdata();
            wp_reset_query();
        ?>

        
        <?php if(get_field('enable_announcement') && get_field('announcement') && get_field('announcement_placement') == 'bottom') { ?>
            <div class="special-announcement columns large-12">
                <div class="white-container">
                    <h4 class="announcement-title">Announcement</h4>
                    <?php the_widget('custom_post_widget', 'custom_post_id='.get_field('announcement')); ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>


    

    <?php
        $events_feed = get_field('events_feed');
        $ctx = stream_context_create(array('http'=>
            array(
                'timeout' => 3,  //1200 Seconds is 20 Minutes
            ),
            'ssl' => array('verify_peer' => false, 'verify_peer_name' => false),
        ));
        $events_xml = file_get_contents($events_feed, false, $ctx );
        $xml = new SimpleXmlElement($events_xml);
        $events = array();

        foreach ($xml->channel->item as $item) {
          $events[] = array(
            'title' => $item->title,
            'date'  => $item->category,
            'url' => $item->link
          );
        }
        ?>
    <div class="events">
        <div class="row" style="min-height: 200px;">
            <?php if(!empty($events)) { ?>
                <a href="/news-stories/events" id="More Events"><?php include(get_template_directory() . "/assets/img/events-icon.svg"); ?></a>
                <a href="/news-stories/events" class="more hide-for-small-only" id="More Events">More Events <?php include(get_template_directory() . "/assets/img/circle-arrow-icon.svg"); ?></a>
                <a href="/news-stories/events" id="More Events"><h2>Events</h2></a>
                <div class="list columns large-12">
                    <?php the_widget('CoEnv_Widget_Events', 'feed_url='.$events_feed.'&posts_per_page='.get_field("num_events")); ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="adviser">
        <div class="row">
            <div class="columns large-12">
                <?php the_widget('custom_post_widget', 'custom_post_id='.get_field('adviser_block').'&show_featured_image=true'); ?>
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
</div>
<?php wp_reset_postdata(); wp_reset_query(); //roll back query vars to as per the request ?>
</div>
</div>
</div>
<?php get_footer(); ?>
