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



function susep_notify($comment_id){
	global $susep_opt, $wpdb;

	$comment = get_comment($comment_id);

	if ($comment->comment_type == 'trackback' || $comment->comment_type == 'pingback'){
		susep_log('Notify blocked, comment type: ' . $comment->comment_type);
		return;
	}

	$post_id = $comment->comment_post_ID;
	$email = strtolower(trim($comment->comment_author_email));

	$subscriptions = $wpdb->get_results("select * from " . $wpdb->prefix . "comment_notifier where post_id=" . $post_id .
		" and email<>'" . $wpdb->escape($email) . "'");

	if ($subscriptions){
		$post = get_post($post_id);
		$title = $post->post_title;
		$link = get_permalink($post_id);
		$comment_link = $link . '#comment-' . $comment_id;

		$comment = get_comment($comment_id);

		$message = $susep_opt['message'];
		$message = str_replace('{title}', $title, $message);
		$message = str_replace('{link}', $link, $message);
		$message = str_replace('{comment_link}', $comment_link, $message);
		$message = str_replace('{author}', $comment->comment_author, $message);
		$temp = strip_tags($comment->comment_content);
		if ($susep_opt['length'] && strlen($temp) > $susep_opt['length']){
			$x = strpos($temp, ' ', $susep_opt['length']);
			if ($x !== false) $temp = substr($temp, 0, $x) . '...';
		}
		$message = str_replace('{content}', $temp, $message);

		$subject = $susep_opt['subject'];
		$subject = str_replace('{title}', $title, $subject);
		$subject = str_replace('{author}', $comment->comment_author, $subject);
		$url = get_option('home') . '/?';

		if (trim($susep_opt['copy']) != ''){
			$m = $message;
			$m = str_replace('{name}', 'copy', $m);
			$m = str_replace('{unsubscribe}', $url . 'susep_id=0&susep_t=0', $m);

			$s = $subject;
			$s = str_replace('{name}', 'copy', $s);

			susep_mail($susep_opt['copy'], $s, $m);
		}

		$idx = 0;
		$ok = 0;
		foreach ($subscriptions as $subscription){
			$idx++;
			$m = $message;
			$m = str_replace('{name}', $subscription->name, $m);
			$m = str_replace('{unsubscribe}', $url . 'susep_id=' . $subscription->id . '&susep_t=' . $subscription->token, $m);

			$s = $subject;
			$s = str_replace('{name}', $subscription->name, $s);

			if (susep_mail($subscription->email, $s, $m)){
				ok++;
			}
		}
	}
}


/**
 * Generica mail sender in plain text or html.
 */
function susep_mail(&$to, &$subject, &$message){
    global $susep_opt, $wpdb;

    $from = $susep_opt['from'];
    $name = $susep_opt['name'];

    $headers  = "MIME-Version: 1.0\r\n";
    if ($susep_opt['html'])
    {
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    }
    else
    {
        $headers .= "Content-type: text/plain; charset=UTF-8\r\n";
    }
    $headers .= 'From: "' . $name . '" <' . $from . ">\r\n";

    $subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';

    if ($susep_opt['sendmail'])
    {
        return mail($to, $subject, $message, $headers, "-f" . $from);
    }
    else
    {
        return mail($to, $subject, $message, $headers);
    }
}

?>