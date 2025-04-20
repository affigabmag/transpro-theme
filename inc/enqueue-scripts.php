<?php
/**
 * Enqueue scripts and styles
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Enqueue scripts and styles
 */
function transpro_enqueue_scripts() {
    // Enqueue Tailwind CSS from CDN
    wp_enqueue_style('tailwindcss', 'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css', array(), '2.2.19');
    
    // Enqueue main stylesheet
    wp_enqueue_style('transpro-style', get_stylesheet_uri(), array(), TRANSPRO_VERSION);
    
    // Enqueue custom CSS
    wp_enqueue_style('transpro-main', TRANSPRO_URI . '/assets/css/main.css', array(), TRANSPRO_VERSION);
    
    // Enqueue main JavaScript
    wp_enqueue_script('transpro-main', TRANSPRO_URI . '/assets/js/main.js', array('jquery'), TRANSPRO_VERSION, true);
    
    // Localize the script with new data
    $script_data = array(
        'is_logged_in' => is_user_logged_in(),
        'home_url' => home_url(),
        'ajax_url' => admin_url('admin-ajax.php'),
        'is_rtl' => transpro_is_rtl(),
    );
    wp_localize_script('transpro-main', 'transproData', $script_data);
}
add_action('wp_enqueue_scripts', 'transpro_enqueue_scripts');

/**
 * Enqueue admin scripts and styles
 */
function transpro_admin_enqueue_scripts($hook) {
    // Only load on TransPro settings page
    if ('appearance_page_transpro-settings' !== $hook) {
        return;
    }
    
    wp_enqueue_style('transpro-admin', TRANSPRO_URI . '/assets/css/admin.css', array(), TRANSPRO_VERSION);
    wp_enqueue_script('transpro-admin', TRANSPRO_URI . '/assets/js/admin.js', array('jquery'), TRANSPRO_VERSION, true);
}
add_action('admin_enqueue_scripts', 'transpro_admin_enqueue_scripts');