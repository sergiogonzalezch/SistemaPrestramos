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
//Estadístico articulos por ubicacion
$ubicacion=$consulta->estadisticoUbicacion();
$edificio="";
$total="";
while($registro=$ubicacion->fetch_object()){
		$edificio=$edificio.'"'.$registro->edificio.'",';
		$total=$total.'"'.$registro->Total.'",';
	}
	$edificio=substr($edificio,0,-1);
	$total=substr($total,0,-1);
?>
<!--Inicio de contenido-->
<div id="content">
	<!--Sección 1, detalles de la vista-->
	<section class="bg-light py-3">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-8">
					<h1 class="font-weight-bold mb-0">Estadística de prestamos por edificio</h1>
					<p>Vista de estadística artículos entregados según el edifico donde fueron usados.</p>
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
						<h6 class="font-weight-bold mb-0">Total de uso de articulo por edificio</h6>
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
	const ubicaciones = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: [<?php echo $edificio?>],
			datasets: [{
				label: ["Total"],
				data: [<?php echo $total?>],
				backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(153, 102, 255, 0.2)',
					'rgba(255, 159, 64, 0.2)',
					'rgb(64, 255, 130, 0.2)'
				],
				borderColor: [
					'rgba(255, 99, 132, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)',
					'rgba(153, 102, 255, 1)',
					'rgba(255, 159, 64, 1)',
					'rgb(64, 255, 130, 1)'
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
require_once 'inferior.php';
?>

<?php
}
ob_end_flush();
?>
