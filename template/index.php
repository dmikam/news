<?php get_header() ?>
<div id="container">
	<div id="content" class="clearfix">
		<div id="featured" class="clearfix">
			<? $featured = get_posts("category=" . get_category_featured_id() . "&numberposts=1"); ?>
		 	<? foreach($featured as $post) : ?>
		    	<? setup_postdata($post); ?>
		 		<h2><a href="<?php the_permalink(); ?>" id="post-<?php the_ID(); ?>"><?php the_title(); ?></a></h2>
				<? echo get_single_image("large"); ?>
				<div id="excerpt">
					<? the_excerpt(); ?>
				</div>
		 	<?php endforeach; ?>
		</div>
		
		<div id="sub-content" class="clearfix">
			<div id="left">
				<? $width = 350; ?>
				<? $number = "Bloque 1"; ?>
				<? require(TEMPLATEPATH . "/block.php"); ?>
				<? $number = "Bloque 3"; ?>
				<? require(TEMPLATEPATH . "/block.php"); ?>
				<? $number = "Bloque 5"; ?>
				<? require(TEMPLATEPATH . "/block.php"); ?>
				<? $number = "Bloque 7"; ?>
				<? require(TEMPLATEPATH . "/block.php"); ?>
				<? $number = "Bloque 9"; ?>
				<? require(TEMPLATEPATH . "/block.php"); ?>
<?php require(TEMPLATEPATH . "/links_block.php"); ?>	
			</div>
			<div id="right">
				<? $width = 260; ?>
				<? $number = "Bloque 2"; ?>
				<? require(TEMPLATEPATH . "/block.php"); ?>
				<? $number = "Bloque 4"; ?>
				<? require(TEMPLATEPATH . "/block.php"); ?>
				<? $number = "Bloque 6"; ?>
				<? require(TEMPLATEPATH . "/block.php"); ?>
				<? $number = "Bloque 8"; ?>
				<? require(TEMPLATEPATH . "/block.php"); ?>
				<? $number = "Bloque 10"; ?>
				<? require(TEMPLATEPATH . "/block.php"); ?>
			</div>		
		</div>
		
		

	</div>
<?php get_sidebar() ?>
</div>


<?php get_footer() ?>
