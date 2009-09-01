<?php
	if (is_category()){
		$cat = get_category(intval(get_query_var('cat')));
		$mss = mss_get_rss($cat->slug,'external');
		if (!empty($mss)){
?>
		<h3>
			Blogs externos
		</h3>
		<div id="external_rss" class="block">
			<dl class="links_list rss_list">
<?php		foreach ($mss as $item){		?>
				<dt><a href="<?php echo $item['link']; ?>" target="_blank"><?php echo $item['title']; ?></a></dt>
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
	<?php		foreach ($mss as $item){		?>
					<dt><a href="<?php echo $item['link']; ?>" target="_blank"><?php echo $item['title']; ?></a></dt>
					<dd><?php echo excerpt(strip_tags($item['description']),300); ?></dd>
	<?php		}		?>
				</dl>
			</div>

	<?php
			}
				$mss = mss_get_rss($cat->slug,'blog');
				if (!empty($mss)){
		?>
				<h3>
					En primera voz
				</h3>
				<div id="external_rss" class="block">
					<dl class="links_list rss_list">
		<?php		foreach ($mss as $item){		?>
						<dt><a href="<?php echo $item['link']; ?>" target="_blank"><?php echo $item['title']; ?></a></dt>
						<dd><?php echo excerpt(strip_tags($item['description']),300); ?></dd>
		<?php		}		?>
					</dl>
				</div>

		<?php
				}
	}
?>