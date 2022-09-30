<?php 
    // Se incluye la clase donde se encuentra el menú y el pie de página
    include '../../core/helpers/privatePages.php';
    // Se llama el método de la clase para que cargue el encabezado
    privatePages::header("Main");
    // Se llama el método de la clase para que cargue el menú
?>
<div id="info-body">
    <div class="row center-align" id="preloader">
        <div class="preloader-wrapper big active">
            <div class="spinner-layer spinner-green-only center-align">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>
    <!--Contnedor para la información y gráficas-->
    <div class="hide" id="main">
        <div class="container">
            <div class="row">
                <div class="col s10 offset-s1 m6 center-align">
                    <div style="padding: 25px;" class="card amber accent-4">
                        <div class="row">
                            <div class="card-title">
                                <b class="white-text">Tipo de producto más vendido</b>
                            </div>
                        </div>
                        <div class="row">
                            <h5 class="white-text" id="typeProduct"></h5>
                        </div>
                    </div>
                </div>
                <div class="col s10 offset-s1 m6 center-align">
                    <div style="padding: 25px;" class="card amber accent-4">
                        <div class="row">
                            <div class="card-title">
                                <b class="white-text">Tipo de evento más frecuentado</b>
                            </div>
                        </div>
                        <div class="row">
                            <h5 class="white-text" id="typeEvent"></h5>
                        </div>
                    </div>
                </div>
                <div class="col s10 offset-s1 m6 center-align">
                    <div style="padding: 25px;" class="card amber accent-4">
                        <div class="row">
                            <div class="card-title">
                                <b class="white-text">Artículo individual más vendido</b>
                            </div>
                        </div>
                        <div class="row">
                            <h5 class="white-text" id="mostProduct"></h5>
                        </div>
                    </div>
                </div>
                <div class="col s10 offset-s1 m6 center-align">
                    <div style="padding: 25px;" class="card amber accent-4">
                        <div class="row">
                            <div class="card-title">
                                <b class="white-text">Ganancias netas<br>USD($)</b>
                            </div>
                        </div>
                        <div class="row">
                            <h5 class="white-text" id="winnings"></h5>
                        </div>
                    </div>
                </div>
                <div class="col s10 offset-s1 m6 center-align">
                    <div style="padding: 25px;" class="card amber accent-4">
                        <div class="row">
                            <div class="card-title">
                                <b class="white-text">Producto más vendidos</b>
                            </div>
                        </div>
                        <div class="row" id="mostProducts">
                        </div>
                    </div>
                </div>
                <div class="col s10 offset-s1 m6 center-align">
                    <div style="padding: 25px;" class="card amber accent-4">
                        <div class="row">
                            <div class="card-title">
                                <b class="white-text">Producto menos vendidos</b>
                            </div>
                        </div>
                        <div class="row" id="lessProducts">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Inicios de las Gráficas-->
        <div class="row">
            <!-- Gráficas de Barra-->
            <div class="container">
                <div class="col s12 m12 l12 z-depth-2" style="margin-top: 70px;">
                    <canvas id="sales-chart" style="height: 450px;"></canvas>
                    <h3 id="errorsales-chart" class="hide center red-text"></h3>
                </div>
            </div>
            <!--Gráficas de Barra-->
            <div class="container">
                <div class="col s12 m12 l12 z-depth-2" style="margin-top: 70px">
                    <canvas id="ventasMes" style="height: 450px;"></canvas>
                    <h3 id="errorventasMes" class="hide center red-text"></h3>
                </div>
            </div>
            <!-- Gráficas de Barra-->
            <div class="container">
                <div class="col s12 m12 l12 z-depth-2" style="margin-top: 70px;">
                    <canvas id="cantTypeProd" style="height: 450px;"></canvas>
                    <h3 id="errorTypeProd" class="hide center red-text"></h3>
                </div>
            </div>

            <div class="container">
                <div class="col s12 m12 l12 z-depth-2" style="margin-top: 70px;">
                    <canvas id="cantTypeEvent" style="height: 450px;"></canvas>
                    <h3 id="errorTypeEvent" class="hide center red-text"></h3>
                </div>
            </div>
            <div class="container">
                <div class="col s12 m12 l12 z-depth-2" style="margin-top: 70px;">
                    <canvas id="monthSales" style="height: 450px;"></canvas>
                    <h3 id="errormonthSales" class="hide center red-text"></h3>
                </div>
            </div>
            <div class="container">
                <div class="col s12 m12 l12 z-depth-2" style="margin-top: 70px;">
                    <canvas id="monthSales2" style="height: 450px;"></canvas>
                    <h3 id="errormonthSales2" class="hide center red-text"></h3>
                </div>
            </div>
        </div>
        <!--Fin de las Gráficas-->
    </div>
</div>
<?php 
     privatePages::script('main.js');
?>