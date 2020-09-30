<?php

function trumba_func( $atts ) {
    
    $trumba = shortcode_atts( array(
        'webname' => 'coenveventscalendar',
        'spudtype' => 'main',
        'url' => null,
        'teaserbase' => null
    ), $atts );

    return '
       <div role="region" aria-labelledby="calendar_view">
    <h2 class="visuallyhidden" id="calendar_view">
    Main Calendar View
    </h2>
    <script type="text/javascript" src="//www.trumba.com/scripts/spuds.js"></script>
    <script type="text/javascript">
    $Trumba.addSpud({
    webName: "' . $trumba['webname'] . '",
    spudType : "' . $trumba['spudtype'] .'",
    url: {' . $trumba['url'] . '},
    teaserBase: "' . $trumba['teaserbase'] . '"});
    </script>
    <noscript>Your browser must support JavaScript to view this content. 
    Please enable JavaScript in your browser settings then try again. 
    <a href="http://www.trumba.com">Events calendar powered by Trumba</a></noscript>
    </div>';
}
add_shortcode( 'trumba', 'trumba_func' );

function tableau_func( $atts ) {
    $tableau = shortcode_atts( array(
        'host_url' => 'http://myserver.com',
        'site_root' => null,
        'name' => 'My Data',
        'tabs' => 'yes',
        'toolbar' => 'yes',
        'width' => 800,
        'height' => 600,
        'alt_image' => null,
        'static_image' => null,
        'animate_transition' => null,
        'display_static_image' => null,
        'display_spinner' => null,
        'display_overlay' => null,
        'display_count' => null,
        'showVizHome' => null,
        'showTabs' => null,
        'bootstrapWhenNotified' => 'null'
        
    ), $atts );

    return '
    <script type="text/javascript" src="https://tableau.washington.edu/javascripts/api/viz_v1.js"></script> 
    <div class="tableauPlaceholder" style="width: ' . $tableau['width'] . ' height: ' . $tableau['height'] . '"> 
    <noscript><a href=""><img src="' . $tableau['alt_image'] . '" style="border: none" /></a></noscript>
    <object class="tableauViz" width="' . $tableau['width'] . '" height="' . $tableau['height'] . '" style="display:none;">
   <param name="host_url" value="' . $tableau['host_url'] . '" /> 
   <param name="site_root" value="' . $tableau['site_root'] . '" /> 
   <param name="name" value="' . $tableau['name'] . '" /> 
   <param name="tabs" value="' . $tableau['tabs'] . '" /> 
   <param name="toolbar" value="' . $tableau['toolbar'] . '" />
   <param name="static_image" value="' . $tableau['static_image'] . '" />
   <param name="animate_transition" value="' . $tableau['animate_transition'] . '" />
   <param name="display_static_image" value="' . $tableau['display_static_image'] . '" />
   <param name="display_spinner" value="' . $tableau['display_spinner'] . '" />
   <param name="display_overlay" value="' . $tableau['display_overlay'] . '" />
   <param name="display_count" value="' . $tableau['display_count'] . '" />
   <param name="showVizHome" value="' . $tableau['showVizHome'] . '" />
   <param name="showTabs" value="' . $tableau['showTabs'] . '" />
   <param name="bootstrapWhenNotified" value="' . $tableau['bootstrapWhenNotified'] . '" />
   </object></div>'; 
}

add_shortcode( 'tableau', 'tableau_func' );

function gmap_func( $atts ) {
    $gmap = shortcode_atts( array(
        'src' => 'http://myserver.com',
        'width' => 795,
        'height' => 480,
        
    ), $atts );

    return '<iframe src="' . $gmap['src'] . '" width="' . $gmap['width'] . '" height="' . $gmap['height'] . '"></iframe>'; 
}

add_shortcode( 'gmap', 'gmap_func' );

