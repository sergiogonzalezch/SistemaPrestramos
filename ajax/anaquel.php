<?php
//Llamar el modelo
require_once "../models/Anaquel.php";
//Crear una instancia del modelo
$anaquel = new Anaquel();
//Declarar la variables que se emplearan
//Mediadiante un isset
$idAnaquel = isset( $_POST["idAnaquel"] )?
limpiarCadena( $_POST["idAnaquel"] ):"";
$anaquelNumero = isset( $_POST["anaquelNumero"] )?
limpiarCadena( $_POST["anaquelNumero"] ):"";
$descripcionAnaquel = isset( $_POST["descripcionAnaquel"] )?
limpiarCadena( $_POST["descripcionAnaquel"] ):"";
//---------------------------------------------------------------------------
//Switch Case para selecionar una operacion a ejecturar
switch ( $_GET["op"] ) {
	//Case para guardar y editar los datos
	case 'guardaryeditar':
	/*Secuencia If en la cual se validan si el registro esta vacio mediante el id del campo.
	De ser asi se llama la funcion insertan para crear un nuevo registro*/
	if ( empty( $idAnaquel ) ) {
		/*Llamar el metodo insertar en el modelo y
		enviar las variables como parametros*/
		$respuesta = $anaquel->insertar( $anaquelNumero,
		$descripcionAnaquel );
		//Mediante una operacion ternaria evalua si la operacion fue exitosa o no.
		echo $respuesta?"Anaquel registrado":"No se pudo registrar";
	}
	/*Si el campo no esta vacio llama a la funcion editar
	para modificar el dato o los datos a cambiar del registro*/
	else {
		/*Llamar la funcion editar del modelo y
		enviar las varabiles como parametros*/
		$respuesta = $anaquel->editar($idAnaquel,
		$anaquelNumero,
		$descripcionAnaquel);
		//Mediante una operacion ternaria evalua si la operacion fue exitosa o no.
		echo $respuesta?"Anaquel actualizado":"No se pudo actualizar";
	}
	break;
	//---------------------------------------------------------------------------
	//Case para mostrar
	case 'mostrar':
	//Llamar la funcion mostar y enviar el id del registro como parametro
	$respuesta = $anaquel->mostrar( $idAnaquel );
	//Se envian los valores por medio de JSON
	echo json_encode( $respuesta );
	break;
	//---------------------------------------------------------------------------
	//Case para listar los registros de la consulta
	case 'listar':
	//Llamar la funcion listar para visaulizar todos los registros de la consulta
	$respuesta = $anaquel->listar();
	//Declarar una variable para alamcenar valores en un arreglo
	$data = Array();
	//con un ciclo while se van proyectando los campos necesarios de la tabla
	while( $registro = $respuesta->fetch_object() ) {
		$data[] = array(
			/*Permite crear un boton con el valor del id del registro
			donde se llama la funcion para editar el campo*/
			"0"=>'<button class="btn btn-warning" type="button"
			onclick="mostrar('.$registro->idAnaquel.')"  data-toggle = "modal" href = "#myModal" data-target = "#myModal" >
			<i class="fas fa-edit"></i></button>',
			"1"=>$registro->anaquelNumero,
			"2"=>$registro->descripcionAnaquel
		);
	}
	//Almacenar la informacion en un arreglo
	$resultados = array(
		"sEcho"=>1, //Información para el datatables
		"iTotalRecords"=>count( $data ),//enviamos el total registros al datatable
		"iTotalDisplayRecords"=>count( $data ),//enviamos el total registros a visualizar
		"aaData"=>$data
	);
	//Se envian los datos mediante JSON
	echo json_encode( $resultados,JSON_UNESCAPED_UNICODE );
	break;
}
?>
