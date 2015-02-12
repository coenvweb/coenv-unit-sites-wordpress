<?php

/**
 * Customize the output of menus for Foundation top bar
 */

class top_bar_new_walker extends Walker_Page {

    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $output .= "\n<ul class=\"sub-menu dropdown\">\n";
    }
    
}


/**
 * Customize the output of mobile menus for Foundation top bar
 */

class top_bar_mobile_walker extends Walker_Page {
    //Start the menu rendering by indenting
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth);
        $output .= $indent . '<div class="children-' . $depth . '">';
    }
    
    static $count = 0;
    function start_el( &$output, $item, $depth = 0, $count = 0, $args = array(), $id = 0 ) {
        //Get id
        $id = $item->ID;
        $title = get_the_title($item->ID);
        $link = get_the_permalink($item->ID);
        if ( $depth === 0 ) {
            $output .= '
            <ul class="off-canvas-list item-' . $id . '">
                <a class="primary-link columns small-9" href=' . $link . '>
                    <div class="parent">' . $title . '</div>
                </a>
                <div class="accordion" data-accordion>
                    <div class="accordion-navigation">
                        <a class="right columns small-3 expander-link" href="#accordion-' . $id . '">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve" alt="arrow">
<polygon points="142.332,104.886 197.48,50 402.5,256 197.48,462 142.332,407.113 292.727,256 "/>
                            </svg>
                        </a>
                    <div class="content" id=accordion-' . $id . '>';
        }
        if ( $depth == 1 ) {
            $output .= '<li id=' . $id . '><a href=' . $link . '>' . $title . '</a></li>';
          }
        if ( $depth == 2 ) {
            $output .= '<li id=' . $id . '><a href=' . $link . '>' . $title . '</a></li>';
          } 
        self::$count++;  // increase counter
    }
    
    function end_el( &$output, $object, $depth = 0, $args = array(), $id = 0 ) {
        $output .= '';
        if ( $depth === 0 ) {
            $output .= '</div></div></div></ul>';
        }
    }
    
    function end_lvl( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $output .= '</div>';
    }
}

/**
 * Add classes for Foundation menu
 * Filter is called in header.php
 */
function add_parent_class( $css_class, $page, $depth, $args ) {
    if (!empty($args['has_children'])) {
        $css_class[] = 'has-dropdown';
    }
    if (in_array('current_page_parent', $css_class)) {
        $css_class[] = 'active';
    }
    return $css_class;
}

?>