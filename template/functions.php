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

function get_bicat_links($cat1,$cat2){
	global $wpdb;
	if (is_int($cat1)){
		$dc1 = $cat1;
	}else{
		$term1 = get_term_by('slug', $cat1, 'link_category');
		$dc1 = $term1->term_id;
	}
	if (is_int($cat2)){
		$dc2 = $cat2;
	}else{
		$term2 = get_term_by('slug', $cat2, 'link_category');
		$dc2 = $term2->term_id;
	}
	
	if ( $dc1 && $dc2 ) {
	
		$wherestring = "
			$wpdb->links.link_id IN (
				SELECT DISTINCT 
					object_id 
				FROM 
					$wpdb->term_relationships 
				WHERE 
					object_id IN (
						SELECT 
							object_id 
						FROM 
							$wpdb->term_relationships 
							inner join 
								$wpdb->term_taxonomy 
								ON 
								$wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id 
						WHERE 
							term_id = '$dc1'
					) 
					AND 
					object_id IN (
						SELECT 
							object_id 
						FROM 
							$wpdb->term_relationships 
							inner join 
								$wpdb->term_taxonomy 
								on 
								$wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id 
						WHERE 
						term_id = '$dc2'
					)
			)
		";
	}
	$sql = "
		SELECT
			*
		FROM
			$wpdb->links
		WHERE
	".$wherestring;
	
	$res = $wpdb->get_results($sql,OBJECT);
	
	return $res;
}


?>
