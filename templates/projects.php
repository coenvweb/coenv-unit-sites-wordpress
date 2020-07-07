<?php
/*
Template Name: Projects Index
*/

$filtered = false;
//Project Year
if(isset($wp_query->query_vars['project-year']) && $wp_query->query_vars['project-year']){
    $project_year = urlencode(htmlentities($wp_query->query_vars['project-year']));
    $project_year_arr = get_term_by('slug',$funding_year,'project-year');
    $project_year_val = $funding_year_arr->name;
    $filtered = true;
} else {
    $project_year = null;
}

//Project Region
if(isset($wp_query->query_vars['project-region']) && $wp_query->query_vars['project-region']){
    $project_region = urlencode(htmlentities($wp_query->query_vars['project-region']));
    $project_region_arr = get_term_by('slug',$state,'project-region');
    $project_region_val = $state_arr->name;
    $filtered = true;
} else {
    $project_region = null;
}

//Topic
if(isset($wp_query->query_vars['project-topic']) && $wp_query->query_vars['project-topic']){
    $project_topic = urlencode(htmlentities($wp_query->query_vars['project-topic']));
    $project_topic_arr = get_term_by('slug',$topic,'project-topic');
    $project_topic_val = $topic_arr->name;
    $filtered = true;
} else {
    $project_topic = null;
}

//Current
if(isset($_GET['project_status'])) {
    $project_status = urlencode(htmlentities($_GET['project_status']));
    $filtered = true;
} else {
    $project_status = '';
}

if(isset($wp_query->query_vars['project-search']) && $wp_query->query_vars['project-search']) {
	$project_search = urldecode($wp_query->query_vars['project-search']);
	$filtered = true;
}

// WP Query

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

if(empty($project_search) && !empty($project_status)) {
	$meta_query = array(
		array(
			'key' => 'project_status',
			'value' => 'In Progress',
			'compare' => '=',
		),
	);
}


if(isset($project_search)) {
	$meta_query['relation'] = 'AND';
	$meta_query[] = array(
		'relation' => 'OR',
		array (
			'key' => 'project_status',
			'value' => $project_search,
			'compare' => 'LIKE',
		),
		array (
			'key' => 'funding_agencies_0_agency',
			'value' => $project_search,
			'compare' => 'LIKE',
		),
		array (
			'key' => 'funding_agencies_1_agency',
			'value' => $project_search,
			'compare' => 'LIKE',
		),
		array (
			'key' => 'funding_agencies_2_agency',
			'value' => $project_search,
			'compare' => 'LIKE',
		),
		array (
			'key' => 'funding_agencies_3_agency',
			'value' => $project_search,
			'compare' => 'LIKE',
		),
		array (
			'key' => 'investigators_0_name',
			'value' => $project_search,
			'compare' => 'LIKE',
		),
		array (
			'key' => 'investigators_1_name',
			'value' => $project_search,
			'compare' => 'LIKE',
		),
		array (
			'key' => 'investigators_2_name',
			'value' => $project_search,
			'compare' => 'LIKE',
		),
		array (
			'key' => 'investigators_3_name',
			'value' => $project_search,
			'compare' => 'LIKE',
		),
		array (
			'key' => 'investigators_4_name',
			'value' => $project_search,
			'compare' => 'LIKE',
		),
		array (
			'key' => 'investigators_5_name',
			'value' => $project_search,
			'compare' => 'LIKE',
		),
		array (
			'key' => 'investigators_6_name',
			'value' => $project_search,
			'compare' => 'LIKE',
		),
		array (
			'key' => 'investigators_7_name',
			'value' => $project_search,
			'compare' => 'LIKE',
		),
		array(
			'key' => 'science_themes_0_theme',
			'value' => $project_search,
			'compare' => 'LIKE',
		),
		array(
			'key' => 'science_themes_1_theme',
			'value' => $project_search,
			'compare' => 'LIKE',
		),
		array(
			'key' => 'science_themes_2_theme',
			'value' => $project_search,
			'compare' => 'LIKE',
		),
		array(
			'key' => 'science_themes_3_theme',
			'value' => $project_search,
			'compare' => 'LIKE',
		),
    array (
        'key' => 'title',
        'value' => $project_search,
        'compare' => 'LIKE',
    ),
    array (
        'key' => 'content',
        'value' => $project_search,
        'compare' => 'LIKE',
    ),
	);
    if (!empty($project_status)) {
        $meta_query[] = array (
            'relation' => 'AND',
            array(
              'key' => 'project_status',
              'value' => 'In Progress',
              'compare' => '=',
            ),
        );
    }
	$query_args['_meta_or_title'] = $project_search;
} else {
    $meta_query[] = array();
}

