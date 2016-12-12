<?php
/*
Plugin Name: WP Web Fonts
Plugin URI: http://saquery.com           
Description: <a href="admin.php?page=wp-web-fonts/wp-web-fonts.php">WP Web Fonts</a>
Version: 1.1
Author: Stephan Ahlf
Author URI: http://saquery.com
*/

 
	class wp_web_fonts{
		function admin_init() {
			register_setting( 'wpwebfontsOptions', 'wp-web-fonts-font-family' );
			register_setting( 'wpwebfontsOptions', 'wp-web-fonts-font-family-name' );
		}
		
		function init() {
		}

		function plugin_options(){
			require_once dirname(__FILE__).'/wp-web-fonts.options.php';
		}

		
		function wp_print_scripts(){		
			global $current_user;
			get_currentuserinfo(); 
			
			if ($current_user->user_level > 8 && !is_admin()){
				/* wp_enqueue_script('jquery');			
			
				$u = plugins_url( '/', __FILE__ )."wp-web-fonts-admin.js";
				$v = '1.0';
				wp_deregister_script( 'wp-web-fonts' );
				wp_register_script( 'wp-web-fonts', $u, array(), $v, false); */
			}

			
			//echo "<link href='http://fonts.googleapis.com/css?family=Ruslan+Display&v2' rel='stylesheet' type='text/css'>";
			echo (get_option('wp-web-fonts-font-family',''));  
			echo "<style>"."body,html{" . (get_option('wp-web-fonts-font-family-name','')).";}"."</style>";
		}

		function wp_print_admin_scripts(){				
		}

		function wp_print_styles() {
/* 				$u = plugins_url( '/', __FILE__ )."wp-web-fonts.css.php";			
				wp_register_style('wp-web-fonts-style', $u, array(), '1.1');
				wp_enqueue_style( 'wp-web-fonts-style'); */
		}

		function admin_menu(){
			add_menu_page('WP Web Fonts', 'WP Web Fonts', 'administrator', 'wp-web-fonts', array('wp_web_fonts','plugin_options'));
			add_submenu_page('themes.php?post_type=wiki', 'Options', 'Options', 'manage_options', 'wiki-options', array(&$this, 'options_page') );
			add_action( 'admin_init', array('wp_web_fonts','admin_init') );
		}	
		
	}
	add_action('admin_menu', array('wp_web_fonts','admin_menu'));
	add_action('wp_footer', array('wp_web_fonts', 'wp_print_scripts'), 1);
	//add_action('wp_print_styles', array('wp_web_fonts', 'wp_print_styles'),99999);
	if(isset($_GET['activate']) && $_GET['activate'] == 'true')
	add_action('init', array('wp_web_fonts', 'init'));
?>
