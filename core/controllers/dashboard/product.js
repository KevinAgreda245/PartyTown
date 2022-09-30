$(document).ready(function () {
    showTable(1);
    link(1);
    showSelectTypeProduct('nuevoTipo', null);
    showSelectTypeEvent('nuevoEvento', null);
    showSelectProviders('nuevoProveedor', null);
})

//Constante para establecer la ruta y parámetros de comunicación con la API
const apiProductos = "../../core/api/product.php?site=dashboard&action=";


//Función para obtener y mostrar los registros disponibles
function showTable(estado) {
    $.ajax({
            url: apiProductos + 'readProduct',
            type: 'post',
            data: {
                Estado: estado
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
                        fillTable(result.dataset, estado);
                    } else {
                        initTable('tblProducto');
                        sweetAlert(4, result.exception, null);
                    }
                } else {
                    sweetAlert(2, result.exception, 'index');
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

//Función para llenar tabla con los datos de los registros
function fillTable(rows, estado) {
    let content = '';
    //Se recorren las filas para armar el cuerpo de la tabla y se utiliza comilla invertida para escapar los caracteres especiales
    rows.forEach(function (row) {
        (row.visibilidadProducto == 1) ? icon = 'visibility': icon = 'visibility_off';
        precio = parseFloat(row.precioProducto).toFixed(2);
        content += `
            <tr>
                <td>${row.nombreProducto}</td>
                <td>$ ${precio}</td>
                <td>${row.cantidadProducto}</td>
            `;
        if (estado) {
            content += `
                <td><i class="material-icons">${icon}</i></td>
                <td><img src="../../resources/img/public/products/${row.fotoProducto}" class="materialboxed" height="100" width="100"></td>
                <td>
                    <div class="row">
                        <a class="btn waves-effect teal tooltipped" data-position="bottom" data-tooltip="Reabastecimiento"
                            onclick="modalReplanishment(${row.idProducto})"><i class="material-icons">plus_one</i></a>
                        <a class="btn waves-effect green tooltipped" data-position="bottom" data-tooltip="Comentarios"
                            onclick="modalComments(${row.idProducto})"><i class="material-icons">message</i></a>
                        <a class="btn waves-effect orange tooltipped" data-position="bottom" data-tooltip="Valoración"
                            onclick="modalRating(${row.idProducto})"><i class="material-icons">star</i></a>
                    </div>
                    <div class="row">
                        <a class="btn waves-effect blue tooltipped" data-position="bottom" data-tooltip="Actualizar"
                            onclick="modalUpdate(${row.idProducto})"><i class="material-icons">loop</i></a>
                        <a class="btn waves-effect waves-light red tooltipped" data-position="bottom" data-tooltip="Eliminar"
                            onclick="deleteProduct(${row.idProducto})" ><i class="material-icons">delete</i></a>
                    </div>

                </td>
            </tr>
            `;
        } else {
            content += `
            <td><i class="material-icons">visibility_off</i></td>
            <td><img src="../../resources/img/public/products/${row.fotoProducto}" class="materialboxed" height="100" width="100"></td>
                <td>
                    <a class="btn waves-effect green accent-3 tooltipped" data-position="bottom" data-tooltip="Recuperar"
                        onclick="recoverProduct(${row.idProducto})"><i class="material-icons">replay</i></a>
                </td>
            </tr>
            `;
        }
    });
    $('#tablaProducto').html(content);
    initTable('tblProducto');
    $('.materialboxed').materialbox();
    $('.tooltipped').tooltip();
}

function showSelectTypeProduct(idSelect, value) {
    $.ajax({
            url: apiProductos + 'readTypeProduct',
            type: 'post',
            data: null,
            datatype: 'json'
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                if (result.session) {
                    //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                    if (result.status) {
                        let content = '';
                        if (!value) {
                            content += '<option value="0" disabled selected>Seleccione una opción</option>';
                        }
                        result.dataset.forEach(function (row) {
                            if (row.idTipoProducto != value) {
                                content += `<option value="${row.idTipoProducto}">${row.tipoProducto}</option>`;
                            } else {
                                content += `<option value="${row.idTipoProducto}" selected>${row.tipoProducto}</option>`;
                            }
                        });
                        $('#' + idSelect).html(content);
                    } else {
                        $('#' + idSelect).html('<option value="">No hay opciones</option>');
                    }
                    $('select').formSelect();
                } else {
                    sweetAlert(2, result.exception, 'index');
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

function showSelectTypeEvent(idSelect, value) {
    $.ajax({
            url: apiProductos + 'readTypeEvent',
            type: 'post',
            data: null,
            datatype: 'json'
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                if (result.session) {
                    //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                    if (result.status) {
                        let content = '';
                        if (!value) {
                            content += '<option value="0" disabled selected>Seleccione una opción</option>';
                        }
                        result.dataset.forEach(function (row) {
                            if (row.idTipoEvento != value) {
                                content += `<option value="${row.idTipoEvento}">${row.tipoEvento}</option>`;
                            } else {
                                content += `<option value="${row.idTipoEvento}" selected>${row.tipoEvento}</option>`;
                            }
                        });
                        $('#' + idSelect).html(content);
                    } else {
                        $('#' + idSelect).html('<option value="">No hay opciones</option>');
                    }
                    $('select').formSelect();
                } else {
                    sweetAlert(2, result.exception, 'index');
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

function showSelectProviders(idSelect, value) {
    $.ajax({
            url: apiProductos + 'readProvider',
            type: 'post',
            data: null,
            datatype: 'json'
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                if (result.session) {
                    //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                    if (result.status) {
                        let content = '';
                        if (!value) {
                            content += '<option value="0" disabled selected>Seleccione una opción</option>';
                        }
                        result.dataset.forEach(function (row) {
                            if (row.idProveedor != value) {
                                content += `<option value="${row.idProveedor}">${row.nombreProveedor}</option>`;
                            } else {
                                content += `<option value="${row.idProveedor}" selected>${row.nombreProveedor}</option>`;
                            }
                        });
                        $('#' + idSelect).html(content);
                    } else {
                        $('#' + idSelect).html('<option value="">No hay opciones</option>');
                    }
                    $('select').formSelect();
                } else {
                    sweetAlert(2, result.exception, 'index');
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

//Función para crear un nuevo registro
$('#nuevoProducto').submit(function () {
    event.preventDefault();
    $.ajax({
            url: apiProductos + 'createProduct',
            type: 'post',
            data: new FormData($('#nuevoProducto')[0]),
            datatype: 'json',
            cache: false,
            contentType: false,
            processData: false
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                if (result.session) {
                    //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                    if (result.status) {
                        $('#nuevoProducto')[0].reset();
                        $('#agregarProducto').modal('close');
                        if (result.status == 1) {
                            sweetAlert(1, 'Producto creado correctamente.', null);
                        } else {
                            sweetAlert(3, 'Producto creado. ' + result.exception, null);
                        }
                        destroyTable('tblProducto');
                        showTable(1);
                    } else {
                        sweetAlert(2, result.exception, null);
                    }
                } else {
                    sweetAlert(2, result.exception, 'index');
                }
            } else {
                console.log(response);
                sweetAlert(2, error(response), null);
            }
        })
        .fail(function (jqXHR) {
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        });
})

function modalReplanishment(id) {
    $.ajax({
            url: apiProductos + 'getQuantity',
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
                if (result.session) {
                    //Se comprueba si el resultado es satisfactorio para mostrar los valores en el formulario, sino se muestra la excepción
                    if (result.status) {
                        $('#modificarCantidad')[0].reset();
                        $('#idProducto').val(result.dataset.idProducto);
                        texto = 'Cantidad: ' + result.dataset.cantidadProducto;
                        $('#cantidadProducto').text(texto);
                        M.updateTextFields();
                        $('#reabastecerProducto').modal('open');
                    } else {
                        sweetAlert(2, result.exception, null);
                        destroyTable('tblProducto');
                        showTable(1);
                    }
                } else {
                    sweetAlert(2, result.exception, 'index');
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

$('#modificarCantidad').submit(function () {
    event.preventDefault();
    $.ajax({
            url: apiProductos + 'updateQuantity',
            type: 'post',
            data: new FormData($('#modificarCantidad')[0]),
            datatype: 'json',
            cache: false,
            contentType: false,
            processData: false
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                if (result.session) {
                    //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                    if (result.status) {
                        $('#reabastecerProducto').modal('close');
                        if (result.status == 1) {
                            sweetAlert(1, 'Cantidad modificado correctamente', null);
                        } else if (result.status == 2) {
                            sweetAlert(3, 'Cantidad modificado. ' + result.exception, null);
                        } else {
                            sweetAlert(1, 'Cantidad modificado. ' + result.exception, null);
                        }
                        destroyTable('tblProducto');
                        showTable(1);
                    } else {
                        sweetAlert(2, result.exception, null);
                    }
                } else {
                    sweetAlert(2, result.exception, 'index');
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


function modalComments(id) {
    $.ajax({
            url: apiProductos + 'getComments',
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
                if (result.session) {
                    //Se comprueba si el resultado es satisfactorio para mostrar los valores en el formulario, sino se muestra la excepción
                    if (result.status) {
                        fillComments(result.dataset);
                    } else {
                        sweetAlert(2, result.exception, null);
                    }
                } else {
                    sweetAlert(2, result.exception, 'index');
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

function fillComments(rows) {
    let content = '';
    //Se recorren las filas para armar el cuerpo de la tabla y se utiliza comilla invertida para escapar los caracteres especiales
    rows.forEach(function (row) {
        (row.estadoComentario == 1) ? icon = 'visibility': icon = 'visibility_off';
        content += `
        <div class="col s12 m9">
            <div class="card-panel teal">
                <span class="card-title white-text"><strong>Cliente:</strong> ${row.nombreCliente} ${row.apellidoCliente}</span>
                <br>
                <span class="white-text"><strong>Correo: </strong>${row.correoCliente}</span>
                <br> 
                <span class="white-text">${row.descripcionComentario}</span>
            </div>
        </div>
        <div class="col s6 m1 center-align">
            <p><i class="material-icons">${icon}</i></p>
        </div>
        <div class="col s6 m2 center-align">
            <a class="btn waves-effect blue tooltipped" data-position="bottom" data-tooltip="Actualizar"
            onclick="modalUpdateComment(${row.idComentario})"><i class="material-icons">loop</i></a>
        </div>
        `;
    });
    $('#comentarios').html(content);
    $('.tooltipped').tooltip();
    $('#verComentarios').modal('open');
}

function modalUpdateComment(id) {
    $.ajax({
            url: apiProductos + 'getStatusComment',
            type: 'post',
            data: {
                idComment: id
            },
            datatype: 'json'
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                if (result.session) {
                    //Se comprueba si el resultado es satisfactorio para mostrar los valores en el formulario, sino se muestra la excepción
                    if (result.status) {
                        $('#modificarComentario')[0].reset();
                        $('#idCom').val(result.dataset.idComentario);
                        $('#idPro').val(result.dataset.idProducto);
                        (result.dataset.estadoComentario == 1) ? $('#actualizarEstadoCom').prop('checked', true): $('#actualizarEstadoCom').prop('checked', false);
                        $('#verComentarios').modal('close');
                        $('#actualizarComentarios').modal('open');
                    } else {
                        sweetAlert(2, result.exception, null);
                    }
                } else {
                    sweetAlert(2, result.exception, 'index');
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

//Función para crear un nuevo registro
$('#modificarComentario').submit(function () {
    event.preventDefault();
    $.ajax({
            url: apiProductos + 'updateComment',
            type: 'post',
            data: new FormData($('#modificarComentario')[0]),
            datatype: 'json',
            cache: false,
            contentType: false,
            processData: false
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                if (result.session) {
                    //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                    if (result.status) {
                        $('#actualizarComentarios').modal('close');
                        if (result.status == 1) {
                            sweetAlert(1, 'Comentario modificado correctamente', null);
                        } else if (result.status == 2) {
                            sweetAlert(3, 'Comentario modificado. ' + result.exception, null);
                        } else {
                            sweetAlert(1, 'Comentario modificado. ' + result.exception, null);
                        }
                        modalComments($("#idPro").val());
                        $('#modificarComentario')[0].reset();
                    } else {
                        sweetAlert(2, result.exception, null);
                    }
                    destroyTable('tblProducto');
                    showTable(1);
                } else {
                    sweetAlert(2, result.exception, 'index');
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

function modalRating(id) {
    $.ajax({
            url: apiProductos + 'getRating',
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
                if (result.session) {
                    //Se comprueba si el resultado es satisfactorio para mostrar los valores en el formulario, sino se muestra la excepción
                    if (result.status) {
                        fillRating(result.dataset);
                    } else {
                        sweetAlert(2, result.exception, null);
                    }
                } else {
                    sweetAlert(2, result.exception, 'index');
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

function fillRating(rows) {
    let content = '';
    //Se recorren las filas para armar el cuerpo de la tabla y se utiliza comilla invertida para escapar los caracteres especiales
    rows.forEach(function (row) {
        (row.estadoValoracion == 1) ? icon = 'visibility': icon = 'visibility_off';
        content += `
        <div class="col s12 m9">
            <div class="card-panel teal">
                <span class="card-title white-text"><strong>Cliente:</strong> ${row.nombreCliente} ${row.apellidoCliente}</span>
                <br>
                <span class="white-text"><strong>Correo: </strong>${row.correoCliente}</span>
                <br> 
                <span class="white-text"><strong>Valoración: </strong>${row.valoracionProducto}</span>
            </div>
        </div>
        <div class="col s6 m1 center-align">
            <p><i class="material-icons">${icon}</i></p>
        </div>
        <div class="col s6 m2 center-align">
            <a class="btn waves-effect blue tooltipped" data-position="bottom" data-tooltip="Actualizar"
            onclick="modalUpdateRating(${row.idValoracion})"><i class="material-icons">loop</i></a>
        </div>
        `;
    });
    $('#valoracion').html(content);
    $('.tooltipped').tooltip();
    $('#verValoracion').modal('open');
}

function modalUpdateRating(id) {
    $.ajax({
            url: apiProductos + 'getStatusRating',
            type: 'post',
            data: {
                idRating: id
            },
            datatype: 'json'
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                if (result.session) {
                    //Se comprueba si el resultado es satisfactorio para mostrar los valores en el formulario, sino se muestra la excepción
                    if (result.status) {
                        $('#modificarValoracion')[0].reset();
                        $('#idVal').val(result.dataset.idValoracion);
                        $('#idProd').val(result.dataset.idProducto);
                        (result.dataset.estadoValoracion == 1) ? $('#actualizarEstadoVal').prop('checked', true): $('#actualizarEstadoVal').prop('checked', false);
                        $('#verValoracion').modal('close');
                        $('#actualizarValoracion').modal('open');
                    } else {
                        sweetAlert(2, result.exception, null);
                    }
                } else {
                    sweetAlert(2, result.exception, 'index');
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

//Función para crear un nuevo registro
$('#modificarValoracion').submit(function () {
    event.preventDefault();
    $.ajax({
            url: apiProductos + 'updateRating',
            type: 'post',
            data: new FormData($('#modificarValoracion')[0]),
            datatype: 'json',
            cache: false,
            contentType: false,
            processData: false
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                if (result.session) {
                    //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                    if (result.status) {
                        $('#actualizarValoracion').modal('close');
                        if (result.status == 1) {
                            sweetAlert(1, 'Valoración modificado correctamente', null);
                        } else if (result.status == 2) {
                            sweetAlert(3, 'Valoración modificado. ' + result.exception, null);
                        } else {
                            sweetAlert(1, 'Valoración modificado. ' + result.exception, null);
                        }
                        modalRating($("#idProd").val());
                        $('#modificarValoracion')[0].reset();
                    } else {
                        sweetAlert(2, result.exception, null);
                    }
                    destroyTable('tblProducto');
                    showTable(1);
                } else {

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

function modalUpdate(id) {
    $.ajax({
            url: apiProductos + 'getProduct',
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
                if (result.session) {
                    //Se comprueba si el resultado es satisfactorio para mostrar los valores en el formulario, sino se muestra la excepción
                    if (result.status) {
                        $('#modificarProducto')[0].reset();
                        $('#codProducto').val(result.dataset.idProducto);
                        $('#fotoProducto').val(result.dataset.fotoProducto);
                        $('#actualizarNombre').val(result.dataset.nombreProducto);
                        $('#actualizarDescripcion').val(result.dataset.descripcionProducto);
                        $('#actualizarPrecio').val(parseFloat(result.dataset.precioProducto).toFixed(2));
                        showSelectTypeProduct('actualizarTipo', result.dataset.idTipoProducto);
                        showSelectTypeEvent('actualizarEvento', result.dataset.idTipoEvento);
                        showSelectProviders('actualizarProveedor', result.dataset.idProveedor);
                        (result.dataset.visibilidadProducto == 1) ? $('#actualizarEstado').prop('checked', true): $('#actualizarEstado').prop('checked', false);
                        M.updateTextFields();
                        $('#actualizarProducto').modal('open');
                    } else {
                        sweetAlert(2, result.exception, null);
                    }
                } else {
                    sweetAlert(2, result.exception, 'index');
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

//Función para crear un nuevo registro
$('#modificarProducto').submit(function () {
    event.preventDefault();
    $.ajax({
            url: apiProductos + 'updateProduct',
            type: 'post',
            data: new FormData($('#modificarProducto')[0]),
            datatype: 'json',
            cache: false,
            contentType: false,
            processData: false
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                if (result.session) {
                    //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                    if (result.status) {
                        $('#modificarProducto')[0].reset();
                        $('#actualizarProducto').modal('close');
                        if (result.status == 1) {
                            sweetAlert(1, 'Producto modificado correctamente', null);
                        } else if (result.status == 2) {
                            sweetAlert(3, 'Producto modificado. ' + result.exception, null);
                        } else {
                            sweetAlert(1, 'Producto modificado. ' + result.exception, null);
                        }
                        destroyTable('tblProducto');
                        showTable(1);
                    } else {
                        sweetAlert(2, result.exception, null);
                    }
                } else {
                    sweetAlert(2, result.exception, 'index');
                }
            } else {
                console.log(response);
                sweetAlert(2, error(response), null);
            }
        })
        .fail(function (jqXHR) {
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        });
})

function deleteProduct(id) {
    swal({
            title: 'Advertencia',
            text: '¿Quiere eliminar el producto?',
            icon: 'warning',
            buttons: ['Cancelar', 'Aceptar'],
            closeOnClickOutside: false,
            closeOnEsc: false
        })
        .then(function (value) {
            if (value) {
                $.ajax({
                        url: apiProductos + 'actProduct',
                        type: 'post',
                        data: {
                            idProduct: id,
                            statusProduct: 0
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
                                    if (result.status == 1) {
                                        sweetAlert(1, 'Producto eliminado correctamente', null);
                                    } else {
                                        sweetAlert(3, 'Producto eliminado. ' + result.exception, null);
                                    }
                                } else {
                                    sweetAlert(2, result.exception, null);
                                }
                                clearTable('tblProducto');
                                destroyTable('tblProducto');
                                showTable(1);
                            } else {
                                sweetAlert(2, result.exception, 'index');
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
        });

}

function recoverProduct(id) {
    swal({
            title: 'Advertencia',
            text: '¿Quiere recuperar los datos del producto?',
            icon: 'warning',
            buttons: ['Cancelar', 'Aceptar'],
            closeOnClickOutside: false,
            closeOnEsc: false
        })
        .then(function (value) {
            if (value) {
                $.ajax({
                        url: apiProductos + 'actProduct',
                        type: 'post',
                        data: {
                            idProduct: id,
                            statusProduct: 1
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
                                    if (result.status == 1) {
                                        sweetAlert(1, 'Producto recuperado correctamente', null);
                                    } else {
                                        sweetAlert(3, 'Producto recuperado. ' + result.exception, null);
                                    }
                                } else {
                                    sweetAlert(2, result.exception, null);

                                }
                                clearTable('tblProducto');
                                destroyTable('tblProducto');
                                showTable(0);
                            } else {
                                sweetAlert(2, result.exception, 'index');
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
        });
}

function error(response) {
    switch (response) {
        case 'Dato duplicado, no se puede guardar':
            mensaje = 'Nombre del producto existente';
            break;
        default:
            mensaje = 'Ocurrio un problema, reportese con su administrador';
            break;
    }
    return mensaje;
}

function out() {
    clearTable('tblProducto');
    destroyTable('tblProducto');
    showTable(1);
    link(1);
}

function add() {
    clearTable('tblProducto');
    destroyTable('tblProducto');
    showTable(0);
    link(0);
}

function link(value) {
    let link = '';
    if (value == 1) {

        link += `
        <a class="waves-effect waves-light btn" onclick="add()">Ver Productos eliminados</a>
    `;
    } else {
        link += `
        <a class="waves-effect waves-light btn" onclick="out()">Ver Productos</a>
    `;
    }
    $('#link').html(link);
}