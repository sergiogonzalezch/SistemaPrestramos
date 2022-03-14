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
	//
$usuariosEntrega=$consulta->estadisticoEntrega();
$aliasE="";
$totalE="";
while($registro=$usuariosEntrega->fetch_object()){
		$aliasE=$aliasE.'"'.$registro->aliasUsuario.'",';
		$totalE=$totalE.'"'.$registro->total.'",';
	}
	$aliasE=substr($aliasE,0,-1);
	$totalE=substr($totalE,0,-1);
	//
$usuariosDevolucion=$consulta->estadisticoDevolucion();
$aliasD="";
$totalD="";
while($registro=$usuariosDevolucion->fetch_object()){
		$aliasD=$aliasD.'"'.$registro->aliasUsuario.'",';
		$totalD=$totalD.'"'.$registro->total.'",';
	}
	$aliasD=substr($aliasD,0,-1);
	$totalD=substr($totalD,0,-1);
?>
<div id="content">
	<section class="bg-light py-3">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-8">
					<h1 class="font-weight-bold mb-0">Estadisticas de servicio por usuario</h1>
					<p>Pagina de estadisticas</p>
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
							<h6 class="font-weight-bold mb-0">Total entregas por personal durante el mes</h6>
						</div>
						<div class="card-body">
							<canvas id="estadistico" width="400" height="300"></canvas>
						</div>
					</div>
				</div>
				<div class="col-lg-6 my-3">
					<div class="card rounded-0">
						<div class="card-header bg-light">
							<h6 class="font-weight-bold mb-0">Total Devoluciones por personal durante el mes</h6>
						</div>
						<div class="card-body">
							<canvas id="estadistico_dos" width="400" height="300"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

</div>
<script src="../public/js/chart.js"></script>
<script>
	const ctx = document.getElementById('estadistico').getContext('2d');
	const totalEntregas = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: [<?php echo $aliasE?>],
			datasets: [{
				label: ["Entregas"],
				data: [<?php echo $totalE?>],
				backgroundColor: [
					'rgba(75, 192, 84, 0.2)'
				],
				borderColor: [
					'rgb(75, 192, 84)'
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
	const ctx2 = document.getElementById('estadistico_dos').getContext('2d');
	const totalDevoluciones = new Chart(ctx2, {
		type: 'bar',
		data: {
			labels: [<?php echo $aliasD?>],
			datasets: [{
				label: ["Devolucion"],
				data: [<?php echo $totalD?>],
				backgroundColor: [
					'rgba(192, 151, 75, 0.2)'
				],
				borderColor: [
					'rgb(192, 151, 75)'
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
