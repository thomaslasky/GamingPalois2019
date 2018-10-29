<?php
	
	header("Content-Type: text/plain");
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$csrf = new App\Csrf();
	$usersManager = new App\MembresManager();
	$evenementManager = new \App\EvenementManager();
	
	if (isset($_SESSION['id'])) {
		$user = $usersManager->readMembre($_SESSION["id"]);
		if ($user->getStatus() === "Administrateur") {
			if (!empty($_POST["Place"]) && !empty($_POST["Prix"]) && $_POST["Place"] > 0 && $_POST["Prix"] > 0) {
				if ($_POST["Date"] > date("Y-m-d")) {
					
					$updateEvent = new App\Evenement([
						'IDevenement' => $_POST["IDevenement"],
						'Nom'         => $_POST['Nom'],
						'Dates'       => $_POST['Date'],
						'Adresse'     => $_POST['Adresse'],
						'Place'       => $_POST['Place'],
						'Description' => $_POST['Description'],
						'Prix'        => $_POST['Prix'],
					]);
					
					$evenementManager->updateEvent($updateEvent);
					
					echo json_encode([
						"text" => "Evenement modifié avec succès !",
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
				"text" => "Vous n'avez pas les autorisations pour effectuer cette action",
				"token" => $csrf->generateToken(),
			]);
		}
	} else {
		echo json_encode([
			"text" => "Vous devez être connecté et être administrateur pour avoir accès à cette page",
			"token" => $csrf->generateToken(),
		]);
	}