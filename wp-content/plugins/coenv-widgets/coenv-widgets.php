<?php
/*
* Plugin Name: Coenv Static Content Widget
* Plugin URI: http://www.github.com/coenvweb
* Description: A widget that allows you to define a title, content, link, and media.
* Version: 1.0
* Author: Cole Bessee
* Author URI: http://www.github.com/cbessee
* License: GPL2

Copyright 2012 Cole Bessee

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
            __('Static Content (COENV)', 'text_domain'), // Name
            array( 
                'description' => __( 'Updateable, static content widets. Including title, content, image and link.', 'text_domain' ),
                'classname' => 'coenv_static_widget',
            ) // Args
        );
        add_action('admin_enqueue_scripts', array($this, 'coenv_widget_scripts'));
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
            echo "<div class='small-12 columns'>";
                echo "<article class='row widget widget_custom_post_widget'>";

                    if(!empty($instance['image'])) {
                        echo "<div class='widget_img'>";
                        echo "<img src='".$instance['image']."' />";
                        echo "</div>";
                    }

                    echo "<div class='widget_content'>";

                        if (!empty($instance['title'])) { 
                            echo $args['before_title'];

                            if(!empty($instance['link'])) {
                                echo apply_filters('widget_title', $instance['title']);
                            } else {
                                echo apply_filters('widget_title', $instance['title']);
                            }

                            echo $args['after_title'];
                        }

                        if(!empty($instance['content'])) {
                            echo "<p>".$instance['content']."</p>";
                        }

                        if(!empty($instance['link']) && !empty($instance['linktext'])) {
                            $target = $this->getLinkTarget($instance['link'], home_url());
                            echo "<ul class='widget_links'>";
                                echo "<li><a class='button' target='".$target."' href='".$instance['link']."'>".$instance['linktext']."</a></li>";
                            echo "</ul>";
                        }

                    echo "</div>";
                echo "</article>";
            echo "</div>";
        echo "</div>";

        echo $args['after_widget'];
    }


 /*
  * @param array $instance Previously saved values from database.
 */
    public function form( $instance ) {

        global $widget_error;
        if ( is_wp_error( $widget_error) ) {
            foreach ( $widget_error->get_error_messages() as $error ) {
                echo '<div class="notice notice-error is-dismissible">';
                echo '<strong>ERROR</strong>: ';
                echo $error . '<br/>';
                echo '</div>';
            }
        }
        $widget_error=null;

        $title='';
        if(isset($instance['title'])) {
            $title = $instance['title'];
        }

        $image = '';
        if(isset($instance['image'])) {
            $image = $instance['image'];
        }

        $imageID = '';
        if(isset($instance['imageID'])) {
            $imageID = $instance['imageID'];
        }

        $content = '';
        if(isset($instance['content'])) {
            $content = $instance['content'];
        }

        $link = '';
        if(isset($instance['link'])) {
            $link = $instance['link'];
        }

        $linktext = '';
        if(isset($instance['linktext'])) {
            $linktext = $instance['linktext'];
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_name( 'content' ); ?>"><?php _e( 'Content:' ); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>" type="textarea"><?php echo esc_attr( $content ); ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_name( 'link' ); ?>"><?php _e( 'Link URL:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_name( 'linktext' ); ?>"><?php _e( 'Link Text:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'linktext' ); ?>" name="<?php echo $this->get_field_name( 'linktext' ); ?>" type="text" value="<?php echo $linktext; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_name( 'image' ); ?>"><?php _e( 'Image:' ); ?></label>
            <img id="coenv_media_image<?php echo $this->number; ?>" style="width:100%" <?=(empty($image) ? 'hidden' : '')?> src="<?php echo $image; ?>" />
            <input name="<?php echo $this->get_field_name( 'image' ); ?>" id="coenv_media_url<?php echo $this->number; ?>" readonly type="text" size="36"  value="<?php echo esc_url( $image ); ?>" />
            <input name="<?php echo $this->get_field_name( 'imageID' ); ?>" id="coenv_media_id<?php echo $this->number; ?>" hidden type="text" size="36"  value="<?php echo $imageid; ?>" />
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
        global $widget_error;


        $instance = array();
        if(!empty($new_instance['title'])) {
            $instance['title'] = strip_tags( $new_instance['title'] );
        } else {
            $widget_error = new WP_Error;
            $widget_error->add('invalid_title', 'You must include a title');
        }

        $instance['content'] = $new_instance['content'];

        if(!filter_var($new_instance['link'], FILTER_VALIDATE_URL) === false) {
            $instance['link'] = $new_instance['link'];
        } else {
            $widget_error = new WP_Error;
            $widget_error->add('invalid_link', 'Link must be a valid url');
        }

        $instance['linktext'] = $new_instance['linktext'];

        $instance['image'] = $new_instance['image'];
        $instance['imageID'] = $new_instance['imageID'];

        if ( is_wp_error( $widget_error ) ) {
            return false;
        } else {
            return $instance;
        }
    }

}
function register_coenv_base_content() {
    register_widget( 'coenv_base_content' );
}
add_action( 'widgets_init', 'register_coenv_base_content' );
?>
