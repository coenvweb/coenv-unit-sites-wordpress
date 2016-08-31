<?php
/*
Template Name: News
*/

// keep track of whether or not this is the index page
$filtered = false;

// Dates
if(isset($wp_query->query_vars['coenv-year'])) {
    $coenv_year = (int) urlencode(htmlentities($wp_query->query_vars['coenv-year']));
    $coenv_month = (int) urlencode(htmlentities($wp_query->query_vars['coenv-month']));

    // Month needs an offset because php and WordPress calculate dates differently.
    $coenv_date = date('F Y',mktime(10,0,0,$coenv_month+1,0,$coenv_year));
    $filtered = true;
} else {
    $coenv_year = $coenv_month = $coenv_date = null;
}

//Categories
if(isset($wp_query->query_vars['category'])){
    $coenv_cat_term_1 = urlencode(htmlentities($wp_query->query_vars['category']));
    $coenv_cat_term_1_arr = get_term_by('slug',$coenv_cat_term_1,'category');
    $coenv_cat_term_1_val = $coenv_cat_term_1_arr->name;
    $filtered = true;
} else {
    $coenv_cat_1 = $coenv_cat_term_1 = null;
}

?>

<?php get_header(); ?>
<div class="row">
	<div class="small-12 medium-push-4 medium-8 large-push-3 large-9 columns" role="main" id="main-col">
		<div class="entry-content">
		<h1 class="article__title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
		<div class="row filters">
			<div class=" large-6 columns" data-url="<?php the_permalink() ?>" data-cat="blog_category">
				<?php coenv_base_cat_filter('category', $coenv_cat_term_1); // Category filter ?>
			</div>
			<div class=" large-6 columns" data-url="<?php the_permalink() ?>" data-cat="blog_category">
				<?php coenv_base_date_filter('post',$coenv_month,$coenv_year); // Date filter ?>
		 	</div>
            <div class="small-12 columns">
                <hr>
            </div>
		</div>
		<?php
		/**
		  * Blog loop
		  */
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $query_args = array(
			'post_type'	=> 'post',
			'post_status' => 'publish',
			'posts_per_page' => 10,
            'ignore_sticky_posts' => 1,
			'paged' => $paged
		);
		// Category filter
		if($coenv_cat_term_1) :
			$query_args['taxonomy'] = 'category';
			$query_args['term'] = $coenv_cat_term_1;
		endif;

		// Date filters
		if ($coenv_year) {
			$query_args['year'] = $coenv_year;
		} 
		if($coenv_month) {
			$query_args['monthnum'] = $coenv_month;
		}
		$wp_query = new WP_Query( $query_args );
		?>
		<?php if ($wp_query->have_posts()): 
		?>
		<?php if ($coenv_cat_term_1): // Category filter ?>
		<div class="panel">
			<div class="left"><?php echo $wp_query->found_posts; ?> posts in <?php echo $coenv_cat_term_1_val; ?></div>
		</div>
		<?php endif; ?>
		<?php if($coenv_year && $coenv_month): // Date filter ?>
		<div class="panel">
			<div class="left"><?php echo $wp_query->found_posts; ?> posts from <?php echo $coenv_date; ?></div>
		</div>
		<?php endif; ?>
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
		$rows = get_field('blog_link');
        delete_post_thumbnail( get_the_ID() );
        echo '<div class="blog clearfix">';
		get_template_part( 'partials/partial', 'story' );
        ?>
		</div>
	<?php endwhile; ?>
	<div class="pager">
	<?php if ( function_exists('FoundationPress_pagination') ) { FoundationPress_pagination(); } else if ( is_paged() ) { ?>
		<nav id="post-nav">
			<div class="post-previous"><?php //next_posts_link( __( '&larr; Older posts', 'FoundationPress' ) ); ?></div>
			<div class="post-next"><?php //previous_posts_link( __( 'Newer posts &rarr;', 'FoundationPress' ) ); ?></div>
		</nav>
	<?php } ?>
	</div>
  	<?php else: ?>
  	<p>We're sorry. Your crtieria did not match any posts. <a href="/research/publications">Return to all posts &raquo;</a></p>
	<?php endif; ?>
	  </div>		
	<?php if ( is_active_sidebar( 'after-content' ) ) : ?>
	<?php do_action('foundationPress_after_content'); ?>
	<ul class="widget-area after-content">
	<?php dynamic_sidebar("after-content"); ?>
	</ul>
	<?php endif; ?>
	<a href="#" class="back-to-top">Back to Top</a>
	<?php do_action('foundationPress_after_content'); ?>
	</div>
<?php wp_reset_postdata(); wp_reset_query(); ?>
<?php get_sidebar(); ?>
</div>
</div>
<?php get_footer(); ?>
