<?php
	session_start();
	if(!isset($_COOKIE['logedIn'])) 
	{
		header("Location:index.php");
		exit();
	}
	
	$user = $_COOKIE['user'];
	$target_dir = "./users/".$user."/";
	
	if(isset($_GET['filename']))
		$file = $_GET['filename'];
	
	if(isset($_SESSION['path']))
	{
		$target_dir = $_SESSION['path'].$file;
		$path = $_SESSION['path'];
	}
	
	header('Content-Description: File Transfer');
    header('Content-Type: application/force-download');
    header("Content-Disposition: attachment; filename=\"" . basename($file) . "\";");
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($path.$file);
	
	//header("Location:explorer.php");
	
?>