<?php
/*
Template Name: Faculty Index
*/

/*
 * Query variables
 */

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
            <div class="share columns large-6 right" data-article-id="<?php the_ID(); ?>" data-article-title="<?php echo get_the_title(); ?>"
		data-article-shortlink="<?php echo wp_get_shortlink(); ?>"
		data-article-permalink="<?php echo the_permalink(); ?>"><a href="#"><i class="fi-share"></i>Share</a></div>
        	<h1><a href="/faculty"><?php echo the_title(); ?></a></h1>

<?php

$fac_cat = get_term_by( 'slug', (string) $_GET['term'], 'research_areas' );
          $fac_cat = $fac_cat->slug;
          
          if ( ! empty( $instance['title'] ) ) {
               echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
          }
          if ( ! empty( $instance['textarea'] ) ) {
               echo $args['before_text'] . apply_filters( 'widget_text', $instance['textarea'] ). $args['after_text'];
          }
                    $cats_args  = array(
                      'orderby' => 'name',
                      'order' => 'ASC',
                      'taxonomy' => 'research_areas'
                      );
                    $cats = get_categories($cats_args);
                    if ($cats) {
                         echo '<h3 class="cat-title">Our faculty work on:</h3>';
                         echo '<ul class="small-block-grid-2 fac-cats">';
                         if ($fac_cat):
                              echo '<li><a class="button" href="/faculty-research/faculty">All Research Areas</a></li>';
                         endif;
                         foreach($cats as $cat) { 
                              echo '<li><a class="button" href="/faculty-research/faculty/?tax=research_areas&term=' . $cat->slug . '">' . $cat->name . '</a></li>';
                         }
                         echo '</ul>';
                    }

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
	<div class="faculty-list-teach clearfix">

<?php if ($coenv_cat_1): // Category filter ?>
		<div class="panel">
			<div class="left"><?php echo $wp_query->found_posts; ?> faculty working in <strong><?php echo $coenv_cat_term_1_val; ?></strong></div>
			<div class="right"><a href="/research/faculty/">all posts &raquo;</a></div>
		</div>
	<?php endif; ?>
        <ul class="small-block-grid-3">
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
		$faculty_thumb = get_the_post_thumbnail(get_the_ID(),'medium');
		$faculty_link = get_the_permalink();
		$faculty_phone_rows = get_field('phone_number');
		$faculty_email = str_replace('u.washington.edu','uw.edu',get_field('email_address'));
		$first_faculty_phone_row = $faculty_phone_rows[0];
		$first_faculty_phone = $first_faculty_phone_row['number' ];
		$faculty_title_rows = get_field('job_titles' );
		$first_faculty_title_row = $faculty_title_rows[0];
		$first_faculty_title = $first_faculty_title_row['job_title'];
		$faculty_img_src = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
		if (!$faculty_img_src) {
		$faculty_img_src = get_template_directory_uri() . '/assets/img/blank-full.jpg';
		}
		echo '<li class="faculty-list-item">';
		echo '<a href="' . $faculty_link . '"><img src="' . $faculty_img_src . '"" alt="' . get_the_title() . '" /></a>';
		echo '<h4><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h4>';
		echo '</li>';
		endwhile;
		?>
        </ul>
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
