<?php
if ( !$apply_content_filters ) { 
	$content = apply_filters( 'the_content', $content);
}

/* 
 * Set up variables
 */
$link_type = get_field( "link_type", $content_post -> ID );
$link_type_internal = get_field( "link_page", $content_post -> ID );
$link_position = get_field( "link_position", $content_post -> ID );
$widget_title = apply_filters( 'widget_title', $content_post->post_title);
$src = 0;
$size = 0;
if (isset($attachment)){
    $widget_img_attr = array(
        'src'	=> $src,
        'class'	=> "attachment-$size",
        'alt'	=> trim( strip_tags( $attachment->post_excerpt ) ),
        'title'	=> trim( strip_tags( $attachment->post_title ) ),
    );
} else {
    $widget_img_attr = array(
        'src'	=> $src,
        'class'	=> "attachment-$size",
    );
}
$widget_img = get_the_post_thumbnail( $content_post -> ID, 'medium');
$widget_copy = get_field( 'block_text', $content_post -> ID );
$rows = get_field( 'add_links', $content_post -> ID );

$buttons = "";
if( !empty( $rows ) )  {
    $buttons = '<ul class="widget_links">';
    $first = true;
    foreach($rows as $row) {
        if($row['link_type'] == 'internal') {
            $link_title =  $row['link_to_a_page_on_this_site'][0]['link_title_internal'];
            $link_url = get_permalink($row['link_to_a_page_on_this_site'][0]['select_page'][0]);
            $link_target = 'self';	
            $buttons .= '<li><a class="button white" href="' . $link_url . '" target="_' . $link_target . '">' . $link_title . '</a></li>';
            if ( $first ) {
                $first_link_title = $link_title;
                $first_link_url = $link_url;
                $first_link_target = $link_target;
                $first = false;
            }
        } elseif ($row['link_type'] == 'external') {
            $link_title = $row['link_to_an_external_site'][0]['link_title'];
            $link_url = $row['link_to_an_external_site'][0]['link_url'];
            $link_target ='blank';
            $buttons .= '<li><a class="button white" href="' . $link_url . '" target="_' . $link_target . '">' . $link_title . '</a></li>';
            if ( $first ) {
                $first_link_title = $link_title;
                $first_link_url = $link_url;
                $first_link_target = $link_target;
                $first = false;
            }
        } 
    }
    $buttons .= '</ul>';
}

/*
 * Print the widget
 */
echo $before_widget;

if ( $show_featured_image ) {
	echo '<div class="widget_img">';
	echo $widget_img;
	echo '</div>';
	}
echo '<div class="widget_content">';
if ( !empty($link_position) && $link_position[0] == 'title' ) {
    echo $buttons;
}
if ( $show_custom_post_title) {
	echo $before_title;
    if (!empty($first_link_title)) { echo '<a title="' . $first_link_title . '" href="' . $first_link_url . '" target="_' . $first_link_target . '">'; }
    echo $widget_title; 
    if (!empty($first_link_title)) { echo '</a>'; }
	echo $after_title;
}
echo $widget_copy;
if ( $link_position == null ) {
    echo $buttons;
}
echo '</div>';

echo $after_widget;