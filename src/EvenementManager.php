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
			
			$sql = "SELECT * FROM " . $this->table . " ORDER BY Dates DESC LIMIT 5";
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
			
			$sql = "SELECT * FROM evenements WHERE Type = :type";
			$req = $this->db->prepare($sql);
			$req->bindValue('type', $condition, \PDO::PARAM_STR);
			$req->execute();
			$result = $req->fetchAll();
			if (!empty($result)) {
				foreach($result as $value) {
					if ($value['Dates'] > date("Y-m-d")) {
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
			$sql = "INSERT INTO evenements (Nom, Description, Dates, Adresse, Place, Prix, Type, Urlimg) VALUES (:nom,:description,:dates,:adresse,:place,:prix,:type,:url)";
			$req = $this->db->prepare($sql);
			
			$req->bindValue('nom', $event->getNom(), \PDO::PARAM_STR);
			$req->bindValue('dates', $event->getDates(), \PDO::PARAM_STR);
			$req->bindValue('adresse', $event->getAdresse(), \PDO::PARAM_STR);
			$req->bindValue('place', $event->getPlace(), \PDO::PARAM_INT);
			$req->bindValue('url', $event->getUrlimg(), \PDO::PARAM_STR);
			$req->bindValue('description', $event->getDescription(), \PDO::PARAM_STR);
			$req->bindValue('type', $event->getType(), \PDO::PARAM_STR);
			$req->bindValue('prix', $event->getPrix(), \PDO::PARAM_INT);
			
			$req->execute();
		}
		
		//Supprimer un évènement par son ID
		
		public function deleteEvent($id) {
			$partenaireManager = new PartenairesManager();
			
			$partenaireManager->deleteAllPartenaire($id);
			
			$sql = "DELETE FROM {$this->table} WHERE IDevenement = :id";
			$req = $this->db->prepare($sql);
			
			$req->bindValue('id', $id, \PDO::PARAM_INT);
			
			$req->execute();
		}
		
		//Update d'une donnée d'évènement par sont type,
		
		public function updateEvent(Evenement &$evenement) {
			$sql = "UPDATE {$this->table} SET Nom = :nom , Dates = :date , Adresse = :adresse , Place = :place , Prix = :prix, Description = :descr  WHERE IDevenement = :id";
			$req = $this->db->prepare($sql);
			
			$req->bindValue("nom", $evenement->getNom(), \PDO::PARAM_STR);
			$req->bindValue("date", $evenement->getDates(), \PDO::PARAM_STR);
			$req->bindValue("adresse", $evenement->getAdresse(), \PDO::PARAM_STR);
			$req->bindValue("place", $evenement->getPlace(), \PDO::PARAM_INT);
			$req->bindValue("prix", $evenement->getPrix(), \PDO::PARAM_INT);
			$req->bindValue("descr", $evenement->getDescription(), \PDO::PARAM_STR);
			$req->bindValue("id", $evenement->getIdEvenement(), \PDO::PARAM_INT);
			
			$req->execute();
		}
		
		//Update image event
		
		public function updateImgEvent(Evenement $evenement) {
			$sql = "UPDATE {$this->table} SET Urlimg = :url  WHERE IDevenement = :id";
			$req = $this->db->prepare($sql);
			
			$req->bindValue("url", $evenement->getUrlimg(), \PDO::PARAM_STR);
			$req->bindValue("id", $evenement->getIdEvenement(), \PDO::PARAM_INT);
			
			$req->execute();
		}
		
		//Affichage des évènements
		
		public function ficheEvent(Evenement &$event, $modelHTML, $idUser, $modelHTMLpartenaire = "") {
			
			setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');
			
			$participerManager = new ParticiperManager();
			$partenaireManager = new PartenairesManager();
			
			$action = "";
			$partenaires = "";
			
			$idEvent = $event->getIdevenement();
			$nom = $event->getNom();
			$dates = new \DateTime($event->getDates());
			$date = strftime('%A  %d  %B  %Y', strtotime($event->getDates()));
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
				if ($placeDisponible <= 0) {
					$action = "<span class='center-align black-text darken-4'>Inscriptions Complète</span>";
				} elseif ($verifyRegister === FALSE) {
					if (date("Y-m-d") < $dates) {
						if ($event->getType() === "Vide Grenier") {
							$action = "<span id='loader-register-{$idEvent}' class='cursor-pointer bouton_inscription' onclick='requestFormEvent(readDataForm,\"InscriptionEvent\",{$idEvent}),initLoader(\"register\",{$idEvent})'>Inscription</span>";
						} else {
							$action = "<span id='loader-register-{$idEvent}' class='cursor-pointer bouton_inscription' onclick='requestSendLAN(readDataSendLAN,{$idEvent}), initLoader(\"register\",{$idEvent})'>Inscription</span>";
						}
					} else {
						$action = "<span class='bouton_inscription'>Inscription Fermé</span>";
					}
				} elseif ($verifyRegister === TRUE) {
					$action = "<span id='loader-register-{$idEvent}' class='cursor-pointer bouton_inscription' onclick='requestSendDesinscription(readDataSendDesinscriptionEvent,{$idEvent}), initLoader(\"register\",{$idEvent})'>Desinscription</span>";
				}
			} else {
				$action = "<p><span class='cursor-pointer blue-text darken-2' onclick='requestForm(readDataForm,\"Login\")'>Connectez vous</span> pour vous inscrire</p>";
			}
			
			$allPartenaire = $partenaireManager->readPartenairesByEvent($event->getIdEvenement());
			
			if (!empty($allPartenaire)) {
				foreach($allPartenaire as $value) {
					$partenaires .= $partenaireManager->fichePartenaire($value, $modelHTMLpartenaire);
				}
			} else {
				$partenaires = "<p>Aucun partenaire</p>";
			}
			
			$arrReplace = [
				'{{id}}'              => $idEvent,
				'{{nomevent}}'        => $nom,
				'{{description}}'     => $description,
				'{{dateevents}}'      => $date,
				'{{adresse}}'         => $adresses,
				'{{placedisponible}}' => $placeDisponible,
				'{{typeplace}}'       => $typePlace,
				'{{idevent}}'         => $idEvent,
				'{{urlimg}}'          => $urlImg,
				'{{action}}'          => $action,
				'{{prix}}'            => $prix . "€",
				'{{partenaire}}'      => $partenaires,
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
		
	}
