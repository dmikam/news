<?php get_header() ?>
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
<?php
		} 
?>
			<div id="tags">
				<? the_tags('Etiquetas: ',', '); ?>
			</div>
	</div>
<?php get_sidebar() ?>
</div>


<?php get_footer() ?>
