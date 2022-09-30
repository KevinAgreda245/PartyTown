$(document).ready(function () {
    //Se inicializa con el llenado de la tabla
    showTable(0);
    link(0);
})

//Constante para establecer la ruta y parámetros de comunicación con la API de Facturas
const apiFacturas = '../../core/api/invoices.php?site=dashboard&action=';
//Constante para establecer la ruta y parámetros de comunicación con la API de Productos
const apiProductos = '../../core/api/product.php?site=dashboard&action=';

//Función para obtener y mostrar los registros disponibles
function showTable(estado) {
    $.ajax({
            url: apiFacturas + 'readInvoices',
            type: 'post',
            data: {
                Estado: estado
            },
            datatype: 'json'
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                if (result.session) {
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
                    sweetAlert(3, result.exception, 'index.php');
                }
            } else {
                console.log(response);
                sweetAlert(2, 'Ocurrio un problema, reportese con su administrador', null);
            }
        })
        .fail(function (jqXHR) {
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        });
}

//Función para llenar tabla con los datos de los registros
function fillTable(rows) {
    let content = '';
    //Se recorren las filas para armar el cuerpo de la tabla y se utiliza comilla invertida para escapar los caracteres especiales
    rows.forEach(function (row) {
        fecha = moment(row.fechahoraFactura, "YYYYMMDD, h:mm:ss a");
        content += `
            <tr>
                <td>${row.nombreCliente} ${row.apellidoCliente}</td>
                <td>${fecha.locale('es').format('LLLL')}</td>
                `;
        if (row.anulacionFactura == 1) {
            content += ` 
                    <td><i class="material-icons">remove</i></td>
                    <td>${row.direccionFactura}</td>
                    <td> No hay acciones disponible</td>
            `;
        } else {
            if (row.estadoFactura == 0) {
                content += ` 
                    <td><i class="material-icons">local_shipping</i></td>
                    <td>${row.direccionFactura}</td>
                    <td>
                        <a class="btn waves-effect waves-light teal tooltipped" data-position="bottom" data-tooltip="Ver Detalle"
                            onclick="viewInvoices(${row.idFactura})" ><i class="material-icons">visibility</i></a>
                        <a class="btn waves-effect light-green darken-4 tooltipped" data-position="bottom" data-tooltip="Comprobante"
                            onclick="viewReport(${row.idFactura})"><i class="material-icons">insert_drive_file</i></a>
                        <a class="btn waves-effect blue tooltipped" data-position="bottom" data-tooltip="Actualizar"
                            onclick="modalUpdate(${row.idFactura})"><i class="material-icons">loop</i></a>
                        <a class="btn waves-effect red darken-2 tooltipped" data-position="bottom" data-tooltip="Anular"
                            onclick="modalCancel(${row.idFactura})"><i class="material-icons">block</i></a>
                    </td>
                </tr>
                `;
            } else {
                content += ` 
                    <td><i class="material-icons">done</i></td>
                    <td>${row.direccionFactura}</td>
                    <td>
                        <a class="btn waves-effect waves-light teal tooltipped" data-position="bottom" data-tooltip="Ver Detalle"
                            onclick="viewInvoices(${row.idFactura})" ><i class="material-icons">visibility</i></a>
                        <a class="btn waves-effect light-green darken-4 tooltipped" data-position="bottom" data-tooltip="Comprobante"
                            onclick="viewReport(${row.idFactura})"><i class="material-icons">insert_drive_file</i></a>
                    </td>
                </tr>
                `;
            }
        }
    });
    $('#tablaFacturas').html(content);
    initTable('tblFacturas');
}

// Función para visualizar el detalle de una factura
function viewInvoices(id) {
    $.ajax({
            url: apiFacturas + 'getProduct',
            type: 'post',
            data: {
                idInvoices: id
            },
            datatype: 'json'
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                if (result.session) {
                    //Se comprueba si el resultado es satisfactorio para mostrar los productos en un modal, sino se muestra la excepción
                    if (result.status) {
                        fillProducts(result.dataset);
                    } else {
                        sweetAlert(2, result.exception, null);
                    }
                } else {
                    sweetAlert(2, result.exception, 'index');
                }
            } else {
                console.log(response);
            }
        })
        .fail(function (jqXHR) {
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        });
}

//Función para llenar con datos la tabla de producto
function fillProducts(rows) {
    let content = '';
    var total = 0;
    //Se recorren las filas para armar el cuerpo de la tabla y se utiliza comilla invertida para escapar los caracteres especiales
    rows.forEach(function (row) {
        subtotal = parseFloat(row.cantidad * row.precioProducto).toFixed(2);
        content += `
        <tr>
            <td>${row.nombreProducto}</td>
            <td>${row.cantidad}</td>
            <td>${subtotal}</td>
        </tr>
        `;
        total = parseFloat(subtotal) + parseFloat(total);
        total = parseFloat(total).toFixed(2);
    });
    $('#tablaProductos').html(content);
    let totalPagar = '';
    totalPagar += `
            <h5>Total a Pagar: $${total}</h5>
        `;
    $('#total').html(totalPagar);
    $('#verDetalle').modal('open');
}

