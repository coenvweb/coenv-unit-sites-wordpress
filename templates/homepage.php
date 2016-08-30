<?php
/*
Template Name: Homepage
*/
?>
<?php get_header(); ?>
<div class="container">
<div class="fullwidth hero-area">
    <div class="nav-bar-divider section-div show-for-medium-up">
    </div>
    <?php do_action('foundationPress_before_content'); ?>
        <?php

        /**
         * Loop for homepage features.
         */
        $rows = array();
        $feature_args = array(
            'post_type' => 'features',
            'post_status' => 'publish',
            'posts_per_page' => 4,
            'orderby' => 'menu_order',
            );
        $feature_query = new WP_Query( $feature_args ); ?>
        <div class="row homepage-features">
            <h1 class="columns">Climate Science, Collaboration, and Community</h1>
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
                    echo '<div class="feature-image" style="background-image:url(' . $feature_image[0] . ')">';
                    echo '</div>';

                    echo '<div class="feature-content">';
                        echo '<h2>' . get_the_title() . '</h2>';
                        echo '<p class="feature-excerpt">' . $feature_excerpt . '</p>';

                    echo '</div><!-- .feature-content -->';

                    echo "<hr />";
                echo '</div><!-- .feature -->';
            endwhile;
            wp_reset_postdata();
        echo '</div>';
?>
</div>
<?php if ( is_active_sidebar( 'home-columns' ) ) : ?>
<div class="fullwidth slash">
    <div class="row programs" data-equalizer data-equalizer-mq="large-up">
        <div class="widget-area home-columns">
            <?php dynamic_sidebar( 'home-columns' ); ?>
        </div>
    </div>
</div>
<?php endif; ?>
<div class="row teaser-buttons">
<?php if($rows) {
    $counter = 0;
    foreach($rows as $row) {
        echo '<div class="small-12 medium-6 columns">';
            if($row['feature_link_type'] == 'internal') {
                $link_title =  $row['feature_link_to_a_page_on_this_site'][0]['feature_link_title_internal'];
                $link_url = get_permalink($row['feature_link_to_a_page_on_this_site'][0]['feature_select_page'][0]);
                $link_target = 'self';
            } elseif ($row['feature_link_type'] == 'external') {
                $link_title = $row['feature_link_to_an_external_site'][0]['feature_link_title'];
                $link_url = $row['feature_link_to_an_external_site'][0]['feature_link_url'];
                $link_target ='blank';
            }
            echo '<a href="' . $link_url . '" target="_' . $link_target . '"><div class="'. ($counter ? 'community' : 'learn') .' home_button"> ' . $link_title . '</div></a>';
        echo '</div>';
        $counter++;
    }
}
?>
</div>
<div class="fullwidth camp-divider divider">
    <div class="row">
    </div>
</div>
<div class="row news">
<?php
# News with featured news
# Other News
$sticky = count(get_option('sticky_posts')); 
if ($sticky > 2) {
    $sticky = 2;
} else {
    $sticky = 1;
}
if(!empty($sticky)) {
    $home_args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 3,
        'post__not_in' => get_option('sticky_posts'),
        'orderby' => 'date',
        'order' => 'DESC'
    );
}
else {
    $home_args = array(
        'post_type' => 'post',
        'posts_per_page' => 3,
        'post_status' => 'publish',
    );
}
$wp_query = new WP_Query( $home_args );
?>
    <?php if ($wp_query->have_posts()): ?>
    <div class="home-news-section clearfix">
        <div class="columns large-8 medium-8 left" style="margin-top: 0; padding-top: 0;">
        <div class="home-section-title">
            <h2 class="news-title">News</h2>
            <a class="more-news button full_button" href="/pcc/about/news">More News</a>
        </div>
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
            $post_link = '<a class="button" href="' . $post_link_url . '">Read more</a>';
        }

        echo '<div class="small-news">';
        echo '<div class="post-meta">';
        echo '<time class="article__time" datetime="' . get_the_date('Y-m-d h:i:s') . '">' . get_the_date('M j, Y') . '</time>';
        // Get categories
        $more_terms = wp_get_post_terms(get_the_id(), 'category');
        if (!empty($more_terms)) {
            echo "|";
            $more_terms_arr = array();

            foreach ($more_terms as &$term) {
                if ($term->slug != 'uncategorized') {
                    $more_terms_arr[] = '<a href="/about/news/category/' . $term->slug . '">' . $term->name . '</a>';
                }
            }
            $more_terms_str = implode(', ', $more_terms_arr);

        } else {
            $more_terms_str = '';
        }
        $more_terms = "";
        echo '<div class="post_cat">'.$more_terms_str.'</div>';
        echo '</div>';
        echo '<a href="' . $post_link_url . '"><h4>' . get_the_title() . '</h4></a>';
        echo '<p>' . the_advanced_excerpt('length=30&finish=sentence&') . '</p>';
        echo $post_link;
    echo '</div>';
    endwhile;
    ?>
    </div>
<?php endif; ?>
<?php if( is_active_sidebar('homepage-twitter') ) { ?>
    <div class="large-4 medium-4 columns">
        <?php dynamic_sidebar('homepage-twitter'); ?>
    </div>
<?php } ?>
</div>  
</div>  
<div class="fullwidth divider cave-divider">
    <div class="row">
    </div>
</div>
<?php if ( is_active_sidebar( 'hosted-events' ) ) : ?>
<div class="fullwidth slash">
    <div class="row hosted-events" data-equalizer data-equalizer-mq="large-up">
        <div class="columns">
            <h2>Program on Climate Change Events</h2>
            <hr>
            <div class="widget-area home-columns">
                <?php dynamic_sidebar( 'hosted-events' ); ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>    
<div class="row climate-calendar">
    <div class="columns">
        <div class="home-section-title">
            <h2 class="events-title"><div class="calendar"></div>Climate Calendar</h2>
            <a href="/events" id="more_events" class="more-events button full_button" >More Events</a>
        </div>
        <?php the_widget('CoEnv_Widget_Events', 'feed_url=http://www.trumba.com/calendars/sea_pcc.rss&posts_per_page=3'); ?>
    </div>
</div>
</div>
</div>

<a href="#" class="back-to-top">Back to Top</a>
<?php do_action('foundationPress_after_content'); ?>
</div>
</div>
<?php wp_reset_postdata(); wp_reset_query(); //roll back query vars to as per the request ?>
<?php get_footer(); ?>
