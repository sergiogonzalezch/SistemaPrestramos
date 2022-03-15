<?php
//Llamar el modelo
require_once "../models/TipoArticulo.php";
//Crear una instancia del modelo
$tipoarticulo= new TipoArticulo();
//Declarar las variables que se emplearan
$idTipoArticulo = isset($_POST["idTipoArticulo"])?
limpiarCadena($_POST["idTipoArticulo"]):"";
$tipoArticulo = isset($_POST["tipoArticulo"])?
limpiarCadena($_POST["tipoArticulo"]):"";
//---------------------------------------------------------------------------
//Switch Case para seleccionar una operación a ejecutar
switch ($_GET["op"]){
//Case para guardar y editar los datos
	case 'guardaryeditar':
		/*Secuencia If en la cual se validan si el registro está vacío mediante el id del campo.
		De ser asi se llama la función insertar para crear un nuevo registro*/
		if(empty($idTipoArticulo)){
			$respuesta =$tipoarticulo->insertar($tipoArticulo);
			echo $respuesta?"Tipo de articulo registrado":"No se pudo registrar";
		}
		/*Si el campo no está vacío llama a la función
		editar para modificar el dato o los datos a cambiar del registro*/
		else{
			$respuesta =$tipoarticulo->editar($idTipoArticulo, $tipoArticulo);
			echo $respuesta?"Tipo de articulo actualizado":"No se pudo actualizar";
		}
	break;
	//---------------------------------------------------------------------------
	//Case que permite mostrar los valores de un registro determinado mediante su Id
	case 'mostrar':
			$respuesta =$tipoarticulo->mostrar($idTipoArticulo);
			echo json_encode($respuesta);
	break;
	//---------------------------------------------------------------------------
	//Case que permite listar todos los registros de la tabla y se almacenan en un array
	case 'listar':
		$respuesta=$tipoarticulo->listar();
		$data=Array();
		while($registro=$respuesta->fetch_object()){
			$data[]=array(/*Permite crear un botón con el valor del id del registro
			donde se llama la función para editar el campo*/
			"0"=>'<button class="btn btn-warning" type="button"
			onclick="mostrar('.$registro->idTipoArticulo.')" data-toggle = "modal" href = "#myModal" data-target = "#myModal">
			<i class="fas fa-edit"></i></button>',
			"1"=>$registro->tipoArticulo,
			);
		}
		$resultados = array(
			"sEcho"=>1,//Información para el datatables
			"iTotalRecords"=>count($data),//envía el total registros al datatable
			"iTotalDisplayRecords"=>count($data),//envía el total registros a visualizar
			"aaData"=>$data
		);
		//Se envían los datos JSON
		echo json_encode($resultados);
	break;
}
?>
