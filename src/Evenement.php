<?php
	
	namespace App;
	
	class Evenement extends Entity {
		
		private $idEvenement;
		private $nom;
		private $dates;
		private $adresse;
		private $place;
		private $description;
		private $type;
		private $urlimg;
		
		public function __construct($values) {
			parent::__construct($values);
		}
		
		/**
		 * @return mixed
		 */
		public function getIdEvenement() {
			return $this->idEvenement;
		}
		
		/**
		 * @param mixed $idEvenement
		 */
		public function setIdEvenement($idEvenement): void {
			$this->idEvenement = $idEvenement;
		}
		
		/**
		 * @return mixed
		 */
		public function getNom() {
			return $this->nom;
		}
		
		/**
		 * @param mixed $nom
		 */
		public function setNom($nom): void {
			$this->nom = ucfirst($nom);
		}
		
		/**
		 * @return mixed
		 */
		public function getDates() {
			return $this->dates;
		}
		
		/**
		 * @param mixed $dates
		 */
		public function setDates($dates): void {
			$this->dates = $dates;
		}
		
		/**
		 * @return mixed
		 */
		public function getAdresse() {
			return $this->adresse;
		}
		
		/**
		 * @param mixed $adresse
		 */
		public function setAdresse($adresse): void {
			$this->adresse = $adresse;
		}
		
		/**
		 * @return mixed
		 */
		public function getPlace() {
			return $this->place;
		}
		
		/**
		 * @param mixed $place
		 */
		public function setPlace($place): void {
			if(!is_int($place) || $place <= 0) {
				$this->addError("Merci de renseigner un nombre correct");
			} else {
				$this->place = $place;
			}
		}
		
		/**
		 * @return mixed
		 */
		public function getType() {
			return $this->type;
		}
		
		/**
		 * @param mixed $type
		 */
		public function setType($type): void {
			if($type === "Vide Grenier" || $type === "LAN") {
				$this->type = $type;
			} else {
				$this->addError("Merci de renseigner un type correct");
			}
		}
		
		/**
		 * @return mixed
		 */
		public function getDescription() {
			return $this->description;
		}
		
		/**
		 * @param mixed $description
		 */
		public function setDescription($description): void {
			$this->description = $description;
		}
		
		/**
		 * @return mixed
		 */
		public function getUrlimg() {
			return $this->urlimg;
		}
		
		/**
		 * @param mixed $urlimg
		 */
		public function setUrlimg($urlimg): void {
			$this->urlimg = $urlimg;
		}
		
		
	}