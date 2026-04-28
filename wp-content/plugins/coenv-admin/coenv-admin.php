<?php
/**
 * Plugin Name: College of the Environmment Admin Changes
 * Description: Features and customizations for UW College of the Environment Unit Sites
 * Version: 1.1
 * Author: College of the Environment Dean's Office
 * Author URI: http://coenv.uw.edu
 */

 
 //register activation function
 //register_activation_hook(__FILE__, 'coenv_admin_plugin_activate');
 //register deactivation function
 //register_deactivation_hook(__FILE__, 'coenv_admin_plugin_deactivate');

/**
  * Administration tweaks
  */


/**
 *  Add support for anchor button to TinyMCE
 */
function coenv_admin_tinymce_plugins($plugins) {

    $plugins['anchor'] =  plugins_url('coenv-admin/library/tinymce/anchor/plugin.min.js');
    $plugins['blockquote'] =  plugins_url('coenv-admin/library/tinymce/blockquote/plugin.js');
    return $plugins;
}
add_filter('mce_external_plugins', 'coenv_admin_tinymce_plugins');

/**
*  Remove buttons from TinyMCE
*/ 
function coenv_admin_tinymce_buttons_remove_1( $buttons ) {  
 	
 	$remove = array('formatselect', 'wp_adv');
	return array_diff($buttons,$remove);

}

add_filter('mce_buttons', 'coenv_admin_tinymce_buttons_remove_1');

function coenv_admin_tinymce_buttons_remove_2( $buttons ) {  
 	
 	$remove = array('underline','alignjustify','forecolor');
	return array_diff($buttons,$remove);

}

add_filter('mce_buttons_2', 'coenv_admin_tinymce_buttons_remove_2');

 
// Keep the "kitchen sink" open
function changeMceDefaults($in) {
    $in[ 'wordpress_adv_hidden' ] = FALSE;
    return $in;
}
add_filter( 'tiny_mce_before_init', 'changeMceDefaults' );

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
            'block' => 'p',
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
  $plugin_array['clear'] = WP_PLUGIN_URL .'/'.$plugin_name.'/library/tinymce/clear/editor_plugin.js';
   return $plugin_array;
}

add_action('init', 'tinymce_clear_addbuttons');

function tinymce_clear_buttons_before_init( $init ) {
    // do not remove empty divs
    if ( isset( $init['extended_valid_elements'] ) ) {
        $init['extended_valid_elements'] .= ',div[clear|style|class]';
    }
    return $init;
}

add_filter('tiny_mce_before_init', 'tinymce_clear_buttons_before_init');

function coenv_admin_mce_css( $mce_css ) {

	$mce_css .= ', ' . plugins_url( 'coenv-tinymce.css', __FILE__ );

	return $mce_css;
}

add_filter( 'mce_css', 'coenv_admin_mce_css' );

//override new user notification function with custom email
if ( !function_exists( 'wp_new_user_notification' ) ) {
    function wp_new_user_notification( $user_id, $plaintext_pass = '' ) {
        // set content type to html
        add_filter( 'wp_mail_content_type', 'wpmail_content_type' );

        // user
        $user = new WP_User( $user_id );
        $userEmail = stripslashes( $user->user_email );
        $siteUrl = get_home_url();
        $loginUrl = wp_login_url();
        $logoUrl = plugin_dir_url( __FILE__ ).'collegeLogo.png';

        $subject = 'Welcome to the College of the Environment Web Framework';
        $headers = 'From: College of the Environment Web Team <coenvweb@uw.edu>';

        // admin email
        $message  = "A new user has been created"."\r\n\r\n";
        $message .= 'Email: '.$userEmail."\r\n";
        @wp_mail( get_option( 'admin_email' ), 'environment.uw.edu New User Notification', $message, $headers );

        ob_start();
        include plugin_dir_path( __FILE__ ).'/email_welcome.php';
        $message = ob_get_contents();
        ob_end_clean();

        @wp_mail( $userEmail, $subject, $message, $headers );

        // remove html content type
        remove_filter ( 'wp_mail_content_type', 'wpmail_content_type' );
    }
}

/**
 * wpmail_content_type
 * allow html emails
 */
function wpmail_content_type() {
    return 'text/html';
}
