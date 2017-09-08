<?php
/*
Template Name: Intern Index
*/

/*
 * Query variables
 */

 get_header(); ?>
<div class="row">

	<div class="small-12 medium-9 columns right" role="main" id="main-col">
        <div class="entry-content">

	<?php if ($wp_query->have_posts()): ?>
	<div class="article__content clearfix">


		<?php
                        $terms = get_terms( 'years', array(
                        'hide_empty' => 0
                    ) );
                $i = 0;

                    foreach( $terms as $term ) {
                        
                        // First Placement Query
                        $args = array(
                            'post_type'     =>  'intern',
                            'post_status'   =>  'publish',
                            'order'			=>  'ASC',
                            'posts_per_page' => -1,
                            'years'          =>  $term->slug
                        );
                        $query = new WP_Query( $args );

                        echo '<h2>' . $term->name . ' Interns</h2>';
                
                        while ( $query->have_posts() ) : $query->the_post();
                             include( locate_template( 'partials/partial-intern.php', false, false ));
                        endwhile;
                        

                        // Last Name Alpha Query
                        $args = array(
                            'post_type'     =>  'intern',
                            'post_status'   =>  'publish',
                            'order'			=>  'ASC',
                            'posts_per_page' => -1,
                            'years'          =>  $term->slug,
                        );
                        $query = new WP_Query( $args );
                
                        while ( $query->have_posts() ) : $query->the_post();
                            include( locate_template( 'partials/partial-intern.php', false, false ));
                            $i++;
                        endwhile;
                        wp_reset_postdata();
                    } ?>
		

	</div>
	<?php endif; ?>
        </div>
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
<?php get_footer(); ?>
