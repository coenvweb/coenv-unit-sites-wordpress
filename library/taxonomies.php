<?php

/**
* Custom Taxonomies for Student Profiles
**/

function student_profile_tax() {

	$student_profile_labels = array(
		'name'                       => _x( 'Student Types', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Student Type', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Student Types', 'text_domain' ),
		'all_items'                  => __( 'All Student Types', 'text_domain' ),
		'parent_item'                => __( 'Parent Student Type', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Student Type:', 'text_domain' ),
		'new_item_name'              => __( 'New Student Type', 'text_domain' ),
		'add_new_item'               => __( 'Add Student Type', 'text_domain' ),
		'edit_item'                  => __( 'Edit Student Type', 'text_domain' ),
		'update_item'                => __( 'Update Student Type', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'search_items'               => __( 'Search Student Types', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove Student Types', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most cited Student Types', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$student_profile_args = array(
		'labels'                     => $student_profile_labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'student_types', array( 'student-profiles' ), $student_profile_args );
	
}

add_action( 'init', 'student_profile_tax' );

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

}

add_action( 'init', 'course_tax' );

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
		'show_admin_column'          => false,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'research_areas', array( 'faculty', 'student-profiles', 'courses' ), $fac_args );
}

add_action( 'init', 'fac_tax' );

/**
* Custom Taxonomies for Datasets
**/
function data_tax() {

	$data_labels = array(
		'name'                       => _x( 'Regions', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Region', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Regions', 'text_domain' ),
		'all_items'                  => __( 'All Regions', 'text_domain' ),
		'parent_item'                => __( 'Parent Region', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Region:', 'text_domain' ),
		'new_item_name'              => __( 'New Region', 'text_domain' ),
		'add_new_item'               => __( 'Add Region', 'text_domain' ),
		'edit_item'                  => __( 'Edit Region', 'text_domain' ),
		'update_item'                => __( 'Update Region', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'search_items'               => __( 'Search Regions', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove Region', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most cited Regions', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$data_args = array(
		'labels'                     => $data_labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'dataset_region', array( 'datasets' ), $data_args );

	$data_labels_2 = array(
		'name'                       => _x( 'Data Types', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Data Type', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Data Types', 'text_domain' ),
		'all_items'                  => __( 'All Data Types', 'text_domain' ),
		'parent_item'                => __( 'Parent Data Type', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Data Type:', 'text_domain' ),
		'new_item_name'              => __( 'New Data Type', 'text_domain' ),
		'add_new_item'               => __( 'Add Data Type', 'text_domain' ),
		'edit_item'                  => __( 'Edit Data Type', 'text_domain' ),
		'update_item'                => __( 'Update Data Type', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'search_items'               => __( 'Search Data Types', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove Data Type', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most cited Data Types', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$data_args_2 = array(
		'labels'                     => $data_labels_2,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'dataset_type', array( 'datasets' ), $data_args_2 );
}

add_action( 'init', 'data_tax' );