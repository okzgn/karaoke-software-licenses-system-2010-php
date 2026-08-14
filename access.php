<?php
	include("inside.php");
	include("ARCHIVO_VARIABLE.php");

if(IS_DEDICATED){

header('location:' . PAGE_LOC);

}
else {

	$SPECIAL_ACCESS = (Get("special") == $COMODIN_DE_ACCESO ? true : false);

	$DB_CONNECTION = connectTo_GRL();
	$CONNECTION = ($DB_CONNECTION == "Ready");

?>
<!doctype html>

<html lang="es">

<head>
<meta charset="utf-8">

  <title>Karaoke LatinMusic &gt; Acceso usuarios</title>

  <meta name="description" content="Karaoke LatinMusic, el primer sistema de karaoke profesional en Ecuador">
  <meta name="robots" content="noindex,nofollow">
  <meta name="author" content="OKZGN">


  <link rel="shortcut icon" href="data/icon.ico">

  <link rel="stylesheet" href="data/reset.css">
  <link rel="stylesheet" href="data/theme.css">


  <script src="data/jquery.js"></script>
  <script src="data/ui.js"></script>
<?php if(IS_ADMIN){ ?><script src="data/mg.js"></script><?php } ?>
<?php if(IS_SELLER){ ?><script id="mgu" src="data/mgu.js?ref=<?php echo $UserID; ?>"></script><?php } ?>

</head>

<body>

	<noscript><div id="disabled"><h1>Karaoke LatinMusic</h1><br>Nuestra p&aacute;gina funciona con JavaScript Y Cookies, para continuar activa estas opciones en tu navegador.<br><a href="access.php">Luego, haz clic aqu&iacute;.</a></div></noscript>

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

						<div class="where">

						<?php
							if(IS_ADMIN){ echo '<h2>Panel de control</h2>'; }
							else if(IS_SELLER){ echo '<h2>Cuenta de usuario</h2>'; }
							else echo '<h2>Acceso usuarios</h2>';
						?>

						</div>
					</div>
				</div>
			</div>

			<div id="Content">
				<div class="tabs">
					<div class="tabs-start">&nbsp;</div>
					<div class="tabs-space">
					<ul>
						<li><a href="index.php"><span class="gl"><span class="aw">&gt;</span><span>Inicio</span></span></a></li>
						<li class="selected">

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
				</div>

				<div class="container">
					<div class="container-start">&nbsp;</div>
					<div class="container-space ACCESS">
	<?php
	if(IS_ADMIN){

		if(Get("response") == "msgErased") echo '<h3 class="response green">Se han borrado todos los mensajes existentes</h3>';
		if(Get("response") == "msgEraseFail") echo '<h3 class="response red">Ha ocurrido un error al intentar borrar los mensajes</h3>';

	?>


	<?php

		$nw_names = Post("nw_names");
		$nw_sign = Post("nw_sign");
		$nw_username = Post("nw_username");
		$nw_password = Post("nw_password");

		if($nw_names && $nw_sign && $nw_username && $nw_password){

			$SECTOR = "<h3>Error en <strong>Agregar usuario</strong></h3>";

			if(strlen($nw_names) > 3 && strlen($nw_names) < 49 && strlen($nw_sign) > 3 && strlen($nw_sign) < 49 && preg_match('/^[a-z\d_]{4,24}$/i', $nw_username) && strlen($nw_password) > 5){

				if($CONNECTION){

					$nw_username = strtolower($nw_username);

					$e_user = mysql_query("select ref from sellers where (username='". $nw_username ."')");
					$exist_user = gettype(mysql_fetch_object($e_user)) != "boolean";

					if(!$exist_user){
						$message_stat = mysql_query("insert into sellers values(0, '". $nw_username ."', '". sha1($nw_password) ."', '". htmlentities($nw_names) ."', '". htmlentities($nw_sign) ."', 0, 0, '0000-00-00')");

						if($message_stat){
							echo '<h3 class="response green biggie">Se ha agregado al usuario <strong>' . $nw_names . '</strong> correctamente</h3>';
						}
						else {
							echo '<div class="response red">' . $SECTOR . 'No se ha podido agregar al nuevo usuario</div>';
						}
					}
					else {
						echo '<div class="response red">' . $SECTOR . 'Este usuario ya esta registrado en la base de datos</div>';
					}
				}
				else {
					echo '<div class="response red">' . $SECTOR . 'Ha ocurrido un error inesperado, vuelve a intentarlo</div>';
				}
			}
			else {
				echo '<div class="response red">' . $SECTOR . 'No se pudo agregar al usuario, alguno de los campos es muy corto, demasiado largo o es incorrecto</div>';
			}
		}





		$al_user = Post("al_user");
		$al_licences = Post("al_licences");
		$al_price = Post("al_price");

		if($al_user && $al_licences && $al_price){

			$SECTOR = "<h3>Error en <strong>Atribuir licencias</strong></h3>";

			if($al_licences > 0 && $al_licences < 999){
			if($al_price >= 10){

				if($CONNECTION){
					$al_user = explode("^^", $al_user);
					$set_licences = mysql_query("update sellers set lic_actived=lic_actived+" . $al_licences . " where ref=" . $al_user[0] . ";");
					$set_money = mysql_query("insert into money values(0, " . $al_user[0] . ", '". htmlentities($al_user[1]) ."', '". $al_licences ."', '" . $al_price . "', '" . ($al_price * $al_licences) . "', '" . date("Y-m-d") . "');");

					if($set_licences && $set_money){
						echo '<h3 class="response green biggie">Has atribuido <strong>' . $al_licences . ' licencias</strong> al usuario <strong>' . $al_user[1] . '</strong></h3>';
					}
					else {
						echo '<div class="response red">' . $SECTOR . 'No es posible atribuir licencias al usuario</div>';
					}
				}
				else {
					echo '<div class="response red">' . $SECTOR . 'Ha ocurrido un error inesperado, vuelve a intentarlo</div>';
				}
			}
			else {
				echo '<div class="response red">' . $SECTOR . 'No se puede agregar, el monto m&iacute;nimo por cada licencia es de $10</div>';
			}
			}
			else {
				echo '<div class="response red">' . $SECTOR . 'El n&uacute;mero de licencias ingresado no es v&aacute;lido</div>';
			}
		}


	?>



	<?php

		$num_users = 0;

		if($CONNECTION){
			$all_users	= mysql_query("select ref, names, username, sign, lic_actived, lic_used, last from sellers");
			$users_list	= captureData($all_users);

			$num_users	= ($users_list == 0 ? 0 : count($users_list));

			mysql_free_result($all_users);

			$users_list = order($users_list);
		}
	?>



						<div class="pointer">

						<div class="chunker left">
						<form class="special alic" action="access.php" method="post">
							<fieldset>
								<h3 class="blue">Atribuir licencias</h3>
								<div class="box">

								<?php

								if($num_users == 0){ echo '<span class="not-found-short">No se ha agregado ning&uacute;n usuario</span>'; }
								else {

									echo '<h4>Usuario</h4><select id="usrToAtt" name="al_user">';

									for($i = 0; $i < $num_users; $i++){
										$data = explode("^^", $users_list[$i]);
										$ref = $data[0];
										$names = html_entity_decode($data[1]);
										$namesComplete = html_entity_decode($data[1]);

										$names = explode(" ", $names);
										if(count($names) > 1){ $names = $names[0] . " " . $names[1]; }
										else { $names = $namesComplete; }

										echo '<option title="Usuario: ' . $namesComplete . '" ' . ($i == 0 ? 'selected="selected"': '') . ' value="' . $ref . '^^' . $namesComplete . '">' . $names . '</option>';
									}

									echo '</select>
										<h4>N&ordm;&nbsp;Licencias&nbsp;&nbsp;&nbsp;Precio Unitario</h4>
										<input class="s-frm-text" type="text" name="al_licences">
										<input class="s-frm-text" type="text" name="al_price">
										<input class="attrib s-frm-button" type="submit" value="Atribuir">';

								}

								?>
								</div>

							</fieldset>

						</form><br>

						<form class="special seel" action="access.php" method="post">
							<fieldset>
								<h3 class="blue">Gestionar licencias</h3>
								<div class="box">

								<?php

								if($num_users == 0){ echo '<span class="not-found-short">No se ha agregado ning&uacute;n usuario</span>'; }
								else {
									echo '<h4>Usuario</h4><select class="usersList" name="lics_of">';

									$haveReq = Post("lics_of");
									$stdUser = ($haveReq ? explode("^^", $haveReq) : false);

									for($i = 0; $i < $num_users; $i++){
										$data = explode("^^", $users_list[$i]);
										$ref = $data[0];
										$names = html_entity_decode($data[1]);
										$namesComplete = html_entity_decode($data[1]);

										if(!$stdUser){ $quest = ($i == 0 ? 'selected="selected"': ''); }
										else { $quest = ($ref == $stdUser[0] ? 'selected="selected"': ''); }

										$names = explode(" ", $names);
										if(count($names) > 1){ $names = $names[0] . " " . $names[1]; }
										else { $names = $namesComplete; }

										echo '<option title="Usuario: ' . $namesComplete . '" ' . $quest . ' value="' . $ref . '^^' . $namesComplete . '">' . $names . '</option>';
									}

									echo '</select> <input type="submit" class="seeb s-frm-button" value="Ver">';

								}

								?>

	<?php
		if($CONNECTION){
			$lics_of = Post("lics_of");

			if($lics_of){
				$lics_of = explode("^^", $lics_of);
				$get_lics = mysql_query("select ord, client, firstCode, activationCode, creation from generated where (ref='" . $lics_of[0] . "')");
				$the_lics = captureData($get_lics);
				if($the_lics == 0){
					echo '<div class="not-found-short">El usuario <strong>' . $lics_of[1] . '</strong> no ha generado ninguna licencia</div>';
				}
				else {
					mysql_free_result($get_lics);

					$num_lics = count($the_lics);

					$ref = $lics_of[0];
					$user = $lics_of[1];

					echo '<div class="space">';
					echo '<h4>Licencias de <span class="stdUser yellow">' . $user  . '</span></h4><br><strong class="silver">Cliente: </strong><select class="clientList">';

						$the_lics = order($the_lics);

						for($i = 0; $i < $num_lics; $i++){
							$data = explode("^^", $the_lics[$i]);
							$ord = $data[0];
							$client = html_entity_decode($data[1]);
							$clientComplete = html_entity_decode($data[1]);
							$firstCode = $data[2];
							$activationCode = $data[3];
							$creation = $data[4];

							if(Post("stdLic")){ $quest = ($ord == Post("stdLic") ? 'selected="selected"': ''); }
							else { $quest = ($i == 0 ? 'selected="selected"': ''); }

							$client = explode(" ", $client);
							if(count($client) > 1){ $client = $client[0] . " " . $client[1]; }
							else { $client = $clientComplete; }

							echo '<option title="Cliente: ' . $clientComplete . '" ' . $quest . ' value="' . $ref . '^^' . $ord . '^^' . $clientComplete . '^^' . $firstCode . '^^' . $activationCode . '^^' . $creation . '">' . $ord . '. ' . $client . '</option>';
						}

					echo '</select><br><input type="button" class="getlic s-frm-button" value="Revisar"> <input type="button" class="modlic s-frm-button" value="Modificar"> <input type="button" class="dellic s-frm-button" value="Borrar">';

					echo '</div>';
				}
			}

		}
	?>


								</div>

							</fieldset>

						</form><br>
						<form class="special searchLics" action="access.php" method="post">
							<fieldset>
								<h3 class="blue">Buscar licencias</h3>
								<div class="box">

								<?php

								if($num_users == 0){ echo '<span class="not-found-short">No se ha agregado ning&uacute;n usuario</span>'; }
								else {

									echo '<h4>Usuario</h4><select id="seaUsers"><option selected="selected" value="*">Todos</option>';

									for($i = 0; $i < $num_users; $i++){
										$data = explode("^^", $users_list[$i]);
										$ref = $data[0];
										$names = html_entity_decode($data[1]);
										$namesComplete = html_entity_decode($data[1]);

										$names = explode(" ", $names);
										if(count($names) > 1){ $names = $names[0] . " " . $names[1]; }
										else { $names = $namesComplete; }

										echo '<option title="Usuario: ' . $namesComplete . '" value="' . $ref . '">' . $names . '</option>';
									}

									echo '</select><br><h4>Campos</h4><select id="seaField"><option selected="selected" value="*">Cualesquiera</option><option value="client">Nombre de cliente</option><option value="firstCode">C&oacute;digo inicial</option><option value="creation">Fecha de creaci&oacute;n (aaaa-mm-dd)</option><option value="activationCode">C&oacute;digo activaci&oacute;n</option><option value="ord">N&uacute;mero de orden</option></select><br>
										<h4>B&uacute;squeda</h4><input type="text" class="s-frm-text" id="seaVal">
										<input class="searchLicences s-frm-button" type="button" value="Buscar">';

								}

								?>
								</div>

							</fieldset>

						</form><br>
						</div>


						<div class="right">
						<form class="special add" action="access.php" method="post">
							<fieldset>
								<h3 class="blue">Agregar usuario</h3>
								<div class="box">
									<h4 class="another">Nombres y apellidos</h4>
									<input class="s-frm-text" type="text" name="nw_names">
									<h4 class="another">Etiqueta</h4>
									<input class="s-frm-text" type="text" name="nw_sign">
									<h4>Nombre de usuario</h4>
									<input class="s-frm-text" type="text" name="nw_username">
									<h4>Contrase&ntilde;a</h4>
									<input class="s-frm-text" type="text" name="nw_password"><br>
									<input class="addusr s-frm-button" type="submit" value="Agregar">
								</div>

							</fieldset>
						</form><br>

						<form class="special manage" action="access.php" method="post">
							<fieldset>
								<h3 class="blue">Editar usuarios</h3>
								<div class="box">
								<?php

								if($num_users == 0){ echo '<span class="not-found-short">No se ha agregado ning&uacute;n usuario</span>'; }
								else {

									echo '<h4>Usuario</h4><select id="mgUsers">';

									for($i = 0; $i < $num_users; $i++){
										$data = explode("^^", $users_list[$i]);
										$ref = $data[0];
										$names = html_entity_decode($data[1]);
										$namesComplete = html_entity_decode($data[1]);
										$username = $data[2];
										$sign = $data[3];
										$licActived = $data[4];
										$licUsed = $data[5];
										$last = $data[6];

										$names = explode(" ", $names);
										if(count($names) > 1){ $names = $names[0] . " " . $names[1]; }
										else { $names = $namesComplete; }

										echo '<option title="Usuario: ' . $namesComplete . '" ' . ($i == 0 ? 'selected="selected"': '') . ' value="' . $ref . '^^' . $namesComplete . '^^' . $username . '^^' . $sign . '^^' . $licActived . '^^' . $licUsed . '^^' . $last . '">' . $names . ' (' . $username . ')</option>';
									}

									echo '</select><br>
										<input class="infusr s-frm-button" type="button" value="Detalles">
										<input class="editusr s-frm-button" type="button" value="Modificar">
										<input class="delusr s-frm-button" type="button" value="Eliminar">';

								}

								?>
								</div>

							</fieldset>
						</form><br>
						<form class="special gTools" action="access.php" method="post">
							<fieldset>
								<h3 class="blue">Herramientas</h3>
								<div class="box">
								<?php

									echo putMarks();

								?>

								</div>
							</fieldset>
						</form><br>
						</div>
						</div>



	<?php
		if($CONNECTION){

			$all_messages	= mysql_query("select * from messages");

			$messages_list	= captureData($all_messages);

			$num_messages	= ($messages_list == 0 ? 0 : count($messages_list));
		}
	?>

						<div class="special msgs">
							<?php if($num_messages > 0){ echo '<input class="s-frm-button erase right" type="button" value="Borrar todos">'; } ?>
							<h3 class="blue">Mensajes <strong>(<?php echo $num_messages; ?>)</strong></h3>
							<div class="parts"><span class="names">Remitente</span><span class="subject">Asunto</span><span class="message">Mensaje</span></div>
							<div class="box">
								<?php

								if($num_messages == 0){ echo '<span class="not-found">No hay ning&uacute;n mensaje</span>'; }
								else {
									mysql_free_result($all_messages);

									natcasesort($messages_list);
									for($j = 0; $j < $num_messages; $j++){
										$msg = explode("^^", $messages_list[$j]);
										$names = html_entity_decode($msg[1]);
										$namesType = false;
										if(substr($names, 0, 3) == "***"){
											$names = substr($names, 3);
											$namesType = true;
										}
										$subject = html_entity_decode($msg[2]);
										$message = html_entity_decode($msg[3]);
										echo '<div class="msg' . ($namesType ? ' tigtened' : '') . '"><span class="names">' . (strlen($names) > 18 ? substr($names, 0, 18) . "..." : $names) . '</span><span class="real-names hide">' . $names . '</span><span class="subject">' . (strlen($subject) > 20 ? substr($subject, 0, 20) . "..." : $subject) . '</span><span class="real-subject hide">' . $subject . '</span><span class="message">' . (strlen($message) > 36 ? substr($message, 0, 36) . "..." : $message) . '</span><span class="real-message hide">' . $message . '</span></div>';
									}
								}


								?>
							</div>
							<div id="msgComplete">&nbsp;</div>
						</div>








	<?php
	}
	else if(IS_SELLER){

		$nl_client = Post("client");
		$nl_code = Post("code");

		if(Post("action") == "newlicgen" && $nl_client && $nl_code){

			$SECTOR = "<h3>Error en <strong>Nueva licencia</strong></h3>";

			if($UserLicActived > 0){

				if(strlen($nl_client) > 3 && strlen($nl_client) < 49 && preg_match('/^[a-f\d]{8,12}$/i', $nl_code)){

					if($CONNECTION){

						$past_lic = mysql_query("select ref from generated where (client='". htmlentities($nl_client) ."' And firstCode='" . $nl_code . "')");
						$is_relic = gettype(mysql_fetch_object($past_lic)) != "boolean";

						if(!$is_relic){
							$nl_code = strtoupper($nl_code);
							$last_xCode = strtoupper(generateCode($nl_code) . '');
							$set_generated = mysql_query("insert into generated values(0, " . $UserID . ", '". htmlentities($nl_client) ."', '". $nl_code ."', '" . $last_xCode . "', '" . date("Y-m-d") . "');");

							if($set_generated){
								$use_licence = mysql_query("update sellers set lic_actived=lic_actived-1, lic_used=lic_used+1 where ref=" . $UserID . ";");
								$user_info = mysql_query("select lic_actived from sellers where (ref=" . $UserID . ");");
								$result = mysql_fetch_object($user_info);
								$rest_lics = $result -> lic_actived;

								if($use_licence && gettype($rest_lics * 1) == "integer"){
									$_SESSION["SELLER"] = $UserID . "^^" . $UserNames . "^^" . $UserSign . "^^" . $rest_lics . "^^---------------------------------------";
									echo '<h3 class="response green biggie">Se ha generado la clave <strong>' . $last_xCode . '</strong> para <strong>' . $nl_client . '</strong></h3>';
								}
								else {
									echo '<div class="response red">' . $SECTOR . 'No se ha podido generar la clave -&gt; error al actualizar</div>';
								}
							}
							else {
								echo '<div class="response red">' . $SECTOR . 'No se ha podido generar la clave -&gt; error al guardar</div>';
							}

						}
						else {
							echo '<div class="response red">' . $SECTOR . 'Esta licencia ya se ha generado anteriormente</div>';
						}
					}
					else {
						echo '<div class="response red">' . $SECTOR . 'Ha ocurrido un error inesperado, vuelve a intentarlo</div>';
					}
				}
				else {
					echo '<div class="response red">' . $SECTOR . 'Alguno de los valores ingresados es muy corto, demasiado largo o es incorrecto</div>';
				}

			}
			else {
				echo '<div class="response red">' . $SECTOR . 'Actualmente no dispones de licencias h&aacute;biles</div>';
			}
		}

		if($CONNECTION){
			$user_real_info = mysql_query("select lic_actived, lic_used, last from sellers where (ref=" . $UserID . ")");
			$user_data	= mysql_fetch_object($user_real_info);
			$UserLicActived = $user_data -> lic_actived;
			$UserLicUsed	= $user_data -> lic_used;
			$UserLastVisit	= $user_data -> last;


			$licStart = Get("perSta");
			$licFinish = Get("perFin");
			$licStart_stat = false;
			$licFinish_stat = false;
			$per_creation = ($licStart || $licFinish);

			if($per_creation){
				$licStart_stat = $licStart ? explode("-", $licStart) : false;
				if($licStart_stat && count($licStart_stat) == 3 && checkdate($licStart_stat[1], $licStart_stat[2], $licStart_stat[0])){ $licStart_stat = true; }
				else { $licStart_stat = false; }

				$licFinish_stat = $licFinish ? explode("-", $licFinish) : false;
				if($licFinish_stat && count($licFinish_stat) == 3 && checkdate($licFinish_stat[1], $licFinish_stat[2], $licFinish_stat[0])){ $licFinish_stat = true; }
				else { $licFinish_stat = false; }
			}

			$per_creation = ($licStart_stat || $licFinish_stat);

			if(!$per_creation){
				$licStart = "";
				$licFinish = "";
			}

			if($per_creation){
				if($licStart_stat && !$licFinish_stat){
					$request_licences = mysql_query("select ord, client, firstCode, activationCode, creation from generated where (ref=" . $UserID . " And (creation >= '" . $licStart . "'))");
					$licFinish = "";
				}
				if($licFinish_stat && !$licStart_stat){
					$request_licences = mysql_query("select ord, client, firstCode, activationCode, creation from generated where (ref=" . $UserID . " And (creation <= '" . $licFinish . "'))");
					$licStart = "";
				}
				if($licStart_stat && $licFinish_stat){	$request_licences = mysql_query("select ord, client, firstCode, activationCode, creation from generated where (ref=" . $UserID . " And (creation >= '" . $licStart . "' And creation <= '" . $licFinish . "'))"); }
			}
			else {
				$request_licences = mysql_query("select ord, client, firstCode, activationCode, creation from generated where (ref=" . $UserID . ")");
			}


			$my_licences = captureData($request_licences);
			$num_licences = ($my_licences == 0 ? 0 : count($my_licences));
			if($per_creation && $num_licences == 0){ $num_licences = -1; }

		}


	?>

						<div class="Panel">
							<h3 class="blue">Control de c&oacute;digos</h3>
							<div class="grl">
								<div class="left">
									<h4>Nombre:</h4><span><?php echo $UserNames; ?></span><br>
									<h4>Etiqueta:</h4><span><?php echo $UserSign; ?></span><br>
								</div>
								<div class="right">
									<h4>Licencias h&aacute;biles:</h4><strong class="yellow"><?php echo $UserLicActived; ?></strong><br>
									<h4>Licencias usadas:</h4><strong><?php echo $UserLicUsed; ?></strong><br>
								</div>
							</div>
							<div class="double">
								<div class="left">
									<h4><span>(Clientes)</span> Licencias generadas:</h4>
									<div class="licences">
									<?php

									if($num_licences == 0){ echo '<span class="not-found">No hay ninguna licencia generada</span>'; }
									else if($num_licences == -1){ echo '<strong class="not-found">No se ha encontrado ninguna coincidencia</strong>'; }
									else {
										mysql_free_result($request_licences);

										$my_licences = order($my_licences);

										for($k = 0; $k < $num_licences; $k++){
											$lic = explode("^^", $my_licences[$k]);
											$client = html_entity_decode($lic[1]);
											$firstCode = $lic[2];
											$xCode = $lic[3];
											$creationDate = $lic[4];
											echo '<div class="unique"><span class="client" title="Cliente: ' . htmlspecialchars($client) . '"><strong class="lblue">&gt;&nbsp;</strong>' . (strlen($client) > 38 ? substr($client, 0, 38) . "..." : $client) . '</span><span class="firstCode">' . $firstCode . '</span><span class="xCode">' . $xCode . '</span><span class="creationDate">' . $creationDate . '</span></div>';
										}
									}

									?>
									</div>
									<div id="licComplete">&nbsp;</div>
									<form class="limits" action="access.php" method="get">
										<strong>Desde&nbsp;</strong><input class="s-frm-text" type="text" name="perSta" value="<?php echo ($licStart ? $licStart : ""); ?>">&nbsp;&nbsp;&nbsp;<strong>Hasta&nbsp;</strong><input class="s-frm-text" type="text" name="perFin" value="<?php echo ($licFinish ? $licFinish : ""); ?>">&nbsp;<input class="s-frm-button" type="submit" value="Ver"><br><span class="silver">(Ejemplo: aaaa-mm-dd, 2010-06-30)</span>
									</form>
									<div style="background-color:#333;text-align:center;padding:6px 12px"><input type="text" class="seaVal s-frm-text" value=""> <input type="button" class="searchLicences s-frm-button" value="Buscar licencias"></div>
								</div>
								<div class="right">
									<h4>Nueva licencia:</h4>
									<form class="newlic" action="access.php" method="post">
										<fieldset>
											<h5>Nombre cliente</h5>
											<input type="hidden" name="action" value="newlicgen">
											<input class="s-frm-text" type="text" name="client">
											<h5>C&oacute;digo</h5>
											<input class="s-frm-text" type="text" name="code">
											<input class="s-frm-button generate" type="submit" value="Generar">
										</fieldset>
									</form>
								</div>
							</div>
						</div>

	<?php
	}
	else if($SPECIAL_ACCESS){
		if(Get("response") == "fail") echo '<h3 class="response red">No es posible acceder al sistema.</h3>';
	?>


						<br><br><form class="login" action="analize.php" method="post">
							<fieldset>
								<h3 class="blue">Acceso especial</h3>
								<div class="box">
									<h4>Contrase&ntilde;a</h4>
									<input type="hidden" name="special" value="<?php echo $COMODIN_DE_ACCESO; ?>">
									<input class="s-frm-text" type="password" name="password">
									<input class="s-frm-button" type="submit" value="Entrar">
								</div>
							</fieldset>
						</form><br><br><br>





	<?php
	}
	else {
		if(Get("response") == "bad") echo '<h3 class="response red">La contrase&ntilde;a o nombre de usuario son incorrectos</h3>';
		if(Get("response") == "dbno") echo '<h3 class="response red">Lo sentimos, la base de datos esta fuera de servicio</h3>';
	?>

						<form class="login" action="analize.php" method="post">
							<fieldset>
								<h3 class="blue">Usuarios registrados</h3>
								<div class="box">
									<h4>Nombre de usuario</h4>
									<input type="hidden" name="action" value="login">
									<input class="s-frm-text" type="text" name="username">
									<h4>Contrase&ntilde;a</h4>
									<input class="s-frm-text" type="password" name="password">
									<input class="s-frm-button" type="submit" value="Entrar">
								</div>
							</fieldset>
						</form>


	<?php
	}
	?>
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
