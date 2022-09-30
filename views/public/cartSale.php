<?php
    // Se incluye la clase donde se encuentra el menú y el pie de página
    include '../../core/helpers/publicPages.php';
    // Se llama el método de la clase para que cargue el encabezado y el menú
    publicPages::header('carritoPT')
?>
<!--Contenedor donde se ubicará el detalle de la venta-->
<div class="container">
    <h3 class="lang" key="carrito">Carritos de Venta</h3>
    <h5 class="lang" key="prod">Productos</h5>
    <div class="row">
        <div class="col s12 m12 l8">
            <!--Container para ubicar los productos de la venta-->
            <div class="container-fluid">
                <div class="row" id="listProduct">
                    
                    
                </div>
            </div>
        </div>
        <div class="col s12 m6 l4 offset-m3">
            <!--Carta donde se muestra del detalle de la factura-->
            <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                    <span class="card-title"><b class="lang" key="factu">Facturación</b></span>
                    <div id="total">
                    </div>
                </div>
                <!--Botón para realizar el pago-->
                <div class="card-action">
                    <a class="btn waves-effect teal lighten-3 modal-trigger" href='#pagar'><i class="material-icons right">local_atm</i><span class="lang" key="pagar">Pagar</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Modal para asignar el tipo de pago-->
<div id="pagar" class="modal">
    <div class="modal-content">
        <h4 class="lang" key="realizar">Realizar Factura</h4>
        <form method='post' id="crearFactura">
            <div class='input-field col s12'>
                <i class='material-icons prefix'>location_on</i>
                <input type="text" id="direccion" name="direccion">
                <label for='direccion' class="lang" key="dir">Dirección</label>
            </div>
            <div class="row center-align">
                <a href="#" class="btn waves-effect grey tooltipped modal-close tool" key="cancelar" data-tooltip="Cancelar"><i
                        class="material-icons">cancel</i></a>
                <button type="submit" class="btn waves-effect green tooltipped tool" key="facturar" data-tooltip="Facturar"><i
                        class="material-icons">content_paste</i></button>
            </div>
        </form>
    </div>
</div>

<?php 
    // Se llama el método de la clase para que cargue el pie de página
    publicPages::footer('cartSale.js')
?>