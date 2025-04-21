<?php
/**
 * The header for our theme
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php echo transpro_is_rtl() ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php if (transpro_is_rtl()) : ?>
        <style type="text/css">
            body {
                direction: rtl;
                unicode-bidi: embed;
            }
        </style>
    <?php endif; ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <header id="masthead" class="site-header">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <div class="site-branding">
                <?php
                if (has_custom_logo()) :
                    the_custom_logo();
                else :
                ?>
                    <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
                <?php endif; ?>
            </div>

            <nav id="site-navigation" class="main-navigation">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                        'menu_class'     => 'flex',
                        'fallback_cb'    => false,
                    )
                );
                ?>
                <div class="login-status ml-4">
                    <?php
                    if (is_user_logged_in()) :
                        $current_user = wp_get_current_user();
                    ?>
                        <span class="user-welcome mr-2"><?php printf(esc_html__('Welcome, %s', 'transpro'), $current_user->display_name); ?></span>
                        <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>"><?php esc_html_e('Log Out', 'transpro'); ?></a>
                    <?php else : ?>
                        <a href="<?php echo esc_url(wp_login_url()); ?>"><?php esc_html_e('Log In', 'transpro'); ?></a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>

    <div id="content" class="site-content flex">
        <?php if (transpro_show_sidebar()) : ?>
            <aside id="secondary" class="transpro-sidebar">
                <div class="sidebar-header px-4 py-2 bg-gray-800 text-white">
                    <h3 class="text-lg font-medium"><?php echo esc_html(get_option('transpro_theme_name', 'TransPro')); ?></h3>
                </div>
                <nav class="sidebar-menu">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'transpro_sidebar',
                            'menu_id'        => 'transpro-menu',
                            'container'      => false,
                            'menu_class'     => 'sidebar-nav',
                            'fallback_cb'    => false,
                        )
                    );
                    ?>
                </nav>
            </aside>
        <?php endif; ?>

        <main id="primary" class="site-main <?php echo transpro_show_sidebar() ? 'has-sidebar' : 'no-sidebar'; ?>">