<?php
/*
Template Name: Staff Index
*/

/*
 * Query variables
 */

?>

<?php get_header(); ?>
<div class="row">
	<div class="small-12 medium-8 columns" role="main" id="main-col">
		<div class="entry-content">
		    <h1 class="article__title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
		<?php
		/**
		  * Blog loop
		  */
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $query_args = array(
			'post_type'	=> 'members',
			'post_status' => 'publish',
			'posts_per_page' => -1,
            'meta_query' => array(
                'relation' => 'AND',
                'staff_clause' => array(
                    'key' => 'staff_member',
                    'value' => '"staff"',
                    'compare' => 'LIKE',
                ),
                'name_clause' => array(
                    'key' => 'last_name',
                    'compare' => 'EXISTS',
                ),
            ),
            'orderby' => array(
                'name_clause' => 'ASC',
            ),
			'paged' => $paged,
		);
		
		$wp_query = new WP_Query( $query_args );
		?>
        <hr>
		<?php if ($wp_query->have_posts()):
        
		# The Loop
		while ( $wp_query->have_posts() ) :
		    $wp_query->the_post();
		    get_template_part( 'partials/partial', 'staff' );
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
