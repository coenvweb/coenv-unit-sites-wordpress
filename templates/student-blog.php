<?php
/*
Template Name: News
*/

$url_current = $url = preg_replace('/\?.*/', '', $_SERVER['REQUEST_URI']);

$filtered=false;

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
if(isset($wp_query->query_vars['blog_category'])){
    $coenv_cat_term_1 = urlencode(htmlentities($wp_query->query_vars['blog_category']));
    $coenv_cat_term_1_arr = get_term_by('slug',$coenv_cat_term_1,'blog_category');
    $coenv_cat_term_1_val = $coenv_cat_term_1_arr->name;
    $filtered = true;
} else {
    $coenv_cat_1 = $coenv_cat_term_1 = null;
}

?>
<?php get_header(); ?>
<div class="row page-content" id="main-col">
	<div class="columns" role="main">
		<div class="article__content">
		<div class="row filters">
			<div class=" large-6 columns" data-url="<?php the_permalink() ?>" data-cat="blog_category">
				<?php coenv_base_cat_filter('blog_category', $coenv_cat_term_1); // Category filter ?>
			</div>
			<div class=" large-6 columns" data-url="<?php the_permalink() ?>" data-cat="blog_category">
				<?php coenv_base_date_filter('student_blog',$coenv_month,$coenv_year); // Date filter ?>
		 	</div>
		</div>
		<?php
		/**
		  * Blog loop
		  */
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $query_args = array(
			'post_type'	=> 'student_blog',
			'post_status' => 'publish',
			'posts_per_page' => 10,
			'paged' => $paged
		);

        // Category filter
        if($coenv_cat_term_1) :
            $query_args['taxonomy'] = 'blog_category';
            $query_args['term'] = $coenv_cat_term_1;
            unset($query_args['post__not_in']); // if filtering, we want to let sticky posts in
        endif;

        // Date filters
        if ($coenv_year) {
            $query_args['year'] = $coenv_year;
            unset($query_args['post__not_in']);
        }
        if($coenv_month) {
            $query_args['monthnum'] = $coenv_month;
            unset($query_args['post__not_in']);
        }

        $wp_query = new WP_Query( $query_args );
		
		if ($wp_query->have_posts()) { 
		
			if ($coenv_cat_term_1) {
			?>
			<div class="panel">
				<div class="left"><?php echo $wp_query->found_posts; ?> posts in <strong><?php echo $coenv_cat_term_1_val; ?></strong></div>
				<div class="right"><a href="<?php the_permalink() ?>">all posts &raquo;</a></div>
			</div>
			<?php 
			} 
			if($coenv_year && $coenv_month) { ?>
			<div class="panel">
				<div class="left"><?php echo $wp_query->found_posts; ?> posts from <strong><?php echo $coenv_date; ?></strong></div>
				<div class="right"><a href="<?php the_permalink() ?>">all posts &raquo;</a></div>
			</div>
			<?php } ?>

		<div class="blog clearfix">
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) {
		$wp_query->the_post();
		$rows = get_field('blog_link');
		$terms = wp_get_post_terms( get_the_ID(), 'blog_category');
		if (get_field('story_link_url')) {
			$post_link_url = get_field('story_link_url');
			$post_link_target = ' target="_blank" ';
            $post_link = '<p><a class="button" href="' . $post_link_url . '"' . $post_link_target . '>' . get_field('story_source_name') . '</a></p>';
        } else {
        	$post_link_url = get_the_permalink();
            $post_link = '<a class="button left" href="' . $post_link_url . '">Read more</a>';
        }
		?>
		<article class="blog-list-item post-<?php the_ID() ?> clearfix">
        <header class="article__header">
        	<div class="columns small-10 article-meta">
	        	<p>
				<?php 
		        echo get_the_date('M j, Y');
				$termlist = '';
				foreach ($terms as $term) {
		            $termlist .= '<a href="/news-events/student-services-blog/'. $term->taxonomy . '/' . $term->slug . '/">' . $term->name . '</a>, ';
				}
				$termlist = rtrim($termlist,', ');
				if ( !empty( $terms ) ) {
					echo ' / ' . $termlist;
				}
		        ?>
		        </p>
			</div>
			<!--<div class="small-3 right share" data-article-id="<?php the_ID(); ?>" data-article-title="<?php echo get_the_title(); ?>" data-article-shortlink="<?php echo wp_get_shortlink(); ?>" data-article-permalink="<?php echo the_permalink(); ?>"><a href="#"><i class="fi-share"></i>Share</a></div>-->
        	<h2 class="small-12 left article__title"><a href="<?php echo $post_link_url; ?>" <?php echo $post_link_target; ?>><?php echo get_the_title(); ?></a></h2>
		</header>   
        <?php if (has_post_thumbnail()) { ?>
			<div class="small-12 medium-3 right blog-thumb"><a class="right" href="<?php echo get_the_permalink(); ?>"><?php echo the_post_thumbnail( 'small' ); ?></a></div>
			<div class="small-12 medium-9 left blog-content">
			<?php } else { ?>
			<div class="small-12 left">
			<?php } ?>
				<?php echo the_excerpt(); ?>
			</div>
	</article>
	<?php } ?>
	</div>
	<div class="pager">
	<?php if ( function_exists('FoundationPress_pagination') ) { FoundationPress_pagination(); } else if ( is_paged() ) { ?>
		<nav id="post-nav">
			<div class="post-previous"><?php //next_posts_link( __( '&larr; Older posts', 'FoundationPress' ) ); ?></div>
			<div class="post-next"><?php //previous_posts_link( __( 'Newer posts &rarr;', 'FoundationPress' ) ); ?></div>
		</nav>
	<?php } ?>
	</div>
  	<?php } else { ?>
  	<p class="no-results">We're sorry. Your criteria did not match any posts. <a href="/news-events/student-services-blog/">Return to all posts</a></p>
	<?php } ?>
	  </div>		
	<?php if ( is_active_sidebar( 'after-content' ) ) { ?>
	<?php do_action('foundationPress_after_content'); ?>
	<ul class="widget-area after-content">
	<?php dynamic_sidebar("after-content"); ?>
	</ul>
	<?php } ?>
	<a href="#" class="back-to-top">Back to Top</a>
	<?php do_action('foundationPress_after_content'); ?>
	</div>
<?php wp_reset_postdata(); wp_reset_query(); ?>
	<aside id="sidebar" class="columns show-for-medium-up">
	<?php
	if (!is_front_page()) {
		echo '<div class="coenv_base_subnav">';
		echo '<div class="section-title">';
		echo coenv_base_section_title($GLOBALS['post']->ID);
		echo '</div>';
		echo coenv_base_hierarchical_submenu($GLOBALS['post']->ID);
		echo '</div>';	
	}
	?>
	<?php dynamic_sidebar('sidebar-widgets'); ?>
	<?php
	$ancestor_id = coenv_base_get_ancestor('ID');
	if (!function_exists('dynamic_sidebar') || !dynamic_sidebar( $ancestor_id )) {
		dynamic_sidebar( $ancestor_id );
	}
	?>
	</aside>
</div>
<?php get_footer(); ?>
