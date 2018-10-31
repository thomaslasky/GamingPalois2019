<?php
	
	header("Content-Type: text/plain");
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$usersManager = new App\MembresManager();
	$evenementManager = new App\EvenementManager();
	$partenaireManager = new App\PartenairesgpManager();
	
	if (isset($_SESSION['id'])) {
		$user = $usersManager->readMembre($_SESSION["id"]);
		if ($user->getStatus() === "Administrateur") {
			
			$partenaire = $partenaireManager->readPartenaireGp($_POST["IDpartenaire"]);
			
			if (file_exists("../../Img/Partenaires/" . $partenaire->getUrlimg())) {
				unlink("../../Img/Partenaires/" . $partenaire->getUrlimg());
			}
			
			$partenaireManager->deletePartenaireGP($_POST["IDpartenaire"]);
			
			echo json_encode([
				"text" => "Partenaire Supprimé",
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
	