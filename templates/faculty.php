<?php
/*
Template Name: Faculty Index
*/

// Categories
$coenv_cat_1 = urlencode( htmlentities( $_GET['tax'] ) );
$coenv_cat_term_1 = urlencode( htmlentities( $_GET['term'] ) );
$coenv_cat_term_1_arr = get_term_by( 'slug',$coenv_cat_term_1,$coenv_cat_1 );
$coenv_cat_term_1_val = $coenv_cat_term_1_arr->name;

get_header();

if( !empty( get_field( 'intro_text') ) ) {
?>
<div class="full-intro">
	<div class="row">
		<p><?php the_field( 'intro_text' ); ?></p>
	</div>
</div> <!-- // full-intro -->
<?php } ?>
<div class="row page-content" id="main-col">
	<div class="columns" role="main">
			<?php while (have_posts()) : the_post(); ?>
			<article <?php post_class() ?> id="post-<?php the_ID(); ?>" class="template-page">
				<?php do_action('foundationPress_page_before_entry_content'); ?>
				<?php get_template_part( 'partials/partial', 'article' ); ?>
				<footer>
					<?php wp_link_pages( array( 'before' => '<nav id="page-nav"><p>' . __( 'Pages:', 'FoundationPress' ), 'after' => '</p></nav>' ) ); ?>
					<p><?php the_tags(); ?></p>
				</footer>
			</article>
			<?php endwhile;?>
		<div id="filter" class="row filters show-for-small-only">
			<h2 class="large-12 columns left">Filter By Research Area</h2>
			<div class="large-6 columns left" data-url="<?php $_SERVER['REQUEST_URI']; ?>" data-cat="category">
				<?php coenv_base_cat_filter('research_areas', $coenv_cat_term_1); // Category filter ?>
			</div>
		</div>
		<?php

		// Setup WP_QUERY
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$temp = $wp_query;
		$wp_query = null;
		$wp_query = new WP_Query();
		$wp_query->query;

		$query_args = array(
			'post_type'	=> 'faculty',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'taxonomy' => 'research_areas',
			'term' => $fac_cat->slug,
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
		if($coenv_cat_1 && $coenv_cat_term_1) :
			$query_args['taxonomy'] = $coenv_cat_1;
			$query_args['term'] = $coenv_cat_term_1;
		endif;
		$wp_query = new WP_Query( $query_args );

		?>

		<?php if ($wp_query->have_posts()): ?>
		<?php if ($coenv_cat_1): // Category filter ?>
			<div class="panel clearfix">
				<div class="left columns small-10"><?php echo $wp_query->found_posts; ?> faculty working in <strong><?php echo $coenv_cat_term_1_val; ?></strong></div>
				<div class="right columns small-2"><a href="/faculty-research/#filter">All Faculty &raquo;</a></div>
			</div>
		<?php endif; ?>




		<ul class="faculty-list-teach clearfix small-block-grid-3 medium-block-grid-4 large-block-grid-5">

	
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
		$faculty_thumb = get_the_post_thumbnail( get_the_ID(),'faculty_sm' );
		$faculty_link = get_the_permalink();
		$faculty_phone_rows = get_field( 'phone_number' );
		$faculty_email = str_replace( 'u.washington.edu','uw.edu',get_field( 'email_address' ) );
		$first_faculty_phone_row = $faculty_phone_rows[0];
		$first_faculty_phone = $first_faculty_phone_row['number' ];
		$faculty_title_rows = get_field( 'job_titles' );
		$first_faculty_title_row = $faculty_title_rows[0];
		$first_faculty_title = $first_faculty_title_row['job_title'];
		$faculty_img_src = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
		if ( !$faculty_img_src ) {
			$faculty_img_src = get_template_directory_uri() . '/assets/img/blank-153x153.jpg';
		}
		echo '<li class="faculty-list-item">';
			echo '<a href="' . $faculty_link . '"><img src="' . $faculty_img_src . '"" alt="' . get_the_title() . '" /></a>';
			echo '<h3><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h3>';
		echo '</li>';
		endwhile;
		?>
  		</ul>
  		<ul class="widget-area after-content">
			<?php dynamic_sidebar( "after-content" ); ?>
		</ul>

	<?php endif; ?>
    </div>

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
	<?php the_widget('coenv_base_fac_cats', 'title=Research Area'); ?>
	<?php dynamic_sidebar('sidebar-widgets'); ?>
	<?php
	$ancestor_id = coenv_base_get_ancestor('ID');
	if (!function_exists('dynamic_sidebar') || !dynamic_sidebar( $ancestor_id )):
		dynamic_sidebar( $ancestor_id );
	endif;
	?>
	</aside>
	</div>
	    <?php wp_reset_postdata(); wp_reset_query(); //roll back query vars to as per the request ?>

<?php get_footer(); ?>