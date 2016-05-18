<?php
/*
Template Name: Faculty Index
*/

/*
 * Query variables
 */

//Categories

if(isset($_GET['fac-cat'])){
    $coenv_cat_1 = urlencode(htmlentities($_GET['fac-cat']));
    $coenv_cat_term_1 = urlencode(htmlentities($_GET['fac-cat']));
    $coenv_cat_term_1_arr = $fac_cat = get_term_by('slug',$coenv_cat_term_1,'research_areas');
    $coenv_cat_term_1_val = $coenv_cat_term_1_arr->name;
} else {
    $coenv_cat_1 = $coenv_cat_term_1 = $fac_cat = null;
}
?>

<?php get_header(); ?>
<div class="row">

	<div class="small-12 medium-8 columns right" role="main">
        <div class="entry-content">
        	<div class="row filters">
				<div class=" large-6 columns" data-url="<?php $_SERVER['REQUEST_URI']; ?>" data-cat="blog_category">
				</div>
	</div>

<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$temp = $wp_query;
$wp_query = null;
$wp_query = new WP_Query();
$wp_query->query;

/**
* Faculty loop
*/
$query_args = array(
	'post_type'	=> 'faculty',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'taxonomy' => 'research_areas',
	'term' => isset($fac_cat->slug) ? $fac_cat->slug : '',
	'meta_key' => 'last_name',
	'orderby' => 'meta_value',
	'order' => 'ASC',
	'paged' => $paged,
	'meta_query' => array(
		array(
			'key'     => 'last_name',
			'compare' => 'IN',
		),
	),
);

// Category filter
if($coenv_cat_term_1) :
	$query_args['term'] = $coenv_cat_term_1;
endif;
$wp_query = new WP_Query( $query_args );

?>
            <div id="filter" class="row filters show-for-small-only">
			<h2 class="large-12 columns left">Filter By Research Area</h2>
			<div class="large-6 columns left" data-url="<?php $_SERVER['REQUEST_URI']; ?>" data-cat="category">
				<?php coenv_base_cat_filter('research_areas', $coenv_cat_term_1); // Category filter ?>
			</div>
		</div>
	<?php if ($wp_query->have_posts()): ?>
	<div class="faculty-list-teach clearfix">

<?php if ($coenv_cat_1): // Category filter ?>
		<div class="panel">
			<div class="left"><?php echo $wp_query->found_posts; ?> faculty working in <strong><?php echo $coenv_cat_term_1_val; ?></strong></div>
			<div class="right"><a href="/faculty-research/faculty-instructor-bios/">all faculty &raquo;</a></div>
		</div>
	<?php endif; ?>
        
        	<ul class="faculty-list-teach clearfix small-block-grid-3 medium-block-grid-4 large-block-grid-5">
                
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
		$faculty_thumb = get_the_post_thumbnail(get_the_ID(),'thumbnail');
		$faculty_img_src = wp_get_attachment_thumb_url( get_post_thumbnail_id($post->ID));
        $faculty_link = get_the_permalink();
        if (!$faculty_img_src) {
		  $faculty_img_src = get_template_directory_uri() . '/assets/img/blank-153x153.jpg';
		}
		echo '<a href="' . $faculty_link . '"><li class="faculty-list-item"><div class="faculty-thumb"><img src="' . $faculty_img_src . '"" alt="' . get_the_title() . '" /></div><h3>' . get_the_title() . '</h3></li></a>';
		endwhile;
		?>
				<div class="pager">
					<?php /* Display navigation to next/previous pages when applicable */ ?>
	<?php if ( function_exists('FoundationPress_pagination') ) { FoundationPress_pagination(); } else if ( is_paged() ) { ?>
		<nav id="post-nav">
			<div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', 'FoundationPress' ) ); ?></div>
			<div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'FoundationPress' ) ); ?></div>
		</nav>
	<?php } ?>
  </div>
		

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
	    <?php wp_reset_postdata(); wp_reset_query(); //roll back query vars to as per the request ?>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
