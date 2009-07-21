<?php
	get_header(); 
	if (have_posts()) {
		the_post(); 
	}
	$videos = get_posts("category=39&orderby=ID&order=DESC&numberposts=5");
	$cur_video = get_post(get_the_ID());
?>

<div id="container" class="video">
	<div id="content" class="clearfix">
		<div id="video">
			<div class="embed">
<?php
	if ($cur_video){
		echo get_post_meta($cur_video->ID,'video',true);
	}
?>				
			</div>
		</div>
		<div class="entry">
<?php
	if ($cur_video){
		echo $cur_video->post_content;
	}
?>
		</div>
	</div>
	<div id="sidebar">
			<div class="other_videos">
				<h3>Otros vídeos</h3>
				<dl class="links_list">
<?php
	foreach($videos as $video){
?>	
					<dt><a href="<?php echo get_permalink($video->ID);?>"><?php echo $video->post_title; ?></a></dt>
<?php	
	}
?>
				</dl>
			</div>
	</div>
</div>


<?php get_footer() ?>
