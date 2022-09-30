$(document).ready(function () {
    showTable(1);
    link(1);
})

//Constante para establecer la ruta y parámetros de comunicación con la API
const apiTipo = '../../core/api/productType.php?site=dashboard&action=';


function showTable(estado) {
    $.ajax({
            url: apiTipo + 'readType',
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
                        initTable('tblTipo');
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

function fillTable(rows, estado) {
    let content = '';
    //Se recorren las filas para armar el cuerpo de la tabla y se utiliza comilla invertida para escapar los caracteres especiales
    rows.forEach(function (row) {
        (row.visibilidadTipo == 1) ? icon = 'visibility': icon = 'visibility_off';
        content += `
            <tr>
                <td>${row.tipoProducto}</td>
                <td>${row.descripcionTipo}</td>
            `;
        if (estado == 1) {
            content += `
                <td><i class="material-icons">${icon}</i></td>
                <td><img src="../../resources/img/public/categories/${row.fotoTipoProducto}" class="materialboxed" height="100" width="100"></td>
                <td>
                    <a class="btn waves-effect blue tooltipped" data-position="bottom" data-tooltip="Actualizar"
                        onclick="modalUpdate(${row.idTipoProducto})"><i class="material-icons">loop</i></a>
                    <a class="btn waves-effect waves-light red tooltipped" data-position="bottom" data-tooltip="Eliminar"
                        onclick="deleteType(${row.idTipoProducto})" ><i class="material-icons">delete</i></a>
                </td>
            </tr>
            `;
        } else {
            content += `
                <td><i class="material-icons">visibility_off</i></td>
                <td><img src="../../resources/img/public/categories/${row.fotoTipoProducto}" class="materialboxed" height="100" width="100"></td>
                <td>
                    <a class="btn waves-effect green accent-3 tooltipped" data-position="bottom" data-tooltip="Recuperar"
                        onclick="recoverType(${row.idTipoProducto})"><i class="material-icons">replay</i></a>
                </td>
            </tr>
            `;
        }

    });
    $('#tablaTipo').html(content);
    initTable('tblTipo');
    $('.materialboxed').materialbox();
    $('.tooltipped').tooltip();
}

$('#nuevoProducto').submit(function () {
    event.preventDefault();
    $.ajax({
            url: apiTipo + 'createType',
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
                        $('#agregarTipo').modal('close');
                        if (result.status == 1) {
                            sweetAlert(1, 'Tipo de Producto creado correctamente.', null);
                        } else {
                            sweetAlert(3, 'Tipo de Producto creado. ' + result.exception, null);
                        }
                        destroyTable('tblTipo');
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

function modalUpdate(id) {
    let content = '';
    $.ajax({
            url: apiTipo + 'getType',
            type: 'post',
            data: {
                idType: id
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
                        $('#idTipo').val(result.dataset.idTipoProducto);
                        $('#fotoTipo').val(result.dataset.fotoTipoProducto);
                        $('#actualizarNombre').val(result.dataset.tipoProducto);
                        $('#actualizarDescripcion').val(result.dataset.descripcionTipo);
                        (result.dataset.visibilidadTipo == 1) ? $('#actualizarEstado').prop('checked', true): $('#actualizarEstado').prop('checked', false);
                        content += `
                    <img src="../../resources/img/public/categories/${result.dataset.fotoTipoProducto}" width="100" heigth="100">
                `;
                        $('#mostrarFoto').html(content);
                        M.updateTextFields();
                        $('#actualizarTipo').modal('open');
                    } else {
                        sweetAlert(2, result.exception, null);
                        destroyTable('tblTipo');
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

$('#modificarProducto').submit(function () {
    event.preventDefault();
    $.ajax({
            url: apiTipo + 'updateType',
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
                        $('#actualizarTipo').modal('close');
                        if (result.status == 1) {
                            sweetAlert(1, 'Tipo de Producto modificado correctamente', null);
                        } else if (result.status == 2) {
                            sweetAlert(3, 'Tipo de Producto modificado. ' + result.exception, null);
                        } else {
                            sweetAlert(1, 'Tipo de Producto modificado. ' + result.exception, null);
                        }
                        destroyTable('tblTipo');
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

function deleteType(id) {
    swal({
            title: 'Advertencia',
            text: '¿Quiere eliminar el tipo de producto?',
            icon: 'warning',
            buttons: ['Cancelar', 'Aceptar'],
            closeOnClickOutside: false,
            closeOnEsc: false
        })
        .then(function (value) {
            if (value) {
                $.ajax({
                        url: apiTipo + 'actType',
                        type: 'post',
                        data: {
                            idType: id,
                            statusType: 0
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
                                        sweetAlert(1, 'Tipo de Producto eliminado correctamente', null);
                                    } else {
                                        sweetAlert(3, 'Tipo de Producto eliminado. ' + result.exception, null);
                                    }
                                } else {
                                    sweetAlert(2, result.exception, null);
                                }
                                clearTable('tblTipo');
                                destroyTable('tblTipo');
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

function recoverType(id) {
    swal({
            title: 'Advertencia',
            text: '¿Quiere recuperar los datos del tipo de producto?',
            icon: 'warning',
            buttons: ['Cancelar', 'Aceptar'],
            closeOnClickOutside: false,
            closeOnEsc: false
        })
        .then(function (value) {
            if (value) {
                $.ajax({
                        url: apiTipo + 'actType',
                        type: 'post',
                        data: {
                            idType: id,
                            statusType: 1
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
                                        sweetAlert(1, 'Tipo de Producto recuperado correctamente', null);
                                    } else {
                                        sweetAlert(3, 'Tipo de Producto recuperado. ' + result.exception, null);
                                    }
                                } else {
                                    sweetAlert(2, result.exception, null);

                                }
                                clearTable('tblTipo');
                                destroyTable('tblTipo');
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
            mensaje = 'Tipo de Producto existente';
            break;
        default:
            mensaje = 'Ocurrio un problema, reportese con su administrador';
            break;
    }
    return mensaje;
}

function out() {
    clearTable('tblTipo');
    destroyTable('tblTipo');
    showTable(1);
    link(1);
}

function add() {
    clearTable('tblTipo');
    destroyTable('tblTipo');
    showTable(0);
    link(0);
}

function link(value) {
    let link = '';
    if (value == 0) {
        link += `
        <a class="waves-effect waves-light btn" onclick="out()">Ver Tipo de Producto</a>
    `;
    } else {
        link += `
        <a class="waves-effect waves-light btn" onclick="add()">Ver Tipo de Productos eliminados</a>
    `;
    }
    $('#link').html(link);
}