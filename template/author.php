<?php get_header() ?>
<div id="container" class="clearfix">
	<div id="content" class="category-page clearfix">
		<?php
			global $wp_query;
			$curauth = $wp_query->get_queried_object();
		?>
		<h2 class="category cat-title "><? echo  $curauth->display_name; ?></h2> 
		<div id="description" class="clearfix">
			<div id="author-avatar">
				<? if (file_exists(get_theme_root() . '/newstheme/images/authors/' . $curauth->user_nicename . '.jpg')) : ?>
					<img src="<? echo get_bloginfo('template_directory') . '/images/authors/' . $curauth->user_nicename . '.jpg'?>" alt="Avatar de <? echo $curauth->display_name; ?>" />
				<? else : ?>
				<? endif; ?>
			</div>
			<div id="author-description">
				<h4>Perfil de <?echo  $curauth->display_name; ?></h4>
				<? echo $curauth->description; ?>
				<span id="author-email"><? echo $curauth->user_email?></span>
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
		
		

	</div>
<?php get_sidebar() ?>
</div>


<?php get_footer() ?>
