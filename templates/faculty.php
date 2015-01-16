<?php
/*
Template Name: Faculty Index
*/

?>

<?php get_header(); ?>
<div class="row">

<div class="small-12 medium-8 columns right" role="main">
    <div class="entry-content">
<?php

$fac_cat = get_term_by( 'slug', (string) $_GET['term'], 'research_areas' );
$fac_cat = $fac_cat->slug;

$cats_args  = array(
  'orderby' => 'name',
  'order' => 'ASC',
  'taxonomy' => 'research_areas'
  );
$cats = get_categories($cats_args);
if ($cats) {
     echo '<div class="cat-list">';
     echo '<h3 class="cat-title">Our faculty work on:</h3>';
     echo '<ul class="small-block-grid-2 fac-cats">';
     foreach($cats as $cat) { 
          echo '<li><a class="button" href="/faculty-research/research-areas/' . $cat->slug . '/">' . $cat->name . '</a></li>';
     }
     echo '</ul>';
     echo '</div><hr />';
     echo '<h2>Teaching and Research Faculty</h2>';
}

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
	'meta_key' => 'last_name',
	'orderby' => 'meta_value',
	'order' => 'ASC',
	'meta_query' => array(
		array(
			'key'     => 'last_name',
			'compare' => 'IN',
		),
	),
);

$wp_query = new WP_Query( $query_args );

?>
	<?php if ($wp_query->have_posts()): ?>
	<div class="faculty-list-teach clearfix">
        <ul class="small-block-grid-3">
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
		$faculty_thumb = get_the_post_thumbnail(get_the_ID(),'medium');
		$faculty_link = get_the_permalink();
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
