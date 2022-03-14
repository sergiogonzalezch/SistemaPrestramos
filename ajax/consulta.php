<?php
//Llamar el modelo
require_once "../models/Consulta.php";
//Crear una instancia del modelo
$consulta = new Consulta();
/*Todas la funcionalidades de las consultas necesitan dos parametros
paraestablecer  un rango de fechas mediante el parametro fechaIncio, paraestablecer  el comienzo de las busquedas y fechaFin para delimitar un periodo*/
//Switch Case para selecionar una operacion a ejecturar
switch ( $_GET["op"] ) {
	/*Case consulta servicios que permite enlistar los registros de servicios realizados por los usuarios a los prestamos atendidos*/
	case 'consultaServicios':
	/*Inicializar la varible fechaIncio para ser usado como parametro*/
	$fechaInicio = $_REQUEST["fechaInicio"];
	/*Inicializar la varible fechaFin para ser usado como parametro*/
	$fechaFin = $_REQUEST["fechaFin"];
	/*Llamar a la consulta servicios y enviar las variables
	como parametros para el rango de fechas*/
	$respuesta = $consulta->consultaServicios( $fechaInicio,
	$fechaFin );
	//Declarar una variable para alamcenar valores en un arreglo
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
		"iTotalRecords"=>count( $data ), //enviamos el total registros al datatable
		"iTotalDisplayRecords"=>count( $data ), //enviamos el total registros a visualizar
		"aaData"=>$data
	);
	//Se envian los datos JSON
	echo json_encode( $resultados );
	break;
	//---------------------------------------------------------------------------
	/*Case consulta servicios que permite enlistar los articulos
	solicitados por los prestarios y contabiliza el total
	de articulos solicitados por tipo y por cliente*/
	case 'consultaPrestarios':
	/*Inicializar la varible fechaIncio para ser usado como parametro*/
	$fechaInicio = $_REQUEST["fechaInicio"];
	/*Inicializar la varible fechaFin para ser usado como parametro*/
	$fechaFin = $_REQUEST["fechaFin"];
	/*Llamar a la consulta prestarios y enviar las variables
	como parametros para el rango de fechas*/
	$respuesta = $consulta->consultaPrestarios( $fechaInicio, $fechaFin );
	//Declarar una variable para alamcenar valores en un arreglo
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
		"iTotalRecords"=>count( $data ), //enviamos el total registros al datatable
		"iTotalDisplayRecords"=>count( $data ), //enviamos el total registros a visualizar
		"aaData"=>$data
	);
	//Se envian los datos JSON
	echo json_encode( $resultados );
	break;
	//---------------------------------------------------------------------------
	/*Case consulta entregas que permite enlistar los articulos
	entregados y contabiliza el numero de veces en que fueron
	entregados segun su tipo de articulo*/
	case 'consultaEntregas':
	/*Inicializar la varible fechaIncio para ser usado como parametro*/
	$fechaInicio = $_REQUEST["fechaInicio"];
	/*Inicializar la varible fechaFin para ser usado como parametro*/
	$fechaFin = $_REQUEST["fechaFin"];
	/*Llamar a la consulta entregas y enviar las variables
	como parametros para el rango de fechas*/
	$respuesta = $consulta->consultaEntregas( $fechaInicio,
	$fechaFin );
	//Declarar una variable para alamcenar valores en un arreglo
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
		"iTotalRecords"=>count( $data ), //enviamos el total registros al datatable
		"iTotalDisplayRecords"=>count( $data ), //enviamos el total registros a visualizar
		"aaData"=>$data
	);
	//Se envian los datos JSON
	echo json_encode( $resultados );
	break;
	//---------------------------------------------------------------------------
	/*Case consulta ubicaciones que permite enlistar los articulos
	prestados y contabiliza el numero de veces en que fueron
	entregados segun su tipo de articulo y la ubicacion
	donde fueron utilizados*/
	case 'consultaUbicaciones':
	/*Inicializar la varible fechaIncio para ser usado como parametro*/
	$fechaInicio = $_REQUEST["fechaInicio"];
	/*Inicializar la varible fechaFin para ser usado como parametro*/
	$fechaFin = $_REQUEST["fechaFin"];
	$respuesta = $consulta->consultaUbicaciones( $fechaInicio, $fechaFin );
	//Declarar una variable para alamcenar valores en un arreglo
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
		"iTotalRecords"=>count( $data ), //enviamos el total registros al datatable
		"iTotalDisplayRecords"=>count( $data ), //enviamos el total registros a visualizar
		"aaData"=>$data
	);
	//Se envian los datos JSON
	echo json_encode( $resultados );
	break;
	//---------------------------------------------------------------------------
	/*Case consulta devolucion que permite enlistar los articulos
	devueltosy contabiliza el numero de veces en que fueron
	devueltos segun su tipo de articulo y su condicion de devolucion*/
	case 'consultaDevolucion':
	/*Inicializar la varible fechaIncio para ser usado como parametro*/
	$fechaInicio = $_REQUEST["fechaInicio"];
	/*Inicializar la varible fechaFin para ser usado como parametro*/
	$fechaFin = $_REQUEST["fechaFin"];
	$respuesta = $consulta->consultaDevolucion( $fechaInicio, $fechaFin );
	//Declarar una variable para alamcenar valores en un arreglo
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
		"iTotalRecords"=>count( $data ), //enviamos el total registros al datatable
		"iTotalDisplayRecords"=>count( $data ), //enviamos el total registros a visualizar
		"aaData"=>$data
	);
	//Se envian los datos JSON
	echo json_encode( $resultados );
	break;
}
?>
