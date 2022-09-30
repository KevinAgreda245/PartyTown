<?php
    // Se incluye la clase donde se encuentra el menú y el pie de página
    include '../../core/helpers/privatePages.php';
    // Se llama el método de la clase para que cargue el encabezados
    privatePages::header("Usuario");
?>
<div id="info-body" class="row">
    <!--Buscador de usuario-->
    <div class="col s12 m10">
        <h4>Gestión de Usuario</h4>
    </div>
    <div class="col s12 m2">
        <a class="btn-floating btn-large waves-effect waves-light red modal-trigger tooltipped" data-position="bottom"
            data-tooltip="Agregar" href="#agregarUsuario"><i class="material-icons">add</i></a>
    </div>
    <div class="col s12 m12 l12">
        <table class="highlight" id="tblUsuario">
            <thead class="black-text">
                <tr>
                    <th>NOMBRE</th>
                    <th>APELLIDO</th>
                    <th>CORREO</th>
                    <th>TIPO DE USUARIO</th>
                    <th>FOTO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody id="tablaUsuario">
            </tbody>
        </table>
        <div id="link">

        </div>
    </div>
    <!-- MODALES -->
    <!--Modal agregar un usuario-->
    <div id="agregarUsuario" class="modal white modals">
        <div class="modal-content">
            <h4>Agregar Usuario</h4>
            <form method="post" id="nuevoUsuario" enctype="multipart/form-data">
                <div class="input-field col s12 m6 l4 black-text">
                    <input id="nuevoNombre" name="nuevoNombre" type="text"
                        onfocusout="validateAlphabetic('nuevoNombre' ,1,50)" class="validate" autocomplete="off" required>
                    <label for="nuevoNombre">Nombre</label>
                    <span class="helper-text" data-error="Nombre Incorrecto" data-success="Nombre Correcto"></span>
                </div>
                <div class="input-field col s12 m6 l4 black-text">
                    <input id="nuevoApellido" name="nuevoApellido" type="text"
                        onfocusout="validateAlphabetic('nuevoApellido' ,1,50)" class="validate" autocomplete="off" required>
                    <label for="nuevoApellido">Apellido</label>
                    <span class="helper-text" data-error="Apellido Incorrecto" data-success="Apellido Correcto"></span>
                </div>
                <div class='input-field col s12 m6 l4'>
                    <input id='nuevoCorreo' type='email' onfocusout="validateEmail('nuevoCorreo')" name='nuevoCorreo'
                        class="validate" autocomplete="off" required>
                    <label for='nuevoCorreo'>Correo</label>
                    <span class="helper-text" data-error="Correo Incorrecto" data-success="Correo Correcto"></span>
                </div>
                <div class='input-field col s12 m6 l4'>
                    <input id='fechaNacimiento' type='text' name='fechaNacimiento' class="validate datepicker"
                        autocomplete="off" required>
                    <label for='fechaNacimiento'>Fecha de Nacimiento</label>
                    <span class="helper-text" data-error="Fecha de Nacimiento Incorrecto"
                        data-success="Fecha de Nacimiento Correcto"></span>
                </div>
                <div class='input-field col s12 m6 l4'>
                    <input id='nuevoTelefono' type='text' name='nuevoTelefono'
                        onfocusout="validatePhone('nuevoTelefono')" class='validate' autocomplete="off" required>
                    <label for='nuevoTelefono'>Teléfono</label>
                    <span class="helper-text" data-error="Teléfono Incorrecto FORMATO: XXXX-XXXX"
                        data-success="Teléfono Correcto"></span>
                </div>
                <div class="input-field col s12 m6 l4 black-text">
                    <select name="nuevoTipo" id="nuevoTipo" class='validate' required>
                    </select>
                    <label for="nuevoTipo">Tipo de Usuario</label>
                    <span class="helper-text"></span>
                </div>
                <div class='input-field col s12 m6 l4'>
                    <input id='nuevaClave1' type='password' name='nuevaClave1' minlength="6"
                        onfocusout="validatePassword('nuevaClave1')" class='validate' required>
                    <input id='nuevaClave1' type='password' name='nuevaClave1' minlength="8"
                        onfocusout="validatePassword('nuevaClave1')" class='validate invalid' required>
                    <label for='nuevaClave1'>Contraseña</label>
                    <span class="helper-text" data-error="Contraseña Incorrecta"
                        data-success="Contraseña Correcta"></span>
                </div>
                <div class='input-field col s12 m6 l4'>
                    <input id='nuevaClave2' type='password' name='nuevaClave2'
                        onfocusout="confirmPassword('nuevaClave2','nuevaClave1')" class='validate' required>
                    <label for='nuevaClave2'>Confirmar contraseña</label>
                    <span class="helper-text" data-error="Contraseñas no coinciden"
                        data-success="Contraseñas coinciden"></span>
                </div>
                <div class="col s12 l4">
                    <div class="file-field input-field">
                        <div class="btn tooltipped" data-position="bottom" data-tooltip="Agregar Imagen">
                            <span><i class="material-icons">image</i></span>
                            <input id="nuevaFoto" type="file" name="nuevaFoto">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path  " id="imagen" name="imagen" type="text"
                                placeholder="Seleccione una imagen" onchange="validateImage('imagen')">
                            <span class="helper-text" data-error="No ha seleccionado una imagen"
                                data-success="Imagen Seleccionado"></span>
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
    <!--Modal para modificar usuario-->
    <div id="actualizarUsuario" class="modal modals">
        <div class="modal-content">
            <h4>Modificar Usuario</h4>
            <form method="post" id="modificarUsuario" enctype="multipart/form-data">
                <input type="hidden" id="idUsuario" name="idUsuario" />
                <input type="hidden" id="fotoUsuario" name="fotoUsuario" />
                <div class="input-field col s12 m6 l4 black-text">
                    <input id="actualizarNombre" name="actualizarNombre"
                        onfocusout="validateAlphabetic('actualizarNombre' ,1,50)" type="text" class="validate"
                        requiered>
                    <label for="actualizarNombre">Nombre</label>
                    <span class="helper-text" data-error="Nombre Incorrecto" data-success="Nombre Correcto"></span>
                </div>
                <div class="input-field col s12 m6 l4 black-text">
                    <input id="actualizarApellido" name="actualizarApellido"
                        onfocusout="validateAlphabetic('actualizarApellido' ,1,50)" type="text" class="validate"
                        requiered>
                    <label for="actualizarApellido">Apellido</label>
                    <span class="helper-text" data-error="Apellido Incorrecto" data-success="Apellido Correcto"></span>
                </div>
                <div class="input-field col s12 m6 l4 black-text">
                    <input id="actualizarCorreo" name="actualizarCorreo" onfocusout="validateEmail('actualizarCorreo')"
                        type="text" class="validate" requiered>
                    <label for="actualizarCorreo">Correo</label>
                    <span class="helper-text" data-error="Correo Incorrecto" data-success="Correo Correcto"></span>
                </div>
                <div class='input-field col s12 m6 l4'>
                    <input id='afechaNacimiento' type='text' name='afechaNacimiento' class='validate datepicker'
                        autocomplete="off" required>
                    <label for='afechaNacimiento'>Fecha de Nacimiento</label>
                    <span class="helper-text" data-error="Fecha de Nacimiento Incorrecto"
                        data-success="Fecha de Nacimiento Correcto"></span>
                </div>
                <div class='input-field col s12 m6 l4'>
                    <input id='actualizarTelefono' type='text' name='actualizarTelefono'
                        onfocusout="validatePhone('actualizarTelefono')" class='validate' required>
                    <label for='actualizarTelefono'>Teléfono</label>
                    <span class="helper-text" data-error="Teléfono Incorrecto FORMATO: XXXX-XXXX"
                        data-success="Teléfono Correcto"></span>
                </div>
                <div class="input-field col s12 m6 l4 black-text">
                    <select name="actualizarTipo" id="actualizarTipo"> </select>
                    <label for="type">Tipo de Usuario</label>
                    <span class="helper-text"></span>
                </div>
                <div class="col s12 m6 center-align" id="mostrarFoto">

                </div>
                <div class="col s12 m6">
                    <div class="file-field input-field">
                        <div class="btn tooltipped" data-position="bottom" data-tooltip="Agregar Imagen">
                            <span><i class="material-icons">image</i></span>
                            <input id="actualizarFoto" type="file" name="actualizarFoto">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path" id="imagen2" name="imagen2" type="text"
                                placeholder="Seleccione una imagen" onchange="validateImage('imagen2')">
                            <span class="helper-text" data-error="No ha seleccionado una imagen"
                                data-success="Imagen Seleccionado"></span>
                        </div>
                    </div>
                </div>
                <div class="col s12 center-align">
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
     privatePages::script("user.js");
?>