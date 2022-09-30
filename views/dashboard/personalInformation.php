<?php 
    // Se incluye la clase donde se encuentra el menú y el pie de página
    include '../../core/helpers/privatePages.php';
    // Se llama el método de la clase para que cargue el encabezados
    privatePages::header("Datos Personales");
?>
<div id="info-body" class="row ">
	<!--Contenedor para los datos personales-->
	<div class="container">
		<h4>Datos Personales</h4>
		<form method="post" id="modificarUsuario" enctype="multipart/form-data">
			<div class='row'>
				<div class="col s12 center-align">
					<i class='large material-icons'>assignment_ind</i>
				</div>
			</div>
			<div class="row">
				<input type="hidden" id="idUsuario" name="idUsuario" />
				<input type="hidden" id="fotoUsuario" name="fotoUsuario" />
				<div class="input-field col s12 m6 l4 black-text">
					<input id="actualizarNombre" name="actualizarNombre" type="text" class="validate"
						onfocusout="validateAlphabetic('actualizarNombre',1,50)" requiered>
					<label for="actualizarNombre">Nombre</label>
					<span class="helper-text" data-error="Nombre Incorrecto" data-success="Nombre Correcto"></span>
				</div>
				<div class="input-field col s12 m6 l4 black-text">
					<input id="actualizarApellido" name="actualizarApellido" type="text" class="validate"
						onfocusout="validateAlphabetic('actualizarApellido',1,50)" requiered>
					<label for="actualizarApellido">Apellido</label>
					<span class="helper-text" data-error="Apellido Incorrecto" data-success="Apellido Correcto"></span>
				</div>
				<div class="input-field col s12 m6 l4 black-text">
					<input id="actualizarCorreo" name="actualizarCorreo" type="text" class="validate"
						onfocusout="validateEmail('actualizarCorreo')" requiered>
					<label for="actualizarCorreo">Correo</label>
					<span class="helper-text" data-error="Correo Incorrecto" data-success="Correo Correcto"></span>
				</div>
				<div class='input-field col s12 m6 l4'>
					<input id='afechaNacimiento' type='text' name='afechaNacimiento' class='validate datepicker'
						required>
					<label for='afechaNacimiento'>Fecha de Nacimiento</label>
					<span class="helper-text" data-error="Fecha de Nacimiento Incorrecto"
						data-success="Fecha de Nacimiento Correcto"></span>
				</div>
				<div class='input-field col s12 m6 l4'>
					<input id='actualizarTelefono' type='text' name='actualizarTelefono' class='validate'
						onfocusout="validatePhone('actualizarTelefono')" required>
					<label for='actualizarTelefono'>Teléfono</label>
					<span class="helper-text" data-error="Teléfono Incorrecto" data-success="Teléfono Correcto"></span>
				</div>
				<div class="input-field col s12 m6 l4 black-text">
					<select name="actualizarTipo" id="actualizarTipo"> </select>
					<label for="type">Tipo de Usuario</label>
					<span class="helper-text"></span>
				</div>
				<div class="col s12 m6">
					<div class="file-field input-field">
						<div class="btn tooltipped" data-position="bottom" data-tooltip="Agregar Imagen">
							<span><i class="material-icons">image</i></span>
							<input id="actualizarFoto" type="file" name="actualizarFoto" accept="image/*">
						</div>
						<div class="file-path-wrapper">
							<input class="file-path" id="imagen2" name="imagen2" type="text"
								placeholder="Seleccione una imagen" onchange="validateImage('imagen2')">
							<span class="helper-text" data-error="No ha seleccionado una imagen"
								data-success="Imagen Seleccionado"></span>
						</div>
					</div>
				</div>
			</div>
			<div class="col s12 center-align">
				<button type="submit" class="btn waves-effect blue tooltipped" data-position="bottom"
					data-tooltip="Actualizar">
					<i class='material-icons'>loop</i>
				</button>
				<a class="btn waves-effect green tooltipped modal-trigger" href="#cambioContraseña"
					data-position="bottom" data-tooltip="Cambio de Contraseña">
					<i class='material-icons'>security</i>
				</a>
			</div>
		</form>
	</div>
	<div id="cambioContraseña" class="modal">
		<div class="modal-content">
			<h4>Cambiar contraseña</h4>
			<form method="post" id="modificarContraseña">
				<div class="row center-align">
					<label>CLAVE ACTUAL</label>
				</div>
				<div class="row">
					<div class="input-field col s12 m6">
						<i class="material-icons prefix">security</i>
						<input id="claveActual" type="password" name="claveActual" class="validate"
							onfocusout="validatePassword('claveActual')" required />
						<label for="claveActual">Clave</label>
						<span class="helper-text" data-error="Clave Incorrecto" data-success="Clave Correcto"></span>
					</div>
					<div class="input-field col s12 m6">
						<i class="material-icons prefix">security</i>
						<input id="claveActual2" type="password" name="claveActual2" class="validate"
							onfocusout="confirmPassword('claveActual2','claveActual')" required />
						<label for="claveActual2">Confirmar clave</label>
						<span class="helper-text" data-error="Claves no coinciden"
							data-success="Clave coinciden"></span>
					</div>
				</div>
				<div class="row center-align">
					<label>CLAVE NUEVA</label>
				</div>
				<div class="row">
					<div class="input-field col s12 m6">
						<i class="material-icons prefix">security</i>
						<input id="claveNueva" type="password" name="claveNueva"
							onfocusout="validatePassword('claveNueva')" class="validate" required />
						<label for="claveNueva">Clave</label>
						<span class="helper-text" data-error="Clave Incorrecto" data-success="Clave Correcto"></span>
					</div>
					<div class="input-field col s12 m6">
						<i class="material-icons prefix">security</i>
						<input id="claveNueva2" type="password" name="claveNueva2" class="validate"
							onfocusout="confirmPassword('claveNueva2','claveNueva')" required />
						<label for="claveNueva2">Confirmar clave</label>
						<span class="helper-text" data-error="Claves no coinciden"
							data-success="Clave coinciden"></span>
					</div>
				</div>
				<div class="row center-align">
					<a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i
							class="material-icons">cancel</i></a>
					<button type="submit" class="btn waves-effect orange tooltipped" data-tooltip="Modificar"><i
							class="material-icons">loop</i></button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php 
	privatePages::script('personalInformation.js')
?>