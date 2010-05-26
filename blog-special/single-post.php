<?php get_header() ?>

<div id="container">
	<div id="content" class="clearfix">
		<?php while (have_posts()) : the_post(); ?>
			<h2 class="title big" id="title-<? the_ID(); ?>">
				<a href="<?php the_permalink() ?>" title="Enlace a <?php the_title_attribute(); ?>">
					<?php the_title(); ?>
				</a>
			</h2>
			<div class="entry">
					<?php the_content('Leer más &raquo;'); ?>
			</div>
			<div class="share_and_tags">
				<div class="tags clearfix">
					<strong class="tag-title">etiquetas</strong>  <p><? the_tags('',', '); ?></p>
				</div>
				<div  class="clearfix share">
					<strong class="share-title">comparte</strong> 
					<ul class="share-services">
						<li class="facebook"><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title_attribute(); ?>" title="Enviar a facebook" target="blank">Facebook</a></li>
						<li class="meneame"><a href="http://meneame.net/submit.php?url=<?php the_permalink();?>" target="_blank" title="Enviar a Meneame">Meneame</a></li>
						<li class="digg"><a href="http://digg.com/submit?phase=2&url=<?php the_permalink();?>" target="_blank" title="Enviar a Digg">Digg</a></li>
						<li class="twitter"><a href="http://twitter.com/home?status=Estoy leyendo <?php the_permalink(); ?>" title="Enviar a twitter" target="_blank">Twitter</a></li>	
						<li class="bitacoras"><a href="http://bitacoras.com/anotaciones/<?php the_permalink(); ?>" title="Enviar a bitacoras.com" target="_blank">Bitacoras</a></li>		
					</ul>
				</div>
			</div>
		<?php endwhile; ?>
		<?php comments_template(); ?>
		
	</div>
</div>


<?php get_footer() ?>