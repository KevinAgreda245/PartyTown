<?php 
class Customer extends Validator{
    //Declaración de propiedades
    private $id = null;
    private $nombres = null;
    private $apellido = null;
    private $genero = null;
    private $correo = null;
    private $clave = null;
    private $telefono = null;
    private $fecha = null;
    private $estado = null;

    //Métodos para sobrecarga de propiedades

    /* Establece la ID */
    public function setId($value)
    {
        if ($this->validateId($value)) {
			$this->id = $value;
			return true;
        } else {
			return false;
		}
    }

    /* Obtiene la ID */
    public function getId()
    {
        return $this->id;
    }

    /* Establece el nombre */
    public function setNombre($value)
    {
        if ($this->validateAlphabetic($value,1,50)) {
            $this->nombres = $value;
            return true;
        } else {
            return false;
        }
    }

    /* Obtiene el nombre */
    public function getNombre() 
    {
        return $this->nombres;
    }
    
    /* Establece los apellidos */
    public function setApellidos($value)
    {
        if($this->validateAlphabetic($value,1,50)) {
            $this->apellido = $value;
            return true;
        } else {
            return false;
        }
    }

    /* Obtiene el apellido */
    public function getApellido()
    {
        return $this->apellido;
    }

    /* Establece el gènero */
    public function setGenero($value)
	{
		if ($value == '1' || $value == '2') {
			$this->genero = $value;
			return true;
		} else {
			return false;
		}
	}

    /* Obtiene el gènero */
	public function getGenero()
	{
		return $this->genero;
	}

    /* Establece el correo */
    public function setCorreo($value)
    {
        if($this->validateEmail($value)) {
            $this->correo = $value;
            return true;
        } else {
            return false;
        }
    }

    /* Obtiene el correo */
    public function getCorreo()
    {
        return $this->correo;
    }
    
    /* Establece la clave */
    public function setClave($value)
    {
        if($this->validatePassword($value)) {
            $this->clave = $value;
            return true;
        } else {
            return false;
        }
    }

    /* Obtiene la clave */
    public function getClave()
    {
        return $this->clave;
    }

    /* Establece el teléfono */
    public function setTelefono($value)
    {
        if($this->validatePhone($value)) {
            $this->telefono = $value;
            return true;
        } else {
            return false;
        }
    }

    /* Obtiene el teléfono */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /* Establece la fecha */
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

