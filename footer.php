<?php
/**
 * The template for displaying the footer
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
        </main><!-- #primary -->
    </div><!-- #content -->

    <footer id="colophon" class="site-footer bg-gray-100 py-4 mt-8">
        <div class="container mx-auto px-4">
            <div class="site-info text-center">
                <?php
                /* translators: %s: Theme name. */
                printf(esc_html__('Theme: %s', 'transpro'), 'TransPro');
                ?>
            </div>
        </div>
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>