<?php
/*
Plugin Name: Subscribe Edit Pos
Plugin URI: 
Description: Create subscription to edited post
Version: 1.0.0
Author: 
Author URI: 
Disclaimer: 
*/


$susep_options = get_option('susep');

if ($susep_options['active'])
{
    add_action('comment_form', 'susep_comment_form', 99);
//    add_action('wp_set_comment_status', 'susep_wp_set_comment_status', 10, 2);
    add_action('comment_post', 'susep_comment_post', 10, 2);
    add_action('edit_post', 'susep_notify');
}

function susep_request($name, $default=null)
{
    if (!isset($_POST[$name]))
    {
        return $default;
    }
    if (get_magic_quotes_gpc())
    {
        return susep_stripslashes($_POST[$name]);
    }
    else
    {
        return $_POST[$name];
    }
}

function susep_stripslashes($value)
{
    $value = is_array($value) ? array_map('susep_stripslashes', $value) : stripslashes($value);
    return $value;
}

/**
 * Called when a comment is added to a post with its status: '0' - in moderation,
 * '1' - approved, 'spam' if it is spam. The comment_id is the database id of the
 * comment which is already saved a this point.
 */
function susep_comment_post($comment_id, $status)
{
    susep_log('New comment posted, id: ' . $comment_id . ', status: ' . $status);
    susep_log('Subscribe checkbox status (empty -> not set): ' . $_POST['subscribe']);

    // Checks if there is a subscription request, comments are always sent with
    // POST requests. The '$POST' contains all the values sent by commenters:
    // 'email', 'author', 'comment_post_ID', ...
    if (($status == 0 || $status == 1) && $_POST['subscribe'])
    {
        susep_log('Going on with subscription');

        // Get the post id: it is in the POST parameter set as "comment_post_ID". There is no need to execute queries!
        // Email is already valid, Wordpress checks it before to add a comment to the db...)
        $email = strtolower(trim($_POST['email']));
        $post_id = $_POST['comment_post_ID'];
        $name = $_POST['author'];

        susep_subscribe($post_id, $email, $name);
    }

    // Notify if the comment is already approved
/*    if ($status == 1)
    {
        susep_notify($comment_id);
    }
*/
}

/**
 * Called when a comment is changed of status (usually by an action of the administrator).
 * The status is a string of 'hold', 'approve', 'spam', or 'delete'.
 */
function susep_wp_set_comment_status($comment_id, $status)
{
    susep_log('Comment ' . $comment_id . ' status changed to: ' . $status);
    // When a comment is approved the subscribers are notified
    if ($status == 'approve')
    {
        susep_notify($comment_id);
    }
}

/**
 * Add a subscribe checkbox after the form content if the theme calls the right function
 * and the user want the checkbox automatically added. The options panel checks the theme
 * compatibility.
 */
function susep_comment_form()
{
    global $susep_options;

    if ($susep_options['checkbox'])
    {
        if ($susep_options['label'] == '') $susep_options['label'] = 'Notify me of new comments';
        echo '<p><input type="checkbox" value="1" name="subscribe" id="subscribe"';
        if ($susep_options['checked'])
        {
            echo ' checked="checked"';
        }
        echo '/>&nbsp;<label for="subscribe">' . $susep_options['label'] . '</label></p>';
    }
    $comment = $pstl_options['comment_form'];
    echo $comment;
}

/**
 * Sends out the notification of a new comment for subscribers. This is the core function
 * of this plugin. The notification is not sent to the email address of the author
 * if the comment.
 */
function susep_notify($post_id)
{
    global $susep_options, $wpdb;

    if (!$susep_options['active']) return;

    $email = strtolower(trim($comment->comment_author_email));

    susep_log('Sending notifications for post: ' . $post_id);

//	dump($wpdb->get_results("select * from " . $wpdb->prefix . "comment_notifier "));

    $subscriptions = $wpdb->get_results("select * from " . $wpdb->prefix . "comment_notifier where post_id=" . $post_id .
        " and email<>'" . $wpdb->escape($email) . "'");

    if (!$subscriptions)
    {
        susep_log('No suscriptions found for post ' . $post_id);
        return;
    }

    $post = get_post($post_id);
    $title = $post->post_title;
    $link = get_permalink($post_id);
    //$comment_link = $link . '?cid=' . $comment_id . '#comment-' . $comment_id;
    $comment_link = $link . '#comment-' . $comment_id;

    $comment = get_comment($comment_id);

    $message = $susep_options['message'];
    $message = str_replace('{title}', $title, $message);
    $message = str_replace('{link}', $link, $message);
    $message = str_replace('{comment_link}', $comment_link, $message);
    $message = str_replace('{author}', $comment->comment_author, $message);
    $temp = strip_tags($comment->comment_content);
    if ($susep_options['length'] && strlen($temp) > $susep_options['length'])
    {
        $x = strpos($temp, ' ', $susep_options['length']);
        if ($x !== false) $temp = substr($temp, 0, $x) . '...';
    }
    $message = str_replace('{content}', $temp, $message);

    $subject = $susep_options['subject'];
    $subject = str_replace('{title}', $title, $subject);
    $subject = str_replace('{author}', $comment->comment_author, $subject);
    $url = get_option('home') . '/?';

    if (trim($susep_options['copy']) != '')
    {
        susep_log('Send notification copy to test user');
        $m = $message;
        $m = str_replace('{name}', 'copy', $m);
        $m = str_replace('{unsubscribe}', $url . 'susep_id=0&susep_t=0', $m);

        $s = $subject;
        $s = str_replace('{name}', 'copy', $s);

        susep_mail($susep_options['copy'], $s, $m);
    }

    $idx = 0;
    $ok = 0;
    foreach ($subscriptions as $subscription)
    {
        $idx++;
        $m = $message;
        $m = str_replace('{name}', $subscription->name, $m);
        $m = str_replace('{unsubscribe}', $url . 'susep_id=' . $subscription->id . '&susep_t=' . $subscription->token, $m);

        $s = $subject;
        $s = str_replace('{name}', $subscription->name, $s);

        if (susep_mail($subscription->email, $s, $m)) $ok++;
    }
    susep_log('Sent ' . $idx . ' emails. ' . $ok . ' with success');
}

