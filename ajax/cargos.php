<?php
//Llamar el modelo
require_once "../models/Cargos.php";
//Crear una instancia del modelo
$cargos = new Cargos();
//Declarar la variables que se emlearan
$idCargo = isset( $_POST["idCargo"] )?
limpiarCadena( $_POST["idCargo"] ):"";
$cargoCliente = isset( $_POST["cargoCliente"] )?
limpiarCadena( $_POST["cargoCliente"] ):"";
//---------------------------------------------------------------------------
//Switch Case para selecionar una operacion a ejecturar
switch ( $_GET["op"] ) {
	//Case para guardar y editar los datos
	case 'guardaryeditar':
	/*Secuencia If en la cual se validan si el registro esta vacio mediante el id del campo.
	De ser asi se llamar la funcion insertan para crear un nuevo registro*/
	if ( empty( $idCargo ) ) {
		$respuesta = $cargos->insertar( $cargoCliente );
		//Mediante una operacion ternaria evalua si la operacion fue exitosa o no.
		echo $respuesta?"Cargo registrado":"No se pudo registrar";
	}
	/*Si el campo no esta vacio llamar a la funcion
	editar para modificar el dato o los datos a cambiar del registro*/
	else {
		$respuesta = $cargos->editar( $idCargo,
		$cargoCliente );
		//Mediante una operacion ternaria evalua si la operacion fue exitosa o no.
		echo $respuesta?"Cargo actualizado":"No se pudo actualizar";
	}
	break;
	//---------------------------------------------------------------------------
	//Permite mostrar los valores de un registro determinado mediante su Id
	case 'mostrar':
	//Llamar la funcion mostar y enviar el id del registro como parametro
	$respuesta = $cargos->mostrar( $idCargo );
	//Enviar los valores mediante JSON
	echo json_encode( $respuesta );
	break;
	//---------------------------------------------------------------------------
	//Permite listar todos los registros de la tabla y se almacenan en un array
	case 'listar':
	$respuesta = $cargos->listar();
	//Declarar una variable para alamcenar valores en un arreglo
	$data = Array();
	//con un ciclo while se van proyectando los campos necesarios de la tabla
	while( $registro = $respuesta->fetch_object() ) {
		$data[] = array(
			/*Permite crear un boton con el valor del id del registro
			donde se llama la funcion para editar el campo*/
			"0"=>'<button class="btn btn-warning" type="button"
			onclick="mostrar('.$registro->idCargo.')"
			data-toggle = "modal" href = "#myModal" data-target = "#myModal">
			<i class="fas fa-edit"></i></button>',
			"1"=>$registro->cargoCliente
		);
	}
	//Almacenar la informacion en un arreglo
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
