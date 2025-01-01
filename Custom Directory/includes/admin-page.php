<?php
function custom_directory_menu() {
    add_menu_page('Business Directory', 'Business Directory', 'manage_options', 'business-directory', 'custom_directory_page', 'dashicons-admin-users');
    add_submenu_page('business-directory', 'All Listings', 'All Listings', 'manage_options', 'custom_directory_listings');
}
add_action('admin_menu', 'custom_directory_menu');

function custom_directory_listings() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'business_directory';

    $results = $wpdb->get_results("SELECT * FROM $table_name");

    if ($results) {
        echo '<div class="wrap"><h1>All Listings</h1><table id="business-directory-table" class="display">';
        echo '<thead><tr><th>ID</th><th>Business Name</th><th>Description</th><th>Address</th><th>Phone</th><th>Email</th><th>Website</th><th>Category</th><th>Ratings</th><th>Edit</th><th>Delete</th></tr></thead><tbody>';
        
        foreach ($results as $row) {
            echo '<tr>';
            echo '<td>' . esc_html($row->id) . '</td>';
            echo '<td>' . esc_html($row->name) . '</td>';
            echo '<td>' . esc_html($row->description) . '</td>';
            echo '<td>' . esc_html($row->street) . ', ' . esc_html($row->city) . ', ' . esc_html($row->state) . ' ' . esc_html($row->zip) . '</td>';
            echo '<td><a href="tel:' . esc_html($row->phone) . '">' . esc_html($row->phone) . '</a></td>';
            echo '<td><a href="mailto:' . sanitize_email($row->email) . '">' . sanitize_email($row->email) . '</a></td>';
            echo '<td><a href="' . esc_url($row->website) . '" target="_blank">' . esc_url($row->website) . '</a></td>';
            echo '<td>' . esc_html($row->category) . '</td>';
            echo '<td>' . esc_html($row->ratings) . '</td>';
            echo '<td><a href="admin.php?page=edit_listing&id=' . intval($row->id) . '">Edit</a></td>';
            echo '<td><a href="admin.php?page=delete_listing&id=' . intval($row->id) . '" onclick="return confirm(\'Are you sure?\')">Delete</a></td>';
            echo '</tr>';
        }
        echo '</tbody></table></div>';
    } else {
        echo '<p>No entries found.</p>';
    }
} 

function custom_directory_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'business_directory';

    if (isset($_POST['business_name'])) {
        $wpdb->insert(
            $table_name,
            array(
                'name' => sanitize_text_field($_POST['business_name']),
                'description' => sanitize_textarea_field($_POST['business_description']),
                'street' => sanitize_text_field($_POST['custom_directory_address_street']),
                'city' => sanitize_text_field($_POST['custom_directory_address_city']),
                'state' => sanitize_text_field($_POST['custom_directory_address_state']),
                'zip' => sanitize_text_field($_POST['custom_directory_address_zip']),
                'phone' => preg_replace('/[^0-9]/', '', $_POST['custom_directory_contact_phone']),
                'email' => sanitize_email($_POST['custom_directory_contact_email']),
                'website' => esc_url_raw($_POST['custom_directory_contact_website']),
                'services' => sanitize_text_field($_POST['custom_directory_services_offered']),
                'category' => sanitize_text_field($_POST['custom_directory_category']),
                'ratings' => intval($_POST['custom_directory_ratings']),
            )
        );
    }

    ?>
    <div class="wrap">
        <h1>Business Directory</h1>
        <form method="post" action="">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Business Name:</th>
                    <td><input type="text" name="business_name" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Description:</th>
                    <td><textarea name="business_description" rows="5" required></textarea></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Street:</th>
                    <td><input type="text" name="custom_directory_address_street" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">City:</th>
                    <td><input type="text" name="custom_directory_address_city" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">State:</th>
                    <td>
                        <select name="custom_directory_address_state" required>
                            <option value="">Select a state</option>
                            <?php
                            $states = array(
                                'AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas', 'CA' => 'California', 'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware', 'FL' => 'Florida', 'GA' => 'Georgia', 'HI' => 'Hawaii', 'ID' => 'Idaho', 'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas', 'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland', 'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi', 'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada', 'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico', 'NY' => 'New York', 'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma', 'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina', 'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah', 'VT' => 'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington', 'WV' => 'West Virginia', 'WI' => 'Wisconsin', 'WY' => 'Wyoming',
                            );
                            foreach ($states as $code => $state) {
                                echo '<option value="' . esc_attr($code) . '">' . esc_html($state) . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Zip Code:</th>
                    <td><input type="text" name="custom_directory_address_zip" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Phone:</th>
                    <td><input type="text" name="custom_directory_contact_phone" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Email:</th>
                    <td><input type="email" name="custom_directory_contact_email" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Website:</th>
                    <td><input type="url" name="custom_directory_contact_website" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Services Offered:</th>
                    <td><input type="text" name="custom_directory_services_offered" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Category:</th>
                    <td><input type="text" name="custom_directory_category" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Ratings:</th>
                    <td><input type="number" name="custom_directory_ratings" min="1" max="5" required /></td>
                </tr>
            </table>
            <?php submit_button('Add Business'); ?>
        </form>
    </div>
    <?php

    // Handle data export to CSV file
    if (isset($_GET['export_data'])) {
        custom_directory_export_csv();
    }
}

// Export CSV function
function custom_directory_export_csv() {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="directory-export.csv"');
    $output = fopen('php://output', 'w');

    // Fetch data for export
    $args = array(
        'post_type' => 'business_listing',
        'posts_per_page' => -1,
    );
    $query = new WP_Query($args);

    fputcsv($output, array('Title', 'Content', 'Street', 'City', 'State', 'Zip Code', 'Phone', 'Email', 'Website', 'Services Offered', 'Category', 'Ratings'));

    while ($query->have_posts()) : $query->the_post();
        $title = get_the_title();
        $content = get_the_content();
        $street = get_post_meta(get_the_ID(), '_custom_directory_address_street', true);
        $city = get_post_meta(get_the_ID(), '_custom_directory_address_city', true);
        $state = get_post_meta(get_the_ID(), '_custom_directory_address_state', true);
        $zip = get_post_meta(get_the_ID(), '_custom_directory_address_zip', true);
        $phone = get_post_meta(get_the_ID(), '_custom_directory_contact_phone', true);
        $email = get_post_meta(get_the_ID(), '_custom_directory_contact_email', true);
        $website = get_post_meta(get_the_ID(), '_custom_directory_contact_website', true);
        $services_offered = get_post_meta(get_the_ID(), '_custom_directory_services_offered', true);
        $category = get_post_meta(get_the_ID(), '_custom_directory_category', true);
        $ratings = get_post_meta(get_the_ID(), '_custom_directory_ratings', true);
		
        fputcsv($output, array($title, $content, $street, $city, $state, $zip, $phone, $email, $website, $services_offered, $category, $ratings));
    endwhile;

    fclose($output);
    wp_reset_postdata();
}
?>
