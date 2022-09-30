<?php
require_once('../../core/helpers/database.php');
require_once('../../core/helpers/validator.php');
require_once('../../core/models/slider.php');

if (isset($_GET['site']) && isset($_GET['action'])) {
    session_start();
    $slider = new Slider;
    $result = array('status' => 0, 'exception' => '','session' => 1);
    //Se verifica si existe una sesión iniciada como administrador para realizar las operaciones correspondientes
	if (isset($_SESSION['idUsuario']) && $_GET['site'] == 'dashboard') {
        require 'session.php';
        switch ($_GET['action']) {
            case 'readSlider':
                if($slider->setEstado($_POST['Estado'])){
                    if ($result['dataset'] = $slider->readSlider()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay fotos registrados';
                    }
                } else {

                }
                break;
            case 'createSlider':
                $_POST = $slider->validateForm($_POST);
                if($slider->setTitulo($_POST['nuevoTitulo'])) {
                    if($slider->setSubtitulo($_POST['nuevoSubtitulo'])) {
                        if(is_uploaded_file($_FILES['nuevaFoto']['tmp_name'])) {
                            if($slider->setFoto($_FILES['nuevaFoto'],null)) {
                                if($slider->createSlider()) {
                                    if ($slider->saveFile($_FILES['nuevaFoto'], $slider->getRuta(), $slider->getFoto())) {
                                        $result['status'] = 1;
                                    } else {
                                        $result['status'] = 2;
                                        $result['exception'] = "No se guardó el archivo";
                                    }
                                } else {
                                    $result['exception'] = "Operación fallida";    
                                }
                            } else {
                                $result['exception'] = $slider->getImageError();
                            }
                        } else {
                            $result['exception'] = "Seleccione una imagen";
                        }
                    } else {
                        $result['exception'] = 'Subtítulo incorrecto';
                    }
                } else {
                    $result['exception'] = 'Título incorrecto';
                }
                break;
            case 'get':
                if($slider->setId($_POST['idSlider'])) {
                    if($result['dataset'] = $slider->getSlider()) {
                        $result['status'] = 1; 
                    } else {
                        $result['exception'] = 'Deslizador inexistente';
                    }
                } else {
                    $result['exception'] = 'Deslizador incorrecto';
                }
                break;
            case 'updateSlider':
                $_POST = $slider->validateForm($_POST);
                if($slider->setId($_POST['idSlider'])) {
                    if($slider->getSlider()) {
                        if($slider->setTitulo($_POST['actualizarTitulo'])) {
                            if($slider->setSubtitulo($_POST['actualizarSubtitulo'])) {
                                if($slider->setEstado(isset($_POST['actualizarEstado']) ? 1 : 0)){
                                    if(is_uploaded_file($_FILES['actualizarFoto']['tmp_name'])) {
                                        if($slider->setFoto($_FILES['actualizarFoto'],$_POST['fotoSlider'])) {
                                            $imagen = true;
                                        } else {
                                            $result['exception'] = $slider->getImageError();
                                            $imagen = false;
                                        }
                                    } else {
                                        if($slider->setFoto(null,$_POST['fotoSlider'])) {
                                            $result['exception'] = 'No cambio imagen';
                                        } else {
                                            $result['exception'] = $slider->getImageError();
                                        }
                                        $imagen = false;
                                    }
                                    if($slider->updateSlider()){
                                        if($imagen) {
                                            if($slider->saveFile($_FILES['actualizarFoto'],$slider->getRuta(),$slider->getFoto())){
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
                                $result['exception'] = 'Subtítulo incorrecto';
                            }
                        } else {
                            $result['exception'] = 'Título incorrecto';
                        }
                    } else {
                        $result['exception'] = 'Deslizador inexistente';
                    }
                } else {
                    $result['exception'] = 'Deslizador incorrecto';
                }
                break;
            case 'actSlider':
                if($slider->setId($_POST['idSlider'])){
                    if($slider->getSlider()){
                        if($slider->setEstado($_POST['Estado'])){
                            if($slider->actSlider()){
                                $result['status'] = 1;
                            } else {
                                $result['exception'] = 'Operación fallida';
                            }
                        } else {
                            $result['exception'] = 'Estado incorrecto';
                        }
                    } else {
                        $result['exception'] = 'Deslizador inexistente';
                    }
                } else {
                    $result['exception'] = 'Deslizador incorrecto';
                }
                break;
            default:
                exit('Acción no disponible');
        }
    } else if($_GET['site'] == 'commerce') {   
        switch ($_GET['action']) {
            case 'readSlider':
                if ($result['dataset'] = $slider->readSliderCommerce()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay fotos registrados';
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