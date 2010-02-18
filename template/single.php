<?php get_header() ?>
<?php
	if (isset($_GET['video']) && in_category(39)) :
		require_once('post-category-39.php');	
	else :
		require_once('single-common.php');
	endif;
?>

<?php get_footer() ?>
