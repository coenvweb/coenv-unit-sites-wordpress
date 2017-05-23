<?php
/*
Template Name: People Index
*/


get_header();
?>
<div class="row">
    <div class="small-12 medium-8 columns columns" role="main">
        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class() ?> id="post-<?php the_ID(); ?>" class="template-page">
                <?php do_action('foundationPress_page_before_entry_content'); ?>
                <?php get_template_part( 'partials/partial', 'article' ); ?>
                <footer>
                    <?php wp_link_pages( array( 'before' => '<nav id="page-nav"><p>' . __( 'Pages:', 'FoundationPress' ), 'after' => '</p></nav>' ) ); ?>
                    <p><?php the_tags(); ?></p>
                </footer>
            </article>
        <?php endwhile;?>
        
        <div class="people_index">
            <?php

            $people_class = get_terms('classification');

            foreach($people_class as $class) {
                $query_args = array(
                    'post_type' => 'people',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'taxonomy' => 'classification',
                    'term' => $class->name,
                    'meta_key' => 'last_name',
                    'orderby' => 'meta_value',
                    'order' => 'ASC',
                    'meta_query' => array(
                        array(
                            'key'     => 'last_name',
                            'compare' => 'IN',
                        ),
                    ),
                );
                $wp_query = new WP_Query($query_args);
            ?>
                <?php if ($wp_query->have_posts()): ?>
                    <h2 class="classification-head <?=$class->name?>"><?=$class->name?></h2>
                    <ul class="people-list <?=$class->name?>-list small-block-grid-3 medium-block-grid-4 large-block-grid-5">
                        <?php
                        # The Loop
                        while ( $wp_query->have_posts() ) :
                            $wp_query->the_post();
                            $people_img_src = get_the_post_thumbnail_url(null, 'people-grid');
                            $title = get_field('first_name') . ' ' . get_field('last_name');
                            
                            if ( !$people_img_src) {
                                $people_img_src = get_template_directory_uri() . '/assets/img/blank-153x153.jpg';
                            }
                            echo '<li class="people-list-item">';
                                echo '<a href="' . get_the_permalink() . '"><img src="' . $people_img_src . '"" alt="' . $title . '" /></a>';
                                echo '<h3><a href="' . get_the_permalink() . '">' . $title . '</a></h3>';
                            echo '</li>';
                        endwhile;
                        ?>
                    </ul>
                    <ul class="widget-area after-content">
                        <?php dynamic_sidebar( "after-content" ); ?>
                    </ul>
                <?php endif; ?>
                <?php wp_reset_query(); ?>
            <?php } ?>
        </div>
    </div>
    <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
