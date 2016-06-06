<?php get_header(); ?>
<div class="row page-content" id="main-col">
	<div class="columns small-12" role="main" style="width: 100% !important;">
	<?php do_action('foundationPress_before_content'); ?>
	<?php dynamic_sidebar("before-content"); ?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<div class="entry-content">
				<div class="article__content">
					<form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
					  <div class="field-wrap">
						<label for="s">Search Field</label>
					    <input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="Search this site">
					    <button type="submit"><i class="fi-magnifying-glass"></i><span>Search</span></button>
					  </div>
					</form>
					<?php if ($wp_query->found_posts): ?>
					<div class="panel">
						<div class="left"><?php echo $wp_query->found_posts; ?> results for <strong>"<?php echo get_search_query(); ?>"</strong></div>
					</div>
					<?php endif; ?>
					

				<?php if ( have_posts() ) : ?>
					<div class="search-results">
					<?php while ( have_posts() ) : the_post(); ?>
					
		<h2><a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a></h2>
		<p>
		<?php
		$teaser_limited = get_the_excerpt();
		$teaser_limited = strip_tags($teaser_limited);
		$teaser_limited = trim($teaser_limited, '!,?.&nbsp;');
		echo $teaser_limited . '...';
		?>
		</p>

		<?php endwhile; ?>
	</div>








				<?php 
				endif;
				do_action('foundationPress_before_pagination');
				if ( function_exists('FoundationPress_pagination') ) { FoundationPress_pagination(); } else if ( is_paged() ) {
				?>
					<nav id="post-nav">
						<div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', 'FoundationPress' ) ); ?></div>
						<div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'FoundationPress' ) ); ?></div>
					</nav>
				<?php } ?>

	<?php do_action('foundationPress_after_content'); ?>
			</div>
		</article>
	</div>
</div>
<?php get_footer(); ?>
