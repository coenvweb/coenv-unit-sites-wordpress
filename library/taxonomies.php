<?php

/**
* Custom Taxonomies for Faculty
**/
function fac_tax() {

	$fac_labels = array(
		'name'                       => _x( 'Research Areas', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Research Area', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Research Areas', 'text_domain' ),
		'all_items'                  => __( 'All Research Areas', 'text_domain' ),
		'parent_item'                => __( 'Parent Research Area', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Research Area:', 'text_domain' ),
		'new_item_name'              => __( 'New Research Area', 'text_domain' ),
		'add_new_item'               => __( 'Add Research Area', 'text_domain' ),
		'edit_item'                  => __( 'Edit Research Area', 'text_domain' ),
		'update_item'                => __( 'Update Research Area', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'search_items'               => __( 'Search Research Areas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove Research Area', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most cited Research Areas', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$fac_args = array(
		'labels'                     => $fac_labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'research_areas', array( 'faculty' ), $fac_args );
}

add_action( 'init', 'fac_tax' );

/**
* Custom Taxonomies for Courses
**/
function course_tax() {

//    $course_labels = array(
//		'name'                       => _x( 'Categories', 'Taxonomy General Name', 'text_domain' ),
//		'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'text_domain' ),
//		'menu_name'                  => __( 'Categories', 'text_domain' ),
//		'all_items'                  => __( 'All categories', 'text_domain' ),
//		'parent_item'                => __( 'Parent category', 'text_domain' ),
//		'parent_item_colon'          => __( 'Parent category:', 'text_domain' ),
//		'new_item_name'              => __( 'New category', 'text_domain' ),
//		'add_new_item'               => __( 'Add category', 'text_domain' ),
//		'edit_item'                  => __( 'Edit category', 'text_domain' ),
//		'update_item'                => __( 'Update category', 'text_domain' ),
//		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
//		'search_items'               => __( 'Search categories', 'text_domain' ),
//		'add_or_remove_items'        => __( 'Add or remove category', 'text_domain' ),
//		'choose_from_most_used'      => __( 'Choose from categories with the most courses', 'text_domain' ),
//		'not_found'                  => __( 'Not Found', 'text_domain' ),
//	);
//	$course_args = array(
//		'labels'                     => $course_labels,
//		'hierarchical'               => true,
//		'public'                     => true,
//		'show_ui'                    => true,
//		'show_admin_column'          => true,
//		'show_in_nav_menus'          => true,
//		'show_tagcloud'              => true,
//	);
//	register_taxonomy( 'course_category', array( 'courses' ), $course_args );
    
    $course_labels_2 = array(
		'name'                       => _x( 'Quarters', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Quarter', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Quarters', 'text_domain' ),
		'all_items'                  => __( 'All Quarters', 'text_domain' ),
		'parent_item'                => __( 'Parent Quarter', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Quarter:', 'text_domain' ),
		'new_item_name'              => __( 'New Quarter', 'text_domain' ),
		'add_new_item'               => __( 'Add Quarter', 'text_domain' ),
		'edit_item'                  => __( 'Edit Quarter', 'text_domain' ),
		'update_item'                => __( 'Update Quarter', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'search_items'               => __( 'Search Quarters', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove Quarter', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from quarters with the most courses', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$course_args_2 = array(
		'labels'                     => $course_labels_2,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'course_quarter', array( 'courses' ), $course_args_2 );	
    
  $course_labels_3 = array(
		'name'                       => _x( 'Years', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Year', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Years', 'text_domain' ),
		'all_items'                  => __( 'All Years', 'text_domain' ),
		'parent_item'                => __( 'Parent Year', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Year:', 'text_domain' ),
		'new_item_name'              => __( 'New Year', 'text_domain' ),
		'add_new_item'               => __( 'Add Year', 'text_domain' ),
		'edit_item'                  => __( 'Edit Year', 'text_domain' ),
		'update_item'                => __( 'Update Year', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'search_items'               => __( 'Search Years', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove Years', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from years with the most courses', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$course_args_3 = array(
		'labels'                     => $course_labels_3,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'course_year', array( 'courses' ), $course_args_3 );	

}

add_action( 'init', 'course_tax' );