<?php

add_action('wp_enqueue_scripts', function () {

    wp_enqueue_style(
        'storefront-child',
        get_stylesheet_directory_uri() . '/assets/css/theme.css',
        ['storefront-style'],
        wp_get_theme()->get('Version')
    );

});

add_action('after_setup_theme', function () {

    remove_action('storefront_sidebar', 'storefront_get_sidebar', 10);
    remove_action('storefront_header', 'storefront_product_search', 40);

}, 11);

add_action('woocommerce_before_shop_loop', function () {

    if (function_exists('storefront_product_search') && (is_shop() || is_product_category() || is_product_tag())) {
        storefront_product_search();
    }

}, 5);

function storefront_child_get_about_page_id() {

    $about_page = get_page_by_path('about-us');

    if ($about_page) {
        return $about_page->ID;
    }

    return wp_insert_post([
        'post_title' => 'About Us',
        'post_name' => 'about-us',
        'post_content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae justo vitae neque tincidunt posuere. Praesent sed sem at lorem luctus feugiat. Donec facilisis, risus at dignissim luctus, nibh erat luctus risus, vitae volutpat mi mi at arcu.</p>',
        'post_status' => 'publish',
        'post_type' => 'page',
    ]);

}

add_action('init', function () {

    storefront_child_get_about_page_id();

});

add_filter('wp_nav_menu_items', function ($items, $args) {

    if (!isset($args->theme_location) || 'primary' !== $args->theme_location) {
        return $items;
    }

    $about_page_id = storefront_child_get_about_page_id();

    if (is_wp_error($about_page_id) || !$about_page_id) {
        return $items;
    }

    $about_url = esc_url(get_permalink($about_page_id));

    return $items . '<li class="menu-item menu-item-about-us"><a href="' . $about_url . '">About Us</a></li>';

}, 10, 2);

add_filter('body_class', function ($classes) {

    $classes[] = 'storefront-full-width-content';

    return $classes;

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