$query_args = array(
	'post_type' => 'projects',
	'post_status' => 'publish',
	'posts_per_page' => 15,
	'paged' => $paged,
	'meta_query' => $meta_query,
);

if(isset($project_search)) {
	$query_args['_meta_or_title'] = $project_search;
}

if($project_topic) {
	$query_args['tax_query'][] = array(
		'taxonomy' => 'project_topic',
		'field' => 'slug',
		'terms' => $project_topic,
	);
}

if($project_region) {
	$query_args['tax_query'][] = array(
		'taxonomy' => 'project_region',
		'field' => 'slug',
		'terms' => $project_region,
	);
}

if($project_year) {
	$query_args['tax_query'][] = array(
		'taxonomy' => 'project_year',
		'field' => 'slug',
		'terms' => $project_year,
	);
}

?>
<?php get_header(); 
$wp_query = new WP_Query($query_args);
?>
<div class="row">
	<div class="small-12 medium-9 columns" role="main" id="main-col">
      <article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>
		<div class="entry-content">
        <header class="article__header">
            <div class="article__meta">
            </div>
              <h1 class="article__title"><?php the_title() ?></h1>
        </header>
        <?php the_content(); ?>
			<div class="filters no-auto">
          <p class="filter-label columns">Filter Projects:</p>
				<form method="get" class="search-form filter-form" action="<?php the_permalink() ?>">
					<div class=" large-4 columns" data-url="<?php the_permalink() ?>" data-cat="blog_category topic">
						<?php coenv_base_no_auto_filter('project_topic', $project_topic); // Category filter ?>
					</div>
					<div class=" large-4 columns" data-url="<?php the_permalink() ?>" data-cat="blog_category region">
						<?php coenv_base_no_auto_filter('project_region', $project_region); // Category filter ?>
					</div>
					<div class=" large-4 columns" data-url="<?php the_permalink() ?>" data-cat="blog_category year">
						<?php coenv_base_no_auto_filter('project_year', $project_year); // Category filter ?>
					</div>
					<div class=" large-7 columns">
						<label for="project-search" class="hidden" aria-hidden="true">Search projects</label>
						<input value="<?php if(isset($project_search)){echo $project_search;}; ?>" name="project-search" id="project-search" placeholder="Search projects" aria-label="Search" title="Search" type="text">
					</div>
					<div class="submit large-2 columns right">
						<button type="submit"><i class="fi-magnifying-glass"></i><span> Apply</span></button>
					</div>
					<div class="current-check large-3 columns right">
						<input type="checkbox" id="project_status" name="project_status" value="In Progress" class="left" <?php if ($project_status == 'In+Progress'){echo 'checked';}; ?>><label for="project_status">Current projects</label>
						
					</div>
				</form>
			</div>
		<?php if ($wp_query->have_posts()) {  ?>
			<?php if ($filtered) { ?>
				<div class="panel">
					<div class="left"><?php echo $wp_query->found_posts; ?> projects matching your filters</div>
					<div class="right close"><a href="<?=the_permalink()?>"> All projects <i class="fi-x"></i></a></div>
				</div>
			<?php } ?>
			<div class="projects row">
				<?php
				# The Loop
				while ( $wp_query->have_posts() ) {
					$wp_query->the_post();
					get_template_part( 'partials/partial', 'project-preview' );
				} ?>
			</div>
			<div class="pager">
				<?php if ( function_exists('FoundationPress_pagination') ) { FoundationPress_pagination(); } else if ( is_paged() ) { ?>
					<nav id="post-nav">
						<div class="post-previous"><?php //next_posts_link( __( '&larr; Older posts', 'FoundationPress' ) ); ?></div>
						<div class="post-next"><?php //previous_posts_link( __( 'Newer posts &rarr;', 'FoundationPress' ) ); ?></div>
					</nav>
				<?php } ?>
			</div>
		<?php } else { ?>
			<p>We're sorry. Your crtieria did not match any projects. <a href="<?php the_permalink()?>">Return to all projects &raquo;</a></p>
		<?php } 
			wp_reset_postdata();
			wp_reset_query();
		?>
		</div>
                </article>
        <?php do_action('foundationPress_after_content'); ?>
        <?php if ( is_active_sidebar( 'after-content' ) ) { ?>
            <div id="after-content" class="before-content widget-area" role="complementary">
                <?php dynamic_sidebar( 'after-content' ); ?>
            </div><!-- #after-content -->
        <?php } ?>
        <a href="#" class="back-to-top">Back to Top</a>
	</div>
    <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
