<?php
/**
 * The home page template
 */
get_header();

// Get all home page features
$features = new WP_Query( array(
    'post_type' => 'feature',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC'
) );

?>

    <?php wp_reset_postdata() ?>

    <div class="container">

    <?php if ( $features->have_posts() ) : ?>

        <section id="features">
        <?php wp_reset_postdata() ?>

        <?php get_sidebar() ?>
            <div class="features-container">

                <?php while ( $features->have_posts() ) : $features->the_post() ?>

                    <?php get_template_part( 'partials/partial', 'feature' ) ?>

                <?php endwhile  ?>

            </div><!-- .features-container -->

        </section><!-- #features -->

    <?php endif ?>
       


    </div><!-- .container -->

<?php get_footer() ?>