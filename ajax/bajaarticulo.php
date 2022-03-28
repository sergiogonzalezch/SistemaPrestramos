<?php
//Llamar el modelo
require_once "../models/BajaArticulo.php";
//Crear una instancia del modelo
$baja = new BajaArticulo();
//Declarar las variables que se usaran
$idBaja = isset( $_POST["idBaja"] )?
limpiarCadena( $_POST["idBaja"] ):"";
$fechaBaja = isset( $_POST["fechaBaja"] )?
limpiarCadena( $_POST["fechaBaja"] ):"";
$observacionBaja = isset( $_POST["observacionBaja"] )?
limpiarCadena( $_POST["observacionBaja"] ):"";
$idArticulo = isset( $_POST["idArticulo"] )?
limpiarCadena( $_POST["idArticulo"] ):"";
//---------------------------------------------------------------------------
//Switch Case para seleccionar una operación a ejecutar
switch ( $_GET["op"] ) {
	//Case para guardar y editar los datos
	case 'guardaryeditar':
	/*Secuencia If en la cual se validan si el registro está
	vacío mediante el id del campo.
	De ser así llama la función insertar para crear un nuevo registro*/
	if ( empty( $idBaja ) ) {
		/*Llamar el metodo insertar en el modelo y
		enviar las variables como parámetros*/
		$respuesta = $baja->insertar( $fechaBaja,
		$observacionBaja,
		$idArticulo );
		//Mediante una operación ternaria evalúa si la operación fue exitosa o no.
		echo $respuesta?"Baja registrado":"No se pudo registrar";
	}
	/*Si el campo no está vacío, llama a la función editar
	para modificar el dato o los datos a cambiar del registro*/
	else {
		/*Si el campo no esta vacío llama a la función editar
		para modificar el dato o los datos a cambiar del registro*/
		$respuesta = $baja->editar( $idBaja,
		$observacionBaja );
		//Mediante una operación ternaria evalúa si la operación fue exitosa o no.
		echo $respuesta?"Baja actualizado":"No se pudo actualizar";
	}
	break;
	//---------------------------------------------------------------------------
	/*Case función para la función eliminar
	case 'eliminar':
	//Llamar la función eliminar del modelo y enviar el id del artículo a dar de baja como parámetro*/
	$rspta = $baja->eliminar( $idArticulo );
	echo $rspta?"Registro eliminado":
	"No se puede eliminar";
	break;
	//---------------------------------------------------------------------------
	//Case mostrar
	case 'mostrar':
	//Llamar la función mostrar y enviar el id del registro como parámetro
	$respuesta = $baja->mostrar( $idBaja );
	//Enviar los valores mediante JSON
	echo json_encode( $respuesta );
	break;
	//---------------------------------------------------------------------------
	//Case listar
	case 'listar':
	//Permite listar todos los registros de la tabla y se almacenan en un array
	$respuesta = $baja->listar();
	$data = Array();
	/*con un ciclo while se van proyectando los campos necesarios de la tabla*/
	while( $registro = $respuesta->fetch_object() ) {
		$data[] = array(
			/*Permite crear un botón con el valor del id del registro
			donde se llama la función para editar
			el campo mediante el Id del registro tambien*/
			"0"=>'<button class="btn btn-warning"
			onclick="mostrar('.$registro->Id.')" data-toggle = "modal" href = "#myModal" data-target = "#myModal">
			<i class="fas fa-edit"></i></button>',
			"1"=>$registro->FechaBaja,
			"2"=>$registro->Observaciones,
			"3"=>$registro->Articulo );
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
