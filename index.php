<?php
	session_start();
	if(isset($_COOKIE['logedIn'])) 
	{
		header("Location:explorer.php");
		exit();
	}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>PAS Z7</title>
	<link rel="stylesheet" href="main.css">
	<link href="https://fonts.googleapis.com/css?family=Ubuntu+Mono:400,700&amp;subset=latin-ext" rel="stylesheet">
</head>

<body>
	<div id="container">
		<div class="title">Log in</div>
		<div class="underline"></div>
		
		<form method="POST" action="login.php">
		<br>
		Login:<br><input type="text" name="user"
		<?php if(isset($_COOKIE['user'])) echo "value=".$_COOKIE['user']; ?>><br>
		Password:<br><input type="password" name="password"><br>
		<input type="submit" value="Log in"/>
		</form>
		
		<?php
			if(isset($_SESSION['err']))
			{
				echo $_SESSION['err'];
				unset($_SESSION['err']);
			}
		?>
		
		<a href="register.php">
		<div class="button">Register</div>
		</a>
	
	</div>
</body>
</html>