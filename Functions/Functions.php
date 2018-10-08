<?php
	
	global $db;
	
	try {
		$db = new \PDO('mysql:host=localhost;dbname=gamingpalois', 'root', '', array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
		//$db = new \PDO('mysql:host=gamingpaingaming.mysql.db;dbname=gamingpaingaming', 'gamingpaingaming', 'Atlantissg1', array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
	} catch (PDOException $e) {
		echo $e->getMessage();
		die();
	}
	
	function debug(...$vars) {
		foreach ($vars as $var) {
			echo '<pre>';
			var_dump($var);
			echo '</pre>';
		}
	}
	
	function connexion($mail, $password) {
		global $db;
		
		$sql = "SELECT * FROM membres WHERE Email = :mail";
		
		$resultats = $db->prepare($sql);
		
		$resultats->bindValue("mail", $mail, \PDO::PARAM_STR);
		
		$resultats->execute();
		
		$info = $resultats->fetch();
		
		if ($info['Password'] == $password) {
			$_SESSION['mail'] = $mail;
			$_SESSION['password'] = $password;
			$_SESSION['id'] = $info['IDmembre'];
			header('location: Evenements.php');
		} else if ($info['Password'] != $password) {
			echo '<h1>password ou pseudo incorrect</h1>';
		}
		
	}
	
	function verifyMail($mail) {
		global $db;
		
		$sql = "SELECT Email FROM membres WHERE Email = :mail";
		
		$resultats = $db->prepare($sql);
		
		$resultats->bindValue("mail", $mail, \PDO::PARAM_STR);
		
		$resultats->execute();
		
		$info = $resultats->fetch();
		
		if (empty($info)) {
			return true;
		} else {
			return false;
		}
	}
	
	function verifyInscription($idmembre, $idevent) {
		global $db;
		
		$sql = "SELECT IDmembre FROM participer WHERE IDmembre = :idmembre AND IDevenement = :idevent";
		
		$req = $db->prepare($sql);
		$req->bindValue("idmembre", $idmembre, \PDO::PARAM_INT);
		$req->bindValue("idevent", $idevent, \PDO::PARAM_INT);
		
		$req->execute();
		
		$info = $req->fetch();
		
		if (empty($info)) {
			return true;
		} else {
			return false;
		}
	}