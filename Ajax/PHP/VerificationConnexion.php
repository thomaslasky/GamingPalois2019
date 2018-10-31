<?php
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$membreManager = new App\MembresManager();
	
	$loginBarre = "<div class='container_user_tool'>";
	
	if (isset($_SESSION['id'])) {
		
		$membre = $membreManager->readMembre($_SESSION['id']);
		
		$loginBarre .= "<span style='width: 100%;text-align: center'>{$membre->getPrenom()} {$membre->getNom()}</span>\n";
		$loginBarre .= "<div class='space-between''><span onclick='requestProfil(readData)'>Profil</span><span onclick = 'requestDeconnexion(readDataDeconnexion)'>Deconnexion</span></div>\n";
		
		if ($membre->getStatus() === "Administrateur") {
			$loginBarre .= "<span onclick='requestAdministration(readData)'>Administration</span>";
		}
		
	} else {
		$loginBarre .= "<div class='space-between'><span class='un-surlign' onclick='requestForm(readDataForm,\"Login\")'>Connexion</span><span class='un-surlign' onclick='requestForm(readDataForm,\"Inscription\")'>Inscription</span></div>";
	}
	
	$loginBarre .= "</div>";
	
	echo $loginBarre;