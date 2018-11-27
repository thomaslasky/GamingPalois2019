<?php
	
	header("Content-Type: text/plain");
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$usersManager = new App\MembresManager();
	$csrf = new App\Csrf();
	$siteManager = new App\SiteManager();
	
	$site = $siteManager->selectPresentation();
	
	if (isset($_SESSION['id'])) {
		$user = $usersManager->readMembre($_SESSION["id"]);
		if ($user->getStatus() === "Administrateur") {
			
			$modeleHtml = file_get_contents("../HTML/cardpartenairesadmin.html");
			
			$presentation = "<div class='container_partenaires col s12 m12 l10 xl10 margin-auto'>";
			$presentation .= "<h1 class='center-align flow-text'>Presentation Manager</h1>";
			$presentation .= "<div class='space-between go-line'>";
			
			$formulairePresentation = new App\Formulaire("post","formulaire_user_log column","form_presentation");
			$csrf->generateInput("csrf", $formulairePresentation);
			$formulairePresentation->openDiv("","input-field col s12");
			$formulairePresentation->textArea("editor1","Presentation","material-icons prefix","contact_mail","","textEditor()",$site ?: "");
			$formulairePresentation->closeDiv();
			$formulairePresentation->openDiv("", "input-field col s12");
			$formulairePresentation->submit("Validation", "Valider", "bottum_validation_log bottum_validation_inscription modal_validate_bottom", "requestSendModifPresentation(readDataSendModifPresentation)");
			$formulairePresentation->closeDiv();
			
			$presentation .= $formulairePresentation->render();
			$presentation .= "</div></div>";
			
			echo $presentation;
		} else {
			echo "Vous n'avez pas les permissions d'accès à cette page";
		}
	} else {
		echo "Vous devez êtres connecté et administrateur pour accéder à cette page !";
	}