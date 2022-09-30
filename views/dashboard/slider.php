<?php 
    // Se incluye la clase donde se encuentra el menú y el pie de página
    include '../../core/helpers/privatePages.php';
    // Se llama el método de la clase para que cargue el encabezado
    privatePages::header("Deslizador");
?>
<div id="info-body" class="row">
    <!--Buscador de usuario-->
    <div class="col s12 m10">
        <h4>Gestión del Deslizador</h4>
    </div>
    <div class="col s12 m2">
        <a class="btn-floating btn-large waves-effect waves-light red modal-trigger tooltipped" data-position="bottom"
            data-tooltip="Agregar" href="#agregarSlider"><i class="material-icons">add</i></a>
    </div>
    <div class="col s12 m12 l12">
        <!--Tabla de las imagenes que se encuentra en el slider-->
        <table class="highlight" id="tblSlider">
            <thead class="black-text">
                <tr>
                    <th>TÍTULO</th>
                    <th>SUBTÍTULO</th>
                    <th>ESTADO</th>
                    <th>FOTO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody id="tablaSlider">
            </tbody>
        </table>
        <div id="link">

        </div>
    </div>
    <!-- MODALES -->
    <!--Modal para agregar imagenes al slider-->
    <div id="agregarSlider" class="modal modals">
        <div class="modal-content">
            <h4>Agregar Deslizador</h4>
            <form method="post" id="nuevoSlider" enctype="multipart/form-data">
                <div class="row">
                    <div class="input-field col s12 m6 black-text">
                        <input id="nuevoTitulo" name="nuevoTitulo" type="text"
                            onfocusout="validateAlphanumeric('nuevoTitulo',1,50)" class="validate " required>
                        <label for="nuevoTitulo">Título</label>
                        <span class="helper-text" data-error="Título Incorrecto" data-success="Título Correcto"></span>
                    </div>
                    <div class="input-field col s12 m6 black-text">
                        <input id="nuevoSubtitulo" name="nuevoSubtitulo" type="text"
                            onfocusout="validateAlphanumeric('nuevoSubtitulo',1,50)" class="validate " required>
                        <label for="nuevoSubtitulo">Subtítulo</label>
                        <span class="helper-text" data-error="Subtítulo Incorrecto"
                            data-success="Subtítulo Correcto"></span>
                    </div>
                    <div class="col s12 m6">
                        <div class="file-field input-field">
                            <div class="btn tooltipped" data-position="bottom" data-tooltip="Agregar Imagen">
                                <span><i class="material-icons">image</i></span>
                                <input id="nuevaFoto" type="file" name="nuevaFoto">
                                <span class="helper-text" data-error="No ha seleccionado una imagen"
                                    data-success="Imagen Seleccionado"></span>
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
    <!--Modal para actualizar las imagenes del slider-->
    <div id="actualizarSlider" class="modal modals">
        <div class="modal-content">
            <h4>Modificar Deslizador</h4>
            <form method="post" id="modificarSlider" enctype="multipart/form-data">
                <input type="hidden" id="idSlider" name="idSlider" />
                <input type="hidden" id="fotoSlider" name="fotoSlider" />
                <div class="row">
                    <div class="input-field col s12 m6 black-text">
                        <input id="actualizarTitulo" name="actualizarTitulo" type="text"
                            onfocusout="validateAlphanumeric('actualizarSubtitulo',1,50)" class="validate" requiered>
                        <label for="actualizarTitulo">Título</label>
                        <span class="helper-text" data-error="Titulo Incorrecto" data-success="Título Correcto"></span>
                    </div>
                    <div class="input-field col s12 m6 black-text">
                        <input id="actualizarSubtitulo" name="actualizarSubtitulo" type="text"
                            onfocusout="validateAlphanumeric('actualizarSubtitulo',1,50)" class="validate" requiered>
                        <label for="actualizarSubtitulo">Subtítulo</label>
                        <span class="helper-text" data-error="Subtítulo Incorrecto"
                            data-success="Subtítulo Correcto"></span>
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
                    <div class="col s12 m4 center-align">
                        <div class="switch">
                            <label>Estado:</label>
                            <label class="black-text">
                                <i class="material-icons">visibility_off</i>
                                <input id="actualizarEstado" type="checkbox" name="actualizarEstado" />
                                <span class="lever"></span>
                                <i class="material-icons">visibility</i>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 center-align">
                        <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i
                                class="material-icons">cancel</i></a>
                        <button type="submit" class="btn waves-effect orange tooltipped" data-tooltip="Modificar"><i
                                class="material-icons">loop</i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php 
    privatePages::script('slider.js');
?>