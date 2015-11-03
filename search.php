<?php get_header(); ?>
<div class="row">
	<div class="small-12 medium-12 columns" role="main">
	
		<?php do_action('foundationPress_before_content'); ?>
	
		<?php if ( have_posts() ) : ?>
        <div class="search-filter">
	
		<?php do_action('foundationPress_before_content'); ?>
	
		<h3><?php _e('Results for', 'FoundationPress'); ?> "<?php echo get_search_query(); ?>"</h3>
        
        <?php get_search_form(); ?>
        </div>
	
		<?php while ( have_posts() ) : the_post(); ?>
		<h2><a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a></h2>
		<p>
		<?php
		$teaser_limited = get_the_excerpt();
		$teaser_limited = strip_tags($teaser_limited);
		$teaser_limited = trim($teaser_limited, '!,?.&nbsp;') . '...';
		if ($teaser_limited != "..."):
		echo $teaser_limited;
		endif;
		?>
		</p>
		<?php endwhile; ?>
		
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		
	<?php endif;?>
	
	<?php do_action('foundationPress_before_pagination'); ?>
	
	<?php if ( function_exists('FoundationPress_pagination') ) { FoundationPress_pagination(); } else if ( is_paged() ) { ?>
		
		<nav id="post-nav">
			<div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', 'FoundationPress' ) ); ?></div>
			<div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'FoundationPress' ) ); ?></div>
		</nav>
	<?php } ?>

	<?php do_action('foundationPress_after_content'); ?>

	</div>
		
<?php get_footer(); ?>