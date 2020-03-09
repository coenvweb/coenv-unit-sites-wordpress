<?php


/*
 * Register custom content types
 */

function coenv_base_post_types_init() {
  register_post_type( 'faculty',
    array(
      'labels' => array(    
      'name' => __( 'Faculty' ),
      'singular_name' => __( 'Faculty' ),
      'add_new_item' => __( 'Add Faculty'),
      'edit_item' => __( 'Edit Faculty Member'),
      'new_item' => __( 'New Faculty'),
      ),
    //'hierarchical' => true,
    'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
    'public' => true,
    'has_archive' => false,
    'show_ui' => true,
    'rewrite' => array('slug' => 'faculty-research/faculty-instructor-bios', 'with_front' => false),
    'menu_icon' => 'dashicons-id',
    )

  );
    register_post_type( 'courses',
    array(
      'labels' => array(    
		  'name' => __( 'Courses' ),
		  'singular_name' => __( 'Course' ),
		  'add_new_item' => __( 'Add Course'),
		  'edit_item' => __( 'Edit Course'),
		  'new_item' => __( 'New Course'),
		),
		//'hierarchical' => true,
		'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		'public' => true,
		'has_archive' => false,
		'show_ui' => true,
		'rewrite' => array('slug' => 'course'),
		'menu_icon' => 'dashicons-welcome-learn-more',
		//'capabilities' => array(
//			'edit_post' => 'edit_course',
	//		'edit_posts' => 'edit_courses',
//			'edit_others_posts' => 'edit_other_courses',
//			'publish_posts' => 'publish_courses',
	//		'read_post' => 'read_student_course',
//			'read_private_posts' => 'read_private_courses',
	//		'delete_post' => 'delete_course'
//		),
		'map_meta_cap' => true,
    )

  );
}

add_action( 'init', 'coenv_base_post_types_init' );
add_action('init', 'hide_editor', 100);

/*
 * Hide body on content types that don't need one
 */
function hide_editor() {
  remove_post_type_support( 'content_block', 'editor' );
  remove_post_type_support( 'datasets', 'editor' );

} 

define( 'FACULTY_PAGE_PARENT_ID', '31' );
define( 'BLOG_PAGE_PARENT_ID', '2674' );
define( 'DATASET_PAGE_PARENT_ID', '104' );
define( 'NEWS_PARENT_ID', '142' );
 
 
/**
 * save faculty parent
 *
 * @author  Joe Sexton <joe@webtipblog.com>
 */
function coenv_base_fac_parent( $data, $postarr ) {
    global $post;
 
 
    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $data;
 
    if ( $post->post_type == "faculty" ){
        $data['post_parent'] = FACULTY_PAGE_PARENT_ID;
    }
 
    return $data;
}
add_action( 'wp_insert_post_data', 'coenv_base_fac_parent', FACULTY_PAGE_PARENT_ID, 2  ); 

/**
 * save blog parent
 */
function coenv_base_blog_parent( $data, $postarr ) {
    global $post;
 
 
    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $data;
 
    if ( $post->post_type == "student_blog" ){
        $data['post_parent'] = BLOG_PAGE_PARENT_ID;
    }
 
    return $data;
}
add_action( 'wp_insert_post_data', 'coenv_base_blog_parent', BLOG_PAGE_PARENT_ID, 2  ); 

/**
 * save dataset parent
 */
function coenv_base_dataset_parent( $data, $postarr ) {
    global $post;
 
 
    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $data;
 
    if ( $post->post_type == "datasets" ){
        $data['post_parent'] = DATASET_PAGE_PARENT_ID;
    }
 
    return $data;
}
add_action( 'wp_insert_post_data', 'coenv_base_dataset_parent', '104', 2  );

function coenv_base_news_parent( $data, $postarr ) {
    global $post;
 
 
    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $data;
 
    if ( $post->post_type == "post" ){
        $data['post_parent'] = NEWS_PARENT_ID;
    }
 
    return $data;
}
add_action( 'wp_insert_post_data', 'coenv_base_news_parent', '142', 2  );

/*
 * Teasers for custom fields
 */
function coenv_base_custom_field_excerpt($field_name) {
  global $post;
  $text = get_field($field_name);
  if ( '' != $text ) {
    $text = strip_shortcodes( $text );
    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]>', $text);
    $excerpt_length = 60; // 20 words
    $excerpt_more = apply_filters('excerpt_more', '...');
    $text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
  }
  return apply_filters('the_excerpt', $text);
}













