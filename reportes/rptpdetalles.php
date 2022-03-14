<?php
ob_start();
if (strlen(session_id()) < 1)
  session_start();
if(!isset($_SESSION['usuarios'])){
	echo "Debe ingresar correctamente ";
}else{

if($_SESSION['usuarios']['rolUsuario']=="Administrador"){
require('../fpdf182/fpdf.php');

require_once"../Models/Consulta.php";

$consulta = new Consulta();
$respuesta = $consulta->cabecera($_GET["Id"]);
$registro = $respuesta->fetch_object();

$pdf = new FPDF($orientation='P',$unit='mm');
$pdf->AddPage();
$pdf->SetFont('Arial','B',20);
$textypos = 5;
$pdf->setY(12);
$pdf->setX(100);
// Agregamos los datos de la empresa
$pdf->Cell(5,$textypos,"Centro de Ingenieria Computacional");
$pdf->Image('img/Imagen1.jpg',30,12,20,20,'JPG');
$pdf->Image('img/Imagen2.jpg',250,12,20,20,'JPG');
//
$pdf->SetFont('Arial','B',12);
$pdf->setY(25);$pdf->setX(50);
$pdf->Cell(5,$textypos,"Folio: ".utf8_decode($registro->NumFolio));
//

$pdf->SetFont('Arial','B',10);
$pdf->setY(25);$pdf->setX(100);
$pdf->Cell(5,$textypos,"Fecha de Prestamo: ".utf8_decode($registro->Fecha));
$pdf->setY(25);$pdf->setX(180);
$pdf->Cell(5,$textypos,"Fecha de Cierre: ".utf8_decode($registro->FechaCierre));

//
$pdf->SetFont('Arial','B',10);
$pdf->setY(35);$pdf->setX(30);
$pdf->Cell(5,$textypos,"Detalles:");
//
$pdf->setY(40);$pdf->setX(30);
$pdf->SetFont('Arial','',10);
$pdf->Cell(5,$textypos,"Num. de Empleado: ".utf8_decode($registro->Matricula));
$pdf->setY(45);$pdf->setX(30);
$pdf->Cell(5,$textypos,"Nombre Completo: ".utf8_decode($registro->Nombre).
" ".utf8_decode($registro->PrimerApellido).
" ".utf8_decode($registro->SegundoApellido));
$pdf->setY(50);$pdf->setX(30);
$pdf->Cell(5,$textypos,"Numero de Articulos: ".utf8_decode($registro->NumArticulos));

///
	// Agregamos los datos del cliente
$pdf->SetFont('Arial','B',10);
$pdf->setY(35);$pdf->setX(120);
$pdf->Cell(5,$textypos,"Ubicacion:");
$pdf->SetFont('Arial','',10);
$pdf->setY(40);$pdf->setX(120);
$pdf->Cell(5,$textypos,"Edificio: ".utf8_decode($registro->Edificio));
$pdf->setY(45);$pdf->setX(120);
$pdf->Cell(5,$textypos,"Tipo de Area: ".utf8_decode($registro->TipoArea));
$pdf->setY(50);$pdf->setX(120);
$pdf->Cell(5,$textypos,"Area: ".utf8_decode($registro->Area));

///

$entrega = $consulta->servicioEntrega($_GET["Id"]);
$registroEntrega = $entrega->fetch_object();

$pdf->SetFont('Arial','B',10);
$pdf->setY(35);$pdf->setX(170);
$pdf->Cell(5,$textypos,"Entrego: ");
$pdf->SetFont('Arial','',10);
$pdf->setY(40);$pdf->setX(170);
$pdf->Cell(5,$textypos,"Alias : ".utf8_decode($registroEntrega->Alias));
$pdf->setY(45);$pdf->setX(170);
$pdf->Cell(5,$textypos,"Servicio : ".utf8_decode($registroEntrega->Servicio));
$pdf->setY(50);$pdf->setX(170);
$pdf->Cell(5,$textypos,"Fecha Entrega: ".utf8_decode($registroEntrega->FechaServicio));
///


$devolucion = $consulta->servicioDevolucion($_GET["Id"]);
$registroDevolucion = $devolucion->fetch_object();

$pdf->SetFont('Arial','B',10);
$pdf->setY(35);$pdf->setX(220);
$pdf->Cell(5,$textypos,"Recibio: ");
$pdf->SetFont('Arial','',10);
$pdf->setY(40);$pdf->setX(220);
$pdf->Cell(5,$textypos,"Alias : ".utf8_decode($registroDevolucion->Alias));
$pdf->setY(45);$pdf->setX(220);
$pdf->Cell(5,$textypos,"Servicio : ".utf8_decode($registroDevolucion->Servicio));
$pdf->setY(50);$pdf->setX(220);
$pdf->Cell(5,$textypos,"Fecha Devolucion: ".utf8_decode($registroDevolucion->FechaServicio));

///
$pdf->SetFont('Arial','B',10);
$pdf->setY(60);$pdf->setX(10);
$pdf->Cell(10,10,'Id',1,0,'C',0);

	$pdf->Cell(50,10,'Articulo',1,0,'C',0);

	$pdf->Cell(35,10,'Condicion Entrega',1,0,'C',0);

	$pdf->Cell(35,10,'Fecha Devolucion',1,0,'C',0);

	$pdf->Cell(40,10,'Condicion Devolucion',1,0,'C',0);

	$pdf->Cell(90,10,'Observaciones',1,0,'C',0);


$pdf->SetFont('Arial','',10);
$pdf->setY(70);$pdf->setX(10);

$resultado=$consulta->cuerpo($_GET["Id"]);
while ($row = $resultado->fetch_assoc()) {
	$pdf->Cell(10,10,$row['Identificador'],1,0,'C',0);

	$pdf->Cell(50,10,$row['Articulo'],1,0,'C',0);

	$pdf->Cell(35,10,$row['CondicionEntrega'],1,0,'C',0);

	$pdf->Cell(35,10,$row['FechaDevolucion'],1,0,'C',0);

	$pdf->Cell(40,10,$row['CondicionDevolucion'],1,0,'C',0);

	$pdf->Cell(90,10,utf8_decode($row['Observaciones']),1,0,'C',0);

	$pdf->Ln(10);

}
$pdf->output();
}else{
	header( 'Location:../views/noacceso.php' );
	}
}
ob_end_flush();
?>
