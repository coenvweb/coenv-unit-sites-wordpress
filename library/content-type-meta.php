<?php
function faculty_change_table_column_titles($columns){
    unset($columns['title']);// temporarily remove, to have custom column before date column
    unset($columns['date']);// temporarily remove, to have custom column before date column
    $columns['title'] = 'Full Faculty Name';
    $columns['first_name'] = 'First Name';
    $columns['last_name'] = 'Last Name';
    $columns['research_areas'] = 'Research Areas';
    $columns['date'] = 'Date';
    return $columns;
}
add_filter('manage_faculty_posts_columns', 'faculty_change_table_column_titles');

function faculty_change_column_rows($column_name, $post_id){
    if($column_name == 'first_name'){
        echo get_field('first_name', $post_id).PHP_EOL;
    }
    if($column_name == 'last_name'){
        echo get_field('last_name', $post_id).PHP_EOL;
    }
    if($column_name == 'research_areas'){
        echo get_the_term_list($post_id, 'research_areas', '', ', ', '').PHP_EOL;
    }
}
add_action('manage_faculty_posts_custom_column', 'faculty_change_column_rows', 10, 2);

function faculty_change_sortable_columns($columns){
    $columns['first_name'] = 'first_name';
    $columns['last_name'] = 'last_name';
    return $columns;
}
add_filter('manage_edit-faculty_sortable_columns', 'faculty_change_sortable_columns');

function name_orderby( $query ) {
    if( ! is_admin() )
        return;
 
    $orderby = $query->get( 'orderby');
 
    if( 'first_name' == $orderby ) {
        $query->set('meta_key','first_name');
        $query->set('orderby','meta_value');
    }
    if( 'last_name' == $orderby ) {
        $query->set('meta_key','last_name');
        $query->set('orderby','meta_value');
    }
}
add_action( 'pre_get_posts', 'name_orderby' );

function my_remove_meta_boxes() {
    remove_meta_box( 'course_quarterdiv', 'courses', 'side' );
    remove_meta_box( 'course_yeardiv', 'courses', 'side' );
}
add_action( 'admin_menu' , 'my_remove_meta_boxes' );


function mbe_change_table_column_titles($columns){
    unset($columns['title']);// temporarily remove, to have custom column before date column
    unset($columns['date']);// temporarily remove, to have custom column before date column
    unset($columns['taxonomy-course_year']);// temporarily remove, to have custom column before date column
    unset($columns['taxonomy-course_quarter']);// temporarily remove, to have custom column before date column
    $columns['course_acronym'] = 'Course Acronym';
    $columns['title'] = 'Course Title';
    $columns['quarters'] = 'Quarter';
    $columns['taxonomy-course_year'] = 'Year';
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

function quarter_meta( $term_id, $tt_id, $taxonomy ){
    $academic_years = get_terms('course_quarter', array ('hide_empty' => false));          
    foreach($academic_years as $key => $academic_year) {
        if (strpos($academic_year->name, 'Autumn') !== false) {
            add_term_meta($academic_year->term_id, 'quarter_order', '1', true);
        }
        elseif (strpos($academic_year->name, 'Winter') !== false) {
            add_term_meta($academic_year->term_id, 'quarter_order', '2', true );
        }
        elseif (strpos($academic_year->name, 'Spring') !== false) {
            add_term_meta($academic_year->term_id, 'quarter_order', '3', true );
        }
        elseif (strpos($academic_year->name, 'Summer A+B') !== false) {
            add_term_meta($academic_year->term_id, 'quarter_order', '4', true );
        }
        elseif (strpos($academic_year->name, 'Summer A') !== false) {
            add_term_meta($academic_year->term_id, 'quarter_order', '5', true );
        }
        elseif (strpos($academic_year->name, 'Summer B') !== false) {
            add_term_meta($academic_year->term_id, 'quarter_order', '6', true );
        }
        elseif (strpos($academic_year->name, 'Other') !== false) {
            add_term_meta($academic_year->term_id, 'quarter_order', '7', true );
        }
        else {
            add_term_meta($academic_year->term_id, 'quarter_order', '10', true );
        }
    }
}
add_action( 'create_term', 'quarter_meta', 10, 3 );