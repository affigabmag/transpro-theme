<?php
/**
 * Theme setup functions
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Register widget areas
 */
function transpro_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Main Sidebar', 'transpro'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here to appear in your sidebar.', 'transpro'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'transpro_widgets_init');

/**
 * Enqueue RTL stylesheets when RTL is enabled
 */
function transpro_enqueue_rtl_styles() {
    if (transpro_is_rtl()) {
        wp_enqueue_style('transpro-rtl', TRANSPRO_URI . '/assets/css/rtl.css', array(), TRANSPRO_VERSION);
    }
}
add_action('wp_enqueue_scripts', 'transpro_enqueue_rtl_styles', 20);

/**
 * Add admin page for theme settings
 */
function transpro_add_admin_menu() {
    add_theme_page(
        esc_html__('TransPro Settings', 'transpro'),
        esc_html__('TransPro Settings', 'transpro'),
        'manage_options',
        'transpro-settings',
        'transpro_settings_page'
    );
}
add_action('admin_menu', 'transpro_add_admin_menu');

/**
 * Register settings
 */
function transpro_register_settings() {
    register_setting('transpro_options', 'transpro_text_direction', array(
        'type' => 'string',
        'default' => 'ltr',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    add_option('transpro_text_direction', 'ltr'); // Ensure default exists
    
    // Register theme name setting
    register_setting('transpro_options', 'transpro_theme_name', array(
        'type' => 'string',
        'default' => 'TransPro',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    add_option('transpro_theme_name', 'TransPro'); // Ensure default exists
}
add_action('admin_init', 'transpro_register_settings');

/**
 * Display settings page
 */
function transpro_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('transpro_options');
            do_settings_sections('transpro-settings');
            
            $current_direction = get_option('transpro_text_direction', 'ltr');
            $theme_name = get_option('transpro_theme_name', 'TransPro');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Theme Name', 'transpro'); ?></th>
                    <td>
                        <input type="text" name="transpro_theme_name" value="<?php echo esc_attr($theme_name); ?>" class="regular-text" />
                        <p class="description"><?php esc_html_e('Enter the name to display in the sidebar header.', 'transpro'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Text Direction', 'transpro'); ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php esc_html_e('Text Direction', 'transpro'); ?></span></legend>
                            <label>
                                <input type="radio" name="transpro_text_direction" value="ltr" <?php checked('ltr', $current_direction); ?> />
                                <?php esc_html_e('Left to Right (LTR)', 'transpro'); ?>
                            </label>
                            <br />
                            <label>
                                <input type="radio" name="transpro_text_direction" value="rtl" <?php checked('rtl', $current_direction); ?> />
                                <?php esc_html_e('Right to Left (RTL)', 'transpro'); ?>
                            </label>
                        </fieldset>
                        <p class="description"><?php esc_html_e('After changing this setting, you may need to refresh your browser to see the changes.', 'transpro'); ?></p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

/**
 * When a new menu item is added to the TransPro menu, ensure it shows in the sidebar
 */
function transpro_update_sidebar_menu($menu_id, $menu_item_db_id, $args) {
    $menu = wp_get_nav_menu_object('TransPro');
    
    if ($menu && $menu->term_id == $menu_id) {
        // Set the menu to the sidebar location if it's not already set
        $locations = get_theme_mod('nav_menu_locations');
        if (!isset($locations['transpro_sidebar']) || $locations['transpro_sidebar'] != $menu_id) {
            $locations['transpro_sidebar'] = $menu_id;
            set_theme_mod('nav_menu_locations', $locations);
        }
    }
}
add_action('wp_update_nav_menu_item', 'transpro_update_sidebar_menu', 10, 3);