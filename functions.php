<?php

add_action('wp_enqueue_scripts', function () {

    wp_enqueue_style(
        'storefront-child',
        get_stylesheet_directory_uri() . '/assets/css/theme.css',
        ['storefront-style'],
        wp_get_theme()->get('Version')
    );

});

add_action('wp_head', function () {

    $primary = get_option('my_primary_color', '#0073aa');
    $secondary = get_option('my_secondary_color', '#111111');
    $accent = get_option('my_accent_color', '#00ff00');

    echo "
    <style>
        :root {
            --primary-color: {$primary};
            --secondary-color: {$secondary};
            --accent-color: {$accent};
        }
    </style>
    ";
});