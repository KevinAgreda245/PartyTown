$(document).ready(function()
{
    getData();
})

//Constante para establecer la ruta y parámetros de comunicación con la API
const apiClient = '../../core/api/customer.php?site=commerce&action=';

function showSelectCategorias(idSelect, value)
{
    let content = '';
    if(value == 2){
        content += `<option value="2" selected>Femenino</option>
        <option value="1">Masculino</option>
        `;
    } else if(value = 1){
        content += `<option value="1" selected>Masculino</option>
        <option value="2">Femenino</option>
        `;
    }
    $('#' + idSelect).html(content);
    $('select').formSelect();
}


function getData(){
    $.ajax({
        url: apiClient + 'getData',
        type: 'post',
        data: null,
        datatype: 'json'
    })
    .done(function(response){
        //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
        if (isJSONString(response)) {
            const result = JSON.parse(response);
            //Se comprueba si el resultado es satisfactorio para mostrar los valores en el formulario, sino se muestra la excepción
            if (result.status) {
                $('#modificarCliente')[0].reset();
                $('#nombres').val(result.dataset.nombreCliente);
                $('#apellidos').val(result.dataset.apellidoCliente);
                $('#correo').val(result.dataset.correoCliente);
                validateDate(result.dataset.fechaNacimiento);
                $('#nacimiento').val((result.dataset.fechaNacimiento).split('-').reverse().join('/'));
                $('#telefono').val(result.dataset.telefonoCliente);
                showSelectCategorias('genero', result.dataset.generoCliente);
                M.updateTextFields();
            } else {
                if (localStorage.getItem('language') == 'EN'){
                    sweetAlert(2, result.exceptionEN, null);
                } else {
                    sweetAlert(2, result.exception, null);
                }
            }
        } else {
            console.log(response);
        }
    })
    .fail(function(jqXHR){
        //Se muestran en consola los posibles errores de la solicitud AJAX
        console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
    });
}

$('#modificarCliente').submit(function(){
    event.preventDefault();
    $.ajax({
        url: apiClient + 'updateCustomer',
        type: 'post',
        data: $('#modificarCliente').serialize(),
        datatype: 'json',
    })
    .done(function(response){
        //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
        if (isJSONString(response)) {
            const result = JSON.parse(response);
            //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
            if (result.status) {
                if (localStorage.getItem('language') == 'EN') {
                    sweetAlert(1, 'User successfully modified', 'user.php');
                } else {
                    sweetAlert(1, 'Usuario modificado correctamente', 'user.php');
                }  
            } else {
                if (localStorage.getItem('language') == 'EN'){
                    sweetAlert(2, result.exceptionEN, null);
                } else {
                    sweetAlert(2, result.exception, null);
                }
            }
        } else {
            console.log(response);
            sweetAlert(2,error(response),null);
        }
    })
    .fail(function(jqXHR){
        //Se muestran en consola los posibles errores de la solicitud AJAX
        console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
    });
})

//Función para cambiar la contraseña del usuario que ha iniciado sesión
$('#modificarContraseña').submit(function () {
    event.preventDefault();
    $.ajax({
            url: apiClient + 'password',
            type: 'post',
            data: $('#modificarContraseña').serialize(),
            datatype: 'json'
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                //if (result.session) {
                    //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                    if (result.status) {
                        $('#actualizarContraseña').modal('close');
                        if (localStorage.getItem('language') == 'EN'){ 
                            sweetAlert(1, 'Password changed correctly', 'index.php');
                        } else {
                            sweetAlert(1, 'Contraseña cambiada correctamente', 'index.php');
                        }
                    } else {
                        if (localStorage.getItem('language') == 'EN'){ 
                            sweetAlert(2, result.exceptionEN, null);
                        } else {
                            sweetAlert(2, result.exception, null);
                        }
                    }
                //} else {
                    //sweetAlert(2, result.exception, 'index');
                //}
            } else {
                console.log(response);
            }
        })
        .fail(function (jqXHR) {
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        });
})

function error(response){
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
