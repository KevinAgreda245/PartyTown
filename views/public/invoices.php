<?php 
    // Se incluye la clase donde se encuentra el menú y el pie de página
	include '../../core/helpers/publicPages.php';
    // Se llama el método de la clase para que cargue el encabezado y el menú
    publicPages::header('ventasPT')
?>
<link rel="stylesheet" type="text/css" href="../../resources/css/material.min.css">
<link rel="stylesheet" type="text/css" href="../../resources/css/dataTables.material.min.css">
<div class="container">
    <div class="col s12 m10">
        <h4 class="lang" key="ventas">Mis ventas</h4>
    </div>
    <div class="col s12 m12 l12">
        <!--Tabla de Facturas-->
        <table class="highlight" id="tblFacturas">
            <thead class="black-text">
                <tr>
                    <th class="lang" key="f&h">FECHA Y HORA</th>
                    <th class="lang" key="dire">DIRECCIÓN</th>
                    <th class="lang" key="estado">ESTADO</th>
                    <th class="lang" key="acciones">ACCIONES</th>
            </thead>
            <tbody style="font-size: 1.8vh;" id="tablaFacturas">
            </tbody>
        </table>
    </div>
</div>
<!--Modal para visualizar el detalle de factura -->
<div id="verDetalle" class="modal modals">
    <div class="modal-content">
        <h4 class="lang" key="detfac">Detalle Factura</h4>
        <div class="col s10 black-text offset-s1">
            <div class="row">
                <table class="responsive-table highlight">
                    <thead>
                        <tr>
                            <th class="lang" key="prod">PRODUCTO</th>
                            <th class="lang" key="cant">CANTIDAD</th>
                            <th class="lang" key="sub">SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody id="tablaProductos">
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col s12 m6 offset-m6" id="total">
    
                </div>
            </div>
            <div class="row center-align">
                <button class="btn waves-effect blue tooltipped modal-close" data-tooltip="Salir"><i
                        class="material-icons">cancel</i></button>
            </div>
        </div>
    </div>
</div>
<?php 
    // Se llama el método de la clase para que cargue el pie de página
    publicPages::footer('invoices.js')
?>