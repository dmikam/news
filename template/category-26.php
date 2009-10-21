<?php get_header() ?>
<div id="container" class="clearfix">
	<div id="content" class="clearfix">
		<div id="featureds" class="block slideshow">
			<div id="more-featured">
				<? $featureds = get_posts("category=26&numberposts=5"); ?>
				<? $cnt = 0; ?>
				<? $buttons = "";?>
			 	<? foreach($featureds as $post) : ?>
					<? setup_postdata($post); ?>
					<? $id = get_the_ID(); ?>
					<div id="post-<?php the_ID(); ?>" class="featured-item <? echo $cnt==0 ? "active" : ""; ?> post-<?php the_ID(); ?>">
						<a href="<?php the_permalink(); ?>" title="<? the_title(); ?>">
						<? echo get_single_image("large",$post->ID); ?>
						</a>
						<h2><a href="<?php the_permalink(); ?>" id="post-<?php the_ID(); ?>"><?php the_title(); ?></a></h2>
					
						<?$buttons .= "<a href='#image-$id' class=\"button goto post-$id\" onclick='slideSwitch(\"post-$id\");return false;'>".($cnt+1)."</a>"; ?>
					</div>
			 	<?php $cnt++; endforeach; ?>
				<div class="buttons">
					<a href="#play-stop" class="playstop button" onclick="slide_toggle(); return false;">play/pause</a>
					<? echo $buttons; ?>
				</div>
			</div>

		</div>
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
