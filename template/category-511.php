<?php
	get_header(); 
?>
<?php while (have_posts()) : the_post(); ?>
	<div id="video">
		<div id="video-deco">	</div>
		<div id="video-content" class="clearfix">
			<h2 id="multimedia-title">
				Multimedia
			</h2>
			<div id="embed">
			<?php
				preg_match_all("/\[embed.*\[\/embed\]/", get_the_content(), $video_tag); 
				if (!empty($video_tag[0][0])) :
					$video_tag[0][0] = preg_replace("/\[embed.*\"\]/",'[embed]', $video_tag[0][0]); 
					$video_shortcode=str_replace('[embed]','[embed width="650" height="400"]',$video_tag[0][0]);
					echo apply_filters('the_content',$video_shortcode);
				endif;
			?>		    	
			</div>
			<div id="more-videos">
				<h3>Otros vídeos</h3>
				<ul>
					<? $videos = get_posts("category=511&orderby=ID&order=DESC&numberposts=5"); ?>
					<? foreach($videos as $video) : ?>	
						<li><a href="<?php echo get_permalink($video->ID);?>?video=1"><?php echo $video->post_title; ?></a></li>
					<? endforeach; ?>
				</ul>
				<script type="text/javascript" charset="utf-8">
					$(function() {
						$("#more-videos ul").quickPager({pageSize:3});
					});
				</script>
			</div>
		</div>
	</div>
<div id="container" class="clearfix video">
	<div id="content" class="clearfix">
			<h2 class="single-title" id="title-<? the_ID(); ?>">
				<a class="none" href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
					<?php the_title(); ?>
				</a>
			</h2>
			<div class="entry">
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
						<li class="meneame"><a href="http://meneame.net/submit.php?url=<?php the_permalink();?>?video=1" target="_blank" title="Enviar a Meneame">Meneame</a></li>
						<li class="digg"><a href="http://digg.com/submit?phase=2&url=<?php the_permalink();?>?video=1" target="_blank" title="Enviar a Digg">Digg</a></li>
						<li class="twitter"><a href="http://twitter.com/home?status=Estoy leyendo <?php the_permalink(); ?>?video=1" title="Enviar a twitter" target="_blank">Twitter</a></li>		
					</ul>
				</h5>
					<?php echo apply_filters('the_content', preg_replace("/\[embed.*\[\/embed\]/",'', get_the_content())); ?>
			</div>	
			<? $withcomments = 1; ?>	
			<?php comments_template(); ?>
	</div>
	<? break; ?>
<?php endwhile; ?>

<? get_sidebar(); ?>
</div>

<script type="text/javascript" charset="utf-8">
	jQuery('#embed embed').attr('width','650');
	jQuery('#embed embed').attr('height','400');
</script>
<?php get_footer() ?>
