<?php
	
	namespace App;
	
abstract class Entity {

    protected $errors = [];

    public function __construct($values) {
        $this->hydrate($values);
    }
    
	protected function addError($error) {
        $this->errors[] = $error;
    }

    public function readError() {
        foreach ($this->errors as $key => $value) {
            echo $key . " " . $value . '<br>';
        }
    }

    private function hydrate($values) {
        if (is_array($values)) {
            foreach ($values as $key => $value) {
                $method = 'set' . ucfirst($key);
                if (method_exists($this, $method)) {
                    $this->$method($value);
                }
            }
        }
    }
}
