<?php
	
	header('Content-Type: application/json');
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$participerManager = new App\ParticiperManager();
	
	if (isset($_SESSION['id'])) {
		
		if (isset($_POST["Action"])) {
			
			$idUser = $_SESSION["id"];
			$idEvent = $_POST["IDevent"];
			
			if ($_POST["Action"] === "inscription") {
				
				$inscription = new App\Participer([
					"IDevenement" => $idEvent,
					"IDmembre"    => $idUser,
					"Emplacement" => 1,
					"Vend"        => "Rien",
				]);
				
				$participerManager->inscription($inscription);
				
				echo json_encode([
					"text" => "Vous êtes inscrit !",
				]);
			}
			
			if ($_POST["Action"] === "desinscription") {
				$participerManager->desinscriptionEvent($idUser,$idEvent);
				
				echo json_encode([
					"text" => "Vous êtes désinscrit !",
				]);
			}
			
		} else {
			echo json_encode([
				"text" => "Une erreur est survenu, merci de rééssayer",
			]);
		}
	} else {
		echo json_encode([
			"text" => "Vous n'avez pas les autorisations pour effectuer cette action",
		]);
	}