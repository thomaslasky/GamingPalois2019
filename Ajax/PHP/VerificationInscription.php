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
		$dates = new \DateTime($event->getDates());
		$placePrise = $eventManager->countParticipants($idEvent);
		$placeDisponible = $placeTotal - $placePrise;
		
		$verifyRegister = $participerManager->verifyInscription($idUser, $idEvent);
		
		if (!empty($idUser)) {
			if ($placeDisponible < 0 && $verifyRegister === TRUE) {
				$action = "<span class='cursor-pointer center-align black-text darken-4'>Inscriptions Complète</span>";
			} elseif ($verifyRegister === FALSE) {
				$secondes = 3600 * 24 * 4;
				$intervale = new \DateInterval("PT{$secondes}S");
				if (date("Y-m-d") < $dates->sub($intervale)) {
					if ($event->getType() === "Vide Grenier") {
						$action = "<span id='loader-register-{$idEvent}' class='cursor-pointer bouton_inscription' onclick='requestFormVideGrenier(readDataForm,\"InscriptionEvent\",{$idEvent})'>Inscription</span>";
					} else {
						$action = "<span id='loader-register-{$idEvent}' class='cursor-pointer bouton_inscription' onclick='requestSendLAN(readDataSendLAN,{$idEvent}), initLoader(\"register\",{$idEvent})'>Inscription</span>";
					}
				} else {
					$action = "<span class='bouton_inscription'>Inscription Fermé</span>";
				}
			} elseif ($verifyRegister === TRUE) {
				/*$secondes = 3600 * 24 * 7;
						$intervale = new \DateInterval("PT{$secondes}S");
						if (date("Y-m-d") > $dates->sub($intervale)) {*/
				$action = "<span id='loader-register-{$idEvent}' class='cursor-pointer bouton_inscription' onclick='requestSendDesinscription(readDataSendDesinscriptionEvent,{$idEvent}), initLoader(\"register\",{$idEvent})'>Desinscription</span>";
				/*} else {
					$action = "<span class='bouton_inscription' onclick=''>Desinscription Impossible <small class='cursor-pointer blue-text darken-1' onclick='requestContact(readData)'>Contactez un administrateur</small></span>";
				}*/
			}
		} else {
			$action = "<p><span class='cursor-pointer blue-text darken-2' onclick='requestForm(readDataForm,\"Login\")'>Connectez vous</span> pour vous inscrire</p>";
		}
		
		echo $action;
	} else {
		echo "";
	}