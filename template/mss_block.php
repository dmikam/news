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

<?php
		}
			$mss = mss_get_rss($cat->slug,'internal');
			if (!empty($mss)){
	?>
			<h3>
				Enfoques
			</h3>
			<div id="external_rss" class="block">
				<? $cnt=0; ?>
	<?php		foreach ($mss as $item){		?>
				<div class="rss_item rss_item_<? echo $cnt; ?>">
						<?php if (!empty($item['image_url'])){	?>
							<div class="rss_item_image"><img src="<?php echo $item['image_url'] ?>" alt="<?php echo $item['rss_title'] ?>" /></div>
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

	<?php
			}
				$mss = mss_get_rss($cat->slug,'blog');
				if (!empty($mss)){
		?>
				<h3 id="primera-voz-title">
					En primera voz
				</h3>
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

		<?php
				}
	}
?>
