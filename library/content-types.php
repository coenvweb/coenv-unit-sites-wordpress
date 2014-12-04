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
    //'rewrite' => array('slug' => 'faculty'),
    'menu_icon' => 'dashicons-id',
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
    'hierarchical' => true,
    'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
    'public' => true,
    'has_archive' => false,
    'show_ui' => true,
    'rewrite' => array('slug' => 'features'),
  'menu_icon' => 'dashicons-slides',
    )
  );
  register_post_type( 'publications',
    array(
      'labels' => array(    
      'name' => __( 'Publications' ),
      'singular_name' => __( 'Publication' ),
      'add_new_item' => __( 'Add Publication'),
      'edit_item' => __( 'Edit Publication'),
      'new_item' => __( 'New Publication'),
      ),
    'hierarchical' => true,
    // drew - i think we need this for each tax connected to a content type
    'taxonomies' => array('author','publication_theme'),
    'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
    'public' => true,
    'has_archive' => false,
    'show_ui' => true,
    'rewrite' => array('slug' => 'publications'),
  'menu_icon' => 'dashicons-book',
    )
  );
  register_post_type( 'student_blog',
    array(
      'labels' => array(    
      'name' => __( 'Blog' ),
      'singular_name' => __( 'Blog Post' ),
      'add_new_item' => __( 'Add Blog Post'),
      'edit_item' => __( 'Edit Blog Post'),
      'new_item' => __( 'New Blog Post'),
      ),
    //'hierarchical' => true,
    'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
    'public' => true,
    'has_archive' => false,
    'show_ui' => true,
    //'rewrite' => array('slug' => 'student_blog'),
  'menu_icon' => 'dashicons-exerpt-view',
    )
  );
  register_post_type( 'datasets',
    array(
      'labels' => array(    
      'name' => __( 'Datasets' ),
      'singular_name' => __( 'Dataset' ),
      'add_new_item' => __( 'Add Dataset'),
      'edit_item' => __( 'Edit Dataset'),
      'new_item' => __( 'New Dataset'),
      ),
    //'hierarchical' => true,
    'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
    'public' => true,
    'has_archive' => false,
    'show_ui' => true,
    //'rewrite' => array('slug' => 'student_blog'),
  'menu_icon' => 'dashicons-exerpt-view',
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













