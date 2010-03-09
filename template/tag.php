<?php get_header() ?>
<div id="container" class="clearfix">
	<div id="content" class="category-page clearfix">
		<h2 class="category cat-title "><? single_tag_title(""); ?></h2> 
		<div id="description" class="clearfix">
			<div id="author-description" class="no_image">
				<? echo  tag_description();; ?>
			</div>
		</div>

		<div id="sub-content" class="clearfix">
				<?php while (have_posts()) : the_post(); ?>
						<div class="clearfix category_news">
							<div class="category_news_image">
								<? $wimage = get_meta('image'); ?>
								<? if (!empty($wimage)) :  ?>
									<a href="<?php the_permalink(); ?>" title="<? the_title(); ?>">	<? echo get_single_image(array(291,630)); ?></a>
									<? $class = "with_image";?>
								<? else: ?>
									<? $class = "no_image";?>
								<? endif; ?>
							</div>
							<div class="category_news_post <? echo $class; ?> ">
								<h2 class="title" id="title-<? the_ID(); ?>">
									<a href="<?php the_permalink() ?>" title="Enlace a <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
								</h2>
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
