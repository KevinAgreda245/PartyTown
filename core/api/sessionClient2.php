<?php 
require_once('../../core/models/customer.php');
$customer = new Customer;
//Comprobamos si esta definida la sesión 'tiempo'.
if ($customer->setId($_SESSION['idCliente'])) {
    $data = $customer->checkOnline();
    if ($data['Online']) {
        if (isset($_SESSION['tiempo'])) {
            //Tiempo en segundos para dar vida a la sesión.
            $inactivo = 360;
            //Calculamos tiempo de vida inactivo.
            $vida_session = time() - $_SESSION['tiempo'];
            //Compraración para redirigir página, si la vida de sesión sea mayor a el tiempo insertado en inactivo.
            if ($vida_session > $inactivo) {
                $customer->endOnline();
                unset($_SESSION['idCliente']);
                header('Location: login.php');
            } else {  // si no ha caducado la sesion, actualizamos
                $_SESSION['tiempo'] = time();
            }
        }
    } else {
        unset($_SESSION['idCliente']);
        header('Location: login.php');
    }
} 
?>