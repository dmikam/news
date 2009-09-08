<?php get_header() ?>
<div id="container" class="clearfix">
	<div id="content" class="clearfix">
		<? $featured_cat = get_category_featured_id(intval(get_query_var('cat'))); ?>
		<? if (!empty($featured_cat)) : ?>
			<? $featured = get_posts("category=" . $featured_cat . "&numberposts=1"); ?>
			<? if (!empty($featured)) : ?>
			<div id="featured" class="clearfix">
			 	<? foreach($featured as $post) : ?>
			    	<? setup_postdata($post); ?>
					<? $raw_content =  get_meta('raw'); ?>
					<? $featured_post_id = get_the_ID(); ?>
					<? if (empty($raw_content)) : ?>
				 		<h2><a href="<?php the_permalink(); ?>" id="post-<?php the_ID(); ?>"><?php the_title(); ?></a></h2>
						<a href="<?php the_permalink(); ?>" title="<? the_title(); ?>">	<? echo get_single_image("large"); ?></a>
						<div id="excerpt">
							<? the_excerpt(); ?>
						</div>
					<? else : ?>
						<? echo apply_filters( 'the_content', $raw_content); ?>
					<? endif; ?>
			 	<?php endforeach; ?>
			</div>
			<? endif; // Si no hay posts destacado, no se muestra nada ?>
		<? endif; // Si no se encuentra la categoría destacada de la sección ?>
		
		<div id="sub-content" class="clearfix">
				<?php while (have_posts()) : the_post(); ?>
					<? if ($featured_post_id != get_the_ID()) : ?>
						<div class="category_news">
							<h2 class="title" id="title-<? the_ID(); ?>">
								<a href="<?php the_permalink() ?>" title="Enlace a <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
							</h2>
							<div class="entry">
								<? $wimage = get_meta('image'); ?>
								<? if (!empty($wimage)) :  ?>
									<a href="<?php the_permalink(); ?>" title="<? the_title(); ?>">	<? echo get_single_image(array(630,630)); ?></a>
								<? endif; ?>
								<?php the_excerpt(); ?>
							</div>
						</div>
					<? endif; // Si el posts es distinto al posts destacado, para no duplicar el post en la portadilla ?>
				<?php endwhile; ?>
		</div>
		
		

	</div>
<?php get_sidebar() ?>
</div>


<?php get_footer() ?>
