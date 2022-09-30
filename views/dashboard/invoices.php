<?php 
    // Se incluye la clase donde se encuentra el menú y el pie de página
    include '../../core/helpers/privatePages.php';
    // Se llama el método de la clase para que cargue el encabezados
    privatePages::header("Facturas");
?>
<div id="info-body" class="row ">
    <div class="col s12 m10">
        <h4>Facturas</h4>
    </div>
    <div class="col s12 m2">
        <a class="btn-floating btn-large waves-effect waves-light teal tooltipped dropdown-trigger"
            data-position="bottom" data-tooltip="Reportes" data-target='reporteFacturas'>
            <i class="material-icons">file_download</i>
        </a>
        <ul id='reporteFacturas' class='dropdown-content'>
            <li><a href="../../core/reports/dashboard/todayInvoices" target="_blank">Facturas de Hoy</a></li>
            <li class="divider" tabindex="-1"></li>
            <li><a href="../../core/reports/dashboard/earningInvoices" target="_blank">Facturas Pendientes</a></li>
        </ul>
    </div>
    <div class="col s12 m12 l12">
        <!--Tabla de Facturas-->
        <table class="highlight" id="tblFacturas">
            <thead class="black-text">
                <tr>
                    <th>CLIENTE</th>
                    <th>FECHA Y HORA</th>
                    <th>ESTADO</th>
                    <th>DIRECCIÓN</th>
                    <th>ACCIONES</th>
            </thead>
            <tbody style="font-size: 1.8vh;" id="tablaFacturas">
            </tbody>
        </table>
        <div id="link">

        </div>
    </div>
    <!--Modal para visualizar el detalle de factura -->
    <div id="verDetalle" class="modal modals">
        <div class="modal-content">
            <h4>Detalle Factura</h4>
            <div class="col s10 black-text offset-s1">
                <div class="row">
                    <table class="responsive-table highlight">
                        <thead>
                            <tr>
                                <th>PRODUCTO</th>
                                <th>CANTIDAD</th>
                                <th>SUBTOTAL</th>
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
</div>
<?php 
    privatePages::script('invoices.js');
?>