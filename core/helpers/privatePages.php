<?php
    /*Clase para el menú y el pie del sitio privado*/
    class privatePages
    {
        /*Método que revise como parámetro el títulos y devuelve impreso el menú*/
        public static function header($title){
            session_start();
            print('
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <title> Dashboard | '.$title.'</title>
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <script src="../../resources/js/chart.min.js"></script>
                <link rel="stylesheet" type="text/css" href="../../resources/css/materialize.min.css">
                <link rel="stylesheet" type="text/css" href="../../resources/css/material.min.css">
                <link rel="stylesheet" type="text/css" href="../../resources/css/dataTables.material.min.css">
                <link rel="stylesheet" type="text/css" href="../../resources/css/responsive.jqueryui.min.css">
                <link rel="stylesheet" type="text/css" href="../../resources/css/materializeIcon.css" rel="stylesheet">
                <link rel="icon" href="../../resources/img/public/logo/icon.png" type="image/png" sizes="16x16">
                <link rel="stylesheet" type="text/css" href="../../resources/css/privatePages.css?version=9">
            </head>
            ');
            if (isset($_SESSION['idUsuario'])) {
                $filename = basename($_SERVER['PHP_SELF']);
                if (!in_array($filename,$_SESSION['pages'])) {
                    header('location: main.php');
                }
                if ($filename != 'index.php') {
                    print('
                        <body>
                        <header>
                            <ul id="slide-out" class="sidenav sidenav-fixed z-depth-2">
                            <li class="center no-padding">
                            <div class="blue darken-4 white-text" style="height: 200px;">
                                <div class="row">
                                    <a href="personalInformation"><img style="margin-top: 5%;" width="85" height="85" class="circle" src="../../resources/img/dashboard/user/'.$_SESSION['fotoUsuario'].'"></a>
                                    <a href="personalInformation"><p class="white-text"><b>Usuario: </b>'.$_SESSION['nombreUsuario'].'</p></a>
                                    <a href="personalInformation"><p class="white-text"><b>Correo: </b>'.$_SESSION['correoUsuario'].'</p></a>
                                        </div>
                                    </div>
                                </li>
                                <li><a class="waves-effect" href="main"><i class="material-icons left">home</i><b>Inicio</b></a></li>
                                <div id="actionUser">
                                </div>
                                <li><a class="waves-effect" href="#" onclick="signOff()"><i class="material-icons left">power_settings_new</i><b>Cerrar Sesión</b></a></li>

                            </ul>
                        </header>
                        <main>
                            <div id="main-body" class="col s12 m12 l9 black-text white">
                            <div class="navbar-fixed">
                                <nav>
                                    <div class="nav-wrapper">
                                        <a href="main" class="dropdown-button right">
                                            <img class="responsive-img" src="../../resources/img/public/logo/logo.png" alt="Logo" width="160" height="25">
                                        </a>
                                        <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                                    </div>
                                </nav>
                            </div>
                        ');
                } else {
                    header('location: main.php');
                }
            } else {
                $filename = basename($_SERVER['PHP_SELF']);
                if ($filename != 'index.php' && $filename != 'register.php' && $filename != 'recoverUser.php' && $filename != 'updatePass.php') {
                    header('location: index.php');
                }
            }
        }
        public static function script($controller){
            print('
                </main>
                <footer>
                    <!--Se llama los archivos JavaScript-->
                    <script src="../../resources/js/jquery-3.3.1.min.js"></script>
                    <script src="../../resources/js/materialize.min.js"></script>
                    <script src="../../resources/js/datatables.min.js"></script>
                    <script src="../../core/helpers/dataTable.js"></script>
                    <script src="../../resources/js/dataTables.material.min.js"></script>
                    <script src="../../resources/js/dataTables.responsive.min.js"></script>
                    <script src="../../resources/js/initiators.js?version=3"></script>
                    <script src="../../resources/js/sweetalert.min.js"></script>
                    <script src="../../resources/js/moment.js"></script>
                    <script src="../../resources/js/MomentJslocales.min.js"></script>
                    <script src="../../core/helpers/functions.js"></script>
                    <script src="../../core/helpers/validator.js"></script>');
                $filename = basename($_SERVER['PHP_SELF']);
                if ($filename != 'index.php' && $filename != 'register.php' && $filename != 'recoverUser.php' && $filename != 'updatePass.php') {
                    print('
                        <script src="../../core/controllers/dashboard/account.js"></script>
                    ');
                }
                if($controller != null){
                    print(
                        '<script src="../../core/controllers/dashboard/'.$controller.'"></script>');
                }
                print('
                </footer>
            </body>

            </html>');
        }
    }

?>