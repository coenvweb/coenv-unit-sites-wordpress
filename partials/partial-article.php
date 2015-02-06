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
				<?php $categories = get_the_category_list(' ') ?>
				<?php if ( $categories ) : ?>
				<div class="article__categories">
					| <?php echo $categories ?>
				</div>
			</div>
 			<?php endif ?> 
        </div>
		<?php endif ?>

	</header>

	<section class="article__content">
		<?php the_content() ?>
	</section>
    <?php remove_filter( 'the_title', 'wptexturize' );
    remove_filter( 'the_excerpt', 'wptexturize' ); ?>

</article><!-- .article -->
