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
$coenv_inpress = urlencode(htmlentities($_GET['inpress']));
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>
<?php get_header(); ?>
<div class="row">
	<div class="small-12 medium-8 columns" role="main">
		<div class="entry-content">
		<h1 class="article__title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
            <?php the_content(); ?>
		<div class="row filters">
			<div class=" large-6 columns" data-url="<?php $_SERVER['REQUEST_URI']; ?>" data-cat="course_quarter">
				<?php coenv_base_cat_filter('course_quarter', $coenv_cat_term_1); // Category filter ?>
			</div>
		</div>
		<hr>
		
		<?php
		echo $coenv_inpress;
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
			<div class="right"><a href="../courses-and-seminars">all courses &raquo;</a></div>
        </div>

		<?php endif; ?>
		<?php if ($wp_query->have_posts()): ?>
        <ul>
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
        ?>
		<li class="course-list-item post-<?php the_ID() ?>">
        <?php
        $terms = wp_get_post_terms($post->ID, 'course_quarter', $args );
        echo '<h5>' . get_field('course_acronym') . ' | <a href="?tax=course_quarter&term=' . $terms[0]->slug . '">' . $terms[0]->name . '</a></h5>';
		echo '<a href="' . get_field('course_website') .'"><h4>' . get_the_title() . '</h4></a>';
        echo '<p>Credits: ' . get_field('number_of_credits') . ' | Meeting times: ' . get_field('class_meeting_times') . ' | Location: ' . get_field('location') . '</p>';
		echo '<div class="course-description">' . get_field('course_description') . '</div>';
        echo '<div class="course-link"><a class="button" href="' . get_the_permalink() .'">See Details</a></div>';
        if (get_field('course_website') ) {
		echo '<div class="course-link"><a class="button" href="' . get_field('course_website') .'">View course website</a></div>';
        }
        echo '</li>';
		endwhile;
		?>
    </ul>
	<div class="pager">
	<?php if ( function_exists('FoundationPress_pagination') ) { FoundationPress_pagination(); } else if ( is_paged() ) { ?>
		<nav id="post-nav">
			<div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', 'FoundationPress' ) ); ?></div>
			<div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'FoundationPress' ) ); ?></div>
		</nav>
	<?php } ?>
	</div>
  	<?php else: ?>
  	<p>We're sorry. Your crtieria did not match any courses. <a href="pcc/education/courses-and-seminars/">Return to all courses &raquo;</a></p>
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
