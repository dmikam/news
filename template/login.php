<?
/*
	Template Name: Login
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
	  	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
		<meta name="Author" content="" />
		<meta name="Keywords" content="" />
		<meta name="description" content="" />
		<link rel="stylesheet" href="styles.css" type="text/css" media="all" />
		<title>Inicia sesión</title>
	</head>
	<body>
		<form name="loginform" id="loginform" action="http://enfoque19.com/wp-login.php" method="post">
			<p>
				<label>Usuario<br />
				<input type="text" name="log" id="user_login" class="input" value="" size="20" tabindex="10" /></label>
			</p>
			<p>
				<label>Contraseña<br />
				<input type="password" name="pwd" id="user_pass" class="input" value="" size="20" tabindex="20" /></label>

			</p>
			<div class="clearfix">
				<div id="nav">
				<p class="forgetmenot"><label><input name="rememberme" type="checkbox" id="rememberme" value="forever" tabindex="90" /> Recuerdame</label></p>
				<p><a href="http://enfoque19.com/wp-login.php?action=lostpassword" title="Recuperar contraseña">¿No recuerdas tu contraseña?</a>
				</p>
				</div>
				<p class="submit">
					<input type="submit" name="wp-submit" id="wp-submit" value="Entrar" tabindex="100" />
					<input type="hidden" name="redirect_to" value="<? echo $_GET['redirect_to']?>" />
					<input type="hidden" name="testcookie" value="1" />
				</p>
			</div>

		</form>


		
	</body>
</html>