<?php 
    // Se incluye la clase donde se encuentra el menú y el pie de página
	include '../../core/helpers/publicPages.php';
	// Se llama el método de la clase para que cargue el encabezado y el menú
    publicPages::header('preguntasPT')
?>
<!--Contenedor para las preguntas-->
<div class="container">
	<h3 class="lang" key="preguntas">Preguntas Frecuentes</h3>
	<!-- Desplegables donde se ubica cada tipo de preguntas-->
	<ul class="collapsible popout">
		<li>
			<!--Titulo de desplegable-->
			<div class="collapsible-header"><i class="material-icons">local_shipping</i><span class="lang" key="pregEnv">Preguntas sobre envío</span></div>
			<!--Las preguntas frecuentes de este tipo de preguntas sobre envío-->
			<div class="collapsible-body white">
				<h5 class="lang" key="q1">¿Cuántas cuesta el envío?</h5>
				<p class="lang" key="pq1">Dependiendo al lugar donde se irá a dejar sería el costo adicional, solamente a nivel de la zona metropolitana
					de San Salvador no se le agregaría el costo.</p>
				<h5 class="lang" key="q2">¿Cuánto se tardaría el envio?</h5>
				<p class="lang" key="pq2">El envio se tardaria de 2 a 3 dás hábiles, depende la demanda diaria de pedidos que tenemos puede ser que se
					tarde hasta 5 días. Ya pasado los 5 días y no ha recibido su pedido, por favor comunicarse con Party Town.</p>
			</div>
		</li>
		<li>
			<!--Titulo de desplegable-->
			<div class="collapsible-header"><i class="material-icons">local_phone</i><span class="lang" key="pregInc">Preguntas sobre incidencias</span></div>
			<!-- Las preguntas frecuentes de este tipo de preguntas sobre incidencias-->
			<div class="collapsible-body white">
				<h5 class="lang" key="q3">Cuentan con una atención al cliente</h5>
				<p class="lang" key="pq3">Si, Party Town cuenta con un atención al cliente en la cual pueden hacer llegar un reclamo o queja sobre
					nuestros servicios.</p>
				<h5 class="lang" key="q4">¿Se permiten devoluciones?</h5>
				<p class="lang" key="pq4">Se permitirán devoluciones siempre y cuando el porducto este dañado de fabrica o durante el traslado, pero si el
					producto esta en promoción no se permitirá devolución.</p>
				<h5 class="lang" key="q5">¿Cómo puedo contactar con Party Town?</h5>
				<p class="lang" key="pq5">Nos puede contactar por medio de Facebook, Twitter, Instagram, además por llamada teléfonica a los números:
					7892-1232 y 7892-1343, y al correo electronico gerencia@gmail.com.</p>
				<h5 class="lang" key="q6">¿Qué hago si me llega el producto dañado durante el transporte?</h5>
				<p class="lang" key="pq6">Puede al instante avisarle al repartidor, para que notifique y se le haga la devolución de su dinero o esperar
					el reenvío del producto</p>
			</div>
		</li>
		<li>
			<!--Título de desplegable-->
			<div class="collapsible-header"><i class="material-icons">store</i><span class="lang" key="pregProy">Preguntas sobre el proyecto</span></div>
			<!-- Las preguntas frecuentes de este tipo de preguntas sobre el proyecto-->
			<div class="collapsible-body white">
				<h5 class="lang" key="q7">¿Quién está detrás de la página?</h5>
				<p class="lang" key="pq7">Los fundadores de Party Town, dos jóvenes que se pueden a pensar que no existe un lugar donde no se puede
					comprar en línea todo los necesario para organizar una fiesta.</p>
				<h5 class="lang" key="q8">¿Cómo surgió la idea?</h5>
				<p class="lang" key="pq8">Viendo lo díficil y tardado que es organizar una fiesta, decidimos poner una tienda en linea para facilitarle al
					organizador, la compra de utensilios para el eventos y así ya no ir de tienda en tienda buscando sus articulos,
					sino que a la puerta de su casa los recibirá.</p>
			</div>
		</li>
		<li>
			<!--Título de desplegable-->
			<div class="collapsible-header"><i class="material-icons">shopping_basket</i><span class="lang" key="pregProd">Preguntas sobre el producto</span></div>
			<!-- Las preguntas frecuentes de este tipo de preguntas sobre el producto-->
			<div class="collapsible-body white">
				<h5 class="lang" key="q9">¿El producto es de buena calidad?</h5>
				<p class="lang" key="pq9">Claro que sí, nuestro producto son de la mejor calidad para que no tenga problemas a la hora de su evento o
					fiesta.</p>
				<h5 class="lang" key="q10">¿El producto es auténtico?</h5>
				<p class="lang" key="pq10">Todos los productos son auténticos, ningún productos es una copia.</p>
			</div>
		</li>
	</ul>
</div>
<?php 
	// Se llama el método de la clase para que cargue el pie de página
    publicPages::footer(null)
?>