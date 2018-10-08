<?php
	
	namespace App;
	
	class EvenementManager extends Manager {
		
		public function __construct() {
			parent::__construct();
			$this->table = "evenements";
		}
		
		public function readAllEvent() {
			
			$allEvents = [];
			
			$sql = "SELECT * FROM " . $this->table . " ORDER BY Dates ASC LIMIT 5";
			$req = $this->db->prepare($sql);
			$req->execute();
			$result = $req->fetchAll();
			foreach ($result as $value) {
				$allEvents[] = new Evenement($value);
			}
			return $allEvents;
		}
		
		public function readAllEventWhere($condition) {
			$event = [];
			
			$sql = "SELECT * FROM " . $this->table . " WHERE Type = :type";
			$req = $this->db->prepare($sql);
			$req->bindValue('type', $condition, \PDO::PARAM_STR);
			$req->execute();
			$result = $req->fetchAll();
			if (!empty($result)) {
				foreach ($result as $value) {
					if ($value['Dates'] >= date("Y-d-m")) {
						$event[] = new Evenement($value);
					}
				}
				return $event;
			}
		}
		
		public function readEventByID($id) {
			$sql = "SELECT * FROM " . $this->table . " WHERE IDevenement = :id";
			$req = $this->db->prepare($sql);
			$req->bindValue('id', $id, \PDO::PARAM_INT);
			$req->execute();
			$result = $req->fetch();
			return new Evenement($result);
		}
		
		public function countParticipants($id) {
			$sql = "SELECT SUM(Emplacement) AS Total FROM participer WHERE IDevenement = :id";
			$req = $this->db->prepare($sql);
			$req->bindValue('id', $id, \PDO::PARAM_INT);
			$req->execute();
			$result = $req->fetch();
			return $result['Total'];
		}
		
		public function addEvent(Evenement &$event) {
			$sql = "INSERT INTO {$this->table} (Nom,Dates,Adresse,Place,Type,Urlimg,Description) VALUES (:nom,:dates,:adresse,:place,:type,:url,:description)";
			$req = $this->db->prepare($sql);
			
			$req->bindValue('nom', $event->getNom(), \PDO::PARAM_STR);
			$req->bindValue('dates', $event->getDates(), \PDO::PARAM_STR);
			$req->bindValue('adresse', $event->getAdresse(), \PDO::PARAM_STR);
			$req->bindValue('place', $event->getPlace(), \PDO::PARAM_INT);
			$req->bindValue('url', $event->getUrlimg(), \PDO::PARAM_STR);
			$req->bindValue('description', $event->getDescription(), \PDO::PARAM_STR);
			$req->bindValue('type', $event->getType(), \PDO::PARAM_STR);
			
			$req->execute();
		}
		
		public function deleteEvent($id) {
			$sql = "DELETE FROM {$this->table} WHERE IDevenement = :id";
			$req = $this->db->prepare($sql);
			
			$req->bindValue('id', $id, \PDO::PARAM_INT);
			
			$req->execute();
		}
		
		public function updateEvent($type, $id, $value) {
			$sql = "UPDATE $this->table SET $type = :information WHERE IDevenement = $id";
			$req = $this->db->prepare($sql);
			$req->bindValue('information', $value, \PDO::PARAM_STR);
			$req->execute();
		}
		
		public function ficheEvent(Evenement &$event, $modelHTML) {
			
			$id = $event->getIdevenement();
			$nom = $event->getNom();
			$dates = $event->getDates();
			$adresses = $event->getAdresse();
			$typePlace = $event->getType();
			$placePrise = $this->countParticipants($id);
			$place = $event->getPlace();
			
			if (empty($placePrise)) {
				$placePrise = 0;
			}
			
			$arrReplace = [
				'{{nomevent}}' => $nom,
				'{{dateevents}}' => $dates,
				'{{adresse}}' => $adresses,
				'{{placetotal}}' => $place,
				'{{typeplace}}' => $typePlace,
				'{{idevent}}' => $id,
				'{{placeprise}}' => $placePrise
			];
			
			return strtr($modelHTML, $arrReplace);
		}
		
		public function ficheAllEvents(Evenement &$event, $modeleHTML) {
			
			$nom = $event->getNom();
			$url = $event->getUrlimg();
			$id = $event->getIdEvenement();
			
			$arrReplace = ['{{nom}}' => $nom,
				'{{url}}' => $url,
				'{{id}}' => $id];
			
			return strtr($modeleHTML, $arrReplace);
		}
		
		public function ficheAllEventsgestion(Evenement &$event, $modeleHTML) {
			$arrReplace = ['{{url}}' => $event->getUrlimg(),
				'{{name}}' => $event->getNom(),
				'{{date}}' => $event->getDates(),
				'{{description}}' => $event->getDescription(),
				'{{place}}' => $event->getPlace(),
				'{{type}}' => $event->getType(),
				'{{id}}' => $event->getIdEvenement()];
			
			return strtr($modeleHTML, $arrReplace);
		}
	}
