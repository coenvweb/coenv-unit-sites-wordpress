<?php

function trumba_func( $atts ) {
    
    $trumba = shortcode_atts( array(
        'webname' => 'coenveventscalendar',
        'spudtype' => 'main',
        'url' => null,
        'teaserbase' => null,
        'varSpud' => null
    ), $atts );
    
    if (isset($trumba['varSpud'])) {
        $varSpud = 'var spud = ' . $trumba['varSpud'];
    } else {
        $varSpud = null;
    };

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
    teaserBase: "' . $trumba['teaserbase'] . '"
    });' . $varSpud . '
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
        'site_root' => '/sales',
        'name' => 'My Sales Scorecard',
        'tabs' => 'yes',
        'toolbar' => 'yes',
    ), $atts );

    return '
    <script type="text/javascript" src="http://myserver/javascripts/api/viz_v1.js"></script> 
    <div class="tableauPlaceholder" style="width:800; height:600;"> 
    <object class="tableauViz" width="800" height="600" style="display:none;">
   <param name="host_url" value="' . $tableau['host_url'] . '" /> 
   <param name="site_root" value="' . $tableau['site_root'] . '" /> 
   <param name="name" value="' . $tableau['name'] . '" /> 
   <param name="tabs" value="' . $tableau['tabs'] . '" /> 
   <param name="toolbar" value="' . $tableau['toolbar'] . '" /></object></div>'; 
}

add_shortcode( 'tableau', 'tableau_func' );