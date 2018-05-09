<?php
	session_start();
	session_destroy();
	unset($_SESSION['userName']);
	unset($_SESSION['password']);
	setcookie("PHPSESSID", "", time() - 3600);
	header('location: index.html');
?>