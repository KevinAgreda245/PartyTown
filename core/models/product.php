<?php 
class Product extends Validator
{
    //Declaración de propiedades
    private $id = null;
    private $nombre = null;
    private $descripcion = null;
    private $precio = null;
    private $cantidad = null;
    private $foto = null;
    private $ruta = "../../resources/img/public/products/";
    private $estado = null;
    private $tipo = null;
    private $evento = null;
    private $proveedor = null;
    private $comentario = null;
    private $valoracion = null;
    private $cliente = null;
    private $dirrecion = null;

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

    public function setNombre($value)
    {
        if ($this->validateAlphabetic($value,1,50)) {
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

    public function setDescripcion($value)
    {
        if ($this->validateAlphanumeric($value,1,100)) {
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

    public function setPrecio($value)
    {
        if($this->validateMoney($value)){
            $this->precio = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function setCantidad($value)
    {
        if($this->validateId($value)){
            $this->cantidad = $value;
            return true; 
        } else {
            return false;
        }
    }

    public function getCantidad()
    {
        return $this->cantidad;
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

    public function setTipo($value)
    {
        if($this->validateId($value)){
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

    public function setEvento($value)
    {
        if($this->validateId($value)){
            $this->evento = $value;
            return true; 
        } else {
            return false;
        }
    }

    public function getEvento()
    {
        return $this->evento;
    }

    public function setProveedor($value)
    {
        if($this->validateId($value)){
            $this->proveedor = $value;
            return true; 
        } else {
            return false;
        }
    }

    public function getProveedor()
    {
        return $this->proveedor;
    }

    public function setComentario($value)
    {
        if ($this->validateAlphanumeric($value,1,100)) {
            $this->comentario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getComentario()
    {
        return $this->comentario;
    }

    public function setValoracion($value)
    {
        if ($value >= 1 && $value <=5) {
            $this->valoracion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getValoracion()
    {
        return $this->valoracion;
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

    public function setDireccion($value){
        $this->dirrecion = $value;
        return true;
    }

    // Método para leer todos los producto
    public function readProduct()
	{
		$sql = 'SELECT idProducto,fotoProducto,nombreProducto,precioProducto,cantidadProducto,visibilidadProducto FROM producto  WHERE estadoProducto = ? ORDER BY visibilidadProducto DESC , nombreProducto ASC';
		$params = array($this->estado);
		return Database::getRows($sql, $params);
    }

    // Método para leer todos los tipos de producto
    public function readTypeProduct(){
        $sql = 'SELECT idTipoProducto,tipoProducto FROM tipoproducto WHERE estadoTipo = 1';
		$params = array(null);
		return Database::getRows($sql, $params);
    }

    // Método para leer todos los tipos de eventos
    public function readTypeEvent(){
        $sql = 'SELECT idTipoEvento,tipoEvento FROM tipoevento WHERE estadoEvento = 1';
		$params = array(null);
		return Database::getRows($sql, $params);
    }

    // Método para leer todos los proveedores
    public function readProviders(){
        $sql = 'SELECT idProveedor,nombreProveedor FROM proveedor WHERE estadoProveedor = 1';
		$params = array(null);
		return Database::getRows($sql, $params);
    }

    //Métodos para SCRUD
    //Método para crear un nuevo producto
    public function createProduct(){
        $sql = 'INSERT producto VALUE(NULL,?,?,?,?,?,1,1,?,?,?)';
        $params = array($this->nombre,$this->descripcion,$this->precio,$this->cantidad,$this->foto,$this->tipo,$this->evento,$this->proveedor);
        return Database::executeRow($sql, $params);
    }

    //Método para obtener la cantidad de un producto
    public function getQuantity(){
        $sql = 'SELECT idProducto,cantidadProducto FROM producto WHERE idProducto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Método para reabastecer un producto
    public function updateQuantity(){
        $sql = 'SET @p0 = ?; SET @p1 = ? ; CALL reabastecimientoProducto(@p0, @p1)';
        $params = array($this->id,$this->cantidad);
        return Database::executeRow($sql,$params);
    }

    //Método para obtener los todos los comentarios de un producto
    public function getComment(){
        $sql = 'SELECT idComentario ,nombreCliente, apellidoCliente, correoCliente, descripcionComentario, estadoComentario FROM comentarioproducto INNER JOIN cliente USING(idCliente) WHERE idProducto = ? ORDER BY estadoComentario DESC , nombreCliente ASC';
        $params = array($this->id);
        return Database::getRows($sql,$params);
    }

    //Método para obtener el estado de un comentario
    public function getStatusComment(){
        $sql = 'SELECT idComentario , estadoComentario, idProducto FROM comentarioproducto  WHERE idComentario = ?';
        $params = array($this->id);
        return Database::getRow($sql,$params);
    }

    //Método para modificar el estado de un comentario
    public function updateComment(){
        $sql = 'UPDATE comentarioproducto SET estadoComentario = ? WHERE idComentario = ?';
        $params = array($this->estado,$this->id);
        return Database::executeRow($sql,$params);
    }

    //Método para obtener todos las valoraciones de un producto
    public function getRating(){
        $sql = 'SELECT idValoracion , nombreCliente , apellidoCliente , correoCliente , valoracionProducto, estadoValoracion FROM valoracionproducto INNER JOIN cliente USING(idCliente) WHERE idProducto = ? ORDER BY estadoValoracion DESC, nombreCliente ASC';
        $params = array($this->id);
        return Database::getRows($sql,$params);
    }

    //Método para obtener el estado de una valoración de un producto
    public function getStatusRating(){
        $sql = 'SELECT idValoracion , estadoValoracion, idProducto FROM valoracionproducto  WHERE idValoracion = ?';
        $params = array($this->id);
        return Database::getRow($sql,$params);
    }

    //Método para modificar el estado de una valoración de un producto
    public function updateRating(){
        $sql = 'UPDATE valoracionproducto SET estadoValoracion = ? WHERE idValoracion = ?';
        $params = array($this->estado,$this->id);
        return Database::executeRow($sql,$params);
    }

    //Método para obtener la información de un producto
    public function getProduct(){
        $sql = 'SELECT idProducto , nombreProducto , descripcionProducto , precioProducto , fotoProducto , visibilidadProducto , idTipoProducto ,idTipoEvento , idProveedor FROM producto WHERE idProducto = ?';
        $params = array($this->id);
        return Database::getRow($sql,$params);
    }

    //Método para modificar la información de un producto
    public function updateProduct(){
        $sql = 'UPDATE producto SET nombreProducto = ? , descripcionProducto = ? , precioProducto = ? , fotoProducto = ? , visibilidadProducto = ? , idTipoProducto = ? , idTipoEvento = ? , idProveedor = ? WHERE idProducto = ?';
        $params = array($this->nombre, $this->descripcion, $this->precio, $this->foto, $this->estado, $this->tipo, $this->evento, $this->proveedor, $this->id);
        return Database::executeRow($sql,$params);
    }

    //Método para activar y desactivar el producto
    public function actProduct(){
        $sql = 'UPDATE producto SET estadoProducto = ? WHERE idProducto = ?';
        $params = array($this->estado,$this->id);
        return Database::executeRow($sql,$params);
    }

    //Método para obtener los productos de una categoria
    public function readProductType(){
        $sql = 'SELECT idProducto,fotoProducto,nombreProducto, descripcionProducto,precioProducto,cantidadProducto FROM producto  WHERE idTipoProducto = ? AND estadoProducto = 1 AND visibilidadProducto = 1 ORDER BY nombreProducto ASC';
        $params = array($this->tipo);
        return Database::getRows($sql,$params);
    }

    public function searchProductType($value){
        $sql = 'SELECT idProducto,fotoProducto,nombreProducto, descripcionProducto,precioProducto,cantidadProducto FROM producto  WHERE (nombreProducto LIKE ? OR descripcionProducto LIKE ?) AND idTipoProducto = ? AND estadoProducto = 1 AND visibilidadProducto = 1 ORDER BY nombreProducto ASC';
        $params = array("%$value%", "%$value%", $this->tipo);
        return Database::getRows($sql,$params);
    }

    //Método para obtener los productos de una Evento
    public function readProductEvents(){
        $sql = 'SELECT idProducto,fotoProducto,nombreProducto, descripcionProducto,precioProducto,cantidadProducto FROM producto  WHERE idTipoEvento = ? AND estadoProducto = 1 AND visibilidadProducto = 1 ORDER BY nombreProducto ASC';
        $params = array($this->evento);
        return Database::getRows($sql,$params);
    }

    /* Obtiene los productos de acuerdo a una búsqueda por nombre, descripcion o tipo de evento */
    public function searchProductEvents($value){
        $sql = 'SELECT idProducto,fotoProducto,nombreProducto, descripcionProducto,precioProducto,cantidadProducto FROM producto  WHERE (nombreProducto LIKE ? OR descripcionProducto LIKE ?) AND idTipoEvento = ? AND estadoProducto = 1 AND visibilidadProducto = 1 ORDER BY nombreProducto ASC';
        $params = array("%$value%", "%$value%", $this->evento);
        return Database::getRows($sql,$params);
    }

    public function detailsProduct(){
        $sql = 'SELECT idProducto,fotoProducto,nombreProducto, descripcionProducto,precioProducto,cantidadProducto FROM producto  WHERE idProducto = ?';
        $params = array($this->id);
        return Database::getRow($sql,$params);
    }

    /* Obtiene los comentarios del producto */
    public function getCommentProduct(){
        $sql = 'SELECT nombreCliente, apellidoCliente, descripcionComentario FROM comentarioproducto INNER JOIN cliente USING(idCliente) WHERE idProducto = ? AND estadoComentario = 1 ORDER BY idCliente DESC';
        $params = array($this->id);
        return Database::getRows($sql,$params);
    }

    /* Crea un nuevo comentario de producto */
    public function createCommentProduct(){
        $sql = 'INSERT INTO comentarioproducto VALUES(NULL,?,?,?,1)';
        $params = array($this->id,$this->cliente,$this->comentario);
        return Database::executeRow($sql,$params);
    }

    /* Obtiene el rating del prod */
    public function getRatingProduct(){
        $sql='SELECT AVG(valoracionProducto) as valoracion FROM valoracionProducto WHERE idProducto = ?';
        $params = array($this->id);
        return Database::getRow($sql,$params);
    }

    /* Crea un rating para prod */
    public function createRatingProdcut(){
        $sql = 'INSERT INTO valoracionproducto VALUES(NULL,?,1,?,?)';
        $params = array($this->valoracion,$this->id,$this->cliente);
        return Database::executeRow($sql,$params);
    }

    /* Inser    ta a la tabla prefactura (para carrito de compra */
    public function insertPre(){
        $sql = 'INSERT INTO prefactura VALUES(NULL,?,?,?)';
        $params = array($this->cliente,$this->id,$this->cantidad);
        return Database::executeRow($sql,$params);
    }

    public function deletePre(){
        $sql = 'DELETE FROM prefactura WHERE idCliente = ?';
        $params = array($this->cliente);
        return Database::executeRow($sql,$params);
    }

    public function getPre(){
        $sql='SELECT idProducto,nombreProducto, descripcionProducto, precioProducto,fotoProducto, prefactura.cantidadProducto as cant FROM prefactura INNER JOIN producto USING(idProducto) WHERE idCliente = ?';
        $params = array($this->cliente);
        return Database::getRows($sql,$params);
    }

    public function deletePrePro(){
        $sql = 'DELETE FROM prefactura WHERE idCliente = ? AND idProducto = ?';
        $params = array($this->cliente,$this->id);
        return Database::executeRow($sql,$params);
    }

    public function createInvoices(){
        $sql = 'INSERT INTO factura VALUES(NULL,(SELECT NOW()),?,0,0,?)';
        $params = array($this->dirrecion,$this->cliente);
        return Database::executeRow($sql,$params);
    }

    public function getLastInvoices(){
        $sql = 'SELECT idFactura FROM `factura` WHERE idCliente = ? ORDER BY idFactura DESC LIMIT 1';
        $params = array($this->cliente);
        $data = Database::getRow($sql, $params);
		if ($data) {
            $this->cliente = $data['idFactura'];
            return true;
        } else{
            return false;
        }
    }

    public function createDetailsInvoices(){
        $sql = 'INSERT INTO detallefactura VALUES(NULL,?,?,?)';
        $params = array($this->cliente,$this->id,$this->cantidad);
        Database::executeRow($sql,$params);
    }

    public function getSalesThroughTime(){
        $sql = 'SELECT f.idFactura, FORMAT(SUM(p.precioProducto * df.cantidadProducto), 2) AS Vendido, f.fechahoraFactura AS Fecha FROM producto AS p INNER JOIN detallefactura AS df USING(idProducto) INNER JOIN factura AS f USING(idFactura) GROUP BY idFactura ';
        $params = array(null);
        Database::getRows($sql, $params);
    }

    public function getMostProduct()
    {
        $sql = 'SELECT SUM(d.cantidadProducto) as Venta, nombreProducto FROM detallefactura as d INNER JOIN (producto) USING (idProducto) GROUP BY (idProducto) ORDER BY Venta DESC LIMIT 3';
        $params = array(null);
        return Database::getRows($sql, $params);
    }

    public function getLessProduct()
    {
        $sql = 'SELECT SUM(d.cantidadProducto) as Venta, nombreProducto FROM detallefactura as d INNER JOIN (producto) USING (idProducto) GROUP BY (idProducto) ORDER BY Venta ASC LIMIT 3';
        $params = array(null);
        return Database::getRows($sql, $params);
    }

    public function getOneMostProduct()
    {
        $sql = 'SELECT SUM(d.cantidadProducto) as Venta, nombreProducto FROM detallefactura as d INNER JOIN (producto) USING (idProducto) GROUP BY (idProducto) ORDER BY Venta DESC LIMIT 1';
        $params = array(null);
        return Database::getRow($sql, $params);
    }

    public function getWinnings()
    {
        $sql = 'SELECT FORMAT(SUM(precioProducto * d.cantidadProducto), 2) as Ganancia FROM detallefactura as d INNER JOIN(producto) USING (idProducto)';
        $params = array(null);
        return Database::getRow($sql, $params);
    }

    public function getMostTypeProduct()
    {
        $sql = 'SELECT tipoproducto AS Tipo, SUM(detallefactura.cantidadProducto * producto.precioProducto) as Monto FROM detallefactura INNER JOIN(factura) USING(idFactura) INNER JOIN(producto) USING (idProducto) INNER JOIN (tipoproducto) USING (idTipoProducto) GROUP BY idTipoProducto  ORDER BY `Monto`  DESC LIMIT 1';
        $params = array(null);
        return Database::getRow($sql, $params);
    }

    public function getMostTypeEvent()
    {
        $sql = 'SELECT te.tipoEvento AS Tipo, FORMAT(SUM(p.precioProducto * df.cantidadProducto),2) AS TotalTipoEvento from detallefactura AS df INNER JOIN producto AS p USING(idProducto) INNER JOIN tipoevento AS te USING(idTipoEvento) INNER JOIN factura as f USING(idFactura) GROUP BY idTipoEvento ORDER BY TotalTipoEvento DESC LIMIT 1';
        $params = array(null);
        return Database::getRow($sql, $params);
    }

}