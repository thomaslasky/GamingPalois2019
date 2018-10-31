<?php
	
	header('Content-Type: application/json');
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$csrf = new App\Csrf();
	
	if ($csrf->verifyToken("csrf", "index.php")) {
		
		$message = "";
		
		$monMail = "contact@gamingpalois.fr";
		
		if (!empty($_POST["Nom"]) && !empty($_POST["Prenom"]) && !empty($_POST["Message"]) && !empty($_POST["Sujet"]) && !empty($_POST["Message"])) {
			if (verifyEmail($_POST["Email"])) {
				if (verifyTelephone($_POST["Telephone"])) {
					
					$message .= strtoupper(htmlspecialchars($_POST["Nom"])) . ' ' . ucfirst(htmlspecialchars($_POST['Prenom'])) . "\n";
					$message .= htmlspecialchars($_POST["Email"]) . "\n";
					$message .= htmlspecialchars($_POST["Telephone"]) . "\n\n";
					$message .= htmlspecialchars($_POST["Message"]);
					
					if (mail("contact@gamingpalois.fr", htmlspecialchars($_POST["Sujet"]), $message)) {
						echo json_encode([
							"text" => "Email envoyé !",
						]);
					} else {
						echo json_encode([
							"text"  => "Une erreur est survenu, merci de réessayer",
							"token" => $csrf->generateToken(),
						]);
					}
				} else {
					echo json_encode([
						"text"  => "Merci de rentrer un numéro de téléphone valide",
						"token" => $csrf->generateToken(),
					]);
				}
			} else {
				echo json_encode([
					"text"  => "Merci de rentrer un email valide",
					"token" => $csrf->generateToken(),
				]);
			}
		} else {
			echo json_encode([
				"text"  => "Merci de remplir tout les champs",
				"token" => $csrf->generateToken(),
			]);
		}
	} else {
		echo json_encode([
			"text"  => "Une erreur est survenu, merci de réessayer",
			"token" => $csrf->generateToken(),
		]);
	}