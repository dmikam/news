	<? $block_post = get_posts(array("meta_key" => "bloque", "meta_value" => $number, "numberposts" => 1, "orderby" => "modified", 'post__not_in' => array($featured_post_id))); ?>	
	<?php foreach ($block_post as $post) : ?>
		<? setup_postdata($post); ?>
		<h2 class="title" id="title-<? the_ID(); ?>">
			<a href="<?php the_permalink() ?>" title="Enlace a <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
		</h2>
		<h5>
			Por 
			<? if (get_the_author_meta('user_level') > 6) : ?>
				<strong><? the_author_posts_link(); ?></strong> <span class="internal_author">(Periodismo Humano)</span> 
			<? else : ?>
				<strong><? the_author(); ?></strong> <span class="external_author">(Redactor externo)</span>
			<? endif;?>
		</h5>
		<?php edit_post_link('Editar', '', ''); ?>
		<div class="entry">
			<? $wimage = get_meta('image'); ?>
			<? if (!empty($wimage)) :  ?>
				<a href="<?php the_permalink(); ?>" title="<? the_title(); ?>">	<? echo get_single_image(array($width,$width)); ?></a>
			<? endif; ?>
			<?php echo apply_filters( 'the_content', get_the_excerpt()); ?>
		</div>
	<?php endforeach; 
