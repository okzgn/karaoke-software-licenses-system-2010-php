<?php

require_once(__DIR__ . "/mysql.shim.php");

session_start();

define("PAGE_LOC", "http://" . $_SERVER['SERVER_NAME'] . "/");
define("IS_ADMIN", isset($_SESSION["ADMIN"]));
define("IS_SELLER", isset($_SESSION["SELLER"]));


function isDedicated($quest = "who"){
    $filePath = __DIR__ . "/paths/ddirs.txt";
    $dedicated = file_exists($filePath) ? file_get_contents($filePath) : "";
    $dparts = explode(":::", $dedicated);
	$is_dedicated = false;
	$who = "";

	for($i = 0; $i < count($dparts); $i++){
		if(strlen($dparts[$i]) > 0 && strpos(PAGE_LOC, $dparts[$i])){
			$is_dedicated = true;
			$who = $dparts[$i];
		}
	}

	return ($quest == "who" ? $who : $is_dedicated);
}

define("IS_DEDICATED", isDedicated());
define("DEDICATED", isDedicated("who"));

if(IS_SELLER){
	$UserData	= explode("^^", $_SESSION["SELLER"]);
	$UserID		= $UserData[0];
	$UserNames	= $UserData[1];
	$UserSign	= $UserData[2];
	$UserLicActived	= $UserData[3];
}



function reqIsFromHere(){
	$prediction = substr($_SERVER['HTTP_REFERER'], 0, strlen(PAGE_LOC));
	if($prediction == PAGE_LOC) return true;
	else return false;
}

function Get($param){
	if(!isset($_GET[$param])) $param = null;
	else $param = $_GET[$param];
	return $param;
}

function Post($param){
	if(!isset($_POST[$param])) $param = null;
	else $param = $_POST[$param];
	return $param;
}

function connectTo_GRL(){
    $Conn = mysql_connect();
    $SelectDB = mysql_query("use klm;");
    $Status = "Not";
    if($Conn && $SelectDB) $Status = "Ready";
    return $Status;
}

function _getFields($request, $row, $cols, $like){
	for($i = 0, $val = ""; $i < $cols; $i++) $val .= mysql_result($request, $row, $i) . $like;
	return substr($val, 0, -2);
}

function captureData($request, $like = "^^"){
	$arr = array();
	if(!$request) return 0;
	$rows = mysql_num_rows($request);
	$cols = mysql_num_fields($request);
	if($rows > 0){
		for($i = 0; $i < $rows; $i++) array_push($arr, _getFields($request, $i, $cols, $like));
		return $arr;
	}
	return 0;
}

function generateCode($firstCode){
	$firstCode = str_split($firstCode);
	$firstCode = array_reverse($firstCode);

	for($i = 0, $newCode = array(); $i < count($firstCode); $i++){
		$char = strtolower($firstCode[$i]);
		switch($char){
			case 'a': $char = '10'; break;
			case 'b': $char = '11'; break;
			case 'c': $char = '12'; break;
			case 'd': $char = '13'; break;
			case 'e': $char = '14'; break;
			case 'f': $char = '15'; break;
		}

		array_push($newCode, $char);
	}

	$newCode = implode("", $newCode);

	$secondCode = substr($newCode, 0, 1);
	$secondCode .= substr($newCode, strlen($newCode) - 2, 1);
	$secondCode .= substr($newCode, 1, 1);
	$secondCode .= substr($newCode, strlen($newCode) - 3, 1);
	$secondCode .= substr($newCode, 2, 1);
	$secondCode .= substr($newCode, strlen($newCode) - 4, 1);
	$secondCode .= substr($newCode, 3, 1);
	$secondCode .= substr($newCode, strlen($newCode) - 5, 1);
	$secondCode .= substr($newCode, 4, 1);

	$finalCode = dechex($secondCode);

	return $finalCode;
}

function order($arr, $with = "^^"){
	$first = array();
	$second = array();
	foreach($arr as $val){
		$part = explode($with, $val);
		$first[$part[0] * 1] = $val;
	}

	krsort($first);

	foreach($first as $val){
		array_push($second, $val);
	}
	return $second;
}

function validateEmail($value){
if(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$value)){ return true; }
return false;
}

function putMarks(){
	# die('<span class="not-found">Herramientas desactivadas</span>');

	$list_marks = scandir('marks/');
	$num_marks = count($list_marks);
	if($num_marks > 2){
		echo '<select id="marks">';
		for($i = 0; $i < $num_marks; $i++){
			if(strlen($list_marks[$i]) > 2 && is_dir('marks/' . $list_marks[$i])) echo '<option ' . ($i == 0 ? 'selected="selected"': '') . ' value="' . $list_marks[$i] . '">' . $list_marks[$i] . '</option>';
		}
		echo '</select><br><input type="button" value="Ir" class="gt-gomark s-frm-button"> ';
	}
	else {
	    echo '<div class="txt-center silver">No has creado ninguna marca.<br><br></div>';
	}

	echo '<input type="button" value="Generador de marcas" class="gt-trademarks s-frm-button">';
}

?>
