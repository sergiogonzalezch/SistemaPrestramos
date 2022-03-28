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
//Total, de préstamos en el año
//Declarar variable
$totalA=0;
//Llamar al metodo
$rsptatotal = $consulta->totalAnual();
$registrototal=$rsptatotal->fetch_object();
$totalA=$registrototal->TotalAnual+$totalA;
//Estadístico total de préstamos durante el año por mes
$respuesta=$consulta->estadisticoTotales();
$fecha="";
$total="";
while($registro=$respuesta->fetch_object()){
		$fecha=$fecha.'"'.$registro->Fecha.'",';
		$total=$total.'"'.$registro->EntregasTotales.'",';
	}
	$fecha=substr($fecha,0,-1);
	$total=substr($total,0,-1);
?>
<!--Inicio de contenido-->
<div id="content">
	<!--Sección 1, detalles de la vista-->
	<section class="bg-light py-3">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-8">
					<h1 class="font-weight-bold mb-0">Estadístico total anual</h1>
					<p>Vista de estadística del total de préstamos realizados durante los doce meses del año.</p>
				</div>
				<!--Div con la sumatoria del total de préstamos-->
				<div class="col-lg-3 col-md-3 d-flex stat my-3">
					<div class="mx-auto">
						<h4 class="card-title">
							<strong><?php echo $totalA?></strong>
						</h4>
						<p class="card-text">Préstamos atendidos del año</p>
						<a href="prestamos.php" class="card-link text-success">Préstamos <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--Sección 2, estadísticas-->
	<section>
		<div class="container d-flex justify-content-center">
			<div class="col-lg-11 col-md-7 block-center m-3 ">
				<div class="card rounded-0">
					<div class="card-header bg-light">
						<h6 class="font-weight-bold mb-0">Total de prestamos por 12 meses</h6>
					</div>
					<div class="card-body">
						<canvas id="estadistico" width="800" height="500"></canvas>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--Fin de contenido-->
<!--Llamar al script para generar las estadísticas-->
<script src="../public/js/chart.js"></script>
<!--Código JavaScript para generar la estadistisca.-->
<script>
	const ctx = document.getElementById('estadistico').getContext('2d');
	const prestamos = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: [<?php echo $fecha?>],
			datasets: [{
				label: ["Total"],
				data: [<?php echo $total?>],
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
<?php
//Llamar al footer y a los scripts que requiere
require_once 'inferior.php';}
ob_end_flush();
?>
