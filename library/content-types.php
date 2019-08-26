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
		//'rewrite' => array('slug' => 'faculty-research/faculty'),
		'menu_icon' => 'dashicons-id',
		'capabilities' => array(
			'edit_post' => 'edit_faculty',
			'edit_posts' => 'edit_facultys',
			'edit_others_posts' => 'edit_other_facultys',
			'publish_posts' => 'publish_facultys',
			'read_post' => 'read_faculty',
			'read_private_posts' => 'read_private_facultys',
			'delete_post' => 'delete_faculty'
		),
		'map_meta_cap' => true,
    )

  );
  register_post_type( 'student-profiles',
    array(
      'labels' => array(    
		  'name' => __( 'Student Profiles' ),
		  'singular_name' => __( 'Student Profile' ),
		  'add_new_item' => __( 'Add Student Profile'),
		  'edit_item' => __( 'Edit Student Profile'),
		  'new_item' => __( 'New Student Profile'),
		),
		//'hierarchical' => true,
		'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		'public' => true,
		'has_archive' => false,
		'show_ui' => true,
		'rewrite' => array('slug' => 'student-profile'),
		'menu_icon' => 'dashicons-smiley',
		'capabilities' => array(
			'edit_post' => 'edit_student_profile',
			'edit_posts' => 'edit_student_profiles',
			'edit_others_posts' => 'edit_other_student_profiles',
			'publish_posts' => 'publish_student_profiles',
			'read_post' => 'read_student_profile',
			'read_private_posts' => 'read_private_student_profiles',
			'delete_post' => 'delete_student_profile'
		),
		'map_meta_cap' => true,
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
		'capabilities' => array(
			'edit_post' => 'edit_course',
			'edit_posts' => 'edit_courses',
			'edit_others_posts' => 'edit_other_courses',
			'publish_posts' => 'publish_courses',
			'read_post' => 'read_student_course',
			'read_private_posts' => 'read_private_courses',
			'delete_post' => 'delete_course'
		),
		'map_meta_cap' => true,
    )

  );
  register_post_type( 'features',
    array(
      'labels' => array(    
      'name' => __( 'Homepage Features' ),
      'singular_name' => __( 'Homepage Feature' ),
      'add_new_item' => __( 'Add Homepage Feature'),
      'edit_item' => __( 'Edit Homepage Feature'),
      'new_item' => __( 'New Homepage Feature'),
      ),
    //'hierarchical' => true,
    'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
    'public' => true,
    'has_archive' => false,
    'show_ui' => true,
    //'rewrite' => array('slug' => 'features'),
  'menu_icon' => 'dashicons-slides',
    )
  );
   register_post_type( 'intranet_page',
    array(
      'labels' => array(    
      'name' => __( 'Intranet Pages' ),
      'singular_name' => __( 'Intranet Page' ),
      'add_new_item' => __( 'Add Intranet Page'),
      'edit_item' => __( 'Edit Intranet Page'),
      'new_item' => __( 'New Intranet Page'),
      ),
    'hierarchical' => true,
    'supports' => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ),
    'public' => true,
    'has_archive' => false,
    'show_ui' => true,
    'rewrite' => array('slug' => 'intranet'),
    'menu_icon' => 'dashicons-slides',
    )
  );

}

add_action( 'init', 'coenv_base_post_types_init' );

/*
 * Add author option to existing post types


function coenv_author_support() {
  add_post_type_support( 'faculty', 'author' );
}
add_action('init', 'coenv_author_support');

/*
 * Hide body on content types that don't need one
 */
function hide_editor() {
  remove_post_type_support( 'content_block', 'editor' );;

} 

add_action('init', 'hide_editor', 100);

define( 'FACULTY_PAGE_PARENT_ID', '3698' );
define( 'BLOG_PAGE_PARENT_ID', '162' );
define( 'NEWS_PARENT_ID', '118' );
define( 'INTRANET_PARENT_ID', '7251' );
 
 
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
add_action( 'wp_insert_post_data', 'coenv_base_news_parent', NEWS_PARENT_ID, 2  ); 

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









