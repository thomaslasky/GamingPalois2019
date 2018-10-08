<?php
	/**
	 * Created by PhpStorm.
	 * User: thoma
	 * Date: 20/06/2018
	 * Time: 15:38
	 */
	
	namespace App;
	
	
	class PartenairesgpManager extends Manager {
		public function __construct() {
			parent::__construct();
			$this->table = "partenairesgp";
		}
		
		public function addPartenaireGP(Partenairesgp &$partenairesgp) {
			$sql = "INSERT INTO {$this->table} (Nom,Description,Site,Urlimg) VALUES (:nom,:description,:site,:url)";
			$req = $this->db->prepare($sql);
			
			$req->bindValue('nom',$partenairesgp->getNom(),\PDO::PARAM_STR);
			$req->bindValue('description',$partenairesgp->getDescription(),\PDO::PARAM_STR);
			$req->bindValue('site',$partenairesgp->getSite(),\PDO::PARAM_STR);
			$req->bindValue('url',$partenairesgp->getUrlimg(),\PDO::PARAM_STR);
			
			$req->execute();
		}
		
		public function readPartenaireGp($id) {
			$sql = "SELECT * FROM {$this->table} WHERE IDpartenaire = {$id}";
			
			$req = $this->db->prepare($sql);
			
			$req->execute();
			
			$result = $req->fetch();
			
			return new Partenairesgp($result);
		}
		
		public function updatePartenaireGP(Partenairesgp &$partenairesgp,$id) {
			$sql = "UPDATE {$this->table} SET Nom = :nom, Description = :descr, Site = :site, Urlimg = :url WHERE IDpartenaire = :id";
			
			$req = $this->db->prepare($sql);
			
			$req->bindValue('nom',$partenairesgp->getNom(),\PDO::PARAM_STR);
			$req->bindValue('descr',$partenairesgp->getDescription(),\PDO::PARAM_STR);
			$req->bindValue('site',$partenairesgp->getSite(),\PDO::PARAM_STR);
			$req->bindValue('url',$partenairesgp->getUrlimg(),\PDO::PARAM_STR);
			$req->bindValue('id',$id,\PDO::PARAM_INT);
			
			$req->execute();
		}
		
		public function deletePartenaireGP($id) {
			$sql = "DELETE FROM {$this->table} WHERE IDpartenaire = :id";
			$req = $this->db->prepare($sql);
			
			$req->bindValue('id',$id,\PDO::PARAM_INT);
			
			$req->execute();
		}
		
		public function allPartenaireGP() {
			
			$allPartenaireGP = [];
			
			$sql = "SELECT * FROM {$this->table}";
			$req = $this->db->prepare($sql);
			
			$req->execute();
			
			$result = $req->fetchAll();
			
			foreach ($result as $value) {
				$allPartenaireGP[] = new Partenairesgp($value);
			}
			
			return $allPartenaireGP;
		}
		
		public function ficheAllPartenairesGP(Partenairesgp &$partenairesgp, $modeleHTML) {
			
			$arrReplace = ['{{nom}}' => $partenairesgp->getNom(),
				'{{urlimg}}' => $partenairesgp->getUrlimg(),
				'{{id}}' => $partenairesgp->getIdPartenaire(),
				'{{description}}' => $partenairesgp->getDescription(),
				'{{site}}' => $partenairesgp->getSite()
			];
			
			return strtr($modeleHTML, $arrReplace);
		}
	}