<?php 
    // Se incluye la clase donde se encuentra el menú y el pie de página
    include '../../core/helpers/privatePages.php';
    // Se llama el método de la clase para que cargue el encabezado 
    privatePages::header("Tipos de Usuarios");
?>
<div id="info-body" class="row ">
    <div class="col s12 m10">
        <h4>Gestión de Tipo de Usuarios</h4>
    </div>
    <div class="col s12 m2">
        <div class="row">
            <a class="btn-floating btn-large waves-effect waves-light red modal-trigger tooltipped"
                data-position="bottom" data-tooltip="Agregar" href="#agregarTipo">
                <i class="material-icons">add</i>
            </a>
        </div>
    </div>
    <div class="col s12 m12 l12">
        <!--Tabla de Tipo de Producto-->
        <table class="highlight" id="tblTipo">
            <thead class="black-text">
                <tr>
                    <th>NOMBRE</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody id="tablaTipo">
            </tbody>
        </table>
        <div id="link">

        </div>
    </div>
    <!-- MODALES -->
    <!--Modal para agregar un nuevo tipo de producto-->
    <div id="agregarTipo" class="modal modals white">
        <div class="modal-content">
            <h4>Agregar Tipo de Usuario</h4>
            <form method="post" id="nuevoTipo">
                <div class="row">
                    <div class="input-field col s12 m6 offset-m3">
                        <input id="nuevoTipo" name="nuevoTipo" type="text"
                            onfocusout="validateAlphabetic('nuevoTipo',1,50)" class="validate " required>
                        <label for="nuevoTipo">Tipo de Usuario</label>
                        <span class="helper-text" data-error="Tipo de Usuario Incorrecto"
                            data-success="Tipo de Usuario Correcto"></span>
                    </div>
                    <div class="col s12 center-align">
                        <h5>Acciones</h5>
                    </div>
                </div>
                <div class="row" id="actionCreate">
                    
                </div>
                <div class="row center-align">
                    <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i
                            class="material-icons">cancel</i></a>
                    <button type="submit" class="btn waves-effect green tooltipped" data-tooltip="Guardar"><i
                            class="material-icons">save</i></button>
                </div>
            </form>
        </div>
    </div>
    <!--Modal para actualizar la informacón de un tipo de producto -->
    <div id="actualizarTipo" class="modal modals white">
        <div class="modal-content">
            <h4>Modificar Tipo de Usuario</h4>
            <form method="post" id="modificarTipo">
                <input type="hidden" name="idTipo" id="idTipo">
                <div class="row">
                    <div class="input-field col s12 m6 offset-m3">
                        <input id="actualizarNombre" name="actualizarNombre" type="text" class="validate" required>
                        <label for="actualizarNombre">Tipo de Usuario</label>
                        <span class="helper-text" data-error="Tipo de Usuario Incorrecto"
                            data-success="Tipo de Usuario Correcto"></span>
                    </div>
                    <div class="col s12 center-align">
                        <h5>Acciones</h5>
                    </div>
                </div>
                <div class="row" id="actionUpdate">
                    
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
    privatePages::script('userType.js')
?>