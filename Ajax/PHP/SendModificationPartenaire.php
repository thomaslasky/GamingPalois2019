<?php
	
	header('Content-Type: application/json');
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	include '../../Functions/sendmail.php';
	
	$csrf = new App\Csrf();
	$membreManager = new App\MembresManager();
	$partenaireManager = new \App\PartenairesgpManager();
	
	if (isset($_SESSION["id"])) {
		$membre = $membreManager->readMembre($_SESSION["id"]);
		if ($membre->getStatus() === "Administrateur") {
			if (isset($_POST)) {
				if ($csrf->verifyToken("csrf", "")) {
					if (isset($_POST["Nom"]) && !empty($_POST["Nom"])) {
						if (isset($_POST["Description"]) && !empty($_POST["Description"])) {
							if (isset($_POST["Lien"]) && verifyUrl($_POST["Lien"]) === TRUE) {
								
								$updatePartenaire = new App\Partenairesgp([
									'IDpartenaire' => $_POST["idpartenaire"],
									"Nom"         => $_POST["Nom"],
									"Description" => $_POST["Description"],
									"Site"        => $_POST["Lien"],
								]);
								
								$partenaireManager->updatePartenaireGP($updatePartenaire);
								
								echo json_encode([
									"text"  => "Partenaire Modifié !"
								]);
								
							} else {
								echo json_encode([
									"text"  => "Merci de renseigner un lien correct",
									"token" => $csrf->generateToken(),
								]);
							}
						} else {
							echo json_encode([
								"text"  => "Merci de renseigner une description correct",
								"token" => $csrf->generateToken(),
							]);
						}
					} else {
						echo json_encode([
							"text"  => "Merci de renseigner un nom correct",
							"token" => $csrf->generateToken(),
						]);
					}
				} else {
					echo json_encode([
						"text"  => "Une erreur c'est produite, merci de reessayer",
						"token" => $csrf->generateToken(),
					]);
				}
			} else {
				echo json_encode([
					"text"  => "Merci de renseigner tout les champs du formulaire",
					"token" => $csrf->generateToken(),
				]);
			}
		} else {
			echo json_encode([
				"text"  => "Vous n'avez pas les droits pour effectuer cette action",
				"token" => $csrf->generateToken(),
			]);
		}
	} else {
		echo json_encode([
			"text"  => "Vous devez être connecté !",
			"token" => $csrf->generateToken(),
		]);
	}