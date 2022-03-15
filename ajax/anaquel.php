<?php
//Llamar el modelo
require_once "../models/Anaquel.php";
//Crear una instancia del modelo
$anaquel = new Anaquel();
//Declarar las variables que se emplearan
//Mediadiante un isset
$idAnaquel = isset( $_POST["idAnaquel"] )?
limpiarCadena( $_POST["idAnaquel"] ):"";
$anaquelNumero = isset( $_POST["anaquelNumero"] )?
limpiarCadena( $_POST["anaquelNumero"] ):"";
$descripcionAnaquel = isset( $_POST["descripcionAnaquel"] )?
limpiarCadena( $_POST["descripcionAnaquel"] ):"";
//---------------------------------------------------------------------------
//Switch Case para seleccionar una operación a ejecutar
switch ( $_GET["op"] ) {
	//Case para guardar y editar los datos
	case 'guardaryeditar':
	/*Secuencia If en la cual se validan si el registro esta vacío mediante el id del campo.
	De ser asi se llama la función insertar para crear un nuevo registro*/
	if ( empty( $idAnaquel ) ) {
		/*Llamar el metodo insertar en el modelo y
		enviar las variables como parámetros*/
		$respuesta = $anaquel->insertar( $anaquelNumero,
		$descripcionAnaquel );
		//Mediante unaoperación ternaria evalúa si la operación fue exitosa o no.
		echo $respuesta?"Anaquel registrado":"No se pudo registrar";
	}
	/*Si el campo no esta vacío llama a la función editar
	para modificar el dato o los datos a cambiar del registro*/
	else {
		/*Llamar la función editar del modelo y
		enviar las varabiles como parámetros*/
		$respuesta = $anaquel->editar($idAnaquel,
		$anaquelNumero,
		$descripcionAnaquel);
		//Mediante una operación ternaria evalúa si la operación fue exitosa o no.
		echo $respuesta? "Anaquel actualizado" : "No se pudo actualizar";
	}
	break;
	//---------------------------------------------------------------------------
	//Case para mostrar
	case 'mostrar':
	//Llamar la función mostrar y enviar el id del registro como parámetro
	$respuesta = $anaquel->mostrar( $idAnaquel );
	//Se envían los valores por medio de JSON
	echo json_encode($respuesta);
	break;
	//---------------------------------------------------------------------------
	//Case para listar los registros de la consulta
	case 'listar':
	//Llamar la función listar para visualizar todos los registros de la consulta
	$respuesta = $anaquel->listar();
	//Declarar una variable para almacenar valores en un arreglo
	$data = Array();
	//con un ciclo while se van proyectando los campos necesarios de la tabla
	while( $registro = $respuesta->fetch_object() ) {
		$data[] = array(
			/*Permite crear un botón con el valor del id del registro
			donde se llama la función para editar el campo*/
			"0"=>'<button class="btn btn-warning" type="button"
			onclick="mostrar('.$registro->idAnaquel.')"  data-toggle = "modal" href = "#myModal" data-target = "#myModal" >
			<i class="fas fa-edit"></i></button>',
			"1"=>$registro->anaquelNumero,
			"2"=>$registro->descripcionAnaquel
		);
	}
	//Almacenar la información en un arreglo
	$resultados = array(
		"sEcho"=>1, //Información para el datatables
		"iTotalRecords"=>count( $data ),//envía el total registros al datatable
		"iTotalDisplayRecords"=>count( $data ),//envía el total registros a visualizar
		"aaData"=>$data
	);
	//Se envían los datos mediante JSON
	echo json_encode( $resultados,JSON_UNESCAPED_UNICODE );
	break;
}
?>
