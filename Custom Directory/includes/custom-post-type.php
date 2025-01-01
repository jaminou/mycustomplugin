<?php
function register_business_post_type() {
    $labels = array(
        'name' => 'Business Listings',
        'singular_name' => 'Business Listing',
        'menu_name' => 'Business Listings',
        'name_admin_bar' => 'Business Listing',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Business',
        'new_item' => 'New Business',
        'edit_item' => 'Edit Business',
        'view_item' => 'View Business',
        'all_items' => 'All Businesses',
        'search_items' => 'Search Businesses',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'custom-fields'),
        'rewrite' => array('slug' => 'businesses'),
    );

    register_post_type('business_listing', $args);
}
add_action('init', 'register_business_post_type');
?>