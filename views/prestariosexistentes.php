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
					<h1 class="font-weight-bold mb-0">Prestario nuevo</h1>
					<p>Registrar un solicitante nuevo desde un personal existente</p>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="container">
			<div class="row" id="formularioregistros">
				<div class="card col-lg-12 p-4">
					<form name="formulario" id="formulario" method="POST" action="prestamista.php">
						<div class=" col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Numero de empleado:</label>
							<input type="hidden" name="idClientes" id="idClientes">
							<input type="text" class="form-control" name="matricula" id="matricula" maxlength="10" placeholder="Numero del prestario" required>
						</div>
						<div class=" col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Seleccionar nombre del nuevo solicitante:</label>
							<select name="idDatosGenerales" id="idDatosGenerales" class="form-control selectpicker" data-live-search="true" required>
							</select>
						</div>
						<div class=" col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Seleccionar programa educativo:</label>
							<select name="idProgramaEducativo" id="idProgramaEducativo" class="form-control selectpicker" data-live-search="true" required>
							</select>
						</div>
						<div class=" col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Seleccionar el perfil del solicitante:</label>
							<select name="idCargo" id="idCargo" class="form-control selectpicker " data-live-search="true" required>

							</select>
						</div>
						<br>
						<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fas fa-save"></i> Guardar</button>
							<a href="prestarios.php" id="btnadd" class="btn btn-danger" onclick="limpiar()" type="button"><i class="fas fa-arrow-circle-left"></i> Regresar</a>
						</div>
					</form>
				</div>

			</div>
		</div>
	</section>
</div>

<?php
require_once 'inferior.php';
?>
<script type=" text/javascript" src="scripts/prestariosexistentes.js">
</script>
<?php
}
ob_end_flush();
?>
