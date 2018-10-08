<?php
	
	namespace App;
	
	/**
	 * Created by PhpStorm.
	 * User: thoma
	 * Date: 26/05/2018
	 * Time: 16:40
	 */
	
	class UploadResponse {
		
		private $error;
		private $name;
		
		public function __construct(?string $error, ?string $name) {
			$this->error = $error;
			$this->name = $name;
		}
		
		public function getError(): ?string {
			return $this->error;
		}
		
		public function getName(): ?string {
			return $this->name;
		}
		
		public function isError(): bool {
			return !is_null($this->getError());
		}
		
		public function isName(): bool {
			return !is_null($this->getName());
		}
	}