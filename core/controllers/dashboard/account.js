$(document).ready(function() {
    getData();
    checkItems();
})

//Constante para establecer la ruta y parámetros de comunicación con la API
const apiAccount = '../../core/api/user.php?site=dashboard&action=';

function getData() {

    $.ajax({
        url: apiAccount + 'getData',
        type: 'post',
        data: null,
        datatype: 'json',
    })
}

function checkItems() {
    $.ajax({
            url: apiAccount + 'readAction',
            type: 'post',
            data: null,
            datatype: 'json'
        })
        .done(function(response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                // Se comprueba que hay acciones registrados para el tipo de usuario
                if (result.status) {
                    console.log(result);
                    fillAction(result.dataset);
                } else {
                    sweetAlert(3, result.exception, null);
                } <<
                <<
                << < HEAD
            },
            error: err => {
                console.log("Error: " + err); ===
                ===
                =
            } else {
                console.log(response); >>>
                >>>
                > 8e577189 ac2cf621fa51f5c2c1a466f7c323ea74
            }
        })
        .fail(function(jqXHR) {
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        });
}

/*
 *   Función para llenar el menú con las acciones
 *
 *   Expects: row (Todas las acciones del tipo del usuario).
 *
 *   Returns: ninguno.
 */

function fillAction(row) {
    let content = "";
    (row).forEach(function(row) {
        content += `
        <li><a class="waves-effect" href="${row.Link}"><i class="material-icons left">${row.Icon}</i><b>${row.Nombre}</b></a></li>
        `;
    });
    $('#actionUser').html(content);
}
//Función para cerrar la sesión del usuario
function signOff() {
    swal({
            title: 'Advertencia',
            text: '¿Quiere cerrar la sesión?',
            icon: 'warning',
            buttons: ['Cancelar', 'Aceptar'],
            closeOnClickOutside: false,
            closeOnEsc: false
        })
        .then(function(value) {
            if (value) {
                location.href = apiAccount + 'logout';
            } else {
                swal({
                    title: 'Enhorabuena',
                    text: 'Continúe con la sesión...',
                    icon: 'info',
                    button: 'Aceptar',
                    closeOnClickOutside: false,
                    closeOnEsc: false
                });
            }
        });
}