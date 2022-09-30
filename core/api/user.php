<?php
require_once('../../core/helpers/database.php');
require_once('../../core/helpers/validator.php');
require_once('../../core/models/user.php');
require_once('../../core/models/actionType.php');

if (isset($_GET['site']) && isset($_GET['action'])) {
    session_start();
    ini_set('date.timezone', 'America/El_Salvador');//Inicializacion de fecha y hora
    $user = new User;
    $result = array('status' => 0, 'exception' => '', 'url' => null, 'session' => 1);
    //Se verifica si existe una sesión iniciada como administrador para realizar las operaciones correspondientes
	if (isset($_SESSION['idUsuario']) && $_GET['site'] == 'dashboard') {
        require 'session.php';
        switch ($_GET['action']) {
            case 'logout':
                if ($user->setId($_SESSION['idUsuario'])) {
                    $user->endOnline();
                    unset($_SESSION['idUsuario']);
                    header('location: ../../views/dashboard/');
                } else {
                    $result['exception'] = 'Usuario incorrecto';
                }
                break;
            case 'getData':
                if($user->setId($_SESSION['idUsuario'])) {
                    if($result['dataset'] = $user->getUser()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'Usuario inexistente';
                   }
                } else {
                    $result['exception'] = 'Usuario incorrecto';
                }
                break;
            case 'getDataP':
                if($user->setId($_SESSION['idUsuario'])) {
                    if($result['dataset'] = $user->getData()) {
                        $_SESSION['userType'] = $user->getTipo();
                        $_SESSION['correoUsuario'] = $user->getCorreo();
                        $_SESSION['fotoUsuario'] = $user->getFoto();
                        $_SESSION['nombreUsuario'] = $user->getNombre().' '.$user->getApellido();
                        $_SESSION['tipoUsuario'] = $user->getTipo();
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'Usuario inexistente';
                   }
                } else {
                    $result['exception'] = 'Usuario incorrecto';
                }
                break;

            case 'password':
                if ($user->setId($_SESSION['idUsuario'])) {
                    $_POST = $user->validateForm($_POST);
                    if ($_POST['claveActual'] == $_POST['claveActual2']) {
                        if ($user->setClave($_POST['claveActual'])) {
                            if ($user->checkPassword()) {
                                if ($_POST['claveNueva'] == $_POST['claveNueva2']) {
                                    if($_POST['claveNueva'] != $user->getClave()){
                                        if ($user->setClave($_POST['claveNueva'])) {
                                            if ($user->changePassword()) {
                                                $result['status'] = 1;
                                            } else {
                                                $result['exception'] = 'Operación fallida';
                                            }
                                        } else {
                                            $result['exception'] = 'Clave nueva menor a 6 caracteres';
                                        }
                                    } else {
                                        $result['exception'] = 'No hay cambio en las claves';
                                    }
                                } else {
                                    $result['exception'] = 'Claves nuevas diferentes';
                                }
                            } else {
                                $result['exception'] = 'Clave actual incorrecta';
                            }
                        } else {
                            $result['exception'] = 'Clave actual menor a 6 caracteres';
                        }
                    } else {
                        $result['exception'] = 'Claves actuales diferentes';
                    }
                } else {
                    $result['exception'] = 'Usuario incorrecto';
                }
                break;
            case 'readUser':
                if($user->setEstado($_POST['Estado'])){
                    if ($result['dataset'] = $user->readUser()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay usuarios';
                    }
                } else{
                    $result['exception'] = 'Estado incorrecto';
                }
                break;
            case 'readTypeUser':
                if ($result['dataset'] = $user->readTypeUser()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay Tipo registradas';
                }
                break;
            case 'createUser':
                $_POST = $user->validateForm($_POST);
                if($user->setNombre($_POST['nuevoNombre'])) {
                    if($user->setApellidos($_POST['nuevoApellido'])) {
                        if($user->setCorreo($_POST['nuevoCorreo'])) {
                            if(empty($_POST['nuevoTipo'])) {
                                $result['exception'] = "Seleccione un tipo de usuario";
                            } else {
                                if($user->setTipo($_POST['nuevoTipo'])) {
                                    if($user->setTelefono($_POST['nuevoTelefono'])) {
                                        if($user->setFecha($_POST['fechaNacimiento'])) {
                                            if($_POST['nuevaClave1']==$_POST['nuevaClave2']) {
                                                if ($_POST['nuevaClave1'] != $_POST['nuevoCorreo']) {
                                                    if($user->setClave($_POST['nuevaClave1'])) {
                                                        if(is_uploaded_file($_FILES['nuevaFoto']['tmp_name'])) {
                                                            if($user->setFoto($_FILES['nuevaFoto'],null)) {
                                                                if($user->createUser()) {
                                                                    if ($user->saveFile($_FILES['nuevaFoto'], $user->getRuta(), $user->getFoto())) {
                                                                        $result['status'] = 1;
                                                                    } else {
                                                                        $result['status'] = 2;
                                                                        $result['exception'] = "No se guardó el archivo";
                                                                    }
                                                                } else {
                                                                    $result['exception'] = "Operación fallida";
                                                                }
                                                            } else {
                                                                $result['exception'] = $user->getImageError();
                                                            }
                                                        } else {
                                                            $result['exception'] = "Seleccione una imagen";
                                                        }
                                                    } else {
                                                        $result['exception'] = $user->getPassError();
                                                    }
                                                } else {
                                                    $result['exception'] = 'El correo y la clave no deben ser iguales';
                                                }
                                            } else {
                                                $result['exception'] = "No coinciden las contraseñas";
                                            }
                                        } else {
                                            $result['exception'] = "Fecha de Nacimiento incorrecta";
                                        }
                                    } else {
                                        $result['exception'] = "Teléfono incorrecto FORMATO: XXXX-XXXX";
                                    }
                                } else {
                                    $result['exception'] = "Tipo de Usuario incorrecto";
                                }
                            }
                        } else {
                            $result['exception'] = "Correo incorrecto";
                        }
                    } else {
                        $result['exception'] = "Apellido incorrecto";
                    }
                } else {
                    $result['exception'] = 'Nombre incorrecto';
                }
                break;
            case'get':
                if($user->setId($_POST['idUser'])) {
                    if($result['dataset'] = $user->getUser()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'Usuario inexistente';
                    }
                } else {
                    $result['exception'] = 'Usuario incorrecto';
                }
                break;
            case 'updateUser':
                $_POST = $user->validateForm($_POST);
                if($user->setId($_POST['idUsuario'])) {
                    if($user->getUser()) {
                        if($user->setNombre($_POST['actualizarNombre'])) {
                            if($user->setApellidos($_POST['actualizarApellido'])) {
                                if($user->setCorreo($_POST['actualizarCorreo'])) {
                                    if($user->setFecha($_POST['afechaNacimiento'])) {
                                        if($user->setTelefono($_POST['actualizarTelefono'])) {
                                            if(empty('actualizarTipo')) {
                                                $result['exception'] = 'Seleccione un tipo de usuario';
                                            } else {
                                                if($user->setTipo($_POST['actualizarTipo'])) {
                                                    if(is_uploaded_file($_FILES['actualizarFoto']['tmp_name'])) {
                                                        if($user->setFoto($_FILES['actualizarFoto'],$_POST['fotoUsuario'])) {
                                                            $imagen = true;
                                                        } else {
                                                            $result['exception'] = $user->getImageError();
                                                            $imagen = false;
                                                        }
                                                    } else {
                                                        if($user->setFoto(null, $_POST['fotoUsuario'])) {
                                                            $result['exception'] = 'No cambio imagen';
                                                        } else {
                                                            $result['exception'] = $user->getImageError();
                                                        }
                                                        $imagen = false;
                                                    }
                                                    if($user->updateUser()) {
                                                        if($imagen) {
                                                            if($user->saveFile($_FILES['actualizarFoto'],$user->getRuta(),$user->getFoto())){
                                                                $result['status'] = 1;
                                                            } else {
                                                                $result['status'] = 2;
                                                                $result['exception'] = 'No se guardo el archivo';
                                                            }
                                                        } else {
                                                            $result['status'] = 3;
                                                        }
                                                        if($_POST['idUsuario'] == $_SESSION['idUsuario']){
                                                            if($user->getData()){
                                                                $result['status'] = 1;
                                                            }
                                                        }
                                                    } else {
                                                        $result['exception'] = 'Operación fallida';
                                                    }
                                                } else {
                                                    $result['exception'] = 'Tipo de Usuario incorrecto';
                                                }
                                            }
                                        }else{
                                            $result['exception'] = 'Télefono Incorrecto FORMATO: XXXX-XXXX';
                                        }
                                    }else{
                                        $result['exception'] = 'Fecha de Nacimiento incorrecta';
                                    }
                                }else{
                                    $result['exception'] = 'Correo incorrecto';
                                }
                            }else{
                                $result['exception'] = 'Apellido incorrecto';
                            }
                        }else{
                            $result['exception'] = 'Nombre incorrecto';
                        }
                    }else{
                        $result['exception'] = 'Usuario inexistente';
                    }
                }else{
                    $result['exception'] = 'Usuario incorrecto';
                }
                break;
            case 'actUser':
                if($_POST['idUser'] != $_SESSION['idUsuario']){
                    if($user->setId($_POST['idUser'])){
                        if($user->getUser()){
                            if($user->setEstado($_POST['statusUser'])){
                                if($user->actUser()){
                                    $result['status'] = 1;
                                } else {
                                    $result['exception'] = "Operación fallida";
                                }
                            } else {
                                $result['exception'] = "Estado incorrecto";
                            }
                        } else {
                            $result['exception'] = "Usuario inexistente";
                        }
                    } else {
                        $result['exception'] = "Usuario incorrecto";
                    }
                } else {
                    $result['exception'] = "No se puede eliminar usted mismo";
                }
                break;
            case 'showAction':
                if ($result['dataset'] = $user->showAction()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay acciones disponibles';
                }
                break;
            case 'readType':
                if ($result['dataset'] = $user->readTypeUser()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay tipos de usuario disponibles';
                }
                break;
            case 'getType':
                if ($user->setId($_POST['identifier'])) {
                    if ($result['dataset'] = $user->getType()) {
                        $result['dataset2'] = $user->getIdAction();
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'Tipo de usuario inexistente';
                    }
                } else {
                    $result['exception'] = 'Tipo de usuario incorrecto';
                }
                break;
            case 'createType':
                $_POST = $user->validateForm($_POST);//Validación de espacios en blanco
                foreach ($_POST as $index => $value) {//Bucle para recorrer los datos
                    $name = explode("_",$index);
                    if($name[0] == 'create'){
                        if($result['exception'] == null){
                            if($user->setAccion($name[1])){//Asignación de la accion
                                if($user->createPrivilege()){ //Ejecución del método para crear un nuevo privilegio
                                    $result['status'] = 1;
                                } else {
                                    $result['status'] = 0;
                                    $result['exception'] = 'Operación fallida';
                                }
                            } else{
                                $result['exception'] = 'Acción incorrecto';
                            }
                        } else {
                            continue;
                        }
                    } else if($name[0] == 'nuevoTipo'){
                        if($user->setNombre($_POST[$index])){//Asignación del nombre
                            if(!$user->createType()){//Ejecución del método para crear el tipo de usuario
                                $result['exception'] = 'Operación fallida';
                            }
                        } else {
                            $result['exception'] = 'Nombre incorrecto';
                        }
                    }
                }
                break;
            case 'updateType':
                $_POST = $user->validateForm($_POST);//Validación de espacios en blanco en formulario
                foreach ($_POST as $index => $value) {
                    $name = explode("_",$index);
                    if($name[0] == 'update'){
                        if($result['exception'] == null){
                            if($user->setAccion($name[1])){//Asignación de la accion a modificar
                                if($user->createPrivilege()){ //Ejecución del método para actualizar privilegio
                                    $result['status'] = 1;
                                    $result['message'] = 'Tipo de Usuario modificado correctamente';
                                } else {
                                    $result['status'] = 0;
                                    $result['exception'] = 'Operación fallida';
                                }
                            } else{
                                $result['exception'] = 'Acción incorrecto';
                            }
                        } else {
                            continue;
                        }
                    } else if($name[0] == 'actualizarNombre'){
                        if($user->setNombre($_POST[$index])){
                            if($user->updateType()){//Ejecución del método para actualizar tipo de usuario
                                $result['status'] = 1;
                                $result['message'] = 'Tipo de Usuario modificado pero sin Privilegios';
                            } else {
                                $result['exception'] = 'Operación fallida';
                            }
                        } else {
                            $result['exception'] = 'Nombre incorrecto';
                        }
                    } else if ($name[0] == 'idTipo'){
                        if(!$user->setId($_POST[$index])){
                            $result['exception'] = 'Tipo de Usuario incorrecto';
                        }
                    }
                }
                break;
            case 'readAction':
                if ($result['dataset'] = $user->readAction()) {
                    $_SESSION['pages'] = array();
                    array_push($_SESSION['pages'],'main.php');
                    array_push($_SESSION['pages'],'personalInformation.php');
                    foreach ($result['dataset'] as $action) {
                        array_push($_SESSION['pages'],$action['Link'].'.php');
                    }
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay acciones disponibles';
                }
                break;
            default:
                exit('Acción no disponible');
        }

    } else if($_GET['site'] == 'dashboard') {
        switch ($_GET['action']) {
            case 'read':
                if($user->setEstado(1)){
                    if ($user->readUser()) {
                        $result['status'] = 1;
                        $result['exception'] = 'Existe al menos un usuario registrado';
                    } else {
                        $result['status'] = 2;
                        $result['exception'] = 'No existen usuarios registrados';
                    }
                } else {
                    $result['exception'] = 'Estado incorrecto';
                }
                break;

            case 'login':
                $_POST = $user->validateForm($_POST);
                if ($user->setCorreo($_POST['email'])) {
                    if ($user->checkCorreo()) {
                        $data = $user->checkUser();
                        if ($data['Estado'] == 1) {
                            if ($user->setClave($_POST['password'])) {
                                if ($user->checkPassword()) {
                                    if ($data['Online'] == 0){
                                        if ($data['Fecha'] > date('Y-m-d')) {
                                            $user->startOnline();
                                            $user->restartCount();
                                            $_SESSION['idUsuario'] = $user->getId();
                                            $_SESSION['correoUsuario'] = $user->getCorreo();
                                            $_SESSION['fotoUsuario'] = $user->getFoto();
                                            $_SESSION['nombreUsuario'] = $user->getNombre().' '.$user->getApellido();
                                            $_SESSION['tipoUsuario'] = $user->getTipo();
                                            $_SESSION['tiempo'] = time();
                                            if ($result['dataset'] = $user->readAction()) {
                                                $_SESSION['pages'] = array();
                                                array_push($_SESSION['pages'],'main.php');
                                                array_push($_SESSION['pages'],'personalInformation.php');
                                                foreach ($result['dataset'] as $action) {
                                                    array_push($_SESSION['pages'],$action['Link'].'.php');
                                                }
                                                $result['status'] = 1;
                                            } else {
                                                $result['exception'] = 'No hay acciones disponibles';
                                            }
                                        } else {
                                            $result['exception'] = 'Debes cambiar tu clave';
                                            $_SESSION['correoUsuario'] = $user->getCorreo();
                                            $result['url'] = 'updatePass.php';
                                        }
                                    } else {
                                        include '../emails/email.php';
                                        $code = rand('000000','999999');
                                        if (Email::verificationCode($user->getCorreo(), $code)) {
                                            $result['exception'] = 'El usuario está en línea';
                                            $user->createCode($code);
                                            $user->lockUser();
                                            $user->endOnline();
                                        } else {
                                            $result['exception'] = 'No se puedo enviar el correo';
                                        }
                                    }
                                } else {
                                    $count = 2 - (int) $user->getLock();
                                    if ($count <= 0) {
                                        if ($user->userLock()) {
                                            $result['exception'] = 'Se te ha bloqueado tu cuenta por 24 horas, o hasta que puedas desbloquear';
                                        } else {
                                            $result['exception'] = 'No se ha podido bloquear la cuenta';
                                        }
                                    } else {
                                        $result['exception'] = 'La clave no es correcta. Te faltan '.$count.' intentos';
                                        $user->sumLock();
                                    }
                                }
                            } else {
                                $count = 2 - (int) $user->getLock();
                                if ($count <= 0) {
                                    if ($user->userLock()) {
                                        $result['exception'] = 'Se te ha bloqueado tu cuenta por 24 horas, o hasta que puedas desbloquear';
                                    } else {
                                        $result['exception'] = 'No se ha podido bloquear la cuenta';
                                    }
                                } else {
                                    $result['exception'] = 'La clave no es correcta. Te faltan '.$count.' intentos';
                                    $user->sumLock();
                                }
                            }
                        } else {
                            $_SESSION['correoUsuario'] = $user->getCorreo();
                            $user->endOnline();
                            $result['exception'] = 'Usuario bloqueado';
                            if ($data['Bloqueo']) {
                                if (date("Y-m-d G:i:s",strtotime($data['Bloqueo'].' + 24 hours')) <=  date("Y-m-d G:i:s")) {
                                    $user->unlockUser();
                                    if ($user->setClave($_POST['password'])) {
                                        if ($user->checkPassword()) {
                                            if ($data['Online'] == 0){
                                                if ($data['Fecha'] > date('Y-m-d')) {
                                                    $user->startOnline();
                                                    $user->restartCount();
                                                    $_SESSION['idUsuario'] = $user->getId();
                                                    $_SESSION['correoUsuario'] = $user->getCorreo();
                                                    $_SESSION['fotoUsuario'] = $user->getFoto();
                                                    $_SESSION['nombreUsuario'] = $user->getNombre().' '.$user->getApellido();
                                                    $_SESSION['tipoUsuario'] = $user->getTipo();
                                                    $_SESSION['tiempo'] = time();
                                                    if ($result['dataset'] = $user->readAction()) {
                                                        $_SESSION['pages'] = array();
                                                        array_push($_SESSION['pages'],'main.php');
                                                        array_push($_SESSION['pages'],'personalInformation.php');
                                                        foreach ($result['dataset'] as $action) {
                                                            array_push($_SESSION['pages'],$action['Link'].'.php');
                                                        }
                                                        $result['status'] = 1;
                                                    } else {
                                                        $result['exception'] = 'No hay acciones disponibles';
                                                    }
                                                } else {
                                                    $result['exception'] = 'Debes cambiar tu clave';
                                                    $_SESSION['correoUsuario'] = $user->getCorreo();
                                                    $result['url'] = 'updatePass.php';
                                                }
                                            } else {
                                                include '../emails/email.php';
                                                $code = rand('000000','999999');
                                                if (Email::verificationCode($user->getCorreo(), $code)) {
                                                    $result['exception'] = 'El usuario está en línea';
                                                    $user->createCode($code);
                                                    $user->lockUser();
                                                    $user->endOnline();
                                                } else {
                                                    $result['exception'] = 'No se puedo enviar el correo';
                                                }
                                            }
                                        } else {
                                            $count = 2 - (int) $user->getLock();
                                            if ($count <= 0) {
                                                if ($user->userLock()) {
                                                    $result['exception'] = 'Se te ha bloqueado tu cuenta por 24 horas, o hasta que puedas desbloquear';
                                                } else {
                                                    $result['exception'] = 'No se ha podido bloquear la cuenta';
                                                }
                                            } else {
                                                $result['exception'] = 'La clave no es correcta. Te faltan '.$count.' intentos';
                                                $user->sumLock();
                                            }
                                        }
                                    } else {
                                        $count = 2 - (int) $user->getLock();
                                        if ($count <= 0) {
                                            if ($user->userLock()) {
                                                $result['exception'] = 'Se te ha bloqueado tu cuenta por 24 horas, o hasta que puedas desbloquear';
                                            } else {
                                                $result['exception'] = 'No se ha podido bloquear la cuenta';
                                            }
                                        } else {
                                            $result['exception'] = 'La clave no es correcta. Te faltan '.$count.' intentos';
                                            $user->sumLock();
                                        }
                                    }
                                } else {
                                    $result['exception'] = 'Usuario bloqueado';
                                    $result['url'] = 'updatePass.php';
                                }
                            } else {
                                $result['url'] = 'recoverUser.php';
                            }
                        }
                    } else {
                        $result['exception'] = 'Correo inexistente';
                    }
                } else {
                    $result['exception'] = 'Correo incorrecto';
                }
                break;
            case 'recoverUser':
                $_POST = $user->validateForm($_POST);
                if ($user->setCorreo($_POST['emailUser'])){
                    if ($user->checkCorreo()) {
                        if ($user->checkCode($_POST['codeUser'])){
                            $user->updateStatus();
                            $result['status'] = 1;
                        } else {
                            $result['exception'] = 'El código no es correcto. Vuelve a intentarlo';
                        }
                    } else {
                        $result['exception'] = 'Correo inexistente';
                    }
                } else {
                    $result['exception'] = 'Correo incorrecto';
                }
                break;
            case 'createUser':
                $_POST = $user->validateForm($_POST);
                if($user->setNombre($_POST['nuevoNombre'])) {
                    if($user->setApellidos($_POST['nuevoApellido'])) {
                        if($user->setCorreo($_POST['nuevoCorreo'])) {
                            if($user->setTipo(1)) {
                                if($user->setTelefono($_POST['nuevoTelefono'])) {
                                    if($user->setFecha($_POST['fechaNacimiento'])) {
                                        if($_POST['nuevaClave1']==$_POST['nuevaClave2']) {
                                            if($_POST['nuevaClave1'] != $_POST['nuevoCorreo']) {
                                                if($user->setClave($_POST['nuevaClave1'])) {
                                                    if(is_uploaded_file($_FILES['nuevaFoto']['tmp_name'])) {
                                                        if($user->setFoto($_FILES['nuevaFoto'],null)) {
                                                            if($user->createUser()) {
                                                                if ($user->saveFile($_FILES['nuevaFoto'], $user->getRuta(), $user->getFoto())) {
                                                                    $result['status'] = 1;
                                                                } else {
                                                                    $result['status'] = 2;
                                                                    $result['exception'] = "No se guardó el archivo";
                                                                }
                                                            } else {
                                                                $result['exception'] = "Operación fallida";
                                                            }
                                                        } else {
                                                            $result['exception'] = $user->getImageError();
                                                        }
                                                    } else {
                                                        $result['exception'] = "Seleccione una imagen";
                                                    }
                                                } else {
                                                    $result['exception'] = $user->getPassError();
                                                }
                                            } else {
                                                $result['exception'] = "Tu correo no debe ser tu clave";
                                            }
                                        } else {
                                            $result['exception'] = "No coinciden las contraseñas";
                                        }
                                    } else {
                                        $result['exception'] = "Fecha de Nacimiento incorrecta";
                                    }
                                } else {
                                    $result['exception'] = "Teléfono incorrecto FORMATO: XXXX-XXXX";
                                }
                            } else {
                                $result['exception'] = "Tipo de Usuario incorrecto";
                            }
                        } else {
                            $result['exception'] = "Correo incorrecto";
                        }
                    } else {
                        $result['exception'] = "Apellido incorrecto";
                    }
                } else {
                    $result['exception'] = 'Nombre incorrecto';
                }
                break;
            case 'restorePass':
                if ($user->setCorreo($_SESSION['correoUsuario'])) {
                    if ($user->checkCorreo()) {
                        if ($_POST['nuevaClave1'] = $_POST['nuevaClave2']) {
                            if ($_POST['nuevaClave1'] != $_SESSION['correoUsuario']) {
                                if ($user->newPass($_POST['nuevaClave1'])) {
                                    if ($user->changePassword()) {
                                        $user->updateStatus();
                                        $user->unlockUser();
                                        $result['status'] = 1;
                                        $result['message'] = 'Se cambio la clave exitosamente';
                                    } else {
                                        $result['exception'] = "Operación fallida";
                                    }
                                } else {
                                    $result['exception'] = "No hay cambio en las claves";
                                }
                            } else {
                                $result['exception'] = "Tu correo no debe ser tu clave";
                            }
                        } else {
                            $result['exception'] = "No coinciden las claves";
                        }
                    } else {
                        $result['exception'] = 'Correo inexistente';
                    }
                } else {
                    $result['exception'] = 'Correo incorrecto';
                }
                break;
            case 'emailCode':
                if ($user->setCorreo($_POST['email'])) {
                    if ($user->checkCorreo()) {
                        include '../emails/email.php';
                        $code = rand('000000','999999');
                        if (Email::updatePass($user->getCorreo(), $code)) {
                            $result['status'] = 1;
                            $user->createCode($code);
                            $user->lockUser();
                            $user->endOnline();
                            $_SESSION['correoUsuario'] = $user->getCorreo();
                        } else {
                            $result['exception'] = 'No se pudo enviar el correo';
                        }
                    } else {
                        $result['exception'] = 'Correo inexistente';
                    }
                } else {
                    $result['exception'] = 'Correo incorrecto';
                }
                break;
            default:
                exit('Acción no disponible');
                break;
        }
    } else {
        $result['session'] = 0;
        $result['exception'] = 'Se ha bloqueado tu cuenta, porque se ha detectado una actividad sospechosa';
    }
    print(json_encode($result));
    //Assign the current timestamp as the user's
    //latest activity
    $_SESSION['last_action'] = time();
} else {
	exit('Recurso denegado');
}
?>