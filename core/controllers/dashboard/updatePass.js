const api = "../../core/api/user.php?site=dashboard&action=";

$('#email').submit(function(){
    event.preventDefault();
    $.ajax({
        url: api + 'emailCode',
        type: 'post',
		data: $('#email').serialize(),
		datatype: 'json'
    })
    .done(function(response){
        //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
        if (isJSONString(response)) {
            const result = JSON.parse(response);
            //Se comprueba si la respuesta es satisfactoria, sino se muestra la excepción
            if (result.status) {
                location.href = 'recoverUser.php';
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