<?php
/*
* Plugin Name: Coenv Static Content Widget
* Plugin URI: http://www.github.com/coenvweb
* Description: A widget that allows you to define a title, content, link, and media.
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

class coenv_base_content extends WP_Widget {

    function __construct() {
        parent::__construct(
            'coenv_base_content', // Base ID
            __('Content Widget', 'text_domain'), // Name
            array( 
                'description' => __( 'Updateable, static content widets. Including title, content, image and link.', 'text_domain' ),
                'classname' => 'coenv_static_widget',
            ) // Args
        );
        add_action('admin_enqueue_scripts', array($this, 'coenv_widget_scripts'));
    }

    public function validateLink($link) {
        return filter_var($link, FILTER_VALIDATE_URL);
    }

    /*
    *   js and css assets
    */
    public function coenv_widget_scripts() {
        wp_enqueue_media();
        wp_enqueue_script('media-upload');
        wp_enqueue_script('coenv_static_widget', plugin_dir_url(__FILE__) . 'upload-media.js', array('jquery'));
    }

    /*
        Determine if a link is internal or external and return the correct target
    */
    public function getLinkTarget($url, $homeurl) {
        $link_url = parse_url($url);
        $home_url = parse_url($homeurl);
        if($link_url['host'] == $home_url['host']) {
            $target = '_self';
        } else {
            $target = '_target';
        }
        return $target;
    }

     /** 
      * Front-end display of widget.
      *
      * @see WP_Widget::widget()
      *
      * @param array $args     Widget arguments.
      * @param array $instance Saved values from database.
      */
    public function widget( $args, $instance ) { 

        echo $args['before_widget'];

        echo "<div class='solid-widget'>";
            echo "<article class='widget widget_custom_post_widget'>";
    
                if(!empty($instance['link'])) {
                    $target = $this->getLinkTarget($instance['link'], home_url());
                        echo "<a target='".$target."' href='".$instance['link']."'>";
                }

                if(!empty($instance['image'])) {
                    echo "<div class='widget_img'>";
                    echo "<img src='".$instance['image']."' alt='".get_post_meta($instance['imageID'], '_wp_attachment_image_alt', true)."' />";
                    echo "</div>";
                }

                echo "<div class='widget_area'>";

                if (!empty($instance['title'])) { 
                    echo $args['before_title'];

                    if(!empty($instance['link'])) {
                        echo apply_filters('widget_title', $instance['title']);
                    } else {
                        echo apply_filters('widget_title', $instance['title']);
                    }

                    echo $args['after_title'];
                }

                if(!empty($instance['link'])) {
                    echo '</a>';
                }

                if(!empty($instance['content'])) {
                    echo apply_filters('the_content', $instance['content']);
                }

               echo "<ul class='widget_links'>";
               if(!empty($instance['link']) && !empty($instance['linktext'])) {
                    $target = $this->getLinkTarget($instance['link'], home_url());
                    echo "<li><a class='button' target='".$target."' href='".$instance['link']."'>".$instance['linktext']."</a></li>";
                }
                if(!empty($instance['link2']) && !empty($instance['linktext2'])) {
                    $target = $this->getLinkTarget($instance['link2'], home_url());
                    echo "<li><a class='button' target='".$target."' href='".$instance['link2']."'>".$instance['linktext2']."</a></li>";
                }
                echo "</ul>";

                echo "</div>";
            echo "</article>";
        echo "</div>";

        echo $args['after_widget'];
    }


 /*
  * @param array $instance Previously saved values from database.
 */
    public function form( $instance ) {

        if ( !empty($instance['error']) ) {
            echo '<div class="notice notice-error is-dismissible">';
            echo '<strong>ERROR</strong>: ';
            echo $instance['error'] . '<br/>';
            echo '</div>';
        }

        ?>
        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?= (isset($instance['title']) ? $instance['title'] : '') ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_name( 'content' ); ?>"><?php _e( 'Content:' ); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>" type="textarea"><?= (isset($instance['content']) ? $instance['content'] : '') ?></textarea>
        </p>
       <p>
            <label for="<?php echo $this->get_field_name( 'link' ); ?>"><?php _e( 'Primary Link URL:' ); ?></label>
            <input class="widefat" placeholder="http(s)://" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?= (isset($instance['link']) ? esc_attr( $instance['link']) : ''); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_name( 'linktext' ); ?>"><?php _e( 'Primary Link Button Text:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'linktext' ); ?>" name="<?php echo $this->get_field_name( 'linktext' ); ?>" type="text" value="<?= (isset($instance['linktext']) ? $instance['linktext'] : ''); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_name( 'link2' ); ?>"><?php _e( 'Secondary Link URL:' ); ?></label>
            <input class="widefat" placeholder="http(s)://" id="<?php echo $this->get_field_id( 'link2' ); ?>" name="<?php echo $this->get_field_name( 'link2' ); ?>" type="text" value="<?= (isset($instance['link2']) ? esc_attr( $instance['link2']) : '' ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_name( 'linktext2' ); ?>"><?php _e( 'Secondary Link Button Text:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'linktext2' ); ?>" name="<?php echo $this->get_field_name( 'linktext2' ); ?>" type="text" value="<?= (isset($instance['linktext2']) ? $instance['linktext2'] : ''); ?>" />
        </p> 

        <p>
            <label for="<?php echo $this->get_field_name( 'image' ); ?>"><?php _e( 'Image:' ); ?></label>
            <br />
            <img id="coenv_media_image<?php echo $this->number; ?>" style="width:100%" <?=(empty($instance['image']) ? 'hidden' : '')?> src="<?= (isset($instance['image']) ? $instance['image'] : '') ?>" />
            <input name="<?php echo $this->get_field_name( 'image' ); ?>" id="coenv_media_url<?php echo $this->number; ?>" readonly type="text" size="36"  value="<?= (isset($instance['image']) ? esc_url( $instance['image'] ) : ''); ?>" />
            <input name="<?php echo $this->get_field_name( 'imageID' ); ?>" id="coenv_media_id<?php echo $this->number; ?>" hidden type="text" size="36"  value="<?= (isset($instance['imageID']) ? $instance['imageID'] : ''); ?>" />
            <input class="custom_media_upload button button-primary" id="<?php echo $this->number; ?>" type="button" value="Upload/Select Image" />
            <input class="remove_custom_media button" type="button" id="<?php echo $this->number; ?>" value="Remove Image" />
        </p>
    <?php
    }

 /**
  * Sanitize widget form values as they are saved.
  *
  * @see WP_Widget::update()
  *
  * @param array $new_instance Values just sent to be saved.
  * @param array $old_instance Previously saved values from database.
  *
  * @return array Updated safe values to be saved.
  */
    public function update( $new_instance, $old_instance ) {

        $old_instance['error'] = '';

        if(!$new_instance['title']) {
            $old_instance['error'] = "This widget must have a title.";
        }

        if($new_instance['link'] != '') {
            if(!$this->validateLink($new_instance['link'])) {
                $old_instance['error'] = "Link 1 URL was invalid. HINT: You must include http://";
            }
        }

        if($new_instance['link2'] != ''){
            if(!$this->validateLink($new_instance['link2'])) {
                $old_instance['error'] = "Link 2 URL was invalid. HINT: You must include http://";
            }
        }

        if(!$old_instance['error']) {
            return $new_instance;
        } else {
            return $old_instance;
        }
    }
}
function register_coenv_base_content() {
    register_widget( 'coenv_base_content' );
}
add_action( 'widgets_init', 'register_coenv_base_content' );
?>
