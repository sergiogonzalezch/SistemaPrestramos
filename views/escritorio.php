<?php
ob_start();
session_start();
if(!isset($_SESSION['usuarios'])){
	header("Location: login.html");
}else{
require 'superior.php';

require_once "../models/Consulta.php";
//Crear una instancia del modelo
$consulta= new Consulta();
$aceptado=0;
$cerrado=0;
$entrega=0;
$devuelto=0;
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
//Estadistico 1
	$total=$consulta->estadisticoArticulosMes();
	$numArticulos='';
	$tipoArticulo='';
	while($registro=$total->fetch_object()){
		$numArticulos=$numArticulos.'"'.$registro->TotalPrestamos.'",';
		$tipoArticulo=$tipoArticulo.'"'.$registro->Tipo.'",';
	}
	$numArticulos=substr($numArticulos,0,-1);
	$tipoArticulo=substr($tipoArticulo,0,-1);
// Estadistico 2
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
<div id="content">
	<section class="bg-light py-3">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-8">
					<h1 class="font-weight-bold mb-0">Escritorio</h1>
					<p>Pagina de datos y estadisticas rapidas</p>
				</div>
				<!--
					<button class="btn btn-primary w-100 align-self-center">Descargar reporte</button>
				</div>-->
			</div>
		</div>
	</section>
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
								<p class="card-text">Prestamos aceptados del dia</p>
								<a href="prestamos.php" class="card-link text-success">Prestamos <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 d-flex stat my-3">
							<div class="mx-auto">
								<h4 class="card-title">
									<strong><?php echo $cerrado?></strong>
								</h4>
								<p class="card-text">Prestamos cerrados del dia</p>
								<a href="prestamos.php" class="card-link text-success">Prestamos <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 d-flex stat my-3">
							<div class="mx-auto">
								<h4 class="card-title">
									<strong><?php echo $entrega?></strong>
								</h4>
								<p class="card-text">Articulos entregados del dia</p>
								<a href="prestamos.php" class="card-link text-success">Prestamos <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 d-flex my-3">
							<div class="mx-auto">
								<h4 class="card-title">
									<strong><?php echo $devuelto?></strong>
								</h4>
								<p class="card-text">Articulos devueltos del dia</p>
								<a href="prestamos.php" class="card-link text-success">Prestamos <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="container">
			<div class="row">
				<div class="col-lg-6 my-3">
					<div class="card rounded-0">
						<div class="card-header bg-light">
							<h6 class="font-weight-bold mb-0">Total tipos articulos prestados durante el mes</h6>
						</div>
						<div class="card-body">
							<canvas id="totalPrestamos" width="400" height="300"></canvas>
						</div>
					</div>
				</div>
				<div class="col-lg-6 my-3">
					<div class="card rounded-0">
						<div class="card-header bg-light">
							<h6 class="font-weight-bold mb-0">Total condiciones de devolucion en mes</h6>
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

<?php
require_once 'inferior.php';
?>
<!--<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>-->
<script src="../public/js/chart.js"></script>
<script>
	const ctx = document.getElementById('totalPrestamos').getContext('2d');
	const totalPrestamos = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: [<?php echo $tipoArticulo; ?>],
			datasets: [{
				label: ["Tipo articulo"],
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

<script>
	const ctx2 = document.getElementById('condiciones').getContext('2d');
	const condicionDevolucion = new Chart(ctx2, {
		type: 'bar',
		data: {
			labels: [<?php echo $condicion ?>],
			datasets: [{
				label: "Condicion",
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
