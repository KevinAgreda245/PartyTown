$(document).ready(function () {
    showTable(1);
    link(1);
})

//Constante para establecer la ruta y parámetros de comunicación con la API
const apiSlider = '../../core/api/slider.php?site=dashboard&action=';

//Función para obtener y mostrar los registros disponibles
function showTable(estado) {
    $.ajax({
            url: apiSlider + 'readSlider',
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
                        initTable('tblSlider');
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
        (row.visibilidadSlider == 1) ? icon = 'visibility': icon = 'visibility_off';
        content += `
            <tr>
                <td>${row.tituloSlider}</td>
                <td>${row.subtituloSlider}</td>
                `;
        if (estado == 1) {
            content += ` 
                <td><i class="material-icons">${icon}</i></td>
                <td><img src="../../resources/img/public/slider/${row.fotoSlider}" class="materialboxed" height="100" width="200"></td>
                <td>
                    <a class="btn waves-effect blue tooltipped" data-position="bottom" data-tooltip="Actualizar"
                        onclick="modalUpdate(${row.idSlider})"><i class="material-icons">loop</i></a>
                    <a class="btn waves-effect waves-light red tooltipped" data-position="bottom" data-tooltip="Eliminar"
                        onclick="deleteSlider(${row.idSlider}, '${row.fotoSlider}')" ><i class="material-icons">delete</i></a>
                </td>
            </tr>
            `;
        } else {
            content += `
                <td><i class="material-icons">visibility_off</i></td>
                <td><img src="../../resources/img/public/slider/${row.fotoSlider}" class="materialboxed" height="100" width="200"></td>
                <td>
                    <a class="btn waves-effect green accent-3 tooltipped" data-position="bottom" data-tooltip="Recuperar"
                        onclick="recoverSlider(${row.idSlider})"><i class="material-icons">replay</i></a>
                </td>
            </tr>
            `;
        }

    });
    $('#tablaSlider').html(content);
    initTable('tblSlider');
    $('.materialboxed').materialbox();
    $('.tooltipped').tooltip();
}


//Función para crear un nuevo registro
$('#nuevoSlider').submit(function () {
    event.preventDefault();
    $.ajax({
            url: apiSlider + 'createSlider',
            type: 'post',
            data: new FormData($('#nuevoSlider')[0]),
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
                        $('#nuevoSlider')[0].reset();
                        $('#agregarSlider').modal('close');
                        if (result.status == 1) {
                            sweetAlert(1, 'Deslizador creado correctamente.', null);
                        } else {
                            sweetAlert(3, 'Deslizador creado. ' + result.exception, null);
                        }
                        destroyTable('tblSlider');
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

function modalUpdate(id) {
    let content = '';
    $.ajax({
            url: apiSlider + 'get',
            type: 'post',
            data: {
                idSlider: id
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
                        $('#modificarSlider')[0].reset();
                        $('#idSlider').val(result.dataset.idSlider);
                        $('#fotoSlider').val(result.dataset.fotoSlider);
                        $('#actualizarTitulo').val(result.dataset.tituloSlider);
                        $('#actualizarSubtitulo').val(result.dataset.subtituloSlider);
                        content += `
                    <img src="../../resources/img/public/slider/${result.dataset.fotoSlider}" width="200" heigth="100">
                `;
                        $('#mostrarFoto').html(content);
                        (result.dataset.visibilidadSlider == 1) ? $('#actualizarEstado').prop('checked', true): $('#actualizarEstado').prop('checked', false);
                        M.updateTextFields();
                        $('#actualizarSlider').modal('open');
                    } else {
                        sweetAlert(2, result.exception, null);
                        destroyTable('tblUsuario');
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

$('#modificarSlider').submit(function () {
    event.preventDefault();
    $.ajax({
            url: apiSlider + 'updateSlider',
            type: 'post',
            data: new FormData($('#modificarSlider')[0]),
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
                        $('#actualizarSlider').modal('close');
                        if (result.status == 1) {
                            sweetAlert(1, 'Deslizador modificado correctamente', null);
                        } else if (result.status == 2) {
                            sweetAlert(3, 'Deslizador modificado. ' + result.exception, null);
                        } else {
                            sweetAlert(1, 'Deslizador modificado. ' + result.exception, null);
                        }
                        destroyTable('tblSlider');
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

//Función para eliminar un registro seleccionado
function deleteSlider(id) {
    swal({
            title: 'Advertencia',
            text: '¿Quiere eliminar la imagen del deslizador?',
            icon: 'warning',
            buttons: ['Cancelar', 'Aceptar'],
            closeOnClickOutside: false,
            closeOnEsc: false
        })
        .then(function (value) {
            if (value) {
                $.ajax({
                        url: apiSlider + 'actSlider',
                        type: 'post',
                        data: {
                            idSlider: id,
                            Estado: 0
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
                                        sweetAlert(1, 'Imagen deslizador eliminado correctamente', null);
                                    } else {
                                        sweetAlert(3, 'Imagen deslizador eliminado. ' + result.exception, null);
                                    }
                                } else {
                                    sweetAlert(2, result.exception, null);
                                }
                                clearTable('tblSlider');
                                destroyTable('tblSlider');
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

//Función para eliminar un registro seleccionado
function recoverSlider(id) {
    swal({
            title: 'Advertencia',
            text: '¿Quiere recuperar la imagen del deslizador?',
            icon: 'warning',
            buttons: ['Cancelar', 'Aceptar'],
            closeOnClickOutside: false,
            closeOnEsc: false
        })
        .then(function (value) {
            if (value) {
                $.ajax({
                        url: apiSlider + 'actSlider',
                        type: 'post',
                        data: {
                            idSlider: id,
                            Estado: 1
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
                                        sweetAlert(1, 'Imagen deslizador recuperado correctamente', null);
                                    } else {
                                        sweetAlert(3, 'Imagen deslizador recuperado. ' + result.exception, null);
                                    }
                                } else {
                                    sweetAlert(2, result.exception, null);
                                }
                                clearTable('tblSlider');
                                destroyTable('tblSlider');
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
    clearTable('tblSlider');
    destroyTable('tblSlider');
    showTable(1);
    link(1);
}

function add() {
    clearTable('tblSlider');
    destroyTable('tblSlider');
    showTable(0);
    link(0);
}

function link(value) {
    let link = '';
    if (value == 0) {
        link += `
        <a class="waves-effect waves-light btn" onclick="out()">Ver Deslizador</a>
    `;
    } else {
        link += `
        <a class="waves-effect waves-light btn" onclick="add()">Ver Deslizador eliminados</a>
    `;
    }
    $('#link').html(link);
}