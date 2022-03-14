<?php
ob_start();
session_start();
if(!isset($_SESSION['usuarios'])){
	header("Location: login.html");
}else{
require 'superior.php';
?>
<div id="content">
	<section class="bg-light py-3">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-8">
					<h1 class="font-weight-bold mb-0">Anaqueles</h1>
					<p>Página de registros de anaqueles</p>
				</div>
				<div class="col-lg-3 col-md-4 d-flex">
					<a data-toggle="modal" href="#myModal" id="btnadd" class="btn btn-success w-100 align-self-center"><i class="fas fa-plus-circle"></i> Agregar</a>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div id="listadoregistros" class="bg-ligth table-responsive p-3">
						<table id="tbllistado" class="table">
							<thead>
								<tr>
									<th>Opciones</th>
									<th>Anaquel numero</th>
									<th>Descripcion</th>
								</tr>
							</thead>
							<tbody>
								<tr></tr>
							</tbody>
							<tfoot>
								<tr>
									<th>Opciones</th>
									<th>Anaquel numero</th>
									<th>Descripcion</th>
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
			<div class="modal-header">
				<h5 class="modal-title">LLenar los campos</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="limpiar()">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<form name="formulario" id="formulario" method="POST">
					<div class="col">
						<label>Anaquel Numero:</label>
						<input type="hidden" name="idAnaquel" id="idAnaquel">
						<input type="text" class="form-control" name="anaquelNumero" id="anaquelNumero" maxlength="20" placeholder="Numero #" required>
					</div>
					<div class="col">
						<label>Descripción:</label>
						<input type="text" class="form-control" name="descripcionAnaquel" id="descripcionAnaquel" maxlength="100" placeholder="Descripción del anaquel">
					</div>
					<br>
					<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<button class="btn btn-primary" type="submit" id="btnGuardar" data-dismiss="modal" onclick="guardaryeditar()"><i class="fas fa-save"></i> Guardar</button>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="limpiar()">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<?php
require_once 'inferior.php';
?>
<script type=" text/javascript" src="scripts/anaquel.js">
</script>
<?php
}
ob_end_flush();
?>
