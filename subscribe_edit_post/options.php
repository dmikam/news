<?php

if (isset($_POST['save']))
{
    $options = susep_request('options');
    susep_check_options($options);
    update_option('susep', $options);
}
else
{
    $options = get_option('susep');
    susep_check_options($options);
}

// Language files inclusion
@include(ABSPATH . 'wp-content/plugins/suscribe_edit_post/en_US.php');
if (WPLANG != '') @include(ABSPATH . 'wp-content/plugins/suscribe_edit_post/' . WPLANG . '.php');

if (isset($_POST['remove_email'])) 
{
    $email = strtolower(trim(susep_request('email')));
    $wpdb->query("delete from " . $wpdb->prefix . "comment_notifier where email='" . $wpdb->escape($email) . "'");
}

if (isset($_POST['remove_post'])) 
{
    $wpdb->query("delete from " . $wpdb->prefix . "comment_notifier where post_id=" . $_POST['id']);
}

if (isset($_POST['import'])) 
{
    $list = $wpdb->get_results("select * from " . $wpdb->prefix . "comments where comment_subscribe='Y' and comment_approved='1'");

    foreach ($list as $r)
    {
        $email = strtolower(trim($r->comment_author_email));
        $post_id = $r->comment_post_ID;
        $name = trim($r->comment_author);
        $token = md5(rand());

        $wpdb->query("insert into " . $wpdb->prefix . "comment_notifier (post_id, email, name, token) values (" . $post_id . ",'" . $email . "','" . $wpdb->escape($name) . "','" . $token . "')");
    }
}

if (isset($_POST['test']))
{
    $options = susep_request('options');
    $options['name'] = str_replace('"', '', $options['name']);
    update_option('susep', $options);



    $message = $options['message'];
    $message = str_replace('{title}', 'A wonderful post title', $message);
    $message = str_replace('{link}', get_option('home'), $message);
    $message = str_replace('{comment_link}', get_option('home'), $message);
    $message = str_replace('{author}', 'Comment author', $message);
    $message = str_replace('{name}', 'Subscriber name', $message);
    $message = str_replace('{unsubscribe}', get_option('home') . '/?' . 'susep_id=fake&susep_t=fake', $message);
    $temp = 'This is a long comment. I like to write unuseful words with my poor english, but I hope you all can understand me. If you can\'t i can speak italian too.';
    if ($options['length'] && strlen($temp) > $options['length'])
    {
        $x = strpos($temp, ' ', $options['length']);
        if ($x !== false) $temp = substr($temp, 0, $x) . '...';
    }
    $message = str_replace('{content}', $temp, $message);

    $subject = $options['subject'];
    $subject = str_replace('{title}', 'A wonderful post title', $subject);
    $subject = str_replace('{author}', 'Comment author', $subject);
    $subject = str_replace('{name}', 'Subscriber name', $subject);

    susep_mail($options['copy'], $subject, $message);
}

function susep_check_options(&$options)
{
    if (trim($options['message']) == '')
    {
        $options['message'] = '
<p>Hi {name},</p>
<p>{author} has just written a new comment on "{title}". Here an excerpt:</p>
<p>{content}</p>
<p>To read more <a href="{comment_link}">click here</a>.</p>
<p>Bye.</p>
<p>To unsubscribe this notification service, <a href="{unsubscribe}">click here</a>.</p>';
    }
    if (trim($options['subject']) == '')
    {
        $options['subject'] = 'A new comment from {author} on "{title}"';
    }
    if (trim($options['thankyou']) == '')
    {
        $options['thankyou'] = 'Your subscription has been removed. In three seconds you will be redirect to the home page. Thank you.';
    }
    if (trim($options['label']) == '')
    {
        $options['label'] = 'Notify me when new comments are added';
    }
    $options['name'] = str_replace('"', '', $options['name']);
}

