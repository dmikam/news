<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title> <?php bloginfo('name'); ?> <?php wp_title(); ?></title>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="all" charset="utf-8" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="shortcut icon" href="<?php bloginfo('template_directory')?>/favicon.ico" />

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_head(); ?>
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js" charset="utf-8"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory')?>/scripts/jquery.thickbox.js" charset="utf-8"></script>
	<link rel="stylesheet" href="<?php bloginfo('template_directory')?>/scripts/jquery.thickbox.css" type="text/css" />
	<? if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function(){
		    $("#menu li").hover(function(){
		        $(this).addClass("hover");
		        $('ul:first',this).css('visibility', 'visible');

		    }, function(){

		        $(this).removeClass("hover");
		        $('ul:first',this).css('visibility', 'hidden');

		    });

		    $("#menu li ul li:has(ul)").find("a:first").append(" &raquo; ");

		});
	</script>
</head>
<body>
	<div id="header" class="clearfix">
		<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
	</div>
	<div id="navbar" class="clearfix">
		<ul id="menu">
			<? wp_list_categories('title_li=&depth=1&hide_empty=0&orderby=term_order&exclude=39,24,25,26,310,311,313,314,309,40,308'); ?>
		</ul>
		<ul id="second-menu">
			<li><a href="">Enfoques</a></li>
			<li><a href="">Enfoques</a></li>
			<li class="rss-link"><a href="">RSS</a></li>	
		</ul>
		<?php // include (TEMPLATEPATH . '/searchform.php'); ?>
	</div>
	<div id="header_bar" class="clearfix">
		<div id="date">
			<? the_current_date(); ?>
		</div>
		<div id="login_bar">
			<? if (is_user_logged_in()) { ?>
				<? global $current_user; ?>
				<? get_currentuserinfo(); ?>
				¡Hola <strong><? echo $current_user->display_name; ?></strong>!  
				<a href="/wp-admin">Accede al panel</a>  | 
				<a href='<?php echo wp_logout_url(); ?>&amp;redirect_to=<? the_current_url() ?>'>Desconecta</a>
			<? } else { ?>
				<a href="/iniciar-sesion/?height=220&amp;width=350&amp;redirect_to=<? the_current_url() ?>" class="thickbox" title="Iniciar sesión">Inicia sesión</a>  |  
				<a href="#">Registrate</a>
			<? } ?>
		</div>
	</div>