/**
 * Subscribe for a post the user with th email and name passed as parameters.
 */
function susep_subscribe($post_id, $email, $name)
{
    global $susep_options, $wpdb;

    susep_log('Start a new subscription');

    // Checks if the user is already subscribed to this post
    $subscribed = $wpdb->get_var("select count(*) from " . $wpdb->prefix . "comment_notifier where post_id=" . $post_id .
        " and email='" . $email . "'");
    $subscribed1 = $wpdb->get_var("select * from " . $wpdb->prefix . "comment_notifier");
	susep_log(var_export($subscribed1,true));
    // Akready subscribed, go out of there...
    if ($subscribed > 0)
    {
        susep_log('This address is already suscribed');
        return;
    }
    // The random token for unsubscription
    $token = md5(rand());
    $res = $wpdb->get_var("insert into " . $wpdb->prefix . "comment_notifier (post_id, email, name, token) values (" . $post_id . ",'" . $email . "','" . $wpdb->escape($name) . "','" . $token . "')");
	susep_log(var_export($wpdb,true));

}

// Quick check if there is a request of unsubscription
add_action('init', 'susep_init');
/**
 * Called on the initialization of plugins. At this time the plugin check if there
 * a unsubscription request.
 */
function susep_init()
{
    global $susep_options;

    if (!$_GET['susep_id']) return;

    $token = $_GET['susep_t'];
    $id = $_GET['susep_id'];

    susep_unsubscribe($id, $token);

    echo '<html><head>';
    echo '<meta http-equiv="refresh" content="3;url=' . get_option('home') . '"/>';
    echo '</head><body>';
    echo $susep_options['thankyou'];
    echo '</body></html>';
    flush();
    // Have I to call some other function like wp_die()?
    die();
}

/**
 * Removes a subscription.
 */
function susep_unsubscribe($id, $token)
{
    global $susep_options, $wpdb;

    $wpdb->query("delete from " . $wpdb->prefix . "comment_notifier where id='" . $wpdb->escape($id) . "'" .
        " and token='" . $wpdb->escape($token) . "'");

    susep_log('Removed suscription id ' . $id);
}

/**
 * Generica mail sender in plain text or html.
 */
function susep_mail(&$to, &$subject, &$message)
{
    global $susep_options, $wpdb;

    $from = $susep_options['from'];
    $name = $susep_options['name'];

    $headers  = "MIME-Version: 1.0\r\n";
    if ($susep_options['html'])
    {
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    }
    else
    {
        $headers .= "Content-type: text/plain; charset=UTF-8\r\n";
    }
    $headers .= 'From: "' . $name . '" <' . $from . ">\r\n";

    $subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';

    if ($susep_options['sendmail'])
    {
        return mail($to, $subject, $message, $headers, "-f" . $from);
    }
    else
    {
        return mail($to, $subject, $message, $headers);
    }
}


add_action('activate_suscribe_edit_post/plugin.php', 'susep_activate');
function susep_activate()
{
    global $wpdb;
    $wpdb->query("RENAME TABLE " . $wpdb->prefix . "subscriptions TO " . $wpdb->prefix . "comment_notifier");

    // SQL to create the table
    $sql = 'create table if not exists ' . $wpdb->prefix . 'comment_notifier (
        `id` int unsigned not null AUTO_INCREMENT,
        `post_id` int unsigned not null default 0,
        `name` varchar (100) not null default \'\',
        `email` varchar (100) not null default \'\',
        `token` varchar (50) not null default \'\',
        primary key (`id`),
        unique key `post_id_email` (`post_id`,`email`),
        key `token` (`token`)
        )';

    $wpdb->query($sql);


}

add_action('admin_menu', 'susep_admin_menu');
function susep_admin_menu()
{
    add_options_page('Subscribe edit post', 'Subscribe edit post', 'manage_options', 'suscribe_edit_post/options.php');
}

add_filter("plugin_action_links_suscribe_edit_post/plugin.php", 'susep_plugin_action_links');
function susep_plugin_action_links($links)
{
    $settings_link = '<a href="options-general.php?page=suscribe_edit_post/options.php">' . __('Settings') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}

/**
 * Append a line to the log file
 */
function susep_log($text) 
{
	//dump($text);
    global $susep_options;
    if (!$susep_options['logs']) return;
    $file = fopen(dirname(__FILE__) . '/suscribe_edit_post.log', 'a');
    fwrite($file, $text . "\n");
    fclose($file);
}

function dump($var){
	echo "<pre>";
	var_dump($var);
	echo "</pre>";
}

?>
