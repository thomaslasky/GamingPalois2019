<?php
	
	function sendemail($mailto, $titreEvent, $contenuMail) {
		
		$mail = $mailto;
		
		//Filtrage des serveur pour les saut de ligne
		
		if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) {
			$passage_ligne = "\r\n";
		} else {
			$passage_ligne = "\n";
		}
		
		//Creation du message multiple format
		
		$message_txt = "coucou";
		$message_html = $contenuMail;
		
		//Déclaration du sujet
		
		$sujet = "Confirmation participation " . $titreEvent;
		
		//Déclaration du Header
		
		$header = "From: \"Gaming Palois\"<contact@gamingpalois.fr>" . $passage_ligne;
		$header .= "Reply-to: \"Exposants\"<$mailto>" . $passage_ligne;
		$header .= "MIME-Version: 1.0" . $passage_ligne;
		$header .= "Content-Type: multipart/aternative;" . $passage_ligne . $passage_ligne;
		
		//Création du message
		
		$message = $passage_ligne . "--" . $passage_ligne;
		
		//Ajout message au format HTML
		
		$message .= "Content-Type: text/html; charset=\"ISO-8859-1\"" . $passage_ligne;
		$message .= "Content-Transfer-Encoding: 8bit" . $passage_ligne;
		$message .= $passage_ligne . $message_html . $passage_ligne;
		
		//Ajout message format texte
		
		//$message .= "Content-Type: text/plain; charset=\"ISO-8859-1\"" . $passage_ligne;
		//$message .= "Content-Transfer-Encoding: 8bit" . $passage_ligne;
		//$message .= $passage_ligne . $message_txt . $passage_ligne;
		
		//fin
		
		$message .= $passage_ligne . "--" . $passage_ligne;
		$message .= $passage_ligne . "--" . $passage_ligne;
		
		//Envois du mail
		
		return mail($mail, $sujet, $message, $header);
	}