if ($options['name'] == '') $options['name'] = get_option('blogname');
if ($options['from'] == '') $options['from'] = get_option('admin_email');

?>

<script type="text/javascript">
    function susep_preview()
    {
        var m = document.getElementById("message").value;
        m = m.replace("{content}", "I totally agree with you opinion about Satollo, he's really...");
        var h = window.open("", "susep","status=0,toolbar=0,height=400,width=550");
        var d = h.document;
        d.write('<html><head><title>Email preview</title>');
        d.write('</head><body>');
        d.write('<table width="100%" border="1" cellspacing="0" cellpadding="5">');
        d.write('<tr><td align="right"><b>Subject</b></td><td>' + document.getElementById("subject").value + '</td></tr>');
        d.write('<tr><td align="right"><b>From</b></td><td>' + document.getElementById("from_name").value + ' &lt;' + document.getElementById("from_email").value + '&gt;</td></tr>');
        d.write('<tr><td align="right"><b>To</b></td><td>User name &lt;user@email&gt;</td></tr>');
        d.write('<tr><td align="left" colspan="2">' + m + '</td></tr>');
        d.write('</table>');
        d.write('</body></html>');
        d.close();
        return false;
    }
</script>

<div class="wrap">

    <form action="" method="post">

        <h3>Email management</h3>
        <table class="form-table">
            <tr>
                <td>
                    Remove this email: <input type="text" name="email" size="30"/>
                    <input type="submit" name="remove_email" class="button-secondary" value="Remove"/>
                </td>
            </tr>
            <tr>
                <td>
                    Remove all subscription for post id: <input type="text" name="id" size="5"/>
                    <input type="submit" class="button-secondary" name="remove_post" value="Remove"/>
                </td>
            </tr>
        </table>

        <h3>General options</h3>
        <table class="form-table">
            <tr>
                <td>
                    <input type="checkbox" name="options[active]" value="1" <?php echo $options['active']!= null?'checked':''; ?> />
                    <label for="options[active]">activate the notifier</label>
                </td>
            </tr>

            <tr>
                <td>
                    <?php
                    $commentsphp = @file_get_contents(get_template_directory() . '/comments.php');
                    if (strpos($commentsphp, 'comment_form') === false) {
                        echo '<strong>Your theme seems to NOT have the "comment_form" action call. Read below.</strong><br /><br />';
                    }
                    ?>
                    <input type="checkbox" name="options[checkbox]" value="1" <?php echo $options['checkbox']!= null?'checked':''; ?> />
                    <label for="options[checkbox]">automatically add the subscription checkbox</label><br />
                    <br />

                    Your theme needs to have the call <code>&lt;?php do_action('comment_form', $post->ID); ?&gt;</code> (usually on comments.php
                    theme file). Not all themes have it.<br />
                    If you want to add manually the subscription checkbox use the code an unchecked checkbox<br />
                    <code>&lt;input type="checkbox" value="1" name="subscribe" id="subscribe"/&gt;</code><br />
                    or the one below for a checked checkbox<br />
                    <code>&lt;input type="checkbox" value="1" name="subscribe" id="subscribe" checked="checked"/&gt;</code><br />

                </td>
            </tr>

            <tr>
                <td>
                    <label>"Notify me..." label</label><br />
                    <input name="options[label]" type="text" size="50" value="<?php echo htmlspecialchars($options['label'])?>"/><br />
                    to be printed near the check box (in the blog language)
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" name="options[checked]" value="1" <?php echo $options['checked']!= null?'checked':''; ?> />
                    <label for="options[checked]">default the checkbox to "checked" status</label><br>
                </td>
            </tr>
        </table>

        <h3>Notification email settings</h3>
        <table class="form-table">
            <tr>
                <td>
                    <label>Sender real name</label><br />
                    <input name="options[name]" id="from_name" type="text" size="50" value="<?php echo htmlspecialchars($options['name'])?>"/>
                </td>
            </tr>

            <tr>
                <td>
                    <label>Sender email address</label><br />
                    <input name="options[from]" id="from_email" type="text" size="50" value="<?php echo htmlspecialchars($options['from'])?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Message subject</label><br />
                    <input name="options[subject]" id="subject" type="text" size="70" value="<?php echo htmlspecialchars($options['subject'])?>"/>
                    <br />
                    Tags: {title} - the post title, {name} the subscriber name, {author} - the commenter name
                </td>
            </tr>

            <tr>
                <td>
                    <label>Message body</label><br />
                    <input type="checkbox" name="options[html]" value="1" <?php echo $options['html']!= null?'checked':''; ?> /> send emails as html
                    (<a href="javascript:void(susep_preview());">preview</a>)
                    <br />
                    <textarea name="options[message]" id="message" wrap="off" rows="10" style="width: 500px"><?php echo htmlspecialchars($options['message'])?></textarea>
                    <br />
                    Tags: {name} - the subscriber name, {unsubscribe} - the unsubscription link, {title} - the post title,
                    {author} the commenter name, {link} the post link, {content} - the comment text (eventually
                    truncated)
                </td>
            </tr>
            <tr>
                <td>
                    Truncate the comment text if it's more than
                    <input name="options[length]" type="text" size="5" value="<?php echo htmlspecialchars($options['length'])?>"/>
                    characters long (leave empty to use the full comment text)
                </td>
            </tr>
        </table>

        <h3>Unsubscription setting</h3>
        <table class="form-table">
            <tr>
                <td>
                    <label>Unsubscription message</label><br />
                    <textarea name="options[thankyou]" wrap="off" rows="7" style="width: 500px"><?php echo htmlspecialchars($options['thankyou'])?></textarea>
                    <br />
                    (Example: You have unsubscribe successfully. Thank you. I'll be send to the home page in 3 seconds.)
                </td>
            </tr>
        </table>

        <h3>Advanced settings</h3>
        <table class="form-table">
            <tr>
                <td>
                    <label>Email address where to send a copy of EACH notification and test emails</label><br />
                    <input name="options[copy]" type="text" size="50" value="<?php echo htmlspecialchars($options['copy'])?>"/><br />
                    (Leave empty to disable. Do not use the sender address, some mail servers don't accept "from" and "to" setted
                    to the same value)
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" name="options[logs]" value="1" <?php echo $options['logs']!= null?'checked':''; ?> />
                    <label for="options[logs]">enable logs (used by me when developing)</label>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" name="options[sendmail]" value="1" <?php echo $options['sendmail']!= null?'checked':''; ?> />
                    <label for="options[sendmail]">force the -f parameter to sendmail to adjust the return path</label>
                </td>
            </tr>
        </table>

        <p class="submit">
            <input class="button-primary" type="submit" name="save" value="Save"/>
            <input class="button-primary" type="submit" name="test" value="Save and send a test email"/>
        </p>

    </form>
<h3>Long list of subscribers</h3>
<p>This section is under developement.</p>
                            <ul>
                                <?php
                                $list = $wpdb->get_results("select distinct post_id, count(post_id) as total from " . $wpdb->prefix . "comment_notifier group by post_id order by total desc");

                                foreach ($list as &$r)
                                {
                                    $post = get_post($r->post_id);
                                    $link = get_permalink($r->post_id);
                                    echo '<li><a href="' . $link . '" target="_blank">' . $r->post_id . ' - ' . $post->post_title . '</a>(' . $r->total . ')</li>';
                                    $list2 = $wpdb->get_results("select email from " . $wpdb->prefix . "comment_notifier where post_id=" . $r->post_id);
                                    echo '<ul>';
                                    foreach ($list2 as &$r2)
                                    {
                                        echo '<li>' . $r2->email . '</li>';
                                    }
                                    echo '</ul>';
                                }
                                ?>
                            </ul>
                            

</div>
