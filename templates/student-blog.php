<?php
/*
Template Name: Blog
*/

/*
 * Query variables
 */
$keys = array_keys($_GET);
$cat_raw = $keys[0];
$cat = htmlentities( urlencode($_GET[$cat_raw]) );
$blog_cat_raw = htmlentities( urlencode($_GET['blog_category']) );
$blog_cat = get_term_by( 'slug', (string) $blog_cat_raw, 'blog_category' );

/*
 * wp_query variables
 */
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$test = get_query_var('blog_date');
$temp = $wp_query;
$wp_query = null;
$wp_query = new WP_Query();
$wp_query->query;
?>

<?php get_header(); ?>
<div class="row">

	<?php coenv_base_section_title($post->ID); ?>
	<?php //if (!is_front_page() && function_exists('bcn_display')): ?>
	<!--<div class="breadcrumbs"><?php //bcn_display(); ?></div>-->
	<?php 


	global $post;
$pagename = $post->post_name;
echo 'page name: ' . $pagename;





	//endif; ?>
	<div class="small-12 medium-8 columns" role="main">
		<div class="entry-content">
		<?php //if ( is_active_sidebar( 'before-content' ) ) : ?>
		<?php //do_action('foundationPress_before_content'); ?>
		<!--<ul class="widget-area before-content">
		<?php // dynamic_sidebar("before-content"); ?>
		</ul>-->
		<?php //endif; ?>
		<h1 class="article__title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
		<div class="row filters">
			<div class=" large-6 columns" data-url="<?php $_SERVER['REQUEST_URI']; ?>" data-cat="blog_category">
				<?php coenv_base_cat_filter('blog_category', $blog_cat_raw); ?>
			</div>

			<div class=" large-6 columns" data-url="<?php $_SERVER['REQUEST_URI']; ?>" data-cat="blog_category">
			<!--<select class="select-date">-->
			<?php
			add_filter( 'get_archives_link', 'get_archives_events_link', 10, 2 );

			//wp_get_archives( array( 'post_type' => 'student_blog' ) );            
			//wp_get_archives( array( 'post_type' => 'student_blog', 'type' => 'yearly' ) );
			wp_get_archives( array( 'post_type' => 'student_blog', 'type' => 'monthly' ) );
			//wp_get_archives( array( 'post_type' => 'student_blog', 'type' => 'daily' ) );

			remove_filter( 'get_archives_link', 'get_archives_events_link', 10, 2 );
			?>
		<!--</select>-->
						</div>







		</div>
		<hr>
		<?php if ($blog_cat): ?>
		<div class="panel">
			<div class="left">Posts about <strong><?php echo $blog_cat->name; ?></strong></div>
			<div class="right"><a href="/research/publications/">all posts &raquo;</a></div>
		</div>
		<?php endif; ?>
		<?php
		/**
		  * Blog loop
		  */
		$blog_args = array(
			'post_type'	=> 'student_blog',
			'post_status' => 'publish',
			'posts_per_page' => 20,
			'taxonomy' => $cat_raw,
			'term' => $cat,
			'orderby' => 'date',
			'order' => 'DESC',
			'paged' => $paged
		);
		$wp_query = new WP_Query( $blog_args );

		?>
		<?php if ($wp_query->have_posts()): ?>
		<?php echo '!!!!!!!!' . $wp_query->query_vars['my_date']; ?>
		<div class="blog clearfix">
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
		$rows = get_field('blog_link');
		$terms = wp_get_post_terms( get_the_ID(), 'blog_category');
		?>
		<div class="blog-list-item">
		<div class="share right" data-article-id="<?php the_ID(); ?>" data-article-title="<?php echo get_the_title(); ?>"
		data-article-shortlink="<?php echo wp_get_shortlink(); ?>"
		data-article-permalink="<?php echo the_permalink(); ?>"><a href="#"><i class="fi-share"></i>Share</a>
        </div>
        <?php
		echo '<h3><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h3>';
		echo '<div class="blog-meta">';
		echo '<p>' . get_the_date('M j, Y') .' / ';
		$termlist = '';
		foreach ($terms as $term) {
		 $termlist .= '<a href="/students/student-blog/?blog-cat=' . $term->slug . '">' . $term->name . '</a>, ';
		}
		$termlist = rtrim($termlist,', ');
		echo $termlist;
		 echo '</p>';
		
		echo '</div>';
		echo '<div class="post">';
		if (has_post_thumbnail()):
		echo '<a class="left" style="margin-right: 2rem;" href="' . get_the_permalink() . '">';
		the_post_thumbnail( 'medium' );
		echo '</a>';
		endif;
		echo the_excerpt();
		echo '<a class="button" href="' . get_the_permalink() . '">Read more</a>';
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
			<div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', 'FoundationPress' ) ); ?></div>
			<div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'FoundationPress' ) ); ?></div>
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