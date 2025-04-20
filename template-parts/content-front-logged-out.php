<?php
/**
 * Template part for displaying front page content for logged-out users
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Get content for logged-out users
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

if ($logged_out_page) {
    $content = apply_filters('the_content', $logged_out_page->post_content);
    ?>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4"><?php echo esc_html($logged_out_page->post_title); ?></h1>
        <div class="entry-content">
            <?php echo $content; ?>
        </div>
        <div class="login-button mt-6">
            <a href="<?php echo esc_url(wp_login_url()); ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                <?php esc_html_e('Log In', 'transpro'); ?>
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
            <p><?php esc_html_e('Front page - for not logged in users.', 'transpro'); ?></p>
        </div>
        <div class="login-button mt-6">
            <a href="<?php echo esc_url(wp_login_url()); ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                <?php esc_html_e('Log In', 'transpro'); ?>
            </a>
        </div>
    </div>
    <?php
}