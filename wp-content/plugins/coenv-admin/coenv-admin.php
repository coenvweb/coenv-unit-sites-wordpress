<?php
/**
 * Plugin Name: College of the Environmment Unit Site Framework
 * Description: Features and customizations for UW College of the Environment Unit Sites
 * Version: 1.0
 * Author: College of the Environment Dean's Office
 * Author URI: http://coenv.uw.edu
 */

function getarchives_where_filter( $where, $args ) {

    if ( isset($args['post_type']) ) {      
        $where = "WHERE post_type = '$args[post_type]' AND post_status = 'publish'";
    }

    return $where;
}


function get_archives_student_blog( $link ) {

    $mylink = str_replace( get_site_url(), '', $link );
    $mylink = str_replace('blog','',$mylink);
    //$mylink = preg_replace('/(\/[0-9]{4})/', '$1', $mylink);

    $mylink2 = preg_replace('/(\/[0-9]{4})/', '?year=_$1', $mylink);
    $mylink3 = preg_replace('/(\/[0-9]{2})/', '?month=_$1', $mylink2);

    //$mylink = preg_replace('/(\/[0-9]{2})/', '?month=_$2', $mylink);




    //'/\/([0-9])\w+'

    return $mylink3;
};

 add_filter( 'getarchives_where', 'getarchives_where_filter', 10, 2 );




/**
  * Administration tweaks
  */


/**
 *  Add support for anchor button to TinyMCE
 */
function coenv_admin_tinymce_plugins($plugins) {

    $plugins['anchor'] =  plugins_url('coenv-admin/library/tinymce/anchor/plugin.min.js');
    return $plugins;
}
add_filter('mce_external_plugins', 'coenv_admin_tinymce_plugins');

/**
*  Remove buttons from TinyMCE
*/ 
function coenv_admin_tinymce_buttons_remove( $buttons ) {  
 	
 	$remove = array('underline','alignjustify','forecolor');
	return array_diff($buttons,$remove);

}

add_filter('mce_buttons_2', 'coenv_admin_tinymce_buttons_remove');

/**
*  Add buttons to TinyMCE
*/ 
function coenv_admin_tinymce_buttons_add($buttons) {

    $buttons[] = 'anchor';
    return $buttons;

}

add_filter("mce_buttons_2", "coenv_admin_tinymce_buttons_add");

/**
 * Define the block-level elements available to the TinyMCE WYSIWYG editor
 */
function coenv_admin_tinymce_styles( $arr ) {

$arr['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Theme Button=intro';
return $arr;
}

// add_filter('tiny_mce_before_init', 'coenv_admin_tinymce_styles');

/**
 * Add custom styles to TinyMCE
 */

add_filter( 'mce_buttons_2', 'fb_mce_editor_buttons' );
function fb_mce_editor_buttons( $buttons ) {

    array_unshift( $buttons, 'styleselect' );
    $value = array_search( 'formatselect', $buttons );
    if ( FALSE !== $value ) {
        foreach ( $buttons as $key => $value ) {
            if ( 'formatselect' === $value )
                unset( $buttons[$key] );
        }
    }
    return $buttons;
}

/**
 * Add styles/classes to the "Styles" drop-down
 */ 
add_filter( 'tiny_mce_before_init', 'fb_mce_before_init' );

function fb_mce_before_init( $settings ) {

    $style_formats = array(
        array(
            'title' => 'Paragraph',
            'block' => 'p',
        ),
        array(
            'title' => 'Introduction',
            'block' => 'span',
            'classes' => 'intro'
        ),
        array(
            'title' => 'Button',
            'block' => 'span',
            'classes' => 'button'
        ),
        array(
            'title' => 'Heading 2',
            'block' => 'h2',
        ),
        array(
            'title' => 'Heading 3',
            'block' => 'h3'
        ),
        array(
            'title' => 'Heading 4',
            'block' => 'h4'
        )
    );

    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;

}

function coenv_admin_mce_css( $mce_css ) {

	$mce_css .= ', ' . plugins_url( 'coenv-tinymce.css', __FILE__ );

	return $mce_css;
}

add_filter( 'mce_css', 'coenv_admin_mce_css' );



/**
 * Add float clearing buttons to TinyMCE
 * 
 */

function tinymce_clear_addbuttons() {
   // Don't bother doing this stuff if the current user lacks permissions
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
 
   // Add only in Rich Editor mode
   if ( get_user_option('rich_editing') == 'true') {
     add_filter("mce_external_plugins", "add_tinymce_clear_plugin");
     add_filter('mce_buttons', 'register_tinymce_clear_buttons');
   }
}
 
function register_tinymce_clear_buttons($buttons) {
   array_push($buttons, "separator", "clearleft","clearright","clearboth");
   return $buttons;
}
 
// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
function add_tinymce_clear_plugin($plugin_array) {
  $plugin_name = preg_replace('/\.php/','',basename(__FILE__));
  $plugin_array['clear'] = WP_PLUGIN_URL .'/'.$plugin_name.'/mce/clear/editor_plugin.js';
   return $plugin_array;
}
 
add_action('init', 'tinymce_clear_addbuttons');

function tinymce_clear_buttons_before_init( $init ) {
    // do not remove empty divs
    $init['extended_valid_elements'] .= ',div[clear|style|class]';
    return $init;
}

add_filter('tiny_mce_before_init', 'tinymce_clear_buttons_before_init');






