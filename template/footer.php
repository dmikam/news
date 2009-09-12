	<div id="footer" class="clearfix">
		 <?php dynamic_sidebar("Pie"); ?> 
		<div id="foot_links" class="block">
			<h3>Más en Periodismo Humano</h3>
			<ul>
				<? wp_list_pages('title_li='); ?>
				<? wp_list_categories('hierarchical=0&title_li=&hide_empty=0&orderby=term_order&exclude=39,24,25,26,310,311,313,314,309,40,308'); ?>
				
			</ul>
		</div>
	</div>
</body>
</html>