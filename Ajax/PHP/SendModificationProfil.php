<?php
	
	header('Content-Type: application/json');
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	include '../../Functions/sendmail.php';
	
	$csrf = new App\Csrf();
	$membreManager = new App\MembresManager();
	
	if (isset($_POST)) {
		if (verifyTelephone($_POST["Telephone"]) === TRUE) {
			if (verifyEmail($_POST["Email"]) === TRUE) {
				
				$user = new App\Membres([
					'IDmembre'  => $_SESSION["id"],
					'Email'     => $_POST["Email"],
					'Telephone' => $_POST["Telephone"],
				]);
				
				$membreManager->updateInformations($user);
				
				echo json_encode([
					"text" => "Modification effectué",
				]);
			} else {
				echo json_encode([
					"text" => "Merci de renseigner un Email correct",
				]);
			}
		} else {
			echo json_encode([
				"text" => "Merci de renseigner un Telephone correct",
			]);
		}
	} else {
		echo json_encode([
			"text" => "Merci de remplir tout les champs",
		]);
	}
	