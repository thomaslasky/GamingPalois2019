<?php
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$participerManager = new App\ParticiperManager();
	$eventManager = new App\EvenementManager();
	
		$idEvent = $_GET['idevent'];
		
		$event = $eventManager->readEventByID($idEvent);
		
		$placeTotal = $event->getPlace();
		
		$placePrise = $eventManager->countParticipants($idEvent);
		$placeDisponible = $placeTotal - $placePrise;
		
		echo 49;