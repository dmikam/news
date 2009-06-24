<?php
/*
Plugin Name: SUbScribe Edit Post
Plugin URI: 
Description: Create subscription to edited post
Version: 1.0.0
Author: dmikam
Author URI: 
Disclaimer: 
*/


$susep_opt = get_option('susep_opt');


if ( is_admin() ){ // admin actions
	register_activation_hook(__FILE__,'susep_install');
	add_filter("plugin_action_links_subscribe_edit_post/subscribe_edit_post.php", 'susep_options_link');
	add_action('admin_menu', 'susep_menu');
	add_action('admin_init', 'susep_register_settings' );
	add_action('comment_form', 'susep_comment_form', 99);
	add_action('init','susep_init_unsubscribe');
	add_action('edit_post', 'susep_notify');
//	add_action('comment_post', 'susep_comment_post', 10, 2);
	add_action('wp_set_comment_status', 'susep_comment_notify', 10, 2);
} else {
  // non-admin enqueues, actions, and filters
}


/*******************************************************************************
								ADMIN INTERFASE FUNCTIONS
*******************************************************************************/
function susep_install(){
	global $wpdb;
	$wpdb->query("RENAME TABLE " . $wpdb->prefix . "comment_notifier TO " . $wpdb->prefix . "susep");

	// SQL to create the table
	$sql = 'CREATE TABLE IF NOT EXISTS ' . $wpdb->prefix . 'susep (
		`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
		`post_id` INT UNSIGNED NOT NULL DEFAULT 0,
		`name` VARCHAR (100) NOT NULL DEFAULT \'\',
		`email` VARCHAR (100) NOT NULL DEFAULT \'\',
		`token` VARCHAR (50) NOT NULL DEFAULT \'\',
		PRIMARY KEY  (`id`),
		UNIQUE KEY `post_id_email` (`post_id`,`email`),
		KEY `token` (`token`)
	)';

//	$wpdb->query($sql);
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
}

function susep_menu(){
	add_options_page('Subscribe edit post', 'Subscribe edit post', 'manage_options', 'subscribe_edit_post/options.php');
}

function susep_options_link($links){
	$settings_link = '<a href="options-general.php?page=subscribe_edit_post/mss_options.php">' . __('Settings') . '</a>';
	array_unshift($links, $settings_link);
	return $links;
}

function susep_register_settings(){
	register_setting('susep-opt', 'susep_opt');
}

/*******************************************************************************
								USER INTERFASE FUNCTIONS
*******************************************************************************/

function susep_comment_post($comment_id, $status){
/*	if ($status == 1){
		susep_notify($comment_id);
	}
*/
	if (($status == 0 || $status == 1) && $_POST['subscribe']){
		$email = strtolower(trim($_POST['email']));
		$post_id = $_POST['comment_post_ID'];
		$name = $_POST['author'];
		susep_subscribe($post_id, $email, $name);
	}
}

function susep_subscribe($post_id, $email, $name){
	global $wpdb;

	$subscribed = $wpdb->get_var("SELECT COUNT(*) FR0M " . $wpdb->prefix . "susep WHERE post_id=" . $post_id ." AND email='" . $email . "'");

	if (!$subscribed){
		$token = md5(rand());
		$res = $wpdb->get_var("INSERT INTO " . $wpdb->prefix . "susep (post_id, email, name, token) VALUES (" . $post_id . ",'" . $email . "','" . $wpdb->escape($name) . "','" . $token . "')");
	}
}

function susep_init_unsubscribe(){
	global $susep_opt;

	if ($_GET['susep_id']){
		$token = $_GET['susep_t'];
		$id = $_GET['susep_id'];

		susep_unsubscribe($id, $token);

		echo '<html><head>';
		echo '<meta http-equiv="refresh" content="3;url=' . get_option('home') . '"/>';
		echo '</head><body>';
		echo $susep_opt['thankyou'];
		echo '</body></html>';
		flush();
		// Have I to call some other function like wp_die()?
		die();
	}
}

function susep_unsubscribe($id, $token){
	global $wpdb;
	$sql = "
		DELETE FROM
			{$wpdb->prefix}susep
		WHERE
			id='".$wpdb->escape($id)."'
			AND
			token='".$wpdb->escape($token)."'
	";
	$return = $wpdb->query($sql);
	return $return;
}

function susep_comment_form(){
	global $pstl_options;
?>
	<p>
		<input type="checkbox" value="1" name="subscribe" id="subscribe"/>
		<label for="subscribe">
			Suscribirme al material de este artículo
		</label>
	</p>';
<?php
	$comment = $pstl_options['comment_form'];
	echo $comment;
}

function susep_comment_notify($comment_id, $status){
	if ($status == 'approve'){
		susep_notify($comment_id);
	}
}




/*******************************************************************************
									ADDITIONAL FUNCTIONS
*******************************************************************************/

if (!function_exists('dump')){
	$dump = create_function('$var','echo "<pre>";var_dump($var);echo "</pre>";');
}

function susep_log($text){
	global $susep_opt;
	if (!$susep_opt['logs']) return;
	$file = fopen(dirname(__FILE__) . '/.subscribe_edit_post.log', 'a');
	fwrite($file, $text . "\n");
	fclose($file);
}
?>