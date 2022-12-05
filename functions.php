<?php

//Adds dynamic title tag support
function myTheme_support()
{
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
    $another_args = array(
        'default-color' => '0000ff',
        'default-image' => get_template_directory_uri() . '/assets/images/background/pozadina_png.jpg',
        'default-repeat' => 'no-repeat',
    );
    add_theme_support('custom-background', $another_args);
}
add_action('after_setup_theme', 'myTheme_support');

function myTheme_register_styles()
{
    $version = wp_get_theme()->get('Version');
    wp_enqueue_style('myTheme-bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css", array(), '4.4.1', 'all');
    wp_enqueue_style('myTheme-fontawesome', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css", array(), '5.13.0', 'all');
    wp_enqueue_style('myTheme-style', get_template_directory_uri() . "./style.css", array('myTheme-bootstrap'), $version, 'all');

}

function myTheme_register_scripts()
{
    $version = wp_get_theme()->get('Version');
    wp_enqueue_script('myTheme-jquery', "https://code.jquery.com/jquery-3.4.1.slim.min.js", array(), "3.4.1", true);
    wp_enqueue_script('myTheme-popper', "https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js", array(), "1.16.0", true);
    wp_enqueue_script('myTheme-bootstrap', "https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js", array(), "3.4.1", true);
    wp_enqueue_script('myTheme-main', get_template_directory_uri() . "/assets/js/main.js", array(), $version, true);

}
add_action('wp_enqueue_scripts', 'myTheme_register_styles');
add_action('wp_enqueue_scripts', 'myTheme_register_scripts');

function myTheme_menus()
{
    $locations = array(
        'primary' => __('Primary Menu', 'THEMENAME'),
        'secondary' => __('Secondary Menu', 'SecondaryMenu')
    );
    register_nav_menus($locations);
}
add_action('init', 'myTheme_menus');

function my_theme_posts_link_attributes()
{
    return 'class="btn btn-primary"';
}
add_filter('next_posts_link_attributes', 'my_theme_posts_link_attributes');

/**
 * Register Custom Navigation Walker
 */
function register_navwalker()
{
    if (!file_exists(get_template_directory() . '/class-wp-bootstrap-navwalker.php')) {
        // File does not exist... return an error.
        return new WP_Error('class-wp-bootstrap-navwalker-missing', __('It appears the class-wp-bootstrap-navwalker.php file may be missing.', 'wp-bootstrap-navwalker'));
    } else {
        // File exists... require it.
        require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
    }
}
add_action('after_setup_theme', 'register_navwalker');


# Dodavanje logotipa
function theme_custom_logo()
{
    if (function_exists("the_custom_logo")) {
        the_custom_logo();
    }
}

function make_main_nav_items() {
    return '<ul id="%1$s" class="navbar-nav me-auto mb-0 mb-ml-5 %2$s">%3$s</ul>';
}
