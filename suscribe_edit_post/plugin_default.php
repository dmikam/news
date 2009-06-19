<?php
/*
Plugin Name: Comment Notifier
Plugin URI: http://www.satollo.net/plugins/comment-notifier
Description: Let blog users to subscribe to comments threads, receiving an email in their mailbox on new comments.
Version: 2.0.3
Author: Satollo
Author URI: http://www.satollo.net
Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
*/

/*	Copyright 2008  Satollo  (email : info@satollo.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

$cmnt_options = get_option('cmnt');

if ($cmnt_options['active'])
{
    add_action('comment_form', 'cmnt_comment_form', 99);
    add_action('wp_set_comment_status', 'cmnt_wp_set_comment_status', 10, 2);
    add_action('comment_post', 'cmnt_comment_post', 10, 2);
}

function cmnt_request($name, $default=null)
{
    if (!isset($_POST[$name]))
    {
        return $default;
    }
    if (get_magic_quotes_gpc())
    {
        return cmnt_stripslashes($_POST[$name]);
    }
    else
    {
        return $_POST[$name];
    }
}

function cmnt_stripslashes($value)
{
    $value = is_array($value) ? array_map('cmnt_stripslashes', $value) : stripslashes($value);
    return $value;
}

/**
 * Called when a comment is added to a post with its status: '0' - in moderation,
 * '1' - approved, 'spam' if it is spam. The comment_id is the database id of the
 * comment which is already saved a this point.
 */
function cmnt_comment_post($comment_id, $status)
{
    cmnt_log('New comment posted, id: ' . $comment_id . ', status: ' . $status);
    cmnt_log('Subscribe checkbox status (empty -> not set): ' . $_POST['subscribe']);

    // Checks if there is a subscription request, comments are always sent with
    // POST requests. The '$POST' contains all the values sent by commenters:
    // 'email', 'author', 'comment_post_ID', ...
    if (($status == 0 || $status == 1) && $_POST['subscribe'])
    {
        cmnt_log('Going on with subscription');

        // Get the post id: it is in the POST parameter set as "comment_post_ID". There is no need to execute queries!
        // Email is already valid, Wordpress checks it before to add a comment to the db...)
        $email = strtolower(trim($_POST['email']));
        $post_id = $_POST['comment_post_ID'];
        $name = $_POST['author'];

        cmnt_subscribe($post_id, $email, $name);
    }

    // Notify if the comment is already approved
    if ($status == 1)
    {
        cmnt_notify($comment_id);
    }
}

/**
 * Called when a comment is changed of status (usually by an action of the administrator).
 * The status is a string of 'hold', 'approve', 'spam', or 'delete'.
 */
function cmnt_wp_set_comment_status($comment_id, $status)
{
    cmnt_log('Comment ' . $comment_id . ' status changed to: ' . $status);
    // When a comment is approved the subscribers are notified
    if ($status == 'approve')
    {
        cmnt_notify($comment_id);
    }
}

/**
 * Add a subscribe checkbox after the form content if the theme calls the right function
 * and the user want the checkbox automatically added. The options panel checks the theme
 * compatibility.
 */
function cmnt_comment_form()
{
    global $cmnt_options;

    if ($cmnt_options['checkbox'])
    {
        if ($cmnt_options['label'] == '') $cmnt_options['label'] = 'Notify me of new comments';
        echo '<p><input type="checkbox" value="1" name="subscribe" id="subscribe"';
        if ($cmnt_options['checked'])
        {
            echo ' checked="checked"';
        }
        echo '/>&nbsp;<label for="subscribe">' . $cmnt_options['label'] . '</label></p>';
    }
    $comment = $pstl_options['comment_form'];
    echo $comment;
}

/**
 * Sends out the notification of a new comment for subscribers. This is the core function
 * of this plugin. The notification is not sent to the email address of the author
 * if the comment.
 */
