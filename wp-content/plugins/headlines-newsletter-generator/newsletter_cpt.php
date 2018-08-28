<?php

add_action( 'init', 'coenv_register_newsletter' );
function coenv_register_newsletter() {

    $labels = array(
        'name' => __( 'Newsletter' ),
        'singular_name' => __( 'Newsletter' ),
        'add_new' => __( 'Add New Newsletter' ),
        'edit_item' => __( 'Edit Newsletter' ),
        'add_new_item' => __( 'New Newsletter' ),
        'view_item' => __( 'View Newsletter' ),
        'search_items' => __( 'Search Newsletter' ),
        'not_found' => __( 'No Newsletter found' ),
        'not_found_in_trash' => __( 'No Newsletter found in Trash' )
    );

    $rewrite = array(
        'slug' => 'college-newsletter',
        'with_front' => true
    );

    $args = array(
        'labels' => $labels,
        'menu_position' => null,
        'supports' => array('title','editor','page-attributes'),
        'public' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'has_archive' => false,
        'hierarchical' => false,
        'menu_icon' => 'dashicons-format-aside',
        'capability_type' => 'page',
        'rewrite' => $rewrite,
    );

    register_post_type( 'newsletter', $args );
}

?>
