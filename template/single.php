<?php get_header() ?>
<div id="container">
	<div id="content" class="clearfix">
		<?php while (have_posts()) : the_post(); ?>
			<h2 class="single-title" id="title-<? the_ID(); ?>">
				<a class="none" href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
					<?php the_title(); ?>
				</a>
			</h2>
			<div id="subtitles">
				<? $subtitle = get_meta('subtitle'); ?>
				<? if (!empty($subtitle)) : ?>
					<h3 class="subtitle"><? echo $subtitle; ?></h3>
				<? endif; ?>
				<? $subtitle2 = get_meta('subtitle-2'); ?>
				<? if (!empty($subtitle2)) : ?>
					<h3 class="subtitle"><? echo $subtitle2; ?></h3>
				<? endif; ?>
			</div>
			<div id="sign_and_date" class="clearfix">
				<div id="author">
					<? if (get_the_author_meta('user_level') > 6) : ?>
						<? the_author_posts_link(); ?> <span class="internal_author">(Enfoque 19)</span> 
					<? else : ?>
						<? the_author(); ?> <span class="external_author">(Redactor externo)</span>
					<? endif;?>
				</div>
				<div id="postdate">
					<?	the_date('d/m/Y', '', '');  ?> <? the_time('G:i'); ?>
				</div>
			</div>
			<div class="entry">
					<?php the_content('Leer más &raquo;'); ?>
			</div>
			
			<div id="tags">
				<? the_tags('Etiquetas: ',', '); ?>
			</div>
			
			<div id="meta_links" class="clearfi">
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
		
	</div>
<?php get_sidebar() ?>
</div>


<?php get_footer() ?>
