<?php
	
	header("Content-Type: application/json");
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$usersManager = new App\MembresManager();
	$evenementManager = new App\EvenementManager();
	$partenaireManager = new App\PartenairesManager();
	
	if (isset($_SESSION['id'])) {
		$user = $usersManager->readMembre($_SESSION["id"]);
		if ($user->getStatus() === "Administrateur") {
			
			$partenaire = $partenaireManager->readPartenaire($_POST["IDpartenaire"]);
			
			if (file_exists("../../Img/Partenaires/" . $partenaire->getUrlimg())) {
				unlink("../../Img/Partenaires/" . $partenaire->getUrlimg());
			}
			
			$partenaireManager->deletePartenaire($_POST["IDpartenaire"]);
			
			echo json_encode([
				"text" => "Partenaire Supprimé !",
			]);
		} else {
			echo json_encode([
				"text" => "Vous n'avez pas les droits pour effectuer cette action",
			]);
		}
	} else {
		echo json_encode([
			"text" => "Vous devez être connecté et administrateur pour effectuer cette action",
		]);
	}
	