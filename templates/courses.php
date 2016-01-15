<?php
/*
Template Name: Courses Page
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
$current_quarters = get_field('quarter_to_display');
$qtr_term_0 = get_term_by('id', $current_quarters[0], 'course_quarter');
$qtr_term_1 = get_term_by('id', $current_quarters[1], 'course_quarter');
if (empty($coenv_cat_1)) {
    $coenv_cat_1 = 'course_quarter';
    $coenv_cat_term_1 = $qtr_term_0->slug;
    $coenv_cat_term_1_arr = $qtr_term_0;
    $coenv_cat_term_1_val = $coenv_cat_term_1_arr->name;
}
?>
<?php get_header(); ?>
<div class="row">
	<div class="small-12 medium-8 columns" role="main">
		<div class="entry-content">
		<h1 class="article__title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
            <?php echo 'Current Quarter: ' . $qtr_term_0->name . ($qtr_term_1->name); ?>
            <?php the_content(); ?>
            
		<div class="row filters">
			<div class=" large-12 columns" data-url="<?php $_SERVER['REQUEST_URI']; ?>" data-cat="course_quarter">
				<?php 
$tax_obj = get_taxonomy($tax);
$tax_str = $tax_obj->labels->name;

$cats_args  = array(
	'orderby' => 'term_group',
	'order' => 'ASC',
	'taxonomy' => 'course_quarter',
    'hide_empty' => 0
);
$cats = get_categories($cats_args);
	if ($cats) {
        $i = 6;
        echo '<div>';
		foreach($cats as $cat) { 
            $year = substr( $cat->slug , -4);
            if($i % 6 == 0) {echo '</div><div><p> Academic Year: ' . ($year - 1) . ' - ' . $year . '</p>';}
			$selected = $cat->slug == $coenv_cat_term_1 ? ' active' : '';
			echo '<a class="button' . $selected . '" href="?tax=course_quarter&term=' . $cat->slug . '">' . $cat->name . '</a>';
            $i++;
            
		}
	} 
                // Category filter ?>
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
			'posts_per_page' => 20,            
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
        <ul>
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
        $terms = wp_get_post_terms($post->ID, 'course_quarter', $args ); ?>
		<li class="course-list-item post-<?php the_ID() ?>">
        <?php
        echo '<h5>' . get_field('course_acronym') . ' | <a href="?tax=course_quarter&term=' . $terms[0]->slug . '">' . $terms[0]->name . '</a></h5>';
		echo '<a href="' . get_field('course_website') .'"><h4>' . get_the_title() . '</h4></a>';
        echo '<p>Credits: ' . get_field('number_of_credits') . ' | Meeting times: ' . get_field('class_meeting_times') . ' | Location: ' . get_field('location') . '</p>';
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
</div>
<?php get_sidebar(); ?>
</div>
</div>
<?php get_footer(); ?>
