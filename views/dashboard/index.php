<?php
    // Se incluye la clase donde se encuentra el menú y el pie de página
    include '../../core/helpers/privatePages.php';
    // Se llama el método de la clase para que cargue el encabezado
    privatePages::header("Login");
?>

<body class="teal darken-1">
    <!--Imagen del icono de Party Town-->
    <div class="section center">
        <img src="../../resources/img/public/Logo/icon.png" alt="Logo" width="150" height="200">
    </div>
    <div class="container">
        <div class="row center-align" id="preloader" hidden>
            <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-red-only center-align">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!--Contenedor para el Formulario de iniciar sesión-->
    <div class="container center valign-wrapper">
        <div class="grey lighten-4 row form z-depth-5">
            <div id="form">
                <form id="login" class="col s12" method="POST">
                    <div class="row">
                        <span><i class="large material-icons">account_circle</i><span>
                    </div>
                    <!--Entrada para el correo-->
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">mail</i>
                            <input class="validate" type="email" name="email" id="email"
                                onfocusout="validateEmail('email')" autocomplete="off" autofocus/>
                            <label for="email">Ingrese su correo</label>
                            <span class="helper-text" data-error="Correo Incorrecto"
                                data-success="Correo Correcto"></span>
                        </div>
                    </div>
                    <!--Entrada para la clave-->
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">lock</i>
                            <input type="password" name="password" id="password" />
                            <label for="password">Ingrese su contraseña</label>
                        </div>
                        <label>
                            <a href="updatePass.php" class="blue-text text-darken-2">¿Haz olvidado tu contraseña?</a>
                        </label>
                    </div>
                    <div class="row">
                        <button type="submit" name="btn_login"
                            class="col s12 btn btn-large waves-effect deep-orange darken-4">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php privatePages::script('index.js'); ?>