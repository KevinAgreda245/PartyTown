//Constante para establecer la ruta y parámetros de comunicación con la API
const apiAccount = '../../core/api/customer.php?site=commerce&action=';

//Función para cerrar la sesión del usuario
function signOff()
{
    
    if (localStorage.getItem('language') == 'ES') {
        swal({
            title: 'Advertencia',
            text: '¿Quiere cerrar la sesión?',
            icon: 'warning',
            buttons: ['Cancelar', 'Aceptar'],
            closeOnClickOutside: false,
            closeOnEsc: false
        })
        .then(function(value){
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
    } else {
        swal({
            title: 'Warning',
            text: 'Want to close the session?',
            icon: 'warning',
            buttons: ['Cancel', 'I agree'],
            closeOnClickOutside: false,
            closeOnEsc: false
        })
        .then(function(value){
            if (value) {
                location.href = apiAccount + 'logout';
            } else {
                swal({
                    title: 'Congratulations',
                    text: 'Continue with the session...',
                    icon: 'info',
                    button: 'I agree',
                    closeOnClickOutside: false,
                    closeOnEsc: false
                });
            }
        });
    }
    
}
