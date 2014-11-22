<?php
/**
 * Plugin Name: College of the Environmment Unit Site Framework
 * Description: Features and customizations for UW College of the Environment Unit Sites
 * Version: 1.0
 * Author: College of the Environment Dean's Office
 * Author URI: http://coenv.uw.edu
 */




/* Custom variables and paths */
function coenv_admin_plugin_activate() {
  coenv_admin_plugin_rules();
  flush_rewrite_rules();
 }

 function coenv_admin_plugin_deactivate() {
  flush_rewrite_rules();
 }

 function coenv_admin_plugin_rules() {
  add_rewrite_rule('students/student_blog/([A-Za-z0-9\-\_]+)/([A-Za-z0-9\-\_]+)/([A-Za-z0-9\-\_]+)/([A-Za-z0-9\-\_]+)/?$', 'index.php?pagename=students/student_blog/&coenv_cat_1=$matches[1]&coenv_cat_2=$matches[2]&coenv_cat_3=$matches[3]&paged=$matches[4]', 'top');
//works

  //add_rewrite_rule('students/student_blog/([A-Za-z0-9\-\_]+)/([A-Za-z0-9\-\_]+)/([A-Za-z0-9\-\_]+)/?$', 'index.php?pagename=students/student_blog/&coenv_cat_1=$matches[1]&coenv_cat_2=$matches[2]&paged=$matches[3]', 'top');

  add_rewrite_rule('students/student_blog/([A-Za-z0-9\-\_]+)/([A-Za-z0-9\-\_]+)/?$', 'index.php?pagename=students/student_blog/&coenv_cat_1=$matches[1]&paged=$matches[2]', 'top');

  //add_rewrite_rule('students/student_blog/([A-Za-z0-9\-\_]+)/([A-Za-z0-9\-\_]+)/?$', 'index.php?pagename=students/student_blog/&coenv_cat_1=$matches[1]&coenv_cat_2=$matches[2]', 'top');

  //add_rewrite_rule('students/student_blog/([A-Za-z0-9\-\_]+)/?$', 'index.php?pagename=students/student_blog/&coenv_cat_1=$matches[1]', 'top');
 }
/*
 function coenv_admin_plugin_query_vars($vars) {
  $vars[] = 'coenv_cat_1';
  $vars[] = 'coenv_cat_2';
  $vars[] = 'coenv_cat_3';
  return $vars;
 }
 */

 function add_query_vars() {
    global $wp;
    $wp->add_query_var('coenv_cat_1');
    $wp->add_query_var('coenv_cat_2');
    $wp->add_query_var('coenv_cat_3');
    $wp->add_query_var('coenv_cat_4');
}
add_action('init', 'add_query_vars');
 
 //register activation function
 register_activation_hook(__FILE__, 'coenv_admin_plugin_activate');
 //register deactivation function
 register_deactivation_hook(__FILE__, 'coenv_admin_plugin_deactivate');
 //add rewrite rules in case another plugin flushes rules
 add_action('init', 'coenv_admin_plugin_rules');
 //add plugin query vars (product_id) to wordpress
 //add_filter('query_vars', 'coenv_admin_plugin_query_vars');




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

$arr['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4';
return $arr;
}

add_filter('tiny_mce_before_init', 'coenv_admin_tinymce_styles');

/**
 * Add custom styles to TinyMCE
 */
function coenv_admin_mce_css( $mce_css ) {

	$mce_css .= ', ' . plugins_url( 'coenv-admin.css', __FILE__ );

	return $mce_css;
}

add_filter( 'mce_css', 'coenv_admin_mce_css' );