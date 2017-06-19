<?php
/*
  Template Name: Journal
*/

?>
<?php get_header(); ?>
<div class="journal" id="main-col">
    <?php while (have_posts()) : the_post(); ?>
        <article <?php post_class() ?> id="post-<?php the_ID(); ?>" class="template-page">
            <div class="intro-content">
                <div class="row">
                    <div class="small-12 columns">
                        <?php echo get_field('intro'); ?>
                        <?php echo do_shortcode('[qrc_journal]'); ?>
                    </div>
                </div>
            </div>
            <div class="entry-content">
                <div class="row">
                    <div class="small-12 medium-8 columns">
                        <?php the_content(); ?>
                        <?php if ( is_active_sidebar( 'after-content' ) ) : ?>
                            <div id="after-content" class="before-content widget-area" role="complementary">
                                <?php dynamic_sidebar( 'after-content' ); ?>
                            </div><!-- #after-content -->
                        <?php endif; ?> 
                    </div>
                    <div class="journal-sidebar small-12 medium-4 columns">
                        <?php
                        $ancestor_id = coenv_base_get_ancestor('ID');
                        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar( $ancestor_id )):

                            dynamic_sidebar( $ancestor_id );
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </article>
    <?php endwhile;?>
</div>
<?php get_footer(); ?>
