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



/*******************************************************************************
										FUNCTIONS OF TEMPLATE
*******************************************************************************/

function hierarhical_select($list,$parent=0,$level=0){
	$return = '';
	foreach ($list as $item){
		if ($item->parent==$parent){
?>
			<option value="<?php echo $item->slug;?>" ><?php echo str_repeat('-',$level)." ".$item->name;?></option>
<?php
			echo hierarhical_select($list,$item->term_id,$level+1);
		}
	}
	return $return;
}

function mss_sort_rss_helper($a,$b) {
	return strtotime($a['pubdate']) < strtotime($b['pubdate']);
}
function mss_get_rss($cat,$type){
	global
		$wpdb,
		$mss_opt;	
	include_once(ABSPATH . WPINC . '/rss.php');
   $table_name = $wpdb->prefix . "merge_rss";
	$where_array = array();
	if (is_array($cat)){
		$where_array[] = 'cat IN ("'. implode('","',$cat).'")';
	}else{
		$where_array[] = 'cat = "'.addslashes($cat).'"';
	}
	if (is_array($type)){
		$where_array[] = 'type IN ("'. implode('","',$type).'")';
	}else{
		$where_array[] = 'type = "'.addslashes($type).'"';
	}
	$where = 'WHERE ('.implode(') AND (',$where_array).')';
	$sql = "
		SELECT
			id,url,type,cat
		FROM
			$table_name
		$where
		ORDER BY 
			id
	";
	$rss = $wpdb->get_results($sql);
//	dump($sql);
//	dump($rss);
	$rss_list = array();
	foreach($rss as $item){
		$rss_list[] = fetch_rss($item->url);
	}
/*$rss_list[]= fetch_rss('http://www.versvs.net/node/feed');
	$rss_list[]= fetch_rss('http://www.error500.net/node/feed');
*/	
	

	$all_rss = array();
	foreach($rss_list as $rss){
		$all_rss = array_merge($all_rss,$rss->items);
	}
	usort($all_rss, mss_sort_rss_helper);
	$return = array();
	$cnt = 0;
	foreach ($all_rss as $rss) {
		if ($cnt>=$mss_opt['count']){
			break;
		}
		$return[] = $rss;
		//echo "$rss[title] -  $rss[pubdate] <br/>";
		$cnt++;
	}
	return $return;
}

/*******************************************************************************
										ADDITIONAL FUNCTIONS	
*******************************************************************************/

if (!function_exists('dump')){
	$dump = create_function('$var','echo "<pre>";var_dump($var);echo "</pre>";');
}

function mss_block($val){
	global $wpdb;
//	return mysqli_real_escape_string($val);
	return $wpdb->escape($val);
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