<?php
	
	header("Content-Type: text/plain");
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$csrf = new App\Csrf();
	$usersManager = new App\MembresManager();
	
	if (isset($_SESSION['id'])) {
		$user = $usersManager->readMembre($_SESSION["id"]);
		if ($user->getStatus() === "Administrateur") {
			
			$typeEvent = [
				"Vide Grenier",
				"LAN"
			];
			
			$addEvent = "<div class='col s10 container_form_createvent'>";
			$addEvent .= "<h1 class='center-align'>Créer un événement</h1>";
			
			$formulaireNewEvent = new App\Formulaire("post", "container_addevent margin-auto","form_create_event");
			$csrf->generateInput("csrf", $formulaireNewEvent);
			$formulaireNewEvent->openDiv("","col s12");
			$formulaireNewEvent->select("Type", $typeEvent, "Type d'évènement", "");
			$formulaireNewEvent->closeDiv();
			$formulaireNewEvent->openDiv("","input-field col s12");
			$formulaireNewEvent->inputFile("File","File","Logo de l'événement","","material-icons prefix","add_photo_alternate","active");
			$formulaireNewEvent->closeDiv();
			$formulaireNewEvent->openDiv("","input-field col s12");
			$formulaireNewEvent->inputText("Name", "Nom", "Nom de l'événement", "", "", "material-icons prefix","label");
			$formulaireNewEvent->closeDiv();
			$formulaireNewEvent->openDiv("","input-field col s12");
			$formulaireNewEvent->inputDate("Date","Date","Date de l'événement","","","material-icons prefix","date_range","active");
			$formulaireNewEvent->closeDiv();
			$formulaireNewEvent->openDiv("","input-field col s12");
			$formulaireNewEvent->openDiv("","input-field col s7");
			$formulaireNewEvent->inputText("Adresse", "Adresse", "Adresse", "", "", "material-icons prefix","map");
			$formulaireNewEvent->closeDiv();
			$formulaireNewEvent->openDiv("","input-field col s3");
			$formulaireNewEvent->inputNumber("Place", "Place", "Place/Table", "", "", "material-icons prefix","confirmation_number");
			$formulaireNewEvent->closeDiv();
			$formulaireNewEvent->openDiv("","input-field col s2");
			$formulaireNewEvent->inputNumber("Prix", "Prix", "Tarif", "", "", "material-icons prefix","euro_symbol");
			$formulaireNewEvent->closeDiv(2);
			$formulaireNewEvent->openDiv("","input-field col s12");
			$formulaireNewEvent->inputText("Description", "Description", "Description", "", "", "material-icons prefix","description");
			$formulaireNewEvent->closeDiv();
			$formulaireNewEvent->openDiv("","margin-auto");
			$formulaireNewEvent->submit("Envoyer", "Créer", "valide_form","requestSendCreateEvent(readDataSendCreateEvent)");
			$formulaireNewEvent->closeDiv();
			
			$addEvent .= $formulaireNewEvent->render();
			$addEvent .= "</div>";
			
			echo $addEvent;
		} else {
			echo "Vous n'avez pas les permissions d'accès à cette page";
		}
	} else {
		echo "Vous devez êtres connecté et administrateur pour accéder à cette page !";
	}