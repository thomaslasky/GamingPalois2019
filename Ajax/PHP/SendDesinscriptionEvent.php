<?php
	
	header('Content-Type: application/json');
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$evenementManager = new \App\EvenementManager();
	$userManager = new \App\MembresManager();
	$participerManager = new App\ParticiperManager();
	
	if (isset($_SESSION['id'])) {
		
		$idUser = $_SESSION["id"];
		$idEvent = $_POST["IDevent"];
		
		$userInfo = $userManager->readMembre($idUser);
		$evenementInfo = $evenementManager->readEventByID($idEvent);
		
		$participerManager->desinscriptionEvent($idUser, $idEvent);
		
		$msg = "Vous vous êtes desinscrit de l'événement {$evenementInfo->getNom()} ! Vous pouvez vous reinscrire à tout moment dans la limite des places disponible";
		
		if (mail($userInfo->getEmail(), "Desinscription d'un événement", $msg)) {
			echo json_encode([
				"text" => "Vous êtes desinscrit !",
			]);
			exit;
		}
		
	} else {
		echo json_encode([
			"text" => "Vous n'avez pas les autorisations pour effectuer cette action",
		]);
	}