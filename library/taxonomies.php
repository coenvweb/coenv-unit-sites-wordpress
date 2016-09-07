<?php

/**
* Custom Taxonomies for Blog Posts
**/

function blog_tax() {

	$blog_labels = array(
		'name'                       => _x( 'Blog Categories', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Blog Category', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Blog Categories', 'text_domain' ),
		'all_items'                  => __( 'All Blog Categories', 'text_domain' ),
		'parent_item'                => __( 'Parent Blog Category', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Blog Category:', 'text_domain' ),
		'new_item_name'              => __( 'New Blog Category', 'text_domain' ),
		'add_new_item'               => __( 'Add Blog Category', 'text_domain' ),
		'edit_item'                  => __( 'Edit Blog Category', 'text_domain' ),
		'update_item'                => __( 'Update Blog Category', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'search_items'               => __( 'Search Blog Categories', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove blog categories', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most cited blog categoriesblog categories', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$blog_args = array(
		'labels'                     => $blog_labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'blog_category', array( 'student_blog' ), $blog_args );
	
	$blog_labels_2 = array(
		'name'                       => _x( 'Blog Tags', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Blog Tag', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Blog Tags', 'text_domain' ),
		'all_items'                  => __( 'All Blog Tags', 'text_domain' ),
		'parent_item'                => __( 'Parent Blog Tag', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Blog Tag:', 'text_domain' ),
		'new_item_name'              => __( 'New Blog Tag', 'text_domain' ),
		'add_new_item'               => __( 'Add Blog Tag', 'text_domain' ),
		'edit_item'                  => __( 'Edit Blog Tag', 'text_domain' ),
		'update_item'                => __( 'Update Blog Tag', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate blog tags with commas', 'text_domain' ),
		'search_items'               => __( 'Search blog tags', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove blog tags', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most commonly used blog tags', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$blog_args_2 = array(
		'labels'                     => $blog_labels_2,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'blog_post_tag', array( 'student_blog' ), $blog_args_2 );
	
}

add_action( 'init', 'blog_tax' );

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
* Custom Taxonomies for Courses
**/
function course_tax() {

    $cat_labels = array(
		'name'                       => _x( 'Categories', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Categories', 'text_domain' ),
		'all_items'                  => __( 'All categories', 'text_domain' ),
		'parent_item'                => __( 'Parent category', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent category:', 'text_domain' ),
		'new_item_name'              => __( 'New category', 'text_domain' ),
		'add_new_item'               => __( 'Add category', 'text_domain' ),
		'edit_item'                  => __( 'Edit category', 'text_domain' ),
		'update_item'                => __( 'Update category', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'search_items'               => __( 'Search categories', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove category', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from categories with the most courses', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$data_args = array(
		'labels'                     => $cat_labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'course_category', array( 'courses' ), $cat_args );
    
    $data_labels = array(
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
	$data_args = array(
		'labels'                     => $data_labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'course_quarter', array( 'courses' ), $data_args );	

}

add_action( 'init', 'course_tax' );

function mbe_change_table_column_titles($columns){
    unset($columns['date']);// temporarily remove, to have custom column before date column
    $columns['quarters'] = 'Quarters';
    $columns['course_acronym'] = 'Course Acronym';
    $columns['date'] = 'Date';// readd the date column
    return $columns;
}
add_filter('manage_courses_posts_columns', 'mbe_change_table_column_titles');

function mbe_change_column_rows($column_name, $post_id){
    if($column_name == 'quarters'){
        echo get_the_term_list($post_id, 'course_quarter', '', ', ', '').PHP_EOL;
    }
    if($column_name == 'course_acronym'){
        echo get_field('course_acronym', $post_id).PHP_EOL;
    }
}
add_action('manage_courses_posts_custom_column', 'mbe_change_column_rows', 10, 2);

function mbe_change_sortable_columns($columns){
    $columns['quarters'] = 'quarters';
    $columns['course_acronym'] = 'course_acronym';
    return $columns;
}
add_filter('manage_edit-courses_sortable_columns', 'mbe_change_sortable_columns');

function mbe_sort_custom_column($clauses, $wp_query){
    global $wpdb;
    if(isset($wp_query->query['orderby']) && $wp_query->query['orderby'] == 'quarters'){
        $clauses['join'] .= <<<SQL
LEFT OUTER JOIN {$wpdb->term_relationships} ON {$wpdb->posts}.ID={$wpdb->term_relationships}.object_id
LEFT OUTER JOIN {$wpdb->term_taxonomy} USING (term_taxonomy_id)
LEFT OUTER JOIN {$wpdb->terms} USING (term_id)
SQL;
        $clauses['where'] .= "AND (taxonomy = 'course_quarter' OR taxonomy IS NULL)";
        $clauses['groupby'] = "object_id";
        $clauses['orderby'] = "GROUP_CONCAT({$wpdb->terms}.name ORDER BY name ASC)";
        if(strtoupper($wp_query->get('order')) == 'ASC'){
            $clauses['orderby'] .= 'ASC';
        } else{
            $clauses['orderby'] .= 'DESC';
        }
    }
    return $clauses;
}
add_filter('posts_clauses', 'mbe_sort_custom_column', 10, 2);

add_action( 'pre_get_posts', 'acronym_orderby' );
function acronym_orderby( $query ) {
    if( ! is_admin() )
        return;
 
    $orderby = $query->get( 'orderby');
 
    if( 'course_acronym' == $orderby ) {
        $query->set('meta_key','course_acronym');
        $query->set('orderby','meta_value');
    }
}
