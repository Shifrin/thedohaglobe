<?php

/**
 * Theme setup, adding some default configuration for this theme to support
 */
add_action('after_setup_theme', function () {
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Let WordPress manage the document title.
     */
    add_theme_support('title-tag');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     */
    add_theme_support('post-thumbnails');
    add_image_size('featured', 800, 450, true);

    // This theme uses wp_nav_menu() in two locations.
    register_nav_menus(
        [
            'primary'      => __('Primary Menu'),
            'secondary'    => __('Secondary Menu'),
            'footer'       => __('Footer Menu'),
            'social_media' => __('Social Media'),
        ]
    );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support(
        'html5',
        [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ]
    );

    // add post type supports
    add_theme_support('post-formats', ['video', 'audio']);
});

/**
 * Adding theme required styles
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    wp_enqueue_style('font-noto', 'https://fonts.googleapis.com/css?family=Noto+Serif:400,700&display=swap');
//    wp_enqueue_style('font-lato', 'https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap');

    if (isInMediaCategory()) {
        wp_enqueue_style('lightbox', get_template_directory_uri() . '/css/lightbox.min.css');
    }

    wp_enqueue_style('core', get_stylesheet_uri() . '?' . filemtime(get_stylesheet_directory() .
            '/style.css'));
});

/**
 * Adding theme required scripts
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('jquery');
    wp_enqueue_script(
        'bootstrap',
        'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js',
        ['jquery']
    );

    if (isInMediaCategory()) {
        wp_enqueue_script('lightbox', get_template_directory_uri() . '/js/lightbox.min.js', ['jquery']);
    }
});

/**
 * Remove WordPress default image sizes to avoid too many thumbnails creation.
 */
add_filter('intermediate_image_sizes_advanced', function ($sizes) {
    unset($sizes['medium'], $sizes['large'], $sizes['medium_large']);

    return $sizes;
});

/**
 * Limit the excerpt length.
 */
add_filter('excerpt_length', function () {
    return 25;
}, 999);

/**
 * Add custom excerpt more string.
 */
add_filter('excerpt_more', function () {
    return '...';
});