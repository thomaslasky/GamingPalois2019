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
			$this->email = $email;
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
			$this->age = $age;
		}
		
		public function getTelephone() {
			return $this->telephone;
		}
		
		public function setTelephone($telephone): void {
			$this->telephone = $telephone;
		}
		
		public function getStatus() {
			return $this->status;
		}
		
		public function setStatus($status): void {
			$this->status = $status;
		}
		
		public function getToken() {
			return $this->token;
		}
		
		public function setToken($token): void {
			$this->token = $token;
		}
	}