<?php
/*
Plugin Name: wp-dropbox-music
Plugin URI: http://github.com/RussTheAerialist/wp-dropbox-music
Description: Allows someone to upload music to a dropbox via a web form
Version: 0.1
Author: Russell Hay
Author URI: http://github.com/RussTheAerialist/
License: BSD
*/

require_once('dropbox_admin.php');
require_once('dropbox_shortcode.php');

add_action('admin_init', 'dropbox_music_admin_init');
add_action('init', 'dropbox_init');

function dropbox_init() {
    add_shortcode('dropbox-music', 'dropbox_music_shortcode');
    add_action('admin_menu', 'dropbox_music_admin_menu');
    
    wp_register_style('uploadify_css', plugins_url('wp-dropbox-music/css/uploadify.css'));
    wp_enqueue_style('uploadify_css');

}
?>