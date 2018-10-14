<?php
	
	namespace App;
	
    /**
     * Created by PhpStorm.
     * User: thoma
     * Date: 05/05/2018
     * Time: 22:49
     */
    
    class csrf {
        
        public function __construct() {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        }
        
        public function generateInput($name,Formulaire $formulaire) {
            $formulaire->inputTextHidden($name,$this->generateToken(),"csrf");
        }
        
        public function verifyToken($name, $page) {
            if (!array_key_exists($name, $_POST)) {
                $this->rejete($page);
            }
            
            if (in_array($_POST[$name], $_SESSION['csrf'])) {
                $this->useToken($_POST[$name]);
                return true;
            }
            $this->rejete($page);
        }
        
        private function useToken($token) {
            $tokens = array_filter($_SESSION['csrf'], function ($t) use ($token) {
                return $token !== $t;
            });
            $_SESSION['csrf'] = $tokens;
        }
        
        private function rejete($page) {
            header("location: $page");
            exit;
        }
        
        public function generateToken() {
            $token = bin2hex(random_bytes(16));
            $_SESSION['csrf'][] = $token;
            $this->limiteTokens();
            return $token;
        }
        
        private function limiteTokens() {
            if (count($_SESSION['csrf']) > 50) {
                array_shift($_SESSION['csrf']);
            }
        }
    }