<?php
/*
Template Name: Faculty Index
*/

?>

<?php get_header(); ?>
<div class="row">

	<div class="small-12 medium-8 columns right" role="main">
        <div class="entry-content">
            <?php get_template_part( 'partials/partial', 'article' ) ?>
<?php

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
	'paged' => $paged,
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
	<ul class="faculty-list-teach clearfix small-block-grid-2" data-equalizer>

		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
		$faculty_thumb = get_the_post_thumbnail(get_the_ID(),'thumbnail');
		$faculty_link = get_the_permalink();
		$faculty_phone_rows = get_field('phone_number');
		$faculty_email = str_replace('u.washington.edu','uw.edu',get_field('email_address'));
		$first_faculty_phone_row = $faculty_phone_rows[0];
		$first_faculty_phone = $first_faculty_phone_row['number' ];
		$faculty_title_rows = get_field('job_titles' );
		$first_faculty_title_row = $faculty_title_rows[0];
		$first_faculty_title = $first_faculty_title_row['job_title'];
		$faculty_img = get_the_post_thumbnail($post->ID, 'thumbnail', array( 'class' => 'left' ));
		if (!$faculty_img) {
		$faculty_img_src = get_template_directory_uri() . '/assets/img/blank-153x153.jpg';
		}
        echo '<li class="faculty-list-item" data-equalizer-watch>';
		echo '<a href="' . $faculty_link . '">' . $faculty_img . '</a>';
		echo '<a href="' . get_the_permalink() . '"><h3 class="faculty-name">' . get_the_title() . '</h3>';
        echo '<h4>' . $first_faculty_title . '</h4></a>';
        echo '<a href="tel:+1'.$first_faculty_phone . '">' . $first_faculty_phone . '</a><br />';
        echo '<a href="mailto:'.$faculty_email . '">' . $faculty_email . '</a>';
		echo '</li>';
		endwhile;
		?>
	<?php endif; ?>
        </ul>
    </div>
	<?php if ( is_active_sidebar( 'after-content' ) ) : ?>
	<?php do_action('foundationPress_after_content'); ?>
	<ul class="widget-area after-content">
	<?php dynamic_sidebar("after-content"); ?>
	</ul>
	<?php endif; ?>
	<?php do_action('foundationPress_after_content'); ?>
	</div>
	    <?php wp_reset_postdata(); wp_reset_query(); //roll back query vars to as per the request ?>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
