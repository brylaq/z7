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
		$target_dir = $_GET['dir']."/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	if (file_exists($target_file)) 
	{
		$_SESSION["warn"] = "<div class='err'>Sorry, file already exists.</div>";
		$uploadOk = 0;
	}
	
	if ($_FILES["fileToUpload"]["size"] > 100000) 
	{
		$_SESSION["warn"] = "<div class='err'>Sorry, your file is too large.</div>";
		$uploadOk = 0;
	}
	

	if ($uploadOk == 0) 
		header("Location:explorer.php");

	else 
	{
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
		{
			$_SESSION["warn"] = "<div class='err' style='color:#093;'>The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.</div>";
		} 
		else 
		{
			$_SESSION["warn"] = "<div class='err'>Sorry, there was an error uploading your file.</div>";
			header("Location:explorer.php");
		}
		header("Location:explorer.php");
	}
?>