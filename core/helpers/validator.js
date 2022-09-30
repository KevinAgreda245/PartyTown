var hoy = new Date();

function validateDate(date) {
    $('.datepicker').datepicker({
        autoClose: true,
        format: 'dd/mm/yyyy',
        maxDate: new Date(hoy.getFullYear() - 18, hoy.getMonth(), hoy.getDate()),
        minDate: new Date(hoy.getFullYear() - 99, hoy.getMonth(), hoy.getDate()),
        defaultDate: new Date(date),
        i18n: {
            cancel: 'Cancelar',
            clear: '',
            done: 'Aceptar',
            months: [
                'Enero',
                'Febrero',
                'Marzo',
                'Abril',
                'Mayo',
                'Junio',
                'Julio',
                'Agosto',
                'Septiembre',
                'Octubre',
                'Noviembre',
                'Diciembre'
            ],
            monthsShort: [
                'Ene',
                'Feb',
                'Mar',
                'Abr',
                'May',
                'Jun',
                'Jul',
                'Ago',
                'Sep',
                'Oct',
                'Nov',
                'Dic'
            ],
            weekdaysShort: [
                'Domingo',
                'Lunes',
                'Martes',
                'Miercoles',
                'Jueves',
                'Viernes',
                'Sábado'
            ],
            weekdaysAbbrev: [
                'Do',
                'Lu',
                'Ma',
                'Mi',
                'Ju',
                'Vi',
                'Sa'
            ]
        }
    })
}

function validateImage(value) {
    val = $('#' + value).val();
    var allowedExtensions = /(.jpg|.jpeg|.png|.gif)$/i;
    if (!allowedExtensions.exec(val)) {
        $('#' + value).removeClass("valid").addClass("invalid")
    } else {
        $('#' + value).removeClass("invalid").addClass("valid")
    }

}

function validateAlphabetic(value, minLength, maxLength) {
    val = $('#' + value).val();
    if (val != '') {
        if (/^[a-zA-ZñÑáÁéÉíÍóÓúÚ\s]+$/.test(val)) {
            if (val.length >= minLength && val.length <= maxLength) {
                resp = 'valid';
            } else {
                resp = 'invalid';
            }
        } else {
            resp = 'invalid';
        }
    } else {
        resp = 'invalid';
    }
    $('#' + value).addClass(resp)
}

function validateAlphanumeric(value, minLength, maxLength) {
    val = $('#' + value).val();
    if (val != '') {
        if (/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.]+$/.test(val)) {
            if (val.length >= minLength && val.length <= maxLength) {
                resp = 'valid';
            } else {
                resp = 'invalid';
            }
        } else {
            resp = 'invalid';
        }
    } else {
        resp = 'invalid';
    }
    $('#' + value).addClass(resp)
}

function validateEmail(value) {
    val = $('#' + value).val();
    if (val != '') {
        regEx = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (val.match(regEx)) {
            resp = 'valid'
        } else {
            resp = 'invalid';
        }
    } else {
        resp = 'invalid'
    }
    $('#' + value).addClass(resp)
}

function validatePhone(value) {
    val = $('#' + value).val()
    if (val != '') {
        if (/^([2,6,7]{1}[0-9]{3})(-)([0-9]{4})+$/.test(val)) {
            resp = 'valid';
        } else {
            resp = 'invalid';
        }
    } else {
        resp = 'invalid'
    }
    $('#' + value).addClass(resp);
}

function validateMoney(value) {
    val = $('#' + value).val()
    if (val != '') {
        if (/^[0-9]+(?:\.[0-9]{1,2})?$/.test(val)) {
            $('#' + value).removeClass("invalid").addClass("valid")
        } else {
            $('#' + value).removeClass("valid").addClass("invalid")
        }
    } else {
        $('#' + value).removeClass("valid").addClass("invalid")
    }
}

function validateNumeric(value) {
    val = $('#' + value).val();
    if (val != '') {
        if (/^\d*$/.test(val)) {
            $('#' + value).removeClass("invalid").addClass("valid")
        } else {
            $('#' + value).removeClass("valid").addClass("invalid")
        }
    } else {
        $('#' + value).removeClass("valid").addClass("invalid")
    }

}

function validatePassword(value) {
    val = $('#' + value).val()
    if (val != '' && /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(val)) {
        resp = 'valid';
    } else {
        resp = 'invalid'
    }
    $('#' + value).addClass(resp);
}

function confirmPassword(value, clave1) {
    val = $('#' + value).val();
    val2 = $('#' + clave1).val();
    if (val == val2) {
        resp = 'valid';
    } else {
        resp = 'invalid';
    }
    $('#' + value).addClass(resp);
}

function empty(value) {
    val = $('#' + value).val();
    if (val != '') {
        $('#' + value).addClass('valid');
    } else {
        $('#' + value).addClass('invalid');
    }
}