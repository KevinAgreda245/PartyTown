<?php
    /*Clase para el menu y el pie del sitio público*/
    class publicPages
    {
        /*Método que revise como parámetro el títulos y devuelve impreso el menú*/
        public static function header($key){
            session_start();
            print('
                <!DOCTYPE html>
                <html lang="es">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    './/<link rel="stylesheet" type="text/css" href="../../resources/css/material.min.css">
                    '<link rel="stylesheet" type="text/css" href="../../resources/css/materialize.min.css">
                    <link rel="stylesheet" type="text/css" href="../../resources/css/materializeIcon.css" rel="stylesheet">
                    <link rel="stylesheet" type="text/css" href="../../resources/css/dataTables.material.min.css">
                    <link rel="stylesheet" type="text/css" href="../../resources/css/responsive.jqueryui.min.css">
                    <link rel="stylesheet" type="text/css"href="../../resources/css/publicPages.css" rel="stylesheet">
                    <link rel="icon" href="../../resources/img/public/logo/icon.png" type="image/png" sizes="16x16">
                    <title class="lang" key="'.$key.'"></title>
                </head>
                <body class="light-green lighten-4">
                    <div class="navbar-fixed">
                    ');
                    if (isset($_SESSION['idCliente'])) {
                        require_once('../../core/helpers/validator.php');
                        require_once('../../core/helpers/database.php');
                        require '../../core/api/sessionClient2.php';
                        $filename = basename($_SERVER['PHP_SELF']);
                        if ($filename != 'login.php') {
                            print('
                                    <nav class="cyan lighten-2" role="navigation">
                                        <div class="nav-wrapper container">
                                            <a id="logo-container" href="index.php" class="brand-logo">
                                                <img class="responsive-img" src="../../resources/img/public/Logo/Logo.png" alt="Logo" width="160" height="25">
                                            </a>
                                            <ul class="right hide-on-med-and-down">
                                                <li><a class="lang" key="inicio" href="index">Inicio</a></li>
                                                <li><a class="lang" key="quienes" href="about">¿Quiénes Somos?</a></li>
                                                <li><a class="lang" key="contactenos" href="contact">Contáctanos</a></li>
                                                <li><a class="dropdown-trigger" href="#!" data-target="traslate"><span class="idioma">ES<span></a></li>
                                                <li><a href="cartSale"><i class="material-icons">add_shopping_cart</i></a></li>
                                                <li><a class="dropdown-trigger" href="#!" data-target="dropdown1"><i class="material-icons">account_circle</i></a></li>
                                            </ul>
                                            <ul id="traslate" class="dropdown-content">
                                                <li><a class="españolOnclick" onclick="showEs()">Español</a></li>
                                                <li><a class="englishOnclick" onclick="showEn()">English</a></li>
                                            </ul>
                                            <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                                        </div>
                                    </nav>
                                </div>
                                <ul id="traslate2" class="dropdown-content">
                                    <li><a class="españolOnclick" onclick="showEs()">Español</a></li>
                                    <li><a class="englishOnclick" onclick="showEn()">English</a></li>
                                </ul>
                                <ul id="dropdown1" class="dropdown-content">
                                    <li><a class="lang" key="ventas" href="invoices">Mis Ventas</a></li>
                                    <li><a class="lang" key="datos" href="user">Datos Personales</a></li>
                                    <li><a class="lang" key="cerrar" onclick="signOff()" href="#!">Cerrar Sesión</a></li>
                                </ul>
                                <ul id="nav-mobile" class="sidenav white">
                                    <li><a href="index"><i class="material-icons">home</i><span class="lang" key="inicio">Inicio</span></a></li>
                                    <li><a href="about"><i class="material-icons">store</i><span class="lang" key="quienes">¿Quiénes Somos?</span></a></li>
                                    <li><a href="contact"><i class="material-icons">phone</i><span class="lang" key="contactenos">Contáctanos</span></a></li>
                                    <li><a href="cartSale"><i class="material-icons">add_shopping_cart</i><span class="lang" key="carrito">Carrito de ventas<span></a></li>
                                    <li><a href="invoices"><i class="material-icons">payment</i><span class="lang" key="ventas">Mis Ventas</span></a></li>
                                    <li><a href="user"><i class="material-icons">account_circle</i><span class="lang" key="datos">Datos Personales</span></a></li>
                                    <li><a class="dropdown-trigger" href="#!" data-target="traslate2"><i class="material-icons">public</i><i class="material-icons right">keyboard_arrow_down</i><span class="idioma">ES<span></a></li>
                                    <li><a onclick="signOff()" href="#!"><i class="material-icons left">power_settings_new</i><span class="lang" key="cerrar">Cerrar Sesión<span></a></li>
                                </ul>

                        ');

                        } else {
                            header('location: index');
                        }
                    } else {
                        $filename = basename($_SERVER['PHP_SELF']);
                            if ($filename == 'cartSale.php' || $filename == 'user.php' || $filename == 'invoices.php') {
                                header('location: login');
                            } else {
                                print('
                                <nav class="cyan lighten-2" role="navigation">
                                    <div class="nav-wrapper container">
                                        <a id="logo-container" href="index.php" class="brand-logo">
                                            <img class="responsive-img" src="../../resources/img/public/Logo/Logo.png" alt="Logo" width="160" height="25">
                                        </a>
                                        <ul class="right hide-on-med-and-down">
                                            <li><a class="lang" key="inicio" href="index">Inicio</a></li>
                                            <li><a class="lang" key="quienes" href="about">¿Quiénes Somos?</a></li>
                                            <li><a class="lang" key="contactenos" href="contact">Contáctanos</a></li>
                                            <li><a class="dropdown-trigger" href="#!" data-target="traslate"><span class="idioma">ES<span></a></li>
                                            <li><a href="login"><i class="material-icons">account_circle</i></a></li>
                                        </ul>
                                        <ul id="traslate" class="dropdown-content">
                                            <li><a onclick="showEs()">Español</a></li>
                                            <li><a onclick="showEn()">English</a></li>
                                        </ul>
                                        <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                                    </div>
                                </nav>
                            </div>
                            <ul id="nav-mobile" class="sidenav white">
                                <li><img class="responsive-img" src="../../resources/img/public/Logo/Logo.png" alt="Logo" width="100" height="25"></li>
                                <li><a href="index"><i class="material-icons">home</i><span class="lang" key="inicio">Inicio</span></a></li>
                                <li><a href="about"><i class="material-icons">store</i>¿Quiénes Somos?</a></li>
                                <li><a href="contact"><i class="material-icons">phone</i>Contáctanos</a></li>
                                <li><a class="dropdown-trigger" href="#!" data-target="traslate2"><i class="material-icons">public</i><i class="material-icons right">keyboard_arrow_down</i><span class="idioma">ES<span></a></li>
                                <li><a href="login"><i class="material-icons">account_circle</i>Acceso</a></li>
                            </ul>
                            <ul id="traslate2" class="dropdown-content">
                                <li><a onclick="showEs()">Español</a></li>
                                <li><a onclick="showEn()">English</a></li>
                            </ul>
                    ');
                            }
                    }
        }
        /*Método que devuelve impreso el pie*/
        public static function footer($controllers){
            print('
                <footer class="page-footer cyan lighten-2">
                    <div class="container">
                        <div class="row">
                            <div class="col l6 s12">
                            <img class="responsive-img" src="../../resources/img/public/Logo/Logo.png" alt="Logo" width="250" height="25">
                                <p class="grey-text text-lighten-4 lang" align="justify" key="footer">Party Town como empresa busca hacer la vida del consumidor más fácil, al reunir en un sólo lugar todos los elementos que podrían considerarse como esenciales y/o básicos en una fiesta.
                                Ofreciendo todo en un mismo local, poniendo énfasis en una calidad consistentemente alta y precios razonablemente accesibles; para poder ofrecer al cliente una experiencia agradable, ligera y sin quitar el enfoque de su mente en una fiesta para recordar.
                                </p>
                            </div>
                            <div class="col l4 offset-l2 s12">
                                <h5 class="white-text lang" key="mapa">Mapa del Sitio</h5>
                                <ul>
                                    <li><a class="grey-text text-lighten-3 lang" key="inicio" href="index.php">Inicio</a></li>
                                    <li><a class="grey-text text-lighten-3 lang" key="quienes" href="about.php">¿Quienes Somos?</a></li>
                                    <li><a class="grey-text text-lighten-3 lang" key="contactenos" href="contact.php">Contáctenos</a></li>
                                    <li><a class="grey-text text-lighten-3 lang" key="preguntas" href="faq.php">Preguntas frecuentes</a></li>
                                    <li><a class="grey-text text-lighten-3 lang" key="IS&R" href="login.php">Iniciar Sesión y Registrarse</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="footer-copyright">
                        <div class="container">
                            © Party Town 2019 <span class="lang" key="derecho">Derecho de Autor<span>
                            <a class="grey-text text-lighten-4 right" >San Salvador, El Salvador, C.A</a>
                        </div>
                    </div>
                </footer>
                <script src="../../resources/js/jquery-3.3.1.min.js"></script>
                <script src="../../resources/js/materialize.min.js"></script>
                <script src="../../resources/js/sweetalert.min.js"></script>
                <script src="../../core/helpers/functions.js"></script>
                <script src="../../resources/js/initiators.js"></script>
                <script src="../../resources/js/traslate.js"></script>
                <script src="../../core/helpers/validator.js"></script>
                <script src="../../core/controllers/public/accounts.js"></script>');
            if($controllers == 'invoices.js'){
                print(
                    '
                        <script src="../../resources/js/moment.js"></script>
                        <script src="../../resources/js/MomentJslocales.min.js"></script>
                        <script src="../../resources/js/datatables.min.js"></script>
                        <script src="../../core/helpers/dataTable.js"></script>
                        <script src="../../resources/js/dataTables.material.min.js"></script>
                        <script src="../../resources/js/dataTables.responsive.min.js"></script>

                    ');
            }
            if($controllers != null){
                print(
                    '<script src="../../core/controllers/public/'.$controllers.'"></script>');
            }
            print('
            </footer>
        </body>

        </html>');
        }
    }
?>