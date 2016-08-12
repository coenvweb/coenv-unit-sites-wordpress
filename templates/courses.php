<?php
/*
Template Name: Courses Page
*/

/*
 * Query variables
 */

// Categories
if (isset($_GET['tax'])) {
    $coenv_cat_1 = urlencode(htmlentities($_GET['tax']));
}
if (isset($_GET['term'])) {
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
    $coenv_cat_term_1 = $qtr_term_0->slug;
    $coenv_cat_term_1_arr = $qtr_term_0;
    $coenv_cat_term_1_val = $coenv_cat_term_1_arr->name;
}
?>
<?php get_header(); ?>
<div class="row">
	<div class="small-12 medium-push-4 medium-8 large-push-3 large-9 columns" role="main">
		<div class="entry-content">
        <header class="article__header">
		    <h1 class="article__title"><?php the_title(); ?></h1>
            
            <div class="row filters">
                <div class="large-12 columns" data-url="<?php $_SERVER['REQUEST_URI']; ?>" data-cat="course_quarter">
                    <?php

                    $cats_args  = array(
                        'orderby' => 'id',
                        'order' => 'DESC',
                        'taxonomy' => 'course_quarter',
                        'hide_empty' => 0,
                        'number' => 0,
                        'offset' => 0
                    );
                    $cats = get_terms($cats_args);
                    if ($cats) {
                        echo '<div class="show-for-medium-up">';
                        $old_cats = [];
                        $i = -1;
                        foreach(array_reverse($cats) as $cat) { 
                            $selected = $cat->slug == $coenv_cat_term_1 ? ' active' : '';
                            if ($current_quarters[0] == $cat->term_id) {
                                $old_cat_selected = $old_cats[$i]->slug == $coenv_cat_term_1 ? ' active' : '';
                                echo '<a class="button' . $old_cat_selected . '" href="?tax=course_quarter&term=' . $old_cats[$i]->slug . '">' . $old_cats[$i]->name . '</a>';
                                echo '<a class="button' . $selected . '" href="?tax=course_quarter&term=' . $cat->slug . '">' . $cat->name . '</a>';
                                $new_cats = true;
                            } elseif (isset($new_cats)){
                                echo '<a class="button' . $selected . '" href="?tax=course_quarter&term=' . $cat->slug . '">' . $cat->name . '</a>';
                            } else {
                                $old_cats[]= $cat;
                                $i++;
                            }
                        }
                        echo '</div>';
                        $GLOBALS['old_cats'] = $old_cats;
                    }
                    echo '<div class="course-wrap show-for-small-only">';
                        coenv_base_cat_filter('course_quarter', $coenv_cat_term_1);
                    echo '</div>';
                    // Category filter ?>
                </div>
            </div>
        </header>
		
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
				<?php echo $wp_query->found_posts; ?>
				courses offered in 
				<?php echo $coenv_cat_term_1_val; ?>
        </div>
		<?php endif; ?>
		<?php if ($wp_query->have_posts()): ?>
        <ul class="courses">
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
        $terms = wp_get_post_terms($post->ID, 'course_quarter' );
        $categories = wp_get_post_terms($post->ID, 'course_category');
        if($categories) {
            foreach($categories as $category) {
                $course_categories[] = $category;
            }
        }
        $quarter_name = get_field('quarter');
        $course_year = substr( $terms[0]->slug , -4);
        if( have_rows('instructor(s)') ) {
            // loop through the rows of data
            while ( have_rows('instructor(s)') ) : the_row();
            // display a sub field value
            if (get_sub_field('instructor_link')) {
                    $instructors[] = '<a href="' . get_sub_field('instructor_link') . '">' . get_sub_field('instructor_name') . '</a> ';
                } else {
                    $instructors[] = get_sub_field('instructor_name');
                }
            endwhile;
            $instructors = implode(', ',$instructors);
        }?>
		<li class="course-list-item post-<?php the_ID() ?>">
        <?php
        echo '<span class="acro-quarter">' . get_field('course_acronym') . ' | <a href="?tax=course_quarter&term='. $terms[0]->slug . '">' . $quarter_name . ' ' . $course_year . '</a>' . (isset($course_categories) ? ' | ' : '');
        $counter = 0;
        if($course_categories) {
            foreach($course_categories as $category) {
                if($counter > 0) {
                    echo ", ";
                }
                echo $category->name;
                $counter++;
            }
        }
        echo '</span>';
        unset($course_categories);
		echo '<a href="' . get_the_permalink() . '"><h4>' . get_the_title() . '</h4></a>';
            
        if (isset($instructors)) {
            echo '<p class="credits-instructor">Credits: ' . get_field('number_of_credits') . ' | Instructor(s): ' . $instructors . '</p>';
            unset ($instructors);
        } else {
            echo '<p class="credits-instructor">Credits: ' . get_field('number_of_credits');
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
	<?php do_action('foundationPress_after_content'); ?>
	<ul class="widget-area after-content">
	<?php dynamic_sidebar("after-content"); ?>
	</ul>
	<?php endif; ?>
	<a href="#" class="back-to-top">Back to Top</a>
	<?php do_action('foundationPress_after_content'); ?>
	</div>
    </div>
<?php wp_reset_postdata(); wp_reset_query(); //roll back query vars to as per the request ?>
    <?php get_sidebar(); ?>
</div>
</div>
<?php get_footer(); ?>
