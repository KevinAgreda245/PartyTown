//Función para comprobar si una cadena tiene formato JSON
function isJSONString(string)
{
    try {
        if (string != "[]") {
            JSON.parse(string);
            return true;
        } else {
            return false;
        }
    } catch(error) {
        return false;
    }
}

//Función para manejar los mensajes de notificación al usuario
function sweetAlert(type, text, url)
{
    if (localStorage.getItem('language') == 'EN') {
        switch (type) {
            case 1:
                title = "Success";
                icon = "success";
                break;
            case 2:
                title = "Error";
                icon = "error";
                break;
            case 3:
                title = 'Warning';
                icon = "warning";
                break;
            case 4:
                title = 'Information';
                icon = "info";
        }
        if (url) {
            swal({
                title: title,
                text: text,
                icon: icon,
                button: 'I Agree',
                closeOnClickOutside: false,
                closeOnEsc: false
            })
            .then(function(value){
                location.href = url;
            });
        } else {
            swal({
                title: title,
                text: text,
                icon: icon,
                button: 'I Agree',
                closeOnClickOutside: false,
                closeOnEsc: false
            });
        }
    } else {
        switch (type) {
            case 1:
                title = "Éxito";
                icon = "success";
                break;
            case 2:
                title = "Error";
                icon = "error";
                break;
            case 3:
                title = "Advertencia";                
                icon = "warning";
                break;
            case 4:
                title = "Aviso";
                icon = "info";
        }
        if (url) {
            swal({
                title: title,
                text: text,
                icon: icon,
                button: 'Aceptar',
                closeOnClickOutside: false,
                closeOnEsc: false
            })
            .then(function(value){
                location.href = url;
            });
        } else {
            swal({
                title: title,
                text: text,
                icon: icon,
                button: 'Aceptar',
                closeOnClickOutside: false,
                closeOnEsc: false
            });
        }
    }
    
}

//Función para generar gráfica de barra
function barGraph(canvas,xAxis, yAxis, legend, title)
{
    let color = [];
    for (i= 0; i < xAxis.length ; i++){
        color.push('#'+(Math.random().toString(16)).substring(2,8));
    }
    const chart = new Chart($('#'+canvas), {
        type: 'bar',
        data: {
            labels: xAxis,
            datasets: [{
                label: legend,
                backgroundColor: color,
                data: yAxis
            }]
        },
        options: {
            responsive: true,
            legend: {
                display: false
            },
            title: {
                display: true,
                text: title
            },
            scales:{
                yAxes:[{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        },
    });
} 

//Función para generar gráfica de pastel
function pieGraph(canvas,xAxis, yAxis, legend, title)
{
    let color = [];
    for (i= 0; i < xAxis.length ; i++){
        color.push('#'+(Math.random().toString(16)).substring(2,8));
    }
    const mypie = new Chart($('#'+canvas), {
        type: 'doughnut',
        data: {
            labels: xAxis,
            datasets: [{
                data: yAxis,
                backgroundColor: color,
                label: legend
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: title
            },
           
        },
    });
} 

//Función para generar gráfica de barra
function lineGraph(canvas,xAxis, yAxis, legend, title)
{
    const chart = new Chart($('#'+canvas), {
        type: 'line',
        data: {
            labels: xAxis,
            datasets: [{
                label: legend,
                backgroundColor: 'rgba(0,0,0,0.0)',
                borderColor: '#'+(Math.random().toString(16)).substring(2,8),
                data: yAxis
            }]
        },
        options: {
            responsive: true,
            legend: {
                display: false
            },
            title: {
                display: true,
                text: title
            },
            scales:{
                yAxes:[{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        },
    });
}