<?php
	session_start();
	session_unset();
	
	setcookie('user', null, -1, '/');
    setcookie('logedIn', null, -1, '/');
	
	header("Location: index.php");
?>



