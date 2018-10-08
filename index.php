<?php
	
	session_start();
	require_once 'vendor/autoload.php';
	include 'Functions/Functions.php';
	
	if (isset($_SESSION["id"])) {
		header("location: Accueil.php");
	}

?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Gaming Palois</title>
	    
	    <link rel="stylesheet" href="CSS/StyleUserLogs.css">
	    <link rel="stylesheet" href="CSS/FrameWork.css">
	    <link rel="stylesheet" href="CSS/StyleGeneral.css">
	    
	    <link rel="stylesheet" href="materialize/css/materialize.min.css">
        <script src="materialize/js/materialize.min.js"></script>
	    
	    <script type="text/javascript" src="Ajax/oXHR.js"></script>
        <script type="text/javascript" src="Ajax/Ajax.js"></script>
        <script type="text/javascript" src="JS/Functions.js"></script>
	    
        
        <link rel="shortcut icon" type="image/png" href="Img/Logo/logoGP.png" />
    </head>
    <body>
	    <section class="container_user_log valign-wrapper">
            <div class="margin-auto container_log">
                    <a href="index.php">
	                    <img class="responsive-img" src="Img/Logo/logoGP.png">
                    </a>
	            <div class="container_choice_user">
	                <p id="categorie-log-1" class="cursor-pointer categorie" onclick="selectedCategorie('log',1) ; requestFormUser(readDataFormUser,'Login')">Login</p>
	                <p id="categorie-log-2" class="cursor-pointer categorie"
	                   onclick="selectedCategorie('log',2) ; requestFormUser(readDataFormUser,'Inscription')">Inscription</p>
	            </div>
	            <div id="index_form">
		           
	            </div>
        </section>
    </body>
</html>