	<? $block_post = get_posts("meta_key=bloque&meta_value=$number&numberposts=1&orderby=modified"); ?>	
	<?php foreach ($block_post as $post) : ?>
		<? setup_postdata($post); ?>
		<h2 class="title" id="title-<? the_ID(); ?>">
			<a href="<?php the_permalink() ?>" title="Enlace a <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
		</h2>
		<?php edit_post_link('Editar', '', ''); ?>
		<div class="entry">
			<? $wimage = get_meta('image'); ?>
			<? if (!empty($wimage)) :  ?>
				<a href="<?php the_permalink(); ?>" title="<? the_title(); ?>">	<? echo get_single_image(array($width,$width)); ?></a>
			<? endif; ?>
			<?php the_excerpt(); ?>
		</div>
	<?php endforeach; 
