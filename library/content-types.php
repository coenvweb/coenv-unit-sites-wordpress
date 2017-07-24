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
    'exclude_from_search' => true,
    'has_archive' => false,
    'show_ui' => true,
    'rewrite' => array('slug' => 'members', 'with_front' => false),
    'menu_icon' => 'dashicons-id',
    )

  );
  register_post_type( 'member_projects',
    array(
      'labels' => array(    
      'name' => __( 'Member Projects' ),
      'singular_name' => __( 'Member Project' ),
      'add_new_item' => __( 'Add Member Project'),
      'edit_item' => __( 'Edit Member Project'),
      'new_item' => __( 'New Member Project'),
    ),
    'supports' => array( 'title', 'editor', 'revisions' ),
    'public' => true,
    'exclude_from_search' => true,
    'has_archive' => false,
    'show_ui' => true,
    'rewrite' => array('slug' => 'member-projects', 'with_front' => false),
    'menu_icon' => 'dashicons-clipboard',
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
    'exclude_from_search' => true,
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
define( 'MEMBERS_PAGE_PARENT_ID', '3214' );
 
 
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

function project_columns($columns)
{
	$columns = array(
		'cb'		=> '<input type="checkbox" />',
		'title'		=> 'Title',
		'pis'	    => 'PI(s)',
		'project-category'	=>	'Project Categories',
		'date'		=>	'Date',
	);
	return $columns;
}

function project_custom_columns($column)
{
	global $post;
	if($column == 'pis') {
		if(have_rows('project_pi')) {
			$count = 0;
			while(have_rows('project_pi')) : the_row();
				if($count > 0) {
					echo ', ';
				}
				echo the_sub_field('pi_first_name');
				echo " ";
				echo the_sub_field('pi_last_name');
				$count ++;
			endwhile;
		}
	}
	if($column == 'project-category') {
		$terms = get_the_terms( $post->ID, 'project-category' );

		/* If terms were found. */
		if ( !empty( $terms ) ) {

			$out = array();

			/* Loop through each term, linking to the 'edit posts' page for the specific term. */
			foreach ( $terms as $term ) {
				$out[] = sprintf( '<a href="%s">%s</a>',
					esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'project-category' => $term->slug ), 'edit.php' ) ),
					esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'project-category', 'display' ) )
				);
			}

			/* Join the terms, separating them with a comma. */
			echo join( ', ', $out );
		}
	}
}

add_action("manage_member_projects_posts_custom_column", "project_custom_columns");
add_filter("manage_edit-member_projects_columns", "project_columns");
