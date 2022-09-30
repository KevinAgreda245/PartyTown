<?php
class User extends Validator
{
    //Declaración de propiedades
	private $id = null;
    private $nombres = null;
    private $apellido = null;
    private $correo = null;
    private $tipo = null;
    private $clave = null;
    private $telefono = null;
    private $fecha = null;
    private $foto = null;
    private $ruta = "../../resources/img/dashboard/user/";
    private $estado = null;
    private $accion = null;

    //Métodos para sobrecarga de propiedades
    public function setId($value)
    {
        if ($this->validateId($value)) {
			$this->id = $value;
			return true;
        } else {
			return false;
		}
    }

    public function getId()
    {
        return $this->id;
    }

    public function setNombre($value)
    {
        if ($this->validateAlphabetic($value,1,50)) {
            $this->nombres = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getNombre()
    {
        return $this->nombres;
    }

    public function setApellidos($value)
    {
        if($this->validateAlphabetic($value,1,50)) {
            $this->apellido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function setCorreo($value)
    {
        if($this->validateEmail($value)) {
            $this->correo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function setTipo($value)
    {
        if($this->validateId($value)) {
            $this->tipo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setClave($value)
    {
        if($this->validatePassword($value)) {
            $this->clave = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getClave()
    {
        return $this->clave;
    }

    public function setTelefono($value)
    {
        if($this->validatePhone($value)) {
            $this->telefono = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setFecha($value)
    {
        $value = implode("-", array_reverse(explode("/", $value)));
        if($this->validateDate($value)) {
            $this->fecha = $value;
            return true;
        } else{
            return false;
        }
    }

    public function getFecha(){
        return $this->fecha;
    }

    public function setFoto($file, $name)
    {
        if($this->validateImageFile($file,$this->ruta,$name,500,500)) {
            $this->foto = $this->getImageName();
            return true;
        } else {
            return false;
        }
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function getRuta()
	{
		return $this->ruta;
    }

    public function setEstado($value)
	{
		if ($value == '1' || $value == '0') {
			$this->estado = $value;
			return true;
		} else {
			return false;
		}
	}

	public function getEstado()
	{
		return $this->estado;
    }
    
    /**
    *   Método para asignar el valor en la propiedad accion.
    *  
    *   @return boolean true cuando se asigna correctamente el valor y false en caso contrario.
    * 
    *   @param string $value es el valor a validar y asignar a la propiedad.
    */    
    public function setAccion($value)
    {
        if ($this->validateId($value)) {
            $this->accion = $value;
            return true;
        } else {
            return false;
        }
    }

    /**
    *   Método para obtener el valor de la propiedad accion.
    *
    *   @return int el valor de la propiedad accion.
    */    
    public function getAccion()
    {
        return $this->accion;
    }

    public function checkCorreo()
    {
        $sql = 'SELECT idUsuario, fotoUsuario, nombreUsuario, apellidoUsuario, idTipoUsuario FROM usuario WHERE correoUsuario = ? AND estadoEliminacion = 1';
		$params = array($this->correo);
		$data = Database::getRow($sql, $params);
		if ($data) {
            $this->id = $data['idUsuario'];
            $this->foto = $data['fotoUsuario'];
            $this->nombres = $data['nombreUsuario'];
            $this->apellido = $data['apellidoUsuario'];
            $this->tipo = $data['idTipoUsuario'];
			return true;
		} else {
			return false;
		}
    }

    public function checkPassword()
	{
		$sql = 'SELECT claveUsuario FROM usuario WHERE idUsuario = ?';
		$params = array($this->id);
		$data = Database::getRow($sql, $params);
		if (password_verify($this->clave, $data['claveUsuario'])) {
			return true;
		} else {
			return false;
		}
    }

    public function changePassword()
	{
		$hash = password_hash($this->clave, PASSWORD_DEFAULT);
		$sql = 'UPDATE usuario SET claveUsuario = ?,fechaModificacion = ? WHERE idUsuario = ?';
		$params = array($hash, date('Y-m-d G:i:s'),$this->id);
		return Database::executeRow($sql, $params);
	}

    public function readUser()
	{
		$sql = 'SELECT idUsuario,fotoUsuario,nombreUsuario,apellidoUsuario,correoUsuario, tipoUsuario FROM usuario INNER JOIN tipousuario USING(idTipoUsuario) WHERE estadoEliminacion = ?';
		$params = array($this->estado);
		return Database::getRows($sql, $params);
    }

    public function readTypeUser()
    {
        $sql = 'SELECT idTipoUsuario,tipoUsuario FROM tipousuario';
		$params = array(null);
		return Database::getRows($sql, $params);
    }

    public function createUser()
    {
        $hash = password_hash($this->clave, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO usuario VALUES (NULL,?,?,?,?,?,?,?,?,1,1,0,0,NULL,?)';
		$params = array($this->nombres,$this->apellido,$this->correo,$hash,$this->foto,$this->fecha,$this->telefono,$this->tipo,date('Y-m-d G:i:s'));
		return Database::executeRow($sql, $params);
    }

    public function getUser()
    {
        $sql = 'SELECT idUsuario,nombreUsuario,apellidoUsuario,correoUsuario,fotoUsuario,fechaNacimiento,telefonoUsuario,idTipoUsuario FROM usuario WHERE idUsuario = ?';
		$params = array($this->id);
		return Database::getRow($sql, $params);
    }

    public function getData()
    {
        $sql = 'SELECT nombreUsuario,apellidoUsuario,correoUsuario,fotoUsuario,idTipoUsuario FROM usuario WHERE idUsuario = ?';
		$params = array($this->id);
		$data = Database::getRow($sql, $params);
		if ($data) {
            $this->foto = $data['fotoUsuario'];
            $this->nombres = $data['nombreUsuario'];
            $this->apellido = $data['apellidoUsuario'];
            $this->correo = $data['correoUsuario'];
            $this->tipo = $data['idTipoUsuario'];
			return true;
		} else {
			return false;
		}
    }


    public function updateUser()
    {
        $sql = 'UPDATE usuario SET nombreUsuario = ?, apellidoUsuario = ?, correoUsuario = ?, fotoUsuario = ?, fechaNacimiento = ?, telefonoUsuario = ?, idTipoUsuario = ? WHERE idUsuario = ?';
        $params = array($this->nombres,$this->apellido,$this->correo,$this->foto,$this->fecha,$this->telefono,$this->tipo,$this->id);
        return Database::executeRow($sql,$params);
    }

    public function actUser(){
        $sql = 'UPDATE usuario SET estadoEliminacion = ? WHERE idUsuario = ?';
        $params = array($this->estado,$this->id);
        return Database::executeRow($sql,$params);
    }

    public function startOnline()
    {
        $sql = 'UPDATE usuario SET online = 1 WHERE idUsuario = ?';
        $params = array($this->id);
        Database::executeRow($sql,$params); 
    }

    public function endOnline()
    {
        $sql = 'UPDATE usuario SET online = 0 WHERE idUsuario = ?';
        $params = array($this->id);
        Database::executeRow($sql,$params); 
    }

    public function checkUser()
    {
        $sql = 'SELECT DATE((fechaModificacion) + INTERVAL 90 DAY) as Fecha, online as Online, estadoUsuario as Estado, fechaBloqueo as Bloqueo FROM usuario WHERE idUsuario = ?';
        $params = array($this->id);
        return Database::getRow($sql,$params);
    }

    public function createCode($code)
    {
        $hash = password_hash($code, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO codigos VALUES(NULL,?,?,0,?)';
        $params = array($hash,$this->id,date('Y-m-d G:i:s'));
        Database::executeRow($sql,$params);
    }

    public function lockUser()
    {
        $sql = 'UPDATE usuario SET estadoUsuario = 0 WHERE idUsuario = ?';
        $params = array($this->id);
        Database::executeRow($sql,$params);
    }

    public function checkCode($code)
	{
		$sql = 'SELECT codigoVerificacion FROM codigos WHERE idUsuario = ? AND estadoCodigo = 0';
		$params = array($this->id);
		$data = Database::getRow($sql, $params);
		if (password_verify($code, $data['codigoVerificacion'])) {
            return true;
		} else {
			return false;
		}
    }

    public function unlockUser()
    {
        $sql = 'UPDATE usuario SET estadoUsuario = 1, fechaBloqueo = NULL WHERE idUsuario = ?';
        $params = array($this->id);
        Database::executeRow($sql,$params);
    }

    public function updateStatus()
    {
        $sql = 'UPDATE codigos SET estadoCodigo = 1 WHERE idUsuario = ? AND estadoCodigo = 0' ;
        $params = array($this->id);
        Database::executeRow($sql,$params);
    }

    public function checkOnline()
    {
        $sql = 'SELECT online as Online FROM usuario WHERE idUsuario = ?';
        $params = array($this->id);
        return Database::getRow($sql,$params);
    }

    public function getLock()
    {
        $sql = 'SELECT intentosClave as Intentos FROM usuario WHERE idUsuario = ?';
        $params = array($this->id);
        $data = Database::getRow($sql,$params);
        return $data['Intentos'];
    }

    public function sumLock()
    {
        $sql = 'UPDATE usuario SET intentosClave = intentosClave + 1 WHERE idUsuario = ?';
        $params = array($this->id);
        Database::executeRow($sql,$params); 
    }

    public function userLock()
    {
        $sql = 'UPDATE usuario SET estadoUsuario = 0, fechaBloqueo = ? WHERE idUsuario = ?';
        $params = array(date('Y-m-d G:i:s'),$this->id);
        return Database::executeRow($sql,$params);
    }

    public function restartCount()
    {
        $sql = 'UPDATE usuario SET intentosClave = 0 WHERE idUsuario = ?';
        $params = array($this->id);
        Database::executeRow($sql,$params); 
    }

    public function showAction()
    {
        $sql = 'SELECT idAccion as Codigo, accionUsuario as Accion FROM accionesusuario ORDER BY accionUsuario';
        $params = array(null);
        return Database::getRows($sql,$params);
    }

    public function getType()
    {
        $sql = 'SELECT idTipoUsuario as Codigo, tipoUsuario as Tipo FROM tipousuario WHERE idTipoUsuario = ?';
        $params = array($this->id);
        return Database::getRow($sql,$params);
    }

    public function getIdAction()
    {
        $sql = 'SELECT idAccion as Codigo FROM `privilegio` WHERE idTipoUsuario = ?';
        $params = array($this->id);
        return Database::getRows($sql,$params);
    }

    public function createType()
    {
        $sql = 'INSERT INTO tipousuario VALUES (NULL, ?)';
        $params = array($this->nombres);
        $exc = Database::executeRow($sql, $params);
        if($exc){
            $this->id = Database::getLastRowId();
            return true;
        } else {
            return false;
        }
    }

    public function createPrivilege()
    {
        $sql = 'INSERT INTO privilegio VALUES (NULL, ?, ?)';
        $params = array($this->accion,$this->id);
        return Database::executeRow($sql, $params);
    }

    public function updateType()
    {
        $sql = 'UPDATE tipousuario SET tipousuario = ? WHERE idTipoUsuario = ?';
        $params = array($this->nombres,$this->id);
        $exc = Database::executeRow($sql, $params);
        if($exc){
            $sql = 'DELETE FROM privilegio WHERE idTipoUsuario = ?';
            $params = array($this->id);
            return Database::executeRow($sql, $params);
        } else {
            return false;
        }
    }

    public function readAction()
    {
        $sql = 'SELECT accionUsuario as Nombre, paginaAccion as Link, iconAccion as Icon FROM `privilegio` as p INNER JOIN accionesusuario USING (idAccion) WHERE p.`idTipoUsuario` = ?';
        $params = array($_SESSION['tipoUsuario']);        
        return Database::getRows($sql,$params);
    }

    public function newPass($value) 
    {
        $hash = password_hash($value, PASSWORD_DEFAULT);
        if ($hash != $this->clave) {
            $this->clave = $value;
            return true;
        } else {
            return false;
        }
    }

    
}   

?>