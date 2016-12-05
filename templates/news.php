<?php
/*
Template Name: News
*/

/*
 * Query variables
 */

// keep track of whether or not this is the index page
$filtered = false;

// Dates
if(isset($wp_query->query_vars['coenv-year'])) {
    $coenv_year = (int) urlencode(htmlentities($wp_query->query_vars['coenv-year']));
    $coenv_month = (int) urlencode(htmlentities($wp_query->query_vars['coenv-month']));

    // Month needs an offset because php and WordPress calculate dates differently.
    $coenv_date = date('F Y',mktime(10,0,0,$coenv_month+1,0,$coenv_year));
    $filtered = true;
} else {
    $coenv_year = $coenv_month = $coenv_date = null;
}

//Categories
if(isset($wp_query->query_vars['category'])){
    $coenv_cat_term_1 = urlencode(htmlentities($wp_query->query_vars['category']));
    $coenv_cat_term_1_arr = get_term_by('slug',$coenv_cat_term_1,'category');
    $coenv_cat_term_1_val = $coenv_cat_term_1_arr->name;
    $filtered = true;
} else {
    $coenv_cat_1 = $coenv_cat_term_1 = null;
}
?>

<?php get_header(); ?>
<div class="row">
    <div class="small-12 medium-8 columns" role="main" id="main-col">
        <div class="entry-content">
        <h1 class="article__title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
        <div class="row filters">
            <div class=" large-6 columns" data-url="<?php the_permalink() ?>" data-cat="blog_category">
                <?php coenv_base_cat_filter('category', $coenv_cat_term_1); // Category filter ?>
            </div>
            <div class=" large-6 columns" data-url="<?php the_permalink() ?>" data-cat="blog_category">
                <?php coenv_base_date_filter('post',$coenv_month,$coenv_year); // Date filter ?>
            </div>
        </div>
        <hr>
        <?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $sticky = get_option('sticky_posts');

        /**
         * Featured (Sticky) post
         */

        if($paged <= 1 && $filtered == false) {
        $featured_args = array(
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'post_type' => 'post',
            'post__in' => $sticky
        );
        $featured_query = new WP_Query($featured_args);
            if($featured_query->have_posts()) {
                while($featured_query->have_posts()) { 
                    $featured_query->the_post();
                ?>
                    <article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>> 
                        <?php
                        if (get_field('story_link_url')) {
                            $post_link_url = get_field('story_link_url');
                            $post_link_target = ' target="_blank" ';
                            $post_link = '<p><a class="button full_button" href="' . $post_link_url . '"' . $post_link_target . '>' . get_field('story_source_name') . '</a></p>';
                        } else {
                            $post_link_url = get_the_permalink();
                            $post_link = '<a class="button full_button" href="' . $post_link_url . '">Read more</a>';
                        }   
                        if(has_post_thumbnail()) {
                            $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumb' );
                            $alt = get_post_meta(get_post_thumbnail_id( get_the_ID() ), '_wp_attachment_image_alt', true);
                            echo '<div class="featured-thumbnail">';
                                echo '<a href="' . $post_link_url . '" class="img"' . $post_link_target . '>';
                                    echo '<img src="' . $thumbnail[0] . '" class="feature-img" alt="' . $alt . '" />';
                                echo '</a>';
                            echo '</div>';
                        }   
                        ?>  

                        <header class="article__header">
                            <div class="article__meta">
                                <div class="post-info">
                                    <time class="article__time" datetime="<?php echo get_the_date('Y-m-d h:i:s') ?>"><?php echo get_the_date('M j, Y') ?></time>
                                    <?php $categories = get_the_category_list(' ') ?>
                                    <?php if ( $categories ) : ?>
                                        <div class="article__categories">
                                            | <?php echo $categories ?>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                            <h1 class="article__title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h1>

                        </header>

                        <section class="article__content">
                            <?php the_advanced_excerpt('length=30&finish=sentence') ?>
                            <?php echo $post_link; ?>
                        </section>
                        <?php remove_filter( 'the_title', 'wptexturize' );
                        remove_filter( 'the_excerpt', 'wptexturize' ); ?>

                    </article>
                <?php
                }
            }
        }
        /**
          * News loop
          */
        $query_args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 3,
            'post__not_in' => $sticky,
            'ignore_sticky_posts' => 1,
            'paged' => $paged
        );

        // Category filter
        if($coenv_cat_term_1) :
            $query_args['taxonomy'] = 'category';
            $query_args['term'] = $coenv_cat_term_1;
            unset($query_args['post__not_in']); // if filtering, we want to let sticky posts in
        endif;

        // Date filters
        if ($coenv_year) {
            $query_args['year'] = $coenv_year;
            unset($query_args['post__not_in']);
        }
        if($coenv_month) {
            $query_args['monthnum'] = $coenv_month;
            unset($query_args['post__not_in']);
        }

        $wp_query = new WP_Query( $query_args );
        ?>

        <?php if ($wp_query->have_posts()):
        ?>
        <?php if ($coenv_cat_term_1): // Category filter ?>
        <div class="panel">
            <div class="left"><?php echo $wp_query->found_posts; ?> posts in <strong><?php echo $coenv_cat_term_1_val; ?></strong></div>
            <div class="right"><a href="<?php echo the_permalink(); ?>">all posts &raquo;</a></div>
        </div>
        <?php endif; ?>
        <?php if($coenv_year && $coenv_month): // Date filter ?>
        <div class="panel">
            <div class="left"><?php echo $wp_query->found_posts; ?> posts from <strong><?php echo $coenv_date; ?></strong></div>
            <div class="right"><a href="<?php echo the_permalink(); ?>">all posts &raquo;</a></div>
        </div>
        <?php endif; ?>
        <?php
        # The Loop
        while ( $wp_query->have_posts() ) :
        $wp_query->the_post();
        $terms = wp_get_post_terms( get_the_ID(), 'category');
        echo '<div class="blog clearfix">';
        get_template_part( 'partials/partial', 'article' );
        ?>
        </div>
    <?php endwhile; ?>
    <div class="pager">
    <?php if ( function_exists('FoundationPress_pagination') ) { FoundationPress_pagination(); } else if ( is_paged() ) { ?>
        <nav id="post-nav">
            <div class="post-previous"><?php //next_posts_link( __( '&larr; Older posts', 'FoundationPress' ) ); ?></div>
            <div class="post-next"><?php //previous_posts_link( __( 'Newer posts &rarr;', 'FoundationPress' ) ); ?></div>
        </nav>
    <?php } ?>
    </div>
    <?php else: ?>
    <p>We're sorry. Your crtieria did not match any posts. <a href="/about/news">Return to all posts &raquo;</a></p>
    <?php endif; ?>
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
<?php wp_reset_postdata(); wp_reset_query(); ?>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
