<?php
/*
Plugin Name: Mabout Me
Plugin URI: http://www.machiel.me
Description: A simple About Me widget, WordPress v3.5 and up
Version: 1.0
Author: Machiel Molenaar
Author URI: http://www.machiel.me
License: GPLv2 or later
*/

class AboutMe extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'mm_about_me', // Base ID
            'Mabout Me', // Name
            array( 'description' => 'A simple about me widget', ) // Args
        );
    }

    public function form($instance) {

        wp_enqueue_media();

        echo '<p>';
        echo '<label for="' . $this->get_field_id('title') . '">Title:</label>';
        echo '<input type="text" class="widefat" id="' . $this->get_field_id('title') . '"';
        echo ' value="' . $instance['title'] . '" name="' . $this->get_field_name('title') . '"/>';
        echo '</p>';

        echo '<p>';
        echo '<label for="' . $this->get_field_id('image') . '">Image: <span class="select-about-image" id="' . $this->get_field_id('select-image') .'" style="cursor: pointer;">Select an image</span></label>';
        echo '<input type="hidden" class="widefat" id="' . $this->get_field_id('image') . '"';
        echo ' value="' . $instance['image'] . '" name="' . $this->get_field_name('image') . '"/>';
        echo '</p>';

        $img = '';
        if(!empty($instance['image'])) {
            $src = wp_get_attachment_image_src($instance['image'], array(226, 400));
            $img = '<img src="' . $src[0] . '" style="max-width: 226px;" />';
        }
        echo '<div id="' . $this->get_field_id('display-image') . '">' . $img .'</div>';

        echo '<p>';
        echo '<label for="' . $this->get_field_id('about') . '">About me:</label>';
        echo '<textarea class="widefat" id="' . $this->get_field_id('about') . '"';
        echo ' name="' . $this->get_field_name('about') . '">' . $instance['about'] . '</textarea>';
        echo '</p>';
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['about'] = $new_instance['about'];
        $instance['image'] = $new_instance['image'];

        return $instance;
    }

    public function widget($args, $instance) {

        echo $args['before_widget'];
        echo $args['before_title'] . $instance['title'] . $args['after_title'];
        echo wp_get_attachment_image($instance['image'], array(250, 500));
        echo '<p>' . $instance['about'] . '</p>';
        echo $args['after_widget'];

    }
}

function init_widgets() {
    register_widget('AboutMe');
}

function add_media_scripts() {
    wp_enqueue_script( 'about-me-media-uploader', plugins_url('/media-uploader.js', __FILE__) );
}

add_action('admin_enqueue_scripts', 'add_media_scripts');
add_action('widgets_init', 'init_widgets');