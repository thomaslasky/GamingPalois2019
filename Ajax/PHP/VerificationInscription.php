<?php
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$participerManager = new App\ParticiperManager();
	$eventManager = new App\EvenementManager();
	
	if (isset($_SESSION["id"])) {
		
		$idUser = $_SESSION['id'];
		$idEvent = $_GET['IDevent'];
		
		$event = $eventManager->readEventByID($idEvent);
		
		$placeTotal = $event->getPlace();
		
		$placePrise = $eventManager->countParticipants($idEvent);
		$placeDisponible = $placeTotal - $placePrise;
		
		$verifyRegister = $participerManager->verifyInscription($idUser, $idEvent);
		
		if (!empty($idUser)) {
			if ($placeDisponible < 0 && $verifyRegister === TRUE) {
				$action = "<span class='cursor-pointer center-align black-text darken-4'>Inscriptions Complète</span>";
			} elseif ($verifyRegister === FALSE) {
				if ($event->getType() === "Vide Grenier") {
					$action = "<span class='cursor-pointer bouton_inscription' onclick='requestFormVideGrenier(readDataForm,\"InscriptionEvent\",{$idEvent})'>Inscription</span>";
				} else {
					$action = "<span class='cursor-pointer bouton_inscription' onclick='requestSendLAN(readDataSendLAN,{$idEvent})'>Inscription</span>";
				}
			} elseif ($verifyRegister === TRUE) {
				$action = "<span class='cursor-pointer bouton_inscription' onclick='requestSendDesinscription(readDataSendDesinscriptionEvent,{$idEvent})'>Desinscription</span>";
			}
		} else {
			$action = "";
		}
		
		echo $action;
	} else {
		echo "";
	}