<?php
//Llamar el modelo
require_once "../models/Cargos.php";
//Crear una instancia del modelo
$cargos = new Cargos();
//Declarar las variables que se usaran
$idCargo = isset( $_POST["idCargo"] )?
limpiarCadena( $_POST["idCargo"] ):"";
$cargoCliente = isset( $_POST["cargoCliente"] )?
limpiarCadena( $_POST["cargoCliente"] ):"";
//---------------------------------------------------------------------------
//Switch Case para seleccionar una operación a ejecutar
switch ( $_GET["op"] ) {
	//Case para guardar y editar los datos
	case 'guardaryeditar':
	/*Secuencia If en la cual se validan si el registro esta vacíomediante el id del campo.
	De ser asi se llamar la función insertar para crear un nuevo registro*/
	if ( empty( $idCargo ) ) {
		$respuesta = $cargos->insertar( $cargoCliente );
		//Mediante una operación ternaria evalúa si la operación fue exitosa o no.
		echo $respuesta?"Cargo registrado" : "No se pudo registrar";
	}
	/*Si el campo no está vacío llamar a la función
	editar para modificar el dato o los datos a cambiar del registro*/
	else {
		$respuesta = $cargos->editar( $idCargo,
		$cargoCliente );
		//Mediante una operación ternaria   evalúa   si la operación fue exitosa o no.
		echo $respuesta?"Cargo actualizado":"No se pudo actualizar";
	}
	break;
	//---------------------------------------------------------------------------
	//Permite mostrar los valores de un registro determinado mediante su Id
	case 'mostrar':
	//Llamar la función mostrar y enviar el id del registro como parámetro
	$respuesta = $cargos->mostrar( $idCargo );
	//Enviar los valores mediante JSON
	echo json_encode( $respuesta );
	break;
	//---------------------------------------------------------------------------
	//Permite listar todos los registros de la tabla y se almacenan en un array
	case 'listar':
	$respuesta = $cargos->listar();
	//Declarar una variable para almacenar valores en un arreglo
	$data = Array();
	//con un ciclo while se van proyectando los campos necesarios de la tabla
	while( $registro = $respuesta->fetch_object() ) {
		$data[] = array(
			/*Permite crear un botón con el valor del id del registro
			donde se llama la función para editar el campo*/
			"0"=>'<button class="btn btn-warning" type="button"
			onclick="mostrar('.$registro->idCargo.')"
			data-toggle = "modal" href = "#myModal" data-target = "#myModal">
			<i class="fas fa-edit"></i></button>',
			"1"=>$registro->cargoCliente
		);
	}
	//Almacenar la información en un arreglo
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
