<?php get_header() ?>
<div id="container" class="clearfix">
	<div id="content" class="clearfix">
		<? $featured = get_posts("category=" . get_category_featured_id() . "&numberposts=1"); ?>
		<? if (!empty($featured)) : ?>
		<div id="featured" class="clearfix">
		 	<? foreach($featured as $post) : ?>
				<? $raw_content =  get_meta('raw'); ?>
		    	<? setup_postdata($post); ?>
				<? $featured_post_id = get_the_ID(); ?>
		
				<? if (empty($raw_content)) : ?>
			 		<h2><a href="<?php the_permalink(); ?>" id="post-<?php the_ID(); ?>"><?php the_title(); ?></a></h2>
					<a href="<?php the_permalink(); ?>" title="<? the_title(); ?>">	<? echo get_single_image("large"); ?> </a>
					<div id="excerpt">
						<h5 class="metadata">
						<span class="date"><?	echo date('d.m.Y',strtotime($post->post_date));  ?></span> · <span class="author"><? the_author_posts_link(); ?></span> 
						</h5>
						<? the_excerpt(); ?>
					</div>
				<? else : ?>
					<? echo apply_filters( 'the_content', $raw_content); ?>
				<? endif; ?>
		 	<?php endforeach; ?>
		</div>
		<? endif; // Si no hay posts destacado, no se muestra nada ?>
		
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
			</div>
			<div id="right">
				<? $width = 214; ?>
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
