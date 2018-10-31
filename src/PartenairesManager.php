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
		
		public function readPartenaires($idEvent) {
			$sql = "SELECT * FROM " . $this->table . " WHERE IDevenement = :id";
			$req = $this->db->prepare($sql);
			$req->bindValue('id', $idEvent, \PDO::PARAM_INT);
			$req->execute();
			$result = $req->fetchAll();
			
			if (!empty($result)) {
				foreach ($result as $value) {
					$partenaire[] = new Partenaires($value);
				}
				return $partenaire;
			}
		}
		
		public function addPartenaire(Partenaires &$partenaires) {
			$sql = "INSERT INTO {$this->table} (Nom,Description,Site,Urlimg,IDevenement) VALUES (:nom,:description,:site,:url,:id)";
			$req = $this->db->prepare($sql);
			
			$req->bindValue('nom',$partenaires->getNom(),\PDO::PARAM_STR);
			$req->bindValue('description',$partenaires->getDescription(),\PDO::PARAM_STR);
			$req->bindValue('site',$partenaires->getSite(),\PDO::PARAM_STR);
			$req->bindValue('url',$partenaires->getUrlimg(),\PDO::PARAM_STR);
			$req->bindValue('id',$partenaires->getIdEvenement(),\PDO::PARAM_STR);
			
			$req->execute();
		}
		
		public function deletePartenaire($idEvent) {
			
			$partenaires = $this->readPartenaires($idEvent);
			
			if (!empty($partenaires)) {
				foreach ($partenaires as $value) {
					$url = $value['Urlimg'];
					unlink("../Img/Partenaires/Event/{$url}");
				}
			}
			
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
			
			$arrReplace = ['{{nom}}' => htmlspecialchars($nom),
				'{{description}}' => htmlspecialchars($description),
				'{{lien}}' => htmlspecialchars($site),
				'{{url}}' => htmlspecialchars($url)];
			
			return strtr($modelePartenaire, $arrReplace);
		}
	}