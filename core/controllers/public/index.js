$(document).ready(function () {
    showSlider();
    showCategories();
    showEvents();
})

//Constante para establecer la ruta y parámetros de comunicación con la API de Slider
const apiSlider = '../../core/api/slider.php?site=commerce&action=';
//Constante para establecer la ruta y parámetros de comunicación con la API de Tipo de Producto
const apiCategories = '../../core/api/productType.php?site=commerce&action=';
//Constante para establecer la ruta y parámetros de comunicación con la API de Tipo de Producto
const apiEvents = '../../core/api/partyType.php?site=commerce&action=';
//Constante para establecer la ruta y parámetros de comunicación con la API de Tipo de Producto
const apiProduct = '../../core/api/product.php?site=commerce&action=';


function showSlider() {
    $.ajax({
            url: apiSlider + 'readSlider',
            type: 'post',
            data: null,
            datatype: 'json'
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                var ima = 0;
                let content = '';
                const result = JSON.parse(response);
                //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                if (result.session) {
                    if (result.status) {
                        result.dataset.forEach(function (row) {
                            content += `
                        <li>
                            <img src="../../resources/img/public/slider/${row.fotoSlider}">
                            <div class="caption center-align">
                                <h2>${row.tituloSlider}</h2>
                                <h4 class="grey-text text-lighten-3">${row.subtituloSlider}</h3>
                            </div>
                        </li>        
                        `;
                            ima++;
                        });
                        var inter = ima * 6000;
                        setTimeout(showSlider, inter);

                    } else {
                        content += `
                    <li>
                        <img src="../../resources/img/public/slider/SliderDefault.png">
                        <div class="caption center-align">
                            <h2>Party Town</h2>
                            <h4 class="grey-text text-lighten-3 lang" key="pt">La mejor tienda en línea</h3>
                        </div>
                    </li>
                    `;

                    }
                    $('#sli').html(content);
                    showTraslate(localStorage.getItem('language'));
                    $('.slider').slider({
                        'indicators': false
                    });
                } else {
                    if (localStorage.getItem('language') == 'EN'){ 
                        sweetAlert(3, result.exceptionEN, 'index');
                    } else {
                        sweetAlert(3, result.exception, 'index');
                    }
                }   
            } else {
                console.log(response);
            }
        })
        .fail(function (jqXHR) {
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        });
}

/* Muestra todas las categorías de productos */
function showCategories() {
    $.ajax({
            url: apiCategories + 'readType',
            type: 'post',
            data: null,
            datatype: 'json'
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                let content = '';
                const result = JSON.parse(response);
                //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                if (result.session) {
                    if (result.status) {
                        result.dataset.forEach(function (row) {
                            content += `
                        <div class="col s12 m6 l4">
                            <div class="card hoverable">
                                <!--Imagen para la categoría del producto-->
                                <div class="card-image">
                                    <img src="../../resources/img/public/categories/${row.fotoTipoProducto}">
                                    <span class="card-title teal lighten-2">${row.tipoProducto}</span>
                                </div>
                                <!--Descripción de la categoría del producto-->
                                <div class="card-content center-align">
                                    <p>${row.descripcionTipo}</p>
                                </div>
                                <!--Botón para dirigir a los producto de la categoría del producto-->
                                <div class="card-action center-align">
                                    <a class="waves-effect waves-light btn blue-grey darken-1" href="#!" onclick="readProductCategories(${row.idTipoProducto},'${row.tipoProducto}')"><i class="material-icons right">keyboard_arrow_right</i><span class="lang" key="ver">Ver Más</span></a>
                                </div>
                            </div>
                        </div>
                        `;
                        });
                        $('#titleCat').text('Categorías');
                        $('#categorias').html(content);
                        showTraslate(lang);
                    } else {
                        if (localStorage.getItem('language') == 'EN'){ 
                            $('#titleCat').html('<i class="material-icons small">cloud_off</i><span class="red-text"> ' + result.exceptionEN + '</span>');
                        } else {
                            $('#titleCat').html('<i class="material-icons small">cloud_off</i><span class="red-text"> ' + result.exception + '</span>');   
                        }
                    }
                } else {
                    if (localStorage.getItem('language') == 'EN'){ 
                        sweetAlert(3, result.exceptionEN, 'index');
                    } else {
                        sweetAlert(3, result.exception, 'index');
                    }
                }
            } else {
                console.log(response);
            }
        })
        .fail(function (jqXHR) {
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        });
}

