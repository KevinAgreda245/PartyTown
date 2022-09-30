<?php 
    // Se incluye la clase donde se encuentra el menú y el pie de página
	include '../../core/helpers/publicPages.php';
    // Se llama el método de la clase para que cargue el encabezado y el menú
    publicPages::header('datosPT')
?>
<!--Contenedor para los datos personales-->
<div class="container">
	<form method='post' id="modificarCliente">
		<div class='row'>
			<div class="col s12 center-align">
				<i class='large material-icons'>assignment_ind</i>
			</div>
			<div class='input-field col s12 m6'>
				<i class='material-icons prefix'>account_box</i>
				<input id='nombres' type='text' name='nombres' onfocusout="validateAlphabetic('nombres',1,50)"
					class='validate' autocomplete="off" required>
				<label for='nombres' class="lang" key="nombres">Nombres</label>
				<span class="helper-text" data-error="Nombres Incorrecto" data-success="Nombres Correcto"></span>
			</div>
			<div class='input-field col s12 m6'>
				<i class='material-icons prefix'>account_box</i>
				<input id='apellidos' type='text' name='apellidos' onfocusout="validateAlphabetic('apellidos',1,50)"
					class='validate' autocomplete="off" required>
				<label for='apellidos' class="lang" key="apellidos">Apellidos</label>
				<span class="helper-text" data-error="Apellidos Incorrecto" data-success="Apellidos Correcto"></span>
			</div>
			<div class='input-field col s12 m6'>
				<i class='material-icons prefix'>assignment_ind</i>
				<select id="genero" name="genero" class='validate' required>
				</select>
				<label for="genero" class="lang" key="genero">Género</label>
				<span class="helper-text"></span>
			</div>
			<div class='input-field col s12 m6'>
				<i class='material-icons prefix'>cake</i>
				<input id="nacimiento" type="text" name="nacimiento" class="datepicker" autocomplete="off" required>
				<label for='nacimiento' class="lang" key="fecha">Fecha de Nacimiento</label>
				<span class="helper-text" data-error="Fecha de Nacimiento Incorrecto"
					data-success="Fecha de Nacimiento Correcto"></span>
			</div>
			<div class='input-field col s12 m6'>
				<i class='material-icons prefix'>email</i>
				<input id='correo' type='email' name='correo' onfocusout="validateEmail('correo')" class='validate'
					autocomplete="off" required>
				<label for='correo' class="lang" key="correo">Correo</label>
				<span class="helper-text" data-error="Correo Incorrecto" data-success="Correo Correcto"></span>
			</div>
			<div class='input-field col s12 m6'>
				<i class='material-icons prefix'>phone</i>
				<input id='telefono' type='text' name='telefono' onfocusout="validatePhone('telefono')" class='validate'
					autocomplete="off" required>
				<label for='telefono' class="lang" key="tel">Teléfono</label>
				<span class="helper-text" data-error="Teléfono Incorrecto" data-success="Teléfono Correcto"></span>
			</div>
		</div>
		<div class='row center-align'>
			<div class='col s12'>
				<button type="submit" class="btn waves-effect blue tooltipped tool" key="modificar" data-position="bottom"
					data-tooltip="Actualizar">
					<i class='material-icons'>loop</i>
				</button>
				<a class="btn waves-effect green tooltipped modal-trigger tool" key="camb" href="#cambioContraseña"
					data-position="bottom" data-tooltip="Cambio de Contraseña">
					<i class='material-icons'>security</i>
				</a>
			</div>
		</div>
	</form>
</div>
<div id="cambioContraseña" class="modal">
	<div class="modal-content">
		<h4 class="lang" key="cambio">Cambiar contraseña</h4>
		<form method="post" id="modificarContraseña">
			<div class="row center-align">
				<label class="lang" key="contraActual">CLAVE ACTUAL</label>
			</div>
			<div class="row">
				<div class="input-field col s12 m6">
					<i class="material-icons prefix">security</i>
					<input id="claveActual" type="password" name="claveActual" class="validate"
						onfocusout="validatePassword('claveActual')" required />
					<label for="claveActual" class="lang" key="contra">Clave</label>
					<span class="helper-text" data-error="Clave Incorrecto" data-success="Clave Correcto"></span>
				</div>
				<div class="input-field col s12 m6">
					<i class="material-icons prefix">security</i>
					<input id="claveActual2" type="password" name="claveActual2" class="validate"
						onfocusout="confirmPassword('claveActual2','claveActual')" required />
					<label for="claveActual2" class="lang" key="conf">Confirmar clave</label>
					<span class="helper-text" data-error="Claves no coinciden" data-success="Clave coinciden"></span>
				</div>
			</div>
			<div class="row center-align">
				<label class="lang" key="contraNueva">CLAVE NUEVA</label>
			</div>
			<div class="row">
				<div class="input-field col s12 m6">
					<i class="material-icons prefix">security</i>
					<input id="claveNueva" type="password" name="claveNueva" onfocusout="validatePassword('claveNueva')"
						class="validate" required />
					<label for="claveNueva" class="lang" key="contra">Clave</label>
					<span class="helper-text" data-error="Clave Incorrecto" data-success="Clave Correcto"></span>
				</div>
				<div class="input-field col s12 m6">
					<i class="material-icons prefix">security</i>
					<input id="claveNueva2" type="password" name="claveNueva2" class="validate"
						onfocusout="confirmPassword('claveNueva2','claveNueva')" required />
					<label for="claveNueva2" class="lang" key="conf">Confirmar clave</label>
					<span class="helper-text" data-error="Claves no coinciden" data-success="Clave coinciden"></span>
				</div>
			</div>
			<div class="row center-align">
				<a href="#" class="btn waves-effect grey tooltipped modal-close tool" key="cancelar" data-tooltip="Cancelar"><i
						class="material-icons">cancel</i></a>
				<button type="submit" class="btn waves-effect orange tooltipped tool" key="modificar" data-tooltip="Modificar"><i
						class="material-icons">loop</i></button>
			</div>
		</form>
	</div>
</div>
<?php 
    // Se llama el método de la clase para que cargue el pie de página
    publicPages::footer('user.js')
?>