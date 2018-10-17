<?php
	
	$csrf = new App\Csrf();
	
	$modeleHTML = file_get_contents("Template/profileinformation.html");
	
	$mail = $membre->getEmail() . "<br><span>Modifier</span>";
	$age = $membre->getAge() . "<br><span>Modifier</span>";
	$telephone = $membre->getTelephone() . "<br><span>Modifier</span>";
	$adresse = $membre->getAdresse() . "<br><span>Modifier</span>";
	
	$arrValues = [
		'{{mail}}'      => $mail,
		'{{age}}'       => $age,
		'{{telephone}}' => $telephone,
		'{{adresse}}'   => $adresse,
	];
	
	echo strtr($modeleHTML, $arrValues);