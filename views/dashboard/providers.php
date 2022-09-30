<?php 
     // Se incluye la clase donde se encuentra el menú y el pie de página
    include '../../core/helpers/privatePages.php';
    // Se llama el método de la clase para que cargue el encabezado
    privatePages::header("Proveedores");
?>
<div id="info-body" class="row ">
    <div class="col s12 m10">
        <h4>Gestión de Proveedor</h4>
    </div>
    <div class="col s12 m2">
        <div class="row">
            <div class="col 6">
                <a class="btn-floating btn-large waves-effect waves-light red modal-trigger tooltipped" data-position="bottom"
                    data-tooltip="Agregar" href="#agregarProveedor"><i class="material-icons">add</i></a>
            </div>
            <div class="col 6">
                <a class="btn-floating btn-large waves-effect waves-light teal tooltipped" data-position="bottom"
                    data-tooltip="Reporte" href="../../core/reports/dashboard/providers.php" target="_blank"><i
                        class="material-icons">file_download</i></a>
            </div>
        </div>
    </div>
    <div class="col s12 m12 l12">
        <!--Tabla de proveedores-->
        <table class="highlight" id="tblProveedor">
            <thead class="black-text">
                <tr>
                    <th>NOMBRE</th>
                    <th>TELÉFONO</th>
                    <th>FOTO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody id="tablaProveedor">
            </tbody>
        </table>
        <div id="link">
        
        </div>
    </div>
    <!-- MODALES -->
    <!--Modal para agregar un nuevo proveedor-->
    <div id="agregarProveedor" class="modal modals">
        <div class="modal-content">
            <h4>Agregar Proveedor</h4>
            <form method="post" id="nuevoProveedor" enctype="multipart/form-data">
                <div class="row">
                    <div class="input-field col s12 m6 black-text">
                        <input id="nuevoNombre" name="nuevoNombre" type="text" onfocusout="validateAlphanumeric('nuevoNombre',1,50)" class="validate " required>
                        <label for="nuevoNombre">Nombre</label>
                        <span class="helper-text" data-error="Nombre Incorrecto"
                                    data-success="Nombre Correcto"></span>
                    </div>
                    <div class='input-field col s12 m6'>
                        <input id="nuevoTelefono" type="text" name="nuevoTelefono" onfocusout="validatePhone('nuevoTelefono')" class="validate " required>
                        <label for="nuevoTelefono">Teléfono</label>
                        <span class="helper-text" data-error="Teléfono Incorrecto FORMATO: XXXX-XXXX"
                                    data-success="Teléfono Correcto"></span>
                    </div>
                    <div class='input-field col s12 m6'>
                        <input id="nuevoCorreo" type="email" name="nuevoCorreo" onfocusout="validateEmail('nuevoCorreo')" class="validate " required>
                        <label for='nuevoCorreo'>Correo</label>
                        <span class="helper-text" data-error="Correo Incorrecto"
                                    data-success="Correo Correcto"></span>
                    </div>
                    <div class="col s12 m6">
                        <div class="file-field input-field">
                            <div class="btn tooltipped" data-position="bottom" data-tooltip="Agregar Imagen">
                                <span><i class="material-icons">image</i></span>
                                <input id="nuevaFoto" type="file" name="nuevaFoto">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path " id="imagen2" name="imagen2" type="text"
                                    placeholder="Seleccione una imagen" onchange="validateImage('imagen2')">
                                <span class="helper-text" data-error="No ha seleccionado una imagen"
                                    data-success="Imagen Seleccionado"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row center-align">
                    <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i class="material-icons">cancel</i></a>
                    <button type="submit" class="btn waves-effect green tooltipped" data-tooltip="Guardar"><i class="material-icons">save</i></button>
                </div>
            </form>
        </div>
    </div>
    <!--Modal para actualizar información del proveedor-->
    <div id="actualizarProveedor" class="modal modals">
        <div class="modal-content">
            <h4>Modificar Proveedor</h4>
            <form method="post" id="modificarProveedor" enctype="multipart/form-data">
                <input type="hidden" id="idProveedor" name="idProveedor">
                <input type="text" id="fotoProveedor" name="fotoProveedor">
                <div class="row">
                    <div class="input-field col s12 m6 black-text">
                        <input id="actualizarNombre" name="actualizarNombre" type="text" onfocusout="validateAlphanumeric('actualizarNombre',1,50)" class="validate" required>
                        <label for="actualizarNombre">Nombre</label>
                        <span class="helper-text" data-error="Nombre Incorrecto"
                                    data-success="Nombre Correcto"></span>
                    </div>
                    <div class='input-field col s12 m6'>
                        <input id="actualizarTelefono" type="text" name="actualizarTelefono" onfocusout="validatePhone('actualizarTelefono')" class="validate" required>
                        <label for='actualizarTelefono'>Teléfono</label>
                        <span class="helper-text" data-error="Teléfono Incorrecto FORMATO: XXXX-XXXX"
                                    data-success="Teléfono Correcto"></span>
                    </div>
                    <div class='input-field col s12 m6'>
                        <input id="actualizarCorreo" type="email" name="actualizarCorreo" onfocusout="validateEmail('actualizarCorreo')" class="validate" required>
                        <label for="actualizarCorreo">Correo</label>
                        <span class="helper-text" data-error="Correo Incorrecto"
                                    data-success="Correo Correcto"></span>
                    </div>
                    <div class="col s12 m6">
                        <div class="file-field input-field">
                            <div class="btn tooltipped" data-position="bottom" data-tooltip="Agregar Imagen">
                                <span><i class="material-icons">image</i></span>
                                <input id="actualizarFoto" type="file" name="actualizarFoto">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path " id="imagen2" name="imagen2" type="text"
                                    placeholder="Seleccione una imagen" onchange="validateImage('imagen2')">
                                <span class="helper-text" data-error="No ha seleccionado una imagen"
                                    data-success="Imagen Seleccionado"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row center-align">
                    <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i class="material-icons">cancel</i></a>
                    <button type="submit" class="btn waves-effect orange tooltipped" data-tooltip="Modificar"><i class="material-icons">loop</i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php 
     privatePages::script('providers.js');
?>