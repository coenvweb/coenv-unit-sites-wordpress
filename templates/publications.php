<?php
/*
Template Name: Publications Page
*/

/*
 * Query variables
 */

// Categories
$coenv_cat_1 = urlencode(htmlentities($_GET['tax']));
$coenv_cat_term_1 = urlencode(htmlentities($_GET['term']));
$coenv_cat_term_1_arr = get_term_by('slug',$coenv_cat_term_1,$coenv_cat_1);
$coenv_cat_term_1_val = $coenv_cat_term_1_arr->name;

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>

<?php get_header(); ?>

<div class="row">
	<div class="small-12 medium-8 columns" role="main">
		<div class="entry-content">
		<h1 class="article__title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
		<div class="row filters">
			<div class=" large-4 columns" data-url="<?php $_SERVER['REQUEST_URI']; ?>" data-cat="publication_theme">
				<?php coenv_base_cat_filter('publication_theme', $coenv_cat_term_1); // Category filter ?>
			</div>
			<div class="large-4 columns" data-url="<?php $_SERVER['REQUEST_URI']; ?>" data-cat="author">
				<?php coenv_base_cat_filter('author', $coenv_cat_term_1); // Category filter ?>
			</div>
			<div class="large-4 columns" data-url="<?php $_SERVER['REQUEST_URI']; ?>" data-cat="publication_year">
				<?php coenv_base_cat_filter('publication_year', $coenv_cat_term_1); // Category filter ?>
			</div>
		</div>
		<hr>
		
		<?php
		/**
		* Publications loop
		*/

		function alter_pub_order($order,$qry) {
		  remove_filter('posts_orderby','alter_order',1,2);
		  $order = explode(',',$order);
		  $order = implode( ' DESC,',$order);
		  return $order;
		}
		add_filter('posts_orderby','alter_pub_order',1,2);

		$query_args = array(
			'post_type'	=> 'publications',
			'post_status' => 'publish',
			'posts_per_page' => 20,
			'taxonomy' => $cat_raw,
			'term' => $cat,
			'orderby' => 'date',
			'order' => 'ASC',
			'paged' => $paged
		);

		// Category filter
		if($coenv_cat_1 && $coenv_cat_term_1) :
			$query_args['taxonomy'] = $coenv_cat_1;
			$query_args['term'] = $coenv_cat_term_1;
		endif;

		$wp_query = new WP_Query( $query_args );
		?>

		<?php if ($coenv_cat_1 == 'publication_theme'): ?>
		<div class="panel">
			<div class="left"><?php echo $wp_query->found_posts; ?> publications listed under <strong><?php echo $coenv_cat_term_1_val; ?></strong></div>
			<div class="right"><a href="/research/publications/">all publications &raquo;</a></div>
		</div>
		<?php endif; ?>
		<?php if ($coenv_cat_1 == 'author'): ?>
		<div class="panel">
			<div class="left"><?php echo $wp_query->found_posts; ?> publications written by <strong><?php echo $coenv_cat_term_1_val; ?></strong></div>
			<div class="right"><a href="/research/publications/">all publications &raquo;</a></div>
		</div>
		<?php endif; ?>
		<?php if ($coenv_cat_1 == 'publication_year'): ?>
		<div class="panel">
			<div class="left">
				<?php if($coenv_cat_term_1 == 'in-press') { ?>
				<?php echo $wp_query->found_posts; ?>
				publications that are 
				<strong>
				<?php echo strtolower($coenv_cat_term_1_val); ?>
				</strong>
				<?php } elseif (is_numeric($coenv_cat_term_1)) { ?>
				<?php echo $wp_query->found_posts; ?>
				publications published in 
				<strong>
				<?php echo $coenv_cat_term_1_val; ?>
				</strong>
				<?php } ?>
				<strong><?php echo strtolower($year_cat->name); ?></strong></div>
			<div class="right"><a href="/research/publications/">all publications &raquo;</a></div>
		</div>
		<?php endif; ?>
		<?php if ($wp_query->have_posts()): ?>
		<div class="publication clearfix">
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
		$publication_link = get_the_permalink();
		$publication_citation = get_field('publication_citation');
		$rows = get_field('publication_link');
		?>
		<div class="publication-list-item post-<?php the_ID() ?>">
		<div class="blog-meta"><h5>
        <div class="share right" data-article-id="<?php the_ID(); ?>" data-article-title="<?php echo get_the_title(); ?>"
		data-article-shortlink="<?php echo wp_get_shortlink(); ?>"
		data-article-permalink="<?php echo the_permalink(); ?>"><a href="#"><i class="fi-share"></i>Share</a>
        </div>
        <?php
		echo get_the_term_list( $post->ID, 'publication_theme', '', ', ', '' );
		echo '</h5></div>';
		echo '<h4><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h4>';
		echo '<div class="citation">' . $publication_citation . '</div>';
		echo '<div class="publication-links right">';
		if($rows) {
			foreach($rows as $row) {
				if($row['publication_link_type'] == 'upload') {
					echo '<a class="button" href="' . $row['publication_upload_file'] . '" target="_blank">Download</a>';
				} elseif ($row['publication_link_type'] == 'link') {
					echo '<a class="button" href="' . $row['publication_link_url'] . '" target="_blank">' . $row['publication_link_text'] . '</a>';
				} 
			}
		}
		echo '</div>';
		echo '<div class="abstract"><a class="button" href="' . get_the_permalink() .'">View Abstract</a></div>';
		echo '</div>';
		endwhile;
		?>
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
  	<p>We're sorry. Your crtieria did not match any publications. <a href="/research/publications">Return to all publications &raquo;</a></p>
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
<?php wp_reset_postdata(); wp_reset_query(); //roll back query vars to as per the request ?>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>