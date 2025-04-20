<?php
/**
 * The template for displaying 404 pages (not found)
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header();
?>

<div class="container mx-auto px-4 py-8">
    <div class="error-404 not-found text-center py-12">
        <header class="page-header">
            <h1 class="page-title text-4xl font-bold mb-6"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'transpro'); ?></h1>
        </header>

        <div class="page-content">
            <p class="mb-6"><?php esc_html_e('It looks like nothing was found at this location. Maybe try a search?', 'transpro'); ?></p>
            
            <div class="search-form max-w-md mx-auto mb-8">
                <?php get_search_form(); ?>
            </div>

            <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                <?php esc_html_e('Back to Homepage', 'transpro'); ?>
            </a>
        </div>
    </div>
</div>

<?php
get_footer();