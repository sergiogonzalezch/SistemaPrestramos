<?php
/*Inicio de la sesión de usuario, para acceso a la vista*/
ob_start();
session_start();
/*Si no existe la sesión de usuario redirigirá al login*/
if(!isset($_SESSION['usuarios'])){
	header("Location: login.html");
}else{
/*Si existe la sesión de usuario, entonces desplegara la vista*/
require_once 'superior.php';
?>
<!--Inicio de contenido-->
<div id="content">
	<!--Sección con descripción de la vista-->
	<section class="bg-light py-3">
		<div class="container">
			<div class="row">
				<div class="col-lg-5 col-md-8">
					<h1 class="font-weight-bold mb-0">Solicitantes</h1>
					<p>Vista para la consulta, registro y modificacion de solicitantes.</p>
				</div>
				<!--Botón para agregar solicitantes desde cero-->
				<div class="col-lg-3 col-md-4 d-flex">
					<button id="btnAdd" class="btn btn-success w-100 align-self-center" onclick="mostrarform(true)"><i class="fas fa-plus-circle"></i> Agregar solicitante nuevo</button>
				</div>
				<!--Botón para agregar solicitantes desde un registro de usuario existente-->
				<div class="col-lg-3 col-md-4 d-flex">
					<a href="prestariosexistentes.php" id="btnNew" class="btn btn-warning w-100 align-self-center"><i class="fas fa-plus-circle"></i> Agregar desde personal</a>;
				</div>
			</div>
		</div>
	</section>
	<section>
		<!--Sección para enlistar los registros y despliegue del formulario-->
		<div class="container">
			<div class="row">
				<div class="card col-lg-12">
					<div id="listadoregistros" class="table-responsive bg-ligth p-3">
						<!--Tabla HTML, para enlistar los registros-->
						<table id="tbllistado" class="table table-striped table-bordered table-hover">
							<thead>
								<th>Opciones</th>
								<th>Nombres</th>
								<th>Primer apellido</th>
								<th>Segundo apellido</th>
								<th>Núm. de empleado</th>
								<th>Correo institucional</th>
								<th>Programa educativo</th>
								<th>Perfil</th>
							</thead>
							<tbody>
							</tbody>
							<tfoot>
								<th>Opciones</th>
								<th>Nombres</th>
								<th>Primer apellido</th>
								<th>Segundo apellido</th>
								<th>Núm. de empleado</th>
								<th>Correo institucional</th>
								<th>Programa educativo</th>
								<th>Perfil</th>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
			<!--Formulario para la creación y/o modificación de registros-->
			<div class="row" id="formularioregistros">
				<div class="card col-lg-12 p-4">
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
							<label>Segundo apellido (*):</label>
							<input type="text" class="form-control" name="segundoApellido" id="segundoApellido" maxlength="30" placeholder="Segundo apellido">
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Correo institucional (*):</label>
							<input type="email" class="form-control" name="correoInstitucional" id="correoInstitucional" maxlength="30" placeholder="Correo institucional">
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Número de empleado (*):</label>
							<input type="hidden" name="idClientes" id="idClientes">
							<input type="text" class="form-control" name="matricula" id="matricula" maxlength="10" placeholder="Número de empleado" required>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Seleccionar programa educativo (*):</label>
							<select name="idProgramaEducativo" id="idProgramaEducativo" class="form-control selectpicker" data-live-search="true" required></select>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Seleccionar el perfil del solicitante (*):</label>
							<select name="idCargo" id="idCargo" class="form-control selectpicker " data-live-search="true" required></select>
						</div>
						<br>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<button class="btn btn-success" type="submit" id="btnGuardar"><i class="fas fa-save"></i> Guardar</button>
							<button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fas fa-arrow-circle-left"></i> Cancelar</button>
						</div>
					</form>

				</div>
			</div>
		</div>
	</section>
</div>
<!--Fin de contenido-->
<?php
/*Llamar al footer y a los scripts que requiere*/
require_once 'inferior.php';
?>
<!--Llamar al script correspondiente para las funciones de la vista-->
<script type=" text/javascript" src="scripts/prestarios.js"></script>
<?php
}
ob_end_flush();
?>
