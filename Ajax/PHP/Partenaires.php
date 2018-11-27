<?php
	
	header("Content-Type: text/plain");
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$partenairesGPManager = new App\PartenairesgpManager();
	
	$allPartenaires = $partenairesGPManager->allPartenaireGP();
	
	$modeleHtml = file_get_contents("../HTML/cardpartenaires.html");
	
	$allPartenairesGP = "<div class='container_partenaires col s11 m11 l10 xl10 margin-auto'>";
	$allPartenairesGP .= "<h1 class='center-align flow-text'>Partenaires</h1>";
	$allPartenairesGP .= "<div class='space-between go-line'>";
	
	if (!empty($allPartenaires)) {
		foreach ($allPartenaires as $value) {
			$allPartenairesGP .= $partenairesGPManager->ficheAllPartenairesGP($value, $modeleHtml);
		}
	} else {
		$allPartenairesGP .= "Aucun Partenaire";
	}
	
	$allPartenairesGP .= "</div></div>";
	
	echo $allPartenairesGP;
	