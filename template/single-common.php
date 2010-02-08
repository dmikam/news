<div id="container" class="clearfix">
	<div id="content" class="single clearfix">
<?php	
		if (have_posts()) {
			the_post(); 
?>
				<?php 
					$cats = get_the_category(); 
					foreach ($cats as $cat) :
						if ($cat->category_parent == 0 && $cat->term_id!=24) : ?>
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
			<h2 class="single-title" id="title-<? the_ID(); ?>">
					<?php the_title(); ?>
			</h2>
			<div id="subtitles">
				<? $subtitle = get_meta('subtitle'); ?>
				<? if (!empty($subtitle)) : ?>
					<h3 class="subtitle"><? echo $subtitle; ?></h3>
				<? endif; ?>
				<? $subtitle2 = get_meta('subtitle-2'); ?>
				<? if (!empty($subtitle2)) : ?>
					<h3 class="subtitle"><? echo $subtitle2; ?></h3>
				<? endif; ?>
				<? $subtitle3 = get_meta('subtitle-3'); ?>
				<? if (!empty($subtitle3)) : ?>
					<h4 class="subtitle"><? echo $subtitle3; ?></h4>
				<? endif; ?>
			</div>
			<div class="entry">
				<h5 class="metadata">
				<span class="date"><?	echo date('d.m.Y',strtotime($post->post_date));  ?></span> · <span class="author"><? the_author_posts_link(); ?></span> 
				</h5>
				<?php the_content('Leer más &raquo;'); ?>
			</div>
<?php
		} 
?>
			<div id="share_and_tags">
				<div id="tags">
					<p id="tag-title">Más info sobre</p>  <p><? the_tags('',', '); ?></p>
				</div>
				<div id="share">
					<p id="share-title">Comparte</p> 
					<ul id="share-services">
						<li id="facebook"><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>" title="Enviar a facebook" target="blank">Facebook</a></li>
						<li id="meneame"><a href="http://meneame.net/submit.php?url=<?php the_permalink();?>" target="_blank" title="Enviar a Meneame">Meneame</a></li>
						<li id="digg"><a href="http://digg.com/submit?phase=2&url=<?php the_permalink();?>" target="_blank" title="Enviar a Digg">Digg</a></li>
						<li id="twitter"><a href="http://twitter.com/home?status=Estoy leyendo <?php the_permalink(); ?>" title="Enviar a twitter" target="_blank">Twitter</a></li>		
					</ul>
				</div>
			</div>
			
			<?php comments_template(); ?>
			
	</div>
<?php get_sidebar() ?>
</div>
