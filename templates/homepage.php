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
                <div class="feature-image" style="background-image:url(<?php echo $hero['hero_image']; ?>)">
                </div>
                <div class="feature-info-container">
                <div class="feature-info" style="background-color:' . $feature_color . '">
                    <div class="feature-content">
                        <h2><?php echo $hero['hero_title']; ?></h2>
                        <p class="feature-excerpt"><?php echo $hero['hero_description']; ?></p>
                        <a class="button" href="<?php echo $hero['hero_link_url']; ?>"><?php echo $hero['hero_link_title']; ?></a>

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
<div class="row">
	<div class="small-12 large-12 columns">
<?php 
# Widget area for content blocks
if ( is_active_sidebar( 'home-columns' ) ) : 
?>

<?php dynamic_sidebar( 'home-columns' ); ?>


<?php endif; ?>

				
<?php if ( is_active_sidebar( 'home-content' ) ) : ?>
<div class="large-12 columns programs">
	<div class="widget-area home-content" role="complementary">
		<?php dynamic_sidebar( 'home-content' ); ?>
	</div><!-- .widget-area -->
</div>
<?php endif; ?>

<?php if ( is_active_sidebar( 'after-content' ) ) : ?>
	<?php do_action('foundationPress_after_content'); ?>
	<ul class="widget-area after-content">
	<?php dynamic_sidebar("after-content"); ?>
	</ul>
<?php endif; ?>
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
			<h2 class="columns large-9 left" style="margin-top: 0; padding-top: 0;">News and Events</h2>
			<a class="button columns large-3 right" href="/news-and-events">More News</a>
		</div>
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
<?php endif; ?>
<a href="#" class="back-to-top">Back to Top</a>
<?php do_action('foundationPress_after_content'); ?>
</div>
<?php wp_reset_postdata(); wp_reset_query(); //roll back query vars to as per the request ?>
</div>
</div>
<?php get_footer(); ?>