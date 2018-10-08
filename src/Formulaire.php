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
		
		public function inputText($id, $nomChamp, $type,$class = '', $value = '', $placeholder = '', $label, $onClick = "") {
			$this->rendu .= "<label for='$nomChamp'>$label</label><br><input id='$id' type='$type' name='$nomChamp' id='$nomChamp' class='$class' value='$value' placeholder='$placeholder' onclick=$onClick required/><br>";
		}
		
		public function inputTextNoRequired($nomChamp, $type, $class = 'form_input_text', $value = '', $placeholder = '', $label) {
			$this->rendu .= "<label for='$nomChamp'>$label</label><br><input type='$type' name='$nomChamp' id='$nomChamp' class='$class' value='$value' placeholder='$placeholder'/><br>";
		}
		
		public function inputHidden($nomChamp, $value, $id) {
			$this->rendu .= "<input id='$id' type='hidden' name='$nomChamp' value='$value'/>";
		}
		
		public function select($nomSelect,$valuesArray,$label,$spanClass) {
			$choix = '';
			foreach ($valuesArray as $value) {
				$option = $value;
				$choix .= "<option value='$value'>$option</option><br>";
			}
			$this->rendu .= "<span class='$spanClass'><label for='$nomSelect'>$label</label><br><select name='$nomSelect'>$choix</select></span><br>";
		}
		
		public function textarea($name) {
			$this->rendu .= "<textarea name = $name rows='10' cols='10'></textarea>";
		}
		
		public function buttom($buttonClass, $onclick = "", $texte) {
			$this->rendu .= "<button class='$buttonClass' onclick='$onclick'>$texte</button><br>";
		}
		
		public function radio($nomRadio, $valuesArray, $spanClass = 'form_radio') {
			foreach ($valuesArray as $value) {
				$option = $value;
				$this->rendu .= "<span class='$spanClass'><input id='$option' type='radio' name='$nomRadio' value='$option'/><label for='$option'>$option</label></span><br>";
			}
		}
		
		public function checkBox($nom, $valeur, $label, $spanClass = 'form_checbox') {
			$this->rendu .= "<span class='$spanClass'><label for='$nom'>$label</label><br><input type='checkbox' id='$nom' name='$nom' value='$valeur'/></span><br>";
		}
		
		public function submit($name, $send, $class = 'form_submit') {
			$this->rendu .= "<input type='submit' class='$class' name='$name' value='$send'/><br>";
		}
		
		public function render() {
			return "<form method='$this->method' class='$this->class' id='$this->id' enctype=\"multipart/form-data\">" . $this->rendu . "</form>";
		}
	}
