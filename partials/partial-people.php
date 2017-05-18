<?php  

/**
 * People fields
 */
$people_fields = get_fields();
?>
<article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>
	<header class="article__header">
		<div class="people-title">
			<h1 class="article__title">
			<?php if ( is_page() || is_single()) : ?>
				<?php the_title() ?>
			<?php else : ?>
				<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a>
			<?php endif ?>
			</h1>	
		</div>
	</header>
	<section class="article__content">
	</section>
</article><!-- .article -->
