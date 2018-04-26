<?php
	include('main.php');
	
	session_start();
	session_destroy();
	
	header("Location: admin.php");
	die();
?>