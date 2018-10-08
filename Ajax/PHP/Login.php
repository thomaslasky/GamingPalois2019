<?php
	
	header("Content-Type: text/plain");
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/Functions.php';
	
	$csrf = new App\Csrf();
	$usersManager = new App\MembresManager();
	
	if (isset($_SESSION['id'])) {
		
		header("location: Accueil.php");
		exit;
		
	} else {
		if (isset($_COOKIE['Token'])) {
			$cookies = $_COOKIE['Token'];
			if ($usersManager->verifyToken($cookies) === true) {
				header("location: Accueil.php");
				exit;
			} else {
				setcookie("Token", "", time() - 1);
			}
		} else {
			$formulaireLogin = new App\Formulaire("post", "formulaire_login column");
			$csrf->generateInput("csrf", $formulaireLogin);
			$formulaireLogin->inputText("Email", "Email", "text", "", "", "Email", "Email");
			$formulaireLogin->inputText("Password", "Password", "Password", "", "", "Password", "Password");
			$formulaireLogin->submit("Valider", "Valider", "");
			$formulaireLogin->inputText("Remember", "Remember", "checkbox", "remember_checkbox", "true", "", "Remember me");
			
			$login = $formulaireLogin->render();
			
			echo $login;
			
			/*if (isset($_POST['Valider'])) {
				if ($csrf->verifyToken("csrf", "index.php")) {
					if (isset($_POST['Email']) && isset($_POST['Password'])) {
						
						$email = $_POST['Email'];
						$password = $_POST['Password'];
						
						$user = new App\Membres(['Email' => $email,
						                         'Password' => $password]);
						
						$usersManager->connexion($user);
					}
				}
			}*/
		}
	}