<?php
	
	session_start();
	require_once 'vendor/autoload.php';
	include 'Functions/Fileget.php';
	include_once 'Functions/verificationconnexion.php';
	include 'Functions/Functions.php';
	
	$eventManager = new App\EvenementManager();
	
	$event = [];
	
	$videGrenier = '';
	$LAN = '';
	$allEvents = '';
	
	$eventVideGrenier = $eventManager->readAllEventWhere('Vide Grenier');
	$eventLAN = $eventManager->readAllEventWhere('LAN');
	$eventsAll = $eventManager->readAllEvent();
	
	$modeleHTML = file_get_contents('Template/evenements.html');
	$modeleHTMLAllEvent = file_get_contents('Template/allevents.html');
	
	//Gestion Vide Grenier
	
	if (!empty($eventVideGrenier)) {
		foreach($eventVideGrenier as $value) {
			$videGrenier .= $eventManager->ficheEvent($value, $modeleHTML);
		}
	} else {
		$videGrenier = 'Aucun Vide Grenier Prévu';
	}
	
	//Gestion LAN
	
	if (!empty($eventLAN)) {
		foreach($eventLAN as $value) {
			$LAN .= $eventManager->ficheEvent($value, $modeleHTML);
		}
	} else {
		$LAN = 'Aucune Lan Prévu';
	}
	
	if (!empty($eventsAll)) {
		foreach($eventsAll as $value) {
			$allEvents .= $eventManager->ficheAllEvents($value, $modeleHTMLAllEvent);
		}
	} else {
		$allEvents = "Aucun Event";
	}

?>

<!DOCTYPE html>

<html>
	<head>
		<meta charset = "UTF-8">
		<meta name = "viewport" content = "width=device-width, initial-scale=1">
		
		<title>Accueil</title>
		
		<link rel = "stylesheet" href = "CSS/FrameWork.css">
		<link rel = "stylesheet" href = "CSS/StyleGeneral.css">
		<link rel = "stylesheet" href = "CSS/StyleNavigateur.css">
		<link rel = "stylesheet" href = "CSS/StyleUserLogs.css">
		<link rel = "stylesheet" href = "CSS/StylePage.css">
		
		<link rel = "stylesheet" href = "node_modules/materialize-css/dist/css/materialize.min.css">
		<script src = "node_modules/materialize-css/dist/js/materialize.min.js"></script>
		
		<script src = "node_modules/jquery/dist/jquery.min.js"></script>
		
		<script src = "node_modules/jquery.nicescroll/dist/jquery.nicescroll.min.js"></script>
		
		<script type = "text/javascript" src = "Ajax/oXHR.js"></script>
		<script type = "text/javascript" src = "Ajax/Ajax.js"></script>
		<script type = "text/javascript" src = "JS/Functions.js"></script>
		
		<link rel = "shortcut icon" type = "image/png" href = "Img/Logo/logoGP.png" />
	</head>
	<body>
		<section class = "row page_container">
			<?= $navigateur ?>
			<div id = "output" class = "col s12 m12 l9 xl10 float_right">
				<div id = 'container_events' class = 'page_content col s12 m12 l11 xl10 margin-auto'
				     style = 'height: auto;'>
					<div class = "container_type_event">
						<div class = 'block_event'>
							<h1>Vide Grenier</h1>
							<?php echo $videGrenier ?>
						</div>
						<div class = 'block_event'>
							<h1>LAN</h1>
							<?php echo $LAN ?>
						</div>
					</div>
					<div class = "container_allevents container_events_list">
						<h1 class = "center-align blue-text darken-2 no-margin">All Events
							<hr class = "no-margin">
						</h1>
						<div class = "container_allevents_list">
							<?php echo $allEvents ?>
						</div>
					</div>
				</div>
			</div>
			
			<div id = 'myModal-page' class = 'modal_css_event'>
				<div id = "modal" class = 'modal-content col s10 m8 l6 xl6 margin-auto'>
				</div>
			</div>
		</section>
	</body>
</html>

<script>
	$(document).ready(function () {
		$("#output").niceScroll({
			cursorcolor: "#713B75",
			cursorwidth: "8px",
		});
		
		$(".block_event").niceScroll({
			cursorcolor: "#713B75",
			cursorwidth: "8px",
		});
	});
</script>