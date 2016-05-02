<?php
// filter for authors (as a taxonomy) with comma
//  replace '--' with ', ' in the output - allow authors with comma this way

if(!is_admin() && is_singular('publication')){ // make sure the filters are only called in the frontend
	
	$custom_taxonomy_type = 'author';	// here goes your taxonomy type
	
	function comma_taxonomy_filter($tag_arr){
		global $custom_taxonomy_type;
		$tag_arr_new = $tag_arr;
		if($tag_arr->taxonomy == $custom_taxonomy_type && strpos($tag_arr->name, '--')){
			$tag_arr_new->name = str_replace('--',', ',$tag_arr->name);
		}
		return $tag_arr_new;	
	}
	add_filter('get_'.$custom_taxonomy_type, comma_taxonomy_filter);
	
	function comma_taxonomies_filter($tags_arr){
		$tags_arr_new = array();
		foreach($tags_arr as $tag_arr){
			$tags_arr_new[] = comma_taxonomy_filter($tag_arr);
		}
		return $tags_arr_new;
	}
	add_filter('get_the_taxonomies',	comma_taxonomies_filter);
	add_filter('get_terms', 			comma_taxonomies_filter);
	add_filter('get_the_terms',			comma_taxonomies_filter);
}