<?php
	
	namespace App;
	
	/**
	 * Created by PhpStorm.
	 * User: thoma
	 * Date: 26/05/2018
	 * Time: 16:38
	 */
	
	class Files {
		private $index;
		
		const UPLOAD_ERR_OK = 0;
		
		public function __construct(string $index) {
			$this->index = $index;
		}
		
		public function isIndex(): bool {
			return isset($_FILES[$this->index]);
		}
		
		public function getName(): ?string {
			return $this->get('name');
		}
		
		public function getType(): ?string {
			return $this->get('type');
		}
		
		public function getTmpName(): ?string {
			return $this->get('tmp_name');
		}
		
		public function getError(): ?int {
			return $this->get('error');
		}
		
		public function getSize(): ?int {
			return $this->get('size');
		}
		
		private function get(string $index) {
			return $_FILES[$this->index][$index] ?? null;
		}
	}