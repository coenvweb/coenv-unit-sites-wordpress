<?php  
/**
 * An individual article
 */
?>
<article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>

	<header class="article__header">
        <div class="article__meta">
            <?php if ( !is_page() ) : ?>
			<div class="post-info">
				<time class="article__time" datetime="<?php echo get_the_date('Y-m-d h:i:s') ?>"><?php echo get_the_date('M j, Y') ?></time>
                <div class="article__categories">
				<?php
                $terms = wp_get_post_terms( get_the_ID(), 'category');
                $termlist = '| ';
                foreach ($terms as $term) {
                    $termlist .= '<a href="' . $url_current . '?tax='. $term->taxonomy . '&term=' . $term->slug . '">' . $term->name . '</a>, ';
                }
                $termlist = rtrim($termlist,', ');
                echo $termlist;
                ?>
                </div>
			</div>
        </div>
		<?php endif ?>
		<?php if ($GLOBALS['post']->post_parent) : ?>
        <?php if ( is_single()) : ?>
            <h1 class="article__title"><?php the_title() ?></h1>
        <?php endif ?>
        <?php endif ?>

	</header>

	<section class="article__content">
		<?php the_content() ?>
	</section>
    <?php remove_filter( 'the_title', 'wptexturize' );
    remove_filter( 'the_excerpt', 'wptexturize' ); ?>

</article><!-- .article -->
