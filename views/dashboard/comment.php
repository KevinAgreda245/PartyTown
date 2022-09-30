<?php 
    // Se incluye la clase donde se encuentra el menú y el pie de página
    include '../../core/helpers/privatePages.php';
    // Se llama el método de la clase para que cargue el encabezados
    privatePages::header("Comentarios");
?>
<div id="info-body" class="row ">
    <!--Buscador de comentario-->
    <div class="col s10">
        <form>
            <div class="input-field">
                <i class="material-icons prefix">search</i>
                <input id="search" type="search">
            </div>
        </form>
    </div>
    <div class="col s12 m12 l12">
        <!--Tabla de Comentarios-->
        <table class="responsive-table highlight">
            <thead class="black-text">
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Acciones</th>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Carlos Hernández</td>
                    <td>carlitos@gmail.com</td>
                    <td>
                        <button type='submit' name='crear' class='btn waves-effect blue modal-trigger' href="#modal1"><i
                                class='material-icons'>remove_red_eye</i></button>
                    </td>

                </tr>
            </tbody>
        </table>
        <!--Modal para visualizar el comentario que el usuario envío-->
        <div id="modal1" class="modal modal-fixed-footer white ">
            <div class="modal-content">
                <h4>Comentario Código 001</h4>
                <label>Partu Town es una maravilla</label>
            </div>
            <div class="modal-footer white center">
                <a class="modal-close orange waves-effect waves-yellow btn-small"><i
                        class="material-icons left">navigate_next</i>Cerrar</a>
            </div>
        </div>
    </div>
</div>
<!--Se llama los archivos JavaScript-->
<script src="../../resources/js/jquery-3.3.1.min.js"></script>
<script src="../../resources/js/materialize.min.js"></script>
<script src="../../resources/js/initiators.js?version=3"></script>
</body>

</html>