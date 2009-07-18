<?php get_header() ?>
<div id="container">
	<div id="content" class="clearfix">
	
	<?php while (have_posts()) : the_post(); ?>
		<div class="article">
			<h2 class="single-title" id="title-<? the_ID(); ?>">
				<a href="<?php the_permalink(); ?>" id="post-<?php the_ID(); ?>">	<?php the_title(); ?>	</a>
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
			<div id="tags">
				<? the_tags('Etiquetas: ',', '); ?>
			</div>
		</div>
	<?php endwhile; ?>

	</div>
<?php get_sidebar() ?>
</div>


<?php get_footer() ?>