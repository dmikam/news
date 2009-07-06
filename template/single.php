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
	</div>
<?php get_sidebar() ?>
</div>


<?php get_footer() ?>
