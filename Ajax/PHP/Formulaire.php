<?php
	
	header("Content-Type: text/plain");
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$csrf = new App\Csrf();
	$usersManager = new App\MembresManager();
	
	if (isset($_GET['type'])) {
		
		//Création du formulaire de connexion
		
		if ($_GET['type'] === "Login") {
			
			$login = "";
			$login .= "<div><h1 style='text-align: center;font-size: 3.2em'>Login</h1></div>";
			
			$formulaireLogin = new App\Formulaire("post", "formulaire_user_log column", "login_form");
			$csrf->generateInput("csrf", $formulaireLogin);
			$formulaireLogin->openDiv("", "row");
			$formulaireLogin->openDiv("", "input-field col s12");
			$formulaireLogin->inputEmail("Email", "Email", "Email", "", "", "material-icons prefix", "contact_mail");
			$formulaireLogin->closeDiv();
			$formulaireLogin->openDiv("", "input-field col s12");
			$formulaireLogin->inputPassword("Password", "Password", "Password", "", "", "material-icons prefix", "lock_outline");
			$formulaireLogin->openDiv("", "input-field col s12 m8 l4 xl4 margin-auto");
			$formulaireLogin->submit("Validation", "Valider", "col s12 bottum_validation_log margin-auto bottum_validation_inscription", "requestLogin(readDataLogin)");
			$formulaireLogin->closeDiv(2);
			//$formulaireLogin->inputText("Remember", "Remember", "checkbox", "remember_checkbox", "true", "", "Remember me");
			$login .= $formulaireLogin->render();
			
			echo $login;
		}
		
		//Création du formulaire d'inscription
		
		if ($_GET['type'] === "Inscription") {
			
			$valueArray = [
				"Professionnel",
				"Particulier",
			];
			
			$inscription = "";
			$inscription .= "<div><h1 style='text-align: center;font-size: 3.2em'>Inscription</h1></div>";
			
			$formulaireInscription = new App\Formulaire("post", "formulaire_user_log column col s12", "register_form");
			$csrf->generateInput("csrf", $formulaireInscription);
			$formulaireInscription->openDiv("", "row");
			$formulaireInscription->openDiv("", "input-field col s12");
			$formulaireInscription->select("Status", $valueArray, "Vous êtes ?", "");
			$formulaireInscription->closeDiv();
			$formulaireInscription->openDiv("", "input-field col s12");
			$formulaireInscription->inputEmail("Email", "Email", "Email", "", "", "material-icons prefix", "contact_mail");
			$formulaireInscription->closeDiv();
			$formulaireInscription->openDiv("", "input-field col s12 m12 l6 xl6");
			$formulaireInscription->inputText("Prenom", "Prenom", "Prenom", "", "", "material-icons prefix", "person");
			$formulaireInscription->closeDiv();
			$formulaireInscription->openDiv("", "input-field col s12 m12 l6 xl6");
			$formulaireInscription->inputText("Nom", "Nom", "Nom", "", "", "material-icons prefix", "person");
			$formulaireInscription->closeDiv();
			$formulaireInscription->openDiv("", "input-field col s12 m12 l4 xl4");
			$formulaireInscription->inputNumber("Age", "Age", "Age", TRUE, "", "material-icons prefix", "date_range");
			$formulaireInscription->closeDiv();
			$formulaireInscription->openDiv("", "input-field col s12 m12 l8 xl8");
			$formulaireInscription->inputTelephone("Telephone", "Telephone", "Portable", "", "", "material-icons prefix", "contact_phone");
			$formulaireInscription->closeDiv();
			$formulaireInscription->openDiv("", "input-field col s12");
			$formulaireInscription->inputPassword("Password", "Password", "Password", "", "", "material-icons prefix", "lock_outline");
			$formulaireInscription->closeDiv();
			$formulaireInscription->openDiv("", "input-field col s12");
			$formulaireInscription->openDiv("", "col s6 m6 l4 xl4 margin-auto");
			$formulaireInscription->submit("Validation", "Valider", "col s12 bottum_validation_log bottum_validation_inscription", "requestRegister(readDataRegister)");
			$formulaireInscription->closeDiv(3);
			$inscription .= $formulaireInscription->render();
			
			echo $inscription;
		}
		
		//Création du formulaire pour devenir membre
		
		if ($_GET["type"] === "BecomeMember") {
			
			if (isset($_SESSION['id'])) {
				
				$user = $usersManager->readMembre($_SESSION['id']);
				
				$prenom = $user->getPrenom();
				$nom = $user->getNom();
				$mail = $user->getEmail();
				$telephone = "0" . $user->getTelephone();
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
			
			$contact = "<h1 class='center-align'>Devenir Membre</h1>";
			$contact .= "<p>Vous sera demandé 15€ à l'inscription</p>";
			
			$formulaireBecomeMember = new App\Formulaire("post", "", "form_contact");
			$csrf->generateInput("csrf", $formulaireBecomeMember);
			$formulaireBecomeMember->openDiv("", "input-field col s6");
			$formulaireBecomeMember->inputText("Prenom", "Prenom", "Prenom", "", $prenom, "material-icons prefix", "person", $more,$labelClass);
			$formulaireBecomeMember->closeDiv();
			$formulaireBecomeMember->openDiv("", "input-field col s6");
			$formulaireBecomeMember->inputText("Nom", "Nom", "Nom", "", $nom, "material-icons prefix", "person", $more,$labelClass);
			$formulaireBecomeMember->closeDiv();
			$formulaireBecomeMember->openDiv("", "input-field col s12");
			$formulaireBecomeMember->inputEmail("Email", "Email", "Email", "", $mail, "material-icons prefix", "contact_mail", $more,$labelClass);
			$formulaireBecomeMember->closeDiv();
			$formulaireBecomeMember->openDiv("", "input-field col s7");
			$formulaireBecomeMember->inputTelephone("Telephone", "Telephone", "Portable", "", $telephone, "material-icons prefix", "contact_phone", $more,$labelClass);
			$formulaireBecomeMember->closeDiv();
			$formulaireBecomeMember->openDiv("", "input-field col s5");
			$formulaireBecomeMember->inputText("Sujet", "Sujet", "Sujet", "", "Devenir Membre", "material-icons prefix", "subject", "readonly","active");
			$formulaireBecomeMember->closeDiv();
			$formulaireBecomeMember->openDiv("", "input-field col s12");
			$formulaireBecomeMember->inputText("Message", "Message", "Message", "", "", "material-icons prefix", "message","");
			$formulaireBecomeMember->closeDiv();
			$formulaireBecomeMember->openDiv("", "input-field col s12");
			$formulaireBecomeMember->openDiv("", "input-field col s6 margin-auto");
			$formulaireBecomeMember->submit("Validation", "Valider", "col s12 bottum_validation_log bottum_validation_inscription", "requestSendBecomeMember(readDataSendBecomeMember)");
			$formulaireBecomeMember->closeDiv(2);
			
			$contact .= $formulaireBecomeMember->render();
			
			echo $contact;
		}
		
	}
	

	
	