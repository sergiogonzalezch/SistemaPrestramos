<?php
ob_start();
session_start();
if(!isset($_SESSION['usuarios'])){
	header("Location: login.html");
}else{
require_once 'superior.php';
?>
<div id="content">
	<section class="bg-light py-3">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-8">
					<h1 class="font-weight-bold mb-0">Articulos en baja</h1>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="container">
			<div class="row">
				<div class="card col-lg-12">
					<div class="table-responsive bg-ligth p-3" id="listadoregistros">
						<table id="tbllistado" class="table table-striped table-bordered table-condensed responsive table-hover">
							<thead>
								<th>Opciones</th>
								<th>Fecha de Baja</th>
								<th>Observacion Baja</th>
								<th>Articulo</th>
							</thead>
							<tbody>
							</tbody>
							<tfoot>
								<th>Opciones</th>
								<th>Fecha de Baja</th>
								<th>Observacion Baja</th>
								<th>Articulo</th>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
			<div class="row" id="formularioregistros">
				<div class="card col-lg-12 p-4">
					<form name="formulario" id="formulario" method="POST">
						<div class=" col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Baja(*):</label>
							<input type="hidden" name="idBaja" id="idBaja">
						</div>
						<div class=" col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Modificar Observacion de baja:</label>
							<textarea type="text" class="form-control" name="observacionBaja" id="observacionBaja" maxlength="256" rows="8" cols="80" style="resize:none"></textarea>
						</div>
						<br>
						<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fas fa-save"></i> Guardar </button>
							<button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fas fa-arrow-circle-left"></i> Cancelar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</div>
<?php
require_once 'inferior.php';
?> <script type=" text/javascript" src="scripts/bajaarticulo.js">
</script>
<?php
}
ob_end_flush();
?>
