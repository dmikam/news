<?
	global $wpdb;
//	$wpdb->show_errors();
   $table_name = $wpdb->prefix . "merge_rss";

	if ($_POST['new_rss']){
		$new_cat		= mss_block($_POST['mss']['category']);
		$new_type	= mss_block($_POST['mss']['type']);
		$new_url		= mss_block($_POST['mss']['url']);
		
/*		$sql = "
			INSERT INTO 
				$table_name
				(url,type,cat)
			VALUES
				('$new_url','$new_type','$new_cat')
		";
		$wpdb->query($sql);
*/
		$wpdb->insert( $table_name, array( 'url' => $new_url, 'type' => $new_type, 'cat' => $new_cat ), array( '%s', '%s', '%s') );
		$wpdb->print_error();
	}
	
	if ($_POST['delete']){
		foreach($_POST['delete'] as $id=>$value){
			$wpdb->query( $wpdb->prepare( "
				DELETE FROM 
					$table_name
				WHERE
					id= %d", 
				$id) 
			);
		}
	}
	
	$categories =	get_categories(array(
							'hide_empty'=>false
							,'hierarchical'=>1
						));
	$cats = array();
	foreach ($categories as $cat){
		$cats[$cat->term_id] = $cat;
	}
	unset($categories);
	
	$sql = "
		SELECT
			id,url,type,cat
		FROM
			$table_name
		ORDER BY 
			id
	";
	$list = $wpdb->get_results($sql);
?>
<div class="wrap">
	<h2>Merge RSS options page</h2>
	<form method="post" action="options.php">
<?php
		wp_nonce_field('update-options'); 
		settings_fields('mss-opt' );
?>
		<p>version: <?php echo $mss_opt['version']?></p>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Cantidad de articulos de RSS para mostrar</th>
				<td><input type="text" name="mss_opt[count]" value="<?php echo $mss_opt['count']; ?>" /></td>
			</tr>
			<tr valign="top">
				<th scope="row">Loguear todos eventos</th>
				<td><input type="checkbox" name="mss_opt[log]" value="1" <?php echo $mss_opt['log']? 'checked="checked"' : '' ; ?>" /></td>
			</tr>
		</table>
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="mss_opt" />
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
	
	<h2>Añadir RSS</h2>
	<form method="post" action="">
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Categoría</th>
				<th scope="row">Tipo</th>
				<th scope="row">URL</th>
			</tr>
			<tr valign="top">
				<td>
					<select name="mss[category]">
<?php					echo hierarhical_select($cats);		?>
					</select>
				</td>
				<td>
					<select name="mss[type]" >
						<option value="internal">Blogs propios</option>
						<option value="external">Blogs ajenos</option>
						<option value="blog">Blogs en primera voz</option>
					</select>
				</td>
				<td><input type="text"	name="mss[url]"	value=""	size="75" /></td>
			</tr>
		</table>
		<input type="hidden" name="new_rss" value="1" />
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
	<form method="post" action="">
		<table class="form-table">
			<tr><th>Categoría</th><th>Tipo</th><th>URL de RSS</th><th>Quitar</th></tr>
<?php		foreach($list as $item){		?>
			<tr><td><?php echo $item->cat;?></td><td><?php echo $item->type;?></td><td><?php echo $item->url;?></td><td><input type="submit" name="delete[<?php echo $item->id;?>]" value="Eliminar" /></td></tr>
<?php		}		?>
		</table>
	</form>
</div>

<?php 
//$a = mss_get_rss('conflicto','internal');
//dump($a);
?>
