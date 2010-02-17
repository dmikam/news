<?php get_header() ?>
<div id="container" class="clearfix">
	<div id="content" class="no_sidebar clearfix">
		<?php while (have_posts()) : the_post(); ?>
			<h2 class="single-title" id="title-<? the_ID(); ?>">
				<a class="none" href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
					<?php the_title(); ?>
				</a>
			</h2>
			<div class="entry">
					<?php the_content('Leer más &raquo;'); ?>
			</div>
		<?php endwhile; ?>
	</div>
</div>


<?php get_footer() ?>
