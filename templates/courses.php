<?php
/*
Template Name: Courses Index
*/

get_header();

if(isset($wp_query->query_vars['course_quarter'])){
    $coenv_cat_1 = 'course_quarter';
    $coenv_cat_term_1 = urlencode($wp_query->query_vars['course_quarter']);
    $coenv_cat_term_1_arr = get_term_by('slug',$coenv_cat_term_1,$coenv_cat_1);
    $coenv_cat_term_1_val = $coenv_cat_term_1_arr->name;
    $_GET['coenv_cat_term_1_arr'] = $coenv_cat_term_1_arr->slug;
}
if (isset($_GET['course-search'])) {
    $coenv_search_term_1 = urlencode(htmlentities($_GET['course-search']));
    $coenv_search_term_text = urldecode($coenv_search_term_1);
}
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

if (empty($coenv_cat_1)) {
    $coenv_cat_1 = 'course_quarter';
    $coenv_cat_term_1 = '';
    $coenv_cat_term_1_arr = '';
    $coenv_cat_term_1_val = '';
}

$terms = get_terms( array(
    'taxonomy' => 'course_year',
    'hide_empty' => false,
) );

$term_list = '';
foreach ($terms as $term) {
    $term_list .= '<li class="medium-3 small-6 columns course_cat button" data-filter=".' . $term->slug . '">' . $term->name . '</li>';
}

?>

<div class="row page-content">

	<div class="small-12 medium-8 columns right" role="main" id="main-col">
      <article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>
		  <div class="entry-content">
          <header class="article__header">
            <div class="article__meta">
                <h1><?php the_title(); ?></h1>
            </div>
          </header>
      <section class="article__content">
          <div class="course-filter row">
              <ul class="button-group quarter" data-filter-group="quarter">
                <li class="medium-2 small-12 columns all-quarters course_cat button active" data-filter="">All Quarters</li>
                <li class="medium-2 small-6 columns autumn course_cat button" data-filter=".Aut">Autumn</li>
                <li class="medium-2 small-6 columns winter course_cat button" data-filter=".Win">Winter</li>
                <li class="medium-2 small-6 columns spring course_cat button" data-filter=".Spr">Spring</li>
                <li class="medium-2 small-6 columns summer course_cat button" data-filter=".Sum">Summer</li>
              </ul>
              <ul class="button-group courses" data-filter-group="year button-group">
                <li class="medium-3 small-12 columns all-years year_cat button active" data-filter="">All Years</li>
                <?php echo $term_list; ?>
              </ul>
          </div>

<?php
    the_content();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$temp = $wp_query;
$wp_query = null;
$wp_query = new WP_Query();
$wp_query->query;

/**
* People loop
*/
$query_args = array(
	'post_type'	=> 'courses',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'meta_key' => 'course_acronym',
	'orderby' => 'meta_value',
	'order' => 'ASC',
	'paged' => $paged,
);
          
// Category filter
if(isset($coenv_search_term_1)) {
    $query_args['s'] = $coenv_search_term_1;
}elseif($coenv_cat_1 && $coenv_cat_term_1) {
    $query_args['taxonomy'] = $coenv_cat_1;
    $query_args['term'] = $coenv_cat_term_1;
};

$wp_query = new WP_Query( $query_args );

?>
	<?php if ($wp_query->have_posts()): ?>
	<div id="course" class="filter-list accordion clearfix" data-accordion role="tablist" aria-multiselectable="true">
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
		include( locate_template( 'partials/partial-course.php', false, false ));
		endwhile;
		?>
				<div class="pager">
					<?php /* Display navigation to next/previous pages when applicable */ ?>
	<?php if ( function_exists('FoundationPress_pagination') ) { FoundationPress_pagination(); } else if ( is_paged() ) { ?>
		<nav id="post-nav">
			<div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', 'FoundationPress' ) ); ?></div>
			<div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'FoundationPress' ) ); ?></div>
		</nav>
	<?php } ?>
  </div>
		

	</div>
	<?php endif; ?>
          </section>
        </div>
  </article>
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
</div>
</div>
<script type="text/javascript" src="<?php echo content_url(); ?>/plugins/accordion-shortcodes/accordion.min.js?ver=2.3.0"></script>
<script type="text/javascript">
/* <![CDATA[ */
var accordionShortcodesSettings =[{"id":"course","autoClose":false,"openFirst":false,"openAll":false,"clickToClose":true,"scroll":false}];
$('.additional-info').click(function(event){
    event.stopPropagation();
});
$('.accordion-title').click(function() {
    setTimeout(
        function() {
        $('.filter-list').isotope('layout');
        console.log('isotope-relayout');
    }, 200);
});

/* ]]> */
</script>