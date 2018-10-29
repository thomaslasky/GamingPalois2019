<?php
	
	header("Content-Type: text/plain");
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$csrf = new App\Csrf();
	$usersManager = new App\MembresManager();
	
	$contactHTML = file_get_contents("../HTML/contact.html");
	
	if (isset($_SESSION['id'])) {
		$user = $usersManager->readMembre($_SESSION['id']);
		
		$prenom = $user->getPrenom();
		$nom = $user->getNom();
		$mail = $user->getEmail();
		$telephone = $user->getTelephone();
		$more = "readonly";
		$labelClass = "active";
	} else {
		$prenom = "";
		$nom = "";
		$mail = "";
		$telephone = "";
		$more = "";
		$labelClass = "";
	}
	
	$formulaireContact = new App\Formulaire("post", "", "form_contact");
	$csrf->generateInput("csrf", $formulaireContact);
	$formulaireContact->openDiv("", "input-field col s6");
	$formulaireContact->inputText("Prenom", "Prenom", "Prenom", "", $prenom, "material-icons prefix", "person", $more, $labelClass);
	$formulaireContact->closeDiv();
	$formulaireContact->openDiv("", "input-field col s6");
	$formulaireContact->inputText("Nom", "Nom", "Nom", "", $nom, "material-icons prefix", "person", $more, $labelClass);
	$formulaireContact->closeDiv();
	$formulaireContact->openDiv("", "input-field col s12");
	$formulaireContact->inputEmail("Email", "Email", "Email", "", $mail, "material-icons prefix", "contact_mail", $more, $labelClass);
	$formulaireContact->closeDiv();
	$formulaireContact->openDiv("", "input-field col s7");
	$formulaireContact->inputTelephone("Telephone", "Telephone", "Portable", "", $telephone, "material-icons prefix", "contact_phone", $more, $labelClass);
	$formulaireContact->closeDiv();
	$formulaireContact->openDiv("", "input-field col s5");
	$formulaireContact->inputText("Sujet", "Sujet", "Sujet", "", "", "material-icons prefix", "subject", "");
	$formulaireContact->closeDiv();
	$formulaireContact->openDiv("", "input-field col s12");
	$formulaireContact->inputText("Message", "Message", "Message", "", "", "material-icons prefix", "message");
	$formulaireContact->closeDiv();
	$formulaireContact->openDiv("", "input-field col s12");
	$formulaireContact->openDiv("loader-contact-1", "input-field col s6 margin-auto");
	$formulaireContact->submit("Validation", "Valider", "col s12 bottum_validation_log bottum_validation_inscription", "requestSendContact(readDataSendContact),initLoader(\"contact\",1)");
	$formulaireContact->closeDiv(2);
	
	$contact = $formulaireContact->render();
	
	$arrReplace = [
		"{{formulairecontact}}" => $contact,
	];
	
	echo strtr($contactHTML, $arrReplace);