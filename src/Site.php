<?php
	
	namespace App;
	
	class Site extends Entity {
		
		private $presentation;
		
		public function __construct($values) {
			parent::__construct($values);
		}
		
		/**
		 * @return mixed
		 */
		public function getPresentation() {
			return $this->presentation;
		}
		
		/**
		 * @param mixed $presentation
		 */
		public function setPresentation($presentation): void {
			$this->presentation = $presentation;
		}
		
	}