<?php
	
	header("Content-Type: text/plain");
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	$usersManager = new App\MembresManager();
	$partenairesGPManager = new \App\PartenairesgpManager();
	
	if (isset($_SESSION['id'])) {
		$user = $usersManager->readMembre($_SESSION["id"]);
		if ($user->getStatus() === "Administrateur") {
			$allPartenaires = $partenairesGPManager->allPartenaireGP();
			
			$modeleHtml = file_get_contents("../HTML/cardpartenairesadmin.html");
			
			$allPartenairesGP = "<div class='container_partenaires col s11 m11 l10 xl10 margin-auto'>";
			$allPartenairesGP .= "<h1 class='center-align flow-text'>Partenaires</h1>";
			$allPartenairesGP .= "<div>";
			
			if (!empty($allPartenaires)) {
				foreach($allPartenaires as $value) {
					$allPartenairesGP .= $partenairesGPManager->ficheAllPartenairesGP($value, $modeleHtml);
				}
			} else {
				$allPartenairesGP .= "Aucun Partenaire";
			}
			
			$allPartenairesGP .= "</div></div>";
			$allPartenairesGP .= "<div class='bottom-add-result-icon'><div class='container-bottom-add-result'><div class = 'bottom-add-result'><img class = 'un-surlign cursor-pointer' src = '././Img/Icone/Add.png' onclick = 'requestForm(readDataForm,\"AddPartenaires\")'></div></div></div>";
			
			echo $allPartenairesGP;
		} else {
			echo "Vous n'avez pas les permissions d'accès à cette page";
		}
	} else {
		echo "Vous devez êtres connecté et administrateur pour accéder à cette page !";
	}