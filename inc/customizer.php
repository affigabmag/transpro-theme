<?php
/**
 * TransPro Theme Customizer
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function transpro_customize_register($wp_customize) {
    // Add section for TransPro theme settings
    $wp_customize->add_section('transpro_options', array(
        'title'    => esc_html__('TransPro Options', 'transpro'),
        'priority' => 30,
    ));
    
    // Add theme name setting
    $wp_customize->add_setting('transpro_theme_name', array(
        'default'           => 'TransPro',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('transpro_theme_name', array(
        'label'    => esc_html__('Theme Name', 'transpro'),
        'description' => esc_html__('Name displayed in the sidebar header', 'transpro'),
        'section'  => 'transpro_options',
        'type'     => 'text',
    ));
    
    // Add text direction setting
    $wp_customize->add_setting('transpro_text_direction', array(
        'default'           => 'ltr',
        'sanitize_callback' => 'transpro_sanitize_text_direction',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('transpro_text_direction', array(
        'label'    => esc_html__('Text Direction', 'transpro'),
        'section'  => 'transpro_options',
        'type'     => 'radio',
        'choices'  => array(
            'ltr' => esc_html__('Left to Right (LTR)', 'transpro'),
            'rtl' => esc_html__('Right to Left (RTL)', 'transpro'),
        ),
    ));
    
    // Add sidebar settings
    $wp_customize->add_setting('transpro_sidebar_width', array(
        'default'           => 'default',
        'sanitize_callback' => 'transpro_sanitize_sidebar_width',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('transpro_sidebar_width', array(
        'label'    => esc_html__('Sidebar Width', 'transpro'),
        'section'  => 'transpro_options',
        'type'     => 'select',
        'choices'  => array(
            'narrow'  => esc_html__('Narrow', 'transpro'),
            'default' => esc_html__('Default', 'transpro'),
            'wide'    => esc_html__('Wide', 'transpro'),
        ),
    ));
    
    // Add color settings
    $wp_customize->add_setting('transpro_sidebar_bg_color', array(
        'default'           => '#f8fafc',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'transpro_sidebar_bg_color', array(
        'label'    => esc_html__('Sidebar Background Color', 'transpro'),
        'section'  => 'transpro_options',
    )));
    
    $wp_customize->add_setting('transpro_sidebar_text_color', array(
        'default'           => '#1e293b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'transpro_sidebar_text_color', array(
        'label'    => esc_html__('Sidebar Text Color', 'transpro'),
        'section'  => 'transpro_options',
    )));
}
add_action('customize_register', 'transpro_customize_register');

/**
 * Sanitize text direction
 */
function transpro_sanitize_text_direction($input) {
    $valid = array('ltr', 'rtl');
    
    if (in_array($input, $valid, true)) {
        return $input;
    }
    
    return 'ltr';
}

/**
 * Sanitize sidebar width
 */
function transpro_sanitize_sidebar_width($input) {
    $valid = array('narrow', 'default', 'wide');
    
    if (in_array($input, $valid, true)) {
        return $input;
    }
    
    return 'default';
}

/**
 * Generate CSS for the customizer options
 */
function transpro_customize_css() {
    $sidebar_bg_color = get_theme_mod('transpro_sidebar_bg_color', '#f8fafc');
    $sidebar_text_color = get_theme_mod('transpro_sidebar_text_color', '#1e293b');
    $sidebar_width = get_theme_mod('transpro_sidebar_width', 'default');
    
    $sidebar_width_value = '250px'; // Default width
    
    if ($sidebar_width === 'narrow') {
        $sidebar_width_value = '200px';
    } elseif ($sidebar_width === 'wide') {
        $sidebar_width_value = '300px';
    }
    
    ?>
    <style type="text/css">
        .transpro-sidebar {
            background-color: <?php echo esc_attr($sidebar_bg_color); ?>;
            color: <?php echo esc_attr($sidebar_text_color); ?>;
            width: <?php echo esc_attr($sidebar_width_value); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'transpro_customize_css');