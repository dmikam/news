<?
	global $wpdb;
	$wpdb->show_errors();
   $table_name = $wpdb->prefix . "merge_rss";

	if ($_POST['new_rss']){
		$new_cat		= mss_block($_POST['mss']['category']);
		$new_type	= mss_block($_POST['mss']['type']);
		$new_url		= mss_block($_POST['mss']['url']);
		$new_title	= mss_block($_POST['mss']['title']);
		$new_image_url		= mss_block($_POST['mss']['image_url']);
		
		$wpdb->insert( $table_name, array( 'url' => $new_url, 'type' => $new_type, 'cat' => $new_cat, 'title' => $new_title, 'image_url' => $new_image_url ), array( '%s', '%s', '%s', '%s', '%s') );
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

	if ($_POST['edit']){
		foreach ($_POST['edit'] as $id=>$value) {
			$id = (int)$id;
			$sql = "
				SELECT
					id,url,type,cat,title,image_url
				FROM
					$table_name
				WHERE
					id = $id
			";
			$edit_mss = $wpdb->get_row($sql);
		}
	}

	if ($_POST['update_rss']){
		foreach($_POST['update_rss'] as $id=>$value){
			$new_cat		= mss_block($_POST['mss']['category']);
			$new_type	= mss_block($_POST['mss']['type']);
			$new_url		= mss_block($_POST['mss']['url']);
			$new_title	= mss_block($_POST['mss']['title']);
			$new_image_url		= mss_block($_POST['mss']['image_url']);
			$id = (int)$id;
			$wpdb->update( $table_name	,/*SET*/				array( 'url' => $new_url, 'type' => $new_type, 'cat' => $new_cat, 'title' => $new_title, 'image_url' => $new_image_url )
												,/*WHERE*/			array('id'=>$id)
												,/*VALIDATION*/	array( '%s', '%s', '%s', '%s', '%s')
												,/*VALIDATION*/	array( '%d')
			);
			$wpdb->print_error();
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
			id,url,type,cat,title,image_url
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

		<p>Version: <?php echo $mss_opt['version']?></p>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Cantidad de articulos de RSS para mostrar</th>
				<td><input type="text" name="mss_opt[count]" value="<?php echo $mss_opt['count']; ?>" /></td>
			</tr>
			<!--tr valign="top">
				<th scope="row">Loguear todos eventos</th>
				<td><input type="checkbox" name="mss_opt[log]" value="1" <?php echo $mss_opt['log']? 'checked="checked"' : '' ; ?> /></td>
			</tr-->
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
				<th scope="row">Title</th>
				<td><input type="text"	name="mss[title]"	value="<?php echo (empty($edit_mss) ? '' : $edit_mss->title )?>"	size="40" /></td>
			</tr>
		</table>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Categoría</th>
				<th scope="row">Tipo</th>
				<th scope="row">URL</th>
			</tr>
			<tr valign="top">
				<td>
					<select name="mss[category]">
<?php					echo hierarhical_select($cats,0,0,(empty($edit_mss) ? 0 : $edit_mss->cat ));		?>
					</select>
				</td>
				<td>
					<select name="mss[type]" >
<?php
				$phtypes = array('internal'=>'Enfoques','external'=>'De referencia', 'blog'=>'Sociedad civil');
				foreach ($phtypes as $key=>$value) {
?>
						<option value="<?php echo $key; ?>" <?php echo ((!empty($edit_mss) && $edit_mss->type==$key) ? 'selected="selected"' : '' )?>><?php echo $value; ?></option>
<?php					
				}
?>

					</select>
				</td>
				<td><input type="text"	name="mss[url]"	value="<?php echo (empty($edit_mss) ? '' : $edit_mss->url )?>"	size="65" /></td>
			</tr>
		</table>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Imagen</th>
				<td><input type="text" name="mss[image_url]"	value="<?php echo (empty($edit_mss) ? '' : $edit_mss->image_url )?>"	size="60" onblur="document.getElementById('new_mss_image').src=this.value;" /></td>
				<td><img src="<?php echo (empty($edit_mss) ? '' : $edit_mss->image_url )?>" id="new_mss_image" style="max-height:25px;"	/></td>
			</tr>
		</table>
<?php
		if (isset($edit_mss)){
?>
		<input type="hidden" name="update_rss[<?php echo $edit_mss->id;?>]" value="1" />
<?php
		}else{
?>
		<input type="hidden" name="new_rss" value="1" />
<?php
		}
?>
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
	<form method="post" action="">
		<table class="form-table">
			<tr><th>Título</th><th>Categoría</th><th>Tipo</th><th>URL de RSS</th><th>Imágen</th><th>Editar</th><th>Quitar</th></tr>
<?php		foreach($list as $item){		?>
			<tr>
				<td><?php echo $item->title;?></td>
				<td><?php echo $item->cat;?></td>
				<td><?php echo $phtypes[$item->type];?></td>
				<td><?php echo $item->url;?></td>
				<td><img src="<?php echo $item->image_url;?>" title="<?php echo $item->image_url;?>" alt="<?php echo $item->image_url;?>" style="max-height:25px;"></a></td>
				<td><input type="submit" name="edit[<?php echo $item->id;?>]" value="Editar" /></td>
				<td><input type="submit" name="delete[<?php echo $item->id;?>]" value="Eliminar" /></td>
			</tr>
<?php		}		?>
		</table>
	</form>
</div>

<?php 
//$a = mss_get_rss('conflicto','internal');
//dump($a);
?>
