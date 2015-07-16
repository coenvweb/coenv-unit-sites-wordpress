<?php get_header(); ?>
<div class="page-row mini">
    <div class="black-wedge light"></div><div class="black-wedge"></div>
    <div class="header-white show-for-medium-up"></div>
    <div class="header-title-container show-for-medium-up">
        <div class="page-title-row row">
            <div class="page-title"><h1><span>Search Results</span></h1></div>
        </div>
    </div>
</div>

<div class="row">
	<div class="small-12 medium-8 columns results" role="main" id="main-col">
        <div class="search-filter">
	
		<?php do_action('foundationPress_before_content'); ?>
	
		<h3><?php _e('Results for', 'FoundationPress'); ?> "<?php echo get_search_query(); ?>"</h3>
        
        <?php get_search_form(); ?>
        </div>
	
	<?php if ( have_posts() ) : ?>
	
		<?php while ( have_posts() ) : the_post(); ?>
		<h2><a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a></h2>
		<p>
		<?php
		$teaser_limited = the_advanced_excerpt('length=50&length_type=sentence');
		$teaser_limited = strip_tags($teaser_limited);
		$teaser_limited = trim($teaser_limited, '!,?.&nbsp;');
		echo $teaser_limited;
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
</div>
</div>
		
<?php get_footer(); ?>