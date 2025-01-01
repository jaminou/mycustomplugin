<?php
// Register meta box
function custom_directory_add_meta_box() {
    add_meta_box(
        'custom_directory_meta_box',
        'Business Details',
        'custom_directory_meta_box_callback',
        'business_listing'
    );
}
add_action('add_meta_boxes', 'custom_directory_add_meta_box');

function custom_directory_meta_box_callback($post) {
    wp_nonce_field('custom_directory_save_meta_box_data', 'custom_directory_meta_box_nonce');
    // Include all your form fields
    $fields = array(
        'custom_directory_address_street' => 'Street', 
        'custom_directory_address_city' => 'City',
        'custom_directory_address_state' => 'State',  
        'custom_directory_address_zip' => 'Zip Code',
        'custom_directory_contact_phone' => 'Phone',
        'custom_directory_contact_email' => 'Email',
        'custom_directory_contact_website' => 'Website',
        'custom_directory_services_offered' => 'Services Offered',
        'custom_directory_category' => 'Category',
        'custom_directory_ratings' => 'Ratings'
    );

    foreach ($fields as $key => $label) {
        echo '<p><label for="'.$key.'">'.$label.':</label>';
        echo '<input type="text" id="'.$key.'" name="'.$key.'" value="'.esc_attr(get_post_meta($post->ID, '_'.$key, true)).'" size="25" /></p>';
    }
}

// Save meta box data
function custom_directory_save_meta_box_data($post_id) {
    if (!isset($_POST['custom_directory_meta_box_nonce']) || !wp_verify_nonce($_POST['custom_directory_meta_box_nonce'], 'custom_directory_save_meta_box_data')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['post_type']) && $_POST['post_type'] === 'business_listing' && !current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = array(
        'custom_directory_address_street', 
        'custom_directory_address_city',
        'custom_directory_address_state',  
        'custom_directory_address_zip',
        'custom_directory_contact_phone',
        'custom_directory_contact_email',
        'custom_directory_contact_website',
        'custom_directory_services_offered',
        'custom_directory_category',
        'custom_directory_ratings'
    );

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_'.$field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'custom_directory_save_meta_box_data');
?>