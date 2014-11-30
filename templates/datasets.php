<?php
/*
Template Name: Datasets
*/

/*
 * Query variables
 */
$coenv_cat_1 = urlencode(htmlentities($_GET['tax']));
$coenv_cat_term_1 = urlencode(htmlentities($_GET['term']));
$coenv_cat_term_1_arr = get_term_by('slug',$coenv_cat_term_1,$coenv_cat_1);
$coenv_cat_term_1_val = $coenv_cat_term_1_arr->name;
$coenv_inpress = urlencode(htmlentities($_GET['inpress']));
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

?>
<?php get_header(); ?>
<div class="row">
	<div class="small-12 medium-8 columns" role="main">
		<div class="entry-content">
		<h1 class="article__title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
		<div class="row filters">
			<div class=" large-6 columns" data-url="<?php $_SERVER['REQUEST_URI']; ?>" data-cat="dataset_region">
				<?php coenv_base_cat_filter('dataset_region', $coenv_cat_term_1); // Category filter ?>
			</div>
			<div class="large-6 columns" data-url="<?php $_SERVER['REQUEST_URI']; ?>" data-cat="dataset_type">
				<?php coenv_base_cat_filter('dataset_type', $coenv_cat_term_1); // Category filter ?>
			</div>
		</div>
		<hr>
		
		<?php
		echo $coenv_inpress;
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
			/*'meta_query' => array(
				array(
					'key'     => 'in_press',
					'value'     => 'inpress',
					'compare' => 'IN'
				)
			),*/
			'post_type'	=> 'datasets',
			'post_status' => 'publish',
			'posts_per_page' => 20,
			// This doesn't work
			//'meta_key' => (int) 'publication_years',
            //'orderby' => 'meta_value',
            //'order' => 'DESC',
            
			'paged' => $paged
		);

		// Category filter
		if($coenv_cat_1 && $coenv_cat_term_1) :
			$query_args['taxonomy'] = $coenv_cat_1;
			$query_args['term'] = $coenv_cat_term_1;
		endif;

		// In press filter
		//if ($coenv_inpress) {


		//	$query_args['meta_query'] = array(
	//'relation' => 'OR', // Optional, defaults to "AND"
	//array(
	//	'key'     => 'in_press',
	//	'value'   => '1',
	//	'compare' => '='
	//)
//);





		//}
		$wp_query = new WP_Query( $query_args );
		?>

		<?php if ($coenv_cat_1 == 'dataset_region'): ?>
		<div class="panel">
			<div class="left"><?php echo $wp_query->found_posts; ?> datasets from the region <strong><?php echo $coenv_cat_term_1_val; ?></strong></div>
			<div class="right"><a href="/data/cig-datasets/">all datasets &raquo;</a></div>
		</div>
		<?php endif; ?>
		<?php if ($coenv_cat_1 == 'dataset_type'): ?>
		<div class="panel">
			<div class="left"><?php echo $wp_query->found_posts; ?> datasets of type <strong><?php echo $coenv_cat_term_1_val; ?></strong></div>
			<div class="right"><a href="/data/cig-datasets/">all datasets &raquo;</a></div>
		</div>
		<?php endif; ?>
		<?php if ($wp_query->have_posts()): ?>
		<div class="publication clearfix">
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();

		// Publication themes list
		$dataset_region = wp_get_post_terms($post->ID, 'dataset_region');
		if (!empty($dataset_region)) {
			$dataset_region_arr = array();

			foreach ($dataset_region as &$term) {
				$dataset_region_arr[] = '<a href="?tax=dataset_region&term=' . $term->slug . '">' . $term->name . '</a>';
			}
			$dataset_region_str = implode(', ', $dataset_region_arr) . ' | ';
			$dataset_region = "";
		} else {
			$dataset_region_str = '';
		}

		// Publication year list
		$dataset_type = wp_get_post_terms($post->ID, 'dataset_type');
		if (!empty($dataset_type)) {
			$dataset_type_arr = array();

			foreach ($dataset_type as &$term) {
				$dataset_type_arr[] = '<a href="?tax=dataset_type&term=' . $term->slug . '">' . $term->name . '</a>';
			}
			$dataset_type_str = implode(', ', $dataset_type_arr);
			$dataset_type = "";
		} else {
			$dataset_type_str = '';
		}

		$dataset_link = get_the_permalink();
		$rows = get_field('dataset_link');
		?>
		<div class="dataset-list-item post-<?php the_ID() ?>">
		<div class="blog-meta"><h5>
        <div class="share right" data-article-id="<?php the_ID(); ?>" data-article-title="<?php echo get_the_title(); ?>"
		data-article-shortlink="<?php echo wp_get_shortlink(); ?>"
		data-article-permalink="<?php echo the_permalink(); ?>"><a href="#"><i class="fi-share"></i>Share</a>
        </div>
        <?php
		echo $dataset_region_str . $dataset_type_str;

		echo '</h5></div>';
		echo '<h4><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h4>';
		echo '<div>' . get_field('dataset_overview') . '</div>';

		echo '<div>';
		echo '<a class="button" href="' . get_the_permalink() .'">View Details</a>';
		echo '</div>';
		echo '</div>';
		$publication_years_arr = "";
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