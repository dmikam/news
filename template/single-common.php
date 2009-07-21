<div id="container">
	<div id="content" class="clearfix">
<?php	
		if (have_posts()) {
			the_post(); 
?>
			<h2 class="single-title" id="title-<? the_ID(); ?>">
					<?php the_title(); ?>
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
					Por 
					<? if (get_the_author_meta('user_level') > 6) : ?>
						<strong><? the_author_posts_link(); ?></strong> <span class="internal_author">(Enfoque 19)</span> 
					<? else : ?>
						<strong><? the_author(); ?></strong> <span class="external_author">(Redactor externo)</span>
					<? endif;?>
				</div>
				<div id="postdate">
					Actualizado el 
					<strong><?	the_date('d/m/Y', '', '');  ?></strong> a las <strong><? the_time('G:i'); ?></strong>
				</div>
			</div>
			<div class="entry">
				<?php the_content('Leer más &raquo;'); ?>
			</div>
<?php
		} 
?>
			<div id="tags">
				<p><strong>Etiquetas:</strong> <? the_tags('',', '); ?></p>
				<p><strong>Compartir esta noticia en</strong> Meneame.net facebook twitter digg reddit</p>
			</div>
			
			<?php comments_template(); ?>
			
	</div>
<?php get_sidebar() ?>
</div>
