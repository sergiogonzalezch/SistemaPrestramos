<?php
/*Inicio de la sesión de usuario, para acceso a la vista*/
ob_start();
session_start();
if(!isset($_SESSION['usuarios'])){
/*Si no existe la sesión de usuario redirigirá al login*/
	header("Location: login.html");
}else{
/*Si existe la sesión de usuario, entonces desplegara la vista*/
require_once 'superior.php';
?>
<!--Inicio de contenido-->
<div id="content">
	<section class="bg-light py-3">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-8">
					<h1 class="font-weight-bold mb-0">Tipo articulos</h1>
					<p>Pagina de registros para tipos de articulos</p>
				</div>
				<!--Botón para agregar registros mediante modal-->
				<div class="col-lg-3 col-md-4 d-flex">
					<a data-toggle="modal" href="#myModal" id="btnAdd" class="btn btn-success w-100 align-self-center"><i class="fas fa-plus-circle"></i> Agregar</a>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="container">
			<div class="row">
				<div class="card col-lg-12">
					<div id="listadoregistros" class="table-responsive bg-ligth p-3">
						<table id="tbllistado" class="table table-striped table-bordered table-hover">
							<thead>
								<th>Opciones</th>
								<th>Nombre del tipo de artículo</th>
							</thead>
							<tbody>

							</tbody>
							<tfoot>
								<th>Opciones</th>
								<th>Nombre del tipo de articulo</th>
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
			<div class="modal-header">
				<h5 class="modal-title">Llenar los campos</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="limpiar()">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<form name="formulario" id="formulario" method="POST">
					<div class="col">
						<label>Tipo de artículos (*):</label>
						<input type="hidden" name="idTipoArticulo" id="idTipoArticulo">
						<input type="text" class="form-control" name="tipoArticulo" id="tipoArticulo" maxlength="30" placeholder="Tipo artículo" required>
					</div>
				</form>
			</div>
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
<script type="text/javascript" src="scripts/tipoarticulo.js"></script>
<?php
}
ob_end_flush();
?>
