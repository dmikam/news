<div id="searchbox">
	<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
		<label for="s">Buscar |</label>
		<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" />
		<input type="submit" alt="Buscar" id="searchsubmit" value="Buscar" />
	</form>
</div>