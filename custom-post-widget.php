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
$widget_img_attr = array(
	'src'	=> $src,
	'class'	=> "attachment-$size",
	'alt'	=> trim( strip_tags( $attachment->post_excerpt ) ),
	'title'	=> trim( strip_tags( $attachment->post_title ) ),
);
$widget_img = get_the_post_thumbnail( $content_post -> ID, 'sm-sq');
$widget_copy = get_field('block_text', $content_post -> ID);
$rows = get_field('add_links', $content_post -> ID);

if($rows) {
    $buttons = '<ul class="widget_links">';
    foreach($rows as $row) {
        if($row['link_type'] == 'internal') {
            $link_title =  $row['link_to_a_page_on_this_site'][0]['link_title_internal'];
            $link_url = get_permalink($row['link_to_a_page_on_this_site'][0]['select_page'][0]);
            $link_target = 'self';	
            $buttons .= '<li><a class="button" title="' . $link_title . '" href="' . $link_url . '" target="_' . $link_target . '">' . $link_title . '</a></li>';
        } elseif ($row['link_type'] == 'external') {
            $link_title = $row['link_to_an_external_site'][0]['link_title'];
            $link_url = $row['link_to_an_external_site'][0]['link_url'];
            $link_target ='blank';
            $buttons .= '<li><a class="button"  title="' . $link_title . '" href="' . $link_url . '" target="_' . $link_target . '">' . $link_title . '</a></li>';
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
	echo '<a title="' . $first_link_title . '" href="' . $first_link_url . '" target="_' . $first_link_target . '">' . $widget_img . '</a>';
	echo '</div>';
	}
echo '<div class="widget_content">';
if ( $link_position[0] == 'title' ) {
    echo $buttons;
}
if ( $show_custom_post_title ) {
	echo $before_title;
	echo '<a title="' . $first_link_title . '" href="' . $first_link_url . '" target="_' . $first_link_target . '">' . $widget_title . '</a>';
	echo $after_title;
}
echo $widget_copy;
echo '</div>';
if ( $link_position == null ) {
	echo $buttons;
}
echo $after_widget;