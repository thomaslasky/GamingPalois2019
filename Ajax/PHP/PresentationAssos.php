<?php
	
	header("Content-Type: text/plain");
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$siteManager = new App\SiteManager();
	
	$presentation = $siteManager->selectPresentation();
	
	$modeleHTML = file_get_contents("../HTML/presentation.html");
	
	if (!empty($presentation)) {
		$presentationShow .= $siteManager->showPresentation($presentation, $modeleHTML);
		echo $presentationShow;
	} else {
		$presentationShow .= $siteManager->showPresentation("Aucune Présentation", $modeleHTML);
		echo $presentationShow;
	}
	