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

add_action('admin_menu', 'dropbox_music_admin_menu');
add_action('admin_init', 'dropbox_music_admin_init');
?>