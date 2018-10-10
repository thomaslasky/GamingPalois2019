<?php
	
	header('Content-Type: application/json');
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$csrf = new App\Csrf();
	$usersManager = new App\MembresManager();
	
	if ($csrf->verifyToken("csrf", "index.php")) {
		if (isset($_POST['Status']) && isset($_POST['Prenom']) && isset($_POST['Nom']) && isset($_POST['Age']) && isset($_POST['Email']) && isset($_POST['Password'])) {
			
			$nouveauCompte = $_POST;
			unset($nouveauCompte['csrf']);
			
			if ($usersManager->verifyMail($nouveauCompte["Email"]) === TRUE) {
				
				$inscription = new App\Membres($nouveauCompte);
				
				$usersManager->inscription($inscription);
				
				echo json_encode([
					"text" => "Compte Créé",
				]);
				
			} else {
				echo json_encode([
					"text"  => "Ce mail existe déjà",
					"token" => $csrf->generateToken(),
				]);
			}
		} else {
			echo json_encode([
				"text"  => "Merci de renseigner des valeurs correct",
				"token" => $csrf->generateToken(),
			]);
		}
	}