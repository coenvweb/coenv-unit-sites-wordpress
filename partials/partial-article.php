<?php  
/**
 * An individual article
 */
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
    ?>

    <header class="article__header">
        <div class="article__meta">
            <?php if ( !is_page() ) : ?>
                <div class="post-info">
                    <time class="article__time" datetime="<?php echo get_the_date('Y-m-d h:i:s') ?>"><?php echo get_the_date('M j, Y') ?></time> 
                    <?php $categories = get_the_category_list(' ') ?>
                    <?php if ( $categories ) : ?>
                        <div class="article__categories">
                            | <?php echo $categories ?>
                        </div>
                    <?php endif ?>
                </div>
            <?php endif ?>
        </div>
        <?php if ( coenv_base_post_parent(get_the_id())): ?>
            <?php if ( is_page() || is_single()) : ?>
                <h1 class="article__title"><?php the_title() ?></h1>
            <?php else : ?>
                <h1 class="article__title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h1>
            <?php endif ?>
        <?php endif ?>

    </header>

    <section class="article__content">
        <?php
        if(is_single()) {
            the_content();
            if($post_link_target) {
                echo $post_link;
            }
        } else {
             the_advanced_excerpt('length=30&finish=sentence');
             echo $post_link;
        }
        ?>
    </section>
    <?php remove_filter( 'the_title', 'wptexturize' );
    remove_filter( 'the_excerpt', 'wptexturize' ); ?>

</article><!-- .article -->
