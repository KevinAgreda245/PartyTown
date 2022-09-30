<?php
    // Se incluye la clase donde se encuentra el menú y el pie de página
    include '../../core/helpers/publicPages.php';
    // Se llama el método de la clase para que cargue el encabezado y el menú
    publicPages::header('quienesPT')
?>
<!-- Contendor donde se ubicará información, la misión y visión de la empresa-->
<div class="container">
    <div class="row">
        <div class="col s12">
            <!--Card para ¿Quiénes Somos?-->
            <div class="card horizontal">
                <div class="card-stacked col s12">
                    <div class="card-content">
                        <h3 class="lang" key="quienes">¿Quiénes Somos?</h3>
                        <br>
                        <p align="justify" class="lang" key="quienDescr">Party Town facilita al cliente la organización
                            de una fiesta, pues todo lo que el cliente podría buscar, se encuentra en un mismo sitio.
                            Dicha empresa se enfoca en los
                            artículos no
                            comestibles para una fiesta. Party Town es una empresa comercial que compra y distribuye
                            productos de terceros, sin manufacturar productos propios. El objetivo de Party Town es
                            tener una presencia en los alrededores de la primera central de compras, identificar
                            situaciones a mejorar, reconocer patrones en las demografías de los clientes y recibir
                            retroalimentación por parte de los visitantes, personal e inversores. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6">
            <!--Card para Misión-->
            <div class="card">
                <!-- Imagen de Misión-->
                <div class="card-image">
                    <img src="../../resources/img/public/about/party2.png">
                </div>
                <!-- Texto de Misión-->
                <div class="card-content">
                    <h5 class="card-title activator grey-text text-darken-4"><span class="lang"
                            key="mision">Misión</span><i class="material-icons right">more_vert</i></h5>
                    <p align="justify" class="truncate lang" key="missionDetail">Ser la mayor cadena de distribuidoras
                        especializadas en
                        suplementos para fiestas, reuniones y eventos especiales en El Salvador; proporcionando alta
                        satisfacción, confianza y experiencia a nuestros clientes mediante el uso de artículos de la
                        mejor calidad, servicios exclusivos y una atención primaria hacia el consumidor.</p>
                </div>
                <div class="card-reveal">
                    <h5 class="card-title grey-text text-darken-4"><span class="lang" key="mision">Misión</span><i
                            class="material-icons right">close</i></h5>
                    <p align="justify" class="lang" key="missionDetail">Ser la mayor cadena de distribuidoras
                        especializadas en suplementos para
                        fiestas, reuniones y eventos especiales en El Salvador; proporcionando alta satisfacción,
                        confianza y experiencia a nuestros clientes mediante el uso de artículos de la mejor calidad,
                        servicios exclusivos y una atención primaria hacia el consumidor.</p>
                </div>
            </div>
        </div>
        <div class="col s12 m6">
            <!--Card para Visión-->
            <div class="card">
                <!-- Imagen de Visión-->
                <div class="card-image">
                    <img src="../../resources/img/public/about/party3.png">
                </div>
                <!-- Texto de Visión-->
                <div class="card-content">
                    <h5 class="card-title activator grey-text text-darken-4"><span class="lang"
                            key="vision">Visión</span><i class="material-icons right">more_vert</i></h5>
                    <p align="justify" class="truncate lang" key="visionDetail">Ser al año 2024 una corporación líder en
                        el mercado de las
                        tiendas distribuidoras de especialidad en El Salvador, con una cantidad significativa de
                        sucursales en todo el país.</p>
                </div>
                <div class="card-reveal">
                    <h5 class="card-title grey-text text-darken-4"><span class="lang" key="vision">Visión</span><i
                            class="material-icons right">close</i></h5>
                    <p align="justify" class="lang" key="visionDetail">Ser al año 2024 una corporación líder en
                        el mercado de las tiendas
                        distribuidoras de especialidad en El Salvador, con una cantidad significativa de sucursales en
                        todo el país.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    // Se llama el método de la clase para que cargue el pie de página
    publicPages::footer(null)
?>