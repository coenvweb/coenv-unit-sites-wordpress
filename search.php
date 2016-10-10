<?php get_header(); ?>
<div class="row">
	<div class="large-12 columns" role="main" id="main-col">
	
	
		<h2><?php _e('Search Results for', 'FoundationPress'); ?> "<?php echo get_search_query(); ?>"</h2>

        <?php get_search_form(); ?>
	
	<?php if ( have_posts() ) : ?>
	
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'partials/partial', 'search-result' ); ?>
		<?php endwhile; ?>
		
	<?php else : ?>

        <?php //TODO: generic no content line? ?>
        <?php get_template_part( 'content', 'none' ); ?>

	<?php endif;?>
	
	<?php do_action('foundationPress_before_pagination'); ?>
	
	<?php if ( function_exists('FoundationPress_pagination') ) { FoundationPress_pagination(); } else if ( is_paged() ) { ?>
		
		<nav id="post-nav">
			<div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', 'FoundationPress' ) ); ?></div>
			<div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'FoundationPress' ) ); ?></div>
		</nav>
	<?php } ?>

	</div>
</div>
<?php get_footer(); ?>
