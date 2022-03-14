<?php
//Llamar el modelo
require_once "../models/ProgramaEducativo.php";
//Llamar el modelo
$programaeducativo = new ProgramaEducativo();
//Declarar la variables que se emlearan
$idProgramaEducativo = isset( $_POST["idProgramaEducativo"] )?
limpiarCadena( $_POST["idProgramaEducativo"] ):"";
$programasEducativos = isset( $_POST["programasEducativos"] )?
limpiarCadena( $_POST["programasEducativos"] ):"";
//---------------------------------------------------------------------------
//Switch Case para selecionar una operacion a ejecturar
switch ( $_GET["op"] ) {
	//Case para guardar y editar los datos
	case 'guardaryeditar':
	/*Secuencia If en la cual se validan si el registro esta vacio mediante el id del campo.
	De ser asi se llama la funcion insertan para crear un nuevo registro*/
	if ( empty( $idProgramaEducativo ) ) {
		$respuesta = $programaeducativo->insertar( $programasEducativos );
		echo $respuesta?"Programa educativo registrado":"No se pudo registrar";
	}
	/*Si el campo no esta vacio llama a la funcion
	editar para modificar el dato o los datos a cambiar del registro*/
	else {
		$respuesta = $programaeducativo->editar( $idProgramaEducativo,
		$programasEducativos );
		echo $respuesta?"Programa educativo actualizado":"No se pudo actualizar";
	}
	break;
	//---------------------------------------------------------------------------
	//Case que permite mostrar los valores de un registro determinado mediante su Id
	case 'mostrar':
	$respuesta = $programaeducativo->mostrar( $idProgramaEducativo );
	echo json_encode( $respuesta );
	break;
	//---------------------------------------------------------------------------
	//Case que permite listar todos los registros de la tabla y se almacenan en un array
	case 'listar':
	$respuesta = $programaeducativo->listar();
	$data = Array();
	//con un ciclo while se van proyectando los campos necesarios de la tabla
	while( $registro = $respuesta->fetch_object() ) {
		$data[] = array(
			/*Permite crear un boton con el valor del id del registro
			donde se llama la funcion para editar el campo*/
			"0"=>'<button class="btn btn-warning" type="button"
			onclick="mostrar('.$registro->idProgramaEducativo.')" data-toggle = "modal" href = "#myModal" data-target = "#myModal">
			<i class="fas fa-edit"></i></button>',
			"1"=>$registro->programasEducativos,
		);
	}
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
