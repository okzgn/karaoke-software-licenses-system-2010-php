<?php
	include("inside.php");
	include("ARCHIVO_VARIABLE.php");

	$SPECIAL_ACCESS = (Post("special") == $COMODIN_DE_ACCESO ? true : false);

	if(reqIsFromHere() && $SPECIAL_ACCESS){
		$pwd = Post("password");

		if($pwd){
			if(sha1($pwd) == $CONTRASENIA_LUCHO){
				$_SESSION["ADMIN"] = "Administrador^^42ddedec4bcd6663d8ed6efae3e0ec4c9d1d9f20";
				header("location: access.php");

			}

			else header("location: access.php?special=" . $COMODIN_DE_ACCESO . "&response=fail");
		}

		else header("location: access.php?special=" . $COMODIN_DE_ACCESO);
	}

	else if(reqIsFromHere() && !$SPECIAL_ACCESS && Post("action") == "login" && Post("username") && Post("password")){
		$usr = Post("username");
		$pwd = Post("password");

		$usr = strtolower($usr);

		if(connectTo_GRL() == "Ready"){

			$access_user = mysql_query("select ref, names, sign, lic_actived from sellers where (username='" . $usr . "' And password='" . sha1($pwd) . "')");
			$result = mysql_fetch_object($access_user);

			if(gettype($result) != "boolean"){
				$last_visit = mysql_query("update sellers set last='" . date("Y-m-d") . "' where ref=" . ($result -> ref) . ";");
				$_SESSION["SELLER"] = ($result -> ref) . "^^" . html_entity_decode($result -> names) . "^^" . html_entity_decode($result -> sign) . "^^" . ($result -> lic_actived) . "^^---------------------------------------";
				header("location: access.php");
			}

			else  header("location: access.php?response=bad");

		}

		else  header("location: access.php?response=dbno");
	}

	else header("location: access.php");
?>
