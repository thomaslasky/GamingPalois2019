<?php
	/**
	 * Created by PhpStorm.
	 * User: thoma
	 * Date: 08/11/2018
	 * Time: 16:44
	 */
	
	namespace App;
	
	
	class SiteManager extends Manager {
		
		public function __construct() {
			parent::__construct();
			$this->table = "info_site";
		}
		
		public function selectPresentation() {
			$sql = "SELECT Presentation FROM {$this->table}";
			
			$req = $this->db->prepare($sql);
			
			$req->execute();
			
			$presentation = $req->fetch();
			
			return $presentation["Presentation"];
		}
		
		public function updatePresentation($presentation) {
			$sql = "UPDATE {$this->table} SET Presentation = :presentation WHERE IDsite = 1";
			$req = $this->db->prepare($sql);
			$req->bindValue('presentation', $presentation, \PDO::PARAM_STR);
			$req->execute();
		}
		
		public function showPresentation($presentation, $modeleHTML) {
			
			$arrReplace = [
				'{{contenu}}' => $presentation,
			];
			
			return strtr($modeleHTML, $arrReplace);
		}
	}