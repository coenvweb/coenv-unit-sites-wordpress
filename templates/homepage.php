<?php
/*
Template Name: Homepage
*/
?>
<?php get_header(); ?>
<div class="row feature-row">
	<div class="small-12 large-12" role="main" id="main-col">
	
	<?php do_action('foundationPress_before_content'); ?>
	<?php dynamic_sidebar("before-content"); ?>
        <div class="playpause"></div>
        <div class="homepage-features">
		<?php
        $heroes = get_field('hero_slider');
        if($heroes) {
            foreach($heroes as $hero) { 
            ?>
                <div class="feature">
                <div class="feature-image" style="background-image:url(<?php echo wp_get_attachment_url($hero['hero_image']); ?>)">
                </div>
                <?php
                  //  echo wp_get_attachment_image( $hero['hero_image'], 'full', "", array( "class" => "feature-image" ) );
                ?>
                <div class="feature-info-container">
                <div class="feature-info">
                    <div class="feature-content">
                        <?php $buttons = $hero['hero_links'];
                        $done_buttons = '';
                        if( !empty( $buttons ) )  {
                            $first = true;
                            foreach($buttons as $button) {
                                $done_buttons .= '<a class="button white" href="' . $button['hero_link_url'] . '" >' . $button['hero_link_title'] . '</a>';
                                if ( $first ) {
                                    $first_link = $button['hero_link_url'];
                                    $first = false;
                                }
                            }
                            $done_buttons .= ''; 
                        }
                        ?> 
                        <a href="<?php echo $first_link ?>"><h2><?php echo $hero['hero_title']; ?></h2></a>
                        <p class="feature-excerpt"><?php echo $hero['hero_description']; ?></p>
                        <?php
                            echo $done_buttons;
                        ?>

                    </div><!-- .feature-content -->

                </div><!-- .feature-info -->

                </div><!-- .feature-info-container -->

            </div>
            <?php
            }
        }
            ?>
        </div>
    </div>
</div>
<?php
$content_areas = get_field('content_areas');
if($content_areas) {
    foreach($content_areas as $content_area) { 
    ?>
        <div class="row <?php echo sanitize_title( $content_area['home_content_title'], 'empty' ) ?> home-content-row">
            <div class="home-content-container large-12 columns">
                <?php
                if( $content_area['home_content_image'] ) {
                    echo '<a href="' . $first_link . '">';
                    echo wp_get_attachment_image( $content_area['home_content_image'], 'thumbnail', "", array( "class" => "home-content-image" ) );
                    echo '</a>';
                }
                ?>
                <div class="home-content">
                    <div class="home-content">
                        <a href="<?php echo $first_link ?>"><h2><?php echo $content_area['home_content_title']; ?></h2></a>
                        <p class="home-content-content"><?php echo $content_area['home_content_content']; ?></p>
                        <?php $buttons = $content_area['home_content_links'];

                        if( !empty( $buttons ) )  {
                            $done_buttons = '<ul class="home-content-links">';
                            $first = true;
                            foreach($buttons as $button) {
                                    $done_buttons .= '<li><a class="button white" href="' . $button['link_url'] . '" >' . $button['link_title'] . '</a></li>';
                                    if ( $first ) {
                                        $first_link = $button['link_url'];
                                        $first = false;
                                    }
                                }
                            $done_buttons .= '</ul>';
                            echo $done_buttons;
                        } ?>
                        


                    </div><!-- .feature-content -->

                </div><!-- .feature-info -->

            </div><!-- .feature-info-container -->

        </div>
    <?php
    }
}
?>
<div class="row">
	<div class="small-12 large-12 columns">
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
            <div>
                <h2 class="large-9 left" style="margin-top: 0; padding-top: 0;">News and Events</h2>
                <a class="button columns large-3 right" href="/news-and-events">More News</a>
            </div>
        <div class="row">
            <?php
            # The Loop
            while ( $wp_query->have_posts() ) :
            $terms = wp_get_post_terms( get_the_ID(), 'blog_category');
            $wp_query->the_post();

            if ( $wp_query->current_post == 0 ) {
                echo '<div class="large-8 columns featured-news">';
                get_template_part( 'partials/partial', 'story' );		
            }
            else {
                echo '<div class="large-4 columns small-news">';
                get_template_part( 'partials/partial', 'story' );
            }

           echo '</div>';
        endwhile;
        ?>
        </div>
    <?php endif; ?>
    <a href="#" class="back-to-top">Back to Top</a>
    <?php do_action('foundationPress_after_content'); ?>
</div>
<?php wp_reset_postdata(); wp_reset_query(); //roll back query vars to as per the request ?>
</div>
</div>
<?php get_footer(); ?>