<?php

/* 
 * Return member taxonomy terms from research areas.
 */
function coenv_base_mem_terms($id) {
	$mem_terms = wp_get_post_terms( $id, 'research-areas' );
	if ($mem_terms) {
		echo '<ul class="mem-terms inline-list">';
		foreach ($mem_terms as $term) {

			echo '<li><a class="button" href="/people/members/research-areas/' . $term->slug . '">' . $term->name . '</a></li>';
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
