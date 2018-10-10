<?php
	
	header('Content-Type: application/json');
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/Functions.php';
	
	$membreManager = new App\MembresManager();
	
	//Destruction du cookie
	
	setcookie("tokenuser", '', time() - 1);
	
	//Remise à 0 du champ Token en base
	
	$membreManager->deleteToken($_SESSION["id"]);
	
	//Destruction de la session
	
	session_destroy();
	
	echo json_encode([
		"text" => "Vous êtes déconnecté",
	]);
	
	