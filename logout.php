<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SEESION ["loggedin"] !==true){
	header("location:login.php");
	exit;
}

if (isset($_GET["logout"]) && $_GET["logout"] == true) {
	$_SESSION = array();
	session_destroy();
	header("location:login.php");
	exit;
}
?>