<?php

add_shortcode('linea', 'add_clearfix');

function add_clearfix() {
	return "<div style=\"clear:both\"></div>";
}

function get_single_image($size = 'thumbnail') {
	global $post;
	$images = get_children("post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=1");

	if (empty($images)) :
		return "<img src='" . get_bloginfo('template_directory') . "/imagenes/default.png'>";
	else :
		foreach ($images as $image) :
			return wp_get_attachment_image($image->ID,$size);
		endforeach;
	endif;
}

function get_single_image_src($size = 'thumbnail') {
	global $post;
	$images = get_children("post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=1");

	if (empty($images)) :
		return "<img src='" . get_bloginfo('template_directory') . "/imagenes/default.png'>";
	else :
		foreach ($images as $image) :
			$img = wp_get_attachment_image_src($image->ID,$size);
			return $img[0];
		endforeach;
	endif;
}

function get_category_featured_id($category_parent='') {
	if (empty($category_parent)) :
		$category = get_category_by_slug('destacado');
	else :
		$parent = get_category($category_parent);
		$category = get_category_by_slug($parent->slug . '-destacado');
	endif;
 	return $category->cat_ID;
}


?>
