$(document).ready(function() {
    checkUsuarios();
})

//Constante para establecer la ruta y parámetros de comunicación con la API
const apiRegistro = '../../core/api/user.php?site=dashboard&action=';

//Función para verificar si existen usuarios en el sitio privado
function checkUsuarios() {
    $.ajax({
            url: apiRegistro + 'read',
            type: 'post',
            data: null,
            datatype: 'json'
        })
        .done(function(response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const dataset = JSON.parse(response);
                //Se comprueba que no hay usuarios registrados para redireccionar al registro del primer usuario
                if (dataset.status == 1) {
                    sweetAlert(3, dataset.exception, 'index.php');
                }
            } else {
                console.log(response);
            }
        })
        .fail(function(jqXHR) {
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        });
}

//Función para crear un nuevo registro
$('#nuevoUsuario').submit(function() {

    event.preventDefault();
    swal({
            title: 'Advertencia',
            text: '¿Verificó la nueva contraseña?',
            icon: 'warning',
            buttons: ['Cancelar', 'Aceptar'],
            closeOnClickOutside: false,
            closeOnEsc: false
        })
        .then(function(value) {
            if (value) {
                createUser();
            } else {
                swal({
                    title: 'Asegúrese',
                    text: 'Verifique detalladamente la constraseña',
                    icon: 'info',
                    button: 'Aceptar',
                    closeOnClickOutside: false,
                    closeOnEsc: false
                });
            }
        });

})

function createUser() {

    //Antes de crear un nuevo usuario, verificamos que el nombre y la contraseña no coincidan, aún cuando esto es imposible por las demás validaciones.
    // También, validamos aquí y en el validator.js que la contraseña cumpla con los requisitos de carácteres.
    if (!($('#nuevoNombre').val() === $('#nuevaClave1').val() && $('#nuevoNombre').val() === $('#nuevaClave2').val()) && /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test($('#nuevaClave1').val())) {
        $.ajax({
                url: apiRegistro + 'createUser',
                type: 'post',
                data: new FormData($('#nuevoUsuario')[0]),
                datatype: 'json',
                cache: false,
                contentType: false,
                processData: false
            })
            .done(function(response) {
                //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
                if (isJSONString(response)) {
                    const result = JSON.parse(response);
                    //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                    if (result.status) {
                        $('#nuevoUsuario')[0].reset();
                        if (result.status == 1) {
                            sweetAlert(1, 'Usuario creado correctamente.', 'index.php');
                        } else {
                            sweetAlert(3, 'Usuario creado. ' + result.exception, 'index.php');
                        }
                    } else {
                        sweetAlert(2, result.exception, null);
                    }
                } else {
                    console.log(response);
                }
            })
            .fail(function(jqXHR) {
                //Se muestran en consola los posibles errores de la solicitud AJAX
                console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
            });
    } else {
        sweetAlert(2, 'La contraseña debe ser distinta al nombre', null);
    }
}