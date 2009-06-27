<?php get_header() ?>
<div id="container">
	<div id="content" class="clearfix">
		<div id="featured" class="clearfix">
			<? $featured = get_posts("category=" . get_category_featured_id() . "&numberposts=1"); ?>
		 	<? foreach($featured as $post) : ?>
		    	<? setup_postdata($post); ?>
		 		<h2><a href="<?php the_permalink(); ?>" id="post-<?php the_ID(); ?>"><?php the_title(); ?></a></h2>
				<? echo get_single_image("large"); ?>
				<div id="excerpt">
					<? the_excerpt(); ?>
				</div>
		 	<?php endforeach; ?>
		</div>
		
		<?php while (have_posts()) : the_post(); ?>
			<h2 class="title" id="title-<? the_ID(); ?>">
				<a class="none" href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
					<?php the_title(); ?>
				</a>
			</h2>
			<div class="entry">
					<?php the_content('Leer más &raquo;'); ?>
			</div>
		<?php endwhile; ?>
	</div>
<?php get_sidebar() ?>
</div>


<?php get_footer() ?>
