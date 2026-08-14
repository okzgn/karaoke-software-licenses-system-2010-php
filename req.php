<?php
	include("inside.php");

	if(IS_ADMIN){
		if(Get("action") == "eraseMessages"){

			if(connectTo_GRL() == "Ready"){

				$messages_delete = mysql_query("truncate table messages");

				if($messages_delete){ echo "good"; }
				else { echo "bad"; }

			}
			else { echo "bad"; }

		}
		if(Post("action") == "modLic"){

			if(connectTo_GRL() == "Ready"){

				$ref = Post("ref");
				$ord = Post("ord");
				$client = Post("client");
				$creation = Post("creation");
				$firstCode = strtoupper(Post("firstCode"));
				$activationCode = strtoupper(generateCode($firstCode) . "");

				$creation_stat = $creation ? explode("-", $creation) : false;
				if($creation_stat && count($creation_stat) == 3 && checkdate($creation_stat[1], $creation_stat[2], $creation_stat[0])){ $creation_stat = true; }
				else { $creation_stat = false; }

				if(strlen($client) > 3 && strlen($client) < 49 && $creation_stat && preg_match('/^[a-f\d]{8,12}$/i', $firstCode)){

					$mod_licence = mysql_query("update generated set client='" . htmlentities($client) . "', firstCode='" . $firstCode . "', activationCode='" . $activationCode . "', creation='" . $creation . "' where (ref=" . $ref . " And ord=" . $ord . ");");

					if($mod_licence){ echo "good"; }
					else { echo "bad"; }
				}
				else { echo "bad"; }
			}
			else { echo "bad"; }
		}
		if(Post("action") == "delLic"){

			if(connectTo_GRL() == "Ready"){

				$ref = Post("ref");
				$ord = Post("ord");

				$del_licence = mysql_query("delete from generated where (ref=" . $ref . " And ord=" . $ord . ") limit 1;");

				if($del_licence){ echo "good"; }
				else { echo "bad"; }
			}
			else { echo "bad"; }
		}
		if(Post("action") == "editUsr"){

			if(connectTo_GRL() == "Ready"){
				$ref = Post("ref");
				$nw_names = Post("newUsrNames");
				$nw_sign = Post("newUsrSign");
				$nw_username = Post("newUsrName");
				$nw_password = Post("newUsrPwd");
				$nw_licActived = Post("newUsrLics");

				$userLics = mysql_query("select lic_actived from sellers where (ref='" . $ref . "')");
				$licsHave = captureData($userLics);
				$licsHave = ($licsHave == 0 ? 0 : $licsHave);

				if(strlen($nw_names) > 3 && strlen($nw_names) < 49 && strlen($nw_sign) > 3 && strlen($nw_sign) < 49 && preg_match('/^[a-z\d_]{4,24}$/i', $nw_username) && $nw_licActived <= $licsHave[0]){
					$nw_username = strtolower($nw_username);
					$edit_user = mysql_query("update sellers set names='" . htmlentities($nw_names) . "', sign='" . htmlentities($nw_sign) . "', username='" . $nw_username . "'," . (strlen($nw_password) > 5 ? " password='" . sha1($nw_password) . "'," : "") . " lic_actived='" . $nw_licActived . "' where (ref=" . $ref . ");");
					if($edit_user){ echo "good"; }
					else { echo "bad"; }
				}
			}
			else { echo "bad"; }
		}
		if(Post("action") == "delUsr"){

			if(connectTo_GRL() == "Ready"){
				$ref = Post("ref");
				$del_user = mysql_query("delete from sellers where (ref=" . $ref . ") limit 1;");
				$del_user_data = mysql_query("delete from generated where (ref=" . $ref . ");");

				if($del_user && $del_user_data){ echo "good"; }
				else { echo "bad"; }
			}
			else { echo "bad"; }
		}

		if(Get("action") == "searchLicence"){
			if(connectTo_GRL() == "Ready"){
				$seaUser = Get("seaUser");
				$seaField = Get("seaField");
				$seaVal = Get("seaVal");

			if($seaUser && $seaField){

				if(($seaUser == "*" && $seaField == "*" && strlen($seaVal) == 0) || ($seaUser == "*" && $seaField != "*" && strlen($seaVal) == 0)){
					$searchType = mysql_query("select * from generated where (ord > 0)");
				}

				if(($seaUser != "*" && $seaField == "*" && strlen($seaVal) == 0) || ($seaUser != "*" && $seaField != "*" && strlen($seaVal) == 0)){
					$searchType = mysql_query("select * from generated where (ref='" . $seaUser . "' And ord > 0)");
				}

				if($seaUser == "*" && $seaField == "*" && strlen($seaVal) > 0){
					$searchType = mysql_query("select * from generated where (ord='" . $seaVal . "'Or instr(client, '" . $seaVal . "') Or creation='" . $seaVal . "' Or firstCode='" . $seaVal . "' Or activationCode='" . $seaVal . "' )");
				}

				if($seaUser != "*" && $seaField == "*" && strlen($seaVal) > 0){
					$searchType = mysql_query("select * from generated where (ref='" . $seaUser . "' And (ord='" . $seaVal . "'Or instr(client, '" . $seaVal . "') Or creation='" . $seaVal . "' Or firstCode='" . $seaVal . "' Or activationCode='" . $seaVal . "') )");
				}

				if($seaUser == "*" && $seaField != "*" && strlen($seaVal) > 0){
					$searchType = mysql_query("select * from generated where (" . ($seaField == "client" ? "instr(client, '" . $seaVal . "')" : "" . $seaField . "='" . $seaVal . "'") . ")");
				}

				if($seaUser != "*" && $seaField != "*" && strlen($seaVal) > 0){
					$searchType = mysql_query("select * from generated where (ref='" . $seaUser . "' And " . ($seaField == "client" ? "instr(client, '" . $seaVal . "')" : "" . $seaField . "='" . $seaVal . "'") . ")");
				}

				$searchFound	= captureData($searchType);
				$numResults	= ($searchFound == 0 ? 0 : count($searchFound));

				if($numResults > 0){
					mysql_free_result($searchType);

					$searchFound	= order($searchFound);
					$results = '';
					for($i = 0; $i < $numResults; $i++){
						$data = explode("^^", $searchFound[$i]);
						$ord = $data[0];
						$ref = $data[1];
						$client = $data[2];
						$firstCode = $data[3];
						$activationCode = $data[4];
						$creation = $data[5];

						$names = html_entity_decode($client);

						$names = explode(" ", $names);
						if(count($names) > 1){ $names = $names[0] . " " . $names[1]; }
						else { $names = html_entity_decode($client); }

						$results .= '<div class="cell"><strong>Cliente(<span class="white">' . $ord . '</span>):</strong><span>' . $names . '</span><br><strong>C&oacute;digo inicial:</strong><span>' . $firstCode . '</span><br><strong>C&oacute;digo de activaci&oacute;n:</strong><span>' . $activationCode . '</span><br><strong>Fecha de creaci&oacute;n:</strong><span>' . $creation . '</span></div>';
					}
					echo $results;
				}
				else { echo "bad"; }
			}
			else { echo "bad"; }
			}
			else { echo "bad"; }
		}

		if(Post("action") == "createTradeMark"){

			$gtDir		= Post("gtDir");
			$gtTitle	= Post("gtTitle");
			$gtKeywords	= Post("gtKeywords");
			$gtDescription	= Post("gtDescription");
			$gtName		= Post("gtName");
			$gtDirWeb	= Post("gtDirWeb");
			$gtEmail	= Post("gtEmail");
			$gtSupText	= Post("gtSupText");
			$gtDirVideo	= Post("gtDirVideo");
			$gtDirBis	= Post("gtDirBis");
			$gtWhoWeAre	= Post("gtWhoWeAre");
			$gtMission	= Post("gtMission");
			$gtPhones	= Post("gtPhones");

			$allPath = 'marks/' . $gtDir . '/';

			if(strlen($gtDir) > 2 && strlen($gtDirWeb) > 7 && !is_dir($allPath)){

			$createDir	= mkdir($allPath);
			$gtDirWeb	= "http://" . $gtDirWeb . "/";

			if($createDir){
				$_1  = mkdir($allPath . 'data');
				$_2  = mkdir($allPath . 'IMAGENES');
				$_a  = mkdir($allPath . 'docs');

				if($_1 && $_2 && $_a){
					$_3  = copy('paths/index.php', $allPath . 'index.php');
					$_4  = copy('paths/inside.php', $allPath . 'inside.php');
					$_5  = copy('paths/IMAGENES/banner.jpg', $allPath . 'IMAGENES/banner.jpg');
					$_6  = copy('paths/IMAGENES/logo.gif', $allPath . 'IMAGENES/logo.gif');
					$_7  = copy('paths/data/bg.gif', $allPath . 'data/bg.gif');
					$_8  = copy('paths/data/bk.gif', $allPath . 'data/bk.gif');
					$_9  = copy('paths/data/bott.gif', $allPath . 'data/bott.gif');
					$_10 = copy('paths/data/bxl.gif', $allPath . 'data/bxl.gif');
					$_11 = copy('paths/data/bxr.gif', $allPath . 'data/bxr.gif');
					$_12 = copy('paths/data/cnb.gif', $allPath . 'data/cnb.gif');
					$_13 = copy('paths/data/cnt.gif', $allPath . 'data/cnt.gif');
					$_14 = copy('paths/data/deg.gif', $allPath . 'data/deg.gif');
					$_15 = copy('paths/data/icon.ico', $allPath . 'data/icon.ico');
					$_16 = copy('paths/data/ld_b.gif', $allPath . 'data/ld_b.gif');
					$_17 = copy('paths/data/reset.css', $allPath . 'data/reset.css');
					$_18 = copy('paths/data/std.gif', $allPath . 'data/std.gif');
					$_19 = copy('paths/data/theme.css', $allPath . 'data/theme.css');
					$_20 = copy('paths/data/tkb.gif', $allPath . 'data/tkb.gif');
					$_21 = copy('paths/data/tkt.gif', $allPath . 'data/tkt.gif');
					$_22 = copy('paths/data/topp.gif', $allPath . 'data/topp.gif');
					$_23 = copy('paths/data/a_dwn.gif', $allPath . 'data/a_dwn.gif');
					$_24 = copy('paths/data/b_dwn.gif', $allPath . 'data/b_dwn.gif');
					$_25 = copy('paths/data/cbu_h.gif', $allPath . 'data/cbu_h.gif');
					$_26 = copy('paths/data/cbu_n.gif', $allPath . 'data/cbu_n.gif');
					$_27 = copy('paths/data/cd.gif', $allPath . 'data/cd.gif');
					$_28 = copy('paths/data/cdrech.gif', $allPath . 'data/cdrech.gif');
					$_29 = copy('paths/data/dow_h.gif', $allPath . 'data/dow_h.gif');
					$_30 = copy('paths/data/dow_n.gif', $allPath . 'data/dow_n.gif');
					$_31 = copy('paths/data/gbu_h.gif', $allPath . 'data/gbu_h.gif');
					$_32 = copy('paths/data/gbu_n.gif', $allPath . 'data/gbu_n.gif');
					$_33 = copy('paths/data/ui.js', $allPath . 'data/ui.js');
					$_34 = copy('paths/data/jquery.js', $allPath . 'data/jquery.js');

					if($_3 && $_4 && $_5 &&$_6 &&$_7 &&$_8 &&$_9 &&$_10 &&$_11 &&$_12 &&$_13 &&$_14 &&$_15 &&$_16 &&$_17 &&$_18 &&$_19 &&$_20 &&$_21 &&$_22 &&$_23 &&$_24 &&$_25 &&$_26 &&$_27 &&$_28 &&$_29 &&$_30 &&$_31 &&$_32 && $_33 && $_34){
						file_put_contents("paths/ddirs.txt", strtolower($gtDir) . ":::", FILE_APPEND);

						$archivo = $allPath . 'ARCHIVO_VARIABLE.php';
						$fp = fopen($archivo, "a");
						$string = "<?php\n\n\$RUTA = '" . $allPath . "';\n\n\$TITULO_PAGINA = '" . ($gtTitle ? $gtTitle : "Karaoke LatinMusic, Bienvenid@s") . "';\n\$META_KEYWORDS = '" . ($gtKeywords ? $gtKeywords : "latinmusic, latin, latin music, karaoke latinmusic, karaoke latin music, karaoke, cybermusic, cyber music, karaoke cyber music, karaoke cybermusic, ciber music, cibermusic, cyber, music, ciber, ecuador, ecua, ecuakaraoke, ecua karaoke") . "';\n\$META_DESCRIPCION = '" . ($gtDescription ? $gtDescription : "Karaoke Latinmusic, el primer sistema de karaoke profesional en Ecuador. Venta y alquiler de karaoke profesional para todo tipo de eventos.") . "';\n\n\$NOMBRE_GENERAL = '" . ($gtName ? $gtName : "Karaoke LatinMusic") . "';\n\$DIRECCION_WEB = '" . ($gtDirWeb ? $gtDirWeb : "http://www.karaokelatinmusic.com") . "';\n\$MAIL_DE_RECEPCION = '" . ($gtEmail ? $gtEmail : "hello@okzgn.com") . "';\n\n\$TEXTO_SUPERIOR = '" . ($gtSupText ? $gtSupText : "Bienvenid@s a Karaoke LatinMusic") . "';\n\$DIRECCION_VIDEO = '" . ($gtDirVideo ? $gtDirVideo : "http://www.youtube.com/embed/iQoJkHW26Oo") . "';\n\n\$QUIENES_SOMOS = '" . (isset($gtWhoWeAre) ? $gtWhoWeAre : "Sin info. de empresa.") . "';\n\$MISION = '" . (isset($gtMission) ? $gtMission : "Sin info. de misi&oacute;n.") . "';\n\$DIRECCION = '" . (isset($gtDirBis) ? $gtDirBis : "Sin direcci&oacute;n.") . "';\n\$TELEFONOS = '" . (isset($gtPhones) ? $gtPhones : "Sin tel&eacute;fonos.") . "';\n\n?>";
						$write = fputs($fp, $string);
						fclose($fp);

						echo "good";
					}
					else { echo "bad"; }
				}
				else { echo "bad"; }

			}
			else { echo 'bad'; }
			}
			else { echo 'bad'; }

		}

	}
	else if(IS_SELLER){
		if(Get("action") == "searchLicence"){
		if(connectTo_GRL() == "Ready"){
				$seaUser = Get("seaUser");
				$seaVal = Get("seaVal");

			if($seaUser && strlen($seaVal) > 0){

				$searchType = mysql_query("select * from generated where (ref='" . $seaUser . "' And (instr(client, '" . $seaVal . "') Or instr(creation, '" . $seaVal . "') Or instr(firstCode, '" . $seaVal . "') Or instr(activationCode, '" . $seaVal . "')) )");

				$searchFound	= captureData($searchType);
				$numResults	= ($searchFound == 0 ? 0 : count($searchFound));

				if($numResults > 0){
					mysql_free_result($searchType);

					$searchFound	= order($searchFound);
					$results = '';
					for($i = 0; $i < $numResults; $i++){
						$data = explode("^^", $searchFound[$i]);
						$ord = $data[0];
						$ref = $data[1];
						$client = $data[2];
						$firstCode = $data[3];
						$activationCode = $data[4];
						$creation = $data[5];

						$names = html_entity_decode($client);

						$names = explode(" ", $names);
						if(count($names) > 1){ $names = $names[0] . " " . $names[1]; }
						else { $names = html_entity_decode($client); }

						$results .= '<div class="cell"><strong>Cliente(<span class="white">' . $ord . '</span>):</strong><span>' . $names . '</span><br><strong>C&oacute;digo inicial:</strong><span>' . $firstCode . '</span><br><strong>C&oacute;digo de activaci&oacute;n:</strong><span>' . $activationCode . '</span><br><strong>Fecha de creaci&oacute;n:</strong><span>' . $creation . '</span></div>';
					}
					echo $results;
				}
				else { echo "bad"; }
			}
			else { echo "bad"; }
		}
		else { echo "bad"; }
		}
	}
	else if(Get('action') == 'ping'){
		echo 'connected';
	}
	else if(Post('action') == 'addLicToUserLikeMedium'){
		$mUsr = Post("mediumUsr");
		$mPwd = Post("mediumPwd");
		$licUser = Post("licUser");
		$licClient = Post("licClient");
		$licFirstCode = Post("licFirstCode");
		$licActivationCode = Post("licActivationCode");
		$licCreation = Post("licCreation");

		if(connectTo_GRL() == "Ready"){

			$access_user = mysql_query("select ref from sellers where (username='" . strtolower($mUsr) . "' And password='" . sha1($mPwd) . "')");
			$isAuthorized = captureData($access_user);

			if($isAuthorized != 0){
				$e_user = mysql_query("select ref from sellers where (username='". strtolower($licUser) ."')");
				$captureUser = captureData($e_user);
				$refUser = $captureUser[0];

				if($refUser != 0){
					$set_generated = mysql_query("insert into generated values(0, " . $refUser . ", '". htmlentities($licClient) ."', '". strtoupper($licFirstCode) ."', '" . strtoupper($licActivationCode) . "', '" . $licCreation . "');");
					$actualize = mysql_query("update sellers set lic_actived=lic_actived-1, lic_used=lic_used+1 where (ref=" . $refUser . ");");

					if(set_generated && $actualize){ echo 'good'; }
					else { echo 'bad4'; }
				}
				else echo "bad3";
			}

			else echo "bad2";

		}

		else echo "bad1";

	}
	else header("location: access.php");






















?>
