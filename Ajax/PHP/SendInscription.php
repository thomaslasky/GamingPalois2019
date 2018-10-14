<?php
	
	header('Content-Type: application/json');
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	include '../../Functions/sendmail.php';
	
	$csrf = new App\Csrf();
	$usersManager = new App\MembresManager();
	
	if ($csrf->verifyToken("csrf", "index.php")) {
		if (isset($_POST['Status']) && isset($_POST['Prenom']) && isset($_POST['Nom']) && isset($_POST['Age']) && isset($_POST['Email']) && isset($_POST['Password']) && isset($_POST['Telephone'])) {
			
			$nouveauCompte = $_POST;
			unset($nouveauCompte['csrf']);
			
			$arrayType = [
				"Professionnel",
				"Particulier",
			];
			
			if (verifyStatus($nouveauCompte["Status"], $arrayType)) {
				if (verifyAge($nouveauCompte['Age']) === TRUE) {
					if (verifyTelephone($nouveauCompte["Telephone"]) === TRUE) {
						if (verifyEmail($nouveauCompte["Email"])) {
							if ($usersManager->verifyMail($nouveauCompte["Email"]) === TRUE) {
								$inscription = new App\Membres($nouveauCompte);
								
								$usersManager->inscription($inscription);
								
								if (mail($inscription->getEmail(), "Inscription Gaming Palois", "Vous vous êtes inscrit sur le site Gaming Palois !")) {
									echo json_encode([
										"text" => "Compte Créé",
									]);
									exit;
								}
							} else {
								echo json_encode([
									"text"  => "Ce mail existe déjà",
									"token" => $csrf->generateToken(),
								]);
							}
						} else {
							echo json_encode([
								"text"  => "Merci de renseigner un mail valide",
								"token" => $csrf->generateToken(),
							]);
						}
					} else {
						echo json_encode([
							"text"  => "Merci de renseigner un numéro de portable correct",
							"token" => $csrf->generateToken(),
						]);
					}
				} else {
					echo json_encode([
						"text"  => "Merci de renseigner un age correct",
						"token" => $csrf->generateToken(),
					]);
				}
			} else {
				echo json_encode([
					"text"  => "Merci de renseigner un status correct",
					"token" => $csrf->generateToken(),
				]);
			}
		} else {
			echo json_encode([
				"text"  => "Merci de renseigner des valeurs correct",
				"token" => $csrf->generateToken(),
			]);
		}
	} else {
		echo json_encode([
			"text"  => "Une erreur est survenu, merci de réessayer",
			"token" => $csrf->generateToken(),
		]);
	}