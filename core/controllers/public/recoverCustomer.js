const api = "../../core/api/customer.php?site=commerce&action=";

$('#recover').submit(function(){
    event.preventDefault();
    $.ajax({
        url: api + 'recoverUser',
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
                $('#code').attr('hidden',true);
                $('#pass').attr('hidden',false);
            } else {
                sweetAlert(2, result.exception, result.url);
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
        url: api + 'restorePass',
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
                sweetAlert(1, result.message, 'index.php');
            } else {
                sweetAlert(2, result.exception, result.url);
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
