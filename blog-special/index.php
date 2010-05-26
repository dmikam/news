<?php get_header() ?>
		<? 
			$multimedia_id = array();
			$multimedia = get_term_by( 'slug', 'multimedia', 'post_tag' );
	 		$multimedia_id[] = (int)$multimedia->term_id;
		?> 
		<div id="video-nav" class="clearfix">
			<div id="more-videos">
				<? query_posts(array('tag__in' => $multimedia_id)); ?>
				<h2>+ info</h2>
				<ul>
				<?php while (have_posts()) : the_post(); ?>
					<li>
						<a href="<?php the_permalink() ?>" title="Enlace a <?php the_title_attribute(); ?>">
							<?php the_title(); ?>
						</a>
					</li>
				<?php endwhile; ?>
				</ul>
				<script type="text/javascript" charset="utf-8">
					$(function() {
						$("#more-videos ul").quickPager({pageSize:5});
					});
				</script>
			</div>
		</div>
		<? query_posts('tag=multimedia+destacada'); ?>
		<?php while (have_posts()) : the_post(); ?>
			<div id="multimedia">
				<?php $multimedia_value = get_post_meta($post->ID, 'multimedia', true); ?>
				<? echo $multimedia_value; ?>
			</div>
			<div id="container">
				<div id="content" class="clearfix">
					<div id="featured">
						<h2 class="title big" id="title-<? the_ID(); ?>">
							<a href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
								<?php the_title(); ?>
							</a>
						</h2>
						<div class="entry">
								<?php the_excerpt(); ?>
								<p><a class="moreinfo" href="<?php the_permalink() ?>">[+] info</a></p>
								
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
					</div>
			<?php endwhile; ?>
				</div> <!-- End of #content -->
				
				<div id="more" class="clearfix">
					<? query_posts(array('tag__not_in' => $multimedia_id)); ?>
					<?php while (have_posts()) : the_post(); ?>
						<div class="post">
							<a  href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
							<? echo get_single_image(); ?>
							</a>
							<h2 class="title medium" id="title-<? the_ID(); ?>">
								<a  href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
									<?php the_title(); ?>
								</a>
							</h2>
							<div class="entry">
								<?php the_excerpt(); ?>
								<p><a class="moreinfo" href="<?php the_permalink() ?>">[+] info</a></p>
							</div>
						</div>		
					<?php endwhile; ?>
				</div>
			</div> <!-- End of #container -->


<?php get_footer() ?>
