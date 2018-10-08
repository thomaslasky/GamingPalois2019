<?php
	
	$membreManager = new App\MembresManager();
	$arrReplace = [];
	
	if (isset($_SESSION['id'])) {
		$membre = $membreManager->readMembre($_SESSION['id']);
	}