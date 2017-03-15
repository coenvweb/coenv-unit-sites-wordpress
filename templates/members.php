<?php
/*
Template Name: Members Index
*/

/*
 * Query variables
 */

if(isset($wp_query->query_vars['research-areas'])) {
    $research_areas = urldecode($wp_query->query_vars['research-areas']);
}
if(isset($wp_query->query_vars['member-type'])) {
    $member_type = urldecode($wp_query->query_vars['member-type']);
}
if(isset($wp_query->query_vars['member-search'])) {
    $member_search = urldecode($wp_query->query_vars['member-search']);
}
?>

<?php get_header(); ?>
<div class="row">
	<div class="member-template small-12 medium-8 columns" role="main" id="main-col">
		<div class="entry-content">
		<h1 class="large-12 columns article__title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
		<div class="row filters">
			<div class=" large-4 columns" data-url="<?php the_permalink() ?>" data-cat="blog_category">
				<?php coenv_base_cat_filter('research-areas', $research_areas); // Category filter ?>
			</div>
			<div class=" large-4 columns" data-url="<?php the_permalink() ?>" data-cat="blog_category">
				<?php coenv_base_cat_filter('member-type', $member_type); // Category filter ?>
			</div>
			<div class="large-4 columns project_search" data-url="<?php the_permalink() ?>" data-cat="member-search">
                <form role="search" method="get" class="search-form" action="<?php the_permalink() ?>">
                    <div class="field-wrap">
                        <label for="member-search">Search members</label>
                        <input value="<?=$member_search?>" name="member-search" id="s" placeholder="Search members" aria-label="Search" title="Search" type="text">
                        <button type="submit"><i class="fi-magnifying-glass"></i><span>Search</span></button>
                    </div>
                </form>
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
			'meta_query' => array(
                'relation' => 'AND',
                'staff_clause' => array(
                    'key' => 'staff_member',
                    'value' => '"member"',
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

		if($member_search) {
            $query_args['s'] = $member_search;
        }

        if($research_areas) {
           $query_args['tax_query'][] = array(
                'taxonomy' => 'research-areas',
                'field' => 'slug',
                'terms' => $research_areas,
            ); 
        }        

        if(!isset($member_type)) {
           $query_args['tax_query'][] = array(
                'taxonomy' => 'member-type',
                'field' => 'slug',
                'terms' => 'former-member',
                'operator' => 'NOT IN',
            ); 
        }
        
        if($member_type) {
            $query_args['tax_query'][] = array(
                'taxonomy' => 'member-type',
                'field' => 'slug',
                'terms' => $member_type,
            );
        }
		

		$wp_query = new WP_Query( $query_args );
		?>
		<?php if ($wp_query->have_posts()):
        if($research_areas) {
            $term = get_term_by('slug', $research_areas, 'research-areas');
            ?>
            <div class="panel">
                <?php echo $wp_query->found_posts; ?> member<?=($wp_query->found_posts > 1 ? 's' : '')?> working in <strong><?php echo $term->name; ?></strong> <a class="right button" href="<?php the_permalink(); ?>">All Members</a>
            </div>
            <?php
         }
         if($member_type) {
            $term = get_term_by('slug', $member_type, 'member-type');
            ?>
            <div class="panel">
                <?php echo $wp_query->found_posts; ?> <strong><?php echo $term->name; ?><?=($wp_query->found_posts > 1 ? 's' : '')?></strong> <a class="button right" href="<?php the_permalink(); ?>">All Members</a>
            </div>
            <?php
         }
         if($member_search) {
            ?>
            <div class="panel">
                <?php echo $wp_query->found_posts; ?> member<?=($wp_query->found_posts > 1 ? 's' : '')?> matching <strong><?=$member_search?></strong> <a class="button right" href="<?php the_permalink(); ?>">All Members</a>
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
  	<p>We're sorry. Your criteria did not match any qrc members.</p>
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
