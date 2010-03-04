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
						<li><a href="<?php echo get_permalink($video->ID);?>?video"><?php echo $video->post_title; ?></a></li>
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
					<?php echo apply_filters('the_content', preg_replace("/\[embed.*\[\/embed\]/",'', get_the_content())); ?>
			</div>	
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
