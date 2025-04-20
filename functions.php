<?php
/**
 * TransPro functions and definitions
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define theme constants
define('TRANSPRO_VERSION', '1.0.0');
define('TRANSPRO_DIR', get_template_directory());
define('TRANSPRO_URI', get_template_directory_uri());

// Include required files
require_once TRANSPRO_DIR . '/inc/theme-setup.php';
require_once TRANSPRO_DIR . '/inc/customizer.php';
require_once TRANSPRO_DIR . '/inc/enqueue-scripts.php';

/**
 * Theme Setup
 */
function transpro_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'transpro'),
        'transpro_sidebar' => esc_html__('TransPro Sidebar Menu', 'transpro'),
    ));
}
add_action('after_setup_theme', 'transpro_setup');

/**
 * Create default pages upon theme activation
 */
function transpro_create_default_pages() {
    // Check if the front page for logged-out users exists
    $logged_out_page_query = new WP_Query(array(
        'post_type' => 'page',
        'title' => 'Front Page - Not Logged In',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'no_found_rows' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
    ));
    
    $logged_out_page = (!empty($logged_out_page_query->posts)) ? $logged_out_page_query->posts[0] : null;
    
    if (!$logged_out_page) {
        // Create front page for logged-out users
        $logged_out_page_id = wp_insert_post(array(
            'post_title'    => 'Front Page - Not Logged In',
            'post_content'  => 'Front page - for not logged in users',
            'post_status'   => 'publish',
            'post_type'     => 'page',
        ));
    }

    // Check if the front page for logged-in users exists
    $logged_in_page_query = new WP_Query(array(
        'post_type' => 'page',
        'title' => 'Front Page - Logged In',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'no_found_rows' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
    ));
    
    $logged_in_page = (!empty($logged_in_page_query->posts)) ? $logged_in_page_query->posts[0] : null;
    
    if (!$logged_in_page) {
        // Create front page for logged-in users
        $logged_in_page_id = wp_insert_post(array(
            'post_title'    => 'Front Page - Logged In',
            'post_content'  => 'Front page - for logged in users. This is the default content that can be modified later.',
            'post_status'   => 'publish',
            'post_type'     => 'page',
        ));
    }

    // Set front page as the static homepage
    if (isset($logged_out_page_id)) {
        update_option('page_on_front', $logged_out_page_id);
        update_option('show_on_front', 'page');
    } elseif (isset($logged_out_page) && $logged_out_page instanceof WP_Post) {
        update_option('page_on_front', $logged_out_page->ID);
        update_option('show_on_front', 'page');
    }
}
add_action('after_switch_theme', 'transpro_create_default_pages');

/**
 * Create the default transpro menu and menu items
 */
function transpro_create_default_menu() {
    // Check if menu exists
    $menu_exists = wp_get_nav_menu_object('TransPro');
    
    // If it doesn't exist, create it
    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu('TransPro');
        
        // Get the logged-in front page
        $logged_in_page_query = new WP_Query(array(
            'post_type' => 'page',
            'title' => 'Front Page - Logged In',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'no_found_rows' => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        ));
        
        $logged_in_page = (!empty($logged_in_page_query->posts)) ? $logged_in_page_query->posts[0] : null;
        
        if ($logged_in_page) {
            // Add the default menu item
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title' => 'Main',
                'menu-item-url' => get_permalink($logged_in_page->ID),
                'menu-item-status' => 'publish',
                'menu-item-type' => 'post_type',
                'menu-item-object' => 'page',
                'menu-item-object-id' => $logged_in_page->ID,
            ));
            
            // Assign the menu to the sidebar location
            $locations = get_theme_mod('nav_menu_locations');
            $locations['transpro_sidebar'] = $menu_id;
            set_theme_mod('nav_menu_locations', $locations);
        }
    }
}
add_action('after_switch_theme', 'transpro_create_default_menu');

/**
 * Conditional content based on login status
 */
function transpro_get_conditional_content() {
    if (is_front_page()) {
        if (is_user_logged_in()) {
            // Get logged-in front page content
            $logged_in_page = get_page_by_title('Front Page - Logged In');
            if ($logged_in_page) {
                return $logged_in_page->post_content;
            }
        } else {
            // Get logged-out front page content
            $logged_out_page = get_page_by_title('Front Page - Not Logged In');
            if ($logged_out_page) {
                return $logged_out_page->post_content;
            }
        }
    }
    
    // Default return current post content
    global $post;
    return $post->post_content;
}

/**
 * Check if sidebar should be displayed
 */
function transpro_show_sidebar() {
    return is_user_logged_in();
}

/**
 * Get RTL status from theme options
 */
function transpro_is_rtl() {
    $direction = get_theme_mod('transpro_text_direction', 'ltr');
    return ($direction === 'rtl');
}

/**
 * Add body classes
 */
function transpro_body_classes($classes) {
    // Add class based on RTL setting
    if (transpro_is_rtl()) {
        $classes[] = 'rtl';
    } else {
        $classes[] = 'ltr';
    }
    
    // Add class for sidebar
    if (transpro_show_sidebar()) {
        $classes[] = 'has-sidebar';
    }
    
    return $classes;
}
add_filter('body_class', 'transpro_body_classes');