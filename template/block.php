	<? $block_post = get_posts(array("meta_key" => "bloque", "meta_value" => $number, "numberposts" => 1, "orderby" => "modified", 'post__not_in' => array($featured_post_id))); ?>	
	<?php foreach ($block_post as $post) : ?>
		<div class="news">
				<? setup_postdata($post); ?>
					<?php 
						$cats = get_the_category(); 
						foreach ($cats as $cat) :
							if ($cat->category_parent == 0) :
							?>
								<h5 class="category cat-<? echo $cat->term_id; ?>">
									<? echo $cat->cat_name; ?>
								</h5>
							<?
								break;
							endif;
						endforeach;
					?>
				<? $wimage = get_meta('image'); ?>
				<? if (!empty($wimage)) :  ?>
					<a href="<?php the_permalink(); ?>" title="<? the_title(); ?>">	<? echo get_single_image(array($width,$width)); ?></a>
				<? endif; ?>
				<h2 class="title" id="title-<? the_ID(); ?>">
					<a href="<?php the_permalink() ?>" title="Enlace a <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
				</h2>
				<h5 class="metadata">
				<span class="date"><?	echo date('d.m.Y',strtotime($post->post_date));  ?></span> · <span class="author"><? the_author_posts_link(); ?></span> 
				</h5>
				<div class="entry">
					<?php echo apply_filters( 'the_content', get_the_excerpt()); ?>
					<?php //edit_post_link('#edit', '', ''); ?>
				</div>
				<?php comments_number('','<h3 class="comments">1 comentario</h3','<h3 class="comments">% comentarios</h3>');?>
				
		</div>
	
	<?php endforeach; 
