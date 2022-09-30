//Constante para establecer la ruta y parámetros de comunicación con la API
const apiCustomer = "../../core/api/customer.php?site=commerce&action=";

function checked(){
    $('#term').prop('checked', true);
}

$('#registroCliente').submit(function()
{
    event.preventDefault();
    if($('#term').prop('checked')){
        $.ajax({
            url: apiCustomer + 'createCustomer',
            type: 'post',
            data: $('#registroCliente').serialize(),
            datatype: 'json',
        })
        .done(function(response){
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                if (result.status) {
                    if (result.status == 1) {
                        sweetAlert(1, 'Cuenta creado correctamente.', 'user.php');
                    } else {
                        sweetAlert(3, 'Cuenta creado. ' + result.exception, 'user.php');
                    }
                } else {
                    if (localStorage.getItem('language') == 'EN'){ 
                        sweetAlert(2, result.exceptionEN, result.url);
                    } else {
                        sweetAlert(2, result.exception, result.url);
                    }
                }
            } else {
                console.log(response);
                sweetAlert(2,error(response), null);
            }
        })
        .fail(function(jqXHR){
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        });
    }else{
        sweetAlert(2, 'Lea los Términos y Condiciones', null);
    }
})

$('#loginCliente').submit(function()
{
    event.preventDefault();
    $.ajax({
        url: apiCustomer + 'loginCustomer',
        type: 'post',
        data: $('#loginCliente').serialize(),
        datatype: 'json',
    })
    .done(function(response){
        //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
        if (isJSONString(response)) {
            const dataset = JSON.parse(response);
            //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                if (dataset.status) {
                    sweetAlert(1, 'Autenticación correcta', 'index.php');
                } else {
                    sweetAlert(2, dataset.exception, dataset.url);
                }
        } else {
            console.log(response);
            sweetAlert(2,error(response), null);
        }
    })
    .fail(function(jqXHR){
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

$('#emailClient2').submit(function(){
    event.preventDefault();
    $.ajax({
        url: apiCustomer + 'emailCode',
        type: 'post',
		data: $('#emailClient2').serialize(),
		datatype: 'json'
    })
    .done(function(response){
        //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
        if (isJSONString(response)) {
            const result = JSON.parse(response);
            //Se comprueba si la respuesta es satisfactoria, sino se muestra la excepción
            if (result.status) {
                $('#correoCliente').val($('#email').val());
                $('#emailClient').text($('#email').val());
                $('#fase1').attr('hidden', true);
                $('#fase2').attr('hidden', false);
            } else {
                if (localStorage.getItem('language') == 'EN'){ 
                    sweetAlert(2, result.exceptionEN, result.url);
                } else {
                    sweetAlert(2, result.exception, result.url);
                }
            }
        } else {
            console.log(response);
        }
    })
    .fail(function (jqXHR) {
        //Se muestran en consola los posibles errores de la solicitud AJAX
        console.log("Error: " + jqXHR.status + " " + jqXHR.statusText);
    });
})

$('#recover').submit(function(){
    event.preventDefault();
    $.ajax({
        url: apiCustomer + 'recoverUser',
        type: 'post',
		data: $('#recover').serialize(),
		datatype: 'json'
    })
    .done(function(response){
        //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
        if (isJSONString(response)) {
            const result = JSON.parse(response);
            //Se comprueba si la respuesta es satisfactoria, sino se muestra la excepción
            if (result.status) {
                $('#fase2').attr('hidden',true);
                $('#fase3').attr('hidden',false);
            } else {
                if (localStorage.getItem('language') == 'EN'){ 
                    sweetAlert(2, result.exceptionEN, result.url);
                } else {
                    sweetAlert(2, result.exception, result.url);
                }
            }
        } else {
            console.log(response);
        }
    })
    .fail(function (jqXHR) {
        //Se muestran en consola los posibles errores de la solicitud AJAX
        console.log("Error: " + jqXHR.status + " " + jqXHR.statusText);
    });
})

$('#restorePass').submit(function(){
    event.preventDefault();
    $.ajax({
        url: apiCustomer + 'restorePass',
        type: 'post',
		data: $('#restorePass').serialize(),
		datatype: 'json'
    })
    .done(function(response){
        //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
        if (isJSONString(response)) {
            const result = JSON.parse(response);
            //Se comprueba si la respuesta es satisfactoria, sino se muestra la excepción
            if (result.status) {
                sweetAlert(1, result.message, 'login.php');
            } else {
                if (localStorage.getItem('language') == 'EN'){ 
                    sweetAlert(2, result.exceptionEN, result.url);
                } else {
                    sweetAlert(2, result.exception, result.url);
                }
            }
        } else {
            console.log(response);
        }
    })
    .fail(function (jqXHR) {
        //Se muestran en consola los posibles errores de la solicitud AJAX
        console.log("Error: " + jqXHR.status + " " + jqXHR.statusText);
    });
})
