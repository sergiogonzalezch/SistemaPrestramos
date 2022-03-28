<?php
/*Inicio de la sesión de usuario, para acceso a la vista*/
ob_start();
session_start();
/*Si no existe la sesión de usuario redirigirá al login*/
if ( !isset( $_SESSION['usuarios'] ) ) {
	header( "Location: login.html" );
} else {
	/*Si existe la sesión de usuario, entonces desplegara la vista*/
	require_once 'superior.php';
	?>
<!--Inicio de contenido-->
<div id="content">
	<!--Sección con descripción de la vista-->
	<section class="bg-light py-3">
		<div class="container">
			<div class="row">
				<div class="col-lg-7 col-md-8">
					<h1 class="card-title">Préstamos</h1>
					<p>Vista para la consulta, registro y cierre de préstamos.</p>
				</div>
				<!--Botón para agregar artículos-->
				<div class="col-lg-2 col-md-2 m-2 d-flex">
					<button id="btnAdd" class="btn btn-success w-100 align-self-center" onclick="mostrarform(true)"><i class="fas fa-plus-circle"></i> Agregar</button>
				</div>
				<!--Botón para crear reporte de los registros en formato pdf-->
				<div class="col-lg-2 col-md-2 m-2 d-flex">
					<a id="rptgeneral" target="_blank" type="button" name="reporte" onclick="reporte()" class="btn btn-info w-100 align-self-center"><i class=" fas fa-arrow-circle-right"></i> Reporte</a>
				</div>
			</div>
		</div>
	</section>
	<!--Sección para enlistar los registros y despliegue del formulario-->
	<section>
		<div class="container">
			<div class="row">
				<div class="card col-lg-12">
					<div id="listadoregistros" class=" table-responsive bg-ligth p-3">
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
								<th>Opciones</th>
								<th>Folio</th>
								<th>Año</th>
								<th>Mes</th>
								<th>Día</th>
								<th>Solicitante</th>
								<th>Edificio</th>
								<th>Área</th>
								<th>Detalle</th>
								<th>Estatus</th>
							</thead>
							<tbody>
							</tbody>
							<tfoot>
								<th>Opciones</th>
								<th>Folio</th>
								<th>Año</th>
								<th>Mes</th>
								<th>Día</th>
								<th>Solicitante</th>
								<th>Edificio</th>
								<th>Área</th>
								<th>Detalle</th>
								<th>Estatus</th>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
			<!--Formulario para la creación y/o modificación de registros-->
			<div class="row" id="formularioregistros">
				<div class="card col-lg-12 p-4">
					<form name="formulario" id="formulario" method="POST">
						<div class="form-group row">
							<div class="col">
								<input class="form-control" type="hidden" name="idPrestamo" id="idPrestamo">
								<label>Seleccionar solicitante (*):</label>
								<select name="idClientes" id="idClientes" class="form-control selectpicker " data-live-search="true" required></select>
							</div>
							<div class="col">
								<label>Edificio (*):</label>
								<select name="edificio" id="edificio" class="form-control selectpicker" data-live-search="true" required>
									<option class="disabled" value="">Seleccione una opción</option>
									<option value="A">Edificio "A"</option>
									<option value="B">Edificio "B"</option>
									<option value="C">Edificio "C"</option>
									<option value="D">Edificio "D"</option>
									<option value="E">Edificio "E"</option>
									<option value="F">Edificio "F"</option>
								</select>
							</div>
							<div class="col">
								<label>Tipo de área (*):</label>
								<select name="tipoArea" id="tipoArea" class="form-control selectpicker" data-live-search="true" required>
									<option class="disabled" value="">Seleccione una opción</option>
									<option value="Aula">Aula</option>
									<option value="Sala CIC">Sala CIC</option>
									<option value="Laboratorio">Laboratorio</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
								<label>Descripción del área (*):</label>
								<textarea type="text" class="form-control" name="descripcionArea" id="descripcionArea" maxlength="100" placeholder="Descripción del área" rows="4" cols="4" style="resize: none;"></textarea>
							</div>
						</div>
						<!--Formulario para agregar los artículos-->
						<div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
							<!--Botón para llamar al modal para agregar artículos-->
							<a data-toggle="modal" href="#myModal">
								<button id="btnAgregarArt" type="button" class="btn btn-success"> <span class="fas fa-plus"></span> Agregar artículos</button>
							</a>
						</div>

						<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
							<!--Tabla para enlistar los articulos a prestar en el registro-->
							<table id="detalles" class="table table-hover table-borderless">
								<thead class="head">
									<th>Opciones</th>
									<th>Artículo</th>
									<th>Condición de entrega</th>
								</thead>
								<tbody>
								</tbody>
								<tfoot>
									<th></th>
									<th></th>
									<th></th>
								</tfoot>
							</table>
						</div>
						<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
							<!--Tabla para visualizar todos los datos de entrega y devolución del artículo-->
							<table id="mostrar" class="table table-hover table-borderless">
							</table>
						</div>
						<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
							<!--Tabla para agregar los detalles de devolución del artículo-->
							<table id="recibir" class="table table-hover table-borderless">
							</table>
						</div>
						<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<!--Checkbox para visualizar el botón de guardar, al realizar un cierre de préstamo-->
							<label id="label"><input type="checkbox" id="cbox1" value=""> Marque para cerrar el prestamo</label><br>
							<button class="btn btn-success" type="submit" id="btnGuardar"><i class="fas fa-save"></i> Guardar</button>
							<button id="btnCancel" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fas fa-arrow-circle-left"></i> Cancelar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</div>
<!--Modal para visualizar los artículos a préstar, que esten disponibles-->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Seleccionar artículo(s)</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body table-responsive">
				<table id="tblarticulos" class="table nowrap table-hover responsive">
					<thead>
						<th scope="col"></th>
						<th scope="col">Tipo</th>
						<th scope="col">Etiqueta</th>
						<th scope="col">Condición</th>
						<th scope="col">Anaquel</th>
						<th scope="col">Código</th>
					</thead>
					<tbody></tbody>
					<tfoot></tfoot>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!--Modal para registrar los datos de devolución de los artículos-->
<div class="modal fade" id="modalDevolucion" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Llenar los campos</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body table-responsive">
				<form name="formularioDevolucion" id="formularioDevolucion" action="POST">
					<input class="form-control" type="hidden" name="idAP" id="idAP">
					<input class="form-control" type="hidden" name="idA" id="idA">
					<div class="form-group row p-3">
						<label for="condicion">Condición del artículo (*):</label>
						<select name="condicion" id="condicion" class="form-control selectpicker" required>
							<option class="disabled" value="">Seleccionar una opción</option>
							<option value="Bueno">Bueno</option>
							<option value="Regular">Regular</option>
							<option value="Malo">Malo</option>
						</select>
						<label>Observación devolución (*):</label>
						<textarea type="text" class="form-control" name="observacion" id="observacion" maxlength="256" rows="5" cols="10" style="resize: none;" required></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button id="btnActualizar" type="submit" class="btn btn-success" data-dismiss="modal" onclick="devolver()"><i class="fas fa-check"></i>Actualizar</button>
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
<script type=" text/javascript" src="scripts/prestamos.js"></script>
<?php
}
ob_end_flush();
?>
