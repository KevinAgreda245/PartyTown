$(document).ready(function () {
    showTable(1);
    link(1);
})

//Constante para establecer la ruta y parámetros de comunicación con la API
const apiEventos = '../../core/api/partyType.php?site=dashboard&action=';


function showTable(estado) {
    $.ajax({
            url: apiEventos + 'readEvent',
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
                        initTable('tblEvento');
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
        (row.visibilidadEvento == 1) ? icon = 'visibility': icon = 'visibility_off';
        content += `
            <tr>
                <td>${row.tipoEvento}</td>
                <td>${row.descripcionTipo}</td>
            `;
        if (estado == 1) {
            content += `
                <td><i class="material-icons">${icon}</i></td>
                <td><img src="../../resources/img/public/events/${row.fotoTipoEvento}" class="materialboxed" height="100" width="100"></td>
                <td>
                    <a class="btn waves-effect blue tooltipped" data-position="bottom" data-tooltip="Actualizar"
                        onclick="modalUpdate(${row.idTipoEvento})"><i class="material-icons">loop</i></a>
                    <a class="btn waves-effect waves-light red tooltipped" data-position="bottom" data-tooltip="Eliminar"
                        onclick="deleteEvents(${row.idTipoEvento})" ><i class="material-icons">delete</i></a>
                </td>
            </tr>
            `;
        } else {
            content += `
                <td><i class="material-icons">visibility_off</i></td>
                <td><img src="../../resources/img/public/events/${row.fotoTipoEvento}" class="materialboxed" height="100" width="100"></td>
                <td>
                    <a class="btn waves-effect green accent-3 tooltipped" data-position="bottom" data-tooltip="Recuperar"
                        onclick="recoverEvents(${row.idTipoEvento})"><i class="material-icons">replay</i></a>
                </td>
            </tr>
            `;
        }

    });
    $('#tablaEvento').html(content);
    initTable('tblEvento');
    $('.materialboxed').materialbox();
    $('.tooltipped').tooltip();
}

$('#nuevoEvento').submit(function () {
    event.preventDefault();
    $.ajax({
            url: apiEventos + 'createEvent',
            type: 'post',
            data: new FormData($('#nuevoEvento')[0]),
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
                        $('#nuevoEvento')[0].reset();
                        $('#agregarEvento').modal('close');
                        if (result.status == 1) {
                            sweetAlert(1, 'Tipo de Evento creado correctamente.', null);
                        } else {
                            sweetAlert(3, 'Tipo de Evento creado. ' + result.exception, null);
                        }
                        destroyTable('tblEvento');
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
            url: apiEventos + 'getEvent',
            type: 'post',
            data: {
                idEvent: id
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
                        $('#modificarEvento')[0].reset();
                        $('#idEvento').val(result.dataset.idTipoEvento);
                        $('#fotoEvento').val(result.dataset.fotoTipoEvento);
                        $('#actualizarTipo').val(result.dataset.tipoEvento);
                        $('#actualizarDescripcion').val(result.dataset.descripcionTipo);
                        (result.dataset.visibilidadEvento == 1) ? $('#actualizarEstado').prop('checked', true): $('#actualizarEstado').prop('checked', false);
                        content += `
                    <img src="../../resources/img/public/events/${result.dataset.fotoTipoEvento}" width="100" heigth="100">
                `;
                        $('#mostrarFoto').html(content);
                        M.updateTextFields();
                        $('#actualizarEvento').modal('open');
                    } else {
                        sweetAlert(2, result.exception, null);
                        destroyTable('tblEvento');
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

$('#modificarEvento').submit(function () {
    event.preventDefault();
    $.ajax({
            url: apiEventos + 'updateEvents',
            type: 'post',
            data: new FormData($('#modificarEvento')[0]),
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
                        $('#actualizarEvento').modal('close');
                        if (result.status == 1) {
                            sweetAlert(1, 'Tipo de Evento modificado correctamente', null);
                        } else if (result.status == 2) {
                            sweetAlert(3, 'Tipo de Evento modificado. ' + result.exception, null);
                        } else {
                            sweetAlert(1, 'Tipo de Evento modificado. ' + result.exception, null);
                        }
                        destroyTable('tblEvento');
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

function deleteEvents(id) {
    swal({
            title: 'Advertencia',
            text: '¿Quiere eliminar el tipo de evento?',
            icon: 'warning',
            buttons: ['Cancelar', 'Aceptar'],
            closeOnClickOutside: false,
            closeOnEsc: false
        })
        .then(function (value) {
            if (value) {
                $.ajax({
                        url: apiEventos + 'actEvents',
                        type: 'post',
                        data: {
                            idEvents: id,
                            statusEvents: 0
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
                                        sweetAlert(1, 'Tipo de Evento eliminado correctamente', null);
                                    } else {
                                        sweetAlert(3, 'Tipo de Evento eliminado. ' + result.exception, null);
                                    }
                                } else {
                                    sweetAlert(2, result.exception, null);
                                }
                                clearTable('tblEvento');
                                destroyTable('tblEvento');
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

function recoverEvents(id) {
    swal({
            title: 'Advertencia',
            text: '¿Quiere recuperar los datos del tipo de evento?',
            icon: 'warning',
            buttons: ['Cancelar', 'Aceptar'],
            closeOnClickOutside: false,
            closeOnEsc: false
        })
        .then(function (value) {
            if (value) {
                $.ajax({
                        url: apiEventos + 'actEvents',
                        type: 'post',
                        data: {
                            idEvents: id,
                            statusEvents: 1
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
                                        sweetAlert(1, 'Tipo de Evento recuperado correctamente', null);
                                    } else {
                                        sweetAlert(3, 'Tipo de Evento recuperado. ' + result.exception, null);
                                    }
                                } else {
                                    sweetAlert(2, result.exception, null);

                                }
                                clearTable('tblEvento');
                                destroyTable('tblEvento');
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
            mensaje = 'Tipo de Fiesta existente';
            break;
        default:
            mensaje = 'Ocurrio un problema, reportese con su administrador';
            break;
    }
    return mensaje;
}

function out() {
    clearTable('tblEvento');
    destroyTable('tblEvento');
    showTable(1);
    link(1);
}

function add() {
    clearTable('tblEvento');
    destroyTable('tblEvento');
    showTable(0);
    link(0);
}

function link(value) {
    let link = '';
    if (value == 0) {
        link += `
        <a class="waves-effect waves-light btn" onclick="out()">Ver Tipo de Evento</a>
    `;
    } else {
        link += `
        <a class="waves-effect waves-light btn" onclick="add()">Ver Tipo de Evento eliminados</a>
    `;
    }
    $('#link').html(link);
}