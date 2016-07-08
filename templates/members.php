<?php
/*
Template Name: Members Index
*/

/*
 * Query variables
 */

if(isset($wp_query->query_vars['research_areas'])) {
    $research_areas = urldecode($wp_query->query_vars['research_areas']);
}
?>

<?php get_header(); ?>
<div class="row">
	<div class="small-12 medium-8 columns" role="main" id="main-col">
		<div class="entry-content">
		<div class="row filters">
		    <h1 class="large-6 columns article__title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
			<div class=" large-6 columns" data-url="<?php $_SERVER['REQUEST_URI']; ?>" data-cat="blog_category">
				<?php member_research_filter('research_areas', $research_areas); // Category filter ?>
			</div>
		</div>
		<?php
		/**
		  * Blog loop
		  */
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $query_args = array(
			'post_type'	=> 'members',
			'post_status' => 'publish',
			'posts_per_page' => -1,
            'meta_key' => 'last_name',
            'orderby' => 'meta_value',
            'order'=> 'ASC',
			'paged' => $paged,
		);

        if($research_areas) {
            $query_args['tax_query'][] = array(
                'taxonomy' => 'research_areas',
                'field' => 'slug',
                'terms' => $research_areas,
            );
        }
		

		$wp_query = new WP_Query( $query_args );
		?>
		<?php if ($wp_query->have_posts()):
        if($research_areas) {
            $term = get_term_by('slug', $research_areas, 'research_areas');

        ?>
		<div class="panel">
			<div class="left"><?php echo $wp_query->found_posts; ?> member<?=($wp_query->found_posts > 1 ? 's' : '')?> working in <strong><?php echo $term->name; ?></strong></div>
		</div>
		<?php
        }
        ?>
		<hr>
        <?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		    $wp_query->the_post();
		    get_template_part( 'partials/partial', 'member' );
        ?>
	<?php endwhile; ?>
  	<?php else: ?>
  	<p>We're sorry. Your crtieria did not match any qrc members.</p>
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
<?php wp_reset_postdata(); wp_reset_query(); ?>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
