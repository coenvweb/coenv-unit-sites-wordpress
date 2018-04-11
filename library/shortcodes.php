<?php

function datatable_func( $atts, $content = null ) {
	$dt = shortcode_atts( array(
        'search' => 0,
    ), $atts );
	echo var_dump($dt);
    return '<div class="datatable '.($dt['search'] ? 'search' : 'no-search').'">' . $content . '</div>';
}
add_shortcode( 'datatable', 'datatable_func' );

?>
