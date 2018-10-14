<?php
	
	function debug(...$vars) {
		foreach($vars as $var) {
			echo '<pre>';
			var_dump($var);
			echo '</pre>';
		}
	}
	
	function checkPassword($pwdPassed, $pwdDB) {
		if ($pwdPassed === $pwdDB) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function verifyStatus($status,$arrayType) {
		if (!empty($status) && in_array($status,$arrayType)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function verifyAge($age) {
		if (!empty($age) && $age >= 18 && $age < 100) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function verifyTelephone($telephone) {
		
		$taille = strlen($telephone);
		$phonePrefix = substr($telephone, 0, 2);
		
		if (!empty($telephone) && $taille === 10 && $phonePrefix === "06" || $phonePrefix === "07") {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function verifyEmail($email) {
		if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return TRUE;
		} else {
			
			return FALSE;
		}
	}