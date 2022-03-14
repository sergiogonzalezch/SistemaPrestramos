<?php
ob_start();
session_start();
if ( !isset( $_SESSION['usuarios'] ) ) {
	header( "Location: login.html" );
} else {
	require_once 'superior.php';
	?>
<div id="content">
	<section class="bg-light py-3">
		<div class="container">
			<div class="row">
				<div class="col-lg-7 col-md-8">
					<h1 class="card-title">Prestamos</h1>
					<p>Pagina de prestamos</p>
				</div>
				<div class="col-lg-2 col-md-2 m-2 d-flex">
					<button id="btnadd" class="btn btn-success w-100 align-self-center" onclick="mostrarform(true)"><i class="fas fa-plus-circle"></i> Agregar</button>
				</div>
				<div class="col-lg-2 col-md-2 m-2 d-flex">
					<a id="rptgeneral" target="_blank" type="button" name="reporte" onclick="reporte()" class="btn btn-primary w-100 align-self-center"><i class=" fas fa-arrow-circle-right"></i> Reporte</a>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="container">
			<div class="row">
				<div class="card col-lg-12">
					<div id="listadoregistros" class=" table-responsive bg-ligth p-3">
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
								<th>Opciones</th>
								<th>Folio</th>
								<th>Año</th>
								<th>Mes</th>
								<th>Dia</th>
								<th>Solicitante</th>
								<th>Edificio</th>
								<th>Area</th>
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
								<th>Dia</th>
								<th>Solicitante</th>
								<th>Edificio</th>
								<th>Area</th>
								<th>Detalle</th>
								<th>Estatus</th>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
			<div class="row" id="formularioregistros">
				<div class="card col-lg-12 p-4">
					<form name="formulario" id="formulario" method="POST">
						<div class="form-group row">
							<div class="col">
								<input class="form-control" type="hidden" name="idPrestamo" id="idPrestamo">
								<label>Seleccionar Cliente( * ):</label>
								<select name="idClientes" id="idClientes" class="form-control selectpicker " data-live-search="true" required></select>
							</div>
							<div class="col">
								<label>Edificio( * ):</label>
								<select name="edificio" id="edificio" class="form-control selectpicker" data-live-search="true" required>
									<option value="A">Edificio "A"</option>
									<option value="B">Edificio "B"</option>
									<option value="C">Edificio "C"</option>
									<option value="D">Edificio "D"</option>
									<option value="E">Edificio "E"</option>
									<option value="F">Edificio "F"</option>
								</select>
							</div>
							<div class="col">
								<label>Tipo de area:</label>
								<select name="tipoArea" id="tipoArea" class="form-control selectpicker" data-live-search="true" required>
									<option value="Aula">Aula</option>
									<option value="Sala CIC">Sala CIC</option>
									<option value="Laboratorio">Laboratorio</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
								<label>Descripción Area:</label>
								<textarea type="text" class="form-control" name="descripcionArea" id="descripcionArea" maxlength="100" placeholder="Descripción del articulo" rows="4" cols="4" style="resize: none;"></textarea>
							</div>
						</div>

						<div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
							<a data-toggle="modal" href="#myModal">
								<button id="btnAgregarArt" type="button" class="btn btn-success"> <span class="fas fa-plus"></span> Agregar Artículos</button>
							</a>
						</div>
						<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
							<table id="detalles" class="table table-hover table-borderless">
								<thead class="head">
									<th>Opciones</th>
									<th>Articulo</th>
									<th>Condicion Entrega</th>
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
							<table id="mostrar" class="table table-hover table-borderless">
							</table>
						</div>
						<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
							<table id="recibir" class="table table-hover table-borderless">
							</table>
						</div>
						<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<label id="label"><input type="checkbox" id="cbox1" value=""> Marque para entregar</label><br>
							<button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fas fa-save"></i> Guardar</button>
							<button id="btnCancel" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fas fa-arrow-circle-left"></i> Cancelar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</div>

<!------>
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Seleccionar articulo( s )</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;
					</span>
				</button>
			</div>
			<div class="modal-body table-responsive">
				<table id="tblarticulos" class="table nowrap table-hover responsive">
					<thead>

						<th scope="col"></th>
						<th scope="col">Tipo</th>
						<th scope="col">Etiqueta</th>
						<th scope="col">Condicion</th>
						<th scope="col">Anaquel</th>
						<th scope="col">Codigo</th>
					</thead>
					<tbody>
					</tbody>
					<tfoot>
					</tfoot>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!------>
<div class="modal fade" id="modalDevolucion" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">LLenar los campos</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;
					</span>
				</button>
			</div>
			<div class="modal-body table-responsive">
				<form name="formularioDevolucion" id="formularioDevolucion" action="POST">
					<input class="form-control" type="hidden" name="idAP" id="idAP">
					<input class="form-control" type="hidden" name="idA" id="idA">
					<div class="form-group row p-3">
						<label for="condicion">Condicion del articulo( * ):</label>
						<select name="condicion" id="condicion" class="form-control selectpicker" required>
							<option class="disabled" value="">Selecciones una opcion</option>
							<option value="Bueno">Bueno</option>
							<option value="Regular">Regular</option>
							<option value="Malo">Malo</option>
						</select>
						<label>Observacion devolucion( * ):</label>
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

<?php
	require_once 'inferior.php';
	?>
<!--<script type = "text/javascript" src = "../public/js/JsBarcode.all.min.js"></script>
	<script type = "text/javascript" src = "../public/js/jquery.PrintArea.js"></script>-->
<script type=" text/javascript" src="scripts/prestamos.js"></script>

<?php
}
ob_end_flush();
?>
