<?php
/*
Plugin Name: Merge RSS
Plugin URI: 
Description: This plugin permit subscribe a various RSS lists and merge them into one
Version: 0.1
Author: dmikam
Author URI: http://shockinfo.blogspot.com
*/

global
	$mss_opt;

	add_option('mss_opt', array(
		'version'	=> '0.1',
		'count'		=> '5',
		'log'			=> '1',
	));

	$mss_opt = get_option('mss_opt');

if ( is_admin() ){ // admin actions
	register_activation_hook(__FILE__,'mss_install');
	add_action('admin_menu', 'mss_menu');
	add_action('admin_init', 'mss_register_settings' );
} else {
  // non-admin enqueues, actions, and filters
}

function mss_install() {
   global $wpdb;
   $table_name = $wpdb->prefix . "merge_rss";
	

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
	return true;

}

function mss_menu() {
	add_options_page('Merge RSS Plugin Options', 'MSS Options', 8, 'merge_rss/mss_options.php');
}

function mss_register_settings(){
	register_setting('mss-opt', 'mss_opt');
}










function mss_log($text) {
	global $mss_opt;
	//if (!$mss_opt['log']) return;
	//var_dump($mss_opt);
	$file = fopen(dirname(__FILE__) . '/mss.log', 'a');
	fwrite($file, $text . "\n");
	fclose($file);
}

?>