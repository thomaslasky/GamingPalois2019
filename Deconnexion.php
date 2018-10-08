<?php
	session_start();
	setcookie("Token",'',time() - 1);
	session_destroy();
	header('location: index.php');
	