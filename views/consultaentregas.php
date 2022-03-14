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
					<h1 class="font-weight-bold mb-0">Articulos entregados</h1>
					<p>Consulta de articulos entregados por tipo de articulo</p>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="container">
			<div class="row">
				<div class=" card col-lg-12">
					<div class="table-responsive bg-ligth p-3" id="listadoregistros">
						<div class="row">
							<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-4">
								<label>Fecha Inicio</label>
								<input type="date" class="form-control" name="fechaInicio" id="fechaInicio" value="<?php echo
							   date("Y-m-d"); ?>">
							</div>
							<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-4">
								<label>Fecha Fin</label>
								<input type="date" class="form-control" name="fechaFin" id="fechaFin" value="<?php echo
								date("Y-m-d"); ?>">
							</div>
						</div>
						<table id="tbllistado" class="table table-striped table-bordered table-hover">
							<thead>
								<th>Año</th>
								<th>Mes</th>
								<th>Dia</th>
								<th>Tipo de Articulo</th>
								<th>Numero de Articulos Entregados</th>
							</thead>
							<tbody>

							</tbody>
							<tfoot>
								<th>Año</th>
								<th>Mes</th>
								<th>Dia</th>
								<th>Tipo de Articulo</th>
								<th>Numero de Articulos Entregados</th>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<?php
require_once 'inferior.php';
?>
<script type=" text/javascript" src="scripts/consultaentregas.js">
</script>
<?php
}
ob_end_flush();
?>
