<?php
/*
Template Name: Courses Page
*/

/*
 * Query variables
 */

// Categories
if(isset($_GET['tax'])) {
    $coenv_cat_1 = urlencode(htmlentities($_GET['tax']));
}
if(isset($_GET['term'])) {
    $coenv_cat_term_1 = urlencode(htmlentities($_GET['term']));
    $coenv_cat_term_1_arr = get_term_by('slug',$coenv_cat_term_1,$coenv_cat_1);
    $coenv_cat_term_1_val = $coenv_cat_term_1_arr->name;
}
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$current_quarters = get_field('quarter_to_display');
$qtr_term_0 = get_term_by('id', $current_quarters[0], 'course_quarter');
if (isset($current_quarters[1])) {
    $qtr_term_1 = get_term_by('id', $current_quarters[1], 'course_quarter');
};
if (empty($coenv_cat_1)) {
    $coenv_cat_1 = 'course_quarter';
    if (isset($qtr_term)) {
        $coenv_cat_term_1 = $qtr_term_0->slug;
        $coenv_cat_term_1_arr = $qtr_term_0;
        $coenv_cat_term_1_val = $coenv_cat_term_1_arr->name;
    } else {
        $coenv_cat_term_1 = $coenv_cat_term_1_arr = $coenv_cat_term_1_val = null;
    }
}
?>
<?php get_header(); ?>
<div class="row">
	<div class="small-12 medium-9 columns right" role="main" id="main-col">
		<div class="entry-content">
            <?php if(isset($qtr_term_1->name)) { echo '<h4>Upcoming Quarter: ' . $qtr_term_0->name . $qtr_term_1->name . '</h4>'; } elseif(isset($qtr_term_1->name)) {echo '<h4>Upcoming Quarter: ' . $qtr_term_0->name . '</h4>';}?>
            <?php the_content(); ?>
            
		<div class="row filters">
			<div class=" large-12 columns" data-url="<?php $_SERVER['REQUEST_URI']; ?>" data-cat="course_quarter">
				<?php

$cats_args  = array(
	'orderby' => 'none',
	'order' => 'ASC',
	'taxonomy' => 'course_quarter',
    'hide_empty' => 0
);
$cats = get_categories($cats_args);
	if ($cats) {
        $i = 4;
        echo '<div>';
		foreach($cats as $cat) { 
            $year = substr( $cat->slug , -4);
            if($i % 4 == 0) {echo '</div><div><p> Academic Year: ' . $year . ' - ' . ($year + 1) . '</p>';}
			$selected = $cat->slug == $coenv_cat_term_1 ? ' active' : '';
			echo '<a class="button' . $selected . '" href="?tax=course_quarter&term=' . $cat->slug . '">' . $cat->name . '</a>';
            $i++;
            
		}
	} 
                // Category filter ?>
			</div>
		</div>
            </div>
		<hr>
		
		<?php
		/**
		* Courses loop
		*/

		$query_args = array(
			'post_type'	=> 'courses',
			'post_status' => 'publish',
			'posts_per_page' => -1,   
            'meta_key' => 'course_acronym',
            'orderby' => 'meta_value',
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

		<?php if ($coenv_cat_1 == 'course_quarter'): ?>
		<div class="panel">
			<div class="left">
				<?php echo $wp_query->found_posts; ?>
				courses offered in 
				<strong>
				<?php echo $coenv_cat_term_1_val; ?>
				</strong>
				</div>
        </div>

		<?php endif; ?>
		<?php if ($wp_query->have_posts()): ?>
        <ul class="courses">
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
        $terms = wp_get_post_terms($post->ID, 'course_quarter' ); 
        $quarter_name = get_field('quarter');
        $course_year = substr( $terms[0]->slug , -4);
        if( have_rows('instructor(s)') ) {
            // loop through the rows of data
            while ( have_rows('instructor(s)') ) : the_row();
            // display a sub field value
            if (get_sub_field('instructor_link')) {
                    $instructors[] = '<a href="' . get_sub_field('instructor_link') . '>' . get_sub_field('instructor_name') . '</a> ';
                } else {
                    $instructors[] = get_sub_field('instructor_name');
                }
            endwhile;
            $instructors = implode(', ',$instructors);
        }?>
		<li class="course-list-item post-<?php the_ID() ?>">
        <?php
        echo '<h5>' . get_field('course_acronym') . ' | ' . $quarter_name . ' ' . $course_year . '</h5>';
		echo '<a href="' . get_the_permalink() . '"><h4>' . get_the_title() . '</h4></a>';
            
        if (isset($instructors)) {
            echo '<p>Credits: ' . get_field('number_of_credits') . ' | Instructor(s): ' . $instructors . '</p>';
            unset ($instructors);
        } else {
            echo '<p>Credits: ' . get_field('number_of_credits');
        }
        echo '<div class="course-link"><a class="button" href="' . get_the_permalink() .'">See Details</a></div>';
        echo '</li>';
		endwhile;
		?>
    </ul>
  	<?php else: ?>
  	<p>There are no courses advertised for this quarter yet. Try again later, or check another quarter.</p>
	<?php endif; ?>	
	<?php if ( is_active_sidebar( 'after-content' ) ) : ?>
		<div id="after-content" class="before-content widget-area" role="complementary">
			<?php dynamic_sidebar( 'after-content' ); ?>
		</div><!-- #after-content -->
	<?php endif; ?>
	<a href="#" class="back-to-top">Back to Top</a>
	<?php do_action('foundationPress_after_content'); ?>
    </div>
<?php wp_reset_postdata(); wp_reset_query(); //roll back query vars to as per the request ?>
<?php get_sidebar(); ?>
</div>
</div>
<?php get_footer(); ?>
