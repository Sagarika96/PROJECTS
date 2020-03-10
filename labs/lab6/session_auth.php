<?php
	$lifetime = 15 * 60;
	$path = "/labs/lab6";
	$domain = "madhavans1.com";
	$secure = TRUE;
	$httponly = TRUE;
	session_set_cookie_params($lifetime,$path,$domain,$secure,$httponly);
	session_start();

	if (!isset($_SESSION["logged"]) or $_SESSION["logged"] != TRUE){
	echo "<script>alert('You have not login. PLease login first');</script>";
	header("Refresh:0; url=form.php");
	die();	
	}

	if ($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]){
	echo "<script>alert('Session hijacking is detected!');</script>";
	header("Refresh:0; url=form.php");
	die();
	}
?>