function tile_func($atts, $content = null) {
    $attributes = shortcode_atts( array(
        'ids' => '', 
    ), $atts);

	if($attributes['ids']) {
		$tiles = array($tiles[$attributes['ids']]);
        $ids = explode(',', $attributes['ids']);
        $tiles_acf = get_field('tiles');
        $tiles = array();
        foreach($ids as $id) {
            $id = $id - 1;
            if($tiles_acf[$id]) {
                $tiles[] = $tiles_acf[$id];
            }
        }
	} else {
      $tiles = get_field('tiles');
    }

    $output = '<div class="tiles-container">';
        if($tiles)  {
            foreach($tiles as $tile) {

                if($tile['links']) {
                    $links = '';
                    foreach($tile['links'] as $link) {
                        $links .= '<a class="tile-link button" href="'.$link['url'].'" target="'.(strpos($link['url'], $_SERVER['HTTP_HOST']) ? '' : '_blank').'">'.$link['link_text'].'</a>';
                    }
                }

                $output .= "<div class='page-tile' style='background-image: url(".$tile['image']['sizes']['medium'].");'>";
                    if($img_tag) {
                        $output .= $img_tag;
                    }
                    $output .= '<div class="content-wrap">';
                        $output .= "<h3 class='title'>".$tile['title']."</h3>";
                        if($tile['body_content']) {
                            $output .= "<div class='body'>".$tile['content']."</div>";
                        }
                        if($links) {
                            $output .= $links;
                        }
                    $output .= "</div>";
                $output .= "</div>";
            }
        }
        if(count($tiles) >= 2) {
            $output .= "<div style='clear:both'></div>";
        }
    $output .= '</div>';
    return $output;
}
add_shortcode('page-tiles', 'tile_func');

function tile_func_v2($atts, $content = null) {
    $attributes = shortcode_atts( array(
        'ids' => '',
    ), $atts);
        
        
    if($attributes['ids']) {
        $ids = explode(',', $attributes['ids']);
        $tiles_acf = get_field('tiles_v2');
        $tiles = array();
        foreach($ids as $id) {
            $id = --$id;
            if(@$tiles_acf[$id]) {
                $tiles[] = $tiles_acf[$id];
            }
        }
    } else {
        $tiles = get_field('tiles_v2');
    }       
                
    $output = '<div class="expandable-tiles-container">';
        if($tiles)  {
            $count = 1;
            foreach($tiles as $tile) {
                if($tile['image']) {
                    $img_tag = '<img class="tile-image" src="'.$tile['image']['sizes']['med_sq'].'" alt="'.$tile['image']['alt'].'" />';
                }       
                    
                if($tile['links']) {
                    $links = '';
                    foreach($tile['links'] as $link) {
                        $links .= '<a class="tile-link button" href="'.$link['url'].'" target="'.(strpos($link['url'], $_SERVER['HTTP_HOST']) ? '' : '_blank').'">'.$link['link_text'].'</a>';
                    }   
                }           
                        
                $output .= "<div class='page-tile'>";
                    $output .= '<div class="top-wrap">';
                        if($img_tag) {
                            $output .= $img_tag;
                        }   
                        $output .= '<div class="title-wrap">';
                            $output .= "<h3 class='title'>".$tile['title']."</h3>";
                            if($tile['sub_title']) {
                                $output .= "<p class='sub-title'>".$tile['sub_title']."</p>";
                            }

                        $output .= '</div>';
                        if($tile['body_content'] || $links) {
                            $output .= '<i class="fi-arrows-expand"></i>';
                        }
                    $output .= '</div>';
                    if($tile['body_content']) {
                        $output .= '<div class="content-wrap">';
                            $output .= "<div class='body'>".$tile['body_content']."</div>";
                    }   
                            if($links) {
                                $output .= $links;
                            } 
                    if($tile['body_content']) {
                        $output .= "</div>";
                    }
                $output .= "</div>";
                if($count % 2 == 0) {
                    $output .= "<br style='clear:both;' />";
                }
				$count++;
            }
        }
    $output .= '</div><br style="clear:both;" />';
    return $output;
}
add_shortcode('expandable-tiles', 'tile_func_v2');


//iframe support

function fb_change_mce_options( $initArray ) {
    // Comma separated string od extendes tags
    // Command separated string of extended elements
    $ext = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src]';

    if ( isset( $initArray['extended_valid_elements'] ) ) {
        $initArray['extended_valid_elements'] .= ',' . $ext;
    } else {
        $initArray['extended_valid_elements'] = $ext;
    }
    // maybe; set tiny paramter verify_html
    //$initArray['verify_html'] = false;

    return $initArray;
}
add_filter( 'tiny_mce_before_init', 'fb_change_mce_options' );
