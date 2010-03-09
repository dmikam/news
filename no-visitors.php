<?php
/*
Plugin Name: No visitors
Plugin URI: 
Description: Evita visitantes al sitio
Version: 1.0.0
Author: Daniel Aguilar
Author URI: 
Disclaimer: 
*/

add_action('wp','proximamente');

function proximamente() {
	if ( !is_user_logged_in()) { header("Location: http://periodismohumano.com/proximamente/"); }
}
?>