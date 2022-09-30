<?php
require_once('../../core/helpers/database.php');
require_once('../../core/helpers/validator.php');
require_once('../../core/models/product.php');

if (isset($_GET['site']) && isset($_GET['action'])) {
    session_start();
    $product = new Product;
    $result = array('status' => 0, 'exception' => '','session' => 1);
    //Se verifica si existe una sesión iniciada como administrador para realizar las operaciones correspondientes
	if (isset($_SESSION['idUsuario']) && $_GET['site'] == 'dashboard') {
        require 'session.php';
        switch ($_GET['action']) {
            case 'readProduct':
                if($product->setEstado($_POST['Estado'])){
                    if ($result['dataset'] = $product->readProduct()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay productos registrados';
                    }
                } else {
                    $result['exception'] = 'Estado incorrecto';
                }
                break;
            case 'readTypeProduct':
                if ($result['dataset'] = $product->readTypeProduct()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay productos registrados';
                }
                break;
            case 'readTypeEvent':
                if ($result['dataset'] = $product->readTypeEvent()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay productos registrados';
                }
                break;
            case 'readProvider':
                if ($result['dataset'] = $product->readProviders()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay productos registrados';
                }
                break;
            case 'createProduct':
                $_POST = $product->validateForm($_POST);
                if($product->setNombre($_POST['nuevoNombre'])){
                    if($product->setDescripcion($_POST['nuevoDescripcion'])){
                        if($product->setPrecio($_POST['nuevoPrecio'])){
                            if($product->setCantidad($_POST['nuevoCantidad'])){
                                if(empty($_POST['nuevoTipo'])){
                                    $result['exception'] = 'Seleccione un Tipo de Producto';
                                } else {
                                    if($product->setTipo($_POST['nuevoTipo'])){
                                        if(empty($_POST['nuevoEvento'])){
                                            $result['exception'] = 'Seleccione un Tipo de Evento';
                                        } else {
                                            if($product->setEvento($_POST['nuevoEvento'])){
                                                if(empty($_POST['nuevoProveedor'])){
                                                    $result['exception'] = 'Seleccione un Proveedor';
                                                } else {
                                                    if($product->setProveedor($_POST['nuevoProveedor'])) {
                                                        if(is_uploaded_file($_FILES['nuevaFoto']['tmp_name'])) {
                                                            if($product->setFoto($_FILES['nuevaFoto'],null)){
                                                                if($product->createProduct()){
                                                                    if ($product->saveFile($_FILES['nuevaFoto'], $product->getRuta(), $product->getFoto())) {
                                                                        $result['status'] = 1;
                                                                    } else {
                                                                        $result['status'] = 2;
                                                                        $result['exception'] = "No se guardó el archivo";
                                                                    }
                                                                } else {
                                                                    $result['exception'] = "Operación fallida";    
                                                                }
                                                            } else {
                                                                $result['exception'] = $product->getImageError();
                                                            }
                                                        } else {
                                                            $result['exception'] = "Seleccione una imagen";
                                                        }
                                                    } else {
                                                        $result['exception'] = 'Proveedor incorrecto';        
                                                    }
                                                }
                                            } else {
                                                $result['exception'] = 'Tipo de Evento incorrecto';       
                                            }
                                        }
                                    } else {
                                        $result['exception'] = 'Tipo de Producto incorrecto';    
                                    }
                                }
                            } else {
                                $result['exception'] = 'Cantidad incorrecto';
                            }
                        } else {
                            $result['exception'] = 'Precio incorrecto';
                        }
                    } else {
                        $result['exception'] = 'Descripción incorrecto';    
                    }
                } else {
                    $result['exception'] = 'Nombre incorrecto';
                }
                break;
            case 'getQuantity':
                if($product->setId($_POST['idProduct'])){
                    if($result['dataset'] = $product->getQuantity()){
                        $result['status'] = 1; 
                    } else {
                        $result['exception'] = 'Producto inexistente';    
                    }
                } else {
                    $result['exception'] = 'Producto incorrecto';
                }
                break;
            case 'updateQuantity':
                $_POST = $product->validateForm($_POST);
                if($product->setId($_POST['idProducto'])){
                    if($product->setCantidad($_POST['actualizarCantidad'])) {
                        if($product->updateQuantity()){
                            $result['status'] = 1;
                        }else{
                            $result['exception'] = 'Operación fallida';    
                        }
                    } else {
                        $result['exception'] = 'Cantidad incorrecto';    
                    }
                } else {
                    $result['exception'] = 'Usuario incorrecto';
                }
                break;
            case 'resupplyProducts':
                if($product->setId($_POST['Codigo'])){
                    if($product->setCantidad($_POST['Cantidad'])) {
                        if($product->updateQuantity()){
                            $result['status'] = 1;
                        }else{
                            $result['exception'] = 'Operación fallida';    
                        }
                    } else {
                        $result['exception'] = 'Cantidad incorrecto';    
                    }
                } else {
                    $result['exception'] = 'Producto incorrecto';
                }
                break;
            case 'getComments':
                if($product->setId($_POST['idProduct'])){
                    if($result['dataset'] = $product->getComment()){
                        $result['status'] = 1; 
                    } else {
                        $result['exception'] = 'No contiene comentario';    
                    }
                } else {
                    $result['exception'] = 'Producto incorrecto';
                }
                break;
            case 'getStatusComment':
                if($product->setId($_POST['idComment'])){
                    if($result['dataset'] = $product->getStatusComment()){
                        $result['status'] = 1; 
                    } else {
                        $result['exception'] = 'Comentario inexistente';    
                    }
                } else {
                    $result['exception'] = 'Comentario incorrecto';
                }
                break;
            case 'updateComment':
                $_POST = $product->validateForm($_POST);
                if($product->setId($_POST['idCom'])){
                    if($product->setEstado(isset($_POST['actualizarEstadoCom']) ? 1 : 0)){
                        if($product->updateComment()){
                            $result['status'] = 1;
                        }else{
                            $result['exception'] = 'Operación fallida';    
                        }
                    }else{
                        $result['exception'] = 'Estado incorrecto';
                    }
                }else{
                    $result['exception'] = 'Comentario incorrecto';
                }
                break;
            case 'getRating':
                if($product->setId($_POST['idProduct'])){
                    if($result['dataset'] = $product->getRating()){
                        $result['status'] = 1; 
                    } else {
                        $result['exception'] = 'No contiene Valoración';    
                    }
                } else {
                    $result['exception'] = 'Producto incorrecto';
                }
                break;
            case 'getStatusRating':
                if($product->setId($_POST['idRating'])){
                    if($result['dataset'] = $product->getStatusRating()){
                        $result['status'] = 1; 
                    } else {
                        $result['exception'] = 'Valoración inexistente';    
                    }
                } else {
                    $result['exception'] = 'Valoración incorrecto';
                }
                break;
            case 'updateRating':
                $_POST = $product->validateForm($_POST);
                if($product->setId($_POST['idVal'])){
                    if($product->setEstado(isset($_POST['actualizarEstadoVal']) ? 1 : 0)){
                        if($product->updateRating()){
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
            case 'getProduct':
                if($product->setId($_POST['idProduct'])){
                    if($result['dataset'] = $product->getProduct()){
                        $result['status'] = 1; 
                    } else {
                        $result['exception'] = 'Producto inexistente';    
                    }
                } else {
                    $result['exception'] = 'Producto incorrecto';
                }
                break;
            case 'updateProduct':
                $_POST = $product->validateForm($_POST);
                if($product->setId($_POST['codProducto'])){
                    if($product->getProduct()){
                        if($product->setNombre($_POST['actualizarNombre'])) {
                            if($product->setDescripcion($_POST['actualizarDescripcion'])) {
                                if($product->setPrecio($_POST['actualizarPrecio'])) {
                                    if(empty($_POST['actualizarTipo'])) {
                                        $result['exception'] = "Seleccione un tipo de Producto";
                                    }else{
                                        if($product->setTipo($_POST['actualizarTipo'])){
                                            if(empty($_POST['actualizarEvento'])) {
                                                $result['exception'] = "Seleccione un tipo de Evento";
                                            } else {
                                                if($product->setEvento($_POST['actualizarEvento'])) {
                                                    if(empty($_POST['actualizarProveedor'])) {
                                                        $result['exception'] = "Seleccione un Proveedor";
                                                    } else {
                                                        if($product->setProveedor($_POST['actualizarProveedor'])) {
                                                            if($product->setEstado(isset($_POST['actualizarEstado']) ? 1 : 0)){
                                                                if(is_uploaded_file($_FILES['actualizarFoto']['tmp_name'])) {
                                                                    if($product->setFoto($_FILES['actualizarFoto'],$_POST['fotoProducto'])) {
                                                                        $imagen = true;
                                                                    } else {
                                                                        $result['exception'] = $product->getImageError();
                                                                        $imagen = false;
                                                                    }
                                                                } else {
                                                                    if($product->setFoto(null,$_POST['fotoProducto'])) {
                                                                        $result['exception'] = 'No cambio imagen';
                                                                        $imagen = true;
                                                                    } else {
                                                                        $result['exception'] = $product->getImageError();
                                                                        $imagen = false;
                                                                    }
                                                                    
                                                                }
                                                                if($imagen){
                                                                    if($product->updateProduct()){
                                                                        if($product->saveFile($_FILES['actualizarFoto'],$product->getRuta(),$product->getFoto())){
                                                                            $result['status'] = 1;
                                                                        } else {
                                                                            $result['status'] = 2;
                                                                            $result['exception'] = 'No se guardo el archivo';
                                                                        }
                                                                    } else {
                                                                        $result['exception'] = 'Operación fallida';
                                                                    }
                                                                }
                                                            }else{
                                                                $result['exception'] = "Estado Incorrecto";
                                                            }
                                                        } else {
                                                            $result['exception'] = "Proveedor Incorrecto";
                                                        }
                                                    }
                                                } else {
                                                    $result['exception'] = "Tipo de Evento Incorrecto";
                                                }
                                            }
                                        } else {
                                            $result['exception'] = "Tipo de Producto Incorrecto";
                                        }
                                    }
                                } else {
                                    $result['exception'] = "Precio Incorrecto";
                                }
                            } else {
                                $result['exception'] = "Descripcion Incorrecto";
                            }
                        } else {
                            $result['exception'] = "Nombre Incorrecto";
                        }
                    } else {
                        $result['exception'] = "Producto inexistente";    
                    }
                } else {
                    $result['exception'] = "Producto incorrecto";
                }
                break;
            case 'actProduct':
                if($product->setId($_POST['idProduct'])){
                    if($product->getProduct()){
                        if($product->setEstado($_POST['statusProduct'])){
                            if($product->actProduct()){
                                $result['status'] = 1;
                            } else {
                                $result['exception'] = "Operación fallida";
                            }
                        } else {
                            $result['exception'] = "Estado incorrecto";
                        }
                    } else {
                        $result['exception'] = "Producto inexistente";
                    }
                } else {
                    $result['exception'] = "Producto incorrecto";
                }
                break;
            case 'reports':
                $_SESSION['idInvoices'] = $_POST['idInvoices'];
                break;
            case 'getSalesThroTime':

                    if($result['dataset'] = $product->getSalesThroughTime())
                        $result['status'] = 1;
                    else
                        $result['exception'] = "Producto incorrecto";
                break;
            case 'fillCards':
                if($result['dataset'] = $product->getMostTypeProduct()){
                    if($result['dataset2'] = $product->getMostTypeEvent()){
                        if($result['dataset3'] = $product->getOneMostProduct()){
                            if($result['dataset4'] = $product->getWinnings()){
                                if($result['dataset5'] = $product->getMostProduct()){
                                    if($result['dataset6'] = $product->getLessProduct()){
                                        $result['status'] = 1;
                                    }
                                }
                            }
                        }
                    }
                }
                break;
            default:
                exit('Acción no disponible');
        }
    } else if($_GET['site'] == 'commerce'){
        require 'sessionClient.php';
        switch ($_GET['action']){
            case 'readProductType':
                if($product->setTipo($_POST['type'])){
                    if($result['dataset'] = $product->readProductType()){
                        $result['status'] = 1;
                    } else {
                        $result['exceptionEN'] = 'No products available';
                        $result['exception'] = 'No hay productos disponible';
                    }
                } else {
                    $result['exceptionEN'] = 'Wrong Product Type';
                    $result['exception'] = 'Tipo de Producto incorrecto';
                }
                break;
            case 'searchProductType':
                $_POST = $product->validateForm($_POST);
                if($product->setTipo($_POST['type'])){
                    if($result['dataset'] = $product->searchProductType($_POST['value'])){
                        $result['status'] = 1;
                    } else {
                        $result['exceptionEN'] = 'No results in your search';
                        $result['exception'] = 'No hay resultados en su búsqueda';
                    }
                } else {
                    $result['exceptionEN'] = 'Wrong Product Type';
                    $result['exception'] = 'Tipo de Producto incorrecto';
                }
                break;
            case 'readProductEvents':
                if($product->setEvento($_POST['type'])){
                    if($result['dataset'] = $product->readProductEvents()){
                        $result['status'] = 1;
                    } else {
                        $result['exceptionEN'] = 'No products available';
                        $result['exception'] = 'No hay productos disponible';
                    }
                } else {
                    $result['exceptionEN'] = 'Wrong Product Type';
                    $result['exception'] = 'Tipo de Producto incorrecto';
                }
                break; 
            case 'searchProductEvents':
                $_POST = $product->validateForm($_POST);
                if($product->setEvento($_POST['type'])){
                    if($result['dataset'] = $product->searchProductEvents($_POST['value'])){
                        $result['status'] = 1;
                    } else {
                        $result['exceptionEN'] = 'No results in your search';
                        $result['exception'] = 'No hay resultados en su búsqueda';
                    }
                } else {
                    $result['exceptionEN'] = 'Wrong Product Type';
                    $result['exception'] = 'Tipo de Producto incorrecto';
                }
                break;
            case 'getProductDetails':
                if($product->setId($_POST['idProducts'])){
                    if($result['dataset'] = $product->detailsProduct()){
                        $result['status'] = 1;
                    } else {
                        $result['exceptionEN'] = 'Nonexistent Product';
                        $result['exception'] = 'Producto Inexistente';
                    }
                } else {
                    $result['exceptionEN'] = 'Wrong Product';
                    $result['exception'] = 'Producto incorrecto';
                }
                break;
            case 'getComments':
                if($product->setId($_POST['idProduct'])){
                    if($result['dataset'] =$product->getCommentProduct()){
                        $result['status'] = 1;
                    } else {
                        $result['exceptionEN'] = 'No comments on this product';
                        $result['exception'] = 'No tiene comentarios este producto';
                    }
                } else {
                    $result['exceptionEN'] = 'Wrong Product';
                    $result['exception'] = 'Producto incorrecto';
                }
                break;
            case 'getRating':
                if($product->setId($_POST['idProduct'])){
                    if($result['dataset'] =$product->getRatingProduct()){
                        $result['status'] = 1;
                    } else {
                        $result['exceptionEN'] = 'This product has no ratings';
                        $result['exception'] = 'No tiene valoraciones este producto';
                    }
                } else {
                    $result['exceptionEN'] = 'Wrong Product';
                    $result['exception'] = 'Producto incorrecto';
                }
                break;
            case 'createComment':
                $_POST = $product->validateForm($_POST);
                if(isset($_SESSION['idCliente'])){
                    if($product->setCliente($_SESSION['idCliente'])){
                        if($product->setId($_POST['idPro'])){
                            if($product->setComentario($_POST['comentario'])){
                                if($product->createCommentProduct()){
                                    $result['status'] = 1;
                                } else{
                                    $result['exceptionEN'] = 'Operation Failed';
                                    $result['exception'] = 'Operación Fallida';
                                }
                            } else {
                                $result['exceptionEN'] = 'Wrong Comment';
                                $result['exception'] = 'Comentario incorrecto';
                            }
                        } else {
                            $result['exceptionEN'] = 'Wrong Product';
                            $result['exception'] = 'Producto incorrecto';
                        }
                    } else {
                        $result['exceptionEN'] = 'Wrong Customer';
                        $result['exception'] = 'Cliente incorrecto'; 
                    }
                } else {
                    $result['exceptionEN'] = 'Login or Create an account';
                    $result['exception'] = 'Inicie Sesión o Crea una cuenta';
                }
                break;
            case 'createRating':
                $_POST = $product->validateForm($_POST);
                if(isset($_SESSION['idCliente'])){
                    if($product->setCliente($_SESSION['idCliente'])){
                        if($product->setId($_POST['idProd'])){
                            if($product->setValoracion($_POST['nuevoValoracion'])){
                                if($product->createRatingProdcut()){
                                    $result['status'] = 1;
                                } else{
                                    $result['exceptionEN'] = 'Operation failed';
                                    $result['exception'] = 'Operación Fallida';
                                }
                            } else {
                                $result['exceptionEN'] = 'Wrong rating';
                                $result['exception'] = 'Valoración incorrecto';
                            }
                        } else {
                            $result['exceptionEN'] = 'Wrong Product';
                            $result['exception'] = 'Producto incorrecto';
                        }
                    } else {
                        $result['exceptionEN'] = 'Wrong Customer';
                        $result['exception'] = 'Cliente incorrecto'; 
                    }
                } else {
                    $result['exceptionEN'] = 'Login or Create an account';
                    $result['exception'] = 'Inicie Sesión o Crea una cuenta';
                }
                break;
            case 'createPre':
                if(isset($_SESSION['idCliente'])){
                    if($product->setCliente($_SESSION['idCliente'])){
                        if($product->setId($_POST['idProduct'])){
                            $data = $product->getQuantity();
                            if($data){
                                if($data['cantidadProducto']>=$_POST['value']){
                                    if($product->setCantidad($_POST['value']) && $_POST['value'] > 0){
                                        if($product->insertPre()){
                                            $result['status'] = 1;
                                        } else {
                                            $result['exceptionEN'] = 'Operation failed';
                                            $result['exception'] = 'Operación fallido';                    
                                        }
                                    } else {
                                        $result['exceptionEN'] = 'Wrong Amount';
                                        $result['exception'] = 'Cantidad Incorrecto';                
                                    }
                                } else{
                                    $result['exceptionEN'] = 'Amount must be less than:'.$data['cantidadProducto'];
                                    $result['exception'] = 'Cantidad tiene que ser menor a:'.$data['cantidadProducto'];
                                }
                            } else {
                                $result['exceptionEN'] = 'Nonexistent product';
                                $result['exception'] = 'Producto inexistente';
                            }
                        } else {
                            $result['exceptionEN'] = 'Wrong Product';
                            $result['exception'] = 'Producto incorrecto';
                        }
                    } else {
                        $result['exceptionEN'] = 'Wrong Customer';
                        $result['exception'] = 'Cliente incorrecto'; 
                    }
                } else {
                    $result['exceptionEN'] = 'Login or Create an account';
                    $result['exception'] = 'Inicie Sesión o Crea una cuenta';
                }
                break;
            case 'getPre':
                $_POST = $product->validateForm($_POST);
                if(isset($_SESSION['idCliente'])){
                    if($product->setCliente($_SESSION['idCliente'])){
                        if($result['dataset'] = $product->getPre()){
                            $result['status'] = 1;
                        } else {
                            $result['exceptionEN'] = 'You have no products added to the shopping cart';
                            $result['exception'] = 'No tienes productos agregados en el Carrito';     
                        }
                    } else {
                        $result['exceptionEN'] = 'Wrong Customer';
                        $result['exception'] = 'Cliente incorrecto'; 
                    }
                } else {
                    $result['exceptionEN'] = 'Login or Create an account';
                    $result['exception'] = 'Inicie Sesión o Crea una cuenta';
                }
                break;
            case 'deletePrePro':
                if(isset($_SESSION['idCliente'])){
                    if($product->setCliente($_SESSION['idCliente'])){
                        if($product->setId($_POST['idProduct'])){
                            if($product->deletePrePro()){
                                $result['status'] = 1;
                            } else {
                                $result['exceptionEN'] = 'Nonexistent product';
                                $result['exception'] = 'Producto inexistente';    
                            }
                        } else{
                            $result['exceptionEN'] = 'Wrong Product';
                            $result['exception'] = 'Producto incorrecto';    
                        }                     
                    } else {
                        $result['exceptionEN'] = 'Wrong Customer';
                        $result['exception'] = 'Cliente incorrecto'; 
                    }
                } else {
                    $result['exceptionEN'] = 'Login or Create an account';
                    $result['exception'] = 'Inicie Sesión o Crea una cuenta';
                }
                break;
            case 'createInvoices':
                $_POST = $product->validateForm($_POST);
                if(isset($_SESSION['idCliente'])){
                    if($product->setCliente($_SESSION['idCliente'])){
                        if($product->setDireccion($_POST['direccion'])){
                            if($product->createInvoices()){
                                $data = $product->getPre();
                                    if($data){
                                        if($product->getLastInvoices()){
                                            for($x=0;$x<count($data);$x++){
                                                if($product->setId($data[$x]['idProducto'])){
                                                    if($product->setCantidad($data[$x]['cant'])){   
                                                        if($product->createDetailsInvoices()){
                                                            
                                                        }
                                                    }else {
                                                        $result['exception'] = 'Comuniquese con la tienda 2';        
                                                    }
                                                }else {
                                                    $result['exception'] = 'Comuniquese con la tienda';        
                                                }                                            
                                            }
                                            $_SESSION['idInvoices'] = $product->getCliente();
                                            if($product->setCliente($_SESSION['idCliente'])){
                                                if($product->deletePre()){
                                                    $result['status'] = 1;
                                                }
                                            }
                                        }
                                    } else {
                                        $result['exception'] = 'Comuniquese con la tienda';
                                    }
                            } else {
                                $result['exceptionEN'] = 'Invoice not created';
                                $result['exception'] = 'Factura no creada';     
                            }
                        } else {
                            $result['exceptionEN'] = 'Wrong Address';
                            $result['exception'] = 'Dirreción incorrecta';
                        }
                    } else {
                        $result['exceptionEN'] = 'Wrong Customer';
                        $result['exception'] = 'Cliente incorrecto'; 
                    }
                } else {
                    $result['exceptionEN'] = 'Login or Create an account';
                    $result['exception'] = 'Inicie Sesión o Crea una cuenta';
                }
                break;
            default:
                exit('Acción no disponible');
        }
    } else{
        $result['session'] = 0;
        $result['exception'] = 'Se ha bloqueado tu cuenta, porque se ha detectado una actividad sospechosa';
        $result['exceptionEN'] = 'Your account has been blocked, because suspicious activity has been detected';
    }
    print(json_encode($result));
} else {
    exit('Recurso denegado');
}
?>