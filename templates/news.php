<?php
/*
Template Name: News
*/

$url_current = $url = preg_replace('/\?.*/', '', $_SERVER['REQUEST_URI']);

/*
 * Query variables
 */

// Dates
$coenv_year = urlencode(htmlentities($_GET['coenv-year']));
$coenv_month = urlencode(htmlentities($_GET['coenv-month']));
$coenv_date = date('F Y',mktime(0,0,0,(int)$coenv_month,0,(int)$coenv_year));

//Categories
$coenv_cat_1 = urlencode(htmlentities($_GET['tax']));
$coenv_cat_term_1 = urlencode(htmlentities($_GET['term']));
$coenv_cat_term_1_arr = get_term_by('slug',$coenv_cat_term_1,$coenv_cat_1);
$coenv_cat_term_1_val = $coenv_cat_term_1_arr->name;
?>

<?php get_header(); ?>
<div class="row">
	<div class="small-12 medium-8 columns" role="main">
		<div class="entry-content">
		<h1 class="article__title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
		<div class="row filters">
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
			'posts_per_page' => 20,
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
			$post_link_target = ' target="_blank" ';
            $post_link = '<p><a class="button" href="' . $post_link_url . '"' . $post_link_target . '>' . get_field('story_source_name') . '</a></p>';
        } else {
        	$post_link_url = get_the_permalink();
            $post_link = '<a class="button left" href="' . $post_link_url . '">Read more</a>';
        }
		?>
		<div class="blog-list-item clearfix">
		<!--
		<div class="share right" data-article-id="<?php the_ID(); ?>" data-article-title="<?php //echo get_the_title(); ?>"
		data-article-shortlink="<?php //echo wp_get_shortlink(); ?>"
		data-article-permalink="<?php //echo the_permalink(); ?>"><a href="#"><i class="fi-share"></i>Share</a>
        </div>
    	-->
        <?php
        echo '<div class="blog-meta clearfix">';
		echo '<p>' . get_the_date('M j, Y') .' / ';
		$termlist = '';
		foreach ($terms as $term) {
		 $termlist .= '<a href="' . $url_current . '?tax='. $term->taxonomy . '&term=' . $term->slug . '">' . $term->name . '</a>, ';
		}
		$termlist = rtrim($termlist,', ');
		echo $termlist;
		 echo '</p>';
		
		echo '</div>';
		echo '<h3><a href="' . $post_link_url . '"' . $post_link_target . '>' . get_the_title() . '</a></h3>';

		echo '<div class="post">';
		/*if (has_post_thumbnail()):
		echo '<a class="right" style="margin-right: 2rem;" href="' . get_the_permalink() . '">';
		the_post_thumbnail( 'medium' );
		echo '</a>';
		endif;*/
		echo the_excerpt();
		echo $post_link;
		'</div>';
		echo '<div class="blog-links right">';
		if($rows) {
			foreach($rows as $row) {
				if($row['blog_link_type'] == 'upload') {
					echo '<a class="button" href="' . $row['blog_upload_file'] . '" target="_blank">' . $row['blog_file_link_text'] . '</a>';
				} elseif ($row['blog_link_type'] == 'link') {
					echo '<a class="button" href="' . $row['blog_link_url'] . '" target="_blank">' . $row['blog_link_text'] . '</a>';
				} 
			}
		} ?>
		</div>
		</div>
	</div>
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
<?php get_footer(); ?>