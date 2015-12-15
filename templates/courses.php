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
		<div class="row filters">
			<div class=" large-4 columns" data-url="<?php $_SERVER['REQUEST_URI']; ?>" data-cat="publication_theme">
				<?php coenv_base_cat_filter('publication_theme', $coenv_cat_term_1); // Category filter ?>
			</div>
			<div class="large-4 columns" data-url="<?php $_SERVER['REQUEST_URI']; ?>" data-cat="author">
				<?php coenv_base_cat_filter('author', $coenv_cat_term_1); // Category filter ?>
			</div>
			<div class="large-4 columns" data-url="<?php $_SERVER['REQUEST_URI']; ?>" data-cat="publication_year">
				<?php coenv_base_cat_filter('publication_year', $coenv_cat_term_1); // Category filter ?>
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

		<?php if ($coenv_cat_1 == 'course_quarters'): ?>
		<div class="panel">
			<div class="left"><?php echo $wp_query->found_posts; ?> courses listed under <strong><?php echo $coenv_cat_term_1_val; ?></strong></div>
			<div class="right"><a href="/education/courses-and-seminars/">all courses &raquo;</a></div>
		</div>
		<?php endif; ?>
		<?php if ($coenv_cat_1 == 'author'): ?>
		<div class="panel">
			<div class="left"><?php echo $wp_query->found_posts; ?> courses offered by <strong><?php echo $coenv_cat_term_1_val; ?></strong></div>
			<div class="right"><a href="/education/courses-and-seminars/">all courses &raquo;</a></div>
		</div>
		<?php endif; ?>
		<?php if ($coenv_cat_1 == 'publication_year'): ?>
		<div class="panel">
			<div class="left">
				<?php if($coenv_cat_term_1 == 'in-press') { ?>
				<?php echo $wp_query->found_posts; ?>
				courses that are 
				<strong>
				<?php echo strtolower($coenv_cat_term_1_val); ?>
				</strong>
				<?php } elseif (is_numeric($coenv_cat_term_1)) { ?>
				<?php echo $wp_query->found_posts; ?>
				courses offered in 
				<strong>
				<?php echo $coenv_cat_term_1_val; ?>
				</strong>
				<?php } ?>
				<strong><?php echo strtolower($year_cat->name); ?></strong></div>
			<div class="right"><a href="/education/courses-and-seminars/">all courses &raquo;</a></div>

		<?php endif; ?>
		<?php if ($wp_query->have_posts()): ?>
        <ul class="accordion courses clearfix" data-accordion>
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
        ?>
		<li class="course-list-item post-<?php the_ID() ?>">
        <?php
        $terms = wp_get_post_terms($post->ID, 'course_quarter', $args );
        $quarter =  $terms[0]->name;
        echo '<h5>' . get_field('course_acronym') . ' | ' . $quarter . '</h5>';
		echo '<h4>' . get_the_title() . '</h4>';
        echo '<p>Credits: ' . get_field('number_of_credits') . ' | Meeting times: ' . get_field('class_meeting_times') . ' | Location: ' . get_field('location') . '</p>';
		echo '<div class="course-description">' . get_field('course_description') . '</div>';
        echo '<div class="course-link"><a class="button" href="' . get_the_permalink() .'">See Details</a></div>';
        if (get_field('course_website') ) {
		echo '<div class="course-link"><a class="button" href="' . get_field('course_website') .'" target="_blank">View course website</a></div>';
        }
		$publication_terms_arr = "";
		$publication_years_arr = "";
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
  	<p>We're sorry. Your crtieria did not match any publications. <a href="/research/publications">Return to all publications &raquo;</a></p>
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
