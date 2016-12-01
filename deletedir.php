<?php
	//session_start();
	if(!isset($_COOKIE['logedIn'])) 
	{
		header("Location:index.php");
		exit();
	}
	
	$user = $_COOKIE['user'];
	$target_dir = "./users/".$user;
	if(isset($_GET['filename']))
		$target_dir = $_GET['filename'];
	header("Location:explorer.php");
	rmdir($target_dir);
?>