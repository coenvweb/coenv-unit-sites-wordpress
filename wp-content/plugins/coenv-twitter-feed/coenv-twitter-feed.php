<?php
/*
* Plugin Name: Coenv Twitter
* Plugin URI: http://www.github.com/coenvweb
* Description: Enable interfacing with twitter API and provides a simple sidebar widget for displaying timeline tweets
* Version: 1.0
* Author: Cole Bessee
* Author URI: http://www.github.com/cbessee
* License: GPL2

Copyright 2016 Cole Bessee - UW College of the Environment

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License,
version 2, as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/

add_action('wp_enqueue_scripts', 'twitter_scripts');

function twitter_scripts() {
    wp_register_script( 'twitter-feed', plugins_url('coenv-twitter-feed/twitter-feed.js', dirname(__FILE__) ), array('jquery'), '1.0.0', true );

    wp_enqueue_script('twitter-feed');
}

add_action('wp_ajax_getUserTimeline', 'getUserTimeline');
add_action('wp_ajax_nopriv_getUserTimeline', 'getUserTimeline');

require "twitteroauth/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

function getUserTimeline() {

    if( false === ( $tweetArray = get_transient('twitter_feed') ) ) {
        $connection = new TwitterOAuth(get_option('consumer_key'), get_option('consumer_secret'), get_option('access_token'), get_option('access_token_secret'));
        $tweets = $connection->get($_REQUEST['api'], ["screen_name" => $_REQUEST['screen_name'], "count" => 10, "exclude_replies" => true, "include_rts" => true]);
        $tweetArray = json_encode($tweets);
        set_transient('twitter_feed', $tweetArray, 900);
    } else {
        $tweetArray = get_transient('twitter_feed');
    }

    echo $tweetArray;
    die();
}

add_action('admin_menu', 'add_twitter_options_page');

function add_twitter_options_page() {
    add_options_page('Twitter Options', 'Twitter Options', 'manage_options', 'twitter-options', 'twitter_options_page');

    add_action('admin_init', 'register_twitter_settings');
}

function register_twitter_settings() {
    register_setting('twitter-options', 'consumer_key');
    register_setting('twitter-options', 'consumer_secret');
    register_setting('twitter-options', 'access_token');
    register_setting('twitter-options', 'access_token_secret');
}

function twitter_options_page() {
?>
    <div class="wrap">
        <h2>Twitter Options</h2>
            <p> Set your keys and secrets for twitter api access here. Set up a new application and generate keys with <a href="http://apps.twitter.com/">Twitter Application Management</a></p>

        <form method="post" action="options.php">
            <?php settings_fields( 'twitter-options' ); ?>
            <table class="form-table">
                <tr valign="top">
                <th scope="row">Consumer Key</th>
                <td><input type="text" name="consumer_key" value="<?php echo esc_attr( get_option('consumer_key') ); ?>" /></td>
                </tr>

                <tr valign="top">
                <th scope="row">Consumer Secret</th>
                <td><input type="text" name="consumer_secret" value="<?php echo esc_attr( get_option('consumer_secret') ); ?>" /></td>
                </tr>

                <tr valign="top">
                <th scope="row">Access Token</th>
                <td><input type="text" name="access_token" value="<?php echo esc_attr( get_option('access_token') ); ?>" /></td>
                </tr>

                <tr valign="top">
                <th scope="row">Access Token Secret</th>
                <td><input type="text" name="access_token_secret" value="<?php echo esc_attr( get_option('access_token_secret') ); ?>" /></td>
                </tr>
            </table>

            <?php submit_button(); ?>

        </form>
    </div>
<?php
}

class Coenv_Twitter extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_ops = array( 
            'description' => 'Display some number of tweets from a user timeline',
        );
        parent::__construct( 'coenv_twitter', 'Twitter Widget', $widget_ops );
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        ?>
            <div id="twitter">
                <h2 class="at_title"><span class="twitter-logo"><i class="fa fa-twitter"></i></span>@<?=$instance['user']?></h2>
                <script>
                    window.onload = function() {
                        // start jqtweet!
                        if(jQuery('#twitter').length) {
                            JQTWEET.loadTweets('<?=$instance['user']?>', <?=$instance['count']?>);
                        }
                    }
                </script>
            </div>
            <a class="read_tweets button" href="https://twitter.com/<?=$instance['user']?>">Read our Tweets</a>

        <?php
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {
        ?>
        <p>
            <label for="<?php echo $this->get_field_name( 'user' ); ?>"><?php _e( 'Twitter Handle:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'user' ); ?>" name="<?php echo $this->get_field_name( 'user' ); ?>" type="text" value="<?= (isset($instance['user']) ? $instance['user'] : '') ?>" />
        </p>
        <p> 
            <label for="<?php echo $this->get_field_name( 'count' ); ?>"><?php _e( 'Number of Tweets:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?= (isset($instance['count']) ? $instance['count'] : '') ?>" />
        </p>
        <?php
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update( $new_instance, $old_instance ) {
        return $new_instance;
    }
}


function register_twitter_widget() {
    register_widget('coenv_twitter');
}

add_action('widgets_init', 'register_twitter_widget');
?>
