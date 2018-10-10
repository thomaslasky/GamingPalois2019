<?php
	
	header('Content-Type: application/json');
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/Functions.php';
	
	$csrf = new App\Csrf();
	$usersManager = new App\MembresManager();
	
	if ($csrf->verifyToken("csrf", "index.php")) {
		if (isset($_POST['Status']) && isset($_POST['Prenom']) && isset($_POST['Nom']) && isset($_POST['Age']) && isset($_POST['Email']) && isset($_POST['Adresse']) && isset($_POST['Password'])) {
			
			$status = $_POST['Status'];
			$prenom = $_POST['Prenom'];
			$nom = $_POST['Nom'];
			$age = $_POST['Age'];
			$email = $_POST['Email'];
			$telephone = $_POST['Telephone'];
			$adresse = $_POST['Adresse'];
			$password = $_POST['Password'];
			
			if ($usersManager->verifyMail($email) === TRUE) {
				
				$inscription = new App\Membres([
					'Email'     => $email,
					'Nom'       => $nom,
					'Prenom'    => $prenom,
					'Age'       => $age,
					'Telephone' => $telephone,
					'Adresse'   => $adresse,
					'Status'    => $status,
					'Password'  => $password,
				]);
				
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