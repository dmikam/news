<div id="sidebar">
	<? if (is_home()) :  // solo se mostrará el bloque en la portada ?>	
		<h3 id="featureds-title">Temas destacados</h3>
		<div id="featureds" class="block">
			<div id="more-featured">
				<? $featureds = get_posts("category=26&numberposts=5"); ?>
				<? $cnt = 0; ?>
				<? $buttons = "";?>
			 	<? foreach($featureds as $post) : ?>
					<? setup_postdata($post); ?>
					<? $id = get_the_ID(); ?>
					<div id="post-<?php the_ID(); ?>" class="featured-item <? echo $cnt==0 ? "active" : ""; ?> post-<?php the_ID(); ?>">
						<a href="<?php the_permalink(); ?>" title="<? the_title(); ?>">
						<? echo get_single_image("featureds",$post->ID); ?>
						</a>
						<h2><a href="<?php the_permalink(); ?>" id="post-<?php the_ID(); ?>"><?php the_title(); ?></a></h2>
					
						<?$buttons .= "<a href='#image-$id' class=\"button goto post-$id\" onclick='slideSwitch(\"post-$id\");return false;'>".($cnt+1)."</a>"; ?>
					</div>
			 	<?php $cnt++; endforeach; ?>
				<div class="buttons clearfix">
					<a href="#play-stop" class="playstop button" onclick="slide_toggle(); return false;">play/pause</a>
					<? echo $buttons; ?>
				</div>
			</div>

		</div>
	
	
		<?php dynamic_sidebar("Lateral"); ?> 
	
	<? endif;  // Fin de condición para mostrar solo si es portada ?>

	<? if (is_single()) :
		$recomended = recomended_links();
		if (!empty($recomended)) : ?>				
			<h3>Enlaces recomendados</h3>
			<div class="recomended-links block">
				<ul>
					<? echo $recomended; ?>
				</ul>
			</div>
		<? endif; ?>
			
		<h3>Artículos relacionados</h3>
		<div id="meta_links" class="block clearfix">
				<div class="related_posts">
				<?php echo related_posts_shortcode('limit=5');?>
				</div>
		</div>

	<? endif; ?>

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
