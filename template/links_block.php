<?php
	global $wpdb;
	$maxlen = 400;

	if (is_category()){
		$cat = get_category(intval(get_query_var('cat')));
		//dump($cat);
		$cat_slug = $wpdb->escape($cat->slug);
	}
	$res = &get_bicat_links(intval(get_query_var('cat')),'enlaces-propios');
	if ($res){
?>
		<h2 class="title">
			Enlaces Internos
		</h2>
		<div class="entry">
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
	
	
	$res = &get_bicat_links(intval(get_query_var('cat')),'enlaces-externos');
	if ($res){
?>

		<h2 class="title">
			Enlaces Externos
		</h2>
		<div class="entry">
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
