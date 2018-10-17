<?php
	
	header("Content-Type: text/plain");
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$modeleHTML = file_get_contents("../HTML/profil.html");
	
	if (isset($_SESSION['id'])) {
		
		$membreManager = new App\MembresManager();
		
		$membre= $membreManager->readMembre($_SESSION["id"]);
		
		$mail = $membre->getEmail() . "<br><span>Modifier</span>";
		$age = $membre->getAge() . "<br><span>Modifier</span>";
		$telephone = $membre->getTelephone() . "<br><span>Modifier</span>";
		
		$arrValues = [
			'{{mail}}'      => $mail,
			'{{age}}'       => $age,
			'{{telephone}}' => $telephone,
		];
		
		echo strtr($modeleHTML, $arrValues);
	} else {
		echo "Cette page ne vous est pas accessible !";
	}