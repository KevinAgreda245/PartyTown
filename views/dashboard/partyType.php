<?php 
    // Se incluye la clase donde se encuentra el menú y el pie de página
    include '../../core/helpers/privatePages.php';
    // Se llama el método de la clase para que cargue el encabezado
    privatePages::header("Tipos de Eventos");
?>
<div id="info-body" class="row">
    <div class="col s12 m10">
        <h4>Gestión de Tipo de Evento</h4>
    </div>
    <div class="col s12 m2">
        <div class="row">
            <div class="col 6">
                <a class="btn-floating btn-large waves-effect waves-light red modal-trigger tooltipped"
                    data-position="bottom" data-tooltip="Agregar" href="#agregarEvento"><i
                        class="material-icons">add</i></a>
            </div>
            <div class="col 6">
                <a class="btn-floating btn-large waves-effect waves-light teal tooltipped" data-position="bottom"
                    data-tooltip="Reporte" href="../../core/reports/dashboard/partyType.php" target="_blank"><i
                        class="material-icons">file_download</i></a>
            </div>
        </div>
    </div>
    <div class="col s12 m12 l12">
        <!--Tabla de Tipo de evento-->
        <table class="highlight" id="tblEvento">
            <thead class="black-text">
                <tr>
                    <th>NOMBRE</th>
                    <th>DESCRIPCIÓN</th>
                    <th>ESTADO</th>
                    <th>FOTO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody id="tablaEvento">
            </tbody>
        </table>
        <div id="link">

        </div>
    </div>
    <!-- MODALES -->
    <!--Modal para agregar un nuevo tipo de evento-->
    <div id="agregarEvento" class="modal modals">
        <div class="modal-content">
            <h4>Agregar Tipo de Evento</h4>
            <form method="post" id="nuevoEvento" enctype="multipart/form-data">
                <div class="row">
                    <div class="input-field col s12 m6 black-text">
                        <input id="nuevoTipo" name="nuevoTipo" type="text"
                            onfocusout="validateAlphabetic('nuevoTipo',1,50)" class="validate " required>
                        <label for="nuevoTipo">Tipo de Evento</label>
                        <span class="helper-text" data-error="Tipo de Evento Incorrecto"
                            data-success="Tipo de Evento Correcto"></span>
                    </div>
                    <div class="input-field col s12 m6 black-text">
                        <input id="nuevoDescripcion" name="nuevoDescripcion" type="text"
                            onfocusout="validateAlphanumeric('nuevoDescripcion',1,100)" class="validate "
                            required>
                        <label for="nuevoDescripcion">Descripción</label>
                        <span class="helper-text" data-error="Descripción Incorrecta"
                            data-success="Descripción Correcta"></span>
                    </div>
                    <div class="col s12 m6">
                        <div class="file-field input-field">
                            <div class="btn tooltipped" data-position="bottom" data-tooltip="Agregar Imagen">
                                <span><i class="material-icons">image</i></span>
                                <input id="nuevaFoto" type="file" name="nuevaFoto">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path " id="imagen" name="imagen" type="text"
                                    placeholder="Seleccione una imagen" onchange="validateImage('imagen')">
                                <span class="helper-text" data-error="No ha seleccionado una imagen"
                                    data-success="Imagen Seleccionado"></span>
                            </div>
                        </div>
                    </div>
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
    <!--Modal para agragr un nuevo tipo de evento-->
    <div id="actualizarEvento" class="modal modals">
        <div class="modal-content">
            <h4>Modificar Tipo de Evento</h4>
            <form method="post" id="modificarEvento" enctype="multipart/form-data">
                <input type="hidden" id="idEvento" name="idEvento">
                <input type="hidden" id="fotoEvento" name="fotoEvento">
                <div class="row">
                    <div class="input-field col s12 m6 black-text">
                        <input id="actualizarTipo" name="actualizarTipo" type="text"
                            onfocusout="validateAlphabetic('actualizarTipo',1,50)" class="validate" required>
                        <label for="actualizarTipo">Tipo de Evento</label>
                        <span class="helper-text" data-error="Tipo de Evento Incorrecto"
                            data-success="Tipo de Evento Correcto"></span>
                    </div>
                    <div class="input-field col s12 m6 black-text">
                        <input id="actualizarDescripcion" name="actualizarDescripcion"
                            onfocusout="validateAlphanumeric('actualizarDescripcion,1,100)'" type="text"
                            class="validate" required>
                        <label for="actualizarDescripcion">Descripción</label>
                        <span class="helper-text" data-error="Descripción Incorrecta"
                            data-success="Descripción Correcta"></span>
                    </div>
                    <div class="col s12 m4 center-align" id="mostrarFoto">

                    </div>
                    <div class="col s12 m4">
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
                    <div class="col s12 m4">
                        <div class="switch center-align">
                            <div class="row">
                                <label>Estado:</label>
                            </div>
                            <div class="row">
                                <label class="black-text">
                                    <i class="material-icons">visibility_off</i>
                                    <input id="actualizarEstado" type="checkbox" name="actualizarEstado" />
                                    <span class="lever"></span>
                                    <i class="material-icons">visibility</i>
                                </label>
                            </div>
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
    privatePages::script('partyType.js');
?>