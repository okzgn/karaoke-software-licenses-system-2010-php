<?php
	include("inside.php");
	session_destroy();
	header("location: access.php");
?>