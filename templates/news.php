<?php
/*
Template Name: News
*/

$url_current = $url = preg_replace('/\?.*/', '', $_SERVER['REQUEST_URI']);

/*
 * Query variables
 */

// Dates
date_default_timezone_set('America/Los_Angeles');
$coenv_year = urlencode(htmlentities($_GET['coenv-year']));
$coenv_month = urlencode(htmlentities($_GET['coenv-month']));
$coenv_date = date('F Y',mktime('1','30','1',(int)$coenv_month,'1',(int)$coenv_year));

//Categories
$coenv_cat_1 = urlencode(htmlentities($_GET['tax']));
$coenv_cat_term_1 = urlencode(htmlentities($_GET['term']));
$coenv_cat_term_1_arr = get_term_by('slug',$coenv_cat_term_1,$coenv_cat_1);
$coenv_cat_term_1_val = $coenv_cat_term_1_arr->name;
?>

<?php get_header(); ?>
<div class="full-page">
<div class="row">
	<div class="small-12 medium-8 columns" role="main">
		<div class="entry-content">
		<div class="row filters">
			<h3 class="small-12 columns">Filter News</h3>
			<div class=" large-6 columns" data-url="<?php $_SERVER['REQUEST_URI']; ?>" data-cat="blog_category">
				<?php coenv_base_cat_filter('category', $coenv_cat_term_1); // Category filter ?>
			</div>
			<div class=" large-6 columns" data-url="<?php $_SERVER['REQUEST_URI']; ?>" data-cat="blog_category">
				<?php coenv_base_date_filter('post',$coenv_month,$coenv_year); // Date filter ?>
		 	</div>
		</div>
		<hr>
		<?php
		/**
		  * Blog loop
		  */
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$query_args = array(
			'post_type'	=> 'post',
			'post_status' => 'publish',
			'posts_per_page' => 10,
			'orderby' => 'date',
			'order' => 'DESC',
			'paged' => $paged
		);
		// Category filter
		if($coenv_cat_1 && $coenv_cat_term_1) :
			$query_args['taxonomy'] = $coenv_cat_1;
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
		<?php if ($coenv_cat_1): // Category filter ?>
		<div class="panel">
			<div class="left"><?php echo $wp_query->found_posts; ?> posts in <strong><?php echo $coenv_cat_term_1_val; ?></strong></div>
			<div class="right"><a href="<?php echo $url_current; ?>">all posts &raquo;</a></div>
		</div>
		<?php endif; ?>
		<?php if($coenv_year && $coenv_month): // Date filter ?>
		<div class="panel">
			<div class="left"><?php echo $wp_query->found_posts; ?> posts from <strong><?php echo $coenv_date; ?></strong></div>
			<div class="right"><a href="<?php echo $url_current; ?>">all posts &raquo;</a></div>
		</div>
		<?php endif; ?>

		<div class="blog clearfix">
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
		$rows = get_field('blog_link');
		$terms = wp_get_post_terms( get_the_ID(), 'category');
		if (get_field('story_link_url')) {
			$post_link_url = get_field('story_link_url');
			$post_link_target = '';
			if (!strpos($post_link_url,'cig.uw.') || strpos($post_link_url,'.pdf')) {
				$post_link_target = ' target="_blank" ';
			}
            $post_link = '<a class="button" href="' . $post_link_url . '"' . $post_link_target . '>' . get_field('story_source_name') . '</a>';
        } else {
        	$post_link_url = get_the_permalink();
            $post_link = '<a class="button left" href="' . $post_link_url . '">Read more</a>';
        }
		?>
		<div class="blog-list-item clearfix">
			<div class="post-meta clearfix">
			<div class="left">
				<time class="article__time" datetime="2014-10-30 06:56:38"><?php echo get_the_date('M j, Y'); ?></time>
				<div class="terms">
				<?php
				$termlist = '';
				foreach ($terms as $term) {
					if ( $term->slug != 'uncategorized') {
	 					$termlist .= '<a href="' . $url_current . '?tax='. $term->taxonomy . '&term=' . $term->slug . '">' . $term->name . '</a>, ';
	 				}
				}
				$termlist = rtrim($termlist,', ');
				echo $termlist;
				?>
				</div>
				
			</div>
			<div class="sharer right">
        <?php $title = rawurlencode(get_the_title());
        $shortlink = rawurlencode($post_link_url);
        $site_name = rawurlencode(get_bloginfo('name'));
        $twitter = get_option('twitter');
        ?>
        <a href=<?php echo 'http://twitter.com/home?status=' . $title . '%20' . $shortlink . ' target="_blank">' ?>
        <?php get_template_part('assets/img/icons/inline', 'twitter-circle.svg'); ?></a>
        <a href=<?php echo 'http://www.facebook.com/sharer/sharer.php?s=100&p[url]=' . $shortlink . '&p[images][0]=&p[title]=' . $title . '" target="_blank">'; ?>
        <?php get_template_part('assets/img/icons/inline', 'facebook-circle.svg'); ?></a>
        <a href=<?php echo 'mailto:?subject=' . $title . '&body=Check%20out%20this%20article:%20' . $shortlink . '>'; ?>
        <?php get_template_part('assets/img/icons/inline', 'email-circle.svg'); ?></a>
		</div>
		</div>

    	<div class="post-content left <?php echo $has_thumb; ?>">
			
			<h2><a href="<?php echo $post_link_url; ?>"<?php echo $post_link_target; ?>><?php echo get_the_title(); ?></a></h2>
			<?php 	
				echo the_advanced_excerpt('length=100&length_type=words&no_custom=1&allowed_tags=p,a');
				echo $post_link;
			?>
		</div>
	</div>
	<?php $has_thumb = ""; ?>
	<?php endwhile; ?>
	</div>
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