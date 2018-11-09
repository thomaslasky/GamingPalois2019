<?php
	
	header("Content-Type: text/plain");
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$csrf = new App\Csrf();
	$usersManager = new App\MembresManager();
	$eventManager = new \App\EvenementManager();
	$participerManager = new App\ParticiperManager();
	
	if (isset($_SESSION['id'])) {
		$user = $usersManager->readMembre($_SESSION["id"]);
		if ($user->getStatus() === "Administrateur") {
			
			$allEvent = $eventManager->readAllEvent();
			
			$modeleHtml = file_get_contents("../HTML/listeadminevent.html");
			$modeleHtmlInfo = file_get_contents("../HTML/listeparticipant.html");
			$modeleHtmlInfoPartenaires = file_get_contents("../HTML/listepartenaire.html");
			
			$showAllEvent = "<div class='container_event_admin col s10 margin-auto'>";
			$showAllEvent .= "<h1 class='center-align'>Administrer événements</h1>";
			$showAllEvent .= "<div class='go-line'>";
			
			if (!empty($allEvent)) {
				foreach($allEvent as $valueEvent) {
					$showAllEvent .= $participerManager->listeParticipants($valueEvent, $modeleHtml, $modeleHtmlInfo,$modeleHtmlInfoPartenaires);
				}
			} else {
				$showAllEvent .= "Aucun Evenements";
			}
			
			$showAllEvent .= "</div></div>";
			$showAllEvent .= "<div class='bottom-add-result-icon'><div class='container-bottom-add-result'><div class = 'bottom-add-result'><img class = 'un-surlign cursor-pointer' src = '././Img/Icone/Add.png' onclick = 'requestForm(readDataForm,\"AddEvent\")'></div></div></div>";
			
			echo $showAllEvent;
		} else {
			echo "Vous n'avez pas les permissions d'accès à cette page";
		}
	} else {
		echo "Vous devez êtres connecté et administrateur pour accéder à cette page !";
	}