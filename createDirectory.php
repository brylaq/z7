<?php
	session_start();
	if(!isset($_COOKIE['logedIn'])) 
	{
		header("Location:index.php");
		exit();
	}
	
	$user = $_COOKIE['user'];
	$target_dir = "./users/".$user."/";
	if(isset($_GET['dir']))
		$target_dir = $target_dir.$_GET['dir']."/";
	$target_dir = $target_dir.$_POST['dirName'];
	header("Location:explorer.php");
	if(!is_dir($target_dir))
	{
		mkdir($target_dir);
		$_SESSION["warn"] = "<div class='err' style='color:#093;'>Directory created successfully!</div>";
	}
	else
		$_SESSION["warn"] = "<div class='err'>Directory cannot be created!</div>";
?>