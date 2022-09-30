$(document).ready(function()
{
    showTable();
    $('.englishOnclick').attr('onclick','showEn2()');
    $('.españolOnclick').attr('onclick','showEs2()');
});

//Constante para establecer la ruta y parámetros de comunicación con la API de Facturas
const apiFacturas = '../../core/api/invoices.php?site=commerce&action=';

//Función para obtener y mostrar los registros disponibles
function showTable()
{
    $.ajax({
        url: apiFacturas + 'readInvoices',
        type: 'post',
        data: null,
        datatype: 'json'
    })
    .done(function(response){
        //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
        if (isJSONString(response)) {
            const result = JSON.parse(response);
            //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
            if (result.status) {
                //
                fillTable(result.dataset);
            } else {
                //Se inicializa la tabla si en un dado caso no existen datos
                initTable('tblFacturas');
                sweetAlert(4, result.exception, null);
            }
        } else {
            console.log(response);
            sweetAlert(2,'Ocurrio un problema, reportese con su administrador', null);
        }
    })
    .fail(function(jqXHR){
        //Se muestran en consola los posibles errores de la solicitud AJAX
        console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
    });
}

//Función para llenar tabla con los datos de los registros
function fillTable(rows)
{   
    let content = '';
    //Se recorren las filas para armar el cuerpo de la tabla y se utiliza comilla invertida para escapar los caracteres especiales
    rows.forEach(function(row){
        fecha = moment(row.fechahoraFactura,"YYYYMMDD, h:mm:ss a");
        content += `
        <tr>         
            <td>${fecha.locale('es').format('LLLL')}</td>
            <td>${row.direccionFactura}</td>
            `;
        if(row.anulacionFactura == 1){
            content += `
            <td><span class="new badge red" data-badge-caption="Anuladas"></span></td>
            <td>
                <a class="btn waves-effect waves-light teal tooltipped" data-position="bottom" data-tooltip="Ver Detalle"
                    onclick="viewInvoices(${row.idFactura})" ><i class="material-icons">visibility</i></a>
                <a class="btn waves-effect light-green darken-4 tooltipped" data-position="bottom" data-tooltip="Comprobante"
                    onclick="viewReport(${row.idFactura})"><i class="material-icons">insert_drive_file</i></a>
            </td>
        </tr>
            `;
        } else if(row.estadoFactura == 1){
            content += `
            <td><span class="new badge blue" data-badge-caption="Entregadas"></span></td>
            <td>
                <a class="btn waves-effect waves-light teal tooltipped" data-position="bottom" data-tooltip="Ver Detalle"
                    onclick="viewInvoices(${row.idFactura})" ><i class="material-icons">visibility</i></a>
                <a class="btn waves-effect light-green darken-4 tooltipped" data-position="bottom" data-tooltip="Comprobante"
                    onclick="viewReport(${row.idFactura})"><i class="material-icons">insert_drive_file</i></a>
            </td>
        </tr>
            `;  
        } else {
            content += `
            <td><span class="new badge" data-badge-caption="Pendientes"></span></td>
            <td>
                <a class="btn waves-effect waves-light teal tooltipped" data-position="bottom" data-tooltip="Ver Detalle"
                    onclick="viewInvoices(${row.idFactura})" ><i class="material-icons">visibility</i></a>
                <a class="btn waves-effect light-green darken-4 tooltipped" data-position="bottom" data-tooltip="Comprobante"
                    onclick="viewReport(${row.idFactura})"><i class="material-icons">insert_drive_file</i></a>
            </td>
        </tr>
            `;  
        }
        
    });
    $('#tablaFacturas').html(content);
    initTable2('tblFacturas');
    $('.tooltipped').tooltip();
}

// Función para visualizar el detalle de una factura
function viewInvoices(id){
    $.ajax({
        url: apiFacturas + 'getProduct',
        type: 'post',
        data:{
            idInvoices: id
        },
        datatype: 'json'
    })
    .done(function(response){
        //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
        if (isJSONString(response)) {
            const result = JSON.parse(response);
            //Se comprueba si el resultado es satisfactorio para mostrar los productos en un modal, sino se muestra la excepción
            if (result.status) {
                fillProducts(result.dataset);
            } else {
                sweetAlert(2, result.exception, null);
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

//Función para llenar con datos la tabla de producto
function fillProducts(rows){
    let content = '';
    var total = 0;
    //Se recorren las filas para armar el cuerpo de la tabla y se utiliza comilla invertida para escapar los caracteres especiales
    rows.forEach(function(row){
        subtotal = parseFloat(row.cantidad * row.precioProducto).toFixed(2);
        content += `
        <tr>
            <td>${row.nombreProducto}</td>
            <td>${row.cantidad}</td>
            <td>$${subtotal}</td>
        </tr>
        `;
        total = parseFloat(subtotal) + parseFloat(total);
        total =  parseFloat(total).toFixed(2);
    });
    $('#tablaProductos').html(content);
    let totalPagar = '';
        totalPagar += `
            <h5><span class="lang" key="topa">Total a pagar:</span> $${total}</h5>
        `;
    $('#total').html(totalPagar);
    showTraslate(localStorage.getItem('language'));
    $('#verDetalle').modal('open');
}

function viewReport(id){
    $.ajax({
        url: apiFacturas + 'reports',
        type: 'post',
        data: {
            idInvoices: id
        },
        datatype: 'json',
    })
    window.open('../../core/reports/public/purchaseVerder.php?lang='+localStorage.getItem('language'));
}