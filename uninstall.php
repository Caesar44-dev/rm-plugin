<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}
global $wpdb;
$table_rm_plugin = "{$wpdb->prefix}rm_plugin";
$wpdb->query("DROP TABLE IF EXISTS $table_rm_plugin");
