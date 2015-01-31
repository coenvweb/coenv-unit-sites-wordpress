<?php
/**
 * Customize the output of menus for Foundation top bar
 */

class top_bar_walker extends Walker_Nav_Menu {

    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
        $element->has_children = !empty( $children_elements[$element->ID] );
        $element->classes[] = ( $element->current || $element->current_item_ancestor ) ? 'active' : '';
        $element->classes[] = ( $element->has_children && $max_depth !== 1 ) ? 'has-dropdown' : '';
        
        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
    
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $item_html = '';
        parent::start_el( $item_html, $object, $depth, $args ); 
        
        $output .= ( $depth == 0 ) ? '<li class="divider"></li>' : '';
        
        $classes = empty( $object->classes ) ? array() : (array) $item->classes;  
        
        if( in_array('label', $classes) ) {
            $output .= '<li class="divider"></li>';
            $item_html = preg_replace( '/<a[^>]*>(.*)<\/a>/iU', '<label>$1</label>', $item_html );
        }
        
        if ( in_array('divider', $classes) ) {
            $item_html = preg_replace( '/<a[^>]*>( .* )<\/a>/iU', '', $item_html );
        }
        
        $output .= $item_html;
    }
    
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $output .= "\n<ul class=\"sub-menu dropdown\">\n";
    }
    
}

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
            $output .= '<ul class="off-canvas-list item-' . $id . '"><a class="primary-link columns small-9" href=' . $link . '><div class="accordion">' . $title . '</div></a><div class="accordion" data-accordion><div class="accordion-navigation"><a class="right columns small-3 expander-link" href="#accordion-' . $id . '"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="32px" height="32px" viewBox="50.5 126.989 411.451 258.021"
	 enable-background="new 50.5 126.989 411.451 258.021" xml:space="preserve">
<path id="arrow-16-icon" d="M332.722,181.953v-54.964l129.229,129.012l-129.229,129.01v-54.964H50.049l147.899-148.094H332.722z"/>
</svg></a><div class="content" id=accordion-' . $id . '>';
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
            $output .= '</div></div></ul>';
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