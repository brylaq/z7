<?php
	session_start();
	
	if ((!isset($_POST['user'])) || (!isset($_POST['password'])) || (!isset($_POST['password2'])))
	{
		$_SESSION['err'] = '<div id="err">Błąd formularza!</div>';
		header('Location: register.php');
		exit();
	}
	
	if($_POST['password']!=$_POST['password2'])
	{
		$_SESSION['err'] = '<div id="err">Hasła muszą być takie same!</div>';
		header('Location: register.php');
		exit();
	}
	
	$user = $_POST['user'];
	$password = $_POST['password'];

	require_once "connect.php";
	
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno;
	}
	else
	{
		if($result = $connection->query("SELECT * FROM users WHERE user='$user'"))
		{
			$row_counter = $result->num_rows;
			if($row_counter>0)
			{
				$_SESSION['err'] = '<div id="err">Użytkownik istnieje już w bazie!</div>';
				header("Location: register.php");
			}
			else
			{
				if($result = $connection->query("INSERT INTO users (user, password) VALUES('$user', '$password')"))
				{
					$_SESSION['logedIn'] = true;
					$_SESSION['user'] = $user;
					// $cookie_name = "user";
					// $cookie_value = $_POST['user'];
					// setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
					header("Location: explorer.php");
				}
				else
				{
					$_SESSION['err'] = '<div id="err">Błędne zapytanie!</div>';
					header("Location: register.php");
				}
			}
		}
		
		$connection->close();
	}
?>



