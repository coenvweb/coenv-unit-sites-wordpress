<?php
/**
* Custom Taxonomies for Publications
**/

function pub_tax() {

	$labels = array(
		'name'                       => _x( 'Authors', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Author', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Authors', 'text_domain' ),
		'all_items'                  => __( 'All Authors', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Author', 'text_domain' ),
		'add_new_item'               => __( 'Add Author', 'text_domain' ),
		'edit_item'                  => __( 'Edit Author', 'text_domain' ),
		'update_item'                => __( 'Update Author', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove authors', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most cited authors', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
        'query_var'                  => 'authors',
	);
	register_taxonomy( 'author', array( 'publications' ), $args );
	
	$labels_2 = array(
		'name'                       => _x( 'Publication Years', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Publicvation Year', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Publication Years', 'text_domain' ),
		'all_items'                  => __( 'All Publication Years', 'text_domain' ),
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
	register_taxonomy( 'publication_year', array( 'publications' ), $args_2 );
	
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
	register_taxonomy( 'publication_theme', array( 'publications', 'posts' ), $args_3 );

	$labels_4 = array(
		'name'                       => _x( 'Groups', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Group', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Groups', 'text_domain' ),
		'all_items'                  => __( 'All Groups', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Group', 'text_domain' ),
		'add_new_item'               => __( 'Add Group', 'text_domain' ),
		'edit_item'                  => __( 'Edit Group', 'text_domain' ),
		'update_item'                => __( 'Update Group', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate groups with commas', 'text_domain' ),
		'search_items'               => __( 'Search Groups', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove groups', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used groups', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$args_4 = array(
		'labels'                     => $labels_4,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'publication_group', array( 'publications' ), $args_4 );
}

add_action( 'init', 'pub_tax' );

/**
* Custom Taxonomies for People
**/
function people_tax() {

	$people_labels = array(
		'name'                       => _x( 'Classifications', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Classification', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Classifications', 'text_domain' ),
		'all_items'                  => __( 'All Classifications', 'text_domain' ),
		'parent_item'                => __( 'Parent Classification', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Classification:', 'text_domain' ),
		'new_item_name'              => __( 'New Classification', 'text_domain' ),
		'add_new_item'               => __( 'Add Classification', 'text_domain' ),
		'edit_item'                  => __( 'Edit Classification', 'text_domain' ),
		'update_item'                => __( 'Update Classification', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'search_items'               => __( 'Search Classifications', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove Classification', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most cited Classifications', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$people_args = array(
		'labels'                     => $people_labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'classification', array( 'people' ), $people_args );

}
add_action( 'init', 'people_tax' );

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

/**
* Custom Taxonomies for Projects
**/
function project_tax() {

    $funding_year_labels = array(
		'name'                       => _x( 'Year Completed', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Year Completed', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Year Completed', 'text_domain' ),
		'all_items'                  => __( 'All Years', 'text_domain' ),
		'parent_item'                => __( 'Parent Year', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Year:', 'text_domain' ),
		'new_item_name'              => __( 'New Year', 'text_domain' ),
		'add_new_item'               => __( 'Add Year Completed', 'text_domain' ),
		'edit_item'                  => __( 'Edit Year', 'text_domain' ),
		'update_item'                => __( 'Update Year', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'search_items'               => __( 'Search Years', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove Year', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most cited Funding Years', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$funding_year_args = array(
		'labels'                     => $funding_year_labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'project_year', array( 'projects' ), $funding_year_args);

    $state_labels = array(
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
		'choose_from_most_used'      => __( 'Choose from the most cited States', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$state_args = array(
		'labels'                     => $state_labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'project_region', array( 'projects' ), $state_args);

	$topic_labels = array(
		'name'                       => _x( 'Topics', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Topic', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Topics', 'text_domain' ),
		'all_items'                  => __( 'All Topics', 'text_domain' ),
		'parent_item'                => __( 'Parent Topic', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Topic:', 'text_domain' ),
		'new_item_name'              => __( 'New Topic', 'text_domain' ),
		'add_new_item'               => __( 'Add Topic', 'text_domain' ),
		'edit_item'                  => __( 'Edit Topic', 'text_domain' ),
		'update_item'                => __( 'Update Topic', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate topics with commas', 'text_domain' ),
		'search_items'               => __( 'Search topics', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove topics', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used topics', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$topic_args = array(
		'labels'                     => $topic_labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy('project_topic', array( 'projects'), $topic_args);
}

add_action( 'init', 'project_tax' );

function coenv_base_no_auto_filter($tax,$tax_value) {

$tax_obj = get_taxonomy($tax);
$tax_str = $tax_obj->labels->name;

$cats_args  = array(
	'orderby' => 'name',
	'order' => 'ASC',
	'taxonomy' => $tax
);
$cats = get_categories($cats_args);
	if ($cats) {
		echo '<label for="'.$tax_obj->name.'"  class="visuallyhidden">Select ' . $tax_str . '</label>';
		echo '<select name="'.$tax_obj->name.'" class="select-category" id="select-category">';
		echo '<option class="level-0" value="0">All ' . $tax_str . '</option>';
		foreach($cats as $cat) { 
			$selected = $cat->slug == $tax_value ? ' selected="selected"' : '';
			echo '<option value="'. $cat->slug . '"' . $selected . '>' . $cat->name . '</option>';
		}
		echo '</select>';
	}
}