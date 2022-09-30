<?php 
require_once('../../core/helpers/database.php');
require_once('../../core/helpers/validator.php');
require_once('../../core/models/providers.php');

if (isset($_GET['site']) && isset($_GET['action'])) {
    session_start();
    $providers = new Providers;
    $result = array('status' => 0, 'exception' => '','session' => 1);
    //Se verifica si existe una sesión iniciada como administrador para realizar las operaciones correspondientes
	if (isset($_SESSION['idUsuario']) && $_GET['site'] == 'dashboard') {
        require 'session.php';
        switch ($_GET['action']) {
            case 'readProviders':
                if($providers->setEstado($_POST['Estado'])){
                    if ($result['dataset'] = $providers->readProviders()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay proveedores registrados';
                    }
                } else {
                    $result['exception'] = 'Estado incorrecto';
                }
                break;
            case 'createProvider':
                $_POST = $providers->validateForm($_POST);
                if($providers->setNombre($_POST['nuevoNombre'])){
                    if($providers->setTelefono($_POST['nuevoTelefono'])){
                        if($providers->setCorreo($_POST['nuevoCorreo'])){
                            if(is_uploaded_file($_FILES['nuevaFoto']['tmp_name'])){
                                if($providers->setFoto($_FILES['nuevaFoto'],null)){
                                    if($providers->createProviders()){
                                        if ($providers->saveFile($_FILES['nuevaFoto'], $providers->getRuta(), $providers->getFoto())) {
                                            $result['status'] = 1;
                                        } else {
                                            $result['status'] = 2;
                                            $result['exception'] = "No se guardó el archivo";
                                        }
                                    } else {
                                        $result['exception'] = "Operación fallida";    
                                    }
                                } else {
                                    $result['exception'] = $providers->getImageError();
                                }
                            } else {
                                $result['exception'] = "Seleccione una imagen";
                            }
                        } else {
                            $result['exception'] = 'Télefono incorrecto FORMATO: XXXX-XXXX';    
                        }
                    } else {
                        $result['exception'] = 'Télefono incorrecto FORMATO: XXXX-XXXX';
                    }
                } else {
                    $result['exception'] = 'Nombre incorrecto';
                }
                break;
            case 'getProviders':
                if($providers->setId($_POST['idProviders'])){
                    if($result['dataset'] = $providers->getProviders()){
                        $result['status'] = 1; 
                    } else {
                        $result['exception'] = 'Producto inexistente';    
                    }
                } else {
                    $result['exception'] = 'Producto incorrecto';
                }
                break;
            case 'updateProviders':
                $_POST = $providers->validateForm($_POST);
                if($providers->setId($_POST['idProveedor'])){
                    if($providers->getProviders()){
                        if($providers->setNombre($_POST['actualizarNombre'])){
                            if($providers->setTelefono($_POST['actualizarTelefono'])){
                                if($providers->setCorreo($_POST['actualizarCorreo'])){
                                    if(is_uploaded_file($_FILES['actualizarFoto']['tmp_name'])){
                                        if($providers->setFoto($_FILES['actualizarFoto'],$_POST['fotoProveedor'])){
                                            $imagen = true;
                                        } else {
                                            $result['exception'] = $providers->getImageError();
                                            $imagen = false;
                                        }
                                    } else {
                                        if($providers->setFoto(null,$_POST['fotoProveedor'])) {
                                            $result['exception'] = 'No cambio imagen';
                                        } else {
                                            $result['exception'] = $providers->getImageError();
                                        }
                                        $imagen = false;
                                    }
                                    if($providers->updateProviders()){
                                        if($imagen) {
                                            if($providers->saveFile($_FILES['actualizarFoto'],$providers->getRuta(),$providers->getFoto())){
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
                                    $result['exception'] = 'Correo incorrecto';
                                }
                            } else {
                                $result['exception'] = 'Teléfono incorrecto FORMATO: XXXX-XXXX';
                            }
                        } else {
                            $result['exception'] = 'Nombre incorrecto';
                        }
                    } else {
                        $result['exception'] = 'Proveedor inexistente';
                    }
                } else {
                    $result['exception'] = 'Proveedor incorrecto';
                }
                break;
            case 'actProviders':
                if($providers->setId($_POST['idProviders'])){
                    if($providers->getProviders()){
                        if($providers->setEstado($_POST['statusProviders'])){
                            if($providers->actProviders()){
                                $result['status'] = 1;
                            } else {
                                $result['exception'] = 'Operación fallida';
                            }
                        } else {
                            $result['exception'] = 'Estado incorrecto';
                        }
                    } else {
                        $result['exception'] = 'Proveedor inexistente';
                    }
                } else {
                    $result['exception'] = 'Proveedor incorrecto';
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