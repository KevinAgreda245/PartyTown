<?php
class Invoices extends Validator
{
    //Declaración de propiedades
    private $id = null;
    private $direccion = null;
    private $estado = null;
    private $cliente = null;
    private $fechahoy = null;

    //Método para sobrecarga de propiedades
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

    public function setDireccion($value)
    {
        if ($this->validateAlphanumeric($value, 1, 100)) {
            $this->direccion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getDireccion()
    {
        return $this->direccion;
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

    public function setCliente($value)
    {
        if ($this->validateId($value)) {
            $this->cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getCliente()
    {
        return $this->cliente;
    }

    public function setFecha($value)
    {
        $this->fechahoy = $value;
    }

    //Método para leer todas las facturas
    public function readInvoices()
    {
        $sql = 'SELECT idFactura,nombreCliente, apellidoCliente,fechahoraFactura,direccionFactura,estadoFactura, anulacionFactura FROM factura INNER JOIN (cliente) USING(idCliente) WHERE anulacionFactura = ?';
        $params = array($this->estado);
        return Database::getRows($sql, $params);
    }

    //Método para leer todas las facturas
    public function readInvoicesClients()
    {
        $sql = 'SELECT idFactura, fechahoraFactura,direccionFactura,estadoFactura, anulacionFactura FROM factura WHERE idCliente = ?';
        $params = array($this->cliente);
        return Database::getRows($sql, $params);
    }

    //Método para obtener el detalle de venta de una factura
    public function getProduct()
    {
        $sql = 'SELECT e.`idProducto` as codigo ,nombreProducto, e.`cantidadProducto` as cantidad, precioProducto FROM detallefactura as e INNER JOIN producto USING (idProducto) WHERE idFactura = ? ORDER BY nombreProducto ASC';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    //Método para modificar el estado de una factura
    public function updateStatus()
    {
        $sql = 'UPDATE factura SET estadoFactura = 1 WHERE idFactura = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para cancelar una factura
    public function cancelInvoices()
    {
        $sql = 'UPDATE factura SET anulacionFactura = 1 WHERE idFactura = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function getEarning()
    {
        $sql = 'SELECT idCliente, idFactura,fechahoraFactura, direccionFactura,nombreCliente, apellidoCliente FROM factura INNER JOIN (cliente) USING (idCliente) WHERE estadoFactura = 0 AND anulacionFactura = 0 ORDER BY idCliente asc ,fechahoraFactura asc';
        $params = array(null);
        return Database::getRows($sql, $params);
    }

    public function getToday()
    {
        $sql = 'SELECT idCliente, idFactura,fechahoraFactura, direccionFactura,nombreCliente, apellidoCliente, estadoFactura FROM factura INNER JOIN (cliente) USING (idCliente) WHERE  (fechahoraFactura BETWEEN ? AND ?) AND anulacionFactura = 0 ORDER BY idCliente asc ,fechahoraFactura asc';
        $params = array($this->fechahoy . ' 00:00:00', $this->fechahoy . ' 23:59:59');
        return Database::getRows($sql, $params);
    }

    public function getAmount()
    {
        $sql = 'SELECT tipoproducto AS Tipo, SUM(detallefactura.cantidadProducto * producto.precioProducto) as Monto FROM detallefactura INNER JOIN(factura) USING(idFactura) INNER JOIN(producto) USING (idProducto) INNER JOIN (tipoproducto) USING (idTipoProducto) WHERE fechahoraFactura BETWEEN ? AND ? GROUP BY idTipoProducto';
        $params = array(date('Y-m').'-01 00:00:00', date('Y').'-'.(date('m')+1).'-01 00:00:00');
        return Database::getRows($sql, $params);
    }

    public function getInvoices()
    {
        $sql = 'SELECT nombreCliente,apellidoCliente ,fechahoraFactura,direccionFactura FROM factura INNER JOIN (cliente) USING (idCliente) WHERE idFactura = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function getCantTypeProd()
    {
        $sql = 'SELECT COUNT(idProducto) as Cantidad, tipoProducto FROM producto INNER JOIN (tipoproducto) USING (idTipoProducto)  WHERE visibilidadProducto = 1 AND estadoProducto = 1 GROUP BY idTipoProducto ';
        $params = array(null);
        return Database::getRows($sql, $params);
    }

    public function getCantTypeEvent()
    {
        $sql = 'SELECT COUNT(idProducto) as Cantidad, tipoEvento FROM producto INNER JOIN (tipoevento) USING (idTipoEvento)  WHERE visibilidadProducto = 1 AND estadoProducto = 1 GROUP BY idTipoEvento  ';
        $params = array(null);
        return Database::getRows($sql, $params);
    }

    public function getMonthSales()
    {
        $sql = 'SELECT COUNT(idFactura) as Cantidad ,MONTH(fechahoraFactura) as Mes,YEAR(fechahoraFactura) as periodo FROM factura GROUP BY YEAR(fechahoraFactura), MONTH(`fechahoraFactura`) ORDER BY periodo ASC LIMIT 5';
        $params = array(null);
        return Database::getRows($sql, $params);
    }

    public function getMonthSales2()
    {
        $sql = 'SELECT FORMAT(SUM(detallefactura.cantidadProducto * producto.precioProducto),2) as Monto ,MONTH(fechahoraFactura) as Mes,YEAR(fechahoraFactura) as periodo FROM detallefactura INNER JOIN(factura) USING (idFactura) INNER JOIN(producto) USING (idProducto) GROUP BY YEAR(fechahoraFactura), MONTH(`fechahoraFactura`) ORDER BY periodo ASC LIMIT 5';
        $params = array(null);
        return Database::getRows($sql, $params);
    }
}
?>
