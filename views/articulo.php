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
				<div class="col-lg-9 col-md-8">
					<h1 class="font-weight-bold mb-0">Artículos</h1>
					<p>Vista para la consulta, registro y modificación de artículos del sistema.</p>
				</div>
				<!--Botón para agregar artículos-->
				<div class="col-lg-3 col-md-4 d-flex"><button id="btnAdd" class="btn btn-success w-100 align-self-center" onclick="mostrarform(true)"><i class="fas fa-plus-circle"></i> Agregar</button>
				</div>
			</div>
		</div>
	</section>
	<!--Fin de la primera sección-->
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
								<th>Tipo de artículo</th>
								<th>Etiqueta</th>
								<th>Fecha Alta</th>
								<th>Núm. Serie</th>
								<th>Descripción</th>
								<th>Estatus</th>
								<th>Condición</th>
								<th>Anaquel</th>
								<th>Código de barras</th>
								<th>Imagen</th>
							</thead>
							<tbody>
							</tbody>
							<tfoot>
								<th>Opciones</th>
								<th>Tipo de artículo</th>
								<th>Etiqueta</th>
								<th>Fecha Alta</th>
								<th>Núm. Serie</th>
								<th>Descripción</th>
								<th>Estatus</th>
								<th>Condición</th>
								<th>Anaquel</th>
								<th>Código de barras</th>
								<th>Imagen</th>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
			<!--Formulario para la creación y/o modificación de registros-->
			<div class="row" id="formularioregistros">
				<div class="col-lg-12 p-4 bg-ligth">
					<form name="formulario" id="formulario" method="POST">
						<div class="form-group row">
							<div class="col">
								<label>Etiqueta del artículo (*):</label>
								<input type="hidden" name="idArticulo" id="idArticulo">
								<input type="text" class="form-control" name="etiqueta" id="etiqueta" maxlength="30" placeholder="Etiqueta CIC" required>
							</div>
							<div class="col">
								<label>Tipo de artículo (*):</label>
								<select name="idTipoArticulo" id="idTipoArticulo" class="form-control selectpicker" data-live-search="true" required>
								</select>
							</div>
						</div>
						<div class="form-group row ">
							<div class="col">
								<label>Número de serie del artículo (*):</label>
								<input type="text" class="form-control" name="numeroSerie" id="numeroSerie" maxlength="50" placeholder="Número de serie del artículo">
							</div>
							<div class="col">
								<label>Ingresar fecha de alta (*):</label>
								<input class="form-control" type="date" name="fechaAlta" id="fechaAlta" required>
							</div>
						</div>
						<div class="form-group row">
							<div class="col">
								<label>Seleccionar la disponibilidad del artículo (*):</label>
								<select name="disponibilidadArticulos" id="disponibilidadArticulos" class="form-control selectpicker" data-live-search="true" required>
									<option class="disabled" value="">Seleccione una opción</option>
									<option value="Disponible">Disponible</option>
									<option value="NoDisponible">No disponible</option>
									<option value="Mantenimiento">Mantenimiento</option>
									<option value="Baja">Baja</option>
								</select>
							</div>
							<div class="col">
								<label for="condicionArticulo">Seleccionar la condición del artículo (*):</label>
								<select name="condicionArticulo" id="condicionArticulo" class="form-control selectpicker" required>
									<option class="disabled" value="">Seleccione una opción</option>
									<option value="Bueno">Bueno</option>
									<option value="Regular">Regular</option>
									<option value="Malo">Malo</option>
								</select>
							</div>
							<div class="col">
								<label>Seleccionar anaquel (*):</label>
								<select name="idAnaquel" id="idAnaquel" class="form-control selectpicker " data-live-search="true" required></select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col">
								<label>Descripción del artículo (*):</label>
								<textarea type="text" class="form-control" name="descripcion" id="descripcion" maxlength="256" placeholder="Descripción del articulo" rows="5" cols="10" style="resize: none;"></textarea>
							</div>
							<div class="col">
								<label>Imagen del artículo (*):</label>
								<input type="file" class="form-control-file" name="imagen" id="imagen" accept="image/x-png,image/gif,image/jpeg">
								<input type="hidden" name="imagenActual" id="imagenActual">
								<img src="" width="150px" height="120px" id="imagenMuestra">
							</div>
						</div>
						<div class="form-group row">
							<div class="col col-lg-5 col-md-5 col-sm-5 col-xs-5">
								<label>Código de barras (*):</label>
								<input type="text" class="form-control" name="codigoBarras" id="codigoBarras" required>
								<br>
								<button class="btn btn-success" type="button" onclick="generarbarcode()">Generar código</button>
								<button class="btn btn-info" type="button" onclick="imprimir()">Imprimir código</button>
								<div id="print">
									<svg id="barcode">
									</svg>
								</div>
							</div>
						</div>
						<br>
						<div class="col">
							<button class="btn btn-success" type="submit" id="btnGuardar"><i class="fas fa-save"></i> Guardar</button>
							<button id="btnCancel" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fas fa-arrow-circle-left"></i> Cancelar</button>
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
<!--Scripts para generar e imprimir el código de barras-->
<script type="text/javascript" src="../public/js/JsBarcode.all.min.js"></script>
<script type="text/javascript" src="../public/js/jquery.PrintArea.js"></script>
<!--Llamar al script correspondiente para las funciones de la vista-->
<script type=" text/javascript" src="scripts/articulos.js">
</script>
<?php
}
ob_end_flush();
?>