    /* Obtiene la fecha */
    public function getFecha(){
        return $this->fecha;
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

    /* Obtiene los clientes */
    public function readCustomer(){
        $sql = 'SELECT idCliente, nombreCliente, apellidoCliente, correoCliente, telefonoCliente, visibilidadCliente FROM cliente WHERE estadoCliente = ?';
        $params = array($this->estado);
        return Database::getRows($sql,$params);
    }

    /* Obtiene un cliente específico */
    public function getCustomer(){
        $sql = 'SELECT idCliente, nombreCliente, apellidoCliente, correoCliente, telefonoCliente FROM cliente WHERE idCliente = ?';
        $params = array($this->id);
        return Database::getRows($sql,$params);
    }

    /* Obtiene el estado del cliente (Activo o no) */
    public function getStatusCustomer(){
        $sql = 'SELECT idCliente, visibilidadCliente FROM cliente WHERE idCliente = ?';
        $params = array($this->id);
        return Database::getRow($sql,$params);
    }

    /* Actualiza el estado del cliente */
    public function updateStatus(){
        $sql = 'UPDATE cliente SET estadoCliente = ? WHERE idCliente = ?';
        $params = array($this->estado,$this->id);
        return Database::executeRow($sql,$params);
    }

    /* Crea un nuevo cliente */
    public function createCustomer()
    {
        $hash = password_hash($this->clave, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO cliente VALUES(NULL,?,?,?,?,?,?,?,1,1,?,0,NULL,0)';
        $params = array($this->nombres,$this->apellido,$this->genero,$this->correo,$hash,$this->telefono,$this->fecha,date('Y-m-d G:i:s'));
        return Database::executeRow($sql,$params);
    }

    /* Verifica el correo */
    public function checkCorreo(){
        $sql = 'SELECT idCliente FROM cliente WHERE correoCliente = ? AND estadoCliente = 1';
		$params = array($this->correo);
		$data = Database::getRow($sql, $params);
		if ($data) {
            $this->id = $data['idCliente'];
			return true;
		} else {
			return false;
		}
    }

    /* Verifica la contraseña */
    public function checkPassword()
	{
		$sql = 'SELECT claveCliente FROM cliente WHERE idCliente = ?';
		$params = array($this->id);
		$data = Database::getRow($sql, $params);
		if (password_verify($this->clave, $data['claveCliente'])) {
			return true;
		} else {
			return false;
		}
    }

    public function changePassword()
	{
		$hash = password_hash($this->clave, PASSWORD_DEFAULT);
		$sql = 'UPDATE cliente SET claveCliente = ?,fechaModificacion = ? WHERE idCliente = ?';
		$params = array($hash, date('Y-m-d G:i:s'),$this->id);
		return Database::executeRow($sql, $params);
	}

    /* Obtiene los datos del cliente */
    public function getData(){
        $sql = 'SELECT idCliente, nombreCliente, apellidoCliente, correoCliente, generoCliente,fechaNacimiento , telefonoCliente FROM cliente WHERE idCliente = ?';
        $params = array($this->id);
        return Database::getRow($sql,$params);
    }

    /* Actualiza los datos del cliente */
    public function updateCustomer(){
        $sql = 'UPDATE cliente SET nombreCliente = ?, apellidoCliente = ?, correoCliente = ?, generoCliente = ?,fechaNacimiento = ?, telefonoCliente = ? WHERE idCliente = ?';
        $params = array($this->nombres,$this->apellido,$this->correo,$this->genero,$this->fecha,$this->telefono,$this->id);
        return Database::executeRow($sql,$params);
    }

    public function createCode($code)
    {
        $hash = password_hash($code, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO codigoCliente VALUES(NULL,?,?,0,?)';
        $params = array($hash,$this->id,date('Y-m-d G:i:s'));
        Database::executeRow($sql,$params);
    }

    public function checkCode($code)
	{
		$sql = 'SELECT codigoVerificacion FROM codigoCliente WHERE idCliente = ? AND estadoCodigo = 0';
		$params = array($this->id);
		$data = Database::getRow($sql, $params);
		if (password_verify($code, $data['codigoVerificacion'])) {
            return true;
		} else {
			return false;
		}
    }

    public function updateStatusCode()
    {
        $sql = 'UPDATE codigos SET estadoCodigo = 1 WHERE idUsuario = ? AND estadoCodigo = 0' ;
        $params = array($this->id);
        Database::executeRow($sql,$params);
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

    public function checkOnline()
    {
        $sql = 'SELECT online as Online FROM cliente WHERE idCliente = ?';
        $params = array($this->id);
        return Database::getRow($sql,$params);
    }

    public function startOnline()
    {
        $sql = 'UPDATE cliente SET online = 1 WHERE idCliente = ?';
        $params = array($this->id);
        Database::executeRow($sql,$params); 
    }

    public function endOnline()
    {
        $sql = 'UPDATE cliente SET online = 0 WHERE idCliente = ?';
        $params = array($this->id);
        Database::executeRow($sql,$params); 
    }

    public function checkUser()
    {
        $sql = 'SELECT DATE((fechaModificacion) + INTERVAL 90 DAY) as Fecha, online as Online, visibilidadCliente as Estado, fechaBloqueo as Bloqueo FROM cliente WHERE idCliente = ?';
        $params = array($this->id);
        return Database::getRow($sql,$params);
    }

    public function restartCount()
    {
        $sql = 'UPDATE cliente SET intentosClave = 0 WHERE idCliente = ?';
        $params = array($this->id);
        Database::executeRow($sql,$params); 
    }

    public function lockUser()
    {
        $sql = 'UPDATE cliente SET visibilidadCliente = 0 WHERE idCliente = ?';
        $params = array($this->id);
        Database::executeRow($sql,$params);
    }

    public function userLock()
    {
        $sql = 'UPDATE cliente SET visibilidadCliente = 0, fechaBloqueo = ? WHERE idCliente = ?';
        $params = array(date('Y-m-d G:i:s'),$this->id);
        return Database::executeRow($sql,$params);
    }

    public function sumLock()
    {
        $sql = 'UPDATE cliente SET intentosClave = intentosClave + 1 WHERE idCliente = ?';
        $params = array($this->id);
        Database::executeRow($sql,$params); 
    }

    public function unlockUser()
    {
        $sql = 'UPDATE cliente SET visibilidadCliente = 1, fechaBloqueo = NULL WHERE idCliente = ?';
        $params = array($this->id);
        Database::executeRow($sql,$params);
    }

    public function getLock()
    {
        $sql = 'SELECT intentosClave as Intentos FROM cliente WHERE idCliente = ?';
        $params = array($this->id);
        $data = Database::getRow($sql,$params);
        return $data['Intentos'];
    }

}
?>