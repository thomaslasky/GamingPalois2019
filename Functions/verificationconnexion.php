<?php
	
	$membreManager = new App\MembresManager();
	
	$arrReplace = [];
	
	$modeleHtml = file_get_contents("Template/navigateur.html");
	
	$loginBarre = "<div class='container_user_tool'>";
	
	if (isset($_SESSION['id'])) {
		$membre = $membreManager->readMembre($_SESSION['id']);
		
		$loginBarre .= "<span style='width: 100%;text-align: center'>{$membre->getPrenom()} {$membre->getNom()}</span>";
		$loginBarre .= "<div class='space-between'><span onclick='requestProfil(readData) ; closeNavigateur()'>Profil</span><span onclick = 'requestDeconnexion(readDataDeconnexion)'>Deconnexion</span></div>\n";
		
		if ($membre->getStatus() === "Administrateur") {
			$loginBarre .= "<span onclick='requestAdministration(readData) ; closeNavigateur()'>Administration</span>";
		}
		
	} else {
		$loginBarre .= "<div class='space-between'><span class='un-surlign' onclick='requestForm(readDataForm,\"Login\")'>Connexion</span><span class='un-surlign' onclick='requestForm(readDataForm,\"Inscription\") ; closeNavigateur()'>Inscription</span></div>";
	}
	
	$loginBarre .= "</div>";
	
	$arrReplace = [
		'{{usertool}}' => $loginBarre,
	];
	
	$navigateur = strtr($modeleHtml, $arrReplace);