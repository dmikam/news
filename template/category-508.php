<?php
		$cat = get_category(intval(get_query_var('cat')));
		$mss = mss_get_rss($cat->slug,'internal',20);
?>
<?php get_header() ?>
<div id="container" class="clearfix">
	<div id="content" class="no_sidebar clearfix">
		<h2 id="enfoques-title">
			Enfoques
		</h2>
	
		<div id="enfoques" class="enfoques-column">
			<h3 class="enfoques-title-column">Enfoques</h3>
<?php		foreach ($mss as $item) :		?>
			<div class="enfoques-item clearfix">
					<?php if (!empty($item['image_url'])){	?>
						<div class="enfoques-image"><img src="<?php echo $item['image_url'] ?>" alt="image" /></div>
					<?	}  ?>
					<div class="enfoques-data clearfix">
						<?php if (!empty($item['rss_title'])){ ?>
							<h3 class="enfoques-name"> <?php echo $item['rss_title'] ?> </h3>
						<?	} ?>
						<h2 class="enfoques-title">
							<a href="<?php echo $item['link']; ?>" target="_blank"><?php echo $item['title']; ?></a>
						</h2>
						<div class="enfoques-entry"><?php echo excerpt(strip_tags($item['description']),150); ?></div>
						<a class="enfoques-readmore" href="<?php echo $item['link']; ?>" target="_blank">Leer más</a>
					</div>
			</div>
<?php		endforeach;		?>
		</div>
		
	<?php $mss = mss_get_rss($cat->slug,'blog',20); ?>	
	
		<div id="sociedad-civil" class="enfoques-column">
			<h3 class="enfoques-title-column">Sociedad civil</h3>
<?php		foreach ($mss as $item) :		?>
			<div class="enfoques-item clearfix">
					<?php if (!empty($item['image_url'])){	?>
						<div class="enfoques-image"><img src="<?php echo $item['image_url'] ?>" alt="image" /></div>
					<?	}  ?>
					<div class="enfoques-data clearfix">
						<?php if (!empty($item['rss_title'])){ ?>
							<h3 class="enfoques-name"> <?php echo $item['rss_title'] ?> </h3>
						<?	} ?>
						<h2 class="enfoques-title">
							<a href="<?php echo $item['link']; ?>" target="_blank"><?php echo $item['title']; ?></a>
						</h2>
						<div class="enfoques-entry"><?php echo excerpt(strip_tags($item['description']),150); ?></div>
						<a class="enfoques-readmore" href="<?php echo $item['link']; ?>" target="_blank">Leer más</a>
					</div>
			</div>
<?php		endforeach;		?>
		</div>

		<?php $mss = mss_get_rss($cat->slug,'external',20); ?>	

		<div id="en-perspectiva" class="enfoques-column">
			<h3 class="enfoques-title-column">De referencia</h3>
<?php		foreach ($mss as $item) :		?>
			<div class="enfoques-item clearfix">
					<?php if (!empty($item['image_url'])){	?>
						<div class="enfoques-image"><img src="<?php echo $item['image_url'] ?>" alt="image" /></div>
					<?	}  ?>
					<div class="enfoques-data clearfix">
						<?php if (!empty($item['rss_title'])){ ?>
							<h3 class="enfoques-name"> <?php echo $item['rss_title'] ?> </h3>
						<?	} ?>
						<h2 class="enfoques-title">
							<a href="<?php echo $item['link']; ?>" target="_blank"><?php echo $item['title']; ?></a>
						</h2>
						<div class="enfoques-entry"><?php echo excerpt(strip_tags($item['description']),150); ?></div>
						<a class="enfoques-readmore" href="<?php echo $item['link']; ?>" target="_blank">Leer más</a>
					</div>
			</div>
<?php		endforeach;		?>
		</div>
		
		
	
	</div>
</div>
<?php get_footer() ?>