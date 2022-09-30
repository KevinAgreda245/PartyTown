<?php
    // Se incluye la clase donde se encuentra el menú y el pie de página
	include '../../core/helpers/publicPages.php';
	// Se llama el método de la clase para que cargue el encabezado y el menú
    publicPages::header('Formularios');
?>
<div class="container">
        <div class="row">
            <div class="col s12 m12">
                <div class="card" id="code">
                    <form id="recover" method="POST">
                        <input type="hidden" name="emailUser" id="emailUser"
                            value='<?php echo $_SESSION['correoUsuario']?>'>
                        <div class="card-content">
                            <span class="card-title">Recuperar cuenta</span>
                            <div class="row justify-center">
                                <div class='input-field col s12'>
                                    <p>Se te ha enviado un código al correo <?php echo $_SESSION['correoCliente'] ?>,
                                        la cual te servirá para desbloquear tu cuenta.</p>
                                </div>
                                <div class='input-field col s12 m6 offset-m3'>
                                    <i class="material-icons prefix">contact_mail</i>
                                    <input id='codeUser' type='text' name='codeUser' autocomplete="off" required>
                                    <label for='codeUser'>Código de verificación</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <div class="align-center">
                                <button type="submit" class="green waves-effect btn-small"><i
                                        class="material-icons left">contact_mail</i>Verificar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card" id="pass" hidden>
                    <form id="restorePass" method="POST">
                        <input type="hidden" name="emailUser2" id="emailUser2"
                            value='<?php echo $_SESSION['correoUsuario']?>'>
                        <div class="card-content">
                            <span class="card-title ">Restablecer contraseña</span>
                            <div class="row">
                                <div class='input-field col s12 m6'>
                                    <i class="material-icons prefix">lock</i>
                                    <input id='nuevaClave1' type='password' name='nuevaClave1' minlength="6"
                                        onfocusout="validatePassword('nuevaClave1')" class='validate' required>
                                    <label for='nuevaClave1'>Contraseña</label>
                                    <span class="helper-text" data-error="Contraseña Incorrecto"
                                        data-success="Contraseña Correcto"></span>
                                </div>
                                <div class='input-field col s12 m6'>
                                    <i class="material-icons prefix">lock</i>
                                    <input id='nuevaClave2' type='password' name='nuevaClave2'
                                        onfocusout="confirmPassword('nuevaClave2','nuevaClave1')" class='validate'
                                        required>
                                    <label for='nuevaClave2'>Confirmar contraseña</label>
                                    <span class="helper-text" data-error="Contraseñas no coinciden"
                                        data-success="Contraseñas coinciden"></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <div class="align-center">
                                <button type="submit" class="green waves-effect btn-small"><i
                                        class="material-icons left">contact_mail</i>Verificar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
	// Se llama el método de la clase para que cargue el pie de página
    publicPages::footer('recoverCustomer.js');
?>