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
    <script type="text/javascript" src="https://public.tableau.com/javascripts/api/viz_v1.js"></script> 
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

function gCalendar_func($atts) {
    $gCalendar = shortcode_atts( array(
        'calendar_url' => 'https://calendar.google.com/calendar/embed?height=600&wkst=1&bgcolor=%23FFFFFF&src=uw.edu_ntdmhh3bgskqsrkmg36c2ar72c%40group.calendar.google.com&color=%23865A5A&src=qrc%40uw.edu&color=%235229A3&ctz=America%2FLos_Angeles',
    ), $atts );
    return '<div class="responsive-iframe-container">
        <iframe src="'.$gCalendar['calendar_url'].'" style="border-width:0" width="100%" height="600" frameborder="0" scrolling="no"></iframe>
    </div>';

}
add_shortcode('gCalendar', 'gCalendar_func');

function getQRFeed() {
    $feed_url = 'https://www.cambridge.org/core/journals/quaternary-research/latest-issue/feed';
    $journal_json = get_transient('journal_json');
    if($journal_json == false || $journal_json == '') {
        $ctx = stream_context_create(array('http'=>
            array(
                'timeout' => 3,  //1200 Seconds is 20 Minutes
            ),
            'ssl' => array('verify_peer' => false, 'verify_peer_name' => false),
        ));
        $journal_json = file_get_contents( $feed_url, false, $ctx);

        //store journal info for later
        set_transient( 'journal_json', $journal_json, 60 * MINUTE_IN_SECONDS );

        $journal = json_decode($journal_json);

        $firstArticle = $journal->feeds[0];

        update_field('journal_volume', $firstArticle->volume, 'options');
        update_field('journal_issue', $firstArticle->issue, 'options');
        update_field('journal_date', $firstArticle->pubDate[2]->month . '/' . $firstArticle->pubDate[2]->day . '/' . $firstArticle->pubDate[2]->year, 'options');
        update_field('latest_issue_link', $firstArticle->issueUrl, 'options');

        return $journal;

    } else {
        return json_decode($journal_json);
    }   
}

function journal_func( $atts ) {
	$journal = getQRFeed();

	$journal_date = get_field('journal_date', 'option');
	$journal_volume = get_field('journal_volume', 'option');
	$journal_issue = get_field('journal_issue', 'option');
	$journal_cover = get_field('journal_cover', 'option');
	$journal_link = get_field('latest_issue_link', 'option');
    
	ob_start();
	?>
	<div class="shortcode-journal journal-info">
        <div class="journal-head row">
            <div class="small-12 medium-8 columns">
		        <h2>Journal: Current Issue</h2>
            </div>
            <div class="small-12 medium-4 columns">
                <a href="<?php echo $journal_link; ?>">View the latest issue &rarr;</a>
            </div>
        </div>
		<ul class="journal-meta">
			<li class="journal-date"><span class="meta-label">Published: </span><?php echo $journal_date; ?></li>
			<li class="journal-volume"><span class="meta-label">Volume: </span><?php echo $journal_volume; ?></li>
			<li class="journal-issue"><span class="meta-label">Issue: </span><?php echo $journal_issue; ?></li>
		</ul>
		<?php if(count($journal->feeds) >= 3) {
                $dots = count($journal->feeds) - 3;
                $dots = ($dots > 5 ? 5 : $dots);
        ?>

            <div class="journal-articles">
                <?php
                    if(count($journal->feeds) >= 3) {
                        array_pop($journal->feeds);
                        array_pop($journal->feeds);
                        shuffle($journal->feeds);
                        echo '<div class="article-list">';
                            $count = 0;
                            foreach($journal->feeds as $feed) {
                                if($count < 5) {
                                    echo '<div><a href="'.$feed->articleUrl.'">'.$feed->title.'</a></div>';
                                }
                                $count++;
                            }
                        echo '</div>';
                    }
                ?>
                <div class="slider-controller">
                    <span class="story-counter"><span class="current">1</span> of <?php echo $dots; ?> Articles</span>
                </div>
            </div>
        <?php } else {
            ?>
            <p>The current issue of the QRC Journal has no articles available for preview</p>
            <?php
        }?>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'qrc_journal', 'journal_func' );
