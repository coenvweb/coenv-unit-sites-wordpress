<?php if (is_front_page()): ?>
	<article class="story">

		<div class="inner">

			<?php if ( has_post_thumbnail() ) : ?>
				<a href="<?php the_permalink() ?>" class="img">
					<?php the_post_thumbnail( 'medium' ) ?>
				</a>
			<?php endif ?>

			<div class="content">
				<h1><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h1>
				<?php the_excerpt() ?>
	            <a href="<?php the_permalink() ?>" class="button">Read more</a>
			</div>

		</div><!-- .inner -->

	</article>
<?php else: ?>
	<article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>

	<header class="article__header">
        <div class="article__meta">
   		<?php if ( !is_page() ) : ?>
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
                |
                <div class="article__categories">
                     <?php echo implode(', ', $more_terms_arr) ?>
                </div>
            </div>
		<?php endif ?>
		</div>

		<?php if ( is_page() || is_single() ) : ?>
			<h2 class="article__title"><?php the_title() ?></h2>
		<?php else : ?>
			<h2 class="article__title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h2>
		<?php endif ?>

	</header>
	<section class="article__content">
		<div class="coenv-thumb"><a style="float: right;" href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'small' ) ?></a></div>
		<?php if ( get_field('story_link_url') ): ?>
			<?php $trimmed_content = breezer_addDivToImage(get_the_content()); ?>
			<?php $trimmed_content = strip_tags($trimmed_content,'<a>'); ?>
			<?php $trimmed_content = strip_shortcodes ($trimmed_content); ?>
			<?php echo '<p>' . $trimmed_content . '</p>'; ?>
			<a href="<?php the_field('story_link_url'); ?>" class="button" target="_blank"><?php the_field('story_source_name'); ?></a> 
		<?php else: ?>
			<?php $trimmed_content = breezer_addDivToImage(get_the_excerpt()); ?>
			<?php $trimmed_content = strip_tags($trimmed_content,'<a>'); ?>
			<?php $trimmed_content = strip_shortcodes ($trimmed_content); ?>
			<?php echo '<p>' . $trimmed_content . '</p>'; ?>
			<a href="<?php echo the_permalink(); ?>" class="button">Read more</a>
		<?php endif; ?>

	</section>
    <?php remove_filter( 'the_title', 'wptexturize' );
    remove_filter( 'the_excerpt', 'wptexturize' ); ?>

</article><!-- .article -->
<?php endif; ?>
