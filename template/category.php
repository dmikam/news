<?php get_header() ?>
<div id="container" class="clearfix">
	<div id="content" class="category-page clearfix">
		<h2 class="category cat-title cat-<? echo get_query_var('cat'); ?>"><? echo  single_cat_title('', false); ?></h2> 
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
						<div class="image-featured">
							<a href="<?php the_permalink(); ?>" title="<? the_title_attribute(); ?>">	<? echo get_single_image(array(360,360)); ?></a>						
						</div>
						<div class="excerpt-featured">
							<h5 class="metadata">
							<span class="date"><?	echo date('d.m.Y',strtotime($post->post_date));  ?></span> · <span class="author"><? the_author_posts_link(); ?></span> 
							</h5>
							<?php echo apply_filters( 'the_content', get_the_excerpt()); ?>
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
						<div class="clearfix category_news">
							<div class="category_news_image">
								<? $wimage = get_meta('image'); ?>
								<? if (!empty($wimage)) :  ?>
									<a href="<?php the_permalink(); ?>" title="<? the_title_attribute(); ?>">	<? echo get_single_image(array(291,630)); ?></a>
									<? $class = "with_image";?>
								<? else: ?>
									<? $class = "no_image";?>
								<? endif; ?>
							</div>
							<div class="category_news_post <? echo $class; ?> ">
								<h2 class="title" id="title-<? the_ID(); ?>">
									<a href="<?php the_permalink() ?>" title="Enlace a <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
								</h2>
								<?php edit_post_link(); ?>
								
								<h5 class="metadata">
								<span class="date"><?	echo date('d.m.Y',strtotime($post->post_date));  ?></span> · <span class="author"><? the_author_posts_link(); ?></span> 
								</h5>
								<div class="entry">
									<?php echo apply_filters( 'the_content', get_the_excerpt()); ?>
									
									<h5 class="read_more">
										<a href="<?php the_permalink() ?>" title="Leer el resto del artículo <?php the_title_attribute(); ?>">Leer más</a>
									</h5>
								</div>
							</div>
							
						</div>
					<? endif; // Si el posts es distinto al posts destacado, para no duplicar el post en la portadilla ?>
				<?php endwhile; ?>
		</div>
		
		<div class="navigation clearfix">
			<div class="previous"><?php previous_posts_link('Anterior') ?></div>
			<div class="next"><?php next_posts_link('Siguiente') ?></div>
		</div>

	</div>
<?php get_sidebar() ?>
</div>


<?php get_footer() ?>
