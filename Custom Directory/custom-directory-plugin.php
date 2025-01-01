<?php
/*
Plugin Name: Custom Directory Plugin
Description: Manage and display local business listings with advanced features.
Version: 2.2
Author: Jaminou
*/

require_once plugin_dir_path(__FILE__) . 'includes/admin-page.php';
require_once plugin_dir_path(__FILE__) . 'includes/import-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/display-directory.php';
require_once plugin_dir_path(__FILE__) . 'includes/custom-fields.php';
require_once plugin_dir_path(__FILE__) . 'includes/custom-post-type.php';

// Enqueue necessary scripts and styles
function custom_directory_enqueue_scripts() {
    wp_enqueue_style('custom-directory-css', plugin_dir_url(__FILE__) . 'assets/custom-directory.css');
    wp_enqueue_script('custom-directory-js', plugin_dir_url(__FILE__) . 'assets/custom-directory.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'custom_directory_enqueue_scripts');
?>
