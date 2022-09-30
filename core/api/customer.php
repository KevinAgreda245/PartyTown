<?php
require_once('../../core/helpers/database.php');
require_once('../../core/helpers/validator.php');
require_once('../../core/models/customer.php');

//Se comprueba si existe una petición del sitio web y la acción a realizar, de lo contrario se muestra una página de error
if (isset($_GET['site']) && isset($_GET['action'])) {
    //Se inicia la sesion
    session_start();
    ini_set('date.timezone', 'America/El_Salvador');//Inicializacion de fecha y hora
    $customer = new Customer;
    $result = array('status' => 0, 'exception' => '', 'session' => 1, 'url' =>null);
    //Se verifica si existe una sesión iniciada como administrador para realizar las operaciones correspondientes
	if (isset($_SESSION['idUsuario']) && $_GET['site'] == 'dashboard') {
        switch ($_GET['action']) {
            case 'readCustomer':
                if($customer->setEstado($_POST['Estado'])){
                    if ($result['dataset'] = $customer->readCustomer()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay cliente registrados';
                    }
                }
                break;
            case 'actCustomer':
                if($customer->setId($_POST['idCustomer'])){
                    if($customer->getCustomer()){
                        if($customer->setEstado($_POST['statusCustomer'])){
                            if($customer->deleteCustomer()){
                                $result['status'] = 1;
                            } else {
                                $result['exception'] = 'Operación fallida';
                            }
                        } else {
                            $result['exception'] = 'Estado incorrecto';    
                        }
                    } else {
                        $result['exception'] = 'Cliente inexistente';
                    }
                } else {
                    $result['exception'] = 'Cliente incorrecto';
                }
                break;
            case 'getStatusCustomer':
                if($customer->setId($_POST['idCustomer'])){
                    if($result['dataset'] = $customer->getStatusCustomer()){
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'Cliente inexistente';
                    }
                } else {
                    $result['exception'] = 'Cliente incorrecto';
                }   
                break;
            case 'updateCustomer':
                $_POST = $customer->validateForm($_POST);
                if($customer->setId($_POST['idCliente'])){
                    if($customer->setEstado(isset($_POST['actualizarEstado']) ? 1 : 0)){
                        if($customer->updateStatus()){
                            $result['status'] = 1;
                        }else{
                            $result['exception'] = 'Operación fallida';    
                        }
                    }else{
                        $result['exception'] = 'Estado incorrecto';
                    }
                }else{
                    $result['exception'] = 'Valoracion incorrecto';
                }
                break;
            default:
                exit('Acción no disponible');
        }
    } else if($_GET['site'] == 'commerce'){
        if(isset($_SESSION['idCliente'])){
            require 'sessionClient.php';
            switch ($_GET['action']){
                case 'logout':
                    if ($customer->setId($_SESSION['idCliente'])) {
                        $customer->endOnline();
                        unset($_SESSION['idCliente']);
                        header('location: ../../views/public/login.php');
                    }
                    break;
                case 'getData':
                    if($customer->setId($_SESSION['idCliente'])){
                        if($result['dataset'] = $customer->getData()){
                            $result['status'] = 1; 
                        } else {
                            $result['exceptionEN'] = 'Nonexistent customer';
                            $result['exception'] = 'Cliente inexistente';
                        }
                    } else {
                        $result['exceptionEN'] = 'Wrong customer';
                        $result['exception'] = 'Cliente incorrecto';
                    }
                    break;
                case 'updateCustomer':
                    $_POST = $customer->validateForm($_POST);
                    if($customer->setId($_SESSION['idCliente'])){
                        if($customer->getData()){
                            if($customer->setNombre($_POST['nombres'])){
                                if($customer->setApellidos($_POST['apellidos'])){
                                    if($customer->setGenero($_POST['genero'])){
                                        if($customer->setCorreo($_POST['correo'])){
                                            if($customer->setFecha($_POST['nacimiento'])){
                                                if($customer->setTelefono($_POST['telefono'])){
                                                    if($customer->updateCustomer()){
                                                        $result['status'] = 1;        
                                                    } else {
                                                        $result['exceptionEN'] = 'Operation failed';
                                                        $result['exception'] = 'Operación fallida';        
                                                    }
                                                } else {
                                                    $result['exceptionEN'] = 'Wrong telephone';
                                                    $result['exception'] = 'Teléfono Incorrecto';        
                                                }
                                            } else {
                                                $result['exceptionEN'] = 'Wrong date of birth';
                                                $result['exception'] = 'Fecha de Nacimiento Incorrecto';        
                                            }
                                        } else {
                                            $result['exceptionEN'] = 'Wrong email';
                                            $result['exception'] = 'Correo Incorrecto';            
                                        }
                                    } else {
                                        $result['exceptionEN'] = 'Wrong gender';
                                        $result['exception'] = 'Género Incorrecto';        
                                    }
                                } else {
                                    $result['exceptionEN'] = 'Wrong surname';
                                    $result['exception'] = 'Apellido Incorrecto';    
                                }
                            } else {
                                $result['exceptionEN'] = 'Wrong name';
                                $result['exception'] = 'Nombre Incorrecto';
                            }
                        } else {
                            $result['exception'] = 'Cliente inexistente';
                        }
                    } else {
                        $result['exception'] = 'Cliente incorrecto';
                    }
                    break;
                    case 'password':
                    if ($customer->setId($_SESSION['idCliente'])) {
                    $_POST = $customer->validateForm($_POST);
                    if ($_POST['claveActual'] == $_POST['claveActual2']) {
                        if ($customer->setClave($_POST['claveActual'])) {
                            if ($customer->checkPassword()) {
                                if ($_POST['claveNueva'] == $_POST['claveNueva2']) {
                                    if($_POST['claveNueva'] != $customer->getClave()){
                                        if ($customer->setClave($_POST['claveNueva'])) {
                                            if ($customer->changePassword()) {
                                                $result['status'] = 1;
                                            } else {
                                                $result['exceptionEN'] = 'Operation failed';
                                                $result['exception'] = 'Operación fallida';
                                            }
                                        } else {
                                            $result['exceptionEN'] = $customer->getPassErrorEN();
                                            $result['exception'] = $customer->getPassError();
                                        }
                                    } else {
                                        $result['exceptionEN'] = 'There is no change in the keys';
                                        $result['exception'] = 'No hay cambio en las claves';    
                                    }
                                } else {
                                    $result['exceptionEN'] = 'Different new passwords';
                                    $result['exception'] = 'Claves nuevas diferentes';
                                }
                            } else {
                                $result['exceptionEN'] = 'Wrong current password';
                                $result['exception'] = 'Clave actual incorrecta';
                            }
                        } else {
                            $result['exceptionEN'] = $customer->getPassErrorEN();
                            $result['exception'] = $customer->getPassError();
                        }
                    } else {
                        $result['exceptionEN'] = 'Different current passwords';
                        $result['exception'] = 'Claves actuales diferentes';
                    }
                } else {
                    $result['exceptionEN'] = 'Wrong user';
                    $result['exception'] = 'Usuario incorrecto';
                }
                    break;
                default:
                    exit('Acción no disponible');
            }
        } else {
            switch ($_GET['action']) {
                case 'emailCode':
                    if ($customer->setCorreo($_POST['email'])) {
                        if ($customer->checkCorreo()) { 
                            include '../emails/email.php';
                            $code = rand('000000','999999');
                            if (Email::updatePass($customer->getCorreo(), $code)) {
                                $result['status'] = 1;
                                $customer->createCode($code);
                                $_SESSION['correoClient'] = $customer->getCorreo();
                            } else {
                                $result['exceptionEN'] = 'Could not send mail';
                                $result['exception'] = 'No se pudo enviar el correo';        
                            }
                        } else {
                            $result['exceptionEN'] = 'Nonexistent mail';
                            $result['exception'] = 'Correo inexistente';    
                        }
                    } else {
                        $result['exceptionEN'] = 'Wrong email';
                        $result['exception'] = 'Correo incorrecto';
                    }
                    break;
                case 'recoverUser':
                    $_POST = $customer->validateForm($_POST);
                    if ($customer->setCorreo($_SESSION['correoClient'])){
                        if ($customer->checkCorreo()) { 
                            if ($customer->checkCode($_POST['codeUser'])){
                                $customer->updateStatusCode();
                                $result['status'] = 1;
                            } else {
                                $result['exceptionEN'] = 'The code is not correct. Retry';
                                $result['exception'] = 'El código no es correcto. Vuelve a intentarlo';
                            }
                        } else {
                            $result['exceptionEN'] = 'Nonexistent mail';
                            $result['exception'] = 'Correo inexistente';
                        }
                    } else {
                        $result['exceptionEN'] = 'Wrong email';
                        $result['exception'] = 'Correo incorrecto';
                    }
                    break;
                case 'restorePass':
                    if ($customer->setCorreo($_SESSION['correoClient'])) {
                        if ($customer->checkCorreo()) {
                            if ($_POST['nuevaClave1'] = $_POST['nuevaClave2']) {
                                if ($_POST['nuevaClave1'] != $_SESSION['correoClient']) {
                                    if ($customer->newPass($_POST['nuevaClave1'])) {
                                        if ($customer->changePassword()) {
                                            $customer->unlockUser();
                                            $result['status'] = 1;
                                            $result['messageEN'] = 'Password changed successfully';
                                            $result['message'] = 'Se cambio la clave exitosamente';
                                        } else {
                                            $result['exceptionEN'] = 'Operation failed';
                                            $result['exception'] = "Operación fallida";    
                                        }
                                    } else {
                                        $result['exceptionEN'] = 'There is no change in the keys';
                                        $result['exception'] = "No hay cambio en las claves";
                                    }
                                } else {
                                    $result['exceptionEN'] = 'Email should not be your password';
                                    $result['exception'] = "Tu correo no debe ser tu clave";
                                }
                            } else {
                                $result['exceptionEN'] = 'Passwords do not match';
                                $result['exception'] = "No coinciden las claves"; 
                            }
                        } else {
                            $result['exceptionEN'] = 'Nonexistent mail';
                            $result['exception'] = 'Correo inexistente';
                        }
                    } else {
                        $result['exceptionEN'] = 'Wrong mail';
                        $result['exception'] = 'Correo incorrecto';
                    }
                    break;
                case 'createCustomer':
                    $_POST = $customer->validateForm($_POST);
                    if(isset($_POST['term'])){
                        if($_POST['g-recaptcha-response']){
                            if($customer->setNombre($_POST['nombres'])){
                                if($customer->setApellidos($_POST['apellidos'])){
                                    if($customer->setGenero($_POST['genero'])){
                                        if($customer->setFecha($_POST['nacimiento'])){
                                            if($customer->setCorreo($_POST['correo'])){
                                                if($customer->setTelefono($_POST['telefono'])){
                                                    if($_POST['clave1']==$_POST['clave2']) {
                                                        if ($_POST['clave1'] != $_POST['correo']) {
                                                            if($customer->setClave($_POST['clave1'])){
                                                                if($customer->createCustomer()){
                                                                    if($customer->checkCorreo()){
                                                                        $_SESSION['idCliente'] = $customer->getId();
                                                                        $result['status'] = 1;
                                                                    }
                                                                } else {
                                                                    $result['exceptionEN'] = 'Operation failed';
                                                                    $result['exception'] = "Operación fallida";       
                                                                }
                                                            } else {
                                                                $result['exceptionEN'] = $customer->getPassErrorEN();
                                                                $result['exception'] = $customer->getPassError();
                                                            }
                                                        } else {
                                                            $result['exceptionEN'] = 'Email should not be your password';
                                                            $result['exception'] = "El correo no debe ser tu clave";
                                                        }
                                                    } else {
                                                        $result['exceptionEN'] = 'Passwords do not match';
                                                        $result['exception'] = "No coinciden las contraseñas";
                                                    }
                                                } else {
                                                    $result['exceptionEN'] = 'Wrong Telephone FORMAT: XXXX-XXXX';
                                                    $result['exception'] = 'Teléfono Incorrecto FORMATO:XXXX-XXXX';    
                                                }
                                            } else {
                                                $result['exceptionEN'] = 'Wrong mail';
                                                $result['exception'] = 'Correo Incorrecto';    
                                            }
                                        } else {
                                            $result['exceptionEN'] = 'Wrong date of birth';
                                            $result['exception'] = 'Fecha de Nacimento Incorrecto';    
                                        }
                                    } else {
                                        $result['exceptionEN'] = 'Wrong gender';
                                        $result['exception'] = 'Género Incorrecto';    
                                    }
                                } else {
                                    $result['exceptionEN'] = 'Wrong surnames';
                                    $result['exception'] = 'Apellidos Incorrecto';    
                                }
                            } else {
                                $result['exceptionEN'] = 'Wrong names';
                                $result['exception'] = 'Nombres Incorrecto';
                            }
                        } else {
                            $result['exceptionEN'] = 'Verify the captcha';
                            $result['exception'] = 'Verifique el captcha';
                        }
                    }else{
                        $result['exceptionEN'] = 'Read the Terms and Conditions';
                        $result['exception'] = 'Lea los Términos y Condiciones';
                    }
                    break;
                case 'loginCustomer':
                    $_POST = $customer->validateForm($_POST);
                    if ($customer->setCorreo($_POST['correoCliente'])) {
                        if ($customer->checkCorreo()) {
                            $data = $customer->checkUser();
                            if ($data['Estado'] == 1){
                                if ($customer->setClave($_POST['claveCliente'])) {
                                    if ($customer->checkPassword()) {
                                        if ($data['Online'] == 0){
                                            if ($data['Fecha'] > date('Y-m-d')) {
                                                $customer->startOnline();
                                                $customer->restartCount();
                                                $result['status'] = 1;
                                                $_SESSION['idCliente'] = $customer->getId();
                                                $_SESSION['tiempo'] = time();
                                            } else {
                                                $result['exceptionEN'] = 'You must change your password';
                                                $result['exception'] = 'Debes cambiar tu clave';
                                                $_SESSION['correo'] = $customer->getCorreo();
                                            }
                                        } else {
                                            include '../emails/email.php';
                                            $code = rand('000000','999999');
                                            if (Email::verificationCode($customer->getCorreo(), $code)) {
                                                $result['exceptionEN'] = 'The user is online';
                                                $result['exception'] = 'El usuario está en línea';
                                                $customer->createCode($code);
                                                $customer->lockUser();
                                                $customer->endOnline();
                                            } else {
                                                $result['exceptionEN'] = "I can't send the mail";
                                                $result['exception'] = 'No se puedo enviar el correo';
                                            }
                                        }
                                    } else {
                                        $count = 2 - (int) $customer->getLock();
                                        if ($count <= 0) {
                                            if ($customer->userLock()) {
                                                $result['exceptionEN'] = 'Your account has been locked for 24 hours, or until you can unlock';
                                                $result['exception'] = 'Se te ha bloqueado tu cuenta por 24 horas, o hasta que puedas desbloquear';
                                            } else {
                                                $result['exceptionEN'] = 'Could not lock account';
                                                $result['exception'] = 'No se ha podido bloquear la cuenta';    
                                            }
                                        } else {
                                            $result['exceptionEN'] = 'The password is not correct. You are missing'.$count.'attempts';
                                            $result['exception'] = 'La clave no es correcta. Te faltan '.$count.' intentos';
                                            $customer->sumLock();
                                        }
                                    }
                                } else {
                                    $count = 2 - (int) $customer->getLock();
                                        if ($count <= 0) {
                                            if ($customer->userLock()) {
                                                $result['exceptionEN'] = 'Your account has been locked for 24 hours, or until you can unlock';
                                                $result['exception'] = 'Se te ha bloqueado tu cuenta por 24 horas, o hasta que puedas desbloquear';
                                            } else {
                                                $result['exceptionEN'] = 'Could not lock account';
                                                $result['exception'] = 'No se ha podido bloquear la cuenta';    
                                            }
                                        } else {
                                            $result['exceptionEN'] = 'The password is not correct. You are missing'.$count.'attempts';
                                            $result['exception'] = 'La clave no es correcta. Te faltan '.$count.' intentos';
                                            $customer->sumLock();
                                        }
                                }
                            } else {
                                $_SESSION['correoCliente'] = $customer->getCorreo();
                                    $customer->endOnline();
                                    $result['exceptionEN'] = 'User blocked';
                                    $result['exception'] = 'Usuario bloqueado';
                                    if ($data['Bloqueo']) {
                                        if (date("Y-m-d G:i:s",strtotime($data['Bloqueo'].' + 24 hours')) <=  date("Y-m-d G:i:s")) {
                                            $customer->unlockUser();
                                            if ($customer->setClave($_POST['claveCliente'])) {
                                                if ($customer->checkPassword()) {
                                                    if ($data['Online'] == 0){
                                                        if ($data['Fecha'] > date('Y-m-d')) {
                                                            $result['status'] = 1;
                                                            $customer->startOnline();
                                                            $customer->restartCount();
                                                            $_SESSION['idCliente'] = $customer->getId();
                                                            $_SESSION['tiempo'] = time();
                                                    } else {
                                                        $result['exceptionEN'] = 'You must change your password';
                                                        $result['exception'] = 'Debes cambiar tu clave';
                                                    }
                                                } else {
                                                    include '../emails/email.php';
                                                    $code = rand('000000','999999');
                                                    if (Email::verificationCode($customer->getCorreo(), $code)) {
                                                        $result['exceptionEN'] = 'The user is online';
                                                        $result['exception'] = 'El usuario está en línea';
                                                        $customer->createCode($code);
                                                        $customer->lockUser();
                                                        $customer->endOnline();
                                                    } else {
                                                        $result['exceptionEN'] = "I can't send the mail";
                                                        $result['exception'] = 'No se puedo enviar el correo';
                                                    }
                                                }
                                            } else {
                                                $count = 2 - (int) $customer->getLock();
                                                if ($count <= 0) {
                                                    if ($customer->userLock()) {
                                                        $result['exceptionEN'] = 'Your account has been locked for 24 hours, or until you can unlock';
                                                        $result['exception'] = 'Se te ha bloqueado tu cuenta por 24 horas, o hasta que puedas desbloquear';
                                                    } else {
                                                        $result['exceptionEN'] = 'Could not lock account';
                                                        $result['exception'] = 'No se ha podido bloquear la cuenta';    
                                                    }
                                                } else {
                                                    $result['exceptionEN'] = 'The password is not correct. You are missing'.$count.'attempts';
                                                    $result['exception'] = 'La clave no es correcta. Te faltan '.$count.' intentos';
                                                    $customer->sumLock();
                                                }
                                            }
                                        } else {
                                            $count = 2 - (int) $customer->getLock();
                                            if ($count <= 0) {
                                                if ($customer->userLock()) {
                                                    $result['exceptionEN'] = 'Your account has been locked for 24 hours, or until you can unlock';
                                                    $result['exception'] = 'Se te ha bloqueado tu cuenta por 24 horas, o hasta que puedas desbloquear';
                                                } else {
                                                    $result['exceptionEN'] = 'Could not lock account';
                                                    $result['exception'] = 'No se ha podido bloquear la cuenta';    
                                                }
                                            } else {
                                                $result['exceptionEN'] = 'The password is not correct. You are missing'.$count.'attempts';
                                                $result['exception'] = 'La clave no es correcta. Te faltan '.$count.' intentos';
                                                $customer->sumLock();
                                            }
                                        }
                                    } else {
                                        $result['exceptionEN'] = 'User blocked';
                                        $result['exception'] = 'Usuario bloqueado';
                                        $result['url'] = 'recoverCustomer.php';
                                        
                                    }
                                } else {
                                    $result['exceptionEN'] = 'User blocked';
                                    $result['exception'] = 'Usuario bloqueado';
                                    $result['url'] = 'recoverCustomer.php';
                                }
                            }
                        } else {
                            $result['exceptionEN'] = 'Nonexistent mail';
                            $result['exception'] = 'Correo inexistente';
                        }
                } else {
                    $result['exceptionEN'] = 'Wrong mail';
                    $result['exception'] = 'Correo incorrecto';
                }
                    break;
                case 'recoverUser':
                    $_POST = $customer->validateForm($_POST);
                    if ($customer->setCorreo($_POST['emailUser'])){
                        if ($customer->checkCorreo()) { 
                            if ($customer->checkCode($_POST['codeUser'])){
                                $customer->updateStatusCode();
                                $result['status'] = 1;
                            } else {
                                $result['exceptionEN'] = 'The code is not correct. Retry';
                                $result['exception'] = 'El código no es correcto. Vuelve a intentarlo';
                            }
                        } else {
                            $result['exceptionEN'] = 'Nonexistent mail';
                            $result['exception'] = 'Correo inexistente';
                        }
                    } else {
                        $result['exceptionEN'] = 'Wrong mail';
                        $result['exception'] = 'Correo incorrecto';
                    }
                    break;
                case 'restorePass':
                    if ($customer->setCorreo($_SESSION['correoCliente2'])) {
                        if ($customer->checkCorreo()) {
                            if ($_POST['nuevaClave1'] = $_POST['nuevaClave2']) {
                                if ($_POST['nuevaClave1'] != $_SESSION['correoCliente']) {
                                    if ($customer->newPass($_POST['nuevaClave1'])) {
                                        if ($customer->changePassword()) {
                                            $customer->updateStatus();
                                            $customer->unlockUser();
                                            $result['status'] = 1;
                                            $result['messageEN'] = 'The password was changed successfully';
                                            $result['message'] = 'Se cambio la clave exitosamente';
                                        } else {
                                            $result['exceptionEN'] = 'Operation failed';
                                            $result['exception'] = "Operación fallida";    
                                        }
                                    } else {
                                        $result['exceptionEN'] = 'There is no change in the keys';
                                        $result['exception'] = "No hay cambio en las claves";
                                    }
                                } else {
                                    $result['exceptionEN'] = 'Your email should not be your password';
                                    $result['exception'] = "Tu correo no debe ser tu clave";
                                }
                            } else {
                                $result['exceptionEN'] = 'The keys do not match';
                                $result['exception'] = "No coinciden las claves"; 
                            }
                        } else {
                            $result['exceptionEN'] = 'Nonexistent mail';
                            $result['exception'] = 'Correo inexistente';
                        }
                    } else {
                        $result['exceptionEN'] = 'Wrong mail';
                        $result['exception'] = 'Correo incorrecto';
                    }
                    break;
                default:
                    exit('Acción no disponible');
            }
        }
    } else {   
        $result['session'] = 0;
        $result['exceptionEN'] = 'Your account has been blocked, because suspicious activity has been detected';
        $result['exception'] = 'Se ha bloqueado tu cuenta, porque se ha detectado una actividad sospechosa';
    } 
    print(json_encode($result));
} else {
    exit('Recurso denegado');
}
?>