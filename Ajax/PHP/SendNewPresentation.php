<?php
	
	header("Content-Type: application/json");
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$csrf = new App\Csrf();
	$usersManager = new App\MembresManager();
	$siteManager = new App\SiteManager();
	
	if (isset($_SESSION['id'])) {
		$user = $usersManager->readMembre($_SESSION["id"]);
		if ($user->getStatus() === "Administrateur") {
			
			$siteManager->updatePresentation($_POST["Presentation"]);
			
			echo json_encode([
				"text" => "Presentation Modifié !",
			]);
		}
	} else {
		echo json_encode([
			"text"  => "Vous devez être connecté pour effectuer cette action !",
			"token" => $csrf->generateToken(),
		]);
	}