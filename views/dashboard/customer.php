<?php 
    // Se incluye la clase donde se encuentra el menú y el pie de página
    include '../../core/helpers/privatePages.php';
    // Se llama el método de la clase para que cargue el encabezados
    privatePages::header("Cliente");
?>
<div id="info-body" class="row ">
    <!--Buscador de cliente-->
    <div class="col s12 m10">
        <h4>Clientes</h4>
    </div>
    <div class="col s12 m12 l12">
        <!--Tabla de Clientes-->
        <table class="highlight" id="tblCliente">
            <thead class="black-text">
                <tr>
                    <th>NOMBRE</th>
                    <th>APELLIDO</th>
                    <th>CORREO</th>
                    <th>TELÉFONO</th>
                    <th>ESTADO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody id="tablaCliente">
            </tbody>
        </table>
        <div id="link">

        </div>
    </div>
    <!--Modal para actualizar el estado del cliente-->
    <div id="actualizarCliente" class="modal">
        <div class="modal-content">
            <h4>Modificar Estado:</h4>
            <form method="post" id="modificarCliente">
                <input type="hidden" id="idCliente" name="idCliente">
                <div>
                    <div class="switch center-align">
                        <div class="row">
                            <label>Estado:</label>
                        </div>
                        <div class="row">
                            <label class="black-text">
                                <i class="material-icons">lock_outline</i>
                                <input id="actualizarEstado" type="checkbox" name="actualizarEstado" />
                                <span class="lever"></span>
                                <i class="material-icons">lock_open</i>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row center-align">
                    <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i
                            class="material-icons">cancel</i></a>
                    <button type="submit" class="btn waves-effect orange tooltipped" data-tooltip="Modificar"><i
                            class="material-icons">loop</i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php 
    privatePages::script('customer.js');
?>