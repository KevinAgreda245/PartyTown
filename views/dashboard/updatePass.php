<?php 
    // Se incluye la clase donde se encuentra el menú y el pie de página
    include '../../core/helpers/privatePages.php';
    // Se llama el método de la clase para que cargue el encabezados
    privatePages::header("Cambiar contraseña");
?>

<body class="container teal darken-1">
    <!--Imagen del icono de Party Town-->
    <div class="section center">
        <img src="../../resources/img/public/Logo/icon.png" alt="Logo" width="150" height="200">
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12 m12">
                <div class="card">
                    <div class="card-content">
                        <div class="row" id="fase1">
                            <form id="email" method="POST">
                                <span class="card-title ">Correo del usuario</span>
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">mail</i>
                                    <input class="validate" type="email" name="email" id="email"
                                        onfocusout="validateEmail('email')" autocomplete="off" autofocus />
                                    <label for="email">Ingrese su correo</label>
                                    <span class="helper-text" data-error="Correo Incorrecto"
                                        data-success="Correo Correcto"></span>
                                </div>
                                <div class="card-action">
                                    <div class="align-center">
                                        <button type="submit" class="green waves-effect btn-small"><i
                                            class="material-icons left">contact_mail</i>Verificar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row" id="fase2" hidden>
                            <span class="card-title ">Cambiar contraseña</span>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php 
    privatePages::script('updatePass.js');
?>