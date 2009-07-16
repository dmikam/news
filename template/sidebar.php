<div id="sidebar">
	<div id="more-featured">
		<? $featured = get_posts("category=26&numberposts=10"); ?>
		<? dump($featured);$cnt = 0; ?>
		<? $buttons = "";?>
	 	<? foreach($featured as $item) : ?>
			<? $id = get_the_ID(); ?>
	    	<? setup_postdata($item); ?>
			<div id="post-<?php the_ID(); ?>" class="featured-item <? echo $cnt==0 ? "active" : ""; ?> post-<?php the_ID(); ?>">
				<h2><a href="<?php the_permalink(); ?>" id="post-<?php the_ID(); ?>"><?php the_title(); ?></a></h2>
				<? echo get_single_image("large",$item->ID); ?>
				<?$buttons .= "<a href='#image-$id' class=\"button goto post-$id\" onclick='slideSwitch(\"post-$id\");return false;'>".($cnt+1)."</a>"; ?>
			</div>
	 	<?php $cnt++; endforeach; ?>
		<div class="buttons">
			<a href="#play-stop" class="playstop button" onclick="slide_toggle(); return false;">play/pause</a>
			<?echo $buttons;?>
		</div>
	</div>
<?
	if (is_single()){	
		global $post;
		$more_fields = mf_get_boxes();
		reset($more_fields["Enlaces recomendados"]["field"]);
		$title = each($more_fields["Enlaces recomendados"]["field"]);
		$recomended = '';
		while($title!==FALSE) { 
			$title_val = get_post_meta($post->ID,$title['value']['key'],true);
			$link = each($more_fields["Enlaces recomendados"]["field"]);
			$link_val = get_post_meta($post->ID,$link['value']['key'],true);
			if (!empty($title_val) && !empty($link_val)){
				$recomended .= "<li><a href=\"$link_val\">$title_val</a></li>";
			}
			$title = each($more_fields["Enlaces recomendados"]["field"]);
		}
		if (!empty($recomended)){
?>		
		<div class="recomended-links">
			<h3>Enlaces recomendados</h3>
			<ul>
				<?echo $recomended;?>
			</ul>
		</div>
<?		}		?>
			
			<div id="meta_links" class="clearfix">
					<div class="related_posts">
						<h3>Artículos relacionados</h3>
					<?php echo related_posts_shortcode('limit=5');?>
					</div>
		<?
				$more_fields = mf_get_boxes();
				reset($more_fields["Enlaces recomendados"]["field"]);
				$title = each($more_fields["Enlaces recomendados"]["field"]);
				$recomended = '';
				while($title) { 
					$title_val = get_meta($title['value']['key']);
					$link = each($more_fields["Enlaces recomendados"]["field"]);
					$link_val = get_meta($link['value']['key']);
					if (!empty($title_val) && !empty($link_val)){
						$recomended .= "<li><a href=\"$link_val\">$title_val</a></li>";
					}
					$title = each($more_fields["Enlaces recomendados"]["field"]);
				}
				if (!empty($recomended)){
		?>		
				<div class="recomended-links">
					<h3>Enlaces recomendados</h3>
					<ul>
						<?echo $recomended;?>
					</ul>
				</div>
		<?		}		?>
			</div>

<?	}		?>

<?php require(TEMPLATEPATH . "/links_block.php"); ?>	
<?php require(TEMPLATEPATH . "/mss_block.php"); ?>	



</div>

<script type="text/javascript" charset="utf-8">
	var interval = false;
	var play = true;
	
	function slideSwitch(force_next) {
		var $active = jQuery('#more-featured .featured-item.active');

		if ( $active.length == 0 ) $active = jQuery('#more-featured .featured-item:last');
		//alert('#more-featured .featured-item.'+force_next);

		var $next = force_next ? jQuery('#more-featured .featured-item.'+force_next) : 
			($active.next('#more-featured .featured-item').length 
			? $active.next('#more-featured .featured-item')
			: jQuery('#more-featured .featured-item:first'));

		$active.addClass('last-active');

		$next.css({opacity: 0.0})
			.addClass('active')
			.animate({opacity: 1.0}, 1000, function() {
				$active.removeClass('active last-active');
			});
		$('.buttons .goto').removeClass('active');
		$('.buttons .goto.'+$next.attr('id')).addClass('active');
		if (play){
			clearTimeout(interval);
			interval = setTimeout( "slideSwitch('')", 3000 );
		}
	}

	function slide_toggle(){
		if (play){
			play = false;
			$('.playstop.button').removeClass('play');
			$('.playstop.button').addClass('pause');
			slide_stop();
		}else{
			play = true;
			$('.playstop.button').removeClass('pause');
			$('.playstop.button').addClass('play');
			slide_play();
		}
	}

	function slide_play(){
		play = true;
		clearTimeout(interval);
		setTimeout( "slideSwitch('')", 3000 );
	}

	function slide_stop(){
		clearTimeout(interval);
		play = false;
	}
	
	jQuery(function() {
		play = true;
		slide_play();
	});

</script>
