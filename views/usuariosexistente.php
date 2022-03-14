<?php
ob_start();
session_start();
if(!isset($_SESSION['usuarios'])){
	header("Location: login.html");
}else{
require_once 'superior.php';
	if($_SESSION['usuarios']['rolUsuario']=="Administrador"){
?>
<div id="content">
	<section class="bg-light py-3">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-8">
					<h1 class="font-weight-bold mb-0">Encargado nuevo</h1>
					<p>Registrar un encargado nuevo desde un solicitante existente</p>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="container">
			<div class="row" id="formularioregistros">
				<div class="card col-lg-12 p-4">
					<form name="formulario" id="formulario" method="POST">
						<div class=" col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Rol del Encargado(*):</label>
							<input type="hidden" name="idUsuarios" id="idUsuarios">
							<select class="form-control" name="rolUsuario" id="rolUsuario" required>
								<option value="Administrador">Administrador</option>
								<option value="Prestador">Prestador</option>
							</select>
						</div>
						<div class=" col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Seleccionar persona(*):</label>
							<select name="idDatosGenerales" id="idDatosGenerales" class="form-control selectpicker" data-live-search="true" required>
							</select>
						</div>
						<div class=" col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Definir un alias(*):</label>
							<input type="text" class="form-control" name="aliasUsuario" id="aliasUsuario" maxlength="25" placeholder="Alias usuario" pattern="[A-Za-z]{1,15}" required>
						</div>
						<div class=" col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Definir Contraseña(*):</label>
							<input type="password" class="form-control" name="contrasenaUsuario" id="contrasenaUsuario" maxlength="20" placeholder="Contraseña" pattern="[A-Za-z0-9]{1,30}">
						</div>
						<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Agregar una imagen:</label>
							<input type="file" class="form-control" name="imagen" id="imagen" accept="image/x-png,image/gif,image/jpeg">
							<input type="hidden" name="imagenactual" id="imagenactual">
							<img src="" width="150px" height="120px" id="imagenmuestra">
						</div>
						<br>
						<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fas fa-save"></i> Guardar</button>
							<a href="usuarios.php" id="btnadd" class="btn btn-danger" onclick="limpiar()" type="button"><i class="fas fa-arrow-circle-left"></i>Regresar</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</div>
<?php
}else{
	require_once 'noacceso.php';
}
require_once 'inferior.php';
?>
<script type=" text/javascript" src="scripts/usuariosexistente.js"></script>
<?php
}
ob_end_flush();
?>
