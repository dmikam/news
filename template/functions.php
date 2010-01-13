<?php

add_shortcode('linea', 'add_clearfix');

if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'before_widget' => '<div class="block">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
		  'name' => 'Lateral',
    ));
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'before_widget' => '<div class="block">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
		  'name' => 'Pie',
    ));


function add_clearfix() {
	return "<div style=\"clear:both\"></div>";
}

function get_single_image($size = 'thumbnail',$post_id=false) {
	global $post;
	if ($post_id===false){
		$post_id = $post->ID;
	}
	$images = get_children(array('post_parent' => $post_id, 
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
	$images = get_children(array('post_parent' => $post_id, 
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


if ( false === get_option("featureds_size_w") ) {
	add_option("featureds_size_w", "300");
	add_option("featureds_size_h", "200");
	add_option("featureds_crop", "1");
} else {
	update_option("featureds_size_w", "300");
	update_option("featureds_size_h", "200");
	update_option("featureds_crop", "1");
}

function additional_image_sizes( $sizes )
{
	$sizes[] = "featureds";

	return $sizes;
}
add_filter( 'intermediate_image_sizes', 'additional_image_sizes' );



/*
function print_post_title() {
	global $post;
	$thePostID = $post->ID;
	$post_id = get_post($thePostID);
	$title = $post_id->post_title;
	$perm = get_permalink($post_id);
	$post_keys = array(); $post_val = array();
	$post_keys = get_post_custom_keys($thePostID);

	if (!empty($post_keys)) {
		foreach ($post_keys as $pkey) {
			if ($pkey=='title_url') {
				$post_val = get_post_custom_values($pkey);
			}
		}
		if (empty($post_val)) {
			$link = $perm;
		} else {
			$link = $post_val[0];
		}
	} else {
		$link = $perm;
	}
	echo '<h2><a href="'.$link.'" rel="bookmark" title="'.$title.'" target="_blank">'.$title.'</a></h2>';
} 

*/

function the_title_link($title=""){
	$return = $title;

	$post_keys = get_post_custom_keys($thePostID);
	if (!empty($post_keys)) {
		foreach ($post_keys as $pkey) {
			if ($pkey=='title_url') {
				$post_val = get_post_custom_values($pkey);
			}
		}
		if (!empty($post_val)) {
			$link = $post_val[0];
		}
	}
	if (is_single() && !empty($link) ){
		$return = "<a href=\"$link\" title=\"$title\" target=\"_blank\">$title</a>";
	}
	return $return;
}

add_filter( 'the_title', 'the_title_link' );

function proximamente() {
	if ( !is_user_logged_in()) { header("Location: http://periodismohumano.com/proximamente/"); }
 
}

function comentarios($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>">
      <div class="comment-author vcard">
         <?php echo get_avatar($comment,$size='48',$default='<path_to_url>' ); ?>

         <?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?>
      </div>
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.') ?></em>
         <br />
      <?php endif; ?>

      <div class="comment-meta commentmetadata"><?php edit_comment_link(__('(Edit)'),'  ','') ?></div>

      <?php comment_text() ?>

      <div class="reply">
         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </div>
     </div>
<?php
        }


add_action('wp','proximamente');

?>
