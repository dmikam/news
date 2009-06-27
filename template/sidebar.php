<div id="sidebar">
	<div id="more-featured">
		<? $featured = get_posts("category=26&numberposts=10"); ?>
		<? $cnt = 0; ?>
	 	<? foreach($featured as $post) : ?>
	    	<? setup_postdata($post); ?>
			<div class="featured-item <? echo $cnt==0 ? "active" : ""; ?>">
				<h2><a href="<?php the_permalink(); ?>" id="post-<?php the_ID(); ?>"><?php the_title(); ?></a></h2>
				<? echo get_single_image("large"); ?>
			</div>
	 	<?php $cnt++; endforeach; ?>
	</div>
	
</div>

<script type="text/javascript" charset="utf-8">
	
	function slideSwitch() {
	    var $active = jQuery('#more-featured .featured-item.active');

	    if ( $active.length == 0 ) $active = jQuery('#more-featured .featured-item:last');

	    var $next =  $active.next().length ? $active.next()
	        : jQuery('#more-featured .featured-item:first');

	    $active.addClass('last-active');

	    $next.css({opacity: 0.0})
	        .addClass('active')
	        .animate({opacity: 1.0}, 1000, function() {
	            $active.removeClass('active last-active');
	        });
	}

	jQuery(function() {
	    setInterval( "slideSwitch()", 10000 );
	});

</script>