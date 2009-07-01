<?php
	if (is_category()){
		$cat = get_category(intval(get_query_var('cat')));
		$mss = mss_get_rss($cat->slug,'blog');
		if (!empty($mss)){
?>
		<h2 class="title">
			Lista RSS
		</h2>
		<div class="entry">
			<dl class="rss_list">
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