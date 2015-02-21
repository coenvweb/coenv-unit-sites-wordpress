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

/**
 * Gets the top-level ancestor for pages, posts and custom post types
 * Credit: https://github.com/elcontraption/wp-tools 
 * @param
 * - string
 * @return 
 * - array
 */
function coenv_get_ancestor($attr = 'ID') {
    
    $post = get_queried_object();

    // test for search
    if ( is_search() ) {
        return false;
    }

    if ( ($post->post_type == 'post' || is_archive() || is_search()) && !is_post_type_archive( array( 'faculty' ) ) ) {

        $page_for_posts = get_option( 'page_for_posts' );

        if ( $page_for_posts == 0 ) {
            return false;
        }

        $ancestor = get_post( $page_for_posts );
        return $ancestor->$attr;
    }

    // test for pages
    if ( $post->post_type == 'page' ) {

        // test for top-level pages
        if ( $post->post_parent == 0 ) {
            return $post->$attr;
        }

        // must be a child page
        $ancestors = get_post_ancestors( $post->ID );
        $ancestor = get_post( array_pop( $ancestors ) );
        return $ancestor->$attr;
    }

    // test for custom post types
    $custom_post_types = get_post_types( array( '_builtin' => false ), 'object' );
    if ( !empty( $custom_post_types ) && array_key_exists( $post->post_type, $custom_post_types ) ) {

        // is parent_page slug defined?
        if ( isset( $custom_post_types[ $post->post_type ]->parent_page ) ) {

            // parent_page slug is defined.
            $parent = get_page_by_path( $custom_post_types[ $post->post_type ]->parent_page );

        } else {

            // parent_page slug is not defined
            // find custom slug
            $slug = $custom_post_types[ $post->post_type ]->rewrite[ 'slug' ];

            // if a page exists with the same slug, assume that's the parent page
            $parent = get_page_by_path( $slug );
        }

        // get ancestors of $parent
        $ancestors = get_post_ancestors( $parent->ID );

        // if ancestors is empty, just return $parent;
        if ( empty( $ancestors ) ) {
            return $parent->$attr;
        }

        $ancestor = get_post( array_pop( $ancestors ) );
        return $ancestor->$attr;
    }
}

/**
 * Page banners
 *
 * From CoEnv website.
 */
function coenv_banner() {
    $obj = get_queried_object();

    $page_id = false;
    $banner = false;

    $ancestor_id = coenv_get_ancestor('ID');
    
    if ( is_singular( 'post' )) { //change news pages' section titles
        unset ($ancestor_id);
        $ancestor_id = 7;
    }
    
    if ( has_post_thumbnail( $ancestor_id ) ) {
        $page_id = $ancestor_id;
    }

    if ( $page_id == false ) {
        return false;
    }

    $thumb_id = get_post_thumbnail_id( $page_id );
    $image_src = wp_get_attachment_image_src( $thumb_id, 'banner' );
    $attachment_post_obj = get_post( $thumb_id );

    $banner = array(
        'url' => $image_src[0],
        'permalink' => get_permalink( $attachment_post_obj->ID ),
        'title' => $attachment_post_obj->post_title,
        'caption' => $attachment_post_obj->post_excerpt
    );

    return $banner;
    return $ancestor_id;
}

/*
 * Section title
 */
function coenv_base_section_title($id) {

    $coenv_post = get_post($id);
    //print_r($coenv_post);
    $coenv_post_section = get_post(array_pop(get_post_ancestors($id)));

    if (coenv_base_post_parent($id)):
        $section_title = '<div class="section-title"><a href="/' . $coenv_post_section->post_name . '">' . $coenv_post_section->post_title . '</a></div>';
    elseif (!is_front_page()):
        $section_title = '<div class="section-title"><h2><a href="/' . $coenv_post_section->post_name . '">' . $coenv_post_section->post_title . '</a></h2></div>';
    endif;
        
        echo $section_title;
    }