<?php
	
	namespace App;
	
	class EvenementManager extends Manager {
		
		public function __construct() {
			parent::__construct();
			//Définition de la table
			$this->table = "evenements";
		}
		
		//Récupération de tout les évènements créé
		
		public function readAllEvent() {
			
			$allEvents = [];
			
			$sql = "SELECT * FROM " . $this->table . " ORDER BY Dates ASC LIMIT 5";
			$req = $this->db->prepare($sql);
			$req->execute();
			$result = $req->fetchAll();
			foreach($result as $value) {
				$allEvents[] = new Evenement($value);
			}
			return $allEvents;
		}
		
		//Récupération de tout les évènement d'un type précis
		
		public function readAllEventWhere($condition) {
			$event = [];
			
			$sql = "SELECT * FROM " . $this->table . " WHERE Type = :type";
			$req = $this->db->prepare($sql);
			$req->bindValue('type', $condition, \PDO::PARAM_STR);
			$req->execute();
			$result = $req->fetchAll();
			if (!empty($result)) {
				foreach($result as $value) {
					if ($value['Dates'] <= date("Y-d-m")) {
						$event[] = new Evenement($value);
					}
				}
				return $event;
			}
		}
		
		//Récupération d'un évènement par son ID
		
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
		
		//Ajout d'un évènement en base
		
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
		
		//Supprimer un évènement par son ID
		
		public function deleteEvent($id) {
			$sql = "DELETE FROM {$this->table} WHERE IDevenement = :id";
			$req = $this->db->prepare($sql);
			
			$req->bindValue('id', $id, \PDO::PARAM_INT);
			
			$req->execute();
		}
		
		//Update d'une donnée d'évènement par sont type,
		
		public function updateEvent($type, $id, $value) {
			$sql = "UPDATE {$this->table} SET $type = :information WHERE IDevenement = {$id}";
			$req = $this->db->prepare($sql);
			$req->bindValue('information', $value, \PDO::PARAM_STR);
			$req->execute();
		}
		
		//Affichage des évènements
		
		public function ficheEvent(Evenement &$event, $modelHTML, $idUser) {
			
			setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');
			
			$participerManager = new ParticiperManager();
			
			$action = "";
			
			$idEvent = $event->getIdevenement();
			$nom = $event->getNom();
			$dates = $date = strftime('%A  %d  %B  %Y', strtotime($event->getDates()));;
			$adresses = $event->getAdresse();
			$typePlace = $event->getType();
			$placePrise = $this->countParticipants($idEvent);
			$placeTotal = $event->getPlace();
			$urlImg = $event->getUrlimg() ?: "Default.png";
			$description = $event->getDescription();
			$prix = $event->getPrix();
			$placeDisponible = $placeTotal - $placePrise;
			
			$verifyRegister = $participerManager->verifyInscription($idUser, $idEvent);
			
			if (!empty($idUser)) {
				if ($placeDisponible < 0 && $verifyRegister === TRUE) {
					$action = "<span class='cursor-pointer center-align black-text darken-4'>Inscriptions Complète</span>";
				} elseif ($verifyRegister === FALSE) {
					if ($event->getType() === "Vide Grenier") {
						$action = "<span class='cursor-pointer bouton_inscription' onclick='requestFormVideGrenier(readDataForm,\"InscriptionEvent\",{$idEvent})'>Inscription</span>";
					} else {
						$action = "<span class='cursor-pointer bouton_inscription' onclick='requestSendLAN(readDataSendLAN,{$idEvent})'>Inscription</span>";
					}
				} elseif ($verifyRegister === TRUE) {
					$action = "<span class='cursor-pointer bouton_inscription' onclick='requestSendDesinscription(readDataSendDesinscriptionEvent,{$idEvent})'>Desinscription</span>";
				}
			} else {
				$action = "<p><span class='cursor-pointer blue-text darken-2' onclick='requestForm(readDataForm,\"Login\")'>Connectez vous</span> pour vous inscrire</p>";
			}
			
			$arrReplace = [
				'{{id}}'              => $idEvent,
				'{{nomevent}}'        => $nom,
				'{{description}}'     => $description,
				'{{dateevents}}'      => $dates,
				'{{adresse}}'         => $adresses,
				'{{placedisponible}}' => $placeDisponible,
				'{{typeplace}}'       => $typePlace,
				'{{idevent}}'         => $idEvent,
				'{{urlimg}}'          => $urlImg,
				'{{action}}'          => $action,
				'{{prix}}'            => $prix . "€",
			];
			
			return strtr($modelHTML, $arrReplace);
		}
		
		//Affichage de tout les évènements
		
		public function ficheAllEvents(Evenement &$event, $modeleHTML) {
			
			$nom = $event->getNom();
			$url = $event->getUrlimg();
			$id = $event->getIdEvenement();
			
			if (!file_exists("../Img/Events/" . $url)) {
				$url = "Default.png";
			}
			
			$arrReplace = [
				'{{nom}}' => $nom,
				'{{url}}' => $url,
				'{{id}}'  => $id,
			];
			
			return strtr($modeleHTML, $arrReplace);
		}
		
		//[Administrateur] Affiche de la gestion d'évènement
		
		public function ficheAllEventsgestion(Evenement &$event, $modeleHTML) {
			$arrReplace = [
				'{{url}}'         => $event->getUrlimg(),
				'{{name}}'        => $event->getNom(),
				'{{date}}'        => $event->getDates(),
				'{{description}}' => $event->getDescription(),
				'{{place}}'       => $event->getPlace(),
				'{{type}}'        => $event->getType(),
				'{{id}}'          => $event->getIdEvenement(),
			];
			return strtr($modeleHTML, $arrReplace);
		}
	}
