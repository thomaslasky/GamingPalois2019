<?php
	
	namespace App;
    
    class Membres extends Entity {
        
        private $idMembre;
        private $email;
        private $password;
        private $nom;
        private $prenom;
        private $age;
        private $telephone;
        private $adresse;
        private $statut;
        
        public function __construct($values) {
            parent::__construct($values);
        }

		public function getIdMembre() {
			return $this->idMembre;
		}

		public function setIdMembre($idMembre): void {
			$this->idMembre = $idMembre;
		}

		public function getEmail() {
			return $this->email;
		}

		public function setEMail($email): void {
			$this->email = $email;
		}

		public function getPassword() {
			return $this->password;
		}

		public function setPassword($password): void {
			$this->password = $password;
		}

		public function getNom() {
			return $this->nom;
		}

		public function setNom($nom): void {
			$this->nom = $nom;
		}

		public function getPrenom() {
			return $this->prenom;
		}

		public function setPrenom($prenom): void {
			$this->prenom = $prenom;
		}

		public function getAge() {
			return $this->age;
		}

		public function setAge($age): void {
			$this->age = $age;
		}

		public function getTelephone() {
			return $this->telephone;
		}

		public function setTelephone($telephone): void {
			$this->telephone = $telephone;
		}

		public function getAdresse() {
			return $this->adresse;
		}

		public function setAdresse($adresse): void {
			$this->adresse = $adresse;
		}

		public function getStatut() {
			return $this->statut;
		}

		public function setStatut($statut): void {
			$this->statut = $statut;
		}

    }