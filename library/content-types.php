<?php


/*
 * Register custom content types
 */

function coenv_base_post_types_init() {
  register_post_type( 'publications',
    array(
      'labels' => array(    
      'name' => __( 'Publications' ),
      'singular_name' => __( 'Publication' ),
      'add_new_item' => __( 'Add Publication'),
      'edit_item' => __( 'Edit Publication'),
      'new_item' => __( 'New Publication'),
      ),
    'taxonomies' => array('author','publication_theme'),
    'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
    'public' => true,
    'has_archive' => false,
    'show_ui' => true,
    'rewrite' => array('slug' => 'publications'),
    'with_front' => false,
    'menu_icon' => 'dashicons-media-text',
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
    'with_front' => true,
    'rewrite' => array('slug' => 'datasets'),
    'menu_icon' => 'dashicons-exerpt-view',
    )
  );
  register_post_type( 'projects',
  array(
    'labels' => array(    
    'name' => __( 'Projects' ),
    'singular_name' => __( 'Project' ),
    'add_new_item' => __( 'Add Project'),
    'edit_item' => __( 'Edit Project'),
    'new_item' => __( 'New Project'),
    ),
  'hierarchical' => true,
  'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
  'public' => true,
  'has_archive' => false,
  'show_ui' => true,
  'with_front' => true,
  'menu_icon' => 'dashicons-book',
  )
  );
  register_post_type( 'people',
    array(
      'labels' => array(    
      'name' => __( 'People' ),
      'singular_name' => __( 'People' ),
      'add_new_item' => __( 'Add People'),
      'edit_item' => __( 'Edit People'),
      'new_item' => __( 'New People'),
      ),
    'supports' => array( 'title', 'thumbnail' ),
    'public' => true,
    'has_archive' => false,
    'show_ui' => true,
    'rewrite' => array('slug' => 'about/people'),
    'with_front' => false,
    'menu_icon' => 'dashicons-id',
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

define( 'PUBS_PAGE_PARENT_ID', '124' );
define( 'DATASET_PAGE_PARENT_ID', '104' );
define( 'PEOPLE_PARENT_ID', '58' );
define( 'NEWS_PARENT_ID', '142' );
define( 'PROJECTS_PAGE_PARENT_ID', '17424' );
 
 
function coenv_base_dataset_parent( $data, $postarr ) {
    global $post;
 
 
    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we dont want to do anything
    //if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
     //  return $data;
 
    if ( $post->post_type == "datasets" ){
        $data['post_parent'] = DATASET_PAGE_PARENT_ID;
    }
 
    return $data;
}
add_action( 'wp_insert_post_data', 'coenv_base_dataset_parent', '104', 2  );

function coenv_base_people_parent( $data, $postarr ) {
    global $post;
 
 
    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we dont want to do anything
    //if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
     //  return $data;
 
    if ( $post->post_type == "people" ){
        $data['post_parent'] = PEOPLE_PARENT_ID;
    }
 
    return $data;
}
add_action( 'wp_insert_post_data', 'coenv_base_people_parent', '104', 2  );

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

function coenv_base_pubs_parent( $data, $postarr ) {
    global $post;
 
 
    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we dont want to do anything
    //if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
     //   return $data;
 
    if ( $post->post_type == "publications" ){
        $data['post_parent'] = PUBS_PAGE_PARENT_ID;
    }
 
    return $data;
}
add_action( 'wp_insert_post_data', 'coenv_base_pubs_parent', '142', 2  );

//function coenv_base_project_parent( $data, $postarr ) {
 // global $post;


  // verify if this is an auto save routine.
  // If it is our form has not been submitted, so we dont want to do anything
  //if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
   //   return $data;

  //if ( $post->post_type == "projects" ){
   //   $data['post_parent'] = PROJECTS_PAGE_PARENT_ID;
  //}

  //return $data;
//}
//add_action( 'wp_insert_post_data', 'coenv_base_project_parent', '142', 2  );


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