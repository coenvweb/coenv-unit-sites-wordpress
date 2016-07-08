<?php


/*
 * Register custom content types
 */

function coenv_base_post_types_init() {
  register_post_type( 'members',
    array(
      'labels' => array(    
      'name' => __( 'Members' ),
      'singular_name' => __( 'Members' ),
      'add_new_item' => __( 'Add Members'),
      'edit_item' => __( 'Edit Members Member'),
      'new_item' => __( 'New Members'),
      ),
    //'hierarchical' => true,
    'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
    'public' => true,
    'has_archive' => false,
    'show_ui' => true,
    //'rewrite' => array('slug' => 'members'),
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
}

add_action( 'init', 'coenv_base_post_types_init' );
add_action('init', 'hide_editor', 100);

/*
 * Hide body on content types that don't need one
 */
function hide_editor() {
  remove_post_type_support( 'content_block', 'editor' );
}

define( 'NEWS_PARENT_ID', '142' );
 
 
/**
 * save Members parent
 *
 * @author  Joe Sexton <joe@webtipblog.com>
 */
function coenv_base_mem_parent( $data, $postarr ) {
    global $post;
 
 
    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $data;
 
    if ( $post->post_type == "members" ){
        $data['post_parent'] = MEMBERS_PAGE_PARENT_ID;
    }
 
    return $data;
}
add_action( 'wp_insert_post_data', 'coenv_base_mem_parent', MEMBERS_PAGE_PARENT_ID, 2  );

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

