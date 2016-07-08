<?php

/* 
 * Return faculty taxonomy terms from research areas.
 */
function coenv_base_mem_terms($id) {
	$mem_terms = wp_get_post_terms( $id, 'research_areas' );
	if ($mem_terms) {
		echo '<ul class="mem-terms inline-list">';
		foreach ($mem_terms as $term) {

			echo '<li><a class="button" href="/people/members/research_areas/' . $term->slug . '">' . $term->name . '</a></li>';
		}
		echo '</ul>';
	}
}

/*
 * Return grammatically correct first names.
 */
function coenv_base_apostophe_fname($fname) {
	if (substr($fname,-1) == 's') {
		echo $fname . '\'';
	} else {
		echo $fname . '\'s';
	}
}

function add_member_query_vars($aVars) {
    $aVars[] = "research_areas";
    return $aVars;
}
add_filter('query_vars', 'add_member_query_vars');

function members_add_rewrite_rules() {
    global $wp_rewrite;

    $new_rules = array(
        '^people/members/research_areas/(.+)/?$' => 'index.php?page_id=3214&research_areas=' . $wp_rewrite->preg_index(1)
    );
    $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}
add_action( 'generate_rewrite_rules', 'members_add_rewrite_rules' );

function member_research_filter($tax,$tax_value) {

$tax_obj = get_taxonomy($tax);
$tax_str = $tax_obj->labels->name;

$cats_args  = array(
    'orderby' => 'name',
    'order' => 'ASC',
    'taxonomy' => $tax
);
$cats = get_categories($cats_args);
    if ($cats) {
        echo '<select name="select-category" class="select-category" id="select-category">';
        echo '<option class="level-0" value="'. get_the_permalink() .'">All ' . $tax_str . '</option>';
        foreach($cats as $cat) {
            $selected = $cat->slug == $tax_value ? ' selected="selected"' : ''; 
            echo $cat->slug;
            echo $tax_value;
            echo '<option value="' . get_the_permalink() . $tax . '/' . $cat->slug . '/"' . $selected . '>' . $cat->name . '</option>';
        }
        echo '</select>';
    }
}
