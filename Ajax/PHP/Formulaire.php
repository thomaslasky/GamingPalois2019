<?php
	
	header("Content-Type: text/plain");
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$csrf = new App\Csrf();
	$usersManager = new App\MembresManager();
	$partenaireManager = new \App\PartenairesgpManager();
	$eventManager = new \App\EvenementManager();
	
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
			$formulaireInscription->openDiv("", "col s12");
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
			
			$contact = "<h1 class='center-align'>Devenir Membre</h1>";
			$contact .= "<p>Vous sera demandé 15€ à l'inscription</p>";
			
			$formulaireBecomeMember = new App\Formulaire("post", "", "form_contact");
			$csrf->generateInput("csrf", $formulaireBecomeMember);
			$formulaireBecomeMember->openDiv("", "input-field col s6");
			$formulaireBecomeMember->inputText("Prenom", "Prenom", "Prenom", "", $prenom, "material-icons prefix", "person", $more, $labelClass);
			$formulaireBecomeMember->closeDiv();
			$formulaireBecomeMember->openDiv("", "input-field col s6");
			$formulaireBecomeMember->inputText("Nom", "Nom", "Nom", "", $nom, "material-icons prefix", "person", $more, $labelClass);
			$formulaireBecomeMember->closeDiv();
			$formulaireBecomeMember->openDiv("", "input-field col s12");
			$formulaireBecomeMember->inputEmail("Email", "Email", "Email", "", $mail, "material-icons prefix", "contact_mail", $more, $labelClass);
			$formulaireBecomeMember->closeDiv();
			$formulaireBecomeMember->openDiv("", "input-field col s7");
			$formulaireBecomeMember->inputTelephone("Telephone", "Telephone", "Portable", "", $telephone, "material-icons prefix", "contact_phone", $more, $labelClass);
			$formulaireBecomeMember->closeDiv();
			$formulaireBecomeMember->openDiv("", "input-field col s5");
			$formulaireBecomeMember->inputText("Sujet", "Sujet", "Sujet", "", "Devenir Membre", "material-icons prefix", "subject", "readonly", "active");
			$formulaireBecomeMember->closeDiv();
			$formulaireBecomeMember->openDiv("", "input-field col s12");
			$formulaireBecomeMember->inputText("Message", "Message", "Message", "", "", "material-icons prefix", "message", "");
			$formulaireBecomeMember->closeDiv();
			$formulaireBecomeMember->openDiv("", "input-field col s12");
			$formulaireBecomeMember->openDiv("", "input-field col s6 margin-auto");
			$formulaireBecomeMember->submit("Validation", "Valider", "col s12 bottum_validation_log bottum_validation_inscription", "requestSendBecomeMember(readDataSendBecomeMember)");
			$formulaireBecomeMember->closeDiv(2);
			
			$contact .= $formulaireBecomeMember->render();
			
			echo $contact;
		}
		
		//Création du formulaire d'inscription
		
		if ($_GET["type"] === "InscriptionEvent" && isset($_GET["idevent"])) {
			
			$contact = "<h1 class='center-align'>Inscription à un événement</h1>";
			
			$formulaireInscriptionEvent = new App\Formulaire("post", "", "form_contact");
			$csrf->generateInput("csrf", $formulaireInscriptionEvent);
			$formulaireInscriptionEvent->openDiv("", "input-field col s12");
			$formulaireInscriptionEvent->inputNumber("Table", "Table", "Nombre de table", "", "", "material-icons prefix", "assignment", "", "0", "30");
			$formulaireInscriptionEvent->closeDiv();
			$formulaireInscriptionEvent->openDiv("", "input-field col s12");
			$formulaireInscriptionEvent->inputText("Vendre", "Vendre", "A vendre :", "", "", 'material-icons prefix', 'shopping_cart');
			$formulaireInscriptionEvent->closeDiv();
			$formulaireInscriptionEvent->openDiv("", "col s12");
			$formulaireInscriptionEvent->submit("Submit", "Envoyer", "col s4 margin-auto", "requestSendVideGrenier(readDataSendVideGrenier,{$_GET['idevent']}) ,initLoader(\"register\",{$_GET['idevent']}), closeModal(\"page\")");
			$formulaireInscriptionEvent->closeDiv();
			
			$contact .= $formulaireInscriptionEvent->render();
			echo $contact;
		}
		
		//Création formulaire ajout partenaires
		
		if ($_GET["type"] === "AddPartenaires") {
			
			$add = "";
			$add .= "<div><h1 style='text-align: center;font-size: 3.2em'>Ajouter un Partenaire</h1></div>";
			
			$formulaireAddPartenaire = new \App\Formulaire("post", "", "form_add_partenaire");
			$csrf->generateInput("csrf", $formulaireAddPartenaire);
			$formulaireAddPartenaire->openDiv("", "input-field col s12");
			$formulaireAddPartenaire->inputText("Nom", "Nom", "Nom", "", "", "material-icons prefix", "contact_mail", "required");
			$formulaireAddPartenaire->closeDiv();
			$formulaireAddPartenaire->openDiv("", "input-field col s12");
			$formulaireAddPartenaire->inputText("Description", "Description", "Description", "", "", "material-icons prefix", "contact_mail", "required");
			$formulaireAddPartenaire->closeDiv();
			$formulaireAddPartenaire->openDiv("", "input-field col s12");
			$formulaireAddPartenaire->inputLink("Lien", "Lien", 'Lien', '', "", "material-icons prefix", "contact_mail", "required");
			$formulaireAddPartenaire->closeDiv();
			$formulaireAddPartenaire->openDiv("", "input-field col s12");
			$formulaireAddPartenaire->inputFile("Logo", "Logo", "Logo", "", "material-icons prefix", "contact_mail", "active", "onchange='showPicture(this);'");
			$formulaireAddPartenaire->closeDiv();
			$formulaireAddPartenaire->openDiv("", "input-field col s12 m8 l4 xl4 margin-auto");
			$formulaireAddPartenaire->submit("Validation", "Valider", "col s12 bottum_validation_log margin-auto bottum_validation_inscription", "requestSendNewPartenaire(readDataSendNewPartenaire)");
			$formulaireAddPartenaire->closeDiv();
			
			$add .= $formulaireAddPartenaire->render();
			$add .= "<img id='blah' class='margin-auto' style='display: block;' src='#' alt='' />";
			
			echo $add;
		}
		
		//Création formulaire modification partenaires information
		
		if ($_GET["type"] === "ModifPartenaire" && isset($_GET["idpartenaire"])) {
			
			$partenaire = $partenaireManager->readPartenaireGp($_GET["idpartenaire"]);
			
			$modif = "";
			$modif .= "<div><h1 style='text-align: center;font-size: 3.2em'>Modifier un Partenaire</h1></div>";
			
			$formulaireModifPartenaire = new \App\Formulaire("post", "", "form_modif_partenaire");
			$csrf->generateInput("csrf", $formulaireModifPartenaire);
			$formulaireModifPartenaire->openDiv("", "input-field col s12");
			$formulaireModifPartenaire->inputText("Nom", "Nom", "Nom", "", $partenaire->getNom() ?: "", "material-icons prefix", "contact_mail", "required", "active");
			$formulaireModifPartenaire->closeDiv();
			$formulaireModifPartenaire->openDiv("", "input-field col s12");
			$formulaireModifPartenaire->inputText("Description", "Description", "Description", "", $partenaire->getDescription() ?: "", "material-icons prefix", "contact_mail", "required", "active");
			$formulaireModifPartenaire->closeDiv();
			$formulaireModifPartenaire->openDiv("", "input-field col s12");
			$formulaireModifPartenaire->inputLink("Lien", "Lien", 'Lien', '', $partenaire->getSite() ?: "", "material-icons prefix", "contact_mail", "required", "active");
			$formulaireModifPartenaire->closeDiv();
			$formulaireModifPartenaire->openDiv("", "input-field col s12 m8 l4 xl4 margin-auto");
			$formulaireModifPartenaire->submit("Validation", "Valider", "col s12 bottum_validation_log margin-auto bottum_validation_inscription", "requestSendModifPartenaire(readDataSendModifPartenaire,{$_GET["idpartenaire"]})");
			$formulaireModifPartenaire->closeDiv();
			
			$modif .= $formulaireModifPartenaire->render();
			
			echo $modif;
		}
		
		//Création formulaire modification partenaire image
		
		if ($_GET["type"] === "ModificationImgPartenaire" && isset($_GET["idpartenaire"])) {
			$modif = "";
			$modif .= "<div><h1 style='text-align: center;font-size: 3.2em'>Modifier le logo du Partenaire</h1></div>";
			
			$formulaireModifPartenaire = new \App\Formulaire("post", "", "form_modif_partenaire");
			$csrf->generateInput("csrf", $formulaireModifPartenaire);
			$formulaireModifPartenaire->openDiv("", "input-field col s12");
			$formulaireModifPartenaire->inputFile("Logo", "Logo", "Logo", "", "", "", "active", "onchange='showPicture(this);'");
			$formulaireModifPartenaire->closeDiv();
			$formulaireModifPartenaire->openDiv("", "input-field col s12 m8 l4 xl4 margin-auto");
			$formulaireModifPartenaire->submit("Validation", "Valider", "col s12 bottum_validation_log margin-auto bottum_validation_inscription", "requestSendModifImgPartenaire(readDataSendModifImgPartenaire,{$_GET["idpartenaire"]})");
			$formulaireModifPartenaire->closeDiv();
			
			$modif .= $formulaireModifPartenaire->render();
			$modif .= "<img id='blah' class='margin-auto' style='display: block;' src='#' alt='' />";
			
			echo $modif;
		}
		
		//Création formulaire modification evenement information
		
		if ($_GET["type"] === "ModificationEventInfo" && isset($_GET["idevent"])) {
			
			$event = $eventManager->readEventByID($_GET["idevent"]);
			
			$modifEvent = "<h1 class='center-align'>Modifier Event</h1>";
			
			$formulaireModifEvent = new App\Formulaire("post", "container_addevent margin-auto", "form_modify_event");
			$csrf->generateInput("csrf", $formulaireModifEvent);
			$formulaireModifEvent->openDiv("", "input-field col s12");
			$formulaireModifEvent->inputText("Name", "Nom", "Nom de l'événement", "", $event->getNom() ?: "", "material-icons prefix", "label", "", "active");
			$formulaireModifEvent->closeDiv();
			$formulaireModifEvent->openDiv("", "input-field col s12");
			$formulaireModifEvent->inputDate("Date", "Date", "Date de l'événement", "", $event->getDates() ?: "", "material-icons prefix", "date_range", "active");
			$formulaireModifEvent->closeDiv();
			$formulaireModifEvent->openDiv("", "input-field col s12");
			$formulaireModifEvent->openDiv("", "input-field col s7");
			$formulaireModifEvent->inputText("Adresse", "Adresse", "Adresse", "", $event->getAdresse() ?: "", "material-icons prefix", "map", "", "active");
			$formulaireModifEvent->closeDiv();
			$formulaireModifEvent->openDiv("", "input-field col s3");
			$formulaireModifEvent->inputNumber("Place", "Place", "Place/Table", "", $event->getPlace() ?: "", "material-icons prefix", "confirmation_number", "active");
			$formulaireModifEvent->closeDiv();
			$formulaireModifEvent->openDiv("", "input-field col s2");
			$formulaireModifEvent->inputNumber("Prix", "Prix", "Tarif", "", $event->getPrix() ?: "", "material-icons prefix", "euro_symbol", "active");
			$formulaireModifEvent->closeDiv(2);
			$formulaireModifEvent->openDiv("", "input-field col s12");
			$formulaireModifEvent->inputText("Description", "Description", "Description", "", $event->getDescription() ?: "", "material-icons prefix", "description", "", "active");
			$formulaireModifEvent->closeDiv();
			$formulaireModifEvent->openDiv("", "margin-auto");
			$formulaireModifEvent->submit("Envoyer", "Modifier", "valide_form", "requestSendModifEvent(readDataSendModifEvent,{$_GET["idevent"]})");
			$formulaireModifEvent->closeDiv();
			
			$modifEvent .= $formulaireModifEvent->render();
			$modifEvent .= "</div>";
			
			echo $modifEvent;
		}
		
		//Création formulaire modification event image
		
		if ($_GET["type"] === "ModificationImgEvent" && isset($_GET["idevent"])) {
			
			$modif = "";
			$modif .= "<div><h1 style='text-align: center;font-size: 3.2em'>Modifier le logo de l'événement</h1></div>";
			
			$formulaireModifEvent = new \App\Formulaire("post", "", "form_modif_event");
			$csrf->generateInput("csrf", $formulaireModifEvent);
			$formulaireModifEvent->openDiv("", "input-field col s12");
			$formulaireModifEvent->inputFile("Logo", "Logo", "Logo", "", "", "", "active", "onchange='showPicture(this);'");
			$formulaireModifEvent->closeDiv();
			$formulaireModifEvent->openDiv("", "input-field col s12 m8 l4 xl4 margin-auto");
			$formulaireModifEvent->submit("Validation", "Valider", "col s12 bottum_validation_log margin-auto bottum_validation_inscription", "requestSendModifImgEvent(readDataSendModifImgEvent,{$_GET["idevent"]})");
			$formulaireModifEvent->closeDiv();
			
			$modif .= $formulaireModifEvent->render();
			$modif .= "<img id='blah' class='margin-auto' style='display: block;' src='#' alt='' />";
			
			echo $modif;
		}
		
		//Création formulaire d'envoi de mail à tout les participants d'un event
		
		if ($_GET["type"] === "SendEmailAllParticipant" && isset($_GET["idevent"])) {
			
			$sendEmailAll = "";
			$sendEmailAll .= "<div><h1 style='text-align: center;font-size: 3.2em'>Envoyez un Email à tout les Participants</h1></div>";
			
			$formulaireSendMailAllParticipant = new \App\Formulaire("post", "", "form_send_mail_all");
			$csrf->generateInput("csrf", $formulaireSendMailAllParticipant);
			$formulaireSendMailAllParticipant->openDiv("", "input-field col s12");
			$formulaireSendMailAllParticipant->inputText("Sujet", "Sujet", "Sujet", "", "", "material-icons prefix", "email", "", "");
			$formulaireSendMailAllParticipant->closeDiv();
			$formulaireSendMailAllParticipant->openDiv("", "input-field col s12");
			$formulaireSendMailAllParticipant->inputText("Message", "Message", "Message", "", "", "material-icons prefix", "email", "", "");
			$formulaireSendMailAllParticipant->closeDiv();
			$formulaireSendMailAllParticipant->openDiv("", "input-field col s12 m8 l4 xl4 margin-auto");
			$formulaireSendMailAllParticipant->submit("Validation", "Valider", "col s12 bottum_validation_log margin-auto bottum_validation_inscription", "requestSendMailAllParticipants(readDataSendMailAllParticipants,{$_GET["idevent"]})");
			$formulaireSendMailAllParticipant->closeDiv();
			
			$sendEmailAll .= $formulaireSendMailAllParticipant->render();
			
			echo $sendEmailAll;
		}
		
		//Création formulaire d'ajout de partenaire à l'événement
		
		if ($_GET["type"] === "AddPartenaireEvent" && isset($_GET["idevent"])) {
			
			$add = "";
			$add .= "<div><h1 style='text-align: center;font-size: 3.2em'>Ajouter un Partenaire à l'événement</h1></div>";
			
			$formulaireAddPartenaire = new \App\Formulaire("post", "", "form_add_partenaire_event");
			$csrf->generateInput("csrf", $formulaireAddPartenaire);
			$formulaireAddPartenaire->openDiv("", "input-field col s12");
			$formulaireAddPartenaire->inputText("Nom", "Nom", "Nom", "", "", "material-icons prefix", "contact_mail", "required");
			$formulaireAddPartenaire->closeDiv();
			$formulaireAddPartenaire->openDiv("", "input-field col s12");
			$formulaireAddPartenaire->inputText("Description", "Description", "Description", "", "", "material-icons prefix", "contact_mail", "required");
			$formulaireAddPartenaire->closeDiv();
			$formulaireAddPartenaire->openDiv("", "input-field col s12");
			$formulaireAddPartenaire->inputLink("Lien", "Lien", 'Lien', '', "", "material-icons prefix", "contact_mail", "required");
			$formulaireAddPartenaire->closeDiv();
			$formulaireAddPartenaire->openDiv("", "input-field col s12");
			$formulaireAddPartenaire->inputFile("Logo", "Logo", "Logo", "", "material-icons prefix", "contact_mail", "active", "onchange='showPicture(this);'");
			$formulaireAddPartenaire->closeDiv();
			$formulaireAddPartenaire->openDiv("", "input-field col s12 m8 l4 xl4 margin-auto");
			$formulaireAddPartenaire->submit("Validation", "Valider", "col s12 bottum_validation_log margin-auto bottum_validation_inscription", "requestSendNewPartenaireEvent(readDataSendNewPartenaireEvent,{$_GET["idevent"]})");
			$formulaireAddPartenaire->closeDiv();
			
			$add .= $formulaireAddPartenaire->render();
			$add .= "<img id='blah' class='margin-auto' style='display: block;' src='#' alt='' />";
			
			echo $add;
		}
	}