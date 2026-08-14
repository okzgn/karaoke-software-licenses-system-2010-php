<?php

include("inside.php");
include("ARCHIVO_VARIABLE.php");
?>

<!doctype html>

<html lang="es">

<head>
<meta charset="utf-8">

  <title><?php echo $TITULO_PAGINA; ?></title>

  <meta name="keywords" content="<?php echo $META_KEYWORDS; ?>">
  <meta name="description" content="<?php echo $META_DESCRIPCION; ?>">
  <meta name="robots" content="index,follow">
  <meta name="author" content="OKZGN">


  <link rel="shortcut icon" href="data/icon.ico">

  <link rel="stylesheet" href="data/reset.css">
  <link rel="stylesheet" href="data/theme.css">


  <script src="data/jquery.js"></script>
  <script src="data/ui.js"></script>
</head>

<body>

	<noscript><div id="disabled"><h1><?php echo $NOMBRE_GENERAL; ?></h1><br>Nuestra p&aacute;gina funciona con JavaScript Y Cookies, para continuar activa estas opciones en tu navegador.<br><a href="index.php">Luego, haz clic aqu&iacute;.</a></div></noscript>

	<div id="LIM">
		<div class="LIM-space">
			<div id="Header">
				<h1><a title="<?php echo $NOMBRE_GENERAL; ?>" href="<?php echo $DIRECCION_WEB; ?>"><img src="./IMAGENES/logo.gif" alt="<?php echo $NOMBRE_GENERAL; ?>"></a></h1>
				<div class="rightside">
					<div class="bot">
						<div class="opts"><strong><?php echo $TEXTO_SUPERIOR; ?></strong></div>
						<div class="where"><h2>Inicio</h2></div>
					</div>
				</div>
			</div>

			<div id="Content">
				<div class="tabs">
					<div class="tabs-start">&nbsp;</div>
					<div class="tabs-space">
					<ul>
						<li class="selected"><a href="index.php"><span class="gl"><span class="aw">&gt;</span><span>Inicio</span></span></a></li>
					</ul>
					</div>
					<div class="tabs-end">&nbsp;</div>
				</div>

				<div class="container">
					<div class="container-start">&nbsp;</div>
					<div class="container-space HOME">
						<div class="anun">
						    <?php echo $META_DESCRIPCION; ?><br><br>
							<iframe width="577" height="315" src="<?php echo $DIRECCION_VIDEO; ?>" frameborder="0" allowfullscreen></iframe>
						</div>
						<div class="pointer">

							<div class="left">
								<div class="box">
									<h3>Qui&eacute;nes somos</h3>
									<div class="box-space"><?php echo $QUIENES_SOMOS; ?></div>
								</div>
								<div class="box">
									<h3>Misi&oacute;n</h3>
									<div class="box-space"><?php echo $MISION; ?></div>
								</div>
							</div>

							<div class="right">
								<div class="box">
									<h3>Servicio al cliente</h3>
									<div class="box-space">
										<h4>Direcci&oacute;n:</h4><span><?php echo $DIRECCION; ?></span>
										<br><br><h4>Tel&eacute;fonos:</h4><span><?php echo $TELEFONOS; ?></span>
										<br><br><h4>E-mail:</h4><span><?php echo $MAIL_DE_RECEPCION; ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="container-end">&nbsp;</div>
				</div>
			</div>

			<div id="Footer"><div class="Footer-space">2008-2010 Karaoke LatinMusic &copy; Todos los derechos reservados. | Desarrollado por <a href="http://okzgn.com">OKZGN</a></div></div>
		</div>
	</div>


</body>
</html>
