<?php
    // Se incluye la clase donde se encuentra el menú y el pie de página
    include '../../core/helpers/publicPages.php';
    // Se llama el método de la clase para que cargue el encabezado y el menú
    publicPages::header('Productos');
?>
<!--Contenedor donde estará la lista de productos de la categoria-->
<div class="container">
    <!--Nombre de la categoria-->
    <h4 id="title"></h4>
    <!--Buscador de productos-->
    <div class="input-field">
        <i class="material-icons prefix">search</i>
        <input id="search" type="search">
    </div>
    <div class="row">
        <div class="col s12 m8 l8 offset-l2 offset-m2" id="catalogo">
            
            <!--Carta del producto-->
            <div class="card horizontal">
                <div class="card-image">
                    <!--Imagen del producto-->
                    <img class="materialboxed" src="../../resources/img/public/products/productID2.png">
                </div>
                <!--Descripción del producto-->
                <div class="card-stacked">
                    <div class="card-content">
                        <h5>Paquetes de Vasos Rojos</h5>
                        <h6 align="justify"><strong>Descripción: </strong>Un paquete de 100 vasos de color rojo, para
                            que tomes tu bebida favorita</h6>
                        <h6><strong>Precio USD($): </strong>3.50</h6>
                    </div>
                    <!--Boton para saber más del producto-->
                    <div class="card-action">
                        <a href="detailProduct.php">Detalle de Producto</a>
                    </div>
                </div>
            </div>
            <!--Carta del producto-->
            <div class="card horizontal">
                <div class="card-image">
                    <!--Imagen del producto-->
                    <img class="materialboxed" src="../../resources/img/public/products/productID3.png">
                </div>
                <!--Descripción del producto-->
                <div class="card-stacked">
                    <div class="card-content">
                        <h5>Caja de Copas de Vidrio</h5>
                        <h6 align="justify"><strong>Descripción: </strong>Un paquete de 6 copas de vidrio, para hacer
                            tu mejor brindis</h6>
                        <h6><strong>Precio USD($): </strong>7.60</h6>
                    </div>
                    <!--Boton para saber más del producto-->
                    <div class="card-action">
                        <a href="detailProduct.php">Detalle de Producto</a>
                    </div>
                </div>
            </div>
            <!--Carta del producto-->
            <div class="card horizontal">
                <div class="card-image">
                    <!--Imagen del producto-->
                    <img class="materialboxed" src="../../resources/img/public/products/productID4.png">
                </div>
                <!--Descripción del producto-->
                <div class="card-stacked">
                    <div class="card-content">
                        <h5>Mesas Plásticas</h5>
                        <h6 align="justify"><strong>Descripción: </strong>Una mesa pláticas para 4 personas</h6>
                        <h6><strong>Precio USD($): </strong>15.99</h6>
                    </div>
                    <!--Boton para saber más del producto-->
                    <div class="card-action">
                        <a href="detailProduct.php">Detalle de Producto</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php 
    // Se llama el método de la clase para que cargue el pie de página
    publicPages::footer(null)
?>