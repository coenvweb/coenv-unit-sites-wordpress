<?php
/*
Template Name: Datasets
*/

/*
 * Query variables
 */

if(isset($wp_query->query_vars['dataset_region'])){
	$coenv_cat_1 = 'dataset_region';
    $coenv_cat_term_1 = urlencode(htmlentities($wp_query->query_vars['dataset_region']));
    $coenv_cat_term_1_arr = get_term_by('slug',$coenv_cat_term_1,'dataset_region');
    $coenv_cat_term_1_val = $coenv_cat_term_1_arr->name;
    $filtered = true;
}

if(isset($wp_query->query_vars['dataset_type'])){
	$coenv_cat_1 = 'dataset_type';
    $coenv_cat_term_1 = urlencode(htmlentities($wp_query->query_vars['dataset_type']));
    $coenv_cat_term_1_arr = get_term_by('slug',$coenv_cat_term_1,'dataset_type');
    $coenv_cat_term_1_val = $coenv_cat_term_1_arr->name;
    $filtered = true;
}
$page_link = get_the_permalink();

?>
<?php get_header(); ?>
<div class="row">
	<div class="small-12 medium-8 columns" role="main">
		<div class="entry-content">
		<h1 class="article__title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
		<div class="row filters">
			<h3 class="small-12 columns">Filter Datasets</h3>
			<div class=" large-6 columns" data-url="<?php the_permalink(); ?>" data-cat="dataset_region">
				<?php coenv_base_cat_filter('dataset_region', $coenv_cat_term_1); // Category filter ?>
			</div>
			<div class="large-6 columns" data-url="<?php the_permalink(); ?>" data-cat="dataset_type">
				<?php coenv_base_cat_filter('dataset_type', $coenv_cat_term_1); // Category filter ?>
			</div>
		</div>
		<hr>
		
		<?php
		/**
		* Publications loop
		*/
		$query_args = array(
			'post_type'	=> 'datasets',
			'post_status' => 'publish',
			'posts_per_page' => 20,
            'orderby' => 'title',
			'order' => 'ASC', 
			'paged' => $paged
		);

		if($coenv_cat_1 && $coenv_cat_term_1) :
			$query_args['taxonomy'] = $coenv_cat_1;
			$query_args['term'] = $coenv_cat_term_1;
		endif;

		$wp_query = new WP_Query( $query_args );
		?>

		<?php if ($coenv_cat_1 == 'dataset_region'): ?>
		<div class="panel">
			<div class="left"><?php echo $wp_query->found_posts; ?> dataset<?php if((int)$wp_query->found_posts > 1): echo 's'; endif; ?> from the region <strong><?php echo $coenv_cat_term_1_val; ?></strong></div>
			<div class="right"><a href="/resources/data/cig-datasets/">all datasets &raquo;</a></div>
		</div>
		<?php endif; ?>
		<?php if ($coenv_cat_1 == 'dataset_type'): ?>
		<div class="panel">
			<div class="left"><?php echo $wp_query->found_posts; ?> dataset<?php if((int)$wp_query->found_posts > 1): echo 's'; endif; ?> of type <strong><?php echo $coenv_cat_term_1_val; ?></strong></div>
			<div class="right"><a href="/resources/data/cig-datasets/">all datasets &raquo;</a></div>
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
				$dataset_region_arr[] = '<a href="'.$page_link.'dataset_region/' . $term->slug . '">' . $term->name . '</a>';
			}
			$dataset_region_str = implode(', ', $dataset_region_arr) . ', ';
			$dataset_region = "";
		}

		// Publication year list
		$dataset_type = wp_get_post_terms($post->ID, 'dataset_type');
		if (!empty($dataset_type)) {
			$dataset_type_arr = array();

			foreach ($dataset_type as &$term) {
				$dataset_type_arr[] = '<a href="'.$page_link.'dataset_type/' . $term->slug . '">' . $term->name . '</a>';
			}
			$dataset_type_str = implode(', ', $dataset_type_arr);
			$dataset_type = "";
		} 

		$dataset_link = get_the_permalink();
		$rows = get_field('dataset_link');
		?>
		<div class="dataset-list-item post-<?php the_ID() ?>">
        <?php
		echo '<h2><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>';
		if (!empty($dataset_region_str) || !empty($dataset_type_str)) {
			echo '<div class="post-meta clearfix">';
			echo $dataset_region_str . $dataset_type_str;
			echo '</div>';
		}
		echo '<div>' . coenv_base_custom_field_excerpt('dataset_overview') . '</div>';
		echo '<a class="button" href="' . get_the_permalink() .'">View Details</a>';
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
  	<p>We're sorry. Your criteria did not match any publications. <a href="/research/publications">Return to all publications &raquo;</a></p>
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
