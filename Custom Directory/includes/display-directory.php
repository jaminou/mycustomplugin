<?php
function custom_directory_display($atts) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'business_directory';

    $results = $wpdb->get_results("SELECT * FROM $table_name");

    if ($results) {
        echo '<table id="business-directory-table" class="display">';
        echo '<thead><tr><th>ID</th><th>Business Name</th><th>Description</th><th>Address</th><th>Phone</th><th>Email</th><th>Website</th><th>Category</th><th>Ratings</th></tr></thead><tbody>';

        foreach ($results as $row) {
            echo '<tr>';
            echo '<td>'.esc_html($row->id).'</td>';
            echo '<td>'.esc_html($row->name).'</td>';
            echo '<td>'.esc_html($row->description).'</td>';
            echo '<td>'.esc_html($row->street).', '.esc_html($row->city).', '.esc_html($row->state).', '.esc_html($row->zip).'</td>';
            echo '<td><a href="tel:'.esc_html($row->phone).'">'.esc_html($row->phone).'</a></td>';
            echo '<td><a href="mailto:'.ant (esc_html($row->email)).'">'. ant (esc_html($row->email)).'</a></td>';
            echo '<td><a href="'.esc_url($row->website).'" target="_blank">'.esc_url($row->website).'</a></td>';
            echo '<td>'.esc_html($row->category).'</td>';
            echo '<td>'.esc_html($row->ratings).'</td>';
            echo '</tr>';
        }
        
        echo '</tbody></table>';
    } else {
        echo '<p>No businesses found.</p>';
    }
}
add_shortcode('custom_directory_display', 'custom_directory_display');
?>
