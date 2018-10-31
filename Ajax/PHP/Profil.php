<?php
	
	header("Content-Type: text/plain");
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$modeleHTML = file_get_contents("../HTML/profil.html");
	
	if (isset($_SESSION['id'])) {
		
		$membreManager = new App\MembresManager();
		
		$membre = $membreManager->readMembre($_SESSION["id"]);
		
		$mail = $membre->getEmail();
		$age = $membre->getAge();
		$telephone = $membre->getTelephone();
		$identity = $membre->getPrenom() . " " . $membre->getNom();
		
		$arrValues = [
			'{{identity}}'  => $identity,
			'{{mail}}'      => $mail,
			'{{age}}'       => $age,
			'{{telephone}}' => $telephone,
		];
		
		echo strtr($modeleHTML, $arrValues);
	} else {
		echo "Cette page ne vous est pas accessible !";
	}