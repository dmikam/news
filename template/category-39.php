<?php
	get_header(); 
?>
<div id="container" class="clearfix video">
	<div id="content" class="clearfix">
		<?php while (have_posts()) : the_post(); ?>
			<div id="video">
				<div class="embed">
				<?php
					preg_match_all("/\[youtube.*\[\/youtube\]/", get_the_content(), $video_tag); 
					if (!empty($video_tag[0][0])) :
						$video_tag[0][0] = preg_replace("/\[youtube.*\"\]/",'[youtube]', $video_tag[0][0]); 
						$video_shortcode=str_replace('[youtube]','[youtube width="650" height="400"]',$video_tag[0][0]);
						echo do_shortcode($video_shortcode);
					endif;
				?>		    	
				</div>
			</div>
			<h2 class="single-title" id="title-<? the_ID(); ?>">
				<a class="none" href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
					<?php the_title(); ?>
				</a>
			</h2>
			<div class="entry">
					<?php echo  apply_filters('the_content', preg_replace("/\[youtube.*\[\/youtube\]/",'', get_the_content())); ?>
			</div>
			<? break; ?>
		<?php endwhile; ?>
	</div>
	<div id="sidebar">
			<div class="other_videos">
				<h3>Otros vídeos</h3>
				<dl class="links_list">
<?php
$videos = get_posts("category=39&orderby=ID&order=DESC&numberposts=5");

	foreach($videos as $video){
?>	
					<dt><a href="<?php echo get_permalink($video->ID);?>?video"><?php echo $video->post_title; ?></a></dt>
<?php	
	}
?>
				</dl>
			</div>
	</div>
</div>


<?php get_footer() ?>
