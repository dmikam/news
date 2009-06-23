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
				<th scope="row">&nbsp;</th>
				<th scope="row">Categoría</th>
				<th scope="row">Tipo</th>
				<th scope="row">URL</th>
			</tr>
			<tr valign="top">
				<td><input type="radio"	name="mss[new]" 				value="1"></td>
				<td><input type="text"	name="mss[category][1]"		value=""	size="15" /></td>
				<td><input type="text"	name="mss[type][1]"			value=""	size="5"/></td>
				<td><input type="text"	name="mss[url][1]"			value=""	size="50" /></td>
			</tr>
			<tr valign="top">
				<th scope="row" colspan="4">o</th>
			</tr>
			<tr valign="top">
				<th scope="row">&nbsp;</th>
				<th scope="row">Categoría</th>
				<th scope="row">Tipo</th>
				<th scope="row">URL</th>
			</tr>
			<tr valign="top">
				<td><input type="radio"	name="mss[new]" 				value="0"></td>
				<td><input type="text"	name="mss[category][1]"		value=""	size="15" /></td>
				<td><input type="text"	name="mss[type][1]"			value=""	size="5"/></td>
				<td><input type="text"	name="mss[url][1]"			value=""	size="50" /></td>
			</tr>
		</table>
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="mss_opt" />
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
		
	</form>
</div>
