<?php
	if ( function_exists('register_sidebar')){
		 register_sidebar(array(
		     'before_widget' => '<div id="%1$s" class="block clearfix %2$s">',
		     'after_widget' => '</div>',
		     'before_title' => '<h3 class="title">',
		     'after_title' => '</h3>',
			  'name' => 'Lateral',
		 ));
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

	function get_single_image($size = 'thumbnail',$post_id=0) {
		if ($post_id==0){
			global $post;
			$post_id = $post->ID;
		}
		$images = get_children("post_parent=$post_id&post_type=attachment&post_mime_type=image&numberposts=1");
		if (empty($images)) :
			return "<img src='" . get_bloginfo('template_directory') . "/images/default.png'>";
		else :
			foreach ($images as $image) :
				return wp_get_attachment_image($image->ID,$size);
			endforeach;
		endif;
	}


	function get_the_slug($post_id=0) {
		if ($post_id==0){
			global $post;
			$post_id = $post->ID;
		}
		$post_data = get_post($post_id, ARRAY_A);
		$slug = $post_data['post_name'];
		return $slug;
	}

	function the_slug($post_id=0){
		echo get_the_slug($post_id);
	}

	function gallery($atts=''){
		$return = '';
		$params = shortcode_atts(array(
			'numberposts'	=> -1,
			'post_parent'	=> get_the_ID(),
			'size'			=> 'thumbnail',
			'zoom_size'		=> 'full',
			'order'			=> 'DESC',
			'orderby'		=> 'menu_order',
			'shift'			=> 0,
			'group'			=> 'gallery',
			'class'			=> '',
			'item_class'	=> 'item',
			'use_list'		=> true,
			'use_links'		=> true,
			'description'	=> false,
			'default_style'=>	false
		), $atts);

		$params['post_type'] = "attachment";
		$params['post_mime_type'] = "image";

		if($params['default_style']){
			$return .= "<style>
					.$params[group] li {
						float:left;
						margin:5px;
					}
				</style>";
		}
		$images = get_children($params);
		if (!empty($images)){
			for ($i = 0; $i < abs($params['shift']); $i++){
				if ((int)$params['shift']>0){
					$tmp = array_shift($images);
					array_push($images,$tmp);
				}else{
					$tmp = array_pop($images);
					array_unshift($images,$tmp);
				}
			}

			$return .= $params['use_list'] ? "<ul class=\"$params[group] $params[class]\">" : '';
			foreach ($images as $image){
				$thumb_image = wp_get_attachment_image_src($image->ID,$params['size']);
				$zoom_image = wp_get_attachment_image_src($image->ID,$params['zoom_size']);

				$return .= $params['use_list'] ? "\n\t<li class=\"$params[item_class]\">" : '';
				if ($params['use_links']){
					$return .= "<a href=\"$zoom_image[0]\" rel=\"lightbox[$params[group]]\"  title=\"{$image->post_title}\" alt=\"{$image->post_content}\">";
				}
				$return .= "<img src=\"$thumb_image[0]\" width=\"$thumb_image[1]\" height=\"$thumb_image[2]\" title=\"{$image->post_title}\" alt=\"{$image->post_content}\"  />";
				if ($params['use_links']){
					$return .= "</a>";
				}
				if ($params['description']){
					$return .= "<div class=\"description\">{$image->post_title}</div>";
				}
				$return .= $params['use_list'] ? "</li>" : '';
			}
			$return .=  $params['use_list']? "</ul>" : '';
		}
		return $return;
	}
	//make changeable header
	define('HEADER_TEXTCOLOR', '');
	define('HEADER_IMAGE', '%s/setta.jpg'); // %s is theme dir uri
	define('HEADER_IMAGE_WIDTH', get_option('custom_image_width'));
	define('HEADER_IMAGE_HEIGHT', get_option('custom_image_height'));
	define( 'NO_HEADER_TEXT', true );

	function blogbasics_admin_header_style() {

	}

	function header_style() {
	?>
		<style type="text/css">
		body {
			background: url(<?php header_image() ?>) center 40px no-repeat;
		}
		</style>

	<?php
	}

	add_custom_image_header('header_style', 'blogbasics_admin_header_style');
	add_option('custom_image_height',847);
	add_option('custom_image_width',1600);
	
	
	
	function proximamente() {
		if (!is_user_logged_in()) { header("Location: http://periodismohumano.com/"); }
	}
	add_action('wp','proximamente');
	
	add_filter('init', create_function('$a', 'global $wp_rewrite; $wp_rewrite->author_base = "autor"; $wp_rewrite->flush_rules();'));
	
	
?>