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
