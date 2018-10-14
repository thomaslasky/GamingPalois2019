<?php
	
	$membreManager = new App\MembresManager();
	
	$arrReplace = [];
	
	$modeleHtml = file_get_contents("Template/navigateur.html");
	
	$loginBarre = "<div class='container_user_tool'>";
	
	if (isset($_SESSION['id'])) {
		$membre = $membreManager->readMembre($_SESSION['id']);
		
		$loginBarre .= "<span style='width: 100%;text-align: center'>{$membre->getPrenom()} {$membre->getNom()}</span>\n";
		$loginBarre .= "<div class='space-between''><span>Profil</span><span onclick = 'requestDeconnexion(readDataDeconnexion)'>Deconnexion</span></div>\n";
		
		if ($membre->getStatus() === "Admimnistrateur") {
			$loginBarre .= "<span>Administration</span>";
		}
		
	} else {
		$loginBarre .= "<div class='space-between'><span class='un-surlign' onclick='requestForm(readDataForm,\"Login\")'>Connexion</span><span class='un-surlign' onclick='requestForm(readDataForm,\"Inscription\")'>Inscription</span></div>";
	}
	
	$loginBarre .= "</div>";
	
	$arrReplace = [
		'{{usertool}}' => $loginBarre,
	];
	
	$navigateur = strtr($modeleHtml, $arrReplace);