<?php
/*Inicio de la sesión de usuario, para acceso a la vista*/
ob_start();
session_start();
if(!isset($_SESSION['usuarios'])){
	/*Si no existe la sesión de usuario redirigirá al login*/
	header("Location: login.html");
}else{
/*Si existe la sesión de usuario, entonces desplegara la vista*/
require 'superior.php';
//Llamar al modelo para usar una funcion de forma directa
require_once "../models/Consulta.php";
//Crear una instancia del modelo
$consulta= new Consulta();
//Crear las variables
$aceptado=0;
$cerrado=0;
$entrega=0;
$devuelto=0;
//Mostrar consultas rapidas
//Prestamos Aceptados
  $rsptaaceptados = $consulta->prestamosEntregados();
  $registroaceptados=$rsptaaceptados->fetch_object();
  $aceptado=$registroaceptados->TotalEntregas+$aceptado;
//Prestamos Cerrados
  $rsptacerrados = $consulta->prestamosCerrados();
  $registrocerrados=$rsptacerrados->fetch_object();
  $cerrado=$registrocerrados->TotalCerrados+$cerrado;
//Prestamos entregados
  $rsptaentregados = $consulta->articulosEntregados();
  $registroentregados=$rsptaentregados->fetch_object();
  $entrega=$registroentregados->EntregasTotales+$entrega;
//Prestamos devueltos
  $rsptadevueltos = $consulta->articulosDevueltos();
  $registrodevueltos=$rsptadevueltos->fetch_object();
  $devuelto=$registrodevueltos->DevueltosTotales+$devuelto;
//Funciones para las estadisticas
//Estadístico articulos prestados en el mes
	$total=$consulta->estadisticoArticulosMes();
	$numArticulos='';
	$tipoArticulo='';
	while($registro=$total->fetch_object()){
		$numArticulos=$numArticulos.'"'.$registro->TotalPrestamos.'",';
		$tipoArticulo=$tipoArticulo.'"'.$registro->Tipo.'",';
	}
	$numArticulos=substr($numArticulos,0,-1);
	$tipoArticulo=substr($tipoArticulo,0,-1);
//Estadístico condiciones de devolucion en el mes
	$condiciones=$consulta->estadisticoCondicionDevueltoMes();
	$condicion='';
	$condicionCuenta='';
	while($registro=$condiciones->fetch_object()){
		$condicion=$condicion.'"'.$registro->CondicionDevuelto.'",';
		$condicionCuenta=$condicionCuenta.'"'.$registro->Total.'",';
	}
	$condicion=substr($condicion,0,-1);
	$condicionCuenta=substr($condicionCuenta,0,-1);
?>
<!--Inicio de contenido-->
<div id="content">
	<!--Sección 1, detalles de la vista-->
	<section class="bg-light py-3">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-8">
					<h1 class="font-weight-bold mb-0">Escritorio</h1>
					<p>Vista de página principal de datos y estadísticas rápidas.</p>
				</div>
			</div>
		</div>
	</section>
	<!--Sección 1, datos rapidos sobre los prestamos-->
	<section class="bg-mix py-3">
		<div class="container">
			<div class="card rounded-0">
				<div class="card-body">
					<div class="row">
						<div class="col-lg-3 col-md-6 d-flex stat my-3">
							<div class="mx-auto">
								<h4 class="card-title">
									<strong><?php echo $aceptado?></strong>
								</h4>
								<p class="card-text">Préstamos aceptados del día</p>
								<a href="prestamos.php" class="card-link text-success">Préstamos <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 d-flex stat my-3">
							<div class="mx-auto">
								<h4 class="card-title">
									<strong><?php echo $cerrado?></strong>
								</h4>
								<p class="card-text">Préstamos cerrados del día</p>
								<a href="prestamos.php" class="card-link text-success">Préstamos <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 d-flex stat my-3">
							<div class="mx-auto">
								<h4 class="card-title">
									<strong><?php echo $entrega?></strong>
								</h4>
								<p class="card-text">Artéculos entregados del día</p>
								<a href="prestamos.php" class="card-link text-success">Préstamos <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 d-flex my-3">
							<div class="mx-auto">
								<h4 class="card-title">
									<strong><?php echo $devuelto?></strong>
								</h4>
								<p class="card-text">Artículos devueltos del día</p>
								<a href="prestamos.php" class="card-link text-success">Préstamos <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--Sección 3, estadísticas-->
	<section>
		<div class="container">
			<div class="row">
				<!--Total de artículos préstados-->
				<div class="col-lg-6 my-3">
					<div class="card rounded-0">
						<div class="card-header bg-light">
							<h6 class="font-weight-bold mb-0">Total tipos artículos préstados durante el mes</h6>
						</div>
						<div class="card-body">
							<canvas id="totalPrestamos" width="400" height="300"></canvas>
						</div>
					</div>
				</div>
				<!--Total de condiciones de devolución-->
				<div class="col-lg-6 my-3">
					<div class="card rounded-0">
						<div class="card-header bg-light">
							<h6 class="font-weight-bold mb-0">Total condiciones de devolución en mes</h6>
						</div>
						<div class="card-body">
							<canvas id="condiciones" width="400" height="300"></canvas>
						</div>
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
<!--Llamar al script para generar las estadísticas-->
<script src="../public/js/chart.js"></script>
<!--Código JavaScript para generar la estadistisca.-->
<script>
	const ctx = document.getElementById('totalPrestamos').getContext('2d');
	const totalPrestamos = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: [<?php echo $tipoArticulo; ?>],
			datasets: [{
				label: ["Tipos de artículo"],
				data: [<?php echo $numArticulos; ?>],
				backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(153, 102, 255, 0.2)',
					'rgba(255, 159, 64, 0.2)'
				],
				borderColor: [
					'rgba(255, 99, 132, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)',
					'rgba(153, 102, 255, 1)',
					'rgba(255, 159, 64, 1)'
				],
				borderWidth: 1,
				maxBarThickness: 30
			}]
		},
		options: {
			scales: {
				y: {
					beginAtZero: true
				}
			}
		}
	});

</script>
<!--Código JavaScript para generar la estadistisca.-->
<script>
	const ctx2 = document.getElementById('condiciones').getContext('2d');
	const condicionDevolucion = new Chart(ctx2, {
		type: 'bar',
		data: {
			labels: [<?php echo $condicion ?>],
			datasets: [{
				label: "Condiciones de devolución",
				data: [<?php echo $condicionCuenta ?>],
				backgroundColor: [
					'rgba(75, 192, 84, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(255, 99, 132, 0.2)'
				],
				borderColor: [
					'rgb(75, 192, 84)',
					'rgba(255, 206, 86, 1)',
					'rgba(255, 99, 132, 1)'
				],
				borderWidth: 1,
				maxBarThickness: 30
			}]
		},
		options: {
			scales: {
				y: {
					beginAtZero: true
				}

			}
		}
	});

</script>
<?php
}
ob_end_flush();
?>
