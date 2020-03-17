<?php
/*
Template Name: Faculty Index
*/

get_header();
?>

<div class="row">

	<div class="small-12 medium-9 columns right" role="main" id="main-col">
      <article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>
		  <div class="entry-content">
        <header class="article__header">
            <h1 class="article__title"><?php the_title() ?></h1>
        </header>
      <section class="article__content">

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
	'post_type'	=> 'faculty',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'taxonomy' => 'research_areas',
	'meta_key' => 'last_name',
	'orderby' => 'meta_value',
	'order' => 'ASC',
	'paged' => $paged,
	'meta_query' => array(
		array(
			'key'     => 'last_name',
			'compare' => 'IN',
		),
	),
);

$wp_query = new WP_Query( $query_args );

?>
	<?php if ($wp_query->have_posts()): ?>
	<div id="bio" class="filter-list accordion clearfix" data-accordion role="tablist" aria-multiselectable="true">
		<?php
		# The Loop
		while ( $wp_query->have_posts() ) :
		$wp_query->the_post();
		$faculty_thumb = get_the_post_thumbnail(get_the_ID(),'thumbnail');
    $courses_taught = get_field('courses_taught');
		$website = get_field('website_url');
		$phone_number = get_field('phone_number_1');
		$email = str_replace('u.washington.edu','uw.edu',get_field('email_address'));
    $faculty_img = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');
    $faculty_img_src = $faculty_img[0];
    $faculty_areas = get_the_terms($post->ID, 'research_areas');
    $term_list = '';
      
    foreach($faculty_areas as $area) {
        $term_list .= $area->slug . ' ';
    }
		if (!$faculty_img_src) {
		$faculty_img_src = get_template_directory_uri() . '/assets/img/blank-153x153.jpg';
		}
		echo '<div id="bio-t-' . sanitize_title(get_the_title()) . '" class="filter-list-item accordion-title read '.$term_list.'" aria-label="Toggle more information" tabindex="0" aria-expanded="false" aria-controls="bio-c-' . get_the_title()  . '">';
		echo '<div class="faculty-image"><img src="' . $faculty_img_src . '"" alt="' . get_the_title() . '" /></div>';
    echo '<div class="person-info">';
		echo '<h3>' . get_the_title() . '</h3>';
    echo '<div class="additional-info" style="display:none;">';
    echo '<ul class="contact-info">';
    if( have_rows('job_titles') ) {
        echo '<ul class="job-titles">';
        while ( have_rows('job_titles') ) : the_row();
            echo '<li>';
            the_sub_field('job_title');
            echo '</li>';
        endwhile;
        echo '</ul>';
    }
    $fac_terms = wp_get_post_terms( $id, 'research_areas' );
    if ($fac_terms) {
        echo '<ul class="fac-terms inline-list"><p class="focus-label">Focus areas: </p>';
        foreach ($fac_terms as $term) {
            echo '<li><a href="#' . $term->slug . '">' . $term->name . '</a></li>';
        }
    }
		echo '</ul>';
  if (!empty($courses_taught)) : 
        echo '<li class="courses">Teaching: ' . $courses_taught . '</li>';
    endif;
    if (!empty($email)) : 
        echo '<li class="email"><a href="mailto:' . antispambot($email) .'"><i class="fi-mail"></i>' . antispambot($email) .'</a></li>';
    endif;
    if (!empty($phone_number)) :
        echo '<li class="phone-number"><a href="tel:'. $phone_number . '"><i class="fi-telephone"></i>' . $phone_number .'</a></li>';
    endif;
    if (!empty($website)) :
        echo '<li class="website"><a class="button" href="'. $website . '"><i class="icon-contact-link-phone"></i>Website</a></li>';
    endif;
    echo '</ul></div></div></div>';
    echo '<div id="bio-c-' . sanitize_title(get_the_title())  . '" class="spacer-div"></div>';
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
<script type="text/javascript" src="<?php echo content_url(); ?>/plugins/accordion-shortcodes/accordion.min.js?ver=2.3.0"></script>
<script type="text/javascript">
/* <![CDATA[ */
var accordionShortcodesSettings =[{"id":"bio","autoClose":false,"openFirst":false,"openAll":false,"clickToClose":true,"scroll":false}];
$('.accordion-title').click(function() {
    setTimeout(
        function() {
        $('.filter-list').isotope('layout');
        console.log('isotope-relayout');
    }, 200);
});
$('.additional-info').click(function(event){
    event.stopPropagation();
});
/* ]]> */
</script>