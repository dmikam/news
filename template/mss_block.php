<?php
if (is_category() || is_home()){
		if (is_home()){
			$cat = get_category_by_slug('home');
		}else{
			$cat = get_category(intval(get_query_var('cat')));
		}
		$mss = mss_get_rss($cat->slug,'external');
		if (!empty($mss)){
?>
		<h3>
			Blogs externos
		</h3>
		<div id="external_rss" class="block">
			<dl class="links_list rss_list">
<?php		foreach ($mss as $item){		?>
				<dt>
					<a href="<?php echo $item['link']; ?>" target="_blank"><?php echo $item['title']; ?></a>
<?php				if (!empty($item['rss_title'])){			?>
					<div class="mss_item_title"><?php echo $item['rss_title'] ?></div>
<?					} 		?>
<?php				if (!empty($item['image_url'])){			?>
					<div class="mss_item_image"><img src="<?php echo $item['image_url'] ?>" alt="image" /></div>
<?					} 		?>
				</dt>
				<dd><?php echo excerpt(strip_tags($item['description']),300); ?></dd>
<?php		}		?>
			</dl>
		</div>

<?php
		}
			$mss = mss_get_rss($cat->slug,'internal');
			if (!empty($mss)){
	?>
			<h3>
				Blogs internos
			</h3>
			<div id="external_rss" class="block">
				<dl class="links_list rss_list">
<?php			foreach ($mss as $item){		?>
					<dt>
						<a href="<?php echo $item['link']; ?>" target="_blank"><?php echo $item['title']; ?></a>
<?php				if (!empty($item['rss_title'])){			?>
					<div class="mss_item_title"><?php echo $item['rss_title'] ?></div>
<?					} 		?>
<?php				if (!empty($item['image_url'])){			?>
					<div class="mss_item_image"><img src="<?php echo $item['image_url'] ?>" alt="image" /></div>
<?					} 		?>						
					</dt>
					<dd><?php echo excerpt(strip_tags($item['description']),300); ?></dd>
	<?php		}		?>
				</dl>
			</div>

	<?php
			}
				$mss = mss_get_rss($cat->slug,'blog');
				if (!empty($mss)){
		?>
				<h3 id="primera-voz-title">
					En primera voz
				</h3>
				<div id="external_rss" class="block">
					<dl class="links_list rss_list">
		<?php		foreach ($mss as $item){		?>
						<dt>
							<a href="<?php echo $item['link']; ?>" target="_blank"><?php echo $item['title']; ?></a>
<?php				if (!empty($item['rss_title'])){			?>
					<div class="mss_item_title"><?php echo $item['rss_title'] ?></div>
<?					} 		?>
<?php				if (!empty($item['image_url'])){			?>
					<div class="mss_item_image"><img src="<?php echo $item['image_url'] ?>" alt="image" /></div>
<?					} 		?>

						</dt>
						<dd><?php echo excerpt(strip_tags($item['description']),300); ?></dd>
		<?php		}		?>
					</dl>
				</div>

		<?php
				}
	}
?>
