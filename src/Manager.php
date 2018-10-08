<?php
	
	namespace App;
	
	abstract class Manager {
		
		protected $db;
		protected $table;
		
		public function __construct() {
			$this->db = new \PDO('mysql:host=localhost;dbname=gamingpalois', 'root', '', array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
			//$this->db = new \PDO('mysql:host=localhost;dbname=gamingpaingaming', 'gamingpaingaming', 'Atlantissg1', array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
		}
	}