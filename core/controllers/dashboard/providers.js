$(document).ready(function () {
    showTable(1);
    link(1);
})

//Constante para establecer la ruta y parámetros de comunicación con la API
const apiProveedores = "../../core/api/providers.php?site=dashboard&action=";

function showTable(estado) {
    $.ajax({
            url: apiProveedores + 'readProviders',
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
                        initTable('tblProveedor');
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
        content += `
            <tr>
                <td>${row.nombreProveedor}</td>
                <td>${row.telefonoProveedor}</td>
                <td><img src="../../resources/img/dashboard/providers/${row.logoProveedor}" class="materialboxed" height="100" width="100"></td>
            `;
        if (estado == 1) {
            content += `
                <td>
                    <a class="btn waves-effect blue tooltipped" data-position="bottom" data-tooltip="Actualizar"
                        onclick="modalUpdate(${row.idProveedor})"><i class="material-icons">loop</i></a>
                    <a class="btn waves-effect waves-light red tooltipped" data-position="bottom" data-tooltip="Eliminar"
                        onclick="deleteProviders(${row.idProveedor})" ><i class="material-icons">delete</i></a>
                </td>
            </tr>   
            `;
        } else {
            content += `
                <td>
                    <a class="btn waves-effect green accent-3 tooltipped" data-position="bottom" data-tooltip="Recuperar"
                        onclick="recoverProviders(${row.idProveedor})"><i class="material-icons">replay</i></a>
                </td>
            </tr>
            `;
        }
    });
    $('#tablaProveedor').html(content);
    initTable('tblProveedor');
    $('.materialboxed').materialbox();
    $('.tooltipped').tooltip();
}

//Función para crear un nuevo registro
$('#nuevoProveedor').submit(function () {
    event.preventDefault();
    $.ajax({
            url: apiProveedores + 'createProvider',
            type: 'post',
            data: new FormData($('#nuevoProveedor')[0]),
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
                        $('#nuevoProveedor')[0].reset();
                        $('#agregarProveedor').modal('close');
                        if (result.status == 1) {
                            sweetAlert(1, 'Proveedor creado correctamente.', null);
                        } else {
                            sweetAlert(3, 'Proveedor creado. ' + result.exception, null);
                        }
                        destroyTable('tblProveedor');
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
    $.ajax({
            url: apiProveedores + 'getProviders',
            type: 'post',
            data: {
                idProviders: id
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
                        $('#modificarProveedor')[0].reset();
                        $('#idProveedor').val(result.dataset.idProveedor);
                        $('#fotoProveedor').val(result.dataset.logoProveedor);
                        $('#actualizarNombre').val(result.dataset.nombreProveedor);
                        $('#actualizarTelefono').val(result.dataset.telefonoProveedor);
                        $('#actualizarCorreo').val(result.dataset.correoProveedor);
                        M.updateTextFields();
                        $('#actualizarProveedor').modal('open');
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

$('#modificarProveedor').submit(function () {
    event.preventDefault();
    $.ajax({
            url: apiProveedores + 'updateProviders',
            type: 'post',
            data: new FormData($('#modificarProveedor')[0]),
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
                        $('#actualizarProveedor').modal('close');
                        if (result.status == 1) {
                            sweetAlert(1, 'Proveedor modificado correctamente', null);
                        } else if (result.status == 2) {
                            sweetAlert(3, 'Proveedor modificado. ' + result.exception, null);
                        } else {
                            sweetAlert(1, 'Proveedor modificado. ' + result.exception, null);
                        }
                    } else {
                        sweetAlert(2, result.exception, null);
                    }
                    clearTable('tblProveedor');
                    destroyTable('tblProveedor');
                    showTable(1);
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

function deleteProviders(id) {
    swal({
            title: 'Advertencia',
            text: '¿Quiere eliminar el proveedor?',
            icon: 'warning',
            buttons: ['Cancelar', 'Aceptar'],
            closeOnClickOutside: false,
            closeOnEsc: false
        })
        .then(function (value) {
            if (value) {
                $.ajax({
                        url: apiProveedores + 'actProviders',
                        type: 'post',
                        data: {
                            idProviders: id,
                            statusProviders: 0
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
                                        sweetAlert(1, 'Proveedor eliminado correctamente', null);
                                    } else {
                                        sweetAlert(3, 'Proveedor eliminado. ' + result.exception, null);
                                    }
                                } else {
                                    sweetAlert(2, result.exception, null);
                                }
                                clearTable('tblProveedor');
                                destroyTable('tblProveedor');
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

function recoverProviders(id) {
    swal({
            title: 'Advertencia',
            text: '¿Quiere recuperar los datos del proveedor?',
            icon: 'warning',
            buttons: ['Cancelar', 'Aceptar'],
            closeOnClickOutside: false,
            closeOnEsc: false
        })
        .then(function (value) {
            if (value) {
                $.ajax({
                        url: apiProveedores + 'actProviders',
                        type: 'post',
                        data: {
                            idProviders: id,
                            statusProviders: 1
                        },
                        datatype: 'json'
                    })
                    .done(function (response) {
                        //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
                        if (isJSONString(response)) {
                            const result = JSON.parse(response);
                            //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                            if (result.session) {
                                if (result.status) {
                                    if (result.status == 1) {
                                        sweetAlert(1, 'Proveedor recuperado correctamente', null);
                                    } else {
                                        sweetAlert(3, 'Proveedor recuperado. ' + result.exception, null);
                                    }
                                } else {
                                    sweetAlert(2, result.exception, null);
                                }
                                clearTable('tblProveedor');
                                destroyTable('tblProveedor');
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
            mensaje = 'Nombre, Correo y/o Teléfono existente';
            break;
        default:
            mensaje = 'Ocurrio un problema, reportese con su administrador';
            break;
    }
    return mensaje;
}

function out() {
    clearTable('tblProveedor');
    destroyTable('tblProveedor');
    showTable(1);
    link(1);
}

function add() {
    clearTable('tblProveedor');
    destroyTable('tblProveedor');
    showTable(0);
    link(0);
}

function link(value) {
    let link = '';
    if (value == 0) {
        link += `
        <a class="waves-effect waves-light btn" onclick="out()">Ver Proveedor</a>
    `;
    } else {
        link += `
        <a class="waves-effect waves-light btn" onclick="add()">Ver Proveedor eliminados</a>
    `;
    }
    $('#link').html(link);
}