<?php
if ( strlen( session_id() ) < 1 )
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<!-- Etiquetas meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="../public/css/bootstrap.min.css">
	<!--Fuente-->
	<link href="../public/fonts/fuente.css" rel="stylesheet">
	<!--Iconos-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<!--Datatables-->
	<link rel="stylesheet" type="text/css" href="../public/datatables/datatables.min.css" />
	<link rel="stylesheet" type="text/css" href="../public/datatables/dataTables.dateTime.min.css" />
	<link rel="stylesheet" href="../public/css/bootstrap-select.min.css">
	<!--Hoja de estilos-->
	<link rel="stylesheet" href="../public/css/style.css">
</head>

<body class="bg-grey">
	<div id="wrapper" class="d-flex">
		<div id="sidebar-container" class="bg-primary">
			<div class="logo">
				<h4 class="text-ligth font-weight-bold">CheckGo</h4>
				<div class="menu">
					<a class="d-block p-3 text-ligth" href="escritorio.php"><i class="fas fa-th mr-2"></i>Escritorio</a>
					<a class="btn text-ligth" data-toggle="collapse" href="#articulos-collapse" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-archive  mr-2 "></i>Almacen</a>
					<div id="articulos-collapse" class="collapse">
						<a class="d-block p-3 text-ligth" href="articulo.php"><i class="fas fa-caret-right mr-2"></i>Artículos</a>
						<a class="d-block p-3 text-ligth" href="bajaarticulo.php"><i class="fas fa-caret-right mr-2"></i>Artículos en baja</a>
					</div>

					<a class="btn text-ligth" data-toggle="collapse" href="#personas-collapse" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-user mr-2"></i>Personas</a>
					<div id="personas-collapse" class="collapse">
						<a class="d-block p-3 text-ligth" href="prestarios.php"><i class="fas fa-caret-right mr-2"></i>Solicitantes</a>
						<?php
							if ( $_SESSION['usuarios']['rolUsuario'] == "Administrador" ) {
							echo '<a class="d-block p-3 text-ligth" href="usuarios.php">
									<i class="fas fa-caret-right mr-2"></i>Personal</a>';
							}
						?>
					</div>
					<a class="d-block p-3 text-ligth" href="prestamos.php"><i class="fas fa-tasks  mr-2"></i>Préstamos</a>
					<a class="btn text-ligth" data-toggle="collapse" href="#consultas-collapse" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-list-alt mr-2"></i>Consultas</a>
					<div id="consultas-collapse" class="collapse">
						<a class="d-block p-3 text-ligth" href="consultaubicaciones.php"><i class="fas fa-caret-right mr-2"></i>Artículos por ubicación</a>
						<a class="d-block p-3 text-ligth" href="consultaprestarios.php"><i class="fas fa-caret-right mr-2"></i>Artículos por solicitante</a>
						<a class="d-block p-3 text-ligth" href="consultadevolucion.php"><i class="fas fa-caret-right mr-2"></i>Condiciones de devolución</a>
						<a class="d-block p-3 text-ligth" href="consultaentregas.php"><i class="fas fa-caret-right mr-2"></i>Entregas</a>
						<a class="d-block p-3 text-ligth" href="consultaservicios.php"><i class="fas fa-caret-right mr-2"></i>Servicios</a>
					</div>
					<a class="btn text-ligth" data-toggle="collapse" href="#estadisticas-collapse" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-chart-bar mr-2"></i>Estadísticas</a>
					<div id="estadisticas-collapse" class="collapse">
						<a class="d-block p-3 text-ligth" href="estadisticaubicacion.php"><i class="fas fa-caret-right mr-2"></i>Total por edificio</a>
						<a class="d-block p-3 text-ligth" href="estadisticaservicios.php"><i class="fas fa-caret-right mr-2"></i>Total de servicios</a>
						<a class="d-block p-3 text-ligth" href="estadisticatotales.php"><i class="fas fa-caret-right mr-2"></i>Total anual</a>
					</div>
					<a class="btn text-ligth" data-toggle="collapse" href="#configuracion-collapse" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-cog  mr-2 "></i>Configuración</a>
					<div id="configuracion-collapse" class="collapse">
						<a class="d-block p-3 text-ligth" href="anaqueles.php"><i class="fas fa-caret-right mr-2"></i>Anaqueles</a>
						<?php
							if ( $_SESSION['usuarios']['rolUsuario'] == "Administrador" ) {
							echo '<a class="d-block p-3 text-ligth" href="cargos.php">
									<i class="fas fa-caret-right mr-2"></i>Cargos de clientes</a>';
							}
						?>
						<?php
							if ( $_SESSION['usuarios']['rolUsuario'] == "Administrador" ) {
							echo '<a class="d-block p-3 text-ligth" href="programaeducativo.php">
									<i class="fas fa-caret-right mr-2"></i>Programas educativos</a>';
							}
						?>
						<a class="d-block p-3 text-ligth" href="tipoarticulo.php"><i class="fas fa-caret-right mr-2"></i>Tipos de artículos</a>
					</div>
					<a href="#infoModal" class="d-block p-3 text-ligth" data-toggle="modal" data-target="#infoModal"><i class="fas fa-info mr-2"></i>Información</a>
				</div>
			</div>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="infoModalLabel">Informacion del sistema</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>Sistema de préstamos de equipos y accesorios para el Centro de Ingeniería Computacional (CIC) <i>CheckGo.</i>
							<br>
							<b>Versión:</b> 1.0.
							<br>
							<b>Desarrollador:</b> PP-Sergio Guadalupe González Chávez.
							<br>
							<i>Licenciatura en ingeniería en sistemas computacionales.</i>
						</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		<div class="w-100">
			<nav class="navbar navbar-expand-lg navbar-light bg-ligth border-bottom">
				<div class="container">
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav ml-auto mr-5">
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
									<img src="../files/usuarios/<?php echo $_SESSION['usuarios']['imagen']; ?>" class=" border border-secondary rounded-circle " alt="User Image" width="30px" height="30px">
									<span class="hidden-xs"><?php echo $_SESSION['usuarios']['aliasUsuario'];?></span>
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdown">
									<a href="../ajax/usuarios.php?op=salir" class="btn btn-danger btn-flat m-2"><i class="fas fa-door-open mr-2 "></i>Salir</a>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</nav>
