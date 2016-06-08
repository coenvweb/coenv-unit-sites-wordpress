<?php

add_action('wp_ajax_getUserTimeline', 'getUserTimeline');
add_action('wp_ajax_nopriv_getUserTimeline', 'getUserTimeline');

require "twitteroauth/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

function getUserTimeline() {

    require_once "twitterSecret.php";


    if( false === ( $tweetArray = get_transient('twitter_feed') ) ) {
        $connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $ACCESS_TOKEN, $ACCESS_TOKEN_SECRET);
        $tweets = $connection->get($_REQUEST['api'], ["screen_name" => $_REQUEST['screen_name'], "count" => $_REQUEST['count'], "exclude_replies" => true, "include_rts" => true]);
        $tweetArray = json_encode($tweets);
        set_transient('twitter_feed', $tweetArray, 900);
    } else {
        $tweetArray = get_transient('twitter_feed');
    }

    echo $tweetArray;
    die();
}
?>
