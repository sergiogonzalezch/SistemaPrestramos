<?php
ob_start();
if (strlen(session_id()) < 1)
  session_start();
if(!isset($_SESSION['usuarios'])){
	echo "Debe ingresar correctamente ";
}else{

	if($_SESSION['usuarios']['rolUsuario']=="Administrador"){

		if(strlen($_GET['fechaInicio'])>0 and strlen($_GET['fechaFin'])>0){
			$fechaInicio=$_GET['fechaInicio'];
			$fechaFin=$_GET['fechaFin'];
			$varFechaInicio =date('Y-m-d',strtotime($fechaInicio));
			$varFechaFin =date('Y-m-d',strtotime($fechaFin));
		}else{
			$fechaInicio='1111-01-01';
			$fechaFin='9999-12-30';
			$varFechaInicio ='----|--|--';
			$varFechaFin='----|--|--';
		}

require('PDF_MC_Table.php');
//Instanciamos la clase para generar el documento pdf
$pdf=new PDF_MC_Table();
//Agregamos la primera página al documento pdf
$pdf->AddPage();

//Seteamos el inicio del margen superior en 25 pixeles
$y_axis_initial = 25;

//Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
$pdf->SetFont('Arial','B',12);

$pdf->Cell(40,6,'',0,0,'C');
$pdf->Cell(200,6,'PRESTAMOS REALIZADOS',1,0,'C');
$pdf->Ln(10);
$pdf->Cell(100,10,'Desde:'.$varFechaInicio.' hasta '.$varFechaFin,0);
$pdf->Image('img/Imagen1.jpg',20,5,15,15,'JPG');
$pdf->Image('img/Imagen2.jpg',260,5,18,18,'JPG');
$pdf->Ln(10);

//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(232,232,232);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(15,6,utf8_decode('Folio'),1,0,'C',1);
$pdf->Cell(10,6,utf8_decode('Año'),1,0,'C',1);
$pdf->Cell(10,6,utf8_decode('Mes'),1,0,'C',1);
$pdf->Cell(10,6,utf8_decode('Día'),1,0,'C',1);
$pdf->Cell(20,6,utf8_decode('Solicitante'),1,0,'C',1);
$pdf->Cell(30,6,utf8_decode('Nombre'),1,0,'C',1);
$pdf->Cell(30,6,utf8_decode('Primer Apellido'),1,0,'C',1);
$pdf->Cell(32,6,utf8_decode('Segundo Apellido'),1,0,'C',1);
$pdf->Cell(15,6,utf8_decode('Edificio'),1,0,'C',1);
$pdf->Cell(25,6,utf8_decode('Tipo de Area'),1,0,'C',1);
$pdf->Cell(35,6,utf8_decode('Area'),1,0,'C',1);
$pdf->Cell(20,6,utf8_decode('Estatus'),1,0,'C',1);
$pdf->Cell(20,6,utf8_decode('No.Items'),1,0,'C',1);
$pdf->Ln(10);

require_once"../models/Consulta.php";

$consulta = new Consulta();
//$fechaInicio = $_GET["fechaInicio"];
//$fechaFin = $_GET["fechaFin"];
$respuesta = $consulta->reporte($varFechaInicio,$varFechaFin);
$pdf->SetWidths(array(15,10,10,10,20,30,30,32,15,25,35,20,20));


while($registro= $respuesta->fetch_object())
{
	$numFolio = $registro->NumFolio;
	$fecha = $registro->Año;
	$mes = $registro->Mes;
	$dia = $registro->Dia;
	$matricula =$registro->Matricula;
	$nombre = $registro->Nombre;
	$primerap = $registro->PrimerApellido;
	$segundoap = $registro->SegundoApellido;
	$edificio = $registro->Edificio;
	$tipoarea =$registro->TipoArea;
	$area = $registro->Area;
	$estatus = $registro->Finalizado;
	$total = $registro->NumArticulos;


	$pdf->SetFont('Arial','',10);
	$pdf->Row(array(utf8_decode($numFolio),utf8_decode($fecha),utf8_decode($mes),utf8_decode($dia),utf8_decode($matricula),utf8_decode($nombre),utf8_decode($primerap),utf8_decode($segundoap),utf8_decode($edificio),utf8_decode($tipoarea),utf8_decode($area),utf8_decode($estatus),utf8_decode($total)));
}

//Mostramos el documento pdf
$pdf->Output();


}else{
	header( 'Location:../views/noacceso.php' );
	}

}
ob_end_flush();
?>