/* Muestra los eventos o tipos de fiesta */
function showEvents() {
    $.ajax({
            url: apiEvents + 'readEvents',
            type: 'post',
            data: null,
            datatype: 'json'
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                let content = '';
                const result = JSON.parse(response);
                if (result.session) {
                    //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                    if (result.status) {
                        result.dataset.forEach(function (row) {
                            content += `
                    <!--Carta para cada tipo de fiestas-->
                    <div class="col s12 m6 l4">
                        <div class="card hoverable">
                            <!--Imagen para el tipo de fiestas-->
                            <div class="card-image">
                                <img src="../../resources/img/public/events/${row.fotoTipoEvento}">
                                <span class="card-title teal lighten-2">${row.tipoEvento}</span>
                            </div>
                            <!--Descripción del tipo de fiestas-->
                            <div class="card-content center-align">
                                <p>${row.descripcionTipo}</p>
                            </div>
                            <!--Botón para dirigir a los producto del tipo de fiesta-->
                            <div class="card-action center-align">
                                <a class="waves-effect waves-light btn blue-grey darken-1" href="#!" onclick="readProductEvents(${row.idTipoEvento},'${row.tipoEvento}')"><i class="material-icons right">keyboard_arrow_right</i><span class="lang" key="ver">Ver Más</span></a>
                            </div>
                        </div>
                    </div>
                    `;
                        });
                        $('#titleEve').text('Tipos de Eventos');
                        $('#eventos').html(content);
                        showTraslate(lang);
                    } else {
                        if (localStorage.getItem('language') == 'EN'){ 
                            $('#titleEve').html('<i class="material-icons small">cloud_off</i><span class="red-text"> ' + result.exceptionEN + '</span>');    
                        } else {
                            $('#titleEve').html('<i class="material-icons small">cloud_off</i><span class="red-text"> ' + result.exception + '</span>');    
                        }
                    }
                } else {
                    if (localStorage.getItem('language') == 'EN'){ 
                        sweetAlert(3, result.exceptionEN, 'index');
                    } else {
                        sweetAlert(3, result.exception, 'index');
                    }
                }
            } else {
                console.log(response);
            }
        })
        .fail(function (jqXHR) {
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        });
}

