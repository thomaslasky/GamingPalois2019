<?php
	
	namespace App;
	
	class MembresManager extends Manager {
		
		public function __construct() {
			parent::__construct();
			$this->table = "membres";
		}
		
		public function inscription(Membres &$membres) {
			
			$sql = "INSERT INTO membres (Email, Password, Nom, Prenom, Age, Telephone, Adresse, Status) VALUES (:email,:password,:nom,:prenom,:age,:telephone,:adresse,:status)";
			$req = $this->db->prepare($sql);
			
			$req->bindValue('email', $membres->getEmail(), \PDO::PARAM_STR);
			$req->bindValue('password', $membres->getPassword(), \PDO::PARAM_STR);
			$req->bindValue('nom', $membres->getNom(), \PDO::PARAM_STR);
			$req->bindValue('prenom', $membres->getPrenom(), \PDO::PARAM_STR);
			$req->bindValue('age', $membres->getAge(), \PDO::PARAM_INT);
			$req->bindValue('telephone', $membres->getTelephone(), \PDO::PARAM_INT);
			$req->bindValue('adresse', $membres->getAdresse(), \PDO::PARAM_STR);
			$req->bindValue('status', $membres->getStatus(), \PDO::PARAM_STR);
			
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
			$req->bindValue('information', $information, \PDO::PARAM_STR);
			$req->execute();
		}
		
		public function connexion(Membres &$membre) {
			
			$csrf = new Csrf();
			
			$sql = "SELECT * FROM {$this->table} WHERE Email = :email";
			
			$results = $this->db->prepare($sql);
			
			$results->bindValue("email", $membre->getEmail(), \PDO::PARAM_STR);
			
			$results->execute();
			
			$info = $results->fetch();
			
			if (checkPassword($membre->getPassword(), $info['Password']) === TRUE) {
				
				$_SESSION['id'] = $info['IDmembre'];
				
				if (isset($_POST['Remember'])) {
					$token = bin2hex(random_bytes(25));
					setcookie("tokenuser", $token, time() + 3600 * 24 * 30);
					$this->addToken($token, $membre->getIDmembre());
				}
				
				echo json_encode(["text" => "Connexion réussie"]);
				
			} else {
				echo json_encode(["text"  => "Pseudo ou Password incorrect",
				                  "token" => $csrf->generateToken(),
				]);
			}
		}
		
		public function verifyMail($mail) {
			
			$sql = "SELECT Email FROM {$this->table} WHERE Email = :mail";
			
			$resultats = $this->db->prepare($sql);
			
			$resultats->bindValue("mail", $mail, \PDO::PARAM_STR);
			
			$resultats->execute();
			
			$info = $resultats->fetch();
			
			if (empty($info)) {
				return TRUE;
			} else {
				return FALSE;
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
				return TRUE;
			}
			return FALSE;
		}
		
		private function addToken($token, $id) {
			$sql = "UPDATE {$this->table} SET Token = :token WHERE IDmembre = :id";
			$req = $this->db->prepare($sql);
			
			$req->bindValue('token', $token, \PDO::PARAM_STR);
			$req->bindValue('id', $id, \PDO::PARAM_INT);
			
			$req->execute();
		}
		
		public function deleteToken($id) {
			$sql = "UPDATE {$this->table} SET Token = :token WHERE IDmembre = :id";
			
			$req = $this->db->prepare($sql);
			
			$req->bindValue('token', "", \PDO::PARAM_STR);
			$req->bindValue('id', $id, \PDO::PARAM_INT);
			
			$req->execute();
		}
		
	}