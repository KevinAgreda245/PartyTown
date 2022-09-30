$(document).ready(function()
{
    getProduct();
})

//Constante para establecer la ruta y parámetros de comunicación con la API de Tipo de Producto
const apiProduct = '../../core/api/product.php?site=commerce&action=';

function getProduct(){
    $.ajax({
        url: apiProduct + 'getPre',
        type: 'post',
        data: null,
        datatype: 'json'
    })
    .done(function(response){
        //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
        if (isJSONString(response)) {
            const result = JSON.parse(response);
            if (result.session) {
                //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                if (result.status) {
                    fillProducts(result.dataset);
                } else {
                    if (localStorage.getItem('language') == 'EN') {
                        sweetAlert(2, result.exceptionEN , 'index.php');   
                    } else {
                        sweetAlert(2, result.exception , 'index.php');   
                    }
                }
            } else {
                if (localStorage.getItem('language') == 'EN') {
                    sweetAlert(3, result.exceptionEN , 'index.php');   
                } else {
                    sweetAlert(3, result.exception , 'index.php');   
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

function fillProducts(rows){
    let content = '';
    let total = 0;
    let item = 0;
    rows.forEach(function(row){
        subtotal = parseFloat(row.cant * row.precioProducto).toFixed(2);
        total = parseFloat(subtotal) + parseFloat(total);
        total =  parseFloat(total).toFixed(2);
        precio = parseFloat(row.precioProducto).toFixed(2);
        item++;
        content += `
        <!--Carta para cada producto-->
            <div class="card horizontal">
                <!--Imagen del producto-->
                <div class="card-image">
                    <img class="materialboxed" src="../../resources/img/public/products/${row.fotoProducto}">
                </div>
                <!--Detalle del producto-->
                    <div class="card-stacked">
                        <div class="card-content">
                            <h5>${row.nombreProducto}</h5>
                            <p><b class="lang" key="precio">Precio USD($):</b> ${precio}</p>
                            <p><b class="lang" key="cantidad">Cantidad: </b> ${row.cant}</b>
                            <p><b class="lang" key="subtotal">Subtotal USD($):</b>${subtotal}</p>
                        </div>
                        <!--Botón para eliminar el producto de la venta-->
                        <div class="card-action right-align">
                            <a class='btn waves-effect red modal-trigger tooltipped' data-position='right' data-tooltip='Eliminar'onclick="deleteProducto(${row.idProducto})"><i class="material-icons">delete_forever</i></a>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    $('#listProduct').html(content);
    let totalPagar = `<p><span class="lang" key="totalPagar">Total a Pagar</span>(${item} items) USD($):${total}</p>`;
    $('#total').html(totalPagar);
    showTraslate(lang);
}

$('#crearFactura').submit(function(){
    event.preventDefault();
    $.ajax({
        url: apiProduct + 'createInvoices',
        type: 'post',
        data: $('#crearFactura').serialize(),
        datatype: 'json',
    })
    .done(function(response){
        //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
        if (isJSONString(response)) {
            const result = JSON.parse(response);
            //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
            if (result.session) {
                if (result.status) {
                    if (result.status == 1) {
                        sweetAlert(1, 'Factura procesada correctamente', 'index.php');
                    }
                    window.open('../../core/reports/public/purchaseVerder.php?lang='+localStorage.getItem('language'));
                } else {
                    if (localStorage.getItem('language') == 'EN') {
                        sweetAlert(2, result.exceptionEN, null);
                    } else {
                        sweetAlert(2, result.exception, null);
                    }
                }
            } else {
                if (localStorage.getItem('language') == 'EN') {
                    sweetAlert(3, result.exceptionEN, 'index');
                } else {
                    sweetAlert(3, result.exception, 'index');
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
})

function deleteProducto(id){
    if (localStorage.getItem('language') == 'EN') {
        swal({
            title: 'Advertencia',
            text: 'Do you want to remove the product?',
            icon: 'warning',
            buttons: ['Cancel', 'I Agree'],
            closeOnClickOutside: false,
            closeOnEsc: false
        })
        .then(function(value){
            if (value) {
                $.ajax({
                    url: apiProduct + 'deletePrePro',
                    type: 'post',
                    data:{
                        idProduct: id
                    },
                    datatype: 'json'
                })
                .done(function(response){
                    //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
                    if (isJSONString(response)) {
                        const result = JSON.parse(response);
                        //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                        if (result.session) {
                            if (result.status) {
                                if (result.status == 1) {
                                    sweetAlert(1, 'Product removed correctly', 'cartSale.php');
                                } else {
                                    sweetAlert(3, 'Product removed. ' + result.exceptionEN, 'cartSale.php');
                                }
                            } else {
                                sweetAlert(2, result.exceptionEN, null);
                            }
                        } else {
                            sweetAlert(3, result.exceptionEN, 'index');
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
        });
    } else {
        swal({
            title: 'Advertencia',
            text: '¿Quiere eliminar el producto?',
            icon: 'warning',
            buttons: ['Cancelar', 'Aceptar'],
            closeOnClickOutside: false,
            closeOnEsc: false
        })
        .then(function(value){
            if (value) {
                $.ajax({
                    url: apiProduct + 'deletePrePro',
                    type: 'post',
                    data:{
                        idProduct: id
                    },
                    datatype: 'json'
                })
                .done(function(response){
                    //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
                    if (isJSONString(response)) {
                        const result = JSON.parse(response);
                        //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                        if (result.session) {
                            if (result.status) {
                                if (result.status == 1) {
                                    sweetAlert(1, 'Producto eliminado correctamente', 'cartSale.php');
                                } else {
                                    sweetAlert(3, 'Product eliminado. ' + result.exceptionEN, 'cartSale.php');
                                }
                            } else {
                                sweetAlert(2, result.exceptionEN, null);
                            }
                        } else {
                            sweetAlert(3, result.exceptionEN, 'index');
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
        });
    }

}