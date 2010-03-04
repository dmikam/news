	<div id="footer_widgets" class="clearfix">
		<div class="clearfix">
			<?php  dynamic_sidebar("Pie 50"); ?> 
		</div>
		<div class="clearfix">
			<?php  dynamic_sidebar("Pie 25"); ?> 
		</div>
		<div class="clearfix">
			<?php  dynamic_sidebar("Pie 33"); ?> 
		</div>
	</div>
	<div id="footer" class="clearfix">
		<div id="line_titles" class="line clearfix">
			<div class="footer_content">
				<h3 class="contact">Y más</h3>
				<h3 class="what">De qué hablamos</h3>
				<h3 class="who">Quiénes somos</h3>
			</div>
		</div>
		<div id="line_content" class="line clearfix">
			<div class="footer_content">
			
			<h3 id="phlogo">Periodismo Humano</h3>

			<ul class="contact">
				<li><a href="http://periodismohumano.com/contacto">Contacto</a></li>
				<li><a href="http://periodismohumano.com/condiciones-legales">Condiciones de uso / Aviso legal</a></li>
				<li><a href="http://periodismohumano.com/creative-commons">Creative Commons</a></li>
				<li><a href="http://periodismohumano.com/canales-rss">Canales RSS</a></li>
			</ul>
			<ul class="what">
				<? wp_list_categories('title_li=&depth=1&hide_empty=0&orderby=term_order&exclude=39,24,25,26,310,311,313,314,309,40,308'); ?>
			</ul>
			<ul class="who">
				<li><a href="http://periodismohumano.com/que-es-periodismohumano-com">Qué es periodismohumano.com</a></li>
				<li><a href="http://periodismohumano.com/el-equipo">El Equipo</a></li>
				<li><a href="http://periodismohumano.com/quien-nos-apoya">Quién nos apoya</a></li>
				<li><a href="http://periodismohumano.com/hazte-socio-de-periodimohumano-com">Hazte socio de periodismohumano</a></li>
				<li><a href="http://periodismohumano.com/mas-dudas-faq">Más dudas (FAQ)</a></li>
			</ul>
			</div>
		</div>
		<div id="line_socials" class="clearfix line">
			<div class="footer_content">
			
			<ul class="social">
				<li><a class="facebook" href="">facebook</a></li>
				<li><a class="twitter" href="">twitter</a></li>
				<li><a class="rss" href="">rss</a></li>
			</ul>
			<h3 id="followus">Síguenos...</h3>
			</div>
		</div>
	</div>
</body>
</html>