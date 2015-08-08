<?php get_header(); ?>
<div class="row">
	<div class="section-title">News &amp; Events</div>
	<div class="breadcrumbs"><?php bcn_display(); ?></div>
	<div class="small-12 medium-8 columns" role="main">
		<h1 class="article__title">News</h1>
		<?php dynamic_sidebar("before-content"); ?>

		
	<?php if ( have_posts() ) : ?>
		
		<?php do_action('foundationPress_before_content'); ?>

				<?php while ( have_posts() ) : the_post() ?>

					<?php get_template_part( 'partials/partial', 'story' ) ?>

				<?php endwhile ?>
		
		<?php do_action('foundationPress_before_pagination'); ?>
		
	<?php endif;?>
	
	
	
	<?php if ( function_exists('FoundationPress_pagination') ) { FoundationPress_pagination(); } else if ( is_paged() ) { ?>
		<nav id="post-nav">
			<div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', 'FoundationPress' ) ); ?></div>
			<div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'FoundationPress' ) ); ?></div>
		</nav>
	<?php } ?>
	
	<?php do_action('foundationPress_after_content'); ?>
	
	</div>
	<?php get_sidebar(); ?>
</div>	
<?php get_footer(); ?>