<?php
	
	namespace App;
	
	class ParticiperManager extends Manager {
		
		public function __construct() {
			parent::__construct();
			$this->table = "participer";
		}
		
		public function inscription(Participer &$participer) {
			$sql = "INSERT INTO `participer` (Paiement, Vend, Emplacement, IDmembre, IDevenement) VALUES (0, :vend, :emp, :idmembre, :idevent);";
			$req = $this->db->prepare($sql);
			
			$req->bindValue('vend', $participer->getVend(), \PDO::PARAM_STR);
			$req->bindValue('emp', $participer->getEmplacement(), \PDO::PARAM_INT);
			$req->bindValue('idmembre', $participer->getIDmembre(), \PDO::PARAM_INT);
			$req->bindValue('idevent', $participer->getIDevenement(), \PDO::PARAM_INT);
			
			$req->execute();
		}
		
		public function desinscriptionEvent($idmembre, $idevent) {
			$sql = "DELETE FROM " . $this->table . " WHERE IDmembre = :idmembre AND IDevenement = :idevent";
			
			$req = $this->db->prepare($sql);
			$req->bindValue("idmembre", $idmembre, \PDO::PARAM_INT);
			$req->bindValue("idevent", $idevent, \PDO::PARAM_INT);
			
			$req->execute();
		}
		
		public function validatePayement($idEvent, $idUser) {
			
			$sql = "UPDATE participer SET Paiement = 1 WHERE IDmembre = {$idUser} AND IDevenement = {$idEvent}";
			$req = $this->db->prepare($sql);
			$req->execute();
			
		}
		
		public function listeParticipants(Evenement &$event, $modeleHTMLstructure, $modeleHTMLinfo) {
			
			$participantsListe = "";
			
			$idEvent = $event->getIdEvenement();
			
			$participantsTotal = $this->sumParticipants($event->getIdEvenement());
			$allParticipants = $this->selectParticipants($event->getIdEvenement());
			
			if (!empty($allParticipants)) {
				foreach($allParticipants as $value) {
					$participantsListe .= $this->listeAllParticipantsInfo($value, $modeleHTMLinfo, $idEvent);
				}
			}
			
			$arrReplace = [
				'{{nom}}'                 => $event->getNom(),
				'{{date}}'                => $event->getDates(),
				'{{id}}'                  => $event->getIdEvenement(),
				'{{totalparticipants}}'   => $participantsTotal,
				'{{foreachparticipants}}' => $participantsListe,
			];
			
			return strtr($modeleHTMLstructure, $arrReplace);
		}
		
		public function deleteAllParticipants($id) {
			$sql = "DELETE FROM {$this->table} WHERE IDevenement = :id";
			$req = $this->db->prepare($sql);
			
			$req->bindValue('id', $id, \PDO::PARAM_INT);
			
			$req->execute();
		}
		
		private function listeAllParticipantsInfo(Participer &$participer, $modeleHTMLinfo, $idEvent) {
			$membreManager = new MembresManager();
			
			$class = "";
			$action = "";
			
			$infoMembre = $membreManager->readMembre($participer->getIDmembre());
			
			if ($participer->getPaiement() === "0") {
				$class = "red darken-3";
				//$action = "<a href='?suppr={$participer->getIDmembre()}&event={$idEvent}'>Supprimer</a><br><a href='?valider={$participer->getIDmembre()}&event={$idEvent}'>Valider</a>";
			} elseif ($participer->getPaiement() === "1") {
				$class = "green darken-2";
				$action = "";
			}
			
			$arrReplace = [
				'{{class}}'       => $class,
				'{{nomprenom}}'   => $infoMembre->getNom() . " " . $infoMembre->getPrenom(),
				'{{mail}}'        => $infoMembre->getEmail(),
				'{{emplacement}}' => $participer->getEmplacement(),
				'{{action}}'      => $action,
			];
			
			return strtr($modeleHTMLinfo, $arrReplace);
		}
		
		private function selectParticipants($id) {
			$sql = "SELECT * FROM " . $this->table . " WHERE IDevenement = :id";
			$req = $this->db->prepare($sql);
			$req->bindValue('id', $id, \PDO::PARAM_INT);
			$req->execute();
			$result = $req->fetchAll();
			
			if (!empty($result)) {
				foreach($result as $value) {
					$participants[] = new Participer($value);
				}
				return $participants;
			}
		}
		
		private function sumParticipants($id) {
			$sql = "SELECT SUM(Emplacement) AS Total FROM {$this->table} WHERE IDevenement = :id";
			$req = $this->db->prepare($sql);
			$req->bindValue('id', $id, \PDO::PARAM_INT);
			$req->execute();
			$result = $req->fetch();
			return $result['Total'];
		}
		
		public function verifyInscription($idmembre, $idevent) {
			
			$sql = "SELECT * FROM participer WHERE IDmembre = :idmembre AND IDevenement = :idevent";
			
			$req = $this->db->prepare($sql);
			
			$req->bindValue("idmembre", $idmembre, \PDO::PARAM_INT);
			$req->bindValue("idevent", $idevent, \PDO::PARAM_INT);
			
			$req->execute();
			
			$info = $req->fetch();
			
			if (!empty($info)) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}