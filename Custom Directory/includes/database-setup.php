<?php
global $wpdb;
$table_name = $wpdb->prefix . 'business_directory';

function custom_directory_install() {
    global $wpdb;
    global $table_name;

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        description text NOT NULL,
        street tinytext NOT NULL,
        city tinytext NOT NULL,
        state char(2) NOT NULL,
        zip char(5) NOT NULL,
        phone char(20) NOT NULL,
        email tinytext NOT NULL,
        website tinytext NOT NULL,
        services tinytext NOT NULL,
        category tinytext NOT NULL,
        ratings tinyint NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;

    ALTER TABLE $table_name ADD COLUMN IF NOT EXISTS map_url tinytext NOT NULL;"; // Add this line

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'custom_directory_install');
?>