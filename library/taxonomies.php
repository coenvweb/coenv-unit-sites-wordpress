<?php

/**
* Custom Taxonomies for Interns
**/

function intern_tax() {
	
	$labels_2 = array(
		'name'                       => _x( 'Intern Years', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Intern Year', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Intern Years', 'text_domain' ),
		'all_items'                  => __( 'All Intern Years', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Year', 'text_domain' ),
		'add_new_item'               => __( 'Add Year', 'text_domain' ),
		'edit_item'                  => __( 'Edit Year', 'text_domain' ),
		'update_item'                => __( 'Update Year', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate years with commas', 'text_domain' ),
		'search_items'               => __( 'Search Years', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove years', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most published years', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$args_2 = array(
		'labels'                     => $labels_2,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'intern_year', array( 'intern' ), $args_2 );
	
	$labels_3 = array(
		'name'                       => _x( 'Research Themes', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Research Theme', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Research Themes', 'text_domain' ),
		'all_items'                  => __( 'All Themes', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Theme', 'text_domain' ),
		'add_new_item'               => __( 'Add Theme', 'text_domain' ),
		'edit_item'                  => __( 'Edit Theme', 'text_domain' ),
		'update_item'                => __( 'Update Theme', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate themes with commas', 'text_domain' ),
		'search_items'               => __( 'Search Themes', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove themes', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used themes', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$args_3 = array(
		'labels'                     => $labels_3,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'intern_theme', array( 'intern' ), $args_3 );
}

add_action( 'init', 'intern_tax' );

/**
* Custom Taxonomies for PIs
**/
function pi_tax() {

	$pi_labels = array(
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
	$pi_args = array(
		'labels'                     => $pi_labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'research_areas', array( 'pi' ), $pi_args );
}

add_action( 'init', 'pi_tax' );