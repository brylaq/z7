<?php
	session_start();
	
	if ((!isset($_POST['user'])) || (!isset($_POST['password'])))
	{
		$_SESSION['err'] = '<div class="err">Nieudane logowanie, spróbuj ponownie.</div>';
		header('Location: index.php');
		exit();
	}
	
	$user = $_POST['user'];
	$password = $_POST['password'];
	$ip = $_SERVER["REMOTE_ADDR"];
	
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
				$row = $result -> fetch_assoc();
				if($row['errlog'] == 3)
				{
					$connection->query("INSERT INTO logs (user, ip, isok) VALUES('$user', '$ip', 0)");
					
					$_SESSION['err'] = '<div class="err">Konto zablokowane z powodu dużej liczby niepoprawnych logowań</div>';
					header("Location: index.php");
					$connection->close();
					exit();
				}
				if($row['password'] == $password)
				{
					$errlog = 0;
					$connection->query("UPDATE users SET errlog='$errlog' WHERE user='$user'");
					
					$connection->query("INSERT INTO logs (user, ip, isok) VALUES('$user', '$ip', 1)");
					
					$_SESSION['logedIn'] = true;
					$_SESSION['user'] = $user;
					header("Location: explorer.php");
				}
				else
				{
					$connection->query("INSERT INTO logs (user, ip, isok) VALUES('$user', '$ip', 0)");
					$errlog = $row['errlog'] +1;
					$connection->query("UPDATE users SET errlog='$errlog' WHERE user='$user'");
					$_SESSION['err'] = '<div class="err">Nieprawidłowy login lub hasło!</div>';
					header("Location: index.php");
				}
			}
			else
			{
				$connection->query("INSERT INTO logs (user, ip, isok) VALUES('$user', '$ip', 0)");
				$_SESSION['err'] = '<div class="err">Nieprawidłowy login lub hasło!</div>';
				header("Location: index.php");
			}
		}
		
		$connection->close();
		exit();
	}
?>



