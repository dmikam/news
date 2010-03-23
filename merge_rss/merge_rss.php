<?php
/*
Plugin Name: Merge RSS
Plugin URI: 
Description: This plugin permit subscribe a various RSS lists and merge them into one
Version: 0.2
Author: dmikam
Author URI: http://shockinfo.blogspot.com
*/

global
	$mss_opt;

	add_option('mss_opt', array(
		'version'	=> '0.2',
		'count'		=> '5',
		'log'			=> '1',
	));

	$mss_opt = get_option('mss_opt');

if ( is_admin() ){ // admin actions
	register_activation_hook(__FILE__,'mss_install');
	add_action('admin_menu', 'mss_menu');
	add_action('admin_init', 'mss_register_settings' );
	add_filter("plugin_action_links_merge_rss/merge_rss.php", 'mss_options_link');
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
			  title VARCHAR(100) NOT NULL,
			  image_url VARCHAR(100) NOT NULL,
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

function mss_options_link($links){
	$settings_link = '<a href="options-general.php?page=merge_rss/mss_options.php">' . __('Settings') . '</a>';
	array_unshift($links, $settings_link);
	return $links;
}


function mss_register_settings(){
	register_setting('mss-opt', 'mss_opt');
}



/*******************************************************************************
										FUNCTIONS OF TEMPLATE
*******************************************************************************/

function hierarhical_select($list,$parent=0,$level=0,$current=''){
	$return = '';
	foreach ($list as $item){
		if ($item->parent==$parent){
?>
			<option value="<?php echo $item->slug;?>" <?php echo ($item->slug==$current ? 'selected="selected"' : '' )?> ><?php echo str_repeat('-',$level)." ".$item->name;?></option>
<?php
			echo hierarhical_select($list,$item->term_id,$level+1,$current);
		}
	}
	return $return;
}

function mss_sort_rss_helper($a,$b) {
	return $a['pubdate'] < $b['pubdate'];
}
function mss_get_rss($cat,$type,$count=null){
	global
		$wpdb,
		$mss_opt;	
	if (empty($count))  {
		$count=$mss_opt['count'];
	}
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
			id,url,type,cat,title,image_url
		FROM
			$table_name
		$where
		ORDER BY 
			id
	";
	$rss = $wpdb->get_results($sql);
	$rss_list = array();
	foreach($rss as $item){
//		$new_item = fetch_rss($item->url);
		$feed = fetch_feed($item->url);
		if (!is_wp_error($feed)) :
			$maxitems = $feed->get_item_quantity(1);
			$rss_items = $feed->get_items(0, $maxitems);
			$new_item = array();
			foreach($rss_items as $key=>$nitem){
				$new_item = array(
					 'rss_title'	=> $item->title//$nitem->get_title()
					,'image_url'	=> $item->image_url// 
					,'link'			=> $nitem->get_permalink()
					,'title'			=> $nitem->get_title()
					,'description'	=> $nitem->get_description()
					,'pubdate'		=> strtotime($nitem->get_date())
					,'date'			=> $nitem->get_date()
					,'url'			=> $feed->get_link()
				);
				$rss_list[] = $new_item;
			}
		endif;
	}

/*	$all_rss = array();
	foreach($rss_list as $rss){
		$all_rss = array_merge($all_rss,$rss);
	}
*/
	$all_rss = $rss_list;
	usort($all_rss, mss_sort_rss_helper);

	$return = array();
	$cnt = 0;
	foreach ($all_rss as $rss) {
		if ($cnt>=$count){
			break;
		}
		$return[] = $rss;
		//echo "$rss[title] -  $rss[pubdate] <br/>";
		$cnt++;
	}
//	var_dump($return);
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
	if (!$mss_opt['log']) return;
	//var_dump($mss_opt);
	$file = fopen(dirname(__FILE__) . '/mss.log', 'a');
	fwrite($file, $text . "\n");
	fclose($file);
}

?>
