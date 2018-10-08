<?php
	
	namespace App;
	
	/**
	 * Created by PhpStorm.
	 * User: thoma
	 * Date: 26/05/2018
	 * Time: 16:38
	 */
	
	class Uploads {
		public static function upload(string $index, string $destination, string $name, array $acceptedType): UploadResponse {
			$file = new Files($index);
			
			if ($file->isIndex()) {
				if ($file->getError() === Files::UPLOAD_ERR_OK) {
					if (in_array($file->getType(), $acceptedType)) {
						$e = explode('.', $file->getName());
						$ext = $e[1];
						$nameImg = $name . '.' . $ext;
						move_uploaded_file($file->getTmpName(), $destination . '/' . $nameImg);
					} else {
						$error = 'Votre image dois être en ' . $acceptedType;
					}
				} else {
					$error = 'Une erreur est survenue, merci de réesssayer plus tard.';
				}
				
			}
			
			return new UploadResponse($error ?? null, $nameImg ?? null);
		}
	}