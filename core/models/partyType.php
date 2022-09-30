<?php
class partyType extends Validator
{
    //Declaración de propiedades
    private $id = null;
    private $tipo = null;
    private $descripcion = null;
    private $foto = null;
    private $estado = null;
    private $ruta = '../../resources/img/public/events/';

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

    public function setTipo($value)
    {
        if ($this->validateAlphabetic($value, 1, 40)) {
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

    public function setDescripcion($value)
    {
        if ($this->validateAlphanumeric($value, 1, 100)) {
            $this->descripcion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setFoto($file, $name)
    {
        if ($this->validateImageFile($file, $this->ruta, $name, 500, 500)) {
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

    /* Obtiene los tipos de fiesta para la tabla del admin*/
    public function readEvents()
    {
        $sql = 'SELECT idTipoEvento,tipoEvento,descripcionTipo,fotoTipoEvento, visibilidadEvento FROM tipoevento WHERE estadoEvento = ?';
        $params = array($this->estado);
        return Database::getRows($sql, $params);
    }

    /* Obtiene los tipos de fiesta para el sitio público */
    public function readEventsCommerce()
    {
        $sql = 'SELECT idTipoEvento,tipoEvento,descripcionTipo,fotoTipoEvento FROM tipoevento WHERE estadoEvento = 1 AND visibilidadEvento = 1';
        $params = array($this->estado);
        return Database::getRows($sql, $params);
    }

    /* Crea un nuevo tipo fiesta */
    public function createEvents()
    {
        $sql = 'INSERT tipoevento VALUES(NULL,?,?,?,1,1)';
        $params = array($this->tipo, $this->descripcion, $this->foto);
        return Database::executeRow($sql, $params);
    }

    /* Obtiene los eventos */
    public function getEvents()
    {
        $sql = 'SELECT idTipoEvento,tipoEvento,descripcionTipo,fotoTipoEvento, visibilidadEvento FROM tipoevento WHERE idTipoEvento = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    /* Actualiza los tipos de eventos */
    public function updateEvents()
    {
        $sql = 'UPDATE tipoevento SET tipoEvento = ? ,descripcionTipo = ?,fotoTipoEvento = ?, visibilidadEvento = ? WHERE idTipoEvento = ?';
        $params = array($this->tipo, $this->descripcion, $this->foto, $this->estado, $this->id);
        return Database::executeRow($sql, $params);
    }

    /* Actualiza el estado del evento (Disponible o no) */
    public function actEvent()
    {
        $sql = 'UPDATE tipoevento SET estadoEvento = ? WHERE idTipoEvento = ?';
        $params = array($this->estado, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function getTypeProd()
    {
        $sql = 'SELECT nombreProducto,descripcionProducto,precioProducto,cantidadProducto,tipoevento FROM producto INNER JOIN (tipoevento) USING (idTipoEvento) WHERE estadoProducto = 1 ORDER BY tipoevento ASC, cantidadProducto ASC';
        $params = array(null);
        return Database::getRows($sql, $params);
    }

    public function getSalesPerType()
    {

        $sql = 'SELECT te.tipoEvento AS Tipo, FORMAT(SUM(p.precioProducto * df.cantidadProducto),2) AS TotalTipoEvento, f.fechahoraFactura AS Fecha from detallefactura AS df INNER JOIN producto AS p USING(idProducto) INNER JOIN tipoevento AS te USING(idTipoEvento) INNER JOIN factura as f USING(idFactura) WHERE fechahoraFactura BETWEEN ? AND ? GROUP BY idTipoEvento';
        $params = array(date('Y-m').'-01 00:00:00', date('Y').'-'.(date('m')+1).'-01 00:00:00');
        return Database::getRows($sql, $params);
    }
}