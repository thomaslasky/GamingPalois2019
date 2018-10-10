<?php
	
	header("Content-Type: text/plain");
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/Functions.php';
	
	$csrf = new App\Csrf();
	$usersManager = new App\MembresManager();
	
	if (isset($_GET['type'])) {
		
		//Création du formulaire de connexion
		
		if ($_GET['type'] === "Login") {
			$formulaireLogin = new App\Formulaire("post", "formulaire_user_log column", "login_form");
			$csrf->generateInput("csrf", $formulaireLogin);
			$formulaireLogin->inputText("Email", "Email", "text", "", "", "Email", "Email");
			$formulaireLogin->inputText("Password", "Password", "Password", "", "", "Password", "Password");
			$formulaireLogin->inputText("", "", "button", "bottum_validation_log margin-auto bottum_validation_inscription", "Valider", "", "", "requestLogin(readDataLogin)");
			$formulaireLogin->inputText("Remember", "Remember", "checkbox", "remember_checkbox", "true", "", "Remember me");
			$login = $formulaireLogin->render();
			
			echo $login;
		}
	}
	
	//Création du formulaire d'inscription
	
	if ($_GET['type'] === "Inscription") {
		
		$valueArray = [
			"",
			"Professionnel",
			"Particulier",
		];
		
		$formulaireInscription = new App\Formulaire("post", "formulaire_user_log column", "register_form");
		$csrf->generateInput("csrf", $formulaireInscription);
		$formulaireInscription->select("Status", $valueArray, "Vous êtes ?", "");
		$formulaireInscription->inputText("Email", "Email", "email", "field_inscription", "", "Email", "Email", "Email");
		$formulaireInscription->inputText("Prenom", "Prenom", "text", "field_inscription", "", "Prenom", "Prenom", "Prenom");
		$formulaireInscription->inputText("Nom", "Nom", "text", "field_inscription", "", "Nom", "Nom", "Nom");
		$formulaireInscription->inputText("Age", "Age", "text", "field_inscription", "", "Age", "Age", "Age");
		$formulaireInscription->inputText("Telephone", "Telephone", "text", "field_inscription", "", "Telephone", "Telephone", "Téléphone");
		$formulaireInscription->inputText("Adresse", "Adresse", "text", "field_inscription", "", "Adresse", "Adresse", "Adresse");
		$formulaireInscription->inputText("Password", "Password", "Password", "field_inscription", "", "Password", "Password", "Password");
		$formulaireInscription->inputText("", "", "button", "bottum_validation_log margin-auto bottum_validation_inscription", "Valider", "", "", "requestRegister(readDataRegister)");
		$inscription = $formulaireInscription->render();
		
		echo $inscription;
	}