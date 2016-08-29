<?php  
/**
 * An individual article
 */
?>
<article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>
	<header class="article__header">
        <?php if ( !is_page() ) : ?>
            <div class="article__meta">
                <div class="post-info">
                    <time class="article__time" datetime="<?php echo get_the_date('Y-m-d h:i:s') ?>"><?php echo get_the_date('M j, Y') ?></time> 
                    <?php
                        $more_terms = wp_get_post_terms(get_the_id(), 'category');
                        if (!empty($more_terms)) {
                            $more_terms_arr = array();

                            foreach ($more_terms as &$term) {
                                if ($term->slug != 'uncategorized') {
                                    $more_terms_arr[] = '<a href="/about/news/category/' . $term->slug . '">' . $term->name . '</a>';
                                }
                            }
                        }
                    ?>
                    <div class="article__categories">
                        | <?php echo implode(', ', $more_terms_arr) ?>
                    </div>
                </div>
            </div>
		<?php endif ?>		
        <?php if ( is_page() || is_single()) : ?>
			<h1 class="article__title"><?php the_title() ?></h1>
		<?php else : ?>
			<h1 class="article__title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h1>
		<?php endif ?>
	</header>

	<section class="article__content">
		<?php the_content() ?>
	</section>
    <?php remove_filter( 'the_title', 'wptexturize' );
    remove_filter( 'the_excerpt', 'wptexturize' ); ?>

</article><!-- .article -->
