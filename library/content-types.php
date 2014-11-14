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
}

add_action( 'init', 'coenv_base_post_types_init' );
add_action('init', 'hide_editor', 100);

function hide_editor() {
  remove_post_type_support( 'content_block', 'editor' );
} 












