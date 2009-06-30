<?php
	global $wpdb;
	if (is_category()){
		$cat = get_category(intval(get_query_var('cat')));
		//dump($cat);
		$cat_slug = $wpdb->escape($cat->slug);
	}
?>
		<h2 class="title">
			<a href="" title="Enlace a "></a>
		</h2>
		<div class="entry">
			<ul class="links_list">
		<li><h4>INTERNOS</h4></li>
<?php

		$res = &get_bicat_links(intval(get_query_var('cat')),'enlaces-propios');
		
		foreach ($res as $item){
?>
		<li><a href="<?php echo $item->link_url;?>" target="<?php echo $item->link_target;?>"><?php echo $item->link_name;?></a>
<?php		if (!empty($item->link_image)){		?>
				<img class="link_image right" scr="<?php echo $item->link_image;?>" alt="<?php echo $item->link_name;?>" title="<?php echo $item->link_name;?>" />
<?php		}		?>
			<div class="link_description">
<?php
				$maxlen = 400;
				if (strlen($item->link_description)<=$maxlen){
					echo $item->link_description;
				}else{
					echo substr($item->link_description,0,strpos($item->link_description,' ',$maxlen)).(strlen($item->link_description)>$maxlen? " [...]":"");
				}
?>
			</div>
		</li>
		<li><h4>EXTERNOS</h4></li>
<?php
		}

		$res = &get_bicat_links(intval(get_query_var('cat')),'enlaces-externos');
		
		foreach ($res as $item){
?>
		<li><a href="<?php echo $item->link_url;?>" target="<?php echo $item->link_target;?>"><?php echo $item->link_name;?></a>
<?php		if (!empty($item->link_image)){		?>
				<img class="link_image right" scr="<?php echo $item->link_image;?>" alt="<?php echo $item->link_name;?>" title="<?php echo $item->link_name;?>" />
<?php		}		?>
			<div class="link_description">
<?php
				$maxlen = 400;
				if (strlen($item->link_description)<=$maxlen){
					echo $item->link_description;
				}else{
					echo substr($item->link_description,0,strpos($item->link_description,' ',$maxlen)).(strlen($item->link_description)>$maxlen? " [...]":"");
				}
?>
			</div>
		</li>
<?php
		}
?>	
			</ul>
		</div>
