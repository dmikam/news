<?php
	global $wpdb;
	$maxlen = 400;

	if (is_category()){
		$cat = get_category(intval(get_query_var('cat')));
		//dump($cat);
		$cat_slug = $wpdb->escape($cat->slug);
	} 

	if (is_home()) {
		$res = &get_bicat_links('portada','enlaces-propios');
	} else {
		$res = &get_bicat_links(intval(get_query_var('cat')),'enlaces-propios');
	}
	if ($res){
?>
		<h3>
			Blogs en enfoque19
		</h3>
		<div id="internal_blogs" class="links block">
			<dl class="links_list">
<?php		
			foreach ($res as $item){
?>
				<dt><a href="<?php echo $item->link_url;?>" target="<?php echo $item->link_target;?>"><?php echo $item->link_name;?></a></dt>
				<dd>
<?php			if (!empty($item->link_image)){		?>
					<img class="link_image right" scr="<?php echo $item->link_image;?>" alt="<?php echo $item->link_name;?>" title="<?php echo $item->link_name;?>" />
<?php			}		?>
					<div class="link_description">
<?php				excerpt($item->link_description);		?>
					</div>
				</dd>
<?php		}		?>
			</dl>
		</div>
<?php
	}
	
	
	if (is_home()) {
		$res = &get_bicat_links('portada','enlaces-externos');
	} else {
		$res = &get_bicat_links(intval(get_query_var('cat')),'enlaces-externos');
	}
	if ($res){
?>

		<h3> Blogs en internet </h3>
		<div id="external_blogs" class="links block">
			<dl class="links_list">
<?php
		
		foreach ($res as $item){
?>
				<dt><a href="<?php echo $item->link_url;?>" target="<?php echo $item->link_target;?>"><?php echo $item->link_name;?></a></dt>
				<dd>
<?php			if (!empty($item->link_image)){		?>
					<img class="link_image right" scr="<?php echo $item->link_image;?>" alt="<?php echo $item->link_name;?>" title="<?php echo $item->link_name;?>" />
<?php			}		?>
					<div class="link_description">
<?php				excerpt($item->link_description);		?>
					</div>
				</dd>
<?php
		}
?>	
			</dl>
		</div>
<?php
	}
?>

<?
	if (is_home()) {
		$res = &get_bicat_links('portada','orgranizaciones');
	} else {
		$res = &get_bicat_links(intval(get_query_var('cat')),'organizaciones');
	}
	if ($res){
?>
		<h3> Organizaciones </h3>
		<div id="organizations_links" class="links block">
			<dl class="links_list">
<?php
		
		foreach ($res as $item){
?>
				<dt><a href="<?php echo $item->link_url;?>" target="<?php echo $item->link_target;?>"><?php echo $item->link_name;?></a></dt>
				<dd>
<?php			if (!empty($item->link_image)){		?>
					<img class="link_image right" scr="<?php echo $item->link_image;?>" alt="<?php echo $item->link_name;?>" title="<?php echo $item->link_name;?>" />
<?php			}		?>
					<div class="link_description">
<?php				excerpt($item->link_description);		?>
					</div>
				</dd>
<?php
		}
?>	
			</dl>
		</div>
<?php
	}
?>