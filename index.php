<?php
	
	session_start();
	require_once 'vendor/autoload.php';
	include 'Functions/functions.php';
	include 'Functions/verificationconnexion.php';


?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Accueil</title>
        
	    <link rel="stylesheet" href="CSS/FrameWork.css">
	    <link rel="stylesheet" href="CSS/StyleGeneral.css">
	    <link rel="stylesheet" href="CSS/StyleNavigateur.css">
	    <link rel="stylesheet" href="CSS/StyleUserLogs.css">
	    
	    <link rel="stylesheet" href="materialize/css/materialize.min.css">
        <script src="materialize/js/materialize.min.js"></script>
	
	    <script src="node_modules/jquery/dist/jquery.min.js"></script>
	    <script src="node_modules/jquery.nicescroll/dist/jquery.nicescroll.min.js"></script>
	    
	    <script type="text/javascript" src="Ajax/oXHR.js"></script>
        <script type="text/javascript" src="Ajax/Ajax.js"></script>
        <script type="text/javascript" src="JS/Functions.js"></script>
        
        <link rel="shortcut icon" type="image/png" href="Img/Logo/logoGP.png" />
    </head>
    <body>
        <section class="row">
	        <?= $navigateur ?>
	        <div id="output" class="col s12 m12 l9 xl10 float_right">
		        
                <div class=''>
	                <div class = "">
		                <div class = "">
			                <h1 class = "">Vide Grenier
				                <hr class = "no-margin">
			                </h1>
			                <?php echo $videGrenier ?>
		                </div>
		                <div class = "">
			                <h1 class = "">LAN
				                <hr class = "no-margin">
			                </h1>
			                <?php echo $LAN ?>
		                </div>
	                </div>
	                <div class = "">
		                <h1 class = "">All Events
			                <hr class = "">
		                </h1>
		                <div class = "">
			                <?php echo $allEvents ?>
		                </div>
	                </div>
                </div>
            </div>
	        
	        <div id='myModal-page' class='modal_css_event'>
		        <div id="modal" class='modal-content col s10 m8 l6 xl6 margin-auto'>
          
		        </div>
	        </div>
        </section>
    </body>
</html>
