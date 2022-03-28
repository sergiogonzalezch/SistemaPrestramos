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
//Estadístico servicio de entregas
$usuariosEntrega=$consulta->estadisticoEntrega();
$aliasE="";
$totalE="";
while($registro=$usuariosEntrega->fetch_object()){
		$aliasE=$aliasE.'"'.$registro->aliasUsuario.'",';
		$totalE=$totalE.'"'.$registro->total.'",';
	}
	$aliasE=substr($aliasE,0,-1);
	$totalE=substr($totalE,0,-1);
//Estadístico servicio de devolución
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
<!--Inicio de contenido-->
<div id="content">
	<section class="bg-light py-3">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-8">
					<h1 class="font-weight-bold mb-0">Estadísticas de servicios realizados</h1>
					<p>Vista de servicio de entrega y devolución de artículos por personal durante el mes.</p>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="container">
			<div class="row">
				<!--Total de artículos en servicio de entrega por personal-->
				<div class="col-lg-6 my-3">
					<div class="card rounded-0">
						<div class="card-header bg-light">
							<h6 class="font-weight-bold mb-0">Total, de artículos entregados por personal</h6>
						</div>
						<div class="card-body">
							<canvas id="estadistico" width="400" height="300"></canvas>
						</div>
					</div>
				</div>
				<div class="col-lg-6 my-3">
					<div class="card rounded-0">
						<div class="card-header bg-light">
							<h6 class="font-weight-bold mb-0">Total, de devoluciones atendidas por personal</h6>
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
<!--Fin de contenido-->
<!--Llamar al script para generar las estadísticas-->
<script src="../public/js/chart.js"></script>
<!--Código JavaScript para generar la estadistisca.-->
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
					'rgba(59, 83, 160, 0.2)'
				],
				borderColor: [
					'rgb(59, 83, 160)'
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
<!--CódigoJavaScript para generar la estadistisca.-->
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
					'rgba(237, 171, 48, 0.2)'
				],
				borderColor: [
					'rgb(237, 171, 48)'
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
/*Llamar al footer y a los scripts que requiere*/
require_once 'inferior.php'; }
ob_end_flush();
?>
