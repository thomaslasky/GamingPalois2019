<?php
	
	namespace App;
	
	global $rendu;
	
	class Formulaire {
		
		private $method;
		private $class;
		private $rendu;
		
		function __construct($method, $class, $id = "") {
			$this->method = $method;
			$this->class = $class;
			$this->id = $id;
			$this->rendu = "";
		}
		
		function getMethod() {
			return $this->method;
		}
		
		function setMethod($method) {
			$this->method = $method;
		}
		
		public function getClass() {
			return $this->class;
		}
		
		public function setClass($class) {
			$this->class = $class;
		}
		
		public function openDiv($id, $class) {
			$this->rendu .= "<div id='$id' class='$class'>";
		}
		
		public function closeDiv($divToClose = 1) {
			for($i = 1 ; $i <= $divToClose ; $i++) {
				$this->rendu .= "</div>";
			}
		}
		
		public function inputText($id, $nomChamp, $label, $inputClass = '', $value = '', $iClass = "", $icone = "", $more = "", $labelClass = "", $minLength = "", $maxLength = "", $onClick = "") {
			$this->rendu .= "<i class='$iClass'>$icone</i>";
			$this->rendu .= "<input id='$id' class='$inputClass' type='text' name='$nomChamp' value='$value' minlength='$minLength' maxlength='$maxLength' onclick='$onClick' $more/>";
			$this->rendu .= "<label class='$labelClass' for='$nomChamp'>$label</label>";
		}
		
		public function inputTextHidden($nomChamp, $value, $id) {
			$this->rendu .= "<input id='$id' type='hidden' name='$nomChamp' value='$value'/>";
		}
		
		public function inputEmail($id, $nomChamp, $label, $inputClass = '', $value = '', $iClass = "", $icone = "", $more = "", $labelClass = "", $minLength = 0, $maxLength = 199, $onClick = "") {
			$this->rendu .= "<i class='$iClass'>$icone</i>";
			$this->rendu .= "<input id='$id' class='$inputClass' type='email' name='$nomChamp' value='$value' minlength='$minLength' maxlength='$maxLength' onclick='$onClick' $more/>";
			$this->rendu .= "<label class='$labelClass' for='$nomChamp'>$label</label>";
		}
		
		public function inputNumber($id, $nomChamp, $label, $inputClass = '', $value = '', $iClass = "", $icone = "", $labelClass = "", $min = "", $max = "", $onClick = "") {
			$this->rendu .= "<i class='$iClass'>$icone</i>";
			$this->rendu .= "<input id='$id' class='$inputClass' type='number' name='$nomChamp' value='$value' min='$min' max='$max' onclick='$onClick'/>";
			$this->rendu .= "<label class='$labelClass' for='$nomChamp'>$label</label>";
		}
		
		public function inputTelephone($id, $nomChamp, $label, $inputClass = '', $value = '', $iClass = "", $icone = "", $more = "", $labelClass = "", $min = "", $max = "", $onClick = "") {
			$this->rendu .= "<i class='$iClass'>$icone</i>";
			$this->rendu .= "<input id='$id' class='$inputClass' type='tel' name='$nomChamp' value='$value' min='$min' max='$max' onclick='$onClick' $more/>";
			$this->rendu .= "<label class='$labelClass' for='$nomChamp'>$label</label>";
		}
		
		public function inputPassword($id, $nomChamp, $label, $inputClass = '', $value = '', $iClass = "", $icone = "", $labelClass = "", $min = "", $max = "", $onClick = "") {
			$this->rendu .= "<i class='$iClass'>$icone</i>";
			$this->rendu .= "<input id='$id' class='$inputClass' type='password' name='$nomChamp' value='$value' min='$min' max='$max' onclick='$onClick' />";
			$this->rendu .= "<label class='$labelClass' for='$nomChamp'>$label</label>";
		}
		
		public function inputDate($id, $nomChamp, $label, $inputClass = '', $value = '', $iClass = "", $icone = "", $labelClass = "") {
			$this->rendu .= "<i class='$iClass'>$icone</i>";
			$this->rendu .= "<input id='$id' class='$inputClass' type='date' name='$nomChamp' value='$value'/>";
			$this->rendu .= "<label class='$labelClass' for='$nomChamp'>$label</label>";
		}
		
		public function inputFile($id, $nomChamp, $label, $inputClass = '', $iClass = "", $icone = "", $labelClass = "", $more = "") {
			$this->rendu .= "<i class='$iClass'>$icone</i>";
			$this->rendu .= "<input id='$id' class='$inputClass' type='file' name='$nomChamp' $more/>";
			$this->rendu .= "<label class='$labelClass' for='$nomChamp'>$label</label>";
		}
		
		public function inputLink($id, $nomChamp, $label, $inputClass = '', $value = '', $iClass = "", $icone = "", $more = "", $labelClass = "") {
			$this->rendu .= "<i class='$iClass'>$icone</i>";
			$this->rendu .= "<input id='$id' class='$inputClass' type='url' name='$nomChamp' value='$value' $more/>";
			$this->rendu .= "<label class='$labelClass' for='$nomChamp'>$label</label>";
		}
		
		public function select($nomSelect, $valuesArray, $label, $spanClass) {
			
			$choix = "<option disabled selected>Choisissez votre option</option>";
			
			foreach($valuesArray as $value) {
				$option = $value;
				$choix .= "<option value='$value'>$option</option><br>";
			}
			
			$this->rendu .= "<span class='$spanClass'>";
			$this->rendu .= "<label for='$nomSelect'>$label</label>";
			$this->rendu .= "<select name='$nomSelect'>$choix</select>";
			$this->rendu .= "</span>";
		}
		
		public function textArea($id, $nomChamp, $label, $iClass = "", $icone = "", $cols = "50") {
			$this->rendu .= "<i class='$iClass'>$icone</i>";
			$this->rendu .= "<textarea id ='$id' name='$nomChamp' cols='$cols'></textarea>";
			$this->rendu .= "<label for='$nomChamp'>$label</label>";
		}
		
		/*public function radio($nomRadio, $valuesArray, $spanClass = '') {
			foreach($valuesArray as $value) {
				$option = $value;
				$this->rendu .= "<span class='$spanClass'><input id='$option' type='radio' name='$nomRadio' value='$option'/><label for='$option'>$option</label></span><br>";
			}
		}
		
		public function checkBox($nom, $valeur, $label, $spanClass = '') {
			$this->rendu .= "<span class='$spanClass'><label for='$nom'>$label</label><br><input type='checkbox' id='$nom' name='$nom' value='$valeur'/></span><br>";
		}*/
		
		public function submit($name, $send, $class = '', $onclick = "") {
			$this->rendu .= "<input type='button' class='$class' name='$name' value='$send' onclick='$onclick'/>";
		}
		
		public function submitButton($name, $send, $class = '', $onclick = "") {
			$this->rendu .= "<button type='submit' class='$class' name='$name' value='$send' onclick='$onclick'/>Envoyer<i class='material-icons right'>send</i></<button>";
		}
		
		public function render() {
			return "<form method='$this->method' class='$this->class' id='$this->id' enctype=\"multipart/form-data\">" . $this->rendu . "</form>";
		}
	}
