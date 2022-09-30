$(document).ready(() => {
    readProdType();
});

/* Ruta para la API de tipo de productos */
const apiProdType = '../../core/api/productType.php?site=publicInd&action=';

/* Función que obtiene los tipos de productos | no obtiene los productos, sólo su clasificación */
function readProdType() {
    $.ajax({
            url: apiProdType + 'readProdType',
            type: 'post',
            data: null,
            datatype: 'json'
        })
        .done((response) => {
            /* Verificamos la respuesta sea un JSON */
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                if (result.session) {
                    if (result.status) {
                        let content = '';
                        result.dataset.forEach((row) => {
                            content += `
                        <!--Carta para cada categoría del producto-->
                        <div class="col s12 m6 l4">
                            <div class="card hoverable">
                                <!--Imagen para la categoría del producto-->
                                <div class="card-image">
                                    <img src="../../resources/img/public/categories/${row.fotoTipoProducto}">
                                    <span class="card-title teal lighten-2">${row.tipoProducto}</span>
                                </div>
                                <!--Descripción de la categoría del producto-->
                                <div class="card-content center-align">
                                    <p>${row.descripcionTipo}</p>
                                </div>
                                <!--Botón para dirigir a los producto de la categoría del producto-->
                                <div class="card-action center-align">
                                    <a class="waves-effect waves-light btn blue-grey darken-1" href="listProduct.php"><i class="material-icons right">keyboard_arrow_right</i>Ver
                                        Más</a>
                                </div>
                            </div>
                        </div>
                        `;
                        });
                        $('#catalogo').html(content);
                        $('.tooltipped').tooltip();
                    }
                } else {
                    sweetAlert(3, result.exception, 'index');
                }
            }
        })
        .fail((jqXHR) => {
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        })
}

/* Obtiene los productos de acuerdo al tipo de producto seleccionado */

function readProdsFromProdTypes(id, categoria) {

    $('#slider').hide();
    $.ajax({
            url: apiProdType + 'readProdsFromProdTypes',
            type: 'post',
            data: {
                idTipoProducto: id
            },
            datatype: 'json'
        })
        .done((response) => {

            if (isJSONString(response)) {
                const result = JSON.parse(response);
                if (result.session) {
                    if (result.status) {
                        let content = '';
                        result.dataset.forEach((row) => {
                            content += `
                        <!--Carta del producto-->
                        <div class="card horizontal">
                            <div class="card-image">
                                <!--Imagen del producto-->
                                <img class="materialboxed" src="../../resources/img/public/products/${row.fotoProducto}">
                            </div>
                            <!--Descripción del producto-->
                            <div class="card-stacked">
                                <div class="card-content">
                                    <h5>Paquetes de globos</h5>
                                    <h6 align="justify"><strong>Descripción: </strong>${row.descripcionProducto}</h6>
                                    <h6><strong>Precio USD($): </strong></h6>
                                </div>
                                <div class="card-action">
                                    <a href="detailProduct.php">Detalle de Producto</a>
                                </div>
                            </div>
                        </div>
                        `
                        });
                        $('#title').text('Categoría: ' + categoria);
                        $('#catalogo').html(content);
                    } else {
                        sweetAlert(4, result.exception, 'index');
                    }
                } else {
                    sweetAlert(3, result.exception, 'index');
                }
            } else {
                console.log(response);
            }
        })
        .fail((jqXHR) => {
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        })
}

/* Función para obtener los datos del producto seleccionado */

function getProdDetail(id) {
    $('#slider').hide();
    $.ajax({
            url: apiProdType + 'getProdDetail',
            type: 'post',
            data: {
                idProducto: id
            },
            datatype: 'json'
        })
        .done(() => {

            if (isJSONString(response)) {
                const result = JSON.parse(response);
                if (result.session) {
                    if (result.status) {
                        let content = `
                    <div class="card hoverable">
                    <!--Imagen del producto-->
                    <div class="card-image">
                        <img class="activator materialboxed" src="../../resources/img/public/products/${result.dataset.fotoProducto}">
                        <span class="card-title teal lighten-2">${result.dataset.nombreProducto}</span>
                    </div>
                    <!--Detalle producto-->
                    <div class="card-content">
                        <h6><strong>Descripción: </strong>${result.dataset.descripcionProducto}</h6>
                        <h6><strong>Precio USD($): </strong>${result.dataset.precioProducto}</h6>
                        <!--Estrellas para la clasificación-->
                        <div class="ec-stars-wrapper">
                            <a href="#" data-value="1" title="Votar con 1 estrellas">&#9733;</a>
                            <a href="#" data-value="2" title="Votar con 2 estrellas">&#9733;</a>
                            <a href="#" data-value="3" title="Votar con 3 estrellas">&#9733;</a>
                            <a href="#" data-value="4" title="Votar con 4 estrellas">&#9733;</a>
                            <a href="#" data-value="5" title="Votar con 5 estrellas">&#9733;</a>
                        </div>
                        <h6><strong>Valoración: </strong>${result.dataset.valoracionProducto}</h6>
                    </div>
                    <div class="card-action right-align">
                        <div class="row">
                            <div class="col s6 m4">
                                <!--Input para especificar la cantidad a agregar al carrito de ventas-->
                                <input type="number" value="1" max="10" min="1">
                            </div>
                            <div class="col s6 m8">
                                <!--Boton para agregar al carrito-->
                                <a onclick="M.toast({html: 'Se agrego al Carrito de Ventas'})" class="btn-floating btn-large waves-effect waves-light"><i
                                     class='material-icons right'>add_shopping_cart</i></a>
                            </div>
                        </div>
                    </div>
                </div>
                    
                    `;
                    
                }
            } else {
                sweetAlert(3, result.exception, 'index');
            }
        }});
}
