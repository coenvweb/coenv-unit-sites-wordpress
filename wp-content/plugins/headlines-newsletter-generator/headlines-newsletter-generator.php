<?php
/*
* Plugin Name: College of the Environment Newsletter Generator
* Plugin URI: http://www.github.com/coenvweb
* Description: A tool that dumps formatted inky markup for the college's newsletter
* Version: 2.0
* Author: Cole Bessee
* Author URI: http://www.github.com/cbessee
* License: GPL2

Copyright 2016 Cole Bessee - UW College of the Environment

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License,
version 2, as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/

//TODO: Req ACF?

add_action('admin_enqueue_scripts', 'enqueue_headlines_scripts');
function enqueue_headlines_scripts() {
    wp_enqueue_script(
        'main',
        plugin_dir_url( __FILE__ ) . 'includes/js/main.js',
        array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'),
        time(),
        true
    );
    wp_enqueue_style('jquery-ui-datepicker', plugin_dir_url( __FILE__ ) . 'includes/jquery-ui-themes-1.11.4/themes/smoothness/jquery-ui.min.css');
    wp_localize_script( 'main', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}

add_action('admin_menu', 'register_newsletter_admin_page');
function register_newsletter_admin_page() {
    add_submenu_page('edit.php?post_type=newsletter', 'Headlines Newsletter', 'Headlines Newsletter', 'export', 'headlines-newsletter', 'headlines_page');
    add_submenu_page('edit.php?post_type=newsletter', 'SciComm Newsletter', 'SciComm Newsletter', 'export', 'scicomm-newsletter', 'scicomm_page');
}

function headlines_page() {
    include('headlines_page.php');
}

function scicomm_page() {
    include('scicomm_page.php');
}

require_once('newsletter_cpt.php');

function newsletter_columns($columns) {
	$columns = array(
		'cb'	 	=> '<input type="checkbox" />',
		'title' 	=> 'Title',
		'newsletter_type' 	=> 'Newsletter Type',
		'author'	=>	'Author',
		'date'		=>	'Date Published',
	);
	return $columns;
}

function newsletter_custom_columns($column)
{
	global $post;
	if($column == 'newsletter_type')
	{
		echo get_field('newsletter_type', $post->ID);
	}
}

add_action("manage_newsletter_posts_custom_column", "newsletter_custom_columns");
add_filter("manage_edit-newsletter_columns", "newsletter_columns");

require_once('generator.php');

add_action('wp_ajax_build_newsletter', 'build_newsletter_service');

function build_newsletter_service() {

    $newsletter_id = $_POST['newsletter'];

    //TODO: Fire build gen based on newsletter type?
    $generator = new HTMLEmailGenerator($newsletter_id);

    echo $generator->getNewsletter();

    wp_die();
}
?>
