<?php
	if ( function_exists('register_sidebar') ){
		 register_sidebar(array(
		     'before_widget' => '<li id="%1$s" class="widget %2$s">',
		     'after_widget' => '</li>',
		     'before_title' => '<h2 class="widgettitle">',
		     'after_title' => '</h2>',
		 ));
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

?>