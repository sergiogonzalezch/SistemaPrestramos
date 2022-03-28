<?php
/*Inicio de la sesión de usuario, para acceso a la vista*/
ob_start();
session_start();
/*Si no existe la sesión de usuario redirigirá al login*/
if(!isset($_SESSION['usuarios'])){
	header("Location: login.html");
}else{
/*Si existe la sesión de usuario, entonces desplegara la vista*/
require 'superior.php';
?>
<!--Inicio de contenido-->
<div id="content">
	<!--Sección con descripción de la vista-->
	<section class="bg-light py-3">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-8">
					<h1 class="font-weight-bold mb-0">Consultas de artículos por ubicación</h1>
					<p>Vista para consultar los artículos prestados según la ubicación en que fueron usados.</p>
				</div>
			</div>
		</div>
	</section>
	<!--Sección para enlistar los registros-->
	<section>
		<div class="container">
			<div class="row">
				<div class="card col-lg-12">
					<div id="listadoregistros" class="table-responsive bg-ligth p-3">
						<!--Parametros para establecer busquedas por rango de fechas-->
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
						<!--Tabla HTML, para enlistar los registros-->
						<table id="tbllistado" class="table table-striped table-bordered table-hover">
							<thead>
								<th>Año</th>
								<th>Mes</th>
								<th>Edificio</th>
								<th>Tipo de área</th>
								<th>Descripción del área</th>
								<th>Tipo de artículo</th>
								<th>Total</th>
							</thead>
							<tbody>
							</tbody>
							<tfoot>
								<th>Año</th>
								<th>Mes</th>
								<th>Edificio</th>
								<th>Tipo de área</th>
								<th>Descripción del área</th>
								<th>Tipo de artículo</th>
								<th>Total</th>
							</tfoot>
						</table>
					</div>
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
<script type=" text/javascript" src="scripts/consultaubicaciones.js"></script>
<?php
}
ob_end_flush();
?>
