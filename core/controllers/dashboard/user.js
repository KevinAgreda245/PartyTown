$(document).ready(function () {
    showTable(1);
    link(1);
    showSelectCategorias('nuevoTipo', null);
})

//Constante para establecer la ruta y parámetros de comunicación con la API
const apiUsuarios = '../../core/api/user.php?site=dashboard&action=';

//Función para obtener y mostrar los registros disponibles
function showTable(estado) {
    $.ajax({
            url: apiUsuarios + 'readUser',
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
                        initTable('tblUsuario');
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
        content += `
            <tr>
                <td>${row.nombreUsuario}</td>
                <td>${row.apellidoUsuario}</td>
                <td>${row.correoUsuario}</td>
                <td>${row.tipoUsuario}</td>
                <td><img src="../../resources/img/dashboard/user/${row.fotoUsuario}" class="materialboxed" height="100" width="100"></td>
                `;
        if (estado == 1) {
            content += `
                <td>
                    <a class="btn waves-effect blue tooltipped" data-position="bottom" data-tooltip="Actualizar"
                    onclick="modalUpdate(${row.idUsuario})"><i class="material-icons">loop</i></a>
                    <a class="btn waves-effect waves-light red tooltipped" data-position="bottom" data-tooltip="Eliminar"
                    onclick="deleteUser(${row.idUsuario})" ><i class="material-icons">delete</i></a>
                </td>
            </tr>
                `;
        } else {
            content += `
                <td>    
                    <a class="btn waves-effect green accent-3 tooltipped" data-position="bottom" data-tooltip="Recuperar"
                        onclick="recoverUser(${row.idUsuario})"><i class="material-icons">replay</i></a>
                </td>
            </tr>
                `;
        }

    });
    $('#tablaUsuario').html(content);
    initTable('tblUsuario');
    $('.materialboxed').materialbox();
    $('.tooltipped').tooltip();
}

