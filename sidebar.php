<?php
/**
 * The sidebar containing the main widget area
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// If not on the front page or user is not logged in, show regular sidebar
if (!is_front_page() || !is_user_logged_in()) {
    if (is_active_sidebar('sidebar-1')) : ?>
        <aside id="secondary" class="widget-area">
            <?php dynamic_sidebar('sidebar-1'); ?>
        </aside>
    <?php endif;
    return;
}

// This file is not used for the TransPro sidebar
// The TransPro sidebar is included in header.php when user is logged in
?>