<?php
	
	$membreManager = new App\MembresManager();
	$arrReplace = [];
	
	if (isset($_SESSION['id'])) {
		$membre = $membreManager->readMembre($_SESSION['id']);
	}
	
	if (isset($_SESSION['mail']) && isset($_SESSION['password'])) {
		if ($_SESSION['mail'] === $membre->getEmail() && $_SESSION['password'] === $membre->getPassword()) {
			$htmlConnexion = file_get_contents("Template/barreconnexion.html");
			
			if ($membre->getStatut() === "Administrateur") {
				$admin = "<a class = 'margin-auto' href = 'Administration/Accueil.php'>Administration</a>";
			} else {
				$admin = "";
			}
			
			$deco = "<a href = 'Deconnexion.php'>Deconnexion</a>";
			$profil = "<a href = 'Profile.php'>Profile</a>";
			$identite = htmlspecialchars($membre->getPrenom()) . " " . htmlspecialchars($membre->getNom());
			
			$more = "<div class = 'row no-margin-bottom'>
                <div class = 'col s9 margin-auto'>
                    <ul class = 'column space-between valign-wrapper'>
                        <li class='size_li'>$admin</li>
                        <li class='size_li'>$profil</li>
                        <li class='size_li'>$deco</li>
                    </ul>
                </div>
            </div>";
			
			$arrReplace = ['{{nomprenom}}' => htmlspecialchars($membre->getPrenom()) . " " . htmlspecialchars($membre->getNom()),
				'{{id}}' => htmlspecialchars($membre->getIdMembre()),
				'{{admin}}' => $admin];
			
			$htmlConnexion = strtr($htmlConnexion, $arrReplace);
			
			$arrReplace = ['{{connectornot}}' => $htmlConnexion,
				'{{identity}}' => htmlspecialchars($membre->getPrenom()) . " " . htmlspecialchars($membre->getNom()),
				'{{more}}' => $more];
		}
		
	} else {
		
		$connexion = "<h1 class='row title_header h1-connect-margin'><a href='Login.php'>Se Connecter</a><a href='Inscription.php'>S'inscrire</a></h1>";
		
		$identite = "";
		
		$more = "";
		
		$arrReplace = ['{{connectornot}}' => $connexion,
			'{{identity}}' => $identite,
			'{{more}}' => $connexion];
	}
	
	$navigateur = strtr($navigateur, $arrReplace);
	
	