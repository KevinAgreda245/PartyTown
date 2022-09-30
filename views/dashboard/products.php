<?php 
    // Se incluye la clase donde se encuentra el menú y el pie de página
    include '../../core/helpers/privatePages.php';
    
    // Se llama el método de la clase para que cargue el encabezado
    privatePages::header("Productos");
    
?>
<div id="info-body" class="row ">
    <!--Buscador de producto-->
    <div class="col s12 m10">
        <h4>Gestión de Producto</h4>
    </div>
    <div class="col s12 m2">
        <a class="btn-floating btn-large waves-effect waves-light red modal-trigger tooltipped" data-position="bottom"
            data-tooltip="Agregar" href="#agregarProducto"><i class="material-icons">add</i></a>
    </div>
    <div class="col s12 m12 l12">
        <table class="highlight" id="tblProducto">
            <thead class="black-text">
                <tr>
                    <th>NOMBRE</th>
                    <th>PRECIO</th>
                    <th>CANTIDAD</th>
                    <th>ESTADO</th>
                    <th>FOTO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody id="tablaProducto">
            </tbody>
        </table>
    </div>
    <div class="col s12">
        <div class="col 6" id="link">

        </div>
    </div>
    <!-- MODALS -->
    <!--Modal agregar un producto-->
    <div id="agregarProducto" class="modal modals">
        <div class="modal-content">
            <h4>Agregar Producto</h4>
            <form method="post" id="nuevoProducto" enctype="multipart/form-data">
                <div class="row">
                    <div class="input-field col s12 m6 l4 black-text">
                        <input id="nuevoNombre" name="nuevoNombre" type="text" class="validate "
                            onfocusout="validateAlphabetic('nuevoNombre',1,50)" required>
                        <label for="nuevoNombre">Nombre</label>
                        <span class="helper-text" data-error="Nombre Incorrecto" data-success="Nombre Correcto"></span>
                    </div>
                    <div class="input-field col s12 m6 l8 black-text">
                        <input id="nuevoDescripcion" name="nuevoDescripcion" type="text" class="validate "
                            onfocusout="validateAlphanumeric('nuevoDescripcion',1,50)" required>
                        <label for="nuevoDescripcion">Descripción</label>
                        <span class="helper-text" data-error="Descripción Incorrecta"
                            data-success="Descripción Correcta"></span>
                    </div>
                    <div class="input-field col s12 m6 l4 black-text">
                        <input id="nuevoPrecio" name="nuevoPrecio" type="number" class="validate " max="999.99"
                            min="0.01" step="any" onfocusout="validateMoney('nuevoPrecio')" required>
                        <label for="nuevoPrecio">Precio ($)</label>
                        <span class="helper-text" data-error="Precio Incorrecto" data-success="Precio Correcto"></span>
                    </div>
                    <div class="input-field col s12 m6 l4 black-text">
                        <input id="nuevoCantidad" name="nuevoCantidad" type="number" class="validate "
                            onfocusout="validateNumeric('nuevaCantidad')" required>
                        <label for="nuevoCantidad">Cantidad</label>
                        <span class="helper-text" data-error="Cantidad Incorrecta"
                            data-success="Cantidad Correcto"></span>
                    </div>
                    <div class="input-field col s12 m6 l4 black-text">
                        <select name="nuevoTipo" id="nuevoTipo" class='validate' required>
                        </select>
                        <label for="nuevoTipo">Tipo de Producto</label>
                        <span class="helper-text"></span>
                    </div>
                    <div class="input-field col s12 m6 l4 black-text">
                        <select name="nuevoEvento" id="nuevoEvento" class='validate' required>
                        </select>
                        <label for="nuevoEvento">Tipo de Evento</label>
                        <span class="helper-text"></span>
                    </div>
                    <div class="input-field col s12 m6 l4 black-text">
                        <select name="nuevoProveedor" id="nuevoProveedor" class='validate' required>
                        </select>
                        <label for="nuevoProveedor">Proveedor</label>
                        <span class="helper-text"></span>
                    </div>
                    <div class="col s12 m6 l4">
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
    <!--Modal para reabastecer el producto-->
    <div id="reabastecerProducto" class="modal white">
        <div class="modal-content">
            <h4>Reabastecer Producto</h4>
            <form method="post" id="modificarCantidad">
                <input type="hidden" id="idProducto" name="idProducto" />
                <div class="row">
                    <div class="col s12 m6 l6 black-text">
                        <h5 id="cantidadProducto"></h5>
                    </div>
                    <div class="input-field col s12 m6 black-text">
                        <input id="actualizarCantidad" name="actualizarCantidad" type="number" class="validate "
                            max="999" min="1" step="any" onfocusout="validateNumeric('actualizarCantidad')" required>
                        <label for="actualizarCantidad">Cantidad</label>
                        <span class="helper-text" data-error="Cantidad Incorrecta"
                            data-success="Cantidad Correcto"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 center-align">
                        <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i
                                class="material-icons">cancel</i></a>
                        <button type="submit" class="btn waves-effect teal tooltipped" data-tooltip="Agregar"><i
                                class="material-icons">add</i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--Modal para visualizar los comentarios del producto-->
    <div id="verComentarios" class="modal">
        <div class="modal-content">
            <h4>Comentarios</h4>
            <div class="row" id="comentarios">
            </div>
            <div class="row center-align">
                <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i
                        class="material-icons">cancel</i></a>
            </div>
        </div>
    </div>
    <!--Modal para actualizar los comentarios del producto-->
    <div id="actualizarComentarios" class="modal">
        <div class="modal-content">
            <h4>Modificar Estado:</h4>
            <form method="post" id="modificarComentario">
                <input type="hidden" id="idCom" name="idCom">
                <input type="hidden" id="idPro" name="idPro">
                <div>
                    <div class="switch center-align">
                        <div class="row">
                            <label>Estado:</label>
                        </div>
                        <div class="row">
                            <label class="black-text">
                                <i class="material-icons">visibility_off</i>
                                <input id="actualizarEstadoCom" type="checkbox" name="actualizarEstadoCom" />
                                <span class="lever"></span>
                                <i class="material-icons">visibility</i>
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
    <!--Modal para visualizar las valoraciones del producto-->
    <div id="verValoracion" class="modal">
        <div class="modal-content">
            <h4>Valoración</h4>
            <div class="row" id="valoracion">
            </div>
            <div class="row center-align">
                <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i
                        class="material-icons">cancel</i></a>
            </div>
        </div>
    </div>
    <!--Modal para actualizar los comentarios del producto-->
    <div id="actualizarValoracion" class="modal">
        <div class="modal-content">
            <h4>Modificar Estado:</h4>
            <form method="post" id="modificarValoracion">
                <input type="hidden" id="idVal" name="idVal">
                <input type="hidden" id="idProd" name="idProd">
                <div>
                    <div class="switch center-align">
                        <div class="row">
                            <label>Estado:</label>
                        </div>
                        <div class="row">
                            <label class="black-text">
                                <i class="material-icons">visibility_off</i>
                                <input id="actualizarEstadoVal" type="checkbox" name="actualizarEstadoVal" />
                                <span class="lever"></span>
                                <i class="material-icons">visibility</i>
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
    <!--Modal para actualizar del producto-->
    <div id="actualizarProducto" class="modal white modals">
        <div class="modal-content">
            <h4>Modificar Producto</h4>
            <form method="post" id="modificarProducto" enctype="multipart/form-data">
                <input type="hidden" id="codProducto" name="codProducto" />
                <input type="hidden" id="fotoProducto" name="fotoProducto" />
                <div class="row">
                    <div class="input-field col s12 m6 l4 black-text">
                        <input id="actualizarNombre" name="actualizarNombre" type="text" class="validate"
                            onfocusout="validateAlphabetic('actualizarNombre',1,50)" required>
                        <label for="actualizarNombre">Nombre</label>
                        <span class="helper-text" data-error="Nombre Incorrecto" data-success="Nombre Correcto"></span>
                    </div>
                    <div class="input-field col s12 m6 l8 black-text">
                        <input id="actualizarDescripcion" name="actualizarDescripcion" type="text" class="validate"
                            onfocusout="validateAlphanumeric('actualizarDescripcion',1,100)" required>
                        <label for="actualizarDescripcion">Descripción</label>
                        <span class="helper-text" data-error="Descripción Incorrecta"
                            data-success="Descripción Correcta"></span>
                    </div>
                    <div class="input-field col s12 m6 l4 black-text">
                        <input id="actualizarPrecio" name="actualizarPrecio" type="number" max="999.99" min="0.01"
                            step="any" onfocusout="validateMoney('actualizarPrecio')" required>
                        <label for="actualizarPrecio">Precio ($)</label>
                        <span class="helper-text" data-error="Precio Incorrecto" data-success="Precio Correcto"></span>
                    </div>
                    <div class="input-field col s12 m6 l4 black-text">
                        <select name="actualizarTipo" id="actualizarTipo" class='validate' required>
                        </select>
                        <label for="actualizarTipo">Tipo de Producto</label>
                        <span class="helper-text" data-error="Descripción Incorrecta"
                            data-success="Descripción Correcta"></span>
                    </div>
                    <div class="input-field col s12 m6 l4 black-text">
                        <select name="actualizarEvento" id="actualizarEvento" class='validate' required>
                        </select>
                        <label for="actualizarEvento">Tipo de Evento</label>
                        <span class="helper-text" data-error="Descripción Incorrecta"
                            data-success="Descripción Correcta"></span>
                    </div>
                    <div class="input-field col s12 m6 l4 black-text">
                        <select name="actualizarProveedor" id="actualizarProveedor" class='validate' required>
                        </select>
                        <label for="actualizarProveedor">Proveedor</label>
                        <span class="helper-text" data-error="Descripción Incorrecta"
                            data-success="Descripción Correcta"></span>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="file-field input-field">
                            <div class="btn tooltipped" data-position="bottom" data-tooltip="Agregar Imagen">
                                <span><i class="material-icons">image</i></span>
                                <input id="actualizarFoto" type="file" name="actualizarFoto">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path" id="imagen2" name="imagen2" type="text"
                                    placeholder="Seleccione una imagen" onchange="validateImage('imagen2')">
                                <span class="helper-text" data-error="No ha seleccionado una imagen"
                                    data-success="Imagen Seleccionada"></span>
                            </div>
                        </div>
                    </div>
                    <div>
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
</div>
<?php 
     privatePages::script("product.js");
?>