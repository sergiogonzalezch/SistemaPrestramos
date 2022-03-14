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
					<h1 class="font-weight-bold mb-0">Articulos </h1>
					<p>Página de registros de articulos</p>
				</div>
				<div class="col-lg-3 col-md-4 d-flex"><button id="btnadd" class="btn btn-success w-100 align-self-center" onclick="mostrarform(true)"><i class="fas fa-plus-circle"></i> Agregar</button>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="container">
			<div class="row">
				<div class="card col-lg-12">
					<div id="listadoregistros" class=" table-responsive bg-ligth p-3">
						<table id="tbllistado" class="table table-striped table-bordered table-hover">
							<thead>
								<th>Opciones</th>
								<th>Tipo articulo</th>
								<th>Etiqueta</th>
								<th>Fecha Alta</th>
								<th>Num. Serie</th>
								<th>Descripcion</th>
								<th>Estatus</th>
								<th>Condicion</th>
								<th>Anaquel</th>
								<th>Codigo de barras</th>
								<th>Imagen</th>
							</thead>
							<tbody>
							</tbody>
							<tfoot>
								<th>Opciones</th>
								<th>Tipo articulo</th>
								<th>Etiqueta</th>
								<th>Fecha Alta</th>
								<th>Num. Serie</th>
								<th>Descripcion</th>
								<th>Estatus</th>
								<th>Condicion</th>
								<th>Anaquel</th>
								<th>Codigo de barras</th>
								<th>Imagen</th>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
			<div class="row" id="formularioregistros">
				<div class="col-lg-12 p-4 bg-ligth">
					<form name="formulario" id="formulario" method="POST">
						<div class="form-group row">
							<div class=" col ">
								<label>Articulo(*):</label>
								<input type="hidden" name="idArticulo" id="idArticulo">
								<input type="text" class="form-control" name="etiqueta" id="etiqueta" maxlength="30" placeholder="etiqueta CIC" required>
							</div>
							<div class=" col ">
								<label>Tipo articulo(*):</label>
								<select name="idTipoArticulo" id="idTipoArticulo" class="form-control selectpicker" data-live-search="true" required>
								</select>
							</div>
						</div>
						<div class="form-group row ">
							<div class="col">
								<label>Numero de serie del articulo(*):</label>
								<input type="text" class="form-control" name="numeroSerie" id="numeroSerie" maxlength="50" placeholder="Num de serie del articulo">
							</div>
							<div class="col">
								<label>Fecha de Alta(*):</label>
								<input class="form-control" type="date" name="fechaAlta" id="fechaAlta" required>
							</div>
						</div>
						<div class="form-group row">
							<div class="col">
								<label>Seleccionar disponibilidad del articulo(*):</label>
								<select name="disponibilidadArticulos" id="disponibilidadArticulos" class="form-control selectpicker" data-live-search="true" required>
									<option value="Disponible">Disponible</option>
									<option value="NoDisponible">No disponible</option>
									<option value="Mantenimiento">Mantenimiento</option>
									<option value="Baja">Baja</option>
								</select>
							</div>
							<div class="col">
								<label for="condicionArticulo">Condicion del articulo(*):</label>
								<select name="condicionArticulo" id="condicionArticulo" class="form-control selectpicker" required>
									<option value="Bueno">Bueno</option>
									<option value="Regular">Regular</option>
									<option value="Malo">Malo</option>
								</select>
							</div>
							<div class="col ">
								<label>Seleccionar anaquel donde se almacena(*):</label>
								<select name="idAnaquel" id="idAnaquel" class="form-control selectpicker " data-live-search="true" required></select>
							</div>
						</div>

						<div class="form-group row">
							<div class="col">
								<label>Descripción del articulo(*):</label>
								<textarea type="text" class="form-control" name="descripcion" id="descripcion" maxlength="256" placeholder="Descripción del articulo" rows="5" cols="10" style="resize: none;"></textarea>
							</div>
							<div class="col">
								<label>Imagen del articulo(*):</label>
								<input type="file" class="form-control" name="imagen" id="imagen" accept="image/x-png,image/gif,image/jpeg">
								<input type="hidden" name="imagenactual" id="imagenactual">
								<img src="" width="150px" height="120px" id="imagenmuestra">
							</div>
						</div>
						<div class="form-group row">
							<div class="col col-lg-5 col-md-5 col-sm-5 col-xs-5">
								<label>Codigo de barras(*):</label>
								<input type="text" class="form-control" name="codigoBarras" id="codigoBarras" required>
								<button class="btn btn-success" type="button" onclick="generarbarcode()">Generar codigo</button>
								<button class="btn btn-info" type="button" onclick="imprimir()">Imprimir codigo</button>
								<div id="print">
									<svg id="barcode">

									</svg>
								</div>
							</div>
						</div>
						<br>
						<div class="col">
							<button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fas fa-save"></i> Guardar</button>
							<button id="btnCancel" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fas fa-arrow-circle-left"></i> Cancelar</button>
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
<script type="text/javascript" src="../public/js/JsBarcode.all.min.js"></script>
<script type="text/javascript" src="../public/js/jquery.PrintArea.js"></script>
<script type=" text/javascript" src="scripts/articulos.js">
</script>
<?php
}
ob_end_flush();
?>
