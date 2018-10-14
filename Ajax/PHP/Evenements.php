<?php
	
	header("Content-Type: text/plain");
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$eventManager = new App\EvenementManager();
	
	$evenementsHTML = file_get_contents("../HTML/evenements.html");
	
	$event = [];
	
	$videGrenier = '';
	$LAN = '';
	$allEvents = '';
	
	$eventVideGrenier = $eventManager->readAllEventWhere('Vide Grenier');
	$eventLAN = $eventManager->readAllEventWhere('LAN');
	$eventsAll = $eventManager->readAllEvent();
	
	$modeleHTML = file_get_contents('../../Template/evenements.html');
	$modeleHTMLAllEvent = file_get_contents('../../Template/allevents.html');
	
	//Gestion Vide Grenier
	
	if (!empty($eventVideGrenier)) {
		foreach($eventVideGrenier as $value) {
			$videGrenier .= $eventManager->ficheEvent($value, $modeleHTML);
		}
	} else {
		$videGrenier = 'Aucun Vide Grenier Prévu';
	}
	
	//Gestion LAN
	
	if (!empty($eventLAN)) {
		foreach($eventLAN as $value) {
			$LAN .= $eventManager->ficheEvent($value, $modeleHTML);
		}
	} else {
		$LAN = '<p>Aucune Lan Prévu</p>';
	}
	
	if (!empty($eventsAll)) {
		foreach($eventsAll as $value) {
			$allEvents .= $eventManager->ficheAllEvents($value, $modeleHTMLAllEvent);
		}
	} else {
		$allEvents = "<p>Aucun Event</p>";
	}
	
	$arrReplace = [
		"{{videgrenier}}" => $videGrenier,
		"{{lan}}"         => $LAN,
		"{{allevents}}"   => $allEvents
	];
	
	echo strtr($evenementsHTML,$arrReplace);