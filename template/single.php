<?php get_header() ?>
<?php
	if (in_category(39)){
		require_once('post-category-39.php');	
	}else{
		require_once('single-common.php');
	}
?>

<?php get_footer() ?>
