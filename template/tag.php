<?php get_header() ?>
<div id="container" class="clearfix">
	<div id="content" class="clearfix">
		<div id="sub-content" class="clearfix">
				<?php while (have_posts()) : the_post(); ?>
						<div class="category_news">
							<h2 class="title" id="title-<? the_ID(); ?>">
								<a href="<?php the_permalink() ?>" title="Enlace a <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
							</h2>
							<div class="entry">
								<?php the_excerpt(); ?>
							</div>
						</div>
				<?php endwhile; ?>
		</div>
	</div>
<?php get_sidebar() ?>
</div>


<?php get_footer() ?>