function modalUpdate(id) {
    swal({
            title: 'Advertencia',
            text: '¿Factura entregada exitosamente?',
            icon: 'warning',
            buttons: ['No', 'Sí'],
            closeOnClickOutside: false,
            closeOnEsc: false
        })
        .then(function (value) {
            if (value) {
                $.ajax({
                        url: apiFacturas + 'updateInvoices',
                        type: 'post',
                        data: {
                            idFactura: id
                        },
                        datatype: 'json'
                    })
                    .done(function (response) {
                        //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
                        if (isJSONString(response)) {
                            const result = JSON.parse(response);
                            if (result.session) {
                                //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                                if (result.status) {
                                    if (result.status == 1) {
                                        sweetAlert(1, 'Factura modificada correctamente', null);
                                    } else {
                                        sweetAlert(3, 'Factura modificada. ' + result.exception, null);
                                    }
                                } else {
                                    sweetAlert(2, result.exception, null);

                                }
                                clearTable('tblFacturas');
                                destroyTable('tblFacturas');
                                showTable(0);
                            } else {
                                sweetAlert(2, result.exception, 'index');
                            }
                        } else {
                            console.log(response);
                        }
                    })
                    .fail(function (jqXHR) {
                        //Se muestran en consola los posibles errores de la solicitud AJAX
                        console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
                    });
            }
        });
}

function modalCancel(id) {
    swal({
            title: 'Advertencia',
            text: '¿Desea anular la factura?',
            icon: 'warning',
            buttons: ['No', 'Sí'],
            closeOnClickOutside: false,
            closeOnEsc: false
        })
        .then(function (value) {
            if (value) {
                $.ajax({
                        url: apiFacturas + 'cancelInvoices',
                        type: 'post',
                        data: {
                            idFactura: id
                        },
                        datatype: 'json'
                    })
                    .done(function (response) {
                        //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
                        if (isJSONString(response)) {
                            const result = JSON.parse(response);
                            if (result.session) {
                                //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                                if (result.status) {
                                    if (result.status == 1) {
                                        sweetAlert(1, 'Factura anulada correctamente', null);
                                        getProducts(id);
                                    } else {
                                        sweetAlert(3, 'Factura anulada. ' + result.exception, null);
                                    }
                                } else {
                                    sweetAlert(2, result.exception, null);

                                }
                                clearTable('tblFacturas');
                                destroyTable('tblFacturas');
                                showTable(0);
                            } else {
                                sweetAlert(2, result.exception, 'index');
                            }
                        } else {
                            console.log(response);
                        }
                    })
                    .fail(function (jqXHR) {
                        //Se muestran en consola los posibles errores de la solicitud AJAX
                        console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
                    });
            }
        });
}

function getProducts(id) {
    $.ajax({
            url: apiFacturas + 'getProduct',
            type: 'post',
            data: {
                idInvoices: id
            },
            datatype: 'json'
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                if (result.session) {
                    //Se comprueba si el resultado es satisfactorio para mostrar los valores en el formulario, sino se muestra la excepción
                    if (result.status) {
                        resupplyProducts(result.dataset);
                    } else {
                        sweetAlert(2, result.exception, null);
                    }
                } else {
                    sweetAlert(2, result.exception, 'index');
                }
            } else {
                console.log(response);
            }
        })
        .fail(function (jqXHR) {
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        });
}

function resupplyProducts(rows) {
    rows.forEach(function (row) {
        codigo = row.codigo;
        cantidad = row.cantidad;
        $.ajax({
            url: apiProductos + 'resupplyProducts',
            type: 'post',
            data: {
                Codigo: codigo,
                Cantidad: cantidad
            },
            datatype: 'json',
        })
    });
}

function out() {
    clearTable('tblFacturas');
    destroyTable('tblFacturas');
    showTable(0);
    link(0);
}

function add() {
    clearTable('tblFacturas');
    destroyTable('tblFacturas');
    showTable(1);
    link(1);
}

function link(value) {
    let link = '';
    if (value == 1) {
        link += `
        <a class="waves-effect waves-light btn" onclick="out()">Ver Facturas</a>
    `;
    } else {
        link += `
        <a class="waves-effect waves-light btn" onclick="add()">Ver Factura anuladas</a>
    `;
    }
    $('#link').html(link);
}

function viewReport(id) {
    $.ajax({
        url: apiProductos + 'reports',
        type: 'post',
        data: {
            idInvoices: id
        },
        datatype: 'json',
    })
    window.open('../../core/reports/dashboard/purchaseVerder.php');
}