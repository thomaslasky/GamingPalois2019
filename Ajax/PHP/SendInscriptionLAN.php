<?php
	
	header('Content-Type: application/json');
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$participerManager = new App\ParticiperManager();
	
	if (isset($_SESSION['id'])) {
		
		$idUser = $_SESSION["id"];
		$idEvent = $_POST["IDevent"];
		
		$inscription = new App\Participer([
			"IDevenement" => $idEvent,
			"IDmembre"    => $idUser,
			"Emplacement" => 1,
			"Vend"        => "Rien",
		]);
		
		$participerManager->inscription($inscription);
		
		echo json_encode([
			"text" => "Inscription effectué !",
		]);
		
	} else {
		echo json_encode([
			"text" => "Vous n'avez pas les autorisations pour effectuer cette action",
		]);
	}