<?php
	
	header('Content-Type: application/json');
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$csrf = new App\Csrf();
	$participerManager = new App\ParticiperManager();
	$membreManager = new \App\MembresManager();
	
	if ($csrf->verifyToken("csrf", "index.php")) {
		
		if (!empty($_POST["Message"]) && !empty($_POST["Sujet"])) {
			
			$email = [];
			
			$participant = $participerManager->idParticipants($_POST["idevent"]);
			
			foreach($participant as $v) {
				$emailParticipant = $membreManager->emailParticipant($v);
				$email[] = $emailParticipant;
			}
			
			$message = "";
			$message .= htmlspecialchars($_POST["Message"]) . "\n\n";
			$message .= "Merci de ne pas répondre à ce mail, si vous avez besoin de nous contacter suivez ce lien https://gamingpalois.fr";
			
			foreach($email as $value) {
				if (mail($value, htmlspecialchars($_POST["Sujet"]), htmlspecialchars($message))) {
					continue;
				} else {
					echo json_encode([
						"text" => "Une erreur est survenu, merci de réessayer !",
						"token" => $csrf->generateToken(),
					]);
					exit;
				}
			}
			
			echo json_encode([
				"text" => "Les Email ont été envoyé !",
			]);
			
		} else {
			echo json_encode([
				"text"  => "Merci de remplir tout les champs",
				"token" => $csrf->generateToken(),
			]);
		}
	} else {
		echo json_encode([
			"text"  => "Une erreur est survenu, merci de réessayer",
			"token" => $csrf->generateToken(),
		]);
	}