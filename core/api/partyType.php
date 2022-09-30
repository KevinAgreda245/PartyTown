<?php
require_once '../../core/helpers/database.php';
require_once '../../core/helpers/validator.php';
require_once '../../core/models/partyType.php';

if (isset($_GET['site']) && isset($_GET['action'])) {
    session_start();
    ini_set('date.timezone', 'America/El_Salvador');//Inicializacion de fecha y hora
    $partyType = new partyType;
    $result = array('status' => 0, 'exception' => '','session' => 1);
    //Se verifica si existe una sesión iniciada como administrador para realizar las operaciones correspondientes
    if (isset($_SESSION['idUsuario']) && $_GET['site'] == 'dashboard') {
        require 'session.php';
        switch ($_GET['action']) {
            case 'readEvent':
                if ($partyType->setEstado($_POST['Estado'])) {
                    if ($result['dataset'] = $partyType->readEvents()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay Eventos registrados';
                    }
                } else {
                    $result['exception'] = "Estado incorrecto";
                }
                break;
            case 'createEvent':
                $_POST = $partyType->validateForm($_POST);
                if ($partyType->setTipo($_POST['nuevoTipo'])) {
                    if ($partyType->setDescripcion($_POST['nuevoDescripcion'])) {
                        if (is_uploaded_file($_FILES['nuevaFoto']['tmp_name'])) {
                            if ($partyType->setFoto($_FILES['nuevaFoto'], null)) {
                                if ($partyType->createEvents()) {
                                    if ($partyType->saveFile($_FILES['nuevaFoto'], $partyType->getRuta(), $partyType->getFoto())) {
                                        $result['status'] = 1;
                                    } else {
                                        $result['status'] = 2;
                                        $result['exception'] = "No se guardó el archivo";
                                    }
                                } else {
                                    $result['exception'] = "Operación fallida";
                                }
                            } else {
                                $result['exception'] = $partyType->getImageError();
                            }
                        } else {
                            $result['exception'] = 'Seleccione una imagen';
                        }
                    } else {
                        $result['exception'] = 'Descripción incorrecta';
                    }
                } else {
                    $result['exception'] = 'Nombre incorrecto';
                }
                break;
            case 'getEvent':
                if ($partyType->setId($_POST['idEvent'])) {
                    if ($result['dataset'] = $partyType->getEvents()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'Tipo de Evento inexistente';
                    }
                } else {
                    $result['exception'] = 'Tipo de Evento incorrecto';
                }
                break;
            case 'updateEvents':
                $_POST = $partyType->validateForm($_POST);
                if ($partyType->setId($_POST['idEvento'])) {
                    if ($partyType->getEvents()) {
                        if ($partyType->setTipo($_POST['actualizarTipo'])) {
                            if ($partyType->setDescripcion($_POST['actualizarDescripcion'])) {
                                if ($partyType->setEstado(isset($_POST['actualizarEstado']) ? 1 : 0)) {
                                    if (is_uploaded_file($_FILES['actualizarFoto']['tmp_name'])) {
                                        if ($partyType->setFoto($_FILES['actualizarFoto'], $_POST['fotoEvento'])) {
                                            $imagen = true;
                                        } else {
                                            $result['exception'] = $partyType->getImageError();
                                            $imagen = false;
                                        }
                                    } else {
                                        if ($partyType->setFoto(null, $_POST['fotoEvento'])) {
                                            $result['exception'] = 'No cambio imagen';
                                        } else {
                                            $result['exception'] = $partyType->getImageError();
                                        }
                                        $imagen = false;
                                    }
                                    if ($partyType->updateEvents()) {
                                        if ($imagen) {
                                            if ($partyType->saveFile($_FILES['actualizarFoto'], $partyType->getRuta(), $partyType->getFoto())) {
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
                        $result['exception'] = 'Tipo de Evento inexistente';
                    }
                } else {
                    $result['exception'] = 'Tipo de Evento incorrecto';
                }
                break;
            case 'actEvents':
                if ($partyType->setId($_POST['idEvents'])) {
                    if ($partyType->getEvents()) {
                        if ($partyType->setEstado($_POST['statusEvents'])) {
                            if ($partyType->actEvent()) {
                                $result['status'] = 1;
                            } else {
                                $result['exception'] = 'Operación Fallida';
                            }
                        } else {
                            $result['exception'] = 'Estado incorrecto';
                        }
                    } else {
                        $result['exception'] = 'Tipo de Evento inexistente';
                    }
                } else {
                    $result['exception'] = 'Tipo de Evento incorrecto';
                }
                break;

            case 'getSalesPerType';

                if ($result['dataset'] = $partyType->getSalesPerType()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay ventas en el mes';
                }

                break;

            default:
                exit('Acción no disponible');
        }
    } else if ($_GET['site'] == 'commerce') {
        require 'sessionClient.php';
        switch ($_GET['action']) {
            case 'readEvents':
                if ($result['dataset'] = $partyType->readEventsCommerce()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay tipos de eventos disponible';
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