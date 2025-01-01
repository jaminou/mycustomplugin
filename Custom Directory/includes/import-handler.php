<?php
function custom_directory_import_csv($file_path) {
    $handle = fopen($file_path, 'r');

    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
        $post_data = array(
            'post_title'    => wp_strip_all_tags($data[0]),
            'post_content'  => $data[1],
            'post_status'   => 'publish',
            'post_type'     => 'business_listing',
        );

        $post_id = wp_insert_post($post_data);

        // Assuming the CSV has columns for custom fields
        update_post_meta($post_id, '_custom_directory_address', $data[2]);
        update_post_meta($post_id, '_custom_directory_contact_information', $data[3]);
        update_post_meta($post_id, '_custom_directory_services_offered', $data[4]);
        update_post_meta($post_id, '_custom_directory_ratings', $data[5]);
    }

    fclose($handle);
}
?>