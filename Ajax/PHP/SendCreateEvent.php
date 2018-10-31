<?php
	
	header("Content-Type: text/plain");
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$csrf = new App\Csrf();
	$usersManager = new App\MembresManager();
	$evenementManager = new \App\EvenementManager();
	
	$typeEvent = [
		"Vide Grenier",
		"LAN",
	];
	
	$typeFile = [
		"image/jpeg",
		"image/jpg",
		"image/png",
		"image/gif",
	];
	
	if (isset($_SESSION['id'])) {
		$user = $usersManager->readMembre($_SESSION["id"]);
		if ($user->getStatus() === "Administrateur") {
			if (!empty($_POST["Type"]) && in_array($_POST["Type"], $typeEvent)) {
				if (!empty($_POST["Place"]) && !empty($_POST["Prix"]) && $_POST["Place"] > 0 && $_POST["Prix"] > 0) {
					if ($_POST["Date"] > date("Y-m-d")) {
						if (in_array($_FILES["File"]["type"], $typeFile)) {
							
							$uploadPicture = App\Uploads::upload('File', '../../Img/Events', rand(1, 1000) . $_POST['Nom'], $typeFile);
							
							$name = $uploadPicture->getName();
							
							$newEvent = new App\Evenement([
								'Nom'         => $_POST['Nom'],
								'Urlimg'      => $name,
								'Dates'       => $_POST['Date'],
								'Adresse'     => $_POST['Adresse'],
								'Place'       => $_POST['Place'],
								'Type'        => $_POST['Type'],
								'Description' => $_POST['Description'],
								'Prix'        => $_POST['Prix'],
							]);
							
							$evenementManager->addEvent($newEvent);
							
							echo json_encode([
								"text" => "Evenement créé avec succès !",
							]);
						} else {
							echo json_encode([
								"text"  => "Ce type de fichier n'est pas pris en charge !",
								"token" => $csrf->generateToken(),
							]);
						}
					} else {
						echo json_encode([
							"text"  => "Merci de renseigner une date correct",
							"token" => $csrf->generateToken(),
						]);
					}
				} else {
					echo json_encode([
						"text"  => "Merci de renseigner un nombre de place et/ou un tarif correct !",
						"token" => $csrf->generateToken(),
					]);
				}
			} else {
				echo json_encode([
					"text"  => "Merci de renseigner un type d'événement correct !",
					"token" => $csrf->generateToken(),
				]);
			}
		} else {
			echo json_encode([
				"text" => "Vous n'avez pas les autorisations pour effectuer cette action",
			]);
		}
	} else {
		echo json_encode([
			"text" => "Vous devez être connecté et être administrateur pour avoir accès à cette page",
		]);
	}
	