<?php
	
	header('Content-Type: application/json');
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	include '../../Functions/sendmail.php';
	
	$csrf = new App\Csrf();
	$usersManager = new App\MembresManager();
	$partenaireManager = new App\PartenairesManager();
	
	$typeFile = [
		"image/jpeg",
		"image/jpg",
		"image/png",
	];
	
	if (isset($_SESSION['id'])) {
		$user = $usersManager->readMembre($_SESSION["id"]);
		if ($user->getStatus() === "Administrateur") {
			if ($csrf->verifyToken("csrf", "")) {
				if (isset($_POST) && !empty($_POST)) {
					if (isset($_POST["Nom"]) && !empty($_POST["Nom"])) {
						if (isset($_POST["Description"]) && !empty($_POST["Description"])) {
							if (isset($_POST["Lien"]) && verifyUrl($_POST["Lien"]) === TRUE) {
								if (isset($_FILES["Logo"])) {
									if (in_array($_FILES["Logo"]["type"], $typeFile)) {
										
										$nameImg = str_replace(" ", "", $_POST["Nom"]);
										
										$uploadPicture = App\Uploads::upload('Logo', '../../Img/Partenaires', rand(1, 1000) . $nameImg, $typeFile);
										
										$name = $uploadPicture->getName();
										
										$newPartenaire = new \App\Partenaires([
											"Nom"         => $_POST["Nom"],
											"Description" => $_POST["Description"],
											"Site"        => $_POST["Lien"],
											"Urlimg"      => $name,
											"IDevenement" => $_POST["IDevent"],
										]);
										
										$partenaireManager->addPartenaire($newPartenaire);
										
										echo json_encode([
											"text" => "Partenaire Ajouté !",
										]);
									} else {
										echo json_encode([
											"text"  => "Ce type de format d'image n'est pas pris en charge",
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
						"text"  => "Merci de remplir tout les champs !",
						"token" => $csrf->generateToken(),
					]);
				}
			} else {
				echo json_encode([
					"text"  => "Une erreur est survenu, réessayez",
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
			"text"  => "Vous devez être connecté pour effectuer cette action",
			"token" => $csrf->generateToken(),
		]);
	}