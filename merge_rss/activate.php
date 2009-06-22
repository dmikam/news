<?php 
	mss_log("incluido archivo ".__FILE__);
function mss_install() {
   global $wpdb;
	global $mss_version;
   $table_name = $wpdb->prefix . "merge_rss";
	
	$mss_opt = array(
		'version'	=> '0.1',
		'count'		=> '5',
		'log'			=> '1',
	);
	set_option("mss_opt",$mss_opt);
	mss_log('Opciones asociados');
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		mss_log("Intento crear la tabla $table_name");
		$sql = "CREATE TABLE " . $table_name . " (
			  id mediumint(9) NOT NULL AUTO_INCREMENT,
			  url VARCHAR(255) NOT NULL,
			  type VARCHAR(25) NOT NULL,
			  cat VARCHAR(100) NOT NULL,
			  PRIMARY KEY  id (id)
			);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		if (dbDelta($sql)){
			mss_log("Se ha creado la tabla $table_name");
		}else{
			mss_log("No se ha podido crear la tabla $table_name");
		}
	}
	return true;
}

?>