//Función para crear un nuevo registro
$('#nuevoUsuario').submit(function () {
    event.preventDefault();
    $.ajax({
            url: apiUsuarios + 'createUser',
            type: 'post',
            data: new FormData($('#nuevoUsuario')[0]),
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
                        $('#nuevoUsuario')[0].reset();
                        $('#agregarUsuario').modal('close');
                        if (result.status == 1) {
                            sweetAlert(1, 'Usuario creado correctamente.', null);
                        } else {
                            sweetAlert(3, 'Usuario creado. ' + result.exception, null);
                        }
                        destroyTable('tblUsuario');
                        showTable(1);
                    } else {
                        sweetAlert(2, result.exception, null);
                    }
                } else {
                    sweetAlert(3, result.exception, 'index');
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

function showSelectCategorias(idSelect, value) {
    $.ajax({
            url: apiUsuarios + 'readTypeUser',
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
                            if (row.idTipoUsuario != value) {
                                content += `<option value="${row.idTipoUsuario}">${row.tipoUsuario}</option>`;
                            } else {
                                content += `<option value="${row.idTipoUsuario}" selected>${row.tipoUsuario}</option>`;
                            }
                        });
                        $('#' + idSelect).html(content);
                    } else {
                        $('#' + idSelect).html('<option value="">No hay opciones</option>');
                    }
                    $('select').formSelect();
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

//Función para mostrar formulario con registro a modificar
function modalUpdate(id) {
    let content = '';
    $.ajax({
            url: apiUsuarios + 'get',
            type: 'post',
            data: {
                idUser: id
            },
            datatype: 'json'
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                //Se comprueba si el resultado es satisfactorio para mostrar los valores en el formulario, sino se muestra la excepción
                if (result.session) {
                    if (result.status) {
                        $('#modificarUsuario')[0].reset();
                        $('#idUsuario').val(result.dataset.idUsuario);
                        $('#fotoUsuario').val(result.dataset.fotoUsuario);
                        $('#actualizarNombre').val(result.dataset.nombreUsuario);
                        $('#actualizarApellido').val(result.dataset.apellidoUsuario);
                        $('#actualizarCorreo').val(result.dataset.correoUsuario);
                        validateDate(result.dataset.fechaNacimiento)
                        $('#afechaNacimiento').val((result.dataset.fechaNacimiento).split('-').reverse().join('/'));
                        $('#actualizarTelefono').val(result.dataset.telefonoUsuario);
                        content += `
                        <img src="../../resources/img/dashboard/user/${result.dataset.fotoUsuario}" width="100" heigth="100">
                    `;
                        $('#mostrarFoto').html(content);
                        showSelectCategorias('actualizarTipo', result.dataset.idTipoUsuario);
                        M.updateTextFields();
                        $('#actualizarUsuario').modal('open');
                    } else {
                        sweetAlert(2, result.exception, null);
                        destroyTable('tblUsuario');
                        showTable(1);
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

$('#modificarUsuario').submit(function () {
    event.preventDefault();
    $.ajax({
            url: apiUsuarios + 'updateUser',
            type: 'post',
            data: new FormData($('#modificarUsuario')[0]),
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
                        $('#actualizarUsuario').modal('close');
                        if (result.status == 1) {
                            sweetAlert(1, 'Usuario modificado correctamente', null);
                        } else if (result.status == 2) {
                            sweetAlert(3, 'Usuario modificado. ' + result.exception, null);
                        } else {
                            sweetAlert(1, 'Usuario modificado. ' + result.exception, null);
                        }
                        getData();
                        destroyTable('tblUsuario');
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

function deleteUser(id) {
    swal({
            title: 'Advertencia',
            text: '¿Quiere eliminar el usuario?',
            icon: 'warning',
            buttons: ['Cancelar', 'Aceptar'],
            closeOnClickOutside: false,
            closeOnEsc: false
        })
        .then(function (value) {
            if (value) {
                $.ajax({
                        url: apiUsuarios + 'actUser',
                        type: 'post',
                        data: {
                            idUser: id,
                            statusUser: 0
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
                                        sweetAlert(1, 'Usuario eliminado correctamente', null);
                                    } else {
                                        sweetAlert(3, 'Usuario eliminado. ' + result.exception, null);
                                    }
                                } else {
                                    sweetAlert(2, result.exception, null);
                                }
                                clearTable('tblUsuario');
                                destroyTable('tblUsuario');
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

function recoverUser(id) {
    swal({
            title: 'Advertencia',
            text: '¿Quiere recuperar los datos del usuario?',
            icon: 'warning',
            buttons: ['Cancelar', 'Aceptar'],
            closeOnClickOutside: false,
            closeOnEsc: false
        })
        .then(function (value) {
            if (value) {
                $.ajax({
                        url: apiUsuarios + 'actUser',
                        type: 'post',
                        data: {
                            idUser: id,
                            statusUser: 1
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
                                        sweetAlert(1, 'Usuario recuperado correctamente', null);
                                    } else {
                                        sweetAlert(3, 'Usuario recuperado. ' + result.exception, null);
                                    }
                                } else {
                                    sweetAlert(2, result.exception, null);

                                }
                                clearTable('tblUsuario');
                                destroyTable('tblUsuario');
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
            mensaje = 'Correo y/o Teléfono existente';
            break;
        default:
            mensaje = 'Ocurrio un problema, reportese con su administrador';
            break;
    }
    return mensaje;
}


function out() {
    clearTable('tblUsuario');
    destroyTable('tblUsuario');
    showTable(1);
    link(1);
}

function add() {
    clearTable('tblUsuario');
    destroyTable('tblUsuario');
    showTable(0);
    link(0);
}

function link(value) {
    let link = '';
    if (value == 0) {
        link += `
        <a class="waves-effect waves-light btn" onclick="out()">Ver Usuario</a>
    `;
    } else {
        link += `
        <a class="waves-effect waves-light btn" onclick="add()">Ver Usuario eliminados</a>
    `;
    }
    $('#link').html(link);
}