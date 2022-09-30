$(document).ready(function () {
    getData();
})

//Constante para establecer la ruta y parámetros de comunicación con la API
const apiUsuarios = '../../core/api/user.php?site=dashboard&action=';

function getData() {
    $.ajax({
            url: apiUsuarios + 'getData',
            type: 'post',
            data: null,
            datatype: 'json'
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                if (result.session) {
                    //Se comprueba si el resultado es satisfactorio para mostrar los valores en el formulario, sino se muestra la excepción
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
                        showSelectCategorias('actualizarTipo', result.dataset.idTipoUsuario);
                        M.updateTextFields();
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
                        if (result.status == 1) {
                            sweetAlert(1, 'Usuario modificado correctamente', 'main.php');
                        } else if (result.status == 2) {
                            sweetAlert(3, 'Usuario modificado. ' + result.exception, 'main.php');
                        } else {
                            sweetAlert(1, 'Usuario modificado. ' + result.exception, 'main.php');
                        }
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

//Función para cambiar la contraseña del usuario que ha iniciado sesión
$('#modificarContraseña').submit(function () {
    event.preventDefault();
    $.ajax({
            url: apiUsuarios + 'password',
            type: 'post',
            data: $('#modificarContraseña').serialize(),
            datatype: 'json'
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                if (result.session) {
                    //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                    if (result.status) {
                        $('#actualizarContraseña').modal('close');
                        sweetAlert(1, 'Contraseña cambiada correctamente', 'main.php');
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