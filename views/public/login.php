<?php
    // Se incluye la clase donde se encuentra el menú y el pie de página
	include '../../core/helpers/publicPages.php';
	// Se llama el método de la clase para que cargue el encabezado y el menú
    publicPages::header('formularioPT');
?>
<!--Contenedor para los formularios-->
<div class='container' id='acceder'>
    <h4 class='center-align lang' key="acceder">ACCEDER</h4>
    <!--Pestañas para los formularios-->
    <ul class='tabs center-align light-green lighten-4'>
        <li class='tab'><a href='#cuenta' class="lang" key="crear">CREAR CUENTA</a></li>
        <li class='tab'><a href='#sesion' class="active lang" key="iniciar">INICIAR SESIÓN</a></li>
    </ul>
    <!-- Formulario para nueva cuenta -->
    <div id='cuenta'>
        <form method='post' id="registroCliente">
            <div class='row'>
                <div class='input-field col s12 m6'>
                    <i class='material-icons prefix'>account_box</i>
                    <input id='nombres' type='text' name='nombres' onfocusout="validateAlphabetic('nombres',1,50)"
                        class='validate' autocomplete="off" required>
                    <label for='nombres' class="lang" key="nombres">Nombres</label>
                    <span class="helper-text" data-error="Nombres Incorrecto" data-success="Nombres Correcto"></span>
                </div>
                <div class='input-field col s12 m6'>
                    <i class='material-icons prefix'>account_box</i>
                    <input id='apellidos' type='text' name='apellidos' onfocusout="validateAlphabetic('apellidos',1,50)"
                        class='validate ' autocomplete="off" required>
                    <label for='apellidos' class="lang" key="apellidos">Apellidos</label>
                    <span class="helper-text" data-error="Apellidos Incorrecto"
                        data-success="Apellidos Correcto"></span>
                </div>
                <div class='input-field col s12 m6'>
                    <i class='material-icons prefix'>assignment_ind</i>
                    <select id="genero" name="genero" class='validate' required>
                        <option value="0" disabled selected><span class="lang" key="seleccione">Seleccione su género</span></option>
                        <option value="1"><span class="lang" key="masculino">Masculino</span></option>
                        <option value="2"><span class="lang" key="femenino">Femenino</span></option>
                    </select>
                    <label for="genero" class="lang" key="genero">Género</label>
                    <span class="helper-text"></span>
                </div>
                <div class='input-field col s12 m6'>
                    <i class='material-icons prefix'>cake</i>
                    <input id="nacimiento" type="text" name="nacimiento" class="datepicker validate " autocomplete="off"
                        required>
                    <label for='nacimiento' class="lang" key="fecha">Fecha de Nacimiento</label>
                    <span class="helper-text" data-error="Fecha de Nacimiento Incorrecto"
                        data-success="Fecha de Nacimiento Correcto"></span>
                </div>
                <div class='input-field col s12 m6'>
                    <i class='material-icons prefix'>email</i>
                    <input id='correo' type='email' name='correo' onfocusout="validateEmail('correo')" class='validate '
                        autocomplete="off" required>
                    <label for='correo' class="lang" key="correo">Correo</label>
                    <span class="helper-text" data-error="Correo Incorrecto" data-success="Correo Correcto"></span>
                </div>
                <div class='input-field col s12 m6'>
                    <i class='material-icons prefix'>phone</i>
                    <input id='telefono' type='text' name='telefono' onfocusout="validatePhone('telefono')"
                        class='validate ' autocomplete="off" required>
                    <label for='telefono' class="lang" key="tel">Teléfono</label>
                    <span class="helper-text" data-error="Teléfono Incorrecto FORMATO: XXXX-XXXX"
                        data-success="Teléfono Correcto"></span>
                </div>
                <div class='input-field col s12 m6'>
                    <i class='material-icons prefix'>security</i>
                    <input id='clave1' type='password' name='clave1' onfocusout="validatePassword('clave1')"
                        class='validate ' required>
                    <label for='clave1' class="lang" key="contra">Contraseña</label>
                    <span class="helper-text" data-error="Contraseña Incorrecta"
                        data-success="Contraseña Correcta"></span>
                </div>
                <div class='input-field col s12 m6'>
                    <i class='material-icons prefix'>security</i>
                    <input id='clave2' type='password' name='clave2' onfocusout="confirmPassword('clave2','clave1')"
                        class='validate ' required>
                    <label for='clave2' class="lang" key="conf">Confirmar contraseña</label>
                    <span class="helper-text" data-error="Contraseñas no coinciden"
                        data-success="Contraseñas coinciden"></span>
                </div>
            </div>
            <div class='row center-align'>
                <div class="col s12 l5 offset-l4">
                    <div class="g-recaptcha" data-sitekey="6LcFcbQUAAAAAOgE0KCERTDDtwWoDvwr6q4oRLqu"></div>
                </div>
                <div class='col s12'>
                    <p>
                        <label>
                            <input type="checkbox" class="filled-in" id="term" name="term" />
                            <span><span class="lang" key="leido">He leído y acepto los</span> <a href='#terminos'
                                    class="modal-trigger lang" key="term">Términos y condiciones
                                    de uso</a></span>
                        </label>
                    </p>
                </div>
                <div class='col s12'>
                    <button type='submit' class='btn waves-effect blue tooltipped tool' key="registrar" data-position='right'
                        data-tooltip='Registrar'><i class='material-icons'>send</i></button>
                </div>
            </div>
        </form>
    </div>
    <!-- Formulario para iniciar sesión -->
    <div id='sesion'>
        <form method='post' id="loginCliente">
            <div class='row'>
                <div class='input-field col s12 m6 offset-m3'>
                    <i class='material-icons prefix'>email</i>
                    <input id='correoCliente' type='email' name='correoCliente'
                        onfocusout="validateEmail('correoCliente')" class='validate ' autocomplete="off" autofocus>
                    <label for='correoCliente' class="lang" key="correo">Correo</label>
                    <span class="helper-text" data-error="Correo Incorrecto" data-success="Correo Correcto"></span>
                </div>
                <div class='input-field col s12 m6 offset-m3'>
                    <i class='material-icons prefix'>security</i>
                    <input id='claveCliente' type='password' name='claveCliente'
                        onfocusout="validatePassword('claveClients')" class='validate '>
                    <label for='claveCliente' class="lang" key="contra">Contraseña</label>
                    <span class="helper-text" data-error="Contraseña Incorrecta"
                        data-success="Contraseña Correcta"></span>
                </div>
                <div class='col s12 m6 offset-m3'>
                    <label>
                        <a href="#Recuperar" class="blue-text text-darken-2 modal-trigger lang" key="olvidado">¿Haz
                            olvidado tu
                            contraseña?</a>
                    </label>
                </div>
            </div>
            <div class='row center-align'>
                <button type='submit' name='iniciar' class='btn waves-effect blue tooltipped tool' key="btnIS" data-position='right'
                    data-tooltip='Iniciar Sesión'><i class='material-icons'>send</i></button>
            </div>
        </form>
    </div>
    <div id="Recuperar" class="modal">
        <div class="modal-content">
            <div id="fase1">
                <h4 class="lang" key="recuperar">Recuperar contraseña</h4>
                <form id="emailClient2" method="POST">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">mail</i>
                        <input class="validate" type="email" name="email" id="email" onfocusout="validateEmail('email')"
                            autocomplete="off" autofocus />
                        <label for="email" class="lang" key="correo">Ingrese su correo</label>
                        <span class="helper-text" data-error="Correo Incorrecto" data-success="Correo Correcto"></span>
                    </div>
                    <div class="card-action">
                        <div class="align-center">
                            <button type="submit" class="green waves-effect btn-small"><i
                                    class="material-icons left">contact_mail</i><span class="lang" key="verificar">Verificar</span></button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="fase2" hidden>
                <form id="recover" method="post">
                    <input type="hidden" name="correoCliente2" id="correoCliente2">
                    <div class="card-content">
                        <h4 class="lang" key="recCuenta">Recuperar cuenta</h4>
                        <div class="row justify-center">
                            <div class='input-field col s12'>
                                <p><span class="lang" key="env">Se te ha enviado un código al correo</span> <?php echo $_SESSION['correoClient'] ?>,
                                    <span class="lang" key="des">la cual te servirá para desbloquear tu cuenta.</span></p>
                            </div>
                            <div class='input-field col s12 m6 offset-m3'>
                                <i class="material-icons prefix">contact_mail</i>
                                <input id='codeUser' type='text' name='codeUser' autocomplete="off" required>
                                <label for='codeUser' class="lang" key="codigo">Código de verificación</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <div class="align-center">
                            <button type="submit" class="green waves-effect btn-small"><i
                                    class="material-icons left">contact_mail</i><span class="lang" key="verificar">Verificar</span></button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="fase3" hidden>
                <form id="restorePass" method="POST">
                    <div class="card-content">
                        <h4 class="lang" key="restContra">Restablecer contraseña</h4>
                        <div class="row">
                            <div class='input-field col s12 m6'>
                                <i class="material-icons prefix">lock</i>
                                <input id='nuevaClave1' type='password' name='nuevaClave1' minlength="6"
                                    onfocusout="validatePassword('nuevaClave1')" class='validate' required>
                                <label for='nuevaClave1' class="lang" key="contra">Contraseña</label>
                                <span class="helper-text" data-error="Contraseña Incorrecto"
                                    data-success="Contraseña Correcto"></span>
                            </div>
                            <div class='input-field col s12 m6'>
                                <i class="material-icons prefix">lock</i>
                                <input id='nuevaClave2' type='password' name='nuevaClave2'
                                    onfocusout="confirmPassword('nuevaClave2','nuevaClave1')" class='validate' required>
                                <label for='nuevaClave2' class="lang" key="conf">Confirmar contraseña</label>
                                <span class="helper-text" data-error="Contraseñas no coinciden"
                                    data-success="Contraseñas coinciden"></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <div class="align-center">
                            <button type="submit" class="green waves-effect btn-small"><i
                                    class="material-icons left">contact_mail</i><span class="lang" key="verificar">Verificar</span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--Modal de Terminos y Condiciones-->
    <div id="terminos" class="modal">
        <div class="modal-content">
            <h4 class="center-align light-green lang" key="term">Términos y Condiciones</h4>
            <p class="lang" key="firstp">A través de la tienda de Party Town podrá adquirir productos para organizar
                fiestas o eventos.</p>
            <p><strong class='lang' key="envios">ENVIOS</strong></p>
            <p class="lang" key="e1">Enviamos los pedidos a cualquier lugar de El Salvador, se aplicará un costo adicional.</p>
            <p align="justify" class="lang" key="e2">La entrega se realizará en un plazo de aproximado 5 días laborales, para los envíos por
                mensajería. Si en caso no le llega en ese plazo de tiempo, por favor contactarsé con PartyTown en
                cualquier medio
                que está en la página de Contáctenos, también solo tiene 1 días hábil después de hecho la compra para
                cancelar su
                pedido, si no lo cancela se toma que quiere el producto y se rige a nuestra normas.</p>
            <p><strong class='lang' key="impuestos">IMPUESTOS</strong></p>
            <p align="justify" class="lang" key="i1">Todos los artículos que aparecen en la Tienda Party Town, incluyen el IVA correspondiente
                en El
                Salvador.</p>
            <p><strong class='lang' key="formas">FORMA DE PAGO</strong></p>
            <p align="justify" class="lang" key="f1">El pago del producto en la tienda online se hará con las tarjetas VISA y MASTERCARD. El
                número de
                su tarjeta se enviará a través de un sistema bancario de alta seguridad para comprobar su validez y
                hacer el cobro.
                Sólo guardaremos los datos de la tarjeta hasta que hayamos gestionado su pedido.</p>
            <p><strong class='lang' key="gastos">GASTOS DE ENVÍO</strong></p>
            <p align="justify" class="lang" key="g1">Los precios citados no incluyen los gastos de envío dentro de territorio nacional. Así
                que se le
                aumentará al precio los gastos del envío, lo cual el aumento varía depende al lugar donde se dejará la
                venta.Este
                es un importe adicional que no está contemplado en el total que se indicará en el detalle de pedido.</p>
            <p><strong class='lang' key="garantia">GARANTÍA</strong></p>
            <p align="justify" class="lang" key="g2">Dispone de un plazo de 3 días hábiles para devolver los productos una vez recibidos.
                Cambiaremos
                el artículo o, si lo prefiere, le devolveremos el dinero, con talón o mediante ingreso en cuenta
                bancaria, solo sí
                se demustra que el producto venía con defectos de fábrica.</p>
            <p><strong class='lang' key="contacto">CONTACTO</strong></p> 
            <p align="justify">Si desea alguna información adicional, puede ponerse en contacto con nosotros a través de
                los
                números 7892-1343 y 7892-1232 o al correo electrónico gerencia@partytown.com</p>
        </div>
        <div class="modal-footer">
            <a onclick="checked()" class="modal-close waves-effect waves-green btn-flat"><span class="lang" key="acepto">Acepto</span></a>
        </div>
    </div>
</div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php
	// Se llama el método de la clase para que cargue el pie de página
    publicPages::footer('login.js');
?>