	<? $block_post = get_posts(array("meta_key" => "bloque", "meta_value" => $number, "numberposts" => 1, "orderby" => "modified", 'post__not_in' => array($featured_post_id))); ?>	
	<?php foreach ($block_post as $post) : ?>
		<div class="news">
				<? setup_postdata($post); ?>
					<?php 
						$cats = get_the_category(); 
						foreach ($cats as $cat) :
							if ($cat->category_parent == 0 && $cat->term_id!=511) :
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
					<a href="<?php the_permalink(); ?>" title="<? the_title_attribute(); ?>">	<? echo get_single_image(array($width,$width)); ?></a>
				<? endif; ?>
				<h2 class="title" id="title-<? the_ID(); ?>">
					<a href="<?php the_permalink() ?>" title="Enlace a <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
				</h2>
				<?php edit_post_link(); ?>
				
				<h5 class="metadata">
				<span class="author"><? the_author_posts_link(); ?></span> 			
					<? $author2 = get_meta('author2'); ?>
					<? if (!empty($author2)) : ?>
						<span class="author"> · 
							<? $rolauthor2 = get_meta('rol-author2'); ?>
							<? if (!empty($rolauthor2)) : ?>
								<? echo $rolauthor2; ?>:
							<? endif; ?>
							<? echo $author2; ?>
						</span>
					<? endif; ?>
					<? $author3 = get_meta('author3'); ?>
					<? if (!empty($author3)) : ?>
						<span class="author"> ·
							<? $rolauthor3 = get_meta('rol-author3'); ?>
							<? if (!empty($rolauthor3)) : ?>
								<? echo $rolauthor3; ?>:
							<? endif; ?> 
							 <? echo $author3; ?>			
						</span>
					<? endif; ?>
				</h5>
				<div class="entry">
					<?php echo apply_filters( 'the_content', get_the_excerpt()); ?>
					<? $fuente = get_meta('fuente'); ?>
					<? $fuenteurl = get_meta('fuenteurl')?>
					<? if (!empty($fuente) && !empty($fuenteurl)) : ?>
						<p class="source"><strong>Fuente:</strong> <a href="<? echo $fuenteurl; ?>"><? echo $fuente; ?></a></p>
					<? endif; ?>				
				</div>
				<?php comments_number('','<h3 class="comments">1 comentario</h3>','<h3 class="comments">% comentarios</h3>');?>
				
		</div>
	
	<?php endforeach; 
