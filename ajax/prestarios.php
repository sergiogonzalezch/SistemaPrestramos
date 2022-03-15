<?php
//Llamar el modelo
require_once "../models/Prestarios.php";
$prestamista = new Prestarios();
//Crear una instancia del modelo
$idDatosGenerales = isset( $_POST["idDatosGenerales"] )?limpiarCadena( $_POST["idDatosGenerales"] ):"";
$nombres = isset( $_POST["nombres"] )?
limpiarCadena( $_POST["nombres"] ):"";
$primerApellido = isset( $_POST["primerApellido"] )?
limpiarCadena( $_POST["primerApellido"] ):"";
$segundoApellido = isset( $_POST["segundoApellido"] )?
limpiarCadena( $_POST["segundoApellido"] ):"";
$correoInstitucional = isset( $_POST["correoInstitucional"] )?
limpiarCadena( $_POST["correoInstitucional"] ):"";
$matricula = isset( $_POST["matricula"] )?limpiarCadena( $_POST["matricula"] ):"";
$idProgramaEducativo = isset( $_POST["idProgramaEducativo"] )?limpiarCadena( $_POST["idProgramaEducativo"] ):"";
$idCargo = isset( $_POST["idCargo"] )?limpiarCadena( $_POST["idCargo"] ):"";
//---------------------------------------------------------------------------
//Switch Case para seleccionar una operación a ejecutar
switch ( $_GET["op"] ) {
	//Case para guardar y editar los datos
	case 'guardaryeditar':
	/*Secuencia If en la cual se validan si el registro esta vacío mediante el id del campo.
	De ser asi se llama la función insertar para crear un nuevo registro*/
	if ( empty( $idDatosGenerales ) ) {
		/*Si el campo no está vacíollama a la función
		editar para modificar el dato o los datos a cambiar del registro*/
		$respuesta = $prestamista->insertar( $nombres,
		$primerApellido,
		$segundoApellido,
		$correoInstitucional,
		$matricula,
		$idProgramaEducativo,
		$idCargo );
		//Declarar una variable para almacenar valores en un arreglo
		echo $respuesta?"Cliente registrado":"No se pudo registrar";
	} else {
		/*Si el campo no está vacío llama a la función
		editar para modificar el dato o los datos a cambiar del registro*/
		$respuesta = $prestamista->editar( $idDatosGenerales,
		$nombres,
		$primerApellido,
		$segundoApellido,
		$correoInstitucional,
		$matricula,
		$idProgramaEducativo,
		$idCargo );
		//Declarar una variable para almacenar valores en un arreglo
		echo $respuesta?"Cliente actualizado":"No se pudo actualizar";
	}
	break;
	//---------------------------------------------------------------------------
	//Permite mostrar los valores de un registro determinado mediante su Id
	case 'mostrar':
	$respuesta = $prestamista->mostrar( $idDatosGenerales );
	echo json_encode( $respuesta );
	break;
	//---------------------------------------------------------------------------
	case 'listar':
	$respuesta = $prestamista->listar();
	$data = Array();
	//con un ciclo while se van proyectando los campos necesarios de la tabla
	while( $registro = $respuesta->fetch_object() ) {
		$data[] = array(
			/*Permite crear un botón con el valor del id del registro
			donde se llama la función para editar el campo*/
			"0"=>'<button class="btn btn-warning"
			onclick="mostrar('.$registro->idDatosGenerales.')">
			<i class="fas fa-edit"></i></button>',
			"1"=>$registro->nombres,
			"2"=>$registro->primerApellido,
			"3"=>$registro->segundoApellido,
			"4"=>$registro->matricula,
			"5"=>$registro->correoInstitucional,
			"6"=>$registro->programasEducativos,
			"7"=>$registro->cargoCliente );
		}
		//Guardar la infromacion en un arreglo
		$resultados = array(
			"sEcho"=>1, //Información para el datatables
			"iTotalRecords"=>count( $data ), //envía el total registros al datatable
			"iTotalDisplayRecords"=>count( $data ), //envía el total registros a visualizar
			"aaData"=>$data
		);
		//Enviar los datos en JSON
		echo json_encode( $resultados );
		break;
		//---------------------------------------------------------------------------
		//Función para seleccionar el programa educativo que pertenece el prestario
		case 'selecPrograma':
		//llamar el modelo
		require_once "../models/ProgramaEducativo.php";
		$programasEducativos = new ProgramaEducativo();
		$rspta = $programasEducativos->selec();
		//en listar los registros por medio del while
		while( $reg = $rspta->fetch_object() ) {
			echo '<option value=' . $reg->idProgramaEducativo . '>' . $reg->programasEducativos . '</option>';
		}
		break;
		//---------------------------------------------------------------------------
		//Case para seleccionar el cargo que desempeña el prestario
		case 'selecCargo':
		//llamar el modelo
		require_once "../models/Cargos.php";
		$cargo = new Cargos();
		$rspta = $cargo->selec();
		//en listar los registros por medio del while
		while( $reg = $rspta->fetch_object() ) {
			echo '<option value=' . $reg->idCargo. '>' . $reg->cargoCliente . '</option>';
		}
		break;
	}
	?>
