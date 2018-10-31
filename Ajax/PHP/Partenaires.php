<?php
	
	header("Content-Type: text/plain");
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$partenairesGPManager = new App\PartenairesgpManager();
	
	$allPartenaires = $partenairesGPManager->allPartenaireGP();
	
	$modeleHtml = file_get_contents("../HTML/cardpartenaires.html");
	
	$allPartenairesGP = "<div class='container_partenaires col s10 margin-auto'>";
	$allPartenairesGP .= "<h1 class='center-align'>Partenaires</h1><hr>";
	$allPartenairesGP .= "<div class='space-between'>";
	
	if (!empty($allPartenaires)) {
		foreach ($allPartenaires as $value) {
			$allPartenairesGP .= $partenairesGPManager->ficheAllPartenairesGP($value, $modeleHtml);
		}
	} else {
		$allPartenairesGP .= "Aucun Partenaire";
	}
	
	$allPartenairesGP .= "</div></div>";
	
	echo $allPartenairesGP;
	