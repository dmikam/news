<div id="container" class="clearfix">
	<div id="content" class="single clearfix">
<?php	
		if (have_posts()) {
			the_post(); 
?>
				<?php 
					$cats = get_the_category(); 
					foreach ($cats as $cat) :
						if ($cat->category_parent == 0 && $cat->term_id!=24 && $cat->term_id!=511) : ?>
							<h2 class="category cat-title cat-<? echo $cat->term_id; ?>">
						<?	
							echo $cat->cat_name;
						?>
						</h2>
						<?
							break;
						endif;
					endforeach;
				?>
				<?php edit_post_link(); ?>
				
			<h2 class="single-title" id="title-<? the_ID(); ?>">
					<?php the_title(); ?>
			</h2>
			<? $subtitle = get_meta('subtitle'); ?>
			<? if (!empty($subtitle)) : ?>
				<div id="subtitles">
					<h3 class="subtitle"><? echo $subtitle; ?></h3>
					<? $subtitle2 = get_meta('subtitle-2'); ?>
					<? if (!empty($subtitle2)) : ?>
						<h3 class="subtitle"><? echo $subtitle2; ?></h3>
					<? endif; ?>
					<? $subtitle3 = get_meta('subtitle-3'); ?>
					<? if (!empty($subtitle3)) : ?>
						<h4 class="subtitle"><? echo $subtitle3; ?></h4>
					<? endif; ?>
				</div>
			<? endif; ?>
			<div class="entry clearfix">
				<h5 class="metadata clearfix">
					<div class="author-date-head">
						<span class="date"><?	echo date('d.m.Y',strtotime($post->post_date));  ?></span> · <span class="author"><? the_author_posts_link(); ?></span> 
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
					</div>
				
					<ul id="share-services-head">
						<li class="facebook"><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title_attribute(); ?>" title="Enviar a facebook" target="blank">Facebook</a></li>
						<li class="meneame"><a href="http://meneame.net/submit.php?url=<?php the_permalink();?>" target="_blank" title="Enviar a Meneame">Meneame</a></li>
						<li class="digg"><a href="http://digg.com/submit?phase=2&url=<?php the_permalink();?>" target="_blank" title="Enviar a Digg">Digg</a></li>
						<li class="twitter"><a href="http://twitter.com/home?status=Estoy leyendo <?php the_permalink(); ?>" title="Enviar a twitter" target="_blank">Twitter</a></li>		
						<li class="bitacoras"><a href="http://bitacoras.com/anotaciones/<?php the_permalink(); ?>" title="Enviar a bitacoras.com" target="_blank">Bitacoras</a></li>	
					</ul>
				</h5>
				<?php the_content('Leer más &raquo;'); ?>
				
				<? $fuente = get_meta('fuente'); ?>
				<? $fuenteurl = get_meta('fuenteurl')?>
				<? if (!empty($fuente) && !empty($fuenteurl)) : ?>
				<p class="source"><strong>Fuente:</strong> <a href="<? echo $fuenteurl; ?>"><? echo $fuente; ?></a></p>
				<? endif; ?>
			</div>
<?php
		} 
?>
			<div id="share_and_tags">
				<div id="tags">
					<p id="tag-title">Más info sobre</p>  <p><? the_tags('',', '); ?></p>
				</div>
				<div id="share">
					<p id="share-title">Si no lo mueves, no lo sabrá nadie</p> 
					<ul id="share-services">
						<li id="facebook"><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title_attribute(); ?>" title="Enviar a facebook" target="blank">Facebook</a></li>
						<li id="meneame"><a href="http://meneame.net/submit.php?url=<?php the_permalink();?>" target="_blank" title="Enviar a Meneame">Meneame</a></li>
						<li id="digg"><a href="http://digg.com/submit?phase=2&url=<?php the_permalink();?>" target="_blank" title="Enviar a Digg">Digg</a></li>
						<li id="twitter"><a href="http://twitter.com/home?status=Estoy leyendo <?php the_permalink(); ?>" title="Enviar a twitter" target="_blank">Twitter</a></li>		
						<li id="bitacoras"><a href="http://bitacoras.com/anotaciones/<?php the_permalink(); ?>" title="Enviar a bitacoras.com" target="_blank">Bitacoras</a></li>	
					</ul>
				</div>
			</div>
			
			<?php comments_template(); ?>
			
	</div>
<?php get_sidebar() ?>
</div>

<script type="text/javascript" charset="utf-8">
	jQuery('.entry embed').attr('width','610');
	jQuery('.entry embed').attr('height','400');
</script>