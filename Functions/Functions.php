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