function cmnt_notify($comment_id)
{
    global $cmnt_options, $wpdb;

    if (!$cmnt_options['active']) return;

    $comment = get_comment($comment_id);

    if ($comment->comment_type == 'trackback' || $comment->comment_type == 'pingback')
    {
        cmnt_log('Notify blocked, comment type: ' . $comment->comment_type);
        return;
    }

    $post_id = $comment->comment_post_ID;
    $email = strtolower(trim($comment->comment_author_email));

    cmnt_log('Sending notifications for post: ' . $post_id);

    $subscriptions = $wpdb->get_results("select * from " . $wpdb->prefix . "comment_notifier where post_id=" . $post_id .
        " and email<>'" . $wpdb->escape($email) . "'");

    if (!$subscriptions)
    {
        cmnt_log('No suscriptions found for post ' . $post_id);
        return;
    }

    $post = get_post($post_id);
    $title = $post->post_title;
    $link = get_permalink($post_id);
    //$comment_link = $link . '?cid=' . $comment_id . '#comment-' . $comment_id;
    $comment_link = $link . '#comment-' . $comment_id;

    $comment = get_comment($comment_id);

    $message = $cmnt_options['message'];
    $message = str_replace('{title}', $title, $message);
    $message = str_replace('{link}', $link, $message);
    $message = str_replace('{comment_link}', $comment_link, $message);
    $message = str_replace('{author}', $comment->comment_author, $message);
    $temp = strip_tags($comment->comment_content);
    if ($cmnt_options['length'] && strlen($temp) > $cmnt_options['length'])
    {
        $x = strpos($temp, ' ', $cmnt_options['length']);
        if ($x !== false) $temp = substr($temp, 0, $x) . '...';
    }
    $message = str_replace('{content}', $temp, $message);

    $subject = $cmnt_options['subject'];
    $subject = str_replace('{title}', $title, $subject);
    $subject = str_replace('{author}', $comment->comment_author, $subject);
    $url = get_option('home') . '/?';

    if (trim($cmnt_options['copy']) != '')
    {
        cmnt_log('Send notification copy to test user');
        $m = $message;
        $m = str_replace('{name}', 'copy', $m);
        $m = str_replace('{unsubscribe}', $url . 'cmnt_id=0&cmnt_t=0', $m);

        $s = $subject;
        $s = str_replace('{name}', 'copy', $s);

        cmnt_mail($cmnt_options['copy'], $s, $m);
    }

    $idx = 0;
    $ok = 0;
    foreach ($subscriptions as $subscription)
    {
        $idx++;
        $m = $message;
        $m = str_replace('{name}', $subscription->name, $m);
        $m = str_replace('{unsubscribe}', $url . 'cmnt_id=' . $subscription->id . '&cmnt_t=' . $subscription->token, $m);

        $s = $subject;
        $s = str_replace('{name}', $subscription->name, $s);

        if (cmnt_mail($subscription->email, $s, $m)) $ok++;
    }
    cmnt_log('Sent ' . $idx . ' emails. ' . $ok . ' with success');
}

/**
 * Subscribe for a post the user with th email and name passed as parameters.
 */
function cmnt_subscribe($post_id, $email, $name)
{
    global $cmnt_options, $wpdb;

    cmnt_log('Start a new subscription');

    // Checks if the user is already subscribed to this post
    $subscribed = $wpdb->get_var("select count(*) from " . $wpdb->prefix . "comment_notifier where post_id=" . $post_id .
        " and email='" . $email . "'");

    // Akready subscribed, go out of there...
    if ($subscribed > 0)
    {
        cmnt_log('This address is already suscribed');
        return;
    }
    // The random token for unsubscription
    $token = md5(rand());
    $res = $wpdb->query("insert into " . $wpdb->prefix . "comment_notifier (post_id, email, name, token) values (" . $post_id . ",'" . $email . "','" . $wpdb->escape($name) . "','" . $token . "')");


}

// Quick check if there is a request of unsubscription
add_action('init', 'cmnt_init');
/**
 * Called on the initialization of plugins. At this time the plugin check if there
 * a unsubscription request.
 */
function cmnt_init()
{
    global $cmnt_options;

    if (!$_GET['cmnt_id']) return;

    $token = $_GET['cmnt_t'];
    $id = $_GET['cmnt_id'];

    cmnt_unsubscribe($id, $token);

    echo '<html><head>';
    echo '<meta http-equiv="refresh" content="3;url=' . get_option('home') . '"/>';
    echo '</head><body>';
    echo $cmnt_options['thankyou'];
    echo '</body></html>';
    flush();
    // Have I to call some other function like wp_die()?
    die();
}

/**
 * Removes a subscription.
 */
function cmnt_unsubscribe($id, $token)
{
    global $cmnt_options, $wpdb;

    $wpdb->query("delete from " . $wpdb->prefix . "comment_notifier where id='" . $wpdb->escape($id) . "'" .
        " and token='" . $wpdb->escape($token) . "'");

    cmnt_log('Removed suscription id ' . $id);
}

/**
 * Generica mail sender in plain text or html.
 */
function cmnt_mail(&$to, &$subject, &$message)
{
    global $cmnt_options, $wpdb;

    $from = $cmnt_options['from'];
    $name = $cmnt_options['name'];

    $headers  = "MIME-Version: 1.0\r\n";
    if ($cmnt_options['html'])
    {
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    }
    else
    {
        $headers .= "Content-type: text/plain; charset=UTF-8\r\n";
    }
    $headers .= 'From: "' . $name . '" <' . $from . ">\r\n";

    $subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';

    if ($cmnt_options['sendmail'])
    {
        return mail($to, $subject, $message, $headers, "-f" . $from);
    }
    else
    {
        return mail($to, $subject, $message, $headers);
    }
}


add_action('activate_comment-notifier/plugin.php', 'cmnt_activate');
function cmnt_activate()
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

add_action('admin_menu', 'cmnt_admin_menu');
function cmnt_admin_menu()
{
    add_options_page('Comment Notifier', 'Comment Notifier', 'manage_options', 'comment-notifier/options.php');
}

add_filter("plugin_action_links_comment-notifier/plugin.php", 'cmnt_plugin_action_links');
function cmnt_plugin_action_links($links)
{
    $settings_link = '<a href="options-general.php?page=comment-notifier/options.php">' . __('Settings') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}

/**
 * Append a line to the log file
 */
function cmnt_log($text) 
{
    global $cmnt_options;
    if (!$cmnt_options['logs']) return;
    $file = fopen(dirname(__FILE__) . '/comment-notifier.log', 'a');
    fwrite($file, $text . "\n");
    fclose($file);
}

?>