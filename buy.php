<?php

include("inside.php");

if(IS_DEDICATED){
	header('location:' . PAGE_LOC);
}
else {
	include("ARCHIVO_VARIABLE.php");
	if(IS_ADMIN) header("location: access.php");
?>
<!doctype html>

<html lang="es">

<head>
<meta charset="utf-8">

  <title>Karaoke Latinmusic &gt; Comprar</title>

  <meta name="keywords" content="karaoke, cybermusic, karaoke cybermusic, ecua karaoke">
  <meta name="description" content="Karaoke Latinmusic, el primer sistema de karaoke profesional en Ecuador">
  <meta name="robots" content="noindex,nofollow">
  <meta name="author" content="OKZGN">

  <link rel="shortcut icon" href="data/icon.ico">

  <link rel="stylesheet" href="data/reset.css">
  <link rel="stylesheet" href="data/theme.css">


  <script src="data/jquery.js"></script>
  <script src="data/ui.js"></script>
  <script type="text/javascript"></script>
</head>

<body>

	<noscript><div id="disabled"><h1>Karaoke Latinmusic</h1><br>Nuestra p&aacute;gina funciona con JavaScript Y Cookies, para continuar activa estas opciones en tu navegador.<br><a href="index.php">Luego, haz clic aqu&iacute;.</a></div></noscript>

	<div id="LIM">
		<div class="LIM-space">
			<div id="Header">
				<h1><a title="Karaoke Latinmusic" href="http://www.karaokelatinmusic.com"><img src="data/logo.gif" alt="Karaoke Latinmusic"></a></h1>
				<div class="rightside">
					<div class="bot">
						<?php
							if(IS_ADMIN){ echo '<div class="opts"><span class="silver">Usuario:</span> <strong>Administrador</strong>&nbsp;|&nbsp;<strong><a href="logout.php">Cerrar sesi&oacute;n</a></strong></div>'; }
							else if(IS_SELLER){ echo '<div class="opts space-small"><span class="silver">Usuario:</span> <strong>' . $UserNames . '</strong>&nbsp;|&nbsp;<strong><a href="logout.php">Cerrar sesi&oacute;n</a></strong></div>'; }
							else echo '<div class="opts"><strong>Bienvenid@s a Karaoke Latinmusic</strong></div>';
						?>
						<div class="where"><h2>Comprar</h2></div>
					</div>
				</div>
			</div>

			<div id="Content">
				<div class="tabs">
					<div class="tabs-start">&nbsp;</div>
					<div class="tabs-space">
					<ul>
						<li><a href="index.php"><span class="gl"><span class="aw">&gt;</span><span>Inicio</span></span></a></li>
						<li>

						<?php
							if(IS_ADMIN){ echo '<a href="access.php"><span class="gl"><span class="aw">&gt;</span><span>Panel de control</span></span></a>'; }
							else if(IS_SELLER){ echo '<a href="access.php"><span class="gl"><span class="aw">&gt;</span><span>Cuenta de usuario</span></span></a>'; }
							else echo '<a href="access.php"><span class="gl"><span class="aw">&gt;</span><span>Acceso usuarios</span></span></a>';
						?>

						</li>
						<?php if(!IS_ADMIN){ echo '<li><a href="contact.php"><span class="gl"><span class="aw">&gt;</span><span>Contactar</span></span></a></li><li class="selected"><a href="buy.php"><span class="gl"><span class="aw">&gt;</span><span>Comprar</span></span></a></li><li><a href="alq.php"><span class="gl"><span class="aw">&gt;</span><span>Alquiler</span></span></a></li>'; } ?>
					</ul>
					</div>
					<div class="tabs-end">&nbsp;</div>
				</div>

				<div class="container">
					<div class="container-start">&nbsp;</div>
					<div class="container-space BUY"><?php echo $CONTENIDO_PAGINA_COMPRAR; ?>
					</div>
					<div class="container-end">&nbsp;</div>
				</div>
			</div>

			<div id="Footer"><div class="Footer-space">2008-2010 Karaoke Latinmusic &copy; Todos los derechos reservados. | Desarrollado por <a href="http://okzgn.com">OKZGN</a></div></div>
		</div>
	</div>


</body>
</html>
<?php

}

?>
