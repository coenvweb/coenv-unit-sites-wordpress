<?php
/**
 * Generates all the rewrite rules for a given post type and it's taxonomies.
 *
 * @param string|object $post_type The post type for which you wish to create the rewrite rules
 * @param string $index_path relative path from site root to the index page for your cpt
 * @param 2D array $extra_rules optional Non-taxonomy query vars you wish to create rewrite rules for. Rules will be added in the form '/query_var/(.+)/'. 
 * Each nested array represents rules to be treated together as one rewrite
 *
 */
function generate_cpt_rewrite_rules( $post_type, $index_path, $query_vars = array() ) {
    global $wp_rewrite;

    if( ! is_object( $post_type ) )
        $post_type = get_post_type_object( $post_type );

    $new_rewrite_rules = array();

    $taxonomies = get_object_taxonomies( $post_type->name, 'objects' );

    $index_page = get_page_by_path($index_path);

    // all possible taxonomies for each cpt to queryvars
    foreach( $taxonomies as $taxonomy )
        $query_vars[] = $taxonomy->name;

    // All possible permutations of queryvars
    for( $i = 1; $i <= count( $query_vars );  $i++ ) {

        $new_rewrite_rule =  $index_path . '/';
        $new_query_string = 'index.php?page_id=' . $index_page->ID;

        // Prepend the rewrites & queries
        for( $k = 1; $k <= $i; $k++ ) {
            $new_rewrite_rule .= '(' . implode( '|', $query_vars ) . ')/(.+?)/';
            $new_query_string .= '&' . $wp_rewrite->preg_index( $k * 2 - 1 ) . '=' . $wp_rewrite->preg_index( $k * 2 );
        }

        // Add the ability to page all rewrites
        $new_paged_rewrite_rule = $new_rewrite_rule . 'page/([0-9]{1,})/';
        $new_paged_query_string = $new_query_string . '&paged=' . $wp_rewrite->preg_index( $i * 2 + 1 );

        // Trailing slash is optional
        $new_paged_rewrite_rule = $new_paged_rewrite_rule . '?$';
        $new_rewrite_rule = $new_rewrite_rule . '?$';

        $new_rewrite_rules = array( $new_paged_rewrite_rule => $new_paged_query_string,
                                    $new_rewrite_rule       => $new_query_string )
                             + $new_rewrite_rules;
    }

    return $new_rewrite_rules;
}

function add_cpt_rewrites($wp_rewrite) {
    $a_rules = generate_cpt_rewrite_rules('post', 'news-and-events', array('coenv-year', 'coenv-month'));
    $b_rules = generate_cpt_rewrite_rules('datasets', 'resources/data/cig-datasets');
    $c_rules = generate_cpt_rewrite_rules('publications', 'resources/publications', array('publication_author'));
    $d_rules = generate_cpt_rewrite_rules('projects', 'our-work/projects', array('project_topic', 'region', 'year'));
    $wp_rewrite->rules = $a_rules + $b_rules + $c_rules + $d_rules + $wp_rewrite->rules;
}
add_action('generate_rewrite_rules', 'add_cpt_rewrites');

function add_query_vars() {
    add_rewrite_tag('%publication_year%', '(.+?)/');
    add_rewrite_tag('%publication_author%', '(.+?)/');
    add_rewrite_tag('%publiction_theme%', '(.+?)/');
    add_rewrite_tag('%dataset_region%', '(.+?)/');
    add_rewrite_tag('%dataset_type%', '(.+?)/');
    add_rewrite_tag('%coenv-month%', '(.+?)/');
    add_rewrite_tag('%coenv-year%', '(.+?)/');
    add_rewrite_tag('%category%', '(.+?)/');
    add_rewrite_tag('%project_topic%', '(.+?)/');
    add_rewrite_tag('%project_region%', '(.+?)/');
    add_rewrite_tag('%project_year%', '(.+?)/');
}
add_action('init', 'add_query_vars');

?>
