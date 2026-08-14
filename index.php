<?php

include("inside.php");

if(IS_DEDICATED){
	echo file_get_contents(PAGE_LOC . "marks/" . DEDICATED . "/");
}
else {
	include("ARCHIVO_VARIABLE.php");
?>

<!doctype html>

<html lang="es">

<head>
<meta charset="utf-8">

  <title>Karaoke LatinMusic, el primer sistema de karaoke en Ecuador</title>

  <meta name="keywords" content="latinmusic, latin, latin music, karaoke latinmusic, karaoke latin music, karaoke, cybermusic, cyber music, karaoke cyber music, karaoke cybermusic, ciber music, cibermusic, cyber, music, ciber, ecuador, ecua, ecuakaraoke, ecua karaoke">
  <meta name="description" content="Karaoke Latinmusic, el primer sistema de karaoke profesional en Ecuador. Venta y alquiler de karaoke para todo tipo de eventos. Nuestro producto es un software de f�cil instalaci�n, con amplia variedad de �xitos nacionales y del mundo, garantizando as� la diversi�n mediante el canto.">
  <meta name="robots" content="index,follow">
  <meta name="author" content="OKZGN">


  <link rel="shortcut icon" href="data/icon.ico">

  <link rel="stylesheet" href="data/reset.css">
  <link rel="stylesheet" href="data/theme.css">


  <script src="data/jquery.js"></script>
  <script src="data/ui.js"></script>
  <script type="text/javascript">

	$(function(){
		$('.writeus').click(function(){ window.location = 'contact.php'; });

		function open1(e){ e.preventDefault(); var obj=$('iframe');obj.hide();win('<?php echo $ENLACES_DESCARGA_3000; ?>', function(){ obj.show(); },{hideNotBtn:true});}
		function open2(e){ e.preventDefault(); var obj=$('iframe');obj.hide();win('<?php echo $ENLACES_DESCARGA_ACTUALIZACION; ?>', function(){ obj.show(); },{hideNotBtn:true});}

		$('.middle').on('click', open1);
		$('.blackie').on('click', open2);

		$('.lookMoreInfo').click(function(){
			var t = $('#moreInfo');
			if(t.css('display') == 'none'){ t.slideDown(); }
			else { t.slideUp(); }
		});
	});

</script>
</head>

<body>

	<noscript><div id="disabled"><h1>Karaoke Latin Music</h1><br>Nuestra p&aacute;gina funciona con JavaScript Y Cookies, para continuar activa estas opciones en tu navegador.<br><a href="index.php">Luego, haz clic aqu&iacute;.</a></div></noscript>

	<div id="LIM">
		<div class="LIM-space">
			<div id="Header">
				<h1><a title="Karaoke LatinMusic" href="http://www.karaokelatinmusic.com"><img src="data/logo.gif" alt="Karaoke Cybermusic"></a></h1>
				<div class="rightside">
					<div class="bot">
						<?php
							if(IS_ADMIN){ echo '<div class="opts"><span class="silver">Usuario:</span> <strong>Administrador</strong>&nbsp;|&nbsp;<strong><a href="logout.php">Cerrar sesi&oacute;n</a></strong></div>'; }
							else if(IS_SELLER){ echo '<div class="opts space-small"><span class="silver">Usuario:</span> <strong>' . $UserNames . '</strong>&nbsp;|&nbsp;<strong><a href="logout.php">Cerrar sesi&oacute;n</a></strong></div>'; }
							else echo '<div class="opts"><strong>Bienvenid@s a nuestro sitio web oficial</strong></div>';
						?>
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
						<li>

						<?php
							if(IS_ADMIN){ echo '<a href="access.php"><span class="gl"><span class="aw">&gt;</span><span>Panel de control</span></span></a>'; }
							else if(IS_SELLER){ echo '<a href="access.php"><span class="gl"><span class="aw">&gt;</span><span>Cuenta de usuario</span></span></a>'; }
							else echo '<a href="access.php"><span class="gl"><span class="aw">&gt;</span><span>Acceso usuarios</span></span></a>';
						?>

						</li>
						<?php if(!IS_ADMIN){ echo '<li><a href="contact.php"><span class="gl"><span class="aw">&gt;</span><span>Contactar</span></span></a></li><li><a href="buy.php"><span class="gl"><span class="aw">&gt;</span><span>Comprar</span></span></a></li><li><a href="alq.php"><span class="gl"><span class="aw">&gt;</span><span>Alquiler</span></span></a></li>'; } ?>
					</ul>
					</div>
					<div class="tabs-end">&nbsp;</div>
				<br>


				<div class="right">
					<div class="box">
						<h3>Karaoke LatinMusic</h3>
						<div class="box-space"><span><?php echo $NUESTRO_PRODUCTO; ?></span>
						<br><br><h4>Productos:</h4>
						<div class="tugs"><?php echo $PRODUCTOS; ?></div>
						<a class="lookMoreInfo" href="javascript:;">Ver m&aacute;s informaci&oacute;n...</a>
						<div id="moreInfo">
							<br><h4>Caracter&iacute;sticas:</h4>
							<div class="plus"><?php echo $CARACTERISTICAS; ?></div>
							<br><h4>Requisitos m&iacute;nimos:</h4>
							<div class="plus"><?php echo $REQUISITOS; ?></div>
						</div>
						</div>
					</div>

					<div class="box">
						<h3>Cons&uacute;ltenos</h3>
						<div class="box-space">Descuentos especiales para distribuidores. <strong><a class="writeus" href="javascript:;">Escr&iacute;benos</a></strong>
						<br><br><h4>Tel&eacute;fonos (+593):</h4><span><?php echo $TELEFONOS; ?></span></div>
					</div>
				</div>



				</div>

				<div class="container">
					<div class="container-start">&nbsp;</div>
					<div class="container-space HOME">
						<div class="anun"><?php echo $INTRO_PRINCIPAL; ?></div>
						<div class="pointer">

							<div class="left">
								<div class="box">
									<h3>&iquest;Qui&eacute;nes somos?</h3>
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
										<br><br><h4>Tel&eacute;fonos (+593):</h4><span><?php echo $TELEFONOS; ?></span>
										<br><br><div class="center"><button class="writeus s-frm-button">&iexcl;Escr&iacute;benos un mensaje!</button></div>
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
<?php

}

?>
