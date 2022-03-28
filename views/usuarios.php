<?php
/*Inicio de la sesión de usuario, para acceso a la vista*/
ob_start();
session_start();
/*Si no existe la sesión de usuario redirigirá al login*/
if(!isset($_SESSION['usuarios'])){
	header("Location: login.html");
}else{
/*Si existe la sesión de usuario y es igual a Administrador, entonces desplegara la vista*/
require_once 'superior.php';
	if($_SESSION['usuarios']['rolUsuario']=="Administrador"){
?>
<div id="content">
	<!--Inicio de contenido-->
	<section class="bg-light py-3">
		<div class="container">
			<div class="row">
				<div class="col-lg-5 col-md-8">
					<h1 class="font-weight-bold mb-0">Personal</h1>
					<p>Vista para la consulta, registro y modificacion de personal del sistema.</p>
				</div>
				<!--Botón para agregar personal-->
				<div class="col-lg-3 col-md-4 d-flex">
					<button id="btnAdd" class="btn btn-success w-100 align-self-center" onclick="mostrarform(true)"><i class="fas fa-plus-circle"></i> Agregar personal nuevo</button>
				</div>
				<!--Botón para agregar personal desde un solicitante existente-->
				<div class="col-lg-3 col-md-4 d-flex">
					<?php
					//Si el rol es igual a Administrador desplegara el botón
					if ( $_SESSION['usuarios']['rolUsuario'] == "Administrador" ) {
					echo '<a id="btnNew" class="btn btn-warning w-100 align-self-center" type="buttom" href="usuariosexistente.php">
					<i class="fas fa-plus-circle"></i> Agregar desde solicitante</a>'; }?>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="container">
			<div class="row">
				<div class="card col-lg-12">
					<div id="listadoregistros" class="table-responsive bg-ligth p-3">
						<!--Tabla HTML, para enlistar los registros-->
						<table id="tbllistado" class="table table-striped table-bordered table-hover">
							<thead>
								<th>Opciones</th>
								<th>Nombre(s)</th>
								<th>Primer apellido</th>
								<th>Segundo apellido</th>
								<th>Rol</th>
								<th>Alias</th>
								<th>Correo</th>
								<th>Foto</th>
							</thead>
							<tbody>

							</tbody>
							<tfoot>
								<th>Opciones</th>
								<th>Nombre(s)</th>
								<th>Primer apellido</th>
								<th>Segundo apellido</th>
								<th>Rol</th>
								<th>Alias</th>
								<th>Correo institucional</th>
								<th>Foto</th>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
			<div class="row" id="formularioregistros">
				<div class="card col-lg-12 p-4">
					<!--Formulario-->
					<form name="formulario" id="formulario" method="POST">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Nombres (*):</label>
							<input type="hidden" name="idDatosGenerales" id="idDatosGenerales">
							<input type="text" class="form-control" name="nombres" id="nombres" maxlength="30" placeholder="Nombre(s)" required>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Primer apellido (*):</label>
							<input type="text" class="form-control" name="primerApellido" id="primerApellido" maxlength="30" placeholder="Primer apellido">
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Segundo Apellido (*):</label>
							<input type="text" class="form-control" name="segundoApellido" id="segundoApellido" maxlength="30" placeholder="Segundo apellido">
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Correo Institucional (*):</label>
							<input type="email" class="form-control" name="correoInstitucional" id="correoInstitucional" maxlength="30" placeholder="Correo institucional">
						</div>
						<div class=" col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Rol del personal (*):</label>
							<input type="hidden" name="idUsuarios" id="idUsuarios">
							<select class="form-control" name="rolUsuario" id="rolUsuario" required>
								<option class="disabled" value="">Seleccione una opción</option>
								<option value="Administrador">Administrador</option>
								<option value="Prestador">Préstador</option>
								<option value="Retirado">Retirado</option>
							</select>
						</div>
						<div class=" col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Definir un alias (*):</label>
							<input type="text" class="form-control" name="aliasUsuario" id="aliasUsuario" maxlength="25" placeholder="Alias de personal" pattern="[A-Za-z]{1,15}" required>
						</div>
						<div class=" col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Definir una contraseña (*):</label>
							<input type="password" class="form-control" name="contrasenaUsuario" id="contrasenaUsuario" maxlength="20" placeholder="Contraseña" pattern="[A-Za-z0-9]{1,30}">
						</div>
						<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Agregar una imagen:</label>
							<input type="file" class="form-control-file" name="imagen" id="imagen" accept="image/x-png,image/gif,image/jpeg">
							<input type="hidden" name="imagenActual" id="imagenActual">
							<img src="" width="150px" height="120px" id="imagenMuestra">
						</div>
						<br>
						<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<button class="btn btn-success" type="submit" id="btnGuardar"><i class="fas fa-save"></i> Guardar</button>
							<button class="btn btn-danger" onclick="cancelarform()" type="button">
								<i class="fas fa-arrow-circle-left"></i> Cancelar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</div>
<!--Fin de contenido-->
<?php
}else{
	//Si no es igual a Administrador el rol, entonces redirecciona a una vista de no acceso
	require_once 'noacceso.php';
}
/*Llamar al footer y a los scripts que requiere*/
require_once 'inferior.php';
?>
<!--Llamar al script correspondiente para las funciones de la vista-->
<script type=" text/javascript" src="scripts/usuarios.js"></script>
<?php
}
ob_end_flush();
?>
