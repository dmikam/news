<?php
		$cat = get_category(intval(get_query_var('cat')));
		$mss = mss_get_rss($cat->slug,'blog',100);
?>
<?php get_header() ?>
<div id="container" class="clearfix">
	<div id="content" class="enfoques clearfix">
		<h2>
			Enfoques
		</h2>
		<div id="external_rss" class="block">
			<? $cnt=0; ?>
<?php		foreach ($mss as $item){		?>
			<div class="rss_item rss_item_<? echo $cnt; ?>">
					<?php if (!empty($item['image_url'])){	?>
						<div class="rss_item_image"><img src="<?php echo $item['image_url'] ?>" alt="image" /></div>
					<?	}  ?>
					<h4 class="rss_title">
						<?php if (!empty($item['rss_title'])){ ?>
							<span class="rss_item_title"> <?php echo $item['rss_title'] ?> </span>
						<?	} ?>
						<a href="<?php echo $item['link']; ?>" target="_blank"><?php echo $item['title']; ?></a>
					</h4>
					<div class="rss_entry"><?php echo excerpt(strip_tags($item['description']),150); ?></div>
			</div>
			<? $cnt++; ?>
<?php		}		?>
		</div>



	</div>
</div>
<?php get_footer() ?>