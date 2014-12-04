<?php
function FoundationPress_theme_support() {
    // Add language support
    load_theme_textdomain('FoundationPress', get_template_directory() . '/languages');

    // Add menu support
    add_theme_support('menus');

    // Add post thumbnail support: http://codex.wordpress.org/Post_Thumbnails
    add_theme_support('post-thumbnails');
    // set_post_thumbnail_size(150, 150, false);

        // Add media sizes
        // thumbnail: 200x200 square crop
        update_option( 'thumbnail_size_w', 200 );
        update_option( 'thumbnail_size_h', 200 );
        update_option( 'thumbnail_crop', 1 );

    // rss thingy
    add_theme_support('automatic-feed-links');

    // Add post formarts support: http://codex.wordpress.org/Post_Formats
    add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

}

add_action('after_setup_theme', 'FoundationPress_theme_support'); 

/**
 * Remove comment RSS
 */
remove_action( 'wp_head','feed_links', 2 );
remove_action( 'wp_head','feed_links_extra', 3 );
add_action( 'wp_head', 'reinsert_rss_feed', 1 );

function reinsert_rss_feed() {
    echo '<link rel="alternate" type="application/rss+xml" title="' . get_bloginfo('sitename') . ' &raquo; RSS Feed" href="' . get_bloginfo('rss2_url') . '" />';
}

/**
 * Blank search searches for ' ' instead.
 **/
if(!is_admin()){
    add_action('init', 'search_query_fix');
    function search_query_fix(){
        if(isset($_GET['s']) && $_GET['s']==''){
            $_GET['s']=' ';
        }
    }
}

/*
 * Change 'Post' to 'News'
 */
function coenv_base_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'News';
    $submenu['edit.php'][5][0] = 'News';
    $submenu['edit.php'][10][0] = 'Add News';
    $submenu['edit.php'][16][0] = 'News Tags';
    echo '';
}

function coenv_base_change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'News';
    $labels->singular_name = 'News';
    $labels->add_new = 'Add News';
    $labels->add_new_item = 'Add News';
    $labels->edit_item = 'Edit News';
    $labels->new_item = 'News';
    $labels->view_item = 'View News';
    $labels->search_items = 'Search News';
    $labels->not_found = 'No News found';
    $labels->not_found_in_trash = 'No News found in Trash';
    $labels->all_items = 'All News';
    $labels->menu_name = 'News';
    $labels->name_admin_bar = 'News';
}
 
add_action( 'admin_menu', 'coenv_base_change_post_label' );
add_action( 'init', 'coenv_base_change_post_object' );

/*
 * Does the current page, post, etc. have a parent?
 */
function coenv_base_post_parent($id) {
    
    if (get_post($id)->post_parent != 0):
        return 1;
    else :
        return 0;
    endif;
}

/*
 * Section title
 */
function coenv_base_section_title($id) {

    $coenv_post = get_post($id);
    //print_r($coenv_post);
    $coenv_post_section = get_post(array_pop(get_post_ancestors($id)));

    if (coenv_base_post_parent($id)):
        $section_title = '<div class="columns large-12 section-title"><a href="/' . $coenv_post_section->post_name . '">' . $coenv_post_section->post_title . '</a></div>';
    elseif (!is_front_page()):
        $section_title = '<div class="columns large-12 section-title"><h2><a href="/' . $coenv_post_section->post_name . '">' . $coenv_post_section->post_title . '</a>></h1></div>';
    endif;
        echo $section_title;
    }