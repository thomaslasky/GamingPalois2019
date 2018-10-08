<?php
	
	namespace App;
	
	/**
	 * Created by PhpStorm.
	 * User: thoma
	 * Date: 16/05/2018
	 * Time: 16:31
	 */
	
	class Participer extends Entity{
		
		private $paiement;
		private $vend;
		private $emplacement;
		private $IDmembre;
		private $IDevenement;
		
		public function __construct($values) {
			parent::__construct($values);
		}
		
		/**
		 * @return mixed
		 */
		public function getPaiement() {
			return $this->paiement;
		}
		
		/**
		 * @param mixed $paiement
		 */
		public function setPaiement($paiement): void {
			$this->paiement = $paiement;
		}
		
		/**
		 * @return mixed
		 */
		public function getVend() {
			return $this->vend;
		}
		
		/**
		 * @param mixed $vend
		 */
		public function setVend($vend): void {
			$this->vend = $vend;
		}
		
		/**
		 * @return mixed
		 */
		public function getIDmembre() {
			return $this->IDmembre;
		}
		
		/**
		 * @param mixed $IDmembre
		 */
		public function setIDmembre($IDmembre): void {
			$this->IDmembre = $IDmembre;
		}
		
		/**
		 * @return mixed
		 */
		public function getIDevenement() {
			return $this->IDevenement;
		}
		
		/**
		 * @param mixed $IDevenement
		 */
		public function setIDevenement($IDevenement): void {
			$this->IDevenement = $IDevenement;
		}
		
		/**
		 * @return mixed
		 */
		public function getEmplacement() {
			return $this->emplacement;
		}
		
		/**
		 * @param mixed $emplacement
		 */
		public function setEmplacement($emplacement): void {
			$this->emplacement = $emplacement;
		}
		
	}