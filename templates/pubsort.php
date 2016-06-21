<?php
/*
Template Name: Publications Sort Migration
*/

$query_args = array(
    'post_type' => 'publications',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'meta_key' => 'publication_year',
    'orderby' => array( 'meta_value_num' => 'DESC', 'post_title' => 'ASC' )
);

$wp_query = new WP_Query($query_args);

foreach($wp_query->posts as $post) {
    $year = get_the_terms($post->ID, 'publication_year');
    update_field('publication_year', $year[0]->name, $post->ID);
    echo "Updated to " . $year[0]->name . "\n";
}
?>
