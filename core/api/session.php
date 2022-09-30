<?php 
require_once('../../core/models/user.php');
$user = new User;
//Comprobamos si esta definida la sesión 'tiempo'.
if ($user->setId($_SESSION['idUsuario'])) {
    $data = $user->checkOnline();
    if ($data['Online']) {
        if (isset($_SESSION['tiempo'])) {
            //Tiempo en segundos para dar vida a la sesión.
            $inactivo = 120;
            //Calculamos tiempo de vida inactivo.
            $vida_session = time() - $_SESSION['tiempo'];
            //Compraración para redirigir página, si la vida de sesión sea mayor a el tiempo insertado en inactivo.
            if ($vida_session > $inactivo) {
                $user->endOnline();
                unset($_SESSION['idCliente']);
                $result['session'] = 0;
                $result['exception'] = 'Sesión caducada';
                $result['exceptionEN'] = 'Expired Session';
                exit(json_encode($result));
            } else {  // si no ha caducado la sesion, actualizamos
                $_SESSION['tiempo'] = time();
            }
        }
    } else {
        unset($_SESSION['idUsuario']);
        $result['session'] = 0;
        $result['exception'] = 'Se ha bloqueado tu cuenta, porque se ha detectado una actividad sospechosa';
        $result['exceptionEN'] = 'Your account has been blocked, because suspicious activity has been detected';
        exit(json_encode($result));
    }
} 
?>