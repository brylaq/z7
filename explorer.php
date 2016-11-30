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
	<link rel="stylesheet" href="css/fontello.css">
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
		?>
		
		<form action="upload.php<?if(isset($_GET['dir']))echo "?dir=".$_GET['dir']; ?>" method="post" enctype="multipart/form-data">
			Select file to upload:
			<input type="file" name="fileToUpload" id="fileToUpload">
			<input type="submit" value="Upload" name="submit">
		</form>
		
		<form action="createDirectory.php<?if(isset($_GET['dir']))echo "?dir=".$_GET['dir']; ?>" method="post" enctype="multipart/form-data">
			Directory name:
			<input type="text" name="dirName" id="dirName">
			<input type="submit" value="Create" name="submit">
		</form>
		
		<?php
		$path = './users/'.$_COOKIE['user']."/";
		if(isset($_GET['dir']))
		{
			$path = $path.$_GET['dir'];
			echo "<a href='explorer.php'><div class='button'>HOME</div></a>";
		}
		echo "<div style='width:300px;text-align:center;margin-top: 50px;margin-left:auto;margin-right:auto;'><table cellspacing='0'>";
		foreach (new DirectoryIterator($path) as $file) 
		{
			if ($file->isDir())
			{
				if($file->getFilename() !="." && $file->getFilename() !="..")
				{
					echo "<tr><td>";
					$filename = $file->getFilename();
					echo $filename."</td>";
					echo "<td colspan=2><a href='explorer.php?dir=$filename'><div class='buttonsm' style='width: 120px'>EDIT<div></td></tr>";
				}
			}
			elseif ($file->isFile()) 
			{
				echo "<tr><td>";
				$filename = $file->getFilename();
				echo $filename."</td>";
				$directory = $path."/".$filename;
				echo "
				<td><a href='delete.php?filename=$directory'><div class='buttonsm' id='$directory'><i class='icon-trash-empty'></i><div></a></td>
				<td><a href='download.php?filename=$directory'><div class='buttonsm' id='$directory'><i class='icon-download-cloud'></i><div></a></td></tr>";
			}
		}
		echo "</table></div>";
			
	?>

	</div>
</body>
</html>