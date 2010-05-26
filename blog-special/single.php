<?php get_header(); 
	if (has_tag('multimedia')) : 
		include_once('single-multimedia.php');
 	else :
		include_once('single-post.php');
	endif; 
get_footer(); ?>