/* Llena las cards con los datos del producto seleccionado */
function fillProducts(rows) {
    let content = '';
    rows.forEach(function (row) {
        precio = parseFloat(row.precioProducto).toFixed(2);
        content += `
        <!--Carta del producto-->
            <div class="col s12 m8 l6 offset-l3 offset-m2">
                <div class="card horizontal hoverable">
                    <div class="card-image">
                        <!--Imagen del producto-->
                        <img class="materialboxed" src="../../resources/img/public/products/${row.fotoProducto}">
                    </div>
                    <!--Descripción del producto-->
                    <div class="card-stacked">
                        <div class="card-content">
                            <h5>${row.nombreProducto}</h5>
                            <h6 align="justify"><b class="lang" key="descr">Descripción: </b> ${row.descripcionProducto}</h6>
                            <h6><b class="lang" key="precio">Precio USD($): </b> ${precio}</h6>
                        </div>
                        <!--Boton para saber más del producto-->
                        <div class="card-action">
                            <a href="#!" onclick="detailsProducts(${row.idProducto})" class="lang" key="detalle">Detalle de Producto</a>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    return content;
}

/* Función para el buscador */
function readProductCategories(id, categoria) {
    $('.slider').hide();
    $('#group').hide();
    $('#listCategories').removeClass('hide');
    $.ajax({
            url: apiProduct + 'readProductType',
            type: 'post',
            data: {
                type: id
            },
            datatype: 'json'
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                if (result.session) {
                    //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                    if (result.status) {
                        let search = '';
                        search = `
                <form method="post" id="form-search">
                    <div class="input-field col s6 m4">
                        <i class="material-icons prefix">search</i>
                        <input id="buscarCat" type="text" name="buscarCat"/>
                        <label for="buscarCat" class="lang" key="buscador">Buscador</label>
                    </div>
                    <div class="input-field col s6 m4">
                        <button onclick="searchType(${id})" class="btn waves-effect green tooltipped tool" key="buscar" data-tooltip="Buscar"><i class="material-icons">check_circle</i></button>
                    </div>
                </form>
                `;
                        $('#tiCategories').text(categoria);
                        $('#listCat').html(fillProducts(result.dataset));
                        $('#buscadorCat').html(search);
                        $('.tooltipped').tooltip();
                        showTraslate(lang);
                        $("html, body").animate({
                            scrollTop: 0
                        });
                    } else {
                        if (localStorage.getItem('language') == 'EN'){ 
                            sweetAlert(4, result.exceptionEN, 'index');
                        } else {
                            sweetAlert(4, result.exception, 'index');
                        }
                    }
                } else {
                    if (localStorage.getItem('language') == 'EN'){ 
                        sweetAlert(3, result.exceptionEN, 'index');
                    } else {
                        sweetAlert(3, result.exception, 'index');
                    }
                }
            } else {
                console.log(response);
            }
        })
        .fail(function (jqXHR) {
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        });
}

/* Búsqueda de tipos */
function searchType(id) {
    event.preventDefault();
    $.ajax({
            url: apiProduct + 'searchProductType',
            type: 'post',
            data: {
                type: id,
                value: $('#buscarCat').val()
            },
            datatype: 'json'
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                if (result.status) {
                    $('#listCat').html(fillProducts(result.dataset));
                    showTraslate(lang);
                } else {
                    if (localStorage.getItem('language') == 'EN'){ 
                        $('#listCat').html('<h4>' + (result.exceptionEN) + '</h4>');
                    } else {
                        $('#listCat').html('<h4>' + (result.exception) + '</h4>');   
                    }
                }
            } else {
                console.log(response);
            }
        })
        .fail(function (jqXHR) {
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        });
}

/* Lee los productos del evento seleccionado */
function readProductEvents(id, event) {
    $('.slider').hide();
    $('#group').hide();
    $('#listEvents').removeClass('hide');
    $.ajax({
            url: apiProduct + 'readProductEvents',
            type: 'post',
            data: {
                type: id
            },
            datatype: 'json'
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                if (result.status) {
                    let search = '';
                    search = `
                <form method="post" id="form-search">
                    <div class="input-field col s6 m4">
                        <i class="material-icons prefix">search</i>
                        <input id="buscar" type="text" name="buscar"/>
                        <label for="buscar" class="lang" key="buscador">Buscador</label>
                    </div>
                    <div class="input-field col s6 m4">
                        <button onclick="searchEvents(${id})" class="btn waves-effect green tooltipped tool" key="buscar" data-tooltip="Buscar"><i class="material-icons">check_circle</i></button>
                    </div>
                </form>
                `;
                    $('#tiEvents').text(event);
                    $('#listEve').html(fillProducts(result.dataset));
                    $('#buscadorEve').html(search);
                    showTraslate(lang);
                    $("html, body").animate({
                        scrollTop: 0
                    });
                } else {
                    if (localStorage.getItem('language') == 'EN'){ 
                        sweetAlert(4, result.exceptionEN, 'index');
                    } else {
                        sweetAlert(4, result.exception, 'index');    
                    }
                }
            } else {
                console.log(response);
            }
        })
        .fail(function (jqXHR) {
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        });
}

/* Busca eventos */

function searchEvents(id) {
    event.preventDefault();
    $.ajax({
            url: apiProduct + 'searchProductEvents',
            type: 'post',
            data: {
                type: id,
                value: $('#buscar').val()
            },
            datatype: 'json'
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                let content = '';
                const result = JSON.parse(response);
                //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                if (result.status) {
                    $('#listEve').html(fillProducts(result.dataset));
                    showTraslate(lang);
                } else {
                    if (localStorage.getItem('language') == 'EN'){ 
                        $('#listCat').html('<h4>' + (result.exceptionEN) + '</h4>');
                    } else {
                        $('#listCat').html('<h4>' + (result.exception) + '</h4>');   
                    }
                }
            } else {
                console.log(response);
            }
        })
        .fail(function (jqXHR) {
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        });
}

/* Obtiene los detalles de los productos */
function detailsProducts(id) {
    $('#listEvents').hide();
    $('#listCategories').hide();
    $('#detailsProduct').removeClass('hide');
    $.ajax({
            url: apiProduct + 'getProductDetails',
            type: 'post',
            data: {
                idProducts: id
            },
            datatype: 'json'
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                let content = '';
                const result = JSON.parse(response);
                //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                if (result.status) {
                    precio = parseFloat(result.dataset.precioProducto).toFixed(2);
                    content = `
                <div class="col s12 m12 l6 offset-l3">
                    <!--Carta para detallar el producto-->
                    <div class="card hoverable">
                        <!--Imagen del producto-->
                        <div class="card-image">
                            <img class="activator materialboxed" src="../../resources/img/public/products/${result.dataset.fotoProducto}">
                            <span class="card-title teal lighten-2">${result.dataset.nombreProducto}</span>
                        </div>
                        <!--Detalle producto-->
                        <div class="card-content">
                            <h6><b class="lang" key="descr">Descripción: </b> ${result.dataset.descripcionProducto}</h6>
                            <h6><b class="lang" key="precio">Precio USD($): </b> ${precio}</h6>
                            <a class="btn waves-effect green tooltipped tool" key="comentarios" data-position="bottom" data-tooltip="Comentarios"
                                onclick="modalComments(${result.dataset.idProducto})"><i class="material-icons">message</i></a>
                            <a class="btn waves-effect orange tooltipped tool" key="valoracion" data-position="bottom" data-tooltip="Valoración"
                                onclick="modalRating(${result.dataset.idProducto})"><i class="material-icons">star</i></a>
                            <a class="btn waves-effect green tooltipped" data-position="bottom" data-tooltip="Agregar Comentarios"
                                onclick="createComments(${result.dataset.idProducto})"><i class="material-icons">add</i></a>
                            <a class="btn waves-effect orange tooltipped" data-position="bottom" data-tooltip="Agregar Valoración"
                                onclick="createRating(${result.dataset.idProducto})"><i class="material-icons">add</i></a>
                            
                        </div>
                        <div class="card-action right-align">
                            <div class="row">
                                <form method="post" id="agregarCarrito">
                                    <div class="col s6 m4">
                                        <!--Input para especificar la cantidad a agregar al carrito de ventas-->
                                        <input type="number" id="cant" name="cant" value="1" max="999" min="1">
                                    </div>
                                    <div class="col s6 m8">
                                        <!--Boton para agregar al carrito-->
                                        <a onclick="addCart(${result.dataset.idProducto})" class="btn-floating btn-large waves-effect waves-light"><i class='material-icons right'>add_shopping_cart</i></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                `;
                    $('#titleDetails').attr('key','detalle');
                    $('#detPro').html(content);
                    $("html, body").animate({
                        scrollTop: 0
                    });
                    showTraslate(localStorage.getItem('language'));
                } else {
                    if (localStorage.getItem('language') == 'EN'){ 
                        $('#titleDetails').html('<i class="material-icons small">cloud_off</i><span class="red-text"> ' + result.exceptionEN + '</span>');
                    } else {
                        $('#titleDetails').html('<i class="material-icons small">cloud_off</i><span class="red-text"> ' + result.exception + '</span>');
                    }
                }
            } else {
                console.log(response);
            }
        })
        .fail(function (jqXHR) {
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        });
}

/* Obtener los comentarios en un modal */
function modalComments(id) {
    $.ajax({
            url: apiProduct + 'getComments',
            type: 'post',
            data: {
                idProduct: id
            },
            datatype: 'json'
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                //Se comprueba si el resultado es satisfactorio para mostrar los valores en el formulario, sino se muestra la excepción
                if (result.status) {
                    fillComments(result.dataset);
                } else {
                    if (localStorage.getItem('language') == 'EN'){ 
                        sweetAlert(2, result.exceptionEN, null);
                    } else {
                        sweetAlert(2, result.exception, null);
                    }
                
                }
            } else {
                console.log(response);
            }
        })
        .fail(function (jqXHR) {
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        });
}

/* Llena los comentarios */
function fillComments(rows) {
    let content = '';
    //Se recorren las filas para armar el cuerpo de la tabla y se utiliza comilla invertida para escapar los caracteres especiales
    rows.forEach(function (row) {
        content += `
        <div class="col s12">
            <div class="card-panel teal">
                <span class="card-title white-text"><strong class="lang" key="cliente">Cliente:</strong> ${row.nombreCliente} ${row.apellidoCliente}</span>
                <br> 
                <span class="white-text">${row.descripcionComentario}</span>
            </div>
        </div>
        `;
    });
    $('#comentarios').html(content);
    showTraslate(localStorage.getItem('language'));
    $('#verComentarios').modal('open');
}

/* Muestra el rating del producto en un modal */
function modalRating(id) {
    $.ajax({
            url: apiProduct + 'getRating',
            type: 'post',
            data: {
                idProduct: id
            },
            datatype: 'json'
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                let content = '';
                const result = JSON.parse(response);
                //Se comprueba si el resultado es satisfactorio para mostrar los valores en el formulario, sino se muestra la excepción
                if (result.status) {
                    if (result.dataset.valoracion != null) {
                        val = parseFloat(result.dataset.valoracion).toFixed(2);
                        content = `<h6><b class="lang" key="valoracion">Valoración:</b> ${val}</h6>`;
                        $('#promedio').html(content);
                        showTraslate(localStorage.getItem('language'));
                        $('#verValoracion').modal('open');
                    } else {
                        if (localStorage.getItem('language') == 'EN'){ 
                            sweetAlert(2, 'This product has no ratings', null);
                        } else {
                            sweetAlert(2, 'No tiene valoraciones este producto', null);
                        }
                    }
                } else {
                    if (localStorage.getItem('language') == 'EN'){ 
                        sweetAlert(2, result.exceptionEN, null);
                    } else {
                        sweetAlert(2, result.exception, null);
                    }
                }
            } else {
                console.log(response);
            }
        })
        .fail(function (jqXHR) {
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        });
}

/* Crea comentarios */
function createComments(id) {
    $('#agregarComentario').modal('open');
    $('#idPro').val(id);
}

/* Crea ratings */
function createRating(id) {
    $('#agregarValoracion').modal('open');
    $('#idProd').val(id);
}

/* Listener para cuando se desea crear un nuevo comentario */
$('#nuevoComentario').submit(function () {
    event.preventDefault();
    $.ajax({
            url: apiProduct + 'createComment',
            type: 'post',
            data: $('#nuevoComentario').serialize(),
            datatype: 'json',
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                if (result.status) {
                    $('#agregarComentario').modal('close');
                    $('#nuevoComentario')[0].reset();
                    if (result.status == 1) {
                        sweetAlert(1, 'Comentario agregado correctamente', null);
                    } else if (result.status == 2) {
                        sweetAlert(3, 'Comentario agregado. ' + result.exception, null);
                    } else {
                        sweetAlert(1, 'Comentario agregado. ' + result.exception, null);
                    }
                } else {
                    if (localStorage.getItem('language') == 'EN'){ 
                        sweetAlert(2, result.exceptionEN, null);
                    } else {
                        sweetAlert(2, result.exception, null);
                    }
                }
            } else {
                console.log(response);
            }
        })
        .fail(function (jqXHR) {
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        });
})

/* Listener para cuando se desea crear una nueva valoración o rating */
$('#nuevaValoracion').submit(function () {
    event.preventDefault();
    $.ajax({
            url: apiProduct + 'createRating',
            type: 'post',
            data: $('#nuevaValoracion').serialize(),
            datatype: 'json',
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                if (result.status) {
                    $('#agregarValoracion').modal('close');
                    $('#nuevaValoracion')[0].reset();
                    if (result.status == 1) {
                        sweetAlert(1, 'Valoración agregada correctamente', null);
                    } else if (result.status == 2) {
                        sweetAlert(3, 'Valoración agregada. ' + result.exception, null);
                    } else {
                        sweetAlert(1, 'Valoración agregada. ' + result.exception, null);
                    }
                } else {
                    if (localStorage.getItem('language') == 'EN'){ 
                        sweetAlert(2, result.exceptionEN, null);
                    } else {
                        sweetAlert(2, result.exception, null);
                    }
                }
            } else {
                console.log(response);
            }
        })
        .fail(function (jqXHR) {
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        });
})

/* Función que agrega al carrito de compras */
function addCart(id) {
    $.ajax({
            url: apiProduct + 'createPre',
            type: 'post',
            data: {
                idProduct: id,
                value: $('#cant').val()
            },
            datatype: 'json',
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                if (result.session) {
                    //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                    if (result.status) {
                        if (result.status == 1) {
                            sweetAlert(1, 'Agregado al Carrito de Venta', null);
                        } else if (result.status == 2) {
                            sweetAlert(3, 'Agregado al Carrito. ' + result.exception, null);
                        } else {
                            sweetAlert(1, 'Agregado al Carrito. ' + result.exception, null);
                        }
                    } else {
                        if (localStorage.getItem('language') == 'EN'){ 
                            sweetAlert(2, result.exceptionEN, null);
                        } else {
                            sweetAlert(2, result.exception, null);
                        }
                    }
                } else {
                    if (localStorage.getItem('language') == 'EN'){ 
                        sweetAlert(2, result.exceptionEN, 'index');
                    } else {
                        sweetAlert(2, result.exception, 'index');
                    }
                }
            } else {
                console.log(response);
            }
        })
        .fail(function (jqXHR) {
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        });
}