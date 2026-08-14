<?php

include("inside.php");

if(IS_DEDICATED){
	header('location:' . PAGE_LOC);
}
else {
	if(IS_ADMIN) header("location: access.php");
?>
<!doctype html>

<html lang="es">

<head>
<meta charset="utf-8">

  <title>Karaoke LatinMusic &gt; Contacto</title>

  <meta name="description" content="Karaoke LatinMusic, el primer sistema de karaoke profesional en Ecuador. Venta y alquiler de karaoke profesional para todo tipo de eventos.">
  <meta name="robots" content="noindex,nofollow">
  <meta name="author" content="OKZGN">


  <link rel="shortcut icon" href="data/icon.ico">

  <link rel="stylesheet" href="data/reset.css">
  <link rel="stylesheet" href="data/theme.css">


  <script src="data/jquery.js"></script>
  <script src="data/ui.js"></script>

</head>

<body>

	<noscript><div id="disabled"><h1>Karaoke LatinMusic</h1><br>Nuestra p&aacute;gina funciona con JavaScript Y Cookies, para continuar activa estas opciones en tu navegador.<br><a href="contact.php">Luego, haz clic aqu&iacute;.</a></div></noscript>

	<div id="LIM">
		<div class="LIM-space">
			<div id="Header">
				<h1><a title="Karaoke LatinMusic" href="http://www.karaokelatinmusic.com"><img src="data/logo.gif" alt="Karaoke LatinMusic"></a></h1>
				<div class="rightside">
					<div class="bot">
						<?php
							if(IS_ADMIN){ echo '<div class="opts"><span class="silver">Usuario:</span> <strong>Administrador</strong>&nbsp;|&nbsp;<strong><a href="logout.php">Cerrar sesi&oacute;n</a></strong></div>'; }
							else if(IS_SELLER){ echo '<div class="opts space-small"><span class="silver">Usuario:</span> <strong>' . $UserNames . '</strong>&nbsp;|&nbsp;<strong><a href="logout.php">Cerrar sesi&oacute;n</a></strong></div>'; }
							else echo '<div class="opts"><strong>Bienvenid@s a Karaoke LatinMusic</strong></div>';
						?>
						<div class="where"><h2>Contactar</h2></div>
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
						<li class="selected"><a href="contact.php"><span class="gl"><span class="aw">&gt;</span><span>Contactar</span></span></a></li><li><a href="buy.php"><span class="gl"><span class="aw">&gt;</span><span>Comprar</span></span></a></li><li><a href="alq.php"><span class="gl"><span class="aw">&gt;</span><span>Alquiler</span></span></a></li>
					</ul>
					</div>
					<div class="tabs-end">&nbsp;</div>
				</div>

				<div class="container">
					<div class="container-start">&nbsp;</div>
					<div class="container-space CONTACT">

						<?php

						$ml_names = Post("ml_names");
						$ml_subject = Post("ml_subject");
						$ml_message = Post("ml_message");

						if($ml_names && $ml_subject && $ml_message){
							$emailVal = validateEmail($ml_names);
							if(substr($ml_names, 0, 3) == "***") $emailVal = true;
							if($emailVal && strlen($ml_subject) > 3 &&  strlen($ml_subject) < 48 && strlen($ml_message) > 16 && strlen($ml_message) < 1800){

								if(connectTo_GRL() == "Ready"){

									$e_msg = mysql_query("select ref from messages where (names='". htmlentities($ml_names) ."' And subject='". htmlentities($ml_subject) ."')");
									$exist_msg = gettype(mysql_fetch_object($e_msg)) != "boolean";

									if(!$exist_msg){
										$message_stat = mysql_query("insert into messages values(0, '". htmlentities($ml_names) ."', '". htmlentities($ml_subject) ."', '". htmlentities(preg_replace("/\r\n/", "<br>" , $ml_message)) ."')");

										if($message_stat){
											echo '<h3 class="response green">Tu mensaje ha sido enviado exitosamente</h3>';
										}
										else {
											echo '<h3 class="response red">Ha ocurrido un error al enviar el mensaje, int&eacute;ntalo en otro momento</h3>';
										}
									}
									else {
										echo '<h3 class="response red">No se puede enviar este mensaje, es muy parecido al anterior</h3>';
									}
								}
								else {
									echo '<h3 class="response red">Ha ocurrido un error inesperado</h3>';
								}
							}
							else {
								echo '<h3 class="response red">Revise que los campos est&eacute;n correctamente escritos antes de enviarlos</h3>';
							}
						}
						?>
						<form action="contact.php" method="post">
							<fieldset>
								<h3 class="blue">Enviar mensaje</h3>
								<div class="box">
									<span class="lblue">* No se admiten mensajes muy largos, sea breve en su contenido.</span>
									<?php
										if(IS_SELLER){ echo '<input type="hidden" name="ml_names" value="***' . $UserNames . '">'; }
										else echo '<h4>E-mail</h4><input class="s-frm-text" type="text" name="ml_names">';
									?>
									<h4>Asunto</h4>
									<input class="s-frm-text" type="text" name="ml_subject">
									<h4>Mensaje</h4>
									<textarea class="s-frm-text" name="ml_message"></textarea>
									<input class="s-frm-button" type="submit" value="Enviar">
								</div>
							</fieldset>
						</form>
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
