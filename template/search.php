<?php get_header() ?>
<div id="container">
	<div id="content" class="single clearfix">
	
	<?php while (have_posts()) : the_post(); ?>
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
							<a href="<? the_permalink(); ?>"><?php the_title(); ?></a>
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
						<h5 class="metadata">
						<span class="date"><?	echo date('d.m.Y',strtotime($post->post_date));  ?></span> · <span class="author"><? the_author_posts_link(); ?></span> 
						<? $author2 = get_meta('author2'); ?>
						<? if (!empty($author2)) : ?>
							<span class="author"> · <? echo $author2; ?>
								<? $rolauthor2 = get_meta('rol-author2'); ?>
								<? if (!empty($rolauthor2)) : ?>
									(<? echo $rolauthor2; ?>)
								<? endif; ?>
							</span>
						<? endif; ?>
						<? $author3 = get_meta('author3'); ?>
						<? if (!empty($author3)) : ?>
							<span class="author"> · <? echo $author3; ?> 
								<? $rolauthor3 = get_meta('rol-author3'); ?>
								<? if (!empty($rolauthor3)) : ?>
									(<? echo $rolauthor3; ?>)
								<? endif; ?>	
							</span>

						<? endif; ?>
						</h5>
						<?php the_content('Leer más &raquo;'); ?>
					</div>
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
							</ul>
						</div>
					</div>
	<?php endwhile; ?>

		</div>
	<?php get_sidebar() ?>
	</div>
<?php get_footer() ?>
