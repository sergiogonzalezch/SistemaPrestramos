<?php
//Llamar el modelo
require_once "../models/Consulta.php";
//Crear una instancia del modelo
$consulta = new Consulta();
/*Todas las funcionalidades de las consultas necesitan dos parámetros
para establecer  un rango de fechas mediante el parámetro fechaIncio, para establecer  el comienzo de las búsquedas y fechaFin para delimitar un periodo*/
//Switch Case para seleccionar una operación a ejecutar
switch ( $_GET["op"] ) {
	/*Case consulta servicios que permite enlistar los registros de servicios realizados por los usuarios a los prestamos atendidos*/
	case 'consultaServicios':
	/*Inicializar la varible fechaIncio para ser usado como parámetro*/
	$fechaInicio = $_REQUEST["fechaInicio"];
	/*Inicializar la varible fechaFin para ser usado como parámetro*/
	$fechaFin = $_REQUEST["fechaFin"];
	/*Llamar a la consulta servicios y enviar las variables
	como parámetros para el rango de fechas*/
	$respuesta = $consulta->consultaServicios( $fechaInicio,
	$fechaFin );
	//Declarar una variable para almacenar valores en un arreglo
	$data = Array();
	//con un ciclo while se van proyectando los campos necesarios de la tabla
	while( $registro = $respuesta->fetch_object() ) {
		$data[] = array(
			"0"=>$registro->Año,
			"1"=>$registro->Mes,
			"2"=>$registro->Dia,
			"3"=>$registro->aliasUsuario,
			"4"=>$registro->tipoServicio,
			"5"=>$registro->folio
		);
	}//Enviar los valores en un arreglo
	$resultados = array(
		"sEcho"=>1, //Información para el datatables
		"iTotalRecords"=>count( $data ), //envía el total registros al datatable
		"iTotalDisplayRecords"=>count( $data ), //envía el total registros a visualizar
		"aaData"=>$data
	);
	//Se envían los datos JSON
	echo json_encode( $resultados );
	break;
	//---------------------------------------------------------------------------
	/*Case consulta servicios que permite enlistar los artículos
	solicitados por los prestarios y contabiliza el total
	de artículos solicitados por tipo y por cliente*/
	case 'consultaPrestarios':
	/*Inicializar la varible fechaIncio para ser usado como parámetro*/
	$fechaInicio = $_REQUEST["fechaInicio"];
	/*Inicializar la varible fechaFin para ser usado como parámetro*/
	$fechaFin = $_REQUEST["fechaFin"];
	/*Llamar a la consulta prestarios y enviar las variables
	como parámetros para el rango de fechas*/
	$respuesta = $consulta->consultaPrestarios( $fechaInicio, $fechaFin );
	//Declarar una variable para almacenar valores en un arreglo
	$data = Array();
	//con un ciclo while se van proyectando los campos necesarios de la tabla
	while( $registro = $respuesta->fetch_object() ) {
		$data[] = array(
			"0"=>$registro->Año,
			"1"=>$registro->Mes,
			"2"=>$registro->MatriculaCliente,
			"3"=>$registro->Nombre,
			"4"=>$registro->Tipo,
			"5"=>$registro->NoArticulos
		);
	}//Enviar los valores en un arreglo
	$resultados = array(
		"sEcho"=>1, //Información para el datatables
		"iTotalRecords"=>count( $data ), //envía el total registros al datatable
		"iTotalDisplayRecords"=>count( $data ), //envía el total registros a visualizar
		"aaData"=>$data
	);
	//Se envían los datos JSON
	echo json_encode( $resultados );
	break;
	//---------------------------------------------------------------------------
	/*Case consulta entregas que permite enlistar los artículos
	entregados y contabiliza el número de veces en que fueron
	entregados según su tipo de articulo*/
	case 'consultaEntregas':
	/*Inicializar la varible fechaIncio para ser usado como parámetro*/
	$fechaInicio = $_REQUEST["fechaInicio"];
	/*Inicializar la varible fechaFin para ser usado como parámetro*/
	$fechaFin = $_REQUEST["fechaFin"];
	/*Llamar a la consulta entregas y enviar las variables
	como parámetros para el rango de fechas*/
	$respuesta = $consulta->consultaEntregas( $fechaInicio,
	$fechaFin );
	//Declarar una variable para almacenar valores en un arreglo
	$data = Array();
	//con un ciclo while se van proyectando los campos necesarios de la tabla
	while( $registro = $respuesta->fetch_object() ) {
		$data[] = array(
			"0"=>$registro->Año,
			"1"=>$registro->Mes,
			"2"=>$registro->Dia,
			"3"=>$registro->tipoArticulo,
			"4"=>$registro->NumEntregas
		);
	}//Enviar los valores en un arreglo
	$resultados = array(
		"sEcho"=>1, //Información para el datatables
		"iTotalRecords"=>count( $data ), //envía el total registros al datatable
		"iTotalDisplayRecords"=>count( $data ), //envía el total registros a visualizar
		"aaData"=>$data
	);
	//Se envían los datos JSON
	echo json_encode( $resultados );
	break;
	//---------------------------------------------------------------------------
	/*Case consulta ubicaciones que permite enlistar los articulos
	prestados y contabiliza el úumero de veces en que fueron
	entregados según su tipo de artículo y la ubicación
	donde fueron utilizados*/
	case 'consultaUbicaciones':
	/*Inicializar la varible fechaIncio para ser usado como parámetro*/
	$fechaInicio = $_REQUEST["fechaInicio"];
	/*Inicializar la varible fechaFin para ser usado como parámetro*/
	$fechaFin = $_REQUEST["fechaFin"];
	$respuesta = $consulta->consultaUbicaciones( $fechaInicio, $fechaFin );
	//Declarar una variable para almacenar valores en un arreglo
	$data = Array();
	//con un ciclo while se van proyectando los campos necesarios de la tabla
	while( $registro = $respuesta->fetch_object() ) {
		$data[] = array(
			"0"=>$registro->Año,
			"1"=>$registro->Mes,
			"2"=>$registro->edificio,
			"3"=>$registro->tipoArea,
			"4"=>$registro->descripcionArea,
			"5"=>$registro->tipoArticulo,
			"6"=>$registro->TotalPrestamos
		);
	}//Enviar los valores en un arreglo
	$resultados = array(
		"sEcho"=>1, //Información para el datatables
		"iTotalRecords"=>count( $data ), //envía el total registros al datatable
		"iTotalDisplayRecords"=>count( $data ), //envía el total registros a visualizar
		"aaData"=>$data
	);
	//Se envían los datos JSON
	echo json_encode( $resultados );
	break;
	//---------------------------------------------------------------------------
	/*Case consulta devolución que permite enlistar los artículos
	devueltos y contabiliza el número de veces en que fueron
	devueltos según su tipo de artículo y su condición de devolución*/
	case 'consultaDevolucion':
	/*Inicializar la varible fechaIncio para ser usado como parámetro*/
	$fechaInicio = $_REQUEST["fechaInicio"];
	/*Inicializar la varible fechaFin para ser usado como parámetro*/
	$fechaFin = $_REQUEST["fechaFin"];
	$respuesta = $consulta->consultaDevolucion( $fechaInicio, $fechaFin );
	//Declarar una variable para almacenar valores en un arreglo
	$data = Array();
	//con un ciclo while se van proyectando los campos necesarios de la tabla
	while( $registro = $respuesta->fetch_object() ) {
		$data[] = array(
			"0"=>$registro->Año,
			"1"=>$registro->Mes,
			"2"=>$registro->TipoArticulo,
			"3"=>$registro->Condicion,
			"4"=>$registro->Total
		);
	}//Enviar los valores en un arreglo
	$resultados = array(
		"sEcho"=>1, //Información para el datatables
		"iTotalRecords"=>count( $data ), //envía el total registros al datatable
		"iTotalDisplayRecords"=>count( $data ), //envía el total registros a visualizar
		"aaData"=>$data
	);
	//Se envían los datos JSON
	echo json_encode( $resultados );
	break;
}
?>
