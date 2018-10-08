<?php
	/**
	 * Created by PhpStorm.
	 * User: thoma
	 * Date: 20/06/2018
	 * Time: 15:38
	 */
	
	namespace App;
	
	class Partenairesgp extends Entity {
		
		private $idPartenaire;
		private $nom;
		private $description;
		private $site;
		private $urlimg;
		
		public function __construct($values) {
			parent::__construct($values);
		}
		
		/**
		 * @return mixed
		 */
		public function getIdPartenaire() {
			return $this->idPartenaire;
		}
		
		/**
		 * @param mixed $idPartenaire
		 */
		public function setIdPartenaire($idPartenaire): void {
			$this->idPartenaire = $idPartenaire;
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
		public function getSite() {
			return $this->site;
		}
		
		/**
		 * @param mixed $site
		 */
		public function setSite($site): void {
			if (filter_var($site,FILTER_VALIDATE_URL,"")) {
				$this->site = $site;
			} else {
				$this->addError("Merci de renseigner une adresse correcte");
			}
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