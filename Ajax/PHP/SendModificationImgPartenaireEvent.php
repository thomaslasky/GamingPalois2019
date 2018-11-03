<?php
	
	header('Content-Type: application/json');
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	include '../../Functions/sendmail.php';
	
	$csrf = new App\Csrf();
	$membreManager = new App\MembresManager();
	$partenaireManager = new \App\PartenairesManager();
	
	$typeFile = [
		"image/jpeg",
		"image/jpg",
		"image/png",
	];
	
	if (isset($_SESSION["id"])) {
		$membre = $membreManager->readMembre($_SESSION["id"]);
		if ($membre->getStatus() === "Administrateur") {
			if (isset($_POST)) {
				if ($csrf->verifyToken("csrf", "")) {
					if (isset($_FILES["Logo"])) {
						if (in_array($_FILES["Logo"]["type"], $typeFile)) {
							
							$partenaire = $partenaireManager->readPartenaire($_POST["idpartenaire"]);
							
							if (file_exists("../../Img/Partenaires/" . $partenaire->getUrlimg())) {
								unlink("../../Img/Partenaires/" . $partenaire->getUrlimg());
							}
							
							$nom = str_replace(" ", "", $partenaire->getNom());
							
							$uploadPicture = App\Uploads::upload('Logo', '../../Img/Partenaires', rand(1, 1000) . $nom, $typeFile);
							
							$name = $uploadPicture->getName();
							
							$newPartenaire = new \App\Partenaires([
								"IDpartenaire" => $_POST["idpartenaire"],
								"Urlimg"       => $name,
							]);
							
							$partenaireManager->updateImgPartenaire($newPartenaire);
							
							echo json_encode([
								"text" => "Image Modifié !",
							]);
						} else {
							echo json_encode([
								"text"  => "Ce format n'est pas pris en charge !",
								"token" => $csrf->generateToken(),
							]);
						}
					} else {
						echo json_encode([
							"text"  => "Merci de renseigner un Logo !",
							"token" => $csrf->generateToken(),
						]);
					}
				} else {
					echo json_encode([
						"text"  => "Une erreur est survenu, veuillez réessayer !",
						"token" => $csrf->generateToken(),
					]);
				}
			} else {
				echo json_encode([
					"text"  => "Merci de renseigner un nouveau Logo !",
					"token" => $csrf->generateToken(),
				]);
			}
		} else {
			echo json_encode([
				"text"  => "Vous n'avez pas les droits pour effectuer cette action !",
				"token" => $csrf->generateToken(),
			]);
		}
	} else {
		echo json_encode([
			"text"  => "Vous devez être connecté !",
			"token" => $csrf->generateToken(),
		]);
	}
	