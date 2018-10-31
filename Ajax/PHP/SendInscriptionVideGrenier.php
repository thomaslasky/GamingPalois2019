<?php
	
	header('Content-Type: application/json');
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$participerManager = new App\ParticiperManager();
	$evenementManager = new \App\EvenementManager();
	$userManager = new \App\MembresManager();
	
	if (isset($_SESSION['id'])) {
		
		$idUser = $_SESSION["id"];
		$idEvent = $_POST["IDevent"];
		$table = $_POST["Table"];
		$vendre = $_POST["Vendre"] ?: "Non Renseigné";
		
		$userInfo = $userManager->readMembre($idUser);
		$evenementInfo = $evenementManager->readEventByID($idEvent);
		
		$inscription = new App\Participer([
			"IDevenement" => $idEvent,
			"IDmembre"    => $idUser,
			"Emplacement" => $table,
			"Vend"        => $vendre,
		]);
		
		$participerManager->inscription($inscription);
		
		$msg = "Vous vous êtes inscrit à l'événement {$evenementInfo->getNom()} ! Vous pouvez modifier vos informations directement sur votre compte dans la rubrique Profil.";
		
		if (mail($userInfo->getEmail(), "Inscription à l'évènement " . $evenementInfo->getNom(), $msg)) {
			echo json_encode([
				"text" => "Inscription effectué !",
			]);
			exit;
		} else {
			echo json_encode([
				"text" => "Inscription effectué, vous recevrez un mail sous peu",
			]);
		}
	} else {
		echo json_encode([
			"text" => "Vous n'avez pas les autorisations pour effectuer cette action",
		]);
	}