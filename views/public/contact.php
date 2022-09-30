<?php
    // Se incluye la clase donde se encuentra el menú y el pie de página
    include '../../core/helpers/publicPages.php';
    // Se llama el método de la clase para que cargue el encabezado y el menú
    publicPages::header('contactenosPT')
?>
<!--Contenedor para la información de los medios de comunicación de Party Town-->
<div class="container">
    <h3 class="lang" key="contactenos">Contáctenos</h3>
    <div class="row">
        <!--Cartas paras los medios de contactos de la tienda-->
        <div class="col m6 l3">
            <!--Carta para Facebook-->
            <div class="card ">
                <div class="card-image waves-effect waves-block waves-light">
                    <img src="../../resources/img/public/media/facebook.png">
                </div>
                <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4">Facebook</span>
                    <p><a class="lang" key="siguenos" href="https://es-la.facebook.com/" target="_blank">Síguenos</a></p>
                </div>
            </div>
        </div>
        <div class="col m6 l3">
            <!--Carta para Instagram-->
            <div class="card">
                <div class="card-image waves-effect waves-block waves-light">
                    <img src="../../resources/img/public/media/instagram.png">
                </div>
                <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4">Instagram</span>
                    <p><a class="lang" key="siguenos" href="https://www.instagram.com/?hl=es-la" target="_blank">Síguenos</a></p>
                </div>
            </div>
        </div>
        <div class="col m6 l3">
            <!--Carta para Twitter-->
            <div class="card">
                <div class="card-image waves-effect waves-block waves-light">
                    <img src="../../resources/img/public/media/twitter.png">
                </div>
                <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4">Twitter</span>
                    <p><a class="lang" key="siguenos" href="https://twitter.com/?lang=es" target="_blank">Síguenos</a></p>
                </div>
            </div>
        </div>
        <div class="col m6 l3">
            <!--Carta para Correo y Teléfonos-->
            <div class="card">
                <div class="card-image waves-effect waves-block waves-light">
                    <img src="../../resources/img/public/media/mail.png">
                </div>
                <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4"><span class="lang" key="otros">Otros</span><i class="material-icons right">more_vert</i></span>
                    <br>
                </div>
                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4"><span class="lang" key="otros">Otros</span><i class="material-icons right">close</i></span>
                    <p class="lang" key="tel">Teléfonos:</p>
                    <p>7892-1232</p>
                    <p>7892-1343</p>
                    <p class="lang" key="correo">Correo Electrónico:</p>
                    <p>gerencia@partytown.com</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
    // Se llama el método de la clase para que cargue el pie de página
    publicPages::footer(null)
?>