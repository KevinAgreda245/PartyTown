$(document).ready(function () {
    showTable(1);
    link(1);
})
//Constante para establecer la ruta y parámetros de comunicación con la API
const apiCliente = "../../core/api/customer.php?site=dashboard&action=";

//Función para obtener y mostrar los registros disponibles
function showTable(estado) {
    $.ajax({
            url: apiCliente + 'readCustomer',
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
                        initTable('tblCliente');
                        sweetAlert(4, result.exception, null);
                    }
                } else {
                    sweetAlert(3, result.exception, 'index');
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
        (row.visibilidadCliente == 1) ? icon = 'lock_open': icon = 'lock_outline';
        content += `
            <tr>
                <td>${row.nombreCliente}</td>
                <td>${row.apellidoCliente}</td>
                <td>${row.correoCliente}</td>
                <td>${row.telefonoCliente}</td>
        `;
        if (estado == 1) {
            content += `
                <td><i class="material-icons">${icon}</i></td>
                <td>
                    <a class="btn waves-effect blue tooltipped" data-position="bottom" data-tooltip="Actualizar"
                        onclick="modalUpdate(${row.idCliente})"><i class="material-icons">loop</i></a>
                    <a class="btn waves-effect waves-light red tooltipped" data-position="bottom" data-tooltip="Eliminar"
                        onclick="deleteCustomer(${row.idCliente})" ><i class="material-icons">delete</i></a>
                </td>
            </tr>
        `;
        } else {
            content += `
            <td><i class="material-icons">lock_outline</i></td>
                <td>
                    <a class="btn waves-effect green accent-3 tooltipped" data-position="bottom" data-tooltip="Recuperar"
                        onclick="recoverCustomer(${row.idCliente})"><i class="material-icons">replay</i></a>
                </td>
            </tr>
        `;
        }

    });
    $('#tablaCliente').html(content);
    initTable('tblCliente');
    $('.tooltipped').tooltip();
}

function deleteCustomer(id) {
    swal({
            title: 'Advertencia',
            text: '¿Quiere eliminar el cliente?',
            icon: 'warning',
            buttons: ['Cancelar', 'Aceptar'],
            closeOnClickOutside: false,
            closeOnEsc: false
        })
        .then(function (value) {
            if (value) {
                $.ajax({
                        url: apiCliente + 'actCustomer',
                        type: 'post',
                        data: {
                            idCustomer: id,
                            statusCustomer: 0
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
                                        sweetAlert(1, 'Cliente eliminado correctamente', null);
                                    } else {
                                        sweetAlert(3, 'Cliente eliminado. ' + result.exception, null);
                                    }
                                } else {
                                    sweetAlert(2, result.exception, null);
                                }
                                clearTable('tblCliente');
                                destroyTable('tblCliente');
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

function recoverCustomer(id) {
    swal({
            title: 'Advertencia',
            text: '¿Quiere recuperar los datos del cliente?',
            icon: 'warning',
            buttons: ['Cancelar', 'Aceptar'],
            closeOnClickOutside: false,
            closeOnEsc: false
        })
        .then(function (value) {
            if (value) {
                $.ajax({
                        url: apiCliente + 'actCustomer',
                        type: 'post',
                        data: {
                            idCustomer: id,
                            statusCustomer: 1
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
                                        sweetAlert(1, 'Cliente recuperado correctamente', null);
                                    } else {
                                        sweetAlert(3, 'Cliente recuperado. ' + result.exception, null);
                                    }
                                } else {
                                    sweetAlert(2, result.exception, null);

                                }
                                clearTable('tblCliente');
                                destroyTable('tblCliente');
                                showTable(0);
                            } else {
                                sweetAlert(3, result.exception, 'index');
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

function modalUpdate(id) {
    $.ajax({
            url: apiCliente + 'getStatusCustomer',
            type: 'post',
            data: {
                idCustomer: id
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
                        $('#modificarCliente')[0].reset();
                        $('#idCliente').val(result.dataset.idCliente);
                        (result.dataset.visibilidadCliente == 1) ? $('#actualizarEstado').prop('checked', true): $('#actualizarEstado').prop('checked', false);
                        $('#verComentarios').modal('close');
                        $('#actualizarCliente').modal('open');
                    } else {
                        sweetAlert(2, result.exception, null);
                    }
                } else {
                    sweetAlert(3, result.exception, 'index');
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
$('#modificarCliente').submit(function () {
    event.preventDefault();
    $.ajax({
            url: apiCliente + 'updateCustomer',
            type: 'post',
            data: new FormData($('#modificarCliente')[0]),
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
                        $('#modificarCliente')[0].reset();
                        $('#actualizarCliente').modal('close');
                        if (result.status == 1) {
                            sweetAlert(1, 'Cliente modificado correctamente', null);
                        } else if (result.status == 2) {
                            sweetAlert(3, 'Cliente modificado. ' + result.exception, null);
                        } else {
                            sweetAlert(1, 'Cliente modificado. ' + result.exception, null);
                        }
                    } else {
                        sweetAlert(2, result.exception, null);
                    }
                    destroyTable('tblCliente');
                    showTable(1);
                } else {
                    sweetAlert(3, result.exception, 'index');
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

function out() {
    clearTable('tblCliente');
    destroyTable('tblCliente');
    showTable(1);
    link(1);
}

function add() {
    clearTable('tblCliente');
    destroyTable('tblCliente');
    showTable(0);
    link(0);
}

function link(value) {
    let link = '';
    if (value == 0) {
        link += `
        <a class="waves-effect waves-light btn" onclick="out()">Ver Clientes</a>
    `;
    } else {
        link += `
        <a class="waves-effect waves-light btn" onclick="add()">Ver Clientes eliminados</a>
    `;
    }
    $('#link').html(link);
}