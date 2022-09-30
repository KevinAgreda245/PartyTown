<?php
class Validator
{

	private $imageError = null;
	private $imageName = null;
	private $passError = null;
	private $passErrorEN = null;

	public function getImageName()
	{
		return $this->imageName;
	}

	public function getPassError()
	{
		return $this->passError;
	}

	public function getPassErrorEN()
	{
		return $this->passErrorEN;
	}

	public function getImageError()
	{
		switch ($this->imageError) {
			case 1:
				$error = 'El tipo de la imagen debe ser gif, jpg o png';
				break;
			case 2:
				$error = 'La dimensión de la imagen es incorrecta';
				break;
			case 3:
				$error = 'El tamaño de la imagen debe ser menor a 2MB';
				break;
			case 4:
				$error = 'El archivo de la imagen no existe';
				break;
			default:
				$error = 'Ocurrió un problema con la imagen';
		}
		return $error;
	}

	public function getImageErrorEN()
	{
		switch ($this->imageError) {
			case 1:
				$error = 'The type of the image must be gif, jpg or png';
				break;
			case 2:
				$error = 'Image dimension is incorrect';
				break;
			case 3:
				$error = 'Image size must be less than 2MB';
				break;
			case 4:
				$error = 'Image file does not exist';
				break;
			default:
				$error = 'There was a problem with the image';
		}
		return $error;
	}

	public function validateForm($fields)
	{
		foreach ($fields as $index => $value) {
			$value = trim($value);
			$fields[$index] = strip_tags($value);
		}
		return $fields;
	}

	public function validateId($value)
	{
		if (filter_var($value, FILTER_VALIDATE_INT, array('min_range' => 1))) {
			return true;
		} else {
			return false;
		}
	}

	public function validateDate($value){
		$fechaActual = date("Y-m-d");
		$fechaMayor = date("Y-m-d",strtotime($fechaActual."- 18 year"));
		if($value <= $fechaMayor){
			return true;
		}else{
			return false;
		}

	}

	public function validateImageFile($file, $path, $name, $maxWidth, $maxHeigth)
	{
		if ($file) {
	     	if ($file['size'] <= 2097152) {
		    	list($width, $height, $type) = getimagesize($file['tmp_name']);
				if ($width <= $maxWidth && $height <= $maxHeigth) {
					//Tipos de imagen: 1 - GIF, 2 - JPG y 3 - PNG
					if ($type == 1 || $type == 2 || $type == 3) {
						if ($name) {
							if (file_exists($path.$name)) {
								if($this->deleteFile($path, $name)){
									$extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
									$this->imageName = uniqid().'.'.$extension;
									return true;
								} else {
									return false;
								}
							} else {
								$this->imageError = 4;
								return false;
							}
						} else {
							$extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
							$this->imageName = uniqid().'.'.$extension;
							return true;
						}
					} else {
						$this->imageError = 1;
						return false;
					}
				} else {
					$this->imageError = 2;
					return false;
				}
	     	} else {
				$this->imageError = 3;
				return false;
	     	}
		} else {
			if (file_exists($path.$name)) {
				$this->imageName = $name;
				return true;
			} else {
				$this->imageError = 4;
				return false;
			}
		}
	}

	public function validateEmail($email)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return true;
		} else {
			return false;
		}
	}

	public function validateAlphabetic($value, $minimum, $maximum)
	{
		if (preg_match('/^[a-zA-ZñÑáÁéÉíÍóÓúÚ\s]{'.$minimum.','.$maximum.'}$/', $value)) {
			return true;
		} else {
			return false;
		}
	}

	public function validateAlphanumeric($value, $minimum, $maximum)
	{
		if (preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.\&\;\?]{'.$minimum.','.$maximum.'}$/', $value)) {
			return true;
		} else {
			return false;
		}
	}

	/* Valida que sólo sean números el valor ingresado */
	public function validateNumeric($value, $minimum, $maximum)
	{
		if (preg_match('/^[0-9]{'.$minimum.','.$maximum.'}$/',$value))
			return true;
		else
			return false;
	}

	public function validateMoney($value)
	{
		if (preg_match('/^[0-9]+(?:\.[0-9]{1,2})?$/', $value)) {
			return true;
		} else {
			return false;
		}
	}

	public function validatePhone($value){
		if(preg_match('/^([2,6,7][0-9]{3})(-)([0-9]{4})$/',$value)){
			return true;
		}else{
			return false;
		}
	}

	public function validatePassword($value)
	{
		if (strlen($value) > 7) {
			if (strlen($value) < 16) {
				if (preg_match('`[a-z]`',$value)){
					if (preg_match('`[A-Z]`',$value)){
						if (preg_match('`[0-9]`',$value)){
							if (preg_match('/[^a-zA-Z\d]/',$value)){ 
								return true;
							} else {
								$this->passErrorEN = 'The password must contain at least one special character';
								$this->passError = 'La contraseña debe contener al menos un cáracter especial';
								return false;
							}
						} else {
							$this->passErrorEN = 'The password must contain at least one numeric character';
							$this->passError = 'La contraseña debe contener al menos un cáracter numérico';
							return false;
						}
					} else {
						$this->passErrorEN = 'The password must contain at least one uppercase letter';
						$this->passError = 'La contraseña debe contener al menos una letra mayúscula';
						return false;
					}
				} else {
					$this->passErrorEN = 'The password must contain at least one lowercase letter';
					$this->passError = 'La contraseña debe contener al menos una letra minúscula';
					return false;	
				}
			} else {
				$this->passErrorEN = 'The password cannot be longer than 16 characters';
				$this->passError = 'La contraseña no puede tener más de 16 caracteres';
				return false;
			}
		} else {
			$this->passErrorEN = 'The password must be more than 8 characters';
			$this->passError = 'La contraseña debe tener más de 8 caracteres';
			return false;
		}
	}

	public function saveFile($file, $path, $name)
    {
		if (file_exists($path)) {
			if (move_uploaded_file($file['tmp_name'], $path.$name)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
  	}

	public function deleteFile($path, $name)
    {
		if (file_exists($path)) {
			if (unlink($path.$name)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
?>