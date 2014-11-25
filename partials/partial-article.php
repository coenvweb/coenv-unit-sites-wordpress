<?php  
/**
 * An individual article
 */
?>
<article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>

	<header class="article__header">
        <div class="article__meta">
			<div class="share right" data-article-id="<?php the_ID(); ?>" data-article-title="<?php echo get_the_title(); ?>"
			data-article-shortlink="<?php echo wp_get_shortlink(); ?>"
			data-article-permalink="<?php echo the_permalink(); ?>"><a href="#"><i class="fi-share"></i>Share</a>
            </div>
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
		<?php //if ( coenv_base_post_parent(get_the_id())): ?>
		<?php if ( is_page() || is_single()) : ?>
			<h1 class="article__title"><?php the_title() ?></h1>
		<?php else : ?>
			<h1 class="article__title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h1>
		<?php endif ?>
		<?php //endif ?>

	</header>

	<section class="article__content">

		<?php the_content() ?>
		<?php if ( get_field('story_link_url') ): ?> 
	 		<a href="<?php the_field('story_link_url'); ?>" class="button" target="_blank"><?php the_field('story_source_name'); ?> »</a> 
		<?php endif; ?>
	</section>
    <?php remove_filter( 'the_title', 'wptexturize' );
    remove_filter( 'the_excerpt', 'wptexturize' ); ?>

</article><!-- .article -->