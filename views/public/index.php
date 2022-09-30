<?php
    // Se incluye la clase donde se encuentra el menú y el pie de página
    include '../../core/helpers/publicPages.php';
    // Se llama al método de la clase para que cargue el encabezado y el menú
    publicPages::header('inicioPT')
?>
<!-- Slider donde se publicarán imagenes de promociones o información-->
<div class="slider">
    <ul class="slides" id="sli">
    </ul>
</div>
<!--Contenedor donde se ubicarán las categorías de productos-->
<div class="container">
    <div id="group">
        <h5 id="titleCat"></h5>
        <div class="row" id="categorias">
        </div>
        <!-- Contenedor donde se ubicarán los tipos de fiestas-->
        <h5 id="titleEve"></h5>
        <div class="row" id="eventos">
        </div>
        <!--Contenedor donde se ubicarán información histórica de la tienda-->
        <div class="row">
            <div class="col s12 m6 l6">
                <!--Descripción de la Historia de Party Town-->
                <h5 class="lang" key="historia">Historia</h5>
                <blockquote align="justify" class="lang" key="historiaDet">Party Town es fundada en el año de 2019, por
                    dos
                    jóvenes emprededores que
                    quieren facilitar la compra de articulos necesarios para realizar una fiestas tantos empresariales,
                    juveniles, infantiles, boda, graduacion, entre otros eventos.
                    Ofreciendo todo en un mismo local, poniendo énfasis en una calidad consistentemente alta y precios
                    razonablemente accesibles; para poder ofrecer al cliente una experiencia agradable, ligera y sin
                    quitar
                    el enfoque de su mente en una fiesta para recordar.
                    Party Town siempre está ubicada en Av. Las Magnolias, San Salvador,cerca del Hotel Barceló.
                </blockquote>
            </div>
            <!--Google Map con la dirección de la tienda-->
            <div class="col s12 m6 l6">
                <div class="video-container">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3876.4308327923673!2d-89.23916514877762!3d13.692336476998651!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f63303aaa67cb23%3A0xac0988c5bfbf61c2!2sAv.+Las+Magnolias%2C+San+Salvador!5e0!3m2!1ses!2ssv!4v1549308338000"
                        frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
    <div id="listCategories" class="hide">
        <br>
        <a href="index.php" class='btn tooltipped tool' key="volverInicio" data-position='bottom' data-tooltip='Volver al Inicio'><i
                class="small material-icons">arrow_back</i></a>
        <h4 id="tiCategories"></h4>
        <div id="buscadorCat">

        </div>
        <div class="container" id="listCat">

        </div>
    </div>
    <div id="listEvents" class="hide">
        <br>
        <a href="index.php" class='btn tooltipped tool' key="volverInicio" data-position='bottom' data-tooltip='Volver al Inicio'><i
                class="small material-icons">arrow_back</i></a>
        <h4 id="tiEvents"></h4>
        <div id="buscadorEve">

        </div>
        <div class="container" id="listEve">

        </div>
    </div>
    <div id="detailsProduct" class="container hide">
        <br>
        <a href="index.php" class='btn tooltipped' data-position='bottom' data-tooltip='Volver al Inicio'><i
                class="small material-icons">arrow_back</i></a>
        <h4 id="titleDetails" class="lang"></h4>
        <div class="container" id="detPro">
        </div>
    </div>
</div>
<!--Modal para visualizar los comentarios del producto-->
<div id="verComentarios" class="modal">
    <div class="modal-content">
        <h4 class="lang" key="comentario">Comentarios</h4>
        <div class="row" id="comentarios">
        </div>
        <div class="row center-align">
            <a href="#" class="btn waves-effect grey tooltipped modal-close tool" key="cancelar" data-tooltip="Cancelar"><i
                    class="material-icons">cancel</i></a>
        </div>
    </div>
</div>
<!--Modal para visualizar las valoraciones del producto-->
<div id="verValoracion" class="modal">
    <div class="modal-content">
        <h4 class="lang" key="valoracion">Valoración</h4>
        <div id="promedio">
        </div>
        <div class="row center-align">
            <a href="#" class="btn waves-effect grey tooltipped modal-close tool" key="cancelar" data-tooltip="Cancelar"><i
                    class="material-icons">cancel</i></a>
        </div>
    </div>
</div>
<div id="agregarValoracion" class="modal">
    <div class="modal-content">
        <h4 class="lang" key="valoracion">Valoración</h4>
        <form method="post" id="nuevaValoracion">
            <input type="hidden" name="idProd" id="idProd">
            <div class="row">
                <div class="input-field col s12 m6 l4 offset-l4 offset-m3 black-text">
                    <select name="nuevoValoracion" id="nuevoValoracion" class='validate' required>
                        <option value="0" disable selected>Seleccione una puntuación
                        <option value="1">1.0</option>
                        <option value="2">2.0</option>
                        <option value="3">3.0</option>
                        <option value="4">4.0</option>
                        <option value="5">5.0</option>
                    </select>
                    <label for="nuevoValoracion" class="lang" key="valoracion">Valoración</label>
                    <span class="helper-text"></span>
                </div>
            </div>
            <div class="row center-align">
                <a href="#" class="btn waves-effect grey tooltipped modal-close tool" key="cancelar" data-tooltip="Cancelar"><i
                        class="material-icons">cancel</i></a>
                <button type="submit" class="btn waves-effect green tooltipped tool" key="guardar" data-tooltip="Guardar"><i
                        class="material-icons">save</i></button>
            </div>
        </form>
    </div>
</div>
<div id="agregarComentario" class="modal">
    <div class="modal-content">
        <h4 class="lang" key="comentario">Comentario</h4>
        <form method="post" id="nuevoComentario">
            <input type="hidden" name="idPro" id="idPro">
            <div class="row">
                <div class="input-field col s12 m10 offset-m1 black-text">
                    <input type="text" id="comentario" name="comentario" required>
                    <label for="comentario" class="lang" key="comentario">Comentario</label>
                    <span class="helper-text"></span>
                </div>
            </div>
            <div class="row center-align">
                <a href="#" class="btn waves-effect grey tooltipped modal-close tool" key="cancelar" data-tooltip="Cancelar"><i
                        class="material-icons">cancel</i></a>
                <button type="submit" class="btn waves-effect green tooltipped tool" key="guardar" data-tooltip="Guardar"><i
                        class="material-icons">save</i></button>
            </div>
        </form>
    </div>
</div>
<?php
    // Se llama al método de la clase para que cargue el pie de página
    publicPages::footer('index.js')
?>