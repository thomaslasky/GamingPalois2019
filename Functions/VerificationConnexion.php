<?php
	
	$membreManager = new App\MembresManager();
	
	$arrReplace = [];
	
	$modeleHtml = file_get_contents("Template/navigateur.html");
	
	$loginBarre = "<div class='container_user_tool'>";
	
	if (isset($_SESSION['id'])) {
		$membre = $membreManager->readMembre($_SESSION['id']);
		
		$loginBarre .= "<span>{$membre->getPrenom()} {$membre->getNom()}</span>\n";
		$loginBarre .= "<div><span>Profil</span><span onclick = 'requestDeconnexion(readDataDeconnexion)'>Deconnexion</span></div>\n";
		
		if ($membre->getStatus() === "Admimnistrateur") {
			$loginBarre .= "<span>Administration</span>";
		}
		
		
	} else {
		$loginBarre .= "<div class='space-between'><span onclick=''>Connexion</span><span>Inscription</span></div>";
	}
	
	$loginBarre .= "</div>";
	
	$arrReplace = [
		'{{usertool}}' => $loginBarre,
	];
	
	$navigateur = strtr($modeleHtml, $arrReplace);
	
	