<?php // Do not delete these lines
	if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Por favor, no cargue esta página directamente.');
	
	if ( post_password_required() ) { ?>
		<p class="nocomments">Esta noticia está protegida por contraseña. Introdúzcala para ver los comentarios</p> 
	<?php
		return;
	}
	?>

<?php if ( have_comments() ) : ?>
	<div id="comments-title">
		<h3 id="comments"><?php comments_number('Sin comentarios','1 comentario','% comentarios');?> </h3>
	</div>
	
	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>

	<ol class="commentlist">
	<?php wp_list_comments("callback=comentarios");?>
	</ol>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>

 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">Los comentarios están cerrados</p>

	<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>

<div id="respond">

<h3 id="leave_comment"><?php comment_form_title('Deja un comentario', 'Deja una respuesta a %s'); ?> <?php cancel_comment_reply_link() ?></h3>


<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php printf('Debe <a href="%s" class="thickbox">iniciar sesión</a> para escribir un comentario.', get_option('siteurl') . '/iniciar-sesion/?height=220&amp;width=350&amp;redirect_to=' . urlencode(get_permalink())); ?></p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<div id="subform">
<?php if ( !$user_ID ) : ?>

	<p><?php printf('¡Hola <strong><a href="%1$s">%2$s</a></strong>!', get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Desconecta">Desconecta</a></p>

	<?php else : ?>

	<p><label for="author">Nombre <?php if ($req) "(obligatorio)" ?></label><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
	</p>

	<p><label for="email">Correo electrónico (nadie lo verá) <?php if ($req) "(obligatorio)"; ?></label><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
	</p>

	<p><label for="url">Web</label><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
	</p>

	<?php endif; ?>


	<p><label for="comment">Comentario</label><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>

	<p><input name="submit" type="submit" id="submit" tabindex="5" value="Publicar comentario" />
	</div>
<?php comment_id_fields(); ?> 
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>
</div>

<?php endif; // if you delete this the sky will fall on your head ?>