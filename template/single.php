<?php get_header() ?>
<div id="container">
	<div id="content" class="clearfix">
		<?php while (have_posts()) : the_post(); ?>
			<h2 class="title" id="title-<? the_ID(); ?>">
				<a class="none" href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
					<?php the_title(); ?>
				</a>
			</h2>
			<div class="entry">
					<?php the_content('Leer más &raquo;'); ?>
			</div>
			<div class="related_posts">
				<h3>Artículos relacionados</h3>
			<?php echo related_posts_shortcode('limit=5');?>
			</div>
		<?php endwhile; ?>
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
<?php get_sidebar() ?>
</div>


<?php get_footer() ?>
