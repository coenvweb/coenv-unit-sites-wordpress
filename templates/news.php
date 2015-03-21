<?php
/*
Template Name: News
*/

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
<div class="row">
	<div class="small-12 medium-8 columns right" role="main" id="main-col">
		<div class="entry-content">
		<div class="row filters">
			<div class=" large-6 columns" data-url="/about/news/" data-cat="blog_category">
				<?php coenv_base_cat_filter('category', $coenv_cat_term_1); // Category filter ?>
			</div>
			<div class=" large-6 columns" data-url="/about/news/" data-cat="blog_category">
				<?php coenv_base_date_filter('post',$coenv_month,$coenv_year); // Date filter ?>
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
			'paged' => $paged,
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
			<div class="right"><a class="button" href="/about/news/">all posts</a></div>
		</div>
		<?php endif; ?>
		<?php if($coenv_year && $coenv_month): // Date filter ?>
		<div class="panel">
			<div class="left"><?php echo $wp_query->found_posts; ?> posts from <strong><?php echo $coenv_date; ?></strong></div>
			<div class="right"><a class="button" href="/about/news/">all posts &raquo;</a></div>
		</div>
		<?php endif; ?>

		<div class="blog clearfix">
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
		$rows = get_field('blog_link');
		$terms = wp_get_post_terms( get_the_ID(), 'category');
		// Filter display of administrative post categories
		$terms = wp_list_filter($terms, array('slug'=>'uncategorized','slug'=>'featured'),'NOT');
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
        
        <div class="blog-meta clearfix">
            <div class="small-6 columns left">
                <?php 
                echo '<p>' . get_the_date('M j, Y') .' / ';
                $termlist = '';
                foreach ($terms as $term) {
                    $termlist .= '<a href="/about/news/' . '?tax='. $term->taxonomy . '&term=' . $term->slug . '">' . $term->name . '</a>, ';
                }
                $termlist = rtrim($termlist,', ');
                echo $termlist;
                ?>
                </p>
            </div>
            <div class="small-6 columns sharer right">
                <?php $title = rawurlencode(get_the_title());
                $shortlink = rawurlencode(wp_get_shortlink());
                $site_name = rawurlencode(get_bloginfo('name'));
                $twitter = get_option('twitter');
                ?>
                <a href=<?php echo 'http://twitter.com/home?status=' . $title . '%20' . $shortlink . '%20from%20' . $twitter . ' target="_blank">' ?>
                <?php get_template_part('assets/img/icons/inline', 'twitter-circle.svg'); ?></a>
                <a href=<?php echo 'http://www.facebook.com/sharer/sharer.php?s=100&p[url]=' . $shortlink . '&p[images][0]=&p[title]=' . $title . '%20from%20' . $site_name .'" target="_blank">'; ?>
                <?php get_template_part('assets/img/icons/inline', 'facebook-circle.svg'); ?></a>
                <a href=<?php echo 'mailto:?subject=' . $title . '&body=Check%20out%20this%20article%20from%20the%20' . $site_name .':%20' . $shortlink . '>'; ?>
                <?php get_template_part('assets/img/icons/inline', 'email-circle.svg'); ?></a>
            </div>
		</div>
            
        <?php
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
  	<div class="panel">
			<div class="left">We're sorry. This filter did not match any posts.</div>
			<div class="right"><a class="button" href="/about/news/">all posts</a></div>
		</div>
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