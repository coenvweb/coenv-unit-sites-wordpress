<?php
/*
Template Name: Publications Page
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
			<h3 class="small-12 columns">Filter Publications</h3>
			<div class="small-12 large-4 columns" data-url="/resources/publications/" data-cat="publication_theme">
				<?php coenv_base_cat_filter('publication_theme', $coenv_cat_term_1); // Category filter ?>
			</div>
			<div class="small-12 large-4 columns" data-url="/resources/publications/" data-cat="author">
				<?php coenv_base_cat_filter('author', $coenv_cat_term_1); // Category filter ?>
			</div>
			<div class="small-12 large-4 columns" data-url="/resources/publications/" data-cat="publication_year">
				<?php coenv_base_cat_filter('publication_year', $coenv_cat_term_1); // Category filter ?>
			</div>

		</div>
		<hr>
		
		<?php
		

		
		function order_by_multiple( $orderby) {
  			return "YEAR(post_date) DESC, post_title ASC";
		}



		/*
		* Publications loop
		*/ 

		$query_args = array(
			'post_type'	=> 'publications',
			'post_status' => 'publish',
			'posts_per_page' => 10,
			'paged' => $paged
		);

		// Category filter
		if($coenv_cat_1 && $coenv_cat_term_1) :
			$query_args['taxonomy'] = $coenv_cat_1;
			$query_args['term'] = $coenv_cat_term_1;
		endif;
		
		add_filter("posts_orderby", "order_by_multiple");
		$wp_query = new WP_Query( $query_args );
		remove_filter( 'posts_orderby', 'filter_query' );


		?>

		<?php if ($coenv_cat_1 == 'publication_theme'): ?>
		<div class="panel">
			<div class="left"><?php echo $wp_query->found_posts; ?> publications listed under <strong><?php echo $coenv_cat_term_1_val; ?></strong></div>
			<div class="right"><a href="/research/publications/">all publications &raquo;</a></div>
		</div>
		<?php endif; ?>
		<?php if ($coenv_cat_1 == 'author'): ?>
		<div class="panel">
			<div class="left"><?php echo $wp_query->found_posts; ?> publications written by <strong><?php echo $coenv_cat_term_1_val; ?></strong></div>
			<div class="right"><a href="/research/publications/">all publications &raquo;</a></div>
		</div>
		<?php endif; ?>
		<?php if ($coenv_cat_1 == 'publication_year'): ?>
		<div class="panel">
			<div class="left">
				<?php if($coenv_cat_term_1 == 'in-press') { ?>
				<?php echo $wp_query->found_posts; ?>
				publications that are 
				<strong>
				<?php echo strtolower($coenv_cat_term_1_val); ?>
				</strong>
				<?php } elseif (is_numeric($coenv_cat_term_1)) { ?>
				<?php echo $wp_query->found_posts; ?>
				publications published in 
				<strong>
				<?php echo $coenv_cat_term_1_val; ?>
				</strong>
				<?php } ?>
				<strong><?php echo strtolower($year_cat->name); ?></strong></div>
			<div class="right"><a href="/research/publications/">all publications &raquo;</a></div>
		</div>
		<?php endif; ?>
		<?php if ($wp_query->have_posts()): ?>
		<div class="publication clearfix">
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();

		// Publication themes list
		$publication_terms = wp_get_post_terms($post->ID, 'publication_theme');
		if (!empty($publication_terms)) {
			$publication_terms_arr = array();

			foreach ($publication_terms as &$term) {
				$publication_terms_arr[] = '<a href="?tax=publication_theme&term=' . $term->slug . '">' . $term->name . '</a>';
			}
			$publication_terms_str = implode(', ', $publication_terms_arr);
			$publication_terms = "";
		} else {
			$publication_terms_str = '';
		}

		// Publication year list
		$publication_years = wp_get_post_terms($post->ID, 'publication_year');

		if (!empty($publication_years)) {
			$publication_in_press = get_field('in_press');
			if ($publication_in_press[0] !== '1') {
				$publication_years_arr = array();
				foreach ($publication_years as &$year) {
					$publication_years_arr[] = '<a href="?tax=publication_year&term=' . $year->slug . '">' . $year->name . '</a>';
				}
				$publication_years_str = implode(', ', $publication_years_arr);
			} else {
				$publication_years_str = '<a href="?tax=publication_year&term=in-press">In press</a>';
			}
		} else {
			$publication_years_str = '';	
		}

		$publication_link = get_the_permalink();
		$publication_citation = get_field('publication_citation');
		$abstract = get_field('publication_abstract');
		$rows = get_field('publication_link');
		?>
		<div class="pub-list-item post-<?php the_ID() ?>">
		<div class="post-content left">
		<?php
		echo '<h2><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>';
		if (!empty($publication_terms_str) || !empty($publication_years_str)) {
		echo '<div class="post-meta clearfix">';
			echo $publication_years_str;
			if (!empty($publication_terms_str)) {
				echo '&nbsp;&nbsp;/&nbsp;&nbsp;' . $publication_terms_str; 
			}
		echo '</div>';
		}
		echo '<p>' . strip_tags( $publication_citation, '<a>' ) . '</p>';
		echo '<a class="button" href="' . get_the_permalink() .'">Read more</a>';
		echo '</div>';
		echo '</div>';
		$publication_terms_arr = "";
		$publication_years_arr = "";
		endwhile;
		?>
	</div>
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
