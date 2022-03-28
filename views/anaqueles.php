<?php
/*Inicio de la sesión de usuario, para acceso a la vista*/
ob_start();
session_start();
if(!isset($_SESSION['usuarios'])){
/*Si no existe la sesión de usuario redirigirá al login*/
	header("Location: login.html");
}else{
/*Si existe la sesión de usuario, entonces desplegara la vista*/
require 'superior.php';
?>
<!--Inicio de contenido-->
<div id="content">
	<section class="bg-light py-3">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-8">
					<h1 class="font-weight-bold mb-0">Anaqueles</h1>
					<p>Vista para la consulta, registro y modificación de anaqueles del sistema.</p>
				</div>
				<!--Botón para agregar anaqueles mediante modal-->
				<div class="col-lg-3 col-md-4 d-flex">
					<a data-toggle="modal" href="#myModal" id="btnAdd" class="btn btn-success w-100 align-self-center"><i class="fas fa-plus-circle"></i> Agregar</a>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="container">
			<div class="row">
				<div class="card col-12">
					<div id="listadoregistros" class="bg-ligth table-responsive p-3">
						<!--Tabla HTML, para enlistar los registros-->
						<table id="tbllistado" class="table table-striped table-bordered table-condensed responsive table-hover">
							<thead>
								<tr>
									<th>Opciones</th>
									<th>Número de anaquel</th>
									<th>Descripción</th>
								</tr>
							</thead>
							<tbody>
								<tr></tr>
							</tbody>
							<tfoot>
								<tr>
									<th>Opciones</th>
									<th>Número de anaquel</th>
									<th>Descripción</th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!--Cabecera del modal-->
			<div class="modal-header">
				<h5 class="modal-title">Llenar los campos</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="limpiar()">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<!--Cuerpo del modal-->
			<div class="modal-body">
				<form name="formulario" id="formulario" method="POST">
					<div class="col">
						<label>Escribir el número del anaquel (*):</label>
						<input type="hidden" name="idAnaquel" id="idAnaquel">
						<input type="text" class="form-control" name="anaquelNumero" id="anaquelNumero" maxlength="20" placeholder="Número" required>
					</div>
					<div class="col">
						<label>Agregar descripción del anaquel (*):</label>
						<input type="text" class="form-control" name="descripcionAnaquel" id="descripcionAnaquel" maxlength="100" placeholder="Descripción del anaquel">
					</div>
				</form>
			</div>
			<!--Pie del modal-->
			<div class="modal-footer">
				<button class="btn btn-success" type="submit" id="btnGuardar" data-dismiss="modal" onclick="guardaryeditar()"><i class="fas fa-save"></i> Guardar</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="limpiar()"><i class="fas fa-arrow-circle-left"></i> Cancelar</button>
			</div>
		</div>
	</div>
</div>
<!--Fin de contenido-->
<?php
/*Llamar al footer y a los scripts que requiere*/
require_once 'inferior.php';
?>
<!--Llamar al script correspondiente para las funciones de la vista-->
<script type=" text/javascript" src="scripts/anaquel.js"></script>
<?php
}
ob_end_flush();
?>
