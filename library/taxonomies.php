<?php

/**
* Custom Taxonomies for Members
**/
function mem_tax() {

    $ra_labels = array(
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
		'choose_from_most_used'      => __( 'Choose from the most used Research Areas', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$ra_args = array(
		'labels'                     => $ra_labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'research-areas', array( 'members' ), $ra_args );

}

add_action( 'init', 'mem_tax' );

function project_tax() {

    $pc_labels = array(
		'name'                       => _x( 'Project Categories', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Project Category', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Project Categories', 'text_domain' ),
		'all_items'                  => __( 'All Project Categories', 'text_domain' ),
		'parent_item'                => __( 'Parent Project Category', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Project Category:', 'text_domain' ),
		'new_item_name'              => __( 'New Project Category', 'text_domain' ),
		'add_new_item'               => __( 'Add Project Category', 'text_domain' ),
		'edit_item'                  => __( 'Edit Project Category', 'text_domain' ),
		'update_item'                => __( 'Update Project Category', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'search_items'               => __( 'Search Project Categories', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove Project Category', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used Project Categorys', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$pc_args = array(
		'labels'                     => $pc_labels,
		'public'                     => true,
		'hierarchical'               => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'project-category', array( 'member_projects' ), $pc_args );

}

add_action( 'init', 'project_tax' );
