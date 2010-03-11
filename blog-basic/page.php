<?php get_header() ?>
		<?php while (have_posts()) : the_post(); ?>
			<div class="top clearfix">
				<h2 class="title" id="title-<? the_ID(); ?>">
					<a class="none" href="<?php the_permalink() ?>" rel="bookmark" title="Enlace a <?php the_title_attribute(); ?>">
						<?php the_title(); ?>
					</a>
				</h2>
				<div class="comments">
					<a href="<?php the_permalink() ?>#comments">
						<?php comments_number('(0) comentarios ','(1) comentario','(%) comentarios');?>
					</a>
				</div>
			</div>
			<h5 class="metadata">
				<span class="date"><?	echo date('d.m.Y',strtotime($post->post_date));  ?></span> · <span class="author"><? the_author_posts_link(); ?></span> 
			</h5>

			<div class="entry">
					<?php the_content('Leer más'); ?>
			</div>
			
		
		<?php endwhile; ?>
		<?php comments_template(); ?>
		
	</div>
<?php get_sidebar() ?>
</div>


<?php get_footer() ?>
