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
	}