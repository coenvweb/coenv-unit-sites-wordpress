<?php 

/* 
 * Return faculty taxonomy terms from research areas.
 */
function coenv_base_fac_terms($id) {
	$fac_terms = wp_get_post_terms( $id, 'research_areas' );
	if ($fac_terms) {
		echo '<ul class="fac-cats inline-list">';
		foreach ($fac_terms as $term) {

            echo '<li><a href="/faculty-research/#' . $term->slug . '">' . $term->name . '</a></li>';
		}
		echo '</ul>';
	}
}

/*
 * Return grammatically correct first names.
 */
function coenv_base_apostophe_fname($fname) {
	if (substr($fname,-1) == 's') {
		echo $fname . '\'';
	} else {
		echo $fname . '\'s';
	}
}

add_action( 'wp_ajax_populate_faculty', 'populate_faculty_callback' );
add_action( 'wp_ajax_nopriv_populate_faculty', 'populate_faculty_callback' );

function populate_faculty_callback() {
    $area = $_POST['research_areas'];
    //$areaCat = get_term_by('slug', $area, 'research_areas');

	$wp_query = new WP_Query();
	$wp_query->query;

	$query_args = array(
		'post_type' => 'faculty',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'meta_key' => 'last_name',
		'orderby' => 'meta_value',
		'order' => 'ASC',
		'meta_query' => array(
			array(
				'key'     => 'last_name',
				'compare' => 'IN',
			),
		),
	);
	if($area) {
		$query_args['taxonomy'] = 'research_areas';
		$query_args['term'] = $area;
	}
	$wp_query = new WP_Query( $query_args );
	$faculty = array();
	if($wp_query->have_posts()) {
		$faculty['total'] = $wp_query->found_posts;
		if($area) {
			$faculty['area'] = $area;
            $faculty['area_name'] = $_POST['area_name'];
		}
		while($wp_query->have_posts() ) :
			$wp_query->the_post();
			$faculty_id = get_the_ID();
			$faculty['posts'][$faculty_id]['img_src'] = wp_get_attachment_url( get_post_thumbnail_id( $faculty_id ) );
			$faculty['posts'][$faculty_id]['link'] = get_the_permalink();
			$faculty['posts'][$faculty_id]['name'] = get_the_title();
			if ( !$faculty['posts'][$faculty_id]['img_src'] ) {
				$faculty['posts'][$faculty_id]['img_src'] = get_template_directory_uri() . '/assets/img/blank-153x153.jpg';
			}
		endwhile;
	}
	echo json_encode($faculty);
	wp_die();
}
