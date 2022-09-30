<?php
    // Se incluye la clase donde se encuentra el menú y el pie de página
    include '../../core/helpers/privatePages.php';
    // Se llama el método de la clase para que cargue el encabezados
    privatePages::header("Registro del Primer Usuario");
?>

<body class="container teal darken-1">
    <!--Imagen del icono de Party Town-->
    <div class="section center">
        <img src="../../resources/img/public/Logo/icon.png" alt="Logo" width="150" height="200">
    </div>
    <div class="center-align">
        <h3 class="white-text">Registro de Primer Usuario</h3>
        <div class="row white">
            <form method="post" id="nuevoUsuario" enctype="multipart/form-data" autocomplete="off">
                <div class="input-field col s12 m6 l4 black-text">
                    <input id="nuevoNombre" name="nuevoNombre" type="text" autocomplete="off"
                        onfocusout="validateAlphabetic('nuevoNombre' ,1,50)" class="validate" required>
                    <label for="nuevoNombre">Nombre</label>
                    <span class="helper-text" data-error="Nombre Incorrecto" data-success="Nombre Correcto"></span>
                </div>
                <div class="input-field col s12 m6 l4 black-text">
                    <input id="nuevoApellido" name="nuevoApellido" type="text" autocomplete="off"
                        onfocusout="validateAlphabetic('nuevoApellido' ,1,50)" class="validate" required>
                    <label for="nuevoApellido">Apellido</label>
                    <span class="helper-text" data-error="Apellido Incorrecto" data-success="Apellido Correcto"></span>
                </div>
                <div class='input-field col s12 m6 l4'>
                    <input id='nuevoCorreo' type='email' autocomplete="off" onfocusout="validateEmail('nuevoCorreo')"
                        name='nuevoCorreo' class='validate' required>
                    <label for='nuevoCorreo'>Correo</label>
                    <span class="helper-text" data-error="Correo Incorrecto" data-success="Correo Correcto"></span>
                </div>
                <div class='input-field col s12 m6 l4'>
                    <input id='fechaNacimiento' type='text' autocomplete="off" name='fechaNacimiento'
                        class='validate datepicker' required>
                    <label for='fechaNacimiento'>Fecha de Nacimiento</label>
                    <span class="helper-text" data-error="Fecha de Nacimiento Incorrecto"
                        data-success="Fecha de Nacimiento Correcto"></span>
                </div>
                <div class='input-field col s12 m6 l4'>
                    <input id='nuevoTelefono' type='text' autocomplete="off" name='nuevoTelefono'
                        onfocusout="validatePhone('nuevoTelefono')" class='validate' required>
                    <label for='nuevoTelefono'>Teléfono</label>
                    <span class="helper-text" data-error="Teléfono Incorrecto" data-success="Teléfono Correcto"></span>
                </div>
                <div class="input-field col s12 m6 l4 black-text">
                    <select name="nuevoTipo" autocomplete="off" id="nuevoTipo" class='validate' required>
                        <option value="1" selected>Administrador</option>
                    </select>
                    <label for="nuevoTipo">Tipo de Usuario</label>
                    <span class="helper-text" data-error="Contraseña Incorrecto"
                        data-success="Contraseña Correcto"></span>
                </div>
                <div class='input-field col s12 m6 l4'>
                    <input id='nuevaClave1' autocomplete="off" type='password' name='nuevaClave1' minlength="8"
                        onfocusout="validatePassword('nuevaClave1')" class='validate' required>
                    <label for='nuevaClave1'>Contraseña</label>
                    <span class="helper-text" data-error="Contraseña Incorrecto"
                        data-success="Contraseña Correcto"></span>
                </div>
                <div class='input-field col s12 m6 l4'>
                    <input id='nuevaClave2' autocomplete="off" type='password' name='nuevaClave2'
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
                            <input class="file-path" autocomplete="off" id="imagen" name="imagen" type="text"
                                placeholder="Seleccione una imagen" onchange="validateImage('imagen')">
                            <span class="helper-text" data-error="No ha seleccionado una imagen"
                                data-success="Imagen Seleccionado"></span>
                        </div>
                    </div>
                    <div class="card-action center-align">
                        <button type="submit" class="green waves-effect btn-small"><i
                                class="material-icons left">save</i>Registrar</button>
                    </div>
            </form>
        </div>




    </div>
    <div class="card-action">

    </div>
    </form>
    </div>
    </div>
    </div>
    <?php
    privatePages::script('register.js');
?>