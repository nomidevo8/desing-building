<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

delete_option('building_designer_settings');
delete_transient('building_designer_activated');

global $wpdb;

$wpdb->query("DELETE FROM {$wpdb->usermeta} WHERE meta_key = 'building_designer_selections'");

if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
}
