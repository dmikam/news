<?php
/*
Plugin Name: Merge RSS
Plugin URI: 
Description: This plugin permit subscribe a various RSS lists and merge them into one
Version: 1.0
Author: dmikam
Author URI: http://shockinfo.blogspot.com
*/

$mss_version = 1.0;


register_activation_hook(__FILE__,'mss_install');

function mss_install () {
   global $wpdb;
	global $mss_version;
   $table_name = $wpdb->prefix . "merge_rss";

	set_option("mss_version",$mss_version);

	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		$sql = "CREATE TABLE " . $table_name . " (
			  id mediumint(9) NOT NULL AUTO_INCREMENT,
			  url VARCHAR(255) NOT NULL,
			  type VARCHAR(25) NOT NULL,
			  cat VARCHAR(100) NOT NULL,
			  PRIMARY KEY  id (id)
			);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}

}


add_action('admin_menu', 'mss_plugin_menu');

function mss_plugin_menu() {
  add_options_page('Merge RSS Plugin Options', 'MSS Options', 8, 'mss_options.php');
}

?>