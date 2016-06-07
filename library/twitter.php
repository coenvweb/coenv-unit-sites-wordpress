<?php

add_action('wp_ajax_getUserTimeline', 'getUserTimeline');
add_action('wp_ajax_nopriv_getUserTimeline', 'getUserTimeline');

require "twitteroauth/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

function getUserTimeline() {

    require_once "twitterSecret.php";


    $connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $ACCESS_TOKEN, $ACCESS_TOKEN_SECRET);

    $tweets = $connection->get($_REQUEST['api'], ["screen_name" => $_REQUEST['screen_name'], "count" => $_REQUEST['count'], "exclude_replies" => true, "include_rts" => true]);

    $tweetArray = json_encode($tweets);

    echo $tweetArray;
    die();
}
?>
