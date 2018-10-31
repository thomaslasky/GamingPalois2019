<?php
	
	header("Content-Type: application/json");
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$usersManager = new App\MembresManager();
	$evenementManager = new App\EvenementManager();
	$participerManager = new \App\ParticiperManager();
	
	if (isset($_SESSION["id"])) {
		$user = $usersManager->readMembre($_SESSION["id"]);
		if ($user->getStatus() === "Administrateur") {
			$event = $evenementManager->readEventByID($_POST["idevent"]);
			
			if (file_exists("../../Img/Events/" . $event->getUrlimg())) {
				unlink("../../Img/Events/" . $event->getUrlimg());
			}
			
			if ($participerManager->deleteAllParticipants($_POST["idevent"]) === TRUE) {
				$evenementManager->deleteEvent($_POST["idevent"]);
				
				echo json_encode([
					"text" => "Evenement supprimé !",
				]);
			} else {
				echo json_encode([
					"text" => "Une erreur est survenu, reessayez !",
				]);
			}
		} else {
			echo json_encode([
				"text" => "Vous n'avez pas les autorisations pour effectuer cette action",
			]);
		}
	} else {
		echo json_encode([
			"text" => "Vous devez être connecté pour effectuer cette action !",
		]);
	}