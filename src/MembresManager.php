<?php
	
	namespace App;
	
	class MembresManager extends Manager {
		
		public function __construct() {
			parent::__construct();
			$this->table = "membres";
		}
		
		public function inscription(Membres &$membres) {
			$sql = "INSERT INTO " . $this->table . "(Email,Password,Nom,Prenom,Age,Telephone,Adresse,Statut) VALUES (:mail,:password,:nom,:prenom,:age,:telephone,:adresse,:statut)";
			$req = $this->db->prepare($sql);
			
			$req->bindValue('mail', $membres->getEMail(), \PDO::PARAM_STR);
			$req->bindValue('password', $membres->getPassword(), \PDO::PARAM_STR);
			$req->bindValue('nom', $membres->getNom(), \PDO::PARAM_STR);
			$req->bindValue('prenom', $membres->getPrenom(), \PDO::PARAM_STR);
			$req->bindValue('age', $membres->getAge(), \PDO::PARAM_INT);
			$req->bindValue('telephone', $membres->getTelephone(), \PDO::PARAM_INT);
			$req->bindValue('adresse', $membres->getAdresse(), \PDO::PARAM_STR);
			$req->bindValue('statut', $membres->getStatut(), \PDO::PARAM_STR);
			
			$req->execute();
		}
		
		public function readMembre($id) {
			$sql = "SELECT * FROM " . $this->table . " WHERE IDmembre = :id";
			$req = $this->db->prepare($sql);
			$req->bindValue('id', $id, \PDO::PARAM_INT);
			$req->execute();
			$result = $req->fetch();
			
			return new Membres($result);
		}
		
		public function updateInformations($type, $information, $id) {
			$sql = "UPDATE $this->table SET $type = :information WHERE IDmembre = $id";
			$req = $this->db->prepare($sql);
			$req->bindValue('information',$information,\PDO::PARAM_STR);
			$req->execute();
	    }
		
		public function connexion(Membres &$membre) {
			$sql = "SELECT * FROM {$this->table} WHERE Email = :email";
			
			$results = $this->db->prepare($sql);
			
			$results->bindValue("email", $membre->getEmail(), \PDO::PARAM_STR);
			
			$results->execute();
			
			$info = $results->fetch();
			
			if (checkPassword($membre->getPassword(), $info['Password']) === true) {
				
				$_SESSION['id'] = $info['IDmembre'];
				
				if (array_key_exists("Remember", $_POST)) {
					$token = bin2hex(random_bytes(25));
					$this->addToken($token, $membre->getEmail());
					setcookie("Token", $token, time() + 3600 * 24 * 30);
				}
				header("location: Accueil.php");
				exit;
			} else {
				echo '<script>alert("Pseudo or Password incorrect")</script>';
			}
		}
	 
		public function verifyToken($token) {
			$sql = "SELECT * FROM {$this->table} WHERE Token = :token";
			
			$results = $this->db->prepare($sql);
			
			$results->bindValue('token', $token, \PDO::PARAM_STR);
			
			$results->execute();
			
			$info = $results->fetchAll(2);
			
			if (sizeof($info) === 1) {
				$_SESSION['id'] = $info[0]["IDmembre"];
				return true;
			}
			return false;
		}
	 
		private function addToken($token, $pseudo) {
			$sql = "UPDATE {$this->table} SET Token = :token WHERE Email = :email";
			$req = $this->db->prepare($sql);
			
			$req->bindValue('token', $token, \PDO::PARAM_STR);
			$req->bindValue('email', $pseudo, \PDO::PARAM_STR);
			
			$req->execute();
		}
	 
	}