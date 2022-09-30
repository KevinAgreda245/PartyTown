<?php
require_once('../../core/helpers/database.php');
require_once('../../core/helpers/validator.php');
require_once('../../core/models/productType.php');

if (isset($_GET['site']) && isset($_GET['action'])) {
    session_start();
    $productType = new productType;
    $result = array('status' => 0, 'exception' => '','session' => 1);
    //Se verifica si existe una sesión iniciada como administrador para realizar las operaciones correspondientes
	if (isset($_SESSION['idUsuario']) && $_GET['site'] == 'dashboard') {
        require 'session.php';
        switch ($_GET['action']) {
            case 'readType':
                if($productType->setEstado($_POST['Estado'])){
                    if($result['dataset'] = $productType->readType()){
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay Tipos de Producto';
                    }
                } else {
                    $result['exception'] = 'Estado incorrecto';
                }
                break;
            case 'createType':
                $_POST = $productType->validateForm($_POST);
                if($productType->setTipo($_POST['nuevoTipo'])){
                    if($productType->setDescripcion($_POST['nuevoDescripcion'])){
                        if(is_uploaded_file($_FILES['nuevaFoto']['tmp_name'])){
                            if($productType->setFoto($_FILES['nuevaFoto'],null)){
                                if($productType->createType()) {
                                    if ($productType->saveFile($_FILES['nuevaFoto'], $productType->getRuta(), $productType->getFoto())) {
                                        $result['status'] = 1;
                                    } else {
                                        $result['status'] = 2;
                                        $result['exception'] = "No se guardó el archivo";
                                    }
                                } else {
                                    $result['exception'] = "Operación fallida";    
                                }
                            } else {
                                $result['exception'] = $productType->getImageError();
                            }
                        } else {
                            $result['exception'] = 'Seleccione una imagen';
                        }
                    } else {
                        $result['exception'] = 'Descripción Incorrecta';
                    }
                } else {
                    $result['exception'] = 'Tipo de Producto Incorrecto';
                }
                break;
            case 'getType':
                if($productType->setId($_POST['idType'])){
                    if($result['dataset'] = $productType->getType()){
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'Tipo de Producto inexistente';
                    }
                } else {
                    $result['exception'] = 'Tipo de Producto incorrecto';
                }
                break;
            case 'updateType':
                $_POST = $productType->validateForm($_POST);
                if($productType->setId($_POST['idTipo'])){
                    if($productType->getType()){
                        if($productType->setTipo($_POST['actualizarNombre'])){
                            if($productType->setDescripcion($_POST['actualizarDescripcion'])) {
                                if($productType->setEstado(isset($_POST['actualizarEstado']) ? 1 : 0)){
                                    if(is_uploaded_file($_FILES['actualizarFoto']['tmp_name'])) {
                                        if($productType->setFoto($_FILES['actualizarFoto'],$_POST['fotoTipo'])) {
                                            $imagen = true;
                                        } else {
                                            $result['exception'] = $productType->getImageError();
                                            $imagen = false;
                                        }
                                    } else {
                                        if($productType->setFoto(null,$_POST['fotoTipo'])) {
                                            $result['exception'] = 'No cambio imagen';
                                        } else {
                                            $result['exception'] = $productType->getImageError();
                                        }
                                        $imagen = false;
                                    }
                                    if($productType->updateType()){
                                        if($imagen) {
                                            if($productType->saveFile($_FILES['actualizarFoto'],$productType->getRuta(),$productType->getFoto())){
                                                $result['status'] = 1;
                                            } else {
                                                $result['status'] = 2;
                                                $result['exception'] = 'No se guardo el archivo';
                                            }
                                        } else {
                                            $result['status'] = 3;
                                        }
                                    } else {
                                        $result['exception'] = 'Operación fallida';
                                    }
                                } else {
                                    $result['exception'] = 'Estado incorrecto';
                                }
                            } else {    
                                $result['exception'] = 'Descripción incorrecto';
                            }
                        } else {
                            $result['exception'] = 'Nombre incorrecto';
                        }
                    } else {
                        $result['exception'] = 'Tipo de Producto inexistente';
                    }
                } else {
                    $result['exception'] = 'Tipo de Producto incorrecto';
                }
                break;
            case 'actType':
                if($productType->setId($_POST['idType'])){
                    if($productType->getType()){
                        if($productType->setEstado($_POST['statusType'])){
                            if($productType->actType()){
                                $result['status'] = 1;
                            } else{
                                $result['exception'] = 'Operación fallida';
                            }
                        } else {
                            $result['exception'] = 'Estado incorrecto';
                        }
                    } else {
                        $result['exception'] = 'Tipo de Producto inexistente';
                    }
                } else {    
                    $result['exception'] = 'Tipo de Producto incorrecto';
                }
                break;
            default:
                exit('Acción no disponible');
        }
    } else if($_GET['site'] == 'commerce'){
        require 'sessionClient.php';
        switch ($_GET['action']) {
            case 'readType':
                if ($result['dataset'] = $productType->readTypeCommerce()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay categorías disponible';
                }
                break;
            default:
                exit('Acción no disponible');
        }
    } else {   
        $result['session'] = 0;
        $result['exception'] = 'Se ha bloqueado tu cuenta, porque se ha detectado una actividad sospechosa';
    } 
    print(json_encode($result));
} else {
    exit('Recurso denegado');
}
?>