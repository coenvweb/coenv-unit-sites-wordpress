<?php 

/**
 * Print optional metas based on ACF options.
 * @return 
 * - echo string
 */
function coenv_custom_metas() {
    // Post info
    $page_id = get_queried_object_id(); 
    $ancestor = coenv_get_ancestor();
    
    // Source code line breaks
    $break = PHP_EOL;
 
    // Meta ACFs
    $meta_description_on_page = trim(get_field('meta_description_on_page', $page_id));
    $meta_robots = trim(get_field('meta_robots', $page_id));

    // Social ACFs
    $social_share_title = trim(get_field('social_share_title', $page_id));
    $social_share_description = trim(get_field('social_share_description', $page_id));
    $social_share_image = trim(get_field('social_share_image', $page_id)); 

    // Get featured image, or use ancestor's if empty, or fallback to logo
    if ($social_share_image) {
        $featured_img = $social_share_image;   
    } elseif (has_post_thumbnail($page_id)) {
        $featured_img = get_the_post_thumbnail_url($page_id, 'large' );
    } elseif (has_post_thumbnail($ancestor)) {
        $featured_img = get_the_post_thumbnail_url($ancestor, 'large' );
    } else {
        $featured_img = get_template_directory_uri() . '/assets/img/safs-default.jpg';
    }
    
    // Get featured image width and heights
    list($featured_img_width,$featured_img_height,$featured_img_type,$featured_img_attr) = @getimagesize($featured_img);
    
    $html = '';
    
    $html .= '<meta property="og:type" content="website">';
    
    // Add custom meta description if added.
    if ($meta_description_on_page) {
        $html .= '<meta name="description" content="' . $meta_description_on_page . '"/>' . $break;
    } 
    // Add meta robots if added
    if ($meta_robots) {
        $html .= '<meta name="robots" content="' . $meta_robots . '"/>' . $break;
    }  
    // Add social image if declared in ACF. Default will use featured img.  
    if ($featured_img) {
        $html .= '<meta property="og:image" content="' . $featured_img . '"/>' . $break;
        $html .= '<meta property="og:image:width" content="' . $featured_img_width . '" />' . $break;
        $html .= '<meta property="og:image:height" content="' . $featured_img_height . '" />' . $break;
        $html .= '<meta property="twitter:image" content="' . $featured_img . '"/>' . $break;
    } 
    // Add social title if declared in ACF. Default will use meta title.
    if ($social_share_title) {
        $html .= '<meta property="og:title" content="' . $social_share_title . '"/>' . $break;
        $html .= '<meta property="twitter:title" content="' . $social_share_title . '"/>' . $break;
    } else {
        $html .= '<meta property="og:title" content="' . get_the_title() . '"/>' . $break;
        $html .= '<meta property="twitter:title" content="' . get_the_title() . '"/>' . $break;
    }
    // Add social description if declared in ACF. 
    if ($social_share_description) {
        $html .= '<meta property="og:description" content="' . $social_share_description . '"/>' . $break;
        $html .= '<meta property="twitter:description" content="' . $social_share_description . '"/>';
    } else {
        $html .= '<meta property="og:description" content="' . get_the_excerpt() . '"/>' . $break;
        $html .= '<meta property="twitter:description" content="' . get_the_excerpt() . '"/>';
    }

    return $html;
} 

