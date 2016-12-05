<?php
/*
Template Name: Member Projects Index
*/

/*
 * Query variables
 */

if(isset($wp_query->query_vars['project-category'])) {
    $project_categories = urldecode($wp_query->query_vars['project-category']);
}

if(isset($wp_query->query_vars['project-search'])) {
    $project_search = urldecode($wp_query->query_vars['project-search']);
}

$funding_type = get_field('funding_type');
$page_link = get_the_permalink();
?>

<?php get_header(); ?>
<div class="row">
	<div class="member-projects small-12 medium-8 columns" role="main" id="main-col">
		<div class="entry-content">
		    <h1 class="article__title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
		<div class="row filters">
			<div class="large-6 columns" data-url="<?php the_permalink() ?>" data-cat="project-category">
				<?php coenv_base_cat_filter('project-category', $project_categories); // Category filter ?>
			</div>
			<div class="large-6 columns project_search" data-url="<?php the_permalink() ?>" data-cat="project-search">
				<form role="search" method="get" class="search-form" action="<?php the_permalink() ?>">
					<div class="field-wrap">
						<label for="project-search">Search member projects</label>
						<input value="<?= $project_search ?>" name="project-search" id="s" placeholder="Search member projects" aria-label="Search" title="Search" type="text">
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
        

        if($funding_type) {
            $meta_query = array(
                array(
                    'key' => 'funding_type',
                    'value' => $funding_type,
                    'compare' => '=',
                ),
            );
        }

        if($project_search) {
            $meta_query['relation'] = 'AND';
            $meta_query[] = array(
                'relation' => 'OR',
                array (
                    'key' => 'project_pi',
                    'value' => $project_search,
                    'compare' => 'LIKE',
                ),
                array(
                    'key' => 'project_description',
                    'value' => $project_search,
                    'compare' => 'LIKE',
                ),
            );
        }

        $query_args = array(
			'post_type'	=> 'member_projects',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'paged' => $paged,
            'meta_query' => $meta_query,
		);

        if($project_categories) {
            $query_args['tax_query'][] = array(
                'taxonomy' => 'project-category',
                'field' => 'slug',
                'terms' => $project_categories,
            );
        }

		$wp_query = new WP_Query( $query_args );
		?>
		<?php if ($wp_query->have_posts()):
        if($project_categories) {
            $term = get_term_by('slug', $project_categories, 'project-category');
            ?>
            <div class="panel">
                <div class="left"><?php echo $wp_query->found_posts; ?> project<?=($wp_query->found_posts > 1 ? 's' : '')?> in <strong><?php echo $term->name; ?></strong></div>
            </div>
            <?php
        }
        if($project_search) {
            ?>
            <div class="panel">
                <div class="left"><?php echo $wp_query->found_posts; ?> project<?=($wp_query->found_posts > 1 ? 's' : '')?> matching <strong><?php echo $project_search; ?></strong></div>
            </div>
            <?php
        }
        ?>
        <hr>
        <ul class="projects-list">
        <?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		    $wp_query->the_post();
		    get_template_part('partials/partial', 'member-project');
        ?>
	<?php endwhile; ?>
  	<?php else: ?>
  	    <p>We're sorry. Your criteria did not match any QRC member projects.</p>
	<?php endif; ?>
        </ul>
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
