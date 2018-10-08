<?php
	
	header('Content-Type: application/json');
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/Functions.php';
	
	$csrf = new App\Csrf();
	$usersManager = new App\MembresManager();
	
	if (isset($_POST['Inscription'])) {
		if ($csrf->verifyToken("csrf", "index.php")) {
			if (isset($_POST['Statut']) && isset($_POST['Prenom']) && isset($_POST['Nom']) && isset($_POST['Age']) && isset($_POST['Mail']) && isset($_POST['Adresse']) && isset($_POST['Password'])) {
				
				$statut = $_POST['Statut'];
				$prenom = $_POST['Prenom'];
				$nom = $_POST['Nom'];
				$age = $_POST['Age'];
				$mail = $_POST['Mail'];
				$telephone = $_POST['Telephone'];
				$adresse = $_POST['Adresse'];
				$password = $_POST['Password'];
				
				if ($usersManager->verifyMail($mail) === TRUE) {
					
					$inscription = new App\Membres([
						'Email'     => $mail,
						'Nom'       => $nom,
						'Prenom'    => $prenom,
						'Age'       => $age,
						'Telephone' => $telephone,
						'Adresse'   => $adresse,
						'Statut'    => $statut,
						'Password'  => md5($password),
					]);
					
					$membreManager->inscription($inscription);
					
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
	}