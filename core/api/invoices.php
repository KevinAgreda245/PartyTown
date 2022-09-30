<?php
require_once('../../core/helpers/database.php');
require_once('../../core/helpers/validator.php');
require_once('../../core/models/invoices.php');

if (isset($_GET['site']) && isset($_GET['action'])) {
    session_start();
    ini_set('date.timezone', 'America/El_Salvador');//Inicializacion de fecha y hora
    $invoices = new Invoices;
    $result = array('status' => 0, 'exception' => '','session' => 1);
    //Se verifica si existe una sesión iniciada como administrador para realizar las operaciones correspondientes
	if (isset($_SESSION['idUsuario']) && $_GET['site'] == 'dashboard') {
        require 'session.php';
        switch ($_GET['action']) {
            case 'readInvoices':
                if($invoices->setEstado($_POST['Estado'])){
                    if($result['dataset'] = $invoices->readInvoices()){
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay Facturas registradas';
                    }
                } else {
                    $result['exception'] = 'Estado incorrecto';
                }
                break;
            case 'getProduct':
                if($invoices->setId($_POST['idInvoices'])){
                    if($result['dataset']= $invoices->getProduct()){
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'Factura inexistente';
                    }   
                } else {
                    $result['exception'] = 'Factura incorrecta';
                }
                break;
            case 'getStatus':
                if($invoices->setId($_POST['idInvoices'])){
                    if($result['dataset']= $invoices->getStatus()){
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'Factura inexistente';
                    }   
                } else {
                    $result['exception'] = 'Factura incorrecta';
                }
                break;
            case 'updateInvoices':
                if($invoices->setId($_POST['idFactura'])){
                    if($invoices->updateStatus()){
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'Operación fallida';
                    }  
                } else {
                    $result['exception'] = 'Factura incorrecta';
                }
                break;
            case 'cancelInvoices':
                if($invoices->setId($_POST['idFactura'])){
                    if($invoices->cancelInvoices()){
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'Operación fallida';
                    }  
                } else {
                    $result['exception'] = 'Factura incorrecta';
                }
                break;
            case 'getAmount':
                if($result['dataset'] = $invoices->getAmount()){
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay ventas en el mes';
                }
                break;

            case 'getCantTypeProd':
                if($result['dataset'] = $invoices->getCantTypeProd()){
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay productos disponibles';
                }
                break;
            case 'getCantTypeEvent':
                if($result['dataset'] = $invoices->getCantTypeEvent()){
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay productos disponibles';
                }
                break;
            case 'getMonthSales':  
                if($result['dataset'] = $invoices->getMonthSales()){
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay ventas en el periodo de tiempo';
                }
                break;
            case 'getMonthSales2':  
                if($result['dataset'] = $invoices->getMonthSales2()){
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay ventas en el periodo de tiempo';
                }
                break;
            default:
                exit('Acción no disponible');
        }
    } else if($_GET['site'] == 'commerce'){
        require 'sessionClient.php';
        switch ($_GET['action']) {
            case 'readInvoices':
                if($invoices->setCliente($_SESSION['idCliente'])){
                    if($result['dataset'] = $invoices->readInvoicesClients()){
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay facturas';    
                    }
                } else{
                    $result['exception'] = 'Cliente inexistente';
                }
                break;
            case 'getProduct':
                if($invoices->setId($_POST['idInvoices'])){
                    if($result['dataset']= $invoices->getProduct()){
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'Factura inexistente';
                    }   
                } else {
                    $result['exception'] = 'Factura incorrecta';
                }
                break;
            case 'reports':
                $_SESSION['idInvoices'] = $_POST['idInvoices'];
                break;
            default:
                exit('Acción no disponible');
        }
    }else{   
        $result['session'] = 0;
        $result['exception'] = 'Se ha bloqueado tu cuenta, porque se ha detectado una actividad sospechosa';
    } 
    print(json_encode($result));
} else {
    exit('Recurso denegado');
}
?>