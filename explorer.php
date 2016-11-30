<?php
	session_start();
	if(!isset($_COOKIE['logedIn'])) 
	{
		header("Location:index.php");
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
		<div class="title" style="display:inline-block;margin-right:300px;margin-left:300px;">EXPLORER</div>
		<a href="logout.php"><div class="button" style="display:inline-block;">Log out</div><a/>
		<div class="underline"></div>
		
		<?php
			if(isset($_SESSION['warn']))
			{
				echo $_SESSION['warn'];
				unset($_SESSION['warn']);
			}
			
			$path = './users/'.$_COOKIE['user']."/";
			
			echo "<div style='width:300px;text-align:center;margin-top: 100px;margin-left:auto;margin-right:auto;'><table>";
			foreach (new DirectoryIterator($path) as $file) 
			{
				if ($file->isDir())
				{
					if($file->getFilename() !="." && $file->getFilename() !="..")
					{
						echo "<tr><td>";
						print $file->getFilename() . "<br>";
						echo "</td><td><div class='buttonsm'>EDIT<div></td></tr>";
					}
				}
				elseif ($file->isFile()) 
				{
					echo "<tr><td>";
					print $file->getFilename() . "<br>";
					echo "</td><td><div class='buttonsm'>EDIT<div></td></tr>";
				}
			}
			echo "</table></div>";
			
		?>

	</div>
</body>
</html>