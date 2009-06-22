<?php
/*
Plugin Name: Nueva Galeria
Plugin URI: http://nextline.es
Description: Crea un nuevo "shortcode" para galeria
Author: nextline
Version: 1.0
Author URI: www.nextline.es
*/

remove_shortcode('gallery');
add_shortcode('gallery', 'new_gallery_function');

add_shortcode('linea', 'add_clearfix');

function add_clearfix() {
	return "<div style=\"clear:both\"></div>";
}

function new_gallery_function($atts){
	global $post;
	extract(shortcode_atts(array(
		'id'			=> $post->ID,
		'params'		=> 'rel="lightbox[\'gallery\']"',
		'galid'        	=> '',
		'galerytag'		=> 'ul',
		'itemtag'		=> 'li',
		'captiontag'	=> 'span',
		'perpage'		=> '3',
		'size'			=> 'thumbnail',
		'orderby'		=> 'menu_order ASC, ID ASC'
	), $atts));

	$id = (int)$id;
	$images = get_children("post_parent=$id&post_type=attachment&post_mime_type=image&orderby={$orderby}");
	if (!empty($images)) :
		$return = "<$galerytag ".(!empty($galid)?" id='$galid' ":"")." class=\"gallery\">";
		$perpage = (int)$perpage;
		$i=0;
		$start = $_GET["$galid_start"];
		foreach($images as $image) {
			$meta = wp_get_attachment_metadata($image->ID);
			//$thumb_path = dirname($image->guid)."/".$meta['sizes'][$size]['file'];
			$return .= "<$itemtag><a href=\"$image->guid\" $params>" . wp_get_attachment_image($image->ID,$size) . "</a></$itemtag>";
		}
		$return .= "</$galerytag>";
	endif;
	return $return;
	
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

?>
