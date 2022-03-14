<?php
//Llamar el modelo
require_once "../models/PrestariosExistentes.php";
$clientes = new PrestariosExistentes();
//Crear una instancia del modelo
$idClientes = isset( $_POST["idClientes"] )?limpiarCadena( $_POST["idClientes"] ):"";
$idDatosGenerales = isset( $_POST["idDatosGenerales"] )?limpiarCadena( $_POST["idDatosGenerales"] ):"";
$matricula = isset( $_POST["matricula"] )?limpiarCadena( $_POST["matricula"] ):"";
$idProgramaEducativo = isset( $_POST["idProgramaEducativo"] )?limpiarCadena( $_POST["idProgramaEducativo"] ):"";
$idCargo = isset( $_POST["idCargo"] )?limpiarCadena( $_POST["idCargo"] ):"";
//---------------------------------------------------------------------------
//Switch Case para selecionar una operacion a ejecturar
switch ( $_GET["op"] ) {
	//Case para guardar y editar los datos
	case 'guardar':
	/*Secuencia If en la cual se validan si el registro esta vacio mediante el id del campo.
	De ser asi se llama la funcion insertan para crear un nuevo registro*/
	if ( empty( $idClientes ) ) {
		/*Si el campo no esta vacio llama a la funcion
		editar para modificar el dato o los datos a cambiar del registro*/
		$respuesta = $clientes->insertar( $matricula,
		$idDatosGenerales,
		$idProgramaEducativo,
		$idCargo );
		echo $respuesta?"Cliente registrado":"No se pudo registrar";
	}
	break;
	//---------------------------------------------------------------------------
	/*Case para seleccionar el registro de los datos personales que no esten asignados
	a un registro de la tabla clientes para registrar el prestario nuevo*/
	case 'selecDato':
	//llamar el modelo
	require_once "../models/Prestarios.php";
	$dato = new Prestarios();
	$rspta = $dato->selecDato();
	//en listar los registro por medio del while
	while( $reg = $rspta->fetch_object() ) {
		echo '<option value=' . $reg->idDatosGenerales . '>' . $reg->nombre. '</option>';
	}
	break;
	//---------------------------------------------------------------------------
	//Case para seleccionar el programa educativo del prestario
	case 'selecPrograma':
	//llamar el modelo
	require_once "../models/ProgramaEducativo.php";
	$programasEducativos = new ProgramaEducativo();
	$rspta = $programasEducativos->selec();
	//en listar los registro por medio del while
	while( $reg = $rspta->fetch_object() ) {
		echo '<option value=' . $reg->idProgramaEducativo . '>' . $reg->programasEducativos . '</option>';
	}
	break;
	//---------------------------------------------------------------------------
	//Case para seleccionar el cargo que desempeña el cliente
	case 'selecCargo':
	//llamar el modelo
	require_once "../models/Cargos.php";
	$cargo = new Cargos();
	$rspta = $cargo->selec();
	//en listar los registro por medio del while
	while( $reg = $rspta->fetch_object() ) {
		echo '<option value=' . $reg->idCargo. '>' . $reg->cargoCliente . '</option>';
	}
	break;
}

?>
