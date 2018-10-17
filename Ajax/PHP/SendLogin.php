<?php
	
	header('Content-Type: application/json');
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$csrf = new App\Csrf();
	$usersManager = new App\MembresManager();
	
	if ($csrf->verifyToken("csrf", "index.php")) {
		if (isset($_POST['Email']) && isset($_POST['Password'])) {
			
			$email =htmlspecialchars($_POST['Email']);
			$password = htmlspecialchars($_POST['Password']);
			
			$user = new App\Membres([
				'Email'    => $email,
				'Password' => $password,
			]);
			
			$usersManager->connexion($user);
			
		} else {
			echo json_encode([
				"text"  => "Merci de renseigner des valeurs correct",
				"token" => $csrf->generateToken(),
			]);
		}
	}