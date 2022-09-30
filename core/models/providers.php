<?php 
class Providers extends Validator
{
    //Declaración de propiedades
    private $id = null;
    private $nombre = null;
    private $telefono = null;
    private $correo = null;
    private $estado = null;
    private $foto = null;
    private $ruta = "../../resources/img/dashboard/providers/";

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
        if($this->validateAlphanumeric($value,1,50)){
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setTelefono($value)
    {
        if($this->validatePhone($value)){
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

    public function setCorreo($value)
    {
        if($this->validateEmail($value)){
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

    public function readProviders()
    {
        $sql = 'SELECT idProveedor ,logoProveedor,nombreProveedor, telefonoProveedor FROM proveedor WHERE estadoProveedor = ?';
        $params = array($this->estado);
        return Database::getRows($sql,$params);
    }

    public function createProviders()
    {
        $sql = 'INSERT INTO proveedor VALUES(NULL,?,?,?,?,1)';
        $params = array($this->nombre,$this->telefono,$this->correo,$this->foto);
        return Database::executeRow($sql,$params);
    }

    public function getProviders()
    {
        $sql = 'SELECT idProveedor, nombreProveedor, telefonoProveedor, correoProveedor, logoProveedor FROM proveedor WHERE idProveedor = ?';
        $params = array($this->id);
        return Database::getRow($sql,$params);
    }

    public function updateProviders(){
        $sql = 'UPDATE proveedor SET nombreProveedor = ? , telefonoProveedor = ? , correoProveedor = ? , logoProveedor = ? WHERE idProveedor = ?';
        $params = array($this->nombre,$this->telefono,$this->correo,$this->foto,$this->id);
        return Database::executeRow($sql,$params);
    }

    public function actProviders(){
        $sql = 'UPDATE proveedor SET estadoProveedor = ? WHERE idProveedor = ?';
        $params = array($this->estado,$this->id);
        return Database::executeRow($sql,$params);
    }

    public function getProd()
    {
        $sql = 'SELECT `nombreProducto`,`descripcionProducto`,`precioProducto`,`cantidadProducto`, nombreProveedor FROM producto INNER JOIN (proveedor) USING (idProveedor) ORDER BY nombreProveedor asc';
        $params = array(null);
        return Database::getRows($sql,$params);
    }
}
?>