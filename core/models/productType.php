<?php

class productType extends Validator
{
    private $id = null;
    private $tipo= null;
    private $descripcion = null;
    private $foto = null;
    private $ruta = '../../resources/img/public/categories/';
    private $estado = null;

    public function setId($value)
    {

        if($this->validateId($value)) {
            $this->id = $value;
            return true;
        } else 
            return false;
    }

    public function getId() 
    {
        return $this->id;
    }

    public function setTipo($value)
    {

        if($this->validateAlphabetic($value, 1, 60)) {
            $this->tipo = $value;
            return true;
        } else
            return false;            
    }

    public function getTipo() 
    {
        return $this->tipo;
    }

    public function setDescripcion($value)
    {
        if($this->validateAlphanumeric($value, 1, 100)) {
            $this->descripcion = $value;
            return true;
        } else
            return false;
    }

    public function getDescripcion() 
    {
        return $this->descripcion;
    }

    public function setFoto($file, $name)
    {
        if($this->validateImageFile($file, $this->ruta, $name, 500, 500))
        {
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

    /* Métodos para CRUD */

    /* Obtiene todos los tipos de productos con todos sus datos */
    public function readType()
    {
        $sql = 'SELECT idTipoProducto, tipoProducto, descripcionTipo, fotoTipoProducto, visibilidadTipo FROM tipoproducto WHERE estadoTipo = ?';
        $params = array($this->estado);
        return Database::getRows($sql, $params);
    }

    public function readTypeCommerce()
    {
        $sql = 'SELECT idTipoProducto, tipoProducto, descripcionTipo, fotoTipoProducto FROM tipoproducto WHERE estadoTipo = 1 AND visibilidadTipo = 1';
        $params = array(null);
        return Database::getRows($sql, $params);
    }

    public function createType()
    {
       $sql ='INSERT INTO tipoproducto VALUES(NULL,?,?,?,1,1)';
       $params = array($this->tipo,$this->descripcion,$this->foto);
       return Database::executeRow($sql,$params);
    }

    public function getType()
    {
        $sql = 'SELECT idTipoProducto, tipoProducto, descripcionTipo, fotoTipoProducto, visibilidadTipo FROM tipoproducto WHERE idTipoProducto   = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateType()
    {
        $sql = 'UPDATE tipoproducto SET tipoProducto = ?, descripcionTipo = ?, fotoTipoProducto = ?, visibilidadTipo = ? WHERE idTipoProducto = ?';
        $params = array($this->tipo,$this->descripcion,$this->foto,$this->estado,$this->id);
        return Database::executeRow($sql, $params);
    }
    
    public function actType()
    {
        $sql = 'UPDATE tipoproducto SET estadoTipo = ? WHERE idTipoProducto = ?';
        $params = array($this->estado,$this->id);
        return Database::executeRow($sql,$params); 
    }

    public function getTypeProd()
    {
        $sql = 'SELECT nombreProducto,descripcionProducto,precioProducto,cantidadProducto,tipoProducto FROM producto INNER JOIN (tipoproducto) USING (idTipoProducto) WHERE estadoProducto = 1 ORDER BY tipoProducto ASC, cantidadProducto ASC';
        $params = array(null);
        return Database::getRows($sql, $params);
    }
}
?>