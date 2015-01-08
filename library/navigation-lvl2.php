<?php
/**
  * Hierarchical sub menus for second-level navigation
  */

function coenv_base_hierarchical_submenu($postid) {
    $post = get_post($postid);
    $top_post = $post;
    // If the post has ancestors, get its ultimate parent and make that the top post
    if ($post->post_parent && $post->ancestors) {
        $top_post = get_post(end($post->ancestors));
    }
    // Always start traversing from the top of the tree
    return coenv_base_hierarchical_submenu_get_children($top_post, $post);
}

function coenv_base_hierarchical_submenu_get_children($post, $current_page) {
    $menu = '';
    // Get all immediate children of this page
    $args = array(
        'sort_order' => 'ASC',
        'sort_column' => 'menu_order',
        'hierarchical' => 1,
        'child_of' => $post->ID,
        'parent' => $post->ID,
        'offset' => 0,
        'post_type' => 'page',
        'post_status' => 'publish'
    ); 
    $children = get_pages($args);
    if ($children) {
        // Include a title here if needed
        $menu = "\n<ul class=\"side-nav\">\n";
        foreach ($children as $child) {
            // If the child is the viewed page or one of its ancestors, highlight it
            if (in_array($child->ID, get_post_ancestors($current_page)) || ($child->ID == $current_page->ID)) {
                $menu .= '<li class="active"><a href="' . get_permalink($child) . '" class="active">' . $child->post_title . '</a>';
            } else {
                $menu .= '<li><a href="' . get_permalink($child) . '">' . $child->post_title . '</a>';
            }
            // If the page has children and is the viewed page or one of its ancestors, get its children
            if (get_children($child->ID) && (in_array($child->ID, get_post_ancestors($current_page)) || ($child->ID == $current_page->ID))) {
                $menu .= coenv_base_hierarchical_submenu_get_children($child, $current_page);
            }
            $menu .= "</li>\n";
        }
        $menu .= "</ul>\n";
    }
    return $menu;
}
