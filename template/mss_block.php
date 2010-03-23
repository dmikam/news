<?php
if (is_category() || is_home() || is_single()){
		if (is_home()){
			$cat = get_category_by_slug('home');
		} elseif (is_category()) {
			$cat = get_category(intval(get_query_var('cat')));
		} elseif (is_single()) {
			$cats = get_the_category(); 
			foreach ($cats as $cat) :
				if ($cat->category_parent == 0 && $cat->term_id!=24 && $cat->term_id!=511) : 
					break;
				endif;
			endforeach;
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
							<div class="rss_item_image"><a href="<?php echo $item['url']; ?>" target="_blank"><img src="<?php echo $item['image_url'] ?>" alt="<?php echo $item['rss_title'] ?>" /></a></div>
						<?	}  ?>
						<h4 class="rss_title">
							<?php if (!empty($item['rss_title'])){ ?>
								<span class="rss_item_title"><a href="<?php echo $item['link']; ?>" target="_blank"> <?php echo $item['title'] ?> </a></span>
							<?	} ?>
							<a href="<?php echo $item['url']; ?>" target="_blank"><?php echo $item['rss_title']; ?></a>
						</h4>
						<div class="rss_entry"><?php echo excerpt(strip_tags($item['description']),150); ?></div>
				</div>
				<? $cnt++; ?>
	<?php		}		?>
			</div>
			
		<? if (is_home()) : ?>
			<?php dynamic_sidebar("Lateral Portada (Entre RSS)"); ?> 
		<? endif; ?>
		
	<?php
			}
				$mss = mss_get_rss($cat->slug,'blog');
				if (!empty($mss)){
		?>
				<h3 id="primera-voz-title">
					Sociedad civil
				</h3>
				<div id="external_rss" class="block">
					<? $cnt=0; ?>
		<?php		foreach ($mss as $item){		?>
					<div class="rss_item rss_item_<? echo $cnt; ?>">
							<?php if (!empty($item['image_url'])){	?>
								<div class="rss_item_image"><a href="<?php echo $item['url']; ?>" target="_blank"><img src="<?php echo $item['image_url'] ?>" alt="image" /></a></div>
							<?	}  ?>
							<h4 class="rss_title">
								<?php if (!empty($item['rss_title'])){ ?>
									<span class="rss_item_title"><a href="<?php echo $item['link']; ?>" target="_blank"> <?php echo $item['title'] ?> </a></span>
								<?	} ?>
								<a href="<?php echo $item['url']; ?>" target="_blank"><?php echo $item['rss_title']; ?></a>
							</h4>
							<div class="rss_entry"><?php echo excerpt(strip_tags($item['description']),150); ?></div>
					</div>
					<? $cnt++; ?>
		<?php		}		?>
				</div>

		<?php
				}
				$mss = mss_get_rss($cat->slug,'external');
				if (!empty($mss)){
		?>
				<h3>
					De referencia
				</h3>
				<div id="external_rss" class="block">
					<? $cnt=0; ?>
		<?php		foreach ($mss as $item){		?>
					<div class="rss_item rss_item_<? echo $cnt; ?>">
							<?php if (!empty($item['image_url'])){	?>
								<div class="rss_item_image"><a href="<?php echo $item['url']; ?>" target="_blank"><img src="<?php echo $item['image_url'] ?>" alt="image" /></a></div>
							<?	}  ?>
							<h4 class="rss_title">
								<?php if (!empty($item['rss_title'])){ ?>
									<span class="rss_item_title"><a href="<?php echo $item['link']; ?>" target="_blank"> <?php echo $item['title'] ?> </a> </span>
								<?	} ?>
								<a href="<?php echo $item['url']; ?>" target="_blank"><?php echo $item['rss_title']; ?></a>
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
