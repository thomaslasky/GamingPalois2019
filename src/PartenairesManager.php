<?php
	
	namespace App;
	
	/**
	 * Created by PhpStorm.
	 * User: thoma
	 * Date: 15/05/2018
	 * Time: 16:33
	 */
	class PartenairesManager extends Manager {
		
		public function __construct() {
			parent::__construct();
			$this->table = "partenaires";
		}
		
		public function readPartenairesByEvent($idEvent) {
			$sql = "SELECT * FROM " . $this->table . " WHERE IDevenement = :id";
			$req = $this->db->prepare($sql);
			$req->bindValue('id', $idEvent, \PDO::PARAM_INT);
			$req->execute();
			$result = $req->fetchAll();
			
			if (!empty($result)) {
				foreach($result as $value) {
					$partenaire[] = new Partenaires($value);
				}
				return $partenaire;
			}
		}
		
		public function readPartenaire($idPartenaire) {
			$sql = "SELECT * FROM " . $this->table . " WHERE IDpartenaire = :id";
			$req = $this->db->prepare($sql);
			$req->bindValue('id', $idPartenaire, \PDO::PARAM_INT);
			$req->execute();
			$result = $req->fetch();
			
			return new Partenaires($result);
		}
		
		public function addPartenaire(Partenaires &$partenaires) {
			$sql = "INSERT INTO {$this->table} (Nom,Description,Site,Urlimg,IDevenement) VALUES (:nom,:description,:site,:url,:id)";
			$req = $this->db->prepare($sql);
			
			$req->bindValue('nom', $partenaires->getNom(), \PDO::PARAM_STR);
			$req->bindValue('description', $partenaires->getDescription(), \PDO::PARAM_STR);
			$req->bindValue('site', $partenaires->getSite(), \PDO::PARAM_STR);
			$req->bindValue('url', $partenaires->getUrlimg(), \PDO::PARAM_STR);
			$req->bindValue('id', $partenaires->getIdEvenement(), \PDO::PARAM_STR);
			
			$req->execute();
		}
		
		public function updatePartenaire(Partenaires &$partenaires) {
			$sql = "UPDATE {$this->table} SET Nom = :nom, Description = :descr, Site = :site WHERE IDpartenaire = :id";
			
			$req = $this->db->prepare($sql);
			
			$req->bindValue('nom', $partenaires->getNom(), \PDO::PARAM_STR);
			$req->bindValue('descr', $partenaires->getDescription(), \PDO::PARAM_STR);
			$req->bindValue('site', $partenaires->getSite(), \PDO::PARAM_STR);
			$req->bindValue('id', $partenaires->getIdPartenaire(), \PDO::PARAM_INT);
			
			$req->execute();
		}
		
		public function updateImgPartenaire(Partenaires &$partenaires) {
			$sql = "UPDATE {$this->table} SET Urlimg = :url WHERE IDpartenaire = :id";
			
			$req = $this->db->prepare($sql);
			
			$req->bindValue('url', $partenaires->getUrlimg(), \PDO::PARAM_STR);
			$req->bindValue('id', $partenaires->getIdPartenaire(), \PDO::PARAM_INT);
			
			$req->execute();
		}
		
		public function deletePartenaire($idPartenaire) {
			
			$sql = "DELETE FROM {$this->table} WHERE IDpartenaire = :id";
			$req = $this->db->prepare($sql);
			
			$req->bindValue('id', $idPartenaire, \PDO::PARAM_INT);
			
			$req->execute();
		}
		
		public function deleteAllPartenaire($idEvent) {
			$sql = "DELETE FROM {$this->table} WHERE IDevenement = :id";
			$req = $this->db->prepare($sql);
			
			$req->bindValue('id', $idEvent, \PDO::PARAM_INT);
			
			$req->execute();
		}
		
		public function fichePartenaire(Partenaires &$partenaires, $modelePartenaire) {
			
			$nom = $partenaires->getNom();
			$description = $partenaires->getDescription();
			$site = $partenaires->getSite();
			$url = $partenaires->getUrlimg();
			$id = $partenaires->getIdPartenaire();
			
			$arrReplace = [
				'{{nompartenaire}}'         => htmlspecialchars($nom),
				'{{descriptionpartenaire}}' => $description,
				'{{site}}'                  => htmlspecialchars($site),
				'{{url}}'                   => htmlspecialchars($url),
				'{{id}}'                    => htmlspecialchars($id),
			];
			
			return strtr($modelePartenaire, $arrReplace);
		}
	}