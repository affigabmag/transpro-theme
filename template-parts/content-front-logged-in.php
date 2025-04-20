<?php
/**
 * Template part for displaying front page content for logged-in users
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Get content for logged-in users
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
    $content = apply_filters('the_content', $logged_in_page->post_content);
    ?>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4"><?php echo esc_html($logged_in_page->post_title); ?></h1>
        <div class="entry-content">
            <?php echo $content; ?>
        </div>
        <div class="user-actions mt-6">
            <?php
            $current_user = wp_get_current_user();
            ?>
            <p class="mb-4">
                <?php printf(esc_html__('Welcome back, %s!', 'transpro'), $current_user->display_name); ?>
            </p>
            <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                <?php esc_html_e('Log Out', 'transpro'); ?>
            </a>
        </div>
    </div>
    <?php
} else {
    // Fallback if page doesn't exist
    ?>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4"><?php esc_html_e('Welcome', 'transpro'); ?></h1>
        <div class="entry-content">
            <p><?php esc_html_e('Front page - for logged in users.', 'transpro'); ?></p>
        </div>
        <div class="user-actions mt-6">
            <?php
            $current_user = wp_get_current_user();
            ?>
            <p class="mb-4">
                <?php printf(esc_html__('Welcome back, %s!', 'transpro'), $current_user->display_name); ?>
            </p>
            <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                <?php esc_html_e('Log Out', 'transpro'); ?>
            </a>
        </div>
    </div>
    <?php
}