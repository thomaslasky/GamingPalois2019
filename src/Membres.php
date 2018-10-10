<?php
	
	namespace App;
	
	class Membres extends Entity {
		
		private $IDmembre;
		private $email;
		private $password;
		private $nom;
		private $prenom;
		private $age;
		private $telephone;
		private $adresse;
		private $status;
		private $token;
		
		public function __construct($values) {
			parent::__construct($values);
		}
		
		public function getIDmembre() {
			return $this->IDmembre;
		}
		
		public function setIDmembre($IDmembre): void {
			$this->IDmembre = $IDmembre;
		}
		
		public function getEmail() {
			return $this->email;
		}
		
		public function setEmail($email): void {
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$this->email = $email;
			} else {
				$this->addError("Email Invalide");
			}
		}
		
		public function getPassword() {
			return $this->password;
		}
		
		public function setPassword($password): void {
			$this->password = md5($password);
		}
		
		public function getNom() {
			return $this->nom;
		}
		
		public function setNom($nom): void {
			$this->nom = strtoupper($nom);
		}
		
		public function getPrenom() {
			return $this->prenom;
		}
		
		public function setPrenom($prenom): void {
			$this->prenom = ucfirst($prenom);
		}
		
		public function getAge() {
			return $this->age;
		}
		
		public function setAge($age): void {
			if ($age < 18 || $age > 100) {
				$this->addError("Merci de renseigner un âge valide");
			} else {
				$this->age = $age;
			}
		}
		
		public function getTelephone() {
			return $this->telephone;
		}
		
		public function setTelephone($telephone): void {
			if (strlen($telephone) != 10) {
				$this->addError("Merci de renseigner un numéro valide");
			} else {
				$this->telephone = $telephone;
			}
		}
		
		public function getAdresse() {
			return $this->adresse;
		}
		
		public function setAdresse($adresse): void {
			$this->adresse = $adresse;
		}
		
		public function getStatus() {
			return $this->status;
		}
		
		public function setStatus($status): void {
			if ($status === "Professionnel" || $status === "Particulier" || $status === "Administrateur") {
				$this->status = $status;
			} else {
				$this->addError("Petit coquin ! ce n'est pas bien ! Ton IP est désormais banni de ce site ! Contact l'administrateur au plus vite : xxxx@gmail.com");
			}
		}
		
		public function getErrors(): array {
			return $this->errors;
		}
		
		public function setErrors(array $errors): void {
			$this->errors = $errors;
		}
		
		public function getToken() {
			return $this->token;
		}
		
		public function setToken($token): void {
			$this->token = $token;
		}
	}