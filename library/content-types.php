<?php


/*
 * Register custom content types
 */

function coenv_base_post_types_init() {
  register_post_type( 'pi',
    array(
      'labels' => array(    
      'name' => __( 'PIs' ),
      'singular_name' => __( 'PI' ),
      'add_new_item' => __( 'Add PI'),
      'edit_item' => __( 'Edit PI'),
      'new_item' => __( 'New PI'),
      ),
    //'hierarchical' => true,
    'taxonomies' => array('research_areas'),
    'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
    'public' => true,
    'has_archive' => false,
    'show_ui' => true,
    'rewrite' => array('slug' => 'PI'),
    'menu_icon' => 'dashicons-id',
    )

  );
  register_post_type( 'intern',
    array(
      'labels' => array(    
      'name' => __( 'Interns' ),
      'singular_name' => __( 'Intern' ),
      'add_new_item' => __( 'Add Intern'),
      'edit_item' => __( 'Edit Intern'),
      'new_item' => __( 'New Intern'),
      ),
    'hierarchical' => true,
    // drew - i think we need this for each tax connected to a content type
    'taxonomies' => array('intern_year','intern_theme'),
    'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
    'public' => true,
    'has_archive' => false,
    'show_ui' => true,
    'rewrite' => array('slug' => 'intern'),
  'menu_icon' => 'dashicons-book',
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
 
    if ( $post->post_type == "pi" ){
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













