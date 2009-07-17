<?php

add_shortcode('linea', 'add_clearfix');

function add_clearfix() {
	return "<div style=\"clear:both\"></div>";
}

function get_single_image($size = 'thumbnail',$post_id=false) {
	global $post;
	if ($post_id===false){
		$post_id = $post->ID;
	}
	$images = get_children(array('post_parent' => $post->ID, 
								'post_type' => 'attachment',
								'post_mime_type' => 'image',
								'orderby' => 'menu_order',
								'numberposts' => 1,
								'order' => 'ASC'));

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
	$images = get_children(array('post_parent' => $post->ID, 
								'post_type' => 'attachment',
								'post_mime_type' => 'image',
								'orderby' => 'menu_order',
								'numberposts' => 1,
								'order' => 'ASC'));

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
		$c1 = get_category($cat1);
	}else{
		$term1 = get_term_by('slug', $cat1, 'link_category');
		$dc1 = $term1->term_id;
	}
	if (is_int($cat2)){
		$dc2 = $cat2;
		$c2 = get_category($cat2);
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
								AND
								$wpdb->term_taxonomy.taxonomy = 'link_category'
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
								AND
								$wpdb->term_taxonomy.taxonomy = 'link_category'
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

function excerpt($text,$maxlen=500){
	if (strlen($text)<=$maxlen){
		echo $text;
	}else{
		echo substr($text,0,strpos($text,' ',$maxlen)).(strlen($text)>$maxlen? " [...]":"");
	}
}

function related_posts_shortcode( $atts ) {
	extract(shortcode_atts(array(
	    'limit' => '5',
	), $atts));

	global $wpdb, $post, $table_prefix;

	if ($post->ID) {
		$retval = '
		';
 		// Get tags
		$tags = wp_get_post_tags($post->ID);
		$tagsarray = array();
		foreach ($tags as $tag) {
			$tagsarray[] = $tag->term_id;
		}
		$tagslist = implode(',', $tagsarray);

		// Do the query
		$q = "SELECT p.*, count(tr.object_id) as count
			FROM $wpdb->term_taxonomy AS tt, $wpdb->term_relationships AS tr, $wpdb->posts AS p WHERE tt.taxonomy ='post_tag' AND tt.term_taxonomy_id = tr.term_taxonomy_id AND tr.object_id  = p.ID AND tt.term_id IN ($tagslist) AND p.ID != $post->ID
				AND p.post_status = 'publish'
				AND p.post_date_gmt < NOW()
 			GROUP BY tr.object_id
			ORDER BY count DESC, p.post_date_gmt DESC
			LIMIT $limit;";

		$related = $wpdb->get_results($q);
 		if ( $related ) {
			foreach($related as $r) {
				//dump($r);
				$retval .= '<li><a href="'.get_permalink($r->ID).'">
					'.wptexturize($r->post_title).'
					</a></li>
				';
			}
			return '<ul>'.$retval.'</ul>';
		} else {
			$retval .= '
				No related posts found
			';
			$retval .= '
			';
		return $retval;

		}
	}
	return;
}


function the_current_date() {
		$months = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
		$days = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
		echo $days[date("w")] . ", " . date("j") . " de " . $months[date("n")] . " de " . date("Y");
}

function the_current_url() {
	echo 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
}

function recomended_links(){
	global $post;
	$more_fields = mf_get_boxes();
	reset($more_fields["Enlaces recomendados"]["field"]);
	$title = each($more_fields["Enlaces recomendados"]["field"]);
	$recomended = '';
	while($title!==FALSE) {
		$title_val = get_post_meta($post->ID,$title['value']['key'],true);
		$link = each($more_fields["Enlaces recomendados"]["field"]);
		$link_val = get_post_meta($post->ID,$link['value']['key'],true);
		if (!empty($title_val) && !empty($link_val)){
			$recomended .= "<li><a href=\"$link_val\">$title_val</a></li>";
		}
		$title = each($more_fields["Enlaces recomendados"]["field"]);
	}
	return $recomended;
}

?>
