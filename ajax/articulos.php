<?php
//Llamar el modelo
require_once "../models/Articulos.php";
//Crear una instancia del modelo
$articulos = new Articulos();
//Declarar la variables que se emlearan
$idArticulo = isset( $_POST["idArticulo"] )?
limpiarCadena( $_POST["idArticulo"] ):"";
$etiqueta = isset( $_POST["etiqueta"] )?
limpiarCadena( $_POST["etiqueta"] ):"";
$fechaAlta = isset( $_POST["fechaAlta"] )?
limpiarCadena( $_POST["fechaAlta"] ):"";
$numeroSerie = isset( $_POST["numeroSerie"] )?
limpiarCadena( $_POST["numeroSerie"] ):"";
$imagen = isset( $_POST["imagen"] )?
limpiarCadena( $_POST["imagen"] ):"";
$descripcion = isset( $_POST["descripcion"] )?
limpiarCadena( $_POST["descripcion"] ):"";
$codigoBarras = isset( $_POST["codigoBarras"] )?
limpiarCadena( $_POST["codigoBarras"] ):"";
$disponibilidadArticulos = isset( $_POST["disponibilidadArticulos"] )?
limpiarCadena( $_POST["disponibilidadArticulos"] ):"";
$condicionArticulo = isset( $_POST["condicionArticulo"] )?
limpiarCadena( $_POST["condicionArticulo"] ):"";
$idAnaquel = isset( $_POST["idAnaquel"] )?
limpiarCadena( $_POST["idAnaquel"] ):"";
$idTipoArticulo = isset( $_POST["idTipoArticulo"] )?
limpiarCadena( $_POST["idTipoArticulo"] ):"";
$observacionBaja = isset( $_POST["observacionBaja"] )?
limpiarCadena( $_POST["observacionBaja"] ):"";
//---------------------------------------------------------------------------
//Switch Case para selecionar una operacion a ejecturar
switch ( $_GET["op"] ) {
	//Case para guardar y editar los datos
	case 'guardaryeditar':
	//Secuencia if que determina si un archivo no existe o no fue cargado al sistema
	if ( !file_exists( $_FILES['imagen']['tmp_name'] ) ||
	!is_uploaded_file( $_FILES['imagen']['tmp_name'] ) ) {
		//De ser asi usara el elemtno actual de imagen
		$imagen = $_POST["imagenactual"];
		//Si existe el archivo sera almacenado
	} else {
		//Obtiene la extension y los datos de la imagen
		$ext = explode( ".", $_FILES["imagen"]["name"] );
		//Condcion if que verifica si es un formato de imagen valido
		if ( $_FILES['imagen']['type'] == "image/jpg" ||
		$_FILES['imagen']['type'] == "image/jpeg" ||
		$_FILES['imagen']['type'] == "image/png" ) {
			//Renombra el archivo y lo alamcena en un directorio nuevo en el sistema
			$imagen = round( microtime( true ) ) . '.' . end( $ext );
			move_uploaded_file( $_FILES["imagen"]["tmp_name"],
			"../files/articulos/" . $imagen );
		}
	}
	/*Secuencia If en la cual se validan si el registro esta vacio mediante el id del campo.
	De ser asi se llama la funcion insertan para crear un nuevo registro*/
	if ( empty( $idArticulo ) ) {
		$respuesta = $articulos->insertar( $etiqueta, $fechaAlta,
		$numeroSerie, $imagen,
		$descripcion, $codigoBarras,
		$disponibilidadArticulos,
		$condicionArticulo, $idAnaquel,
		$idTipoArticulo );
		//Declarar una variable para alamcenar valores en un arreglo
		echo $respuesta?"Articulo registrado":"No se pudo registrar";
		/*Si el campo no esta vacio llama a la funcion editar
		para modificar el dato o los datos a cambiar del registro*/
	} else {
		$respuesta = $articulos->editar( $idArticulo, $etiqueta,
		$numeroSerie, $imagen, $descripcion,
		$codigoBarras, $disponibilidadArticulos,
		$condicionArticulo, $idAnaquel,
		$idTipoArticulo );
		//Declarar una variable para alamcenar valores en un arreglo
		echo $respuesta?"Articulo actualizado":	"No se pudo actualizar";
	}
	break;
	//---------------------------------------------------------------------------
	//Case para dar de baja un articulo
	case'baja':
	//LLar el metodo baja
	$respuesta = $articulos->baja( $idArticulo, $observacionBaja );
	//Declarar una variable para alamcenar valores en un arreglo
	echo $respuesta?"Articulo en baja":"Fallo operacion baja";
	break;
	//---------------------------------------------------------------------------
	//Case para reactivar el articulo en baja
	case'reactivar':
	//Llamar el metodo reactivar
	$respuesta = $articulos->reactivar( $idArticulo );
	//Declarar una variable para alamcenar valores en un arreglo
	echo $respuesta?"Articulo en actividad otra vez":"Fallo operacion reactivar";
	break;
	//---------------------------------------------------------------------------
	//Case mostrar
	case 'mostrar':
	$respuesta = $articulos->mostrar( $idArticulo );
	echo json_encode( $respuesta );
	break;
	//---------------------------------------------------------------------------
	//Case para listar los registros de la consulta
	case 'listar':
	//Permite listar todos los registros de la tabla y se almacenan en un array
	$respuesta = $articulos->listar();
	$data = Array();
	while( $registro = $respuesta->fetch_object() ) {
		$data[] = array(
			/*Permite crear un boton con el valor del id del registro donde
			se llama la funcion para editar el campo o dar le de baja*/
			"0"=>( $registro->Disponible != 'Baja' )?
			'<button class="btn btn-warning" onclick="mostrar('.$registro->Id.')">
				<i class="fas fa-edit"></i></button>'.' <button class="btn btn-danger"
				onclick="baja('.$registro->Id.')"><i class="fas fa-times"></i></button>':
			//Boton para reactivar el articulo
			'<button class="btn btn-primary" onclick="reactivar('.$registro->Id.')">
				<i class="fas fa-check"></i></button>',
			"1"=>$registro->TipoArticulo,
			"2"=>$registro->Etiqueta,
			"3"=>$registro->AltaArticulo,
			"4"=>$registro->NumSerie,
			"5"=>$registro->Descripcion,
			"6"=>$registro->Disponible,
			/*Operacion ternaria que verifica el valor de la condicion del
			registro representado que el articulo esta en condiciones optimas*/
			"7"=>$registro->Condicion == 'Bueno'?
			/*Si el valor es igual a Bueno desplegara un span de color verde,
			con la leyenda de Bueno*/
			'<span class=" align-middle badge badge-success text-wrap" style="width: 5rem;">Bueno</span>':
			/*Operacion ternaria anidada que verifica el valor de la
			condicion del registro representado que el articulo es igual a regular*/
			( $registro->Condicion == 'Regular'?
			/*Si el valor es igual a Regular desplegara un span de color amarrillo,
			con la leyenda de Regular*/
			'<span class=" align-middle badge badge-warning text-wrap" style="width: 5rem;">Regular</span>':
			/*Si el valor no conincide con ningulo de los dos anteriores entoces,
			deplegara un span de color y la leyenda de malo, debido a que el articulo esta en mal estado*/
			'<span class=" align-middle badge badge-danger text-wrap" style="width: 5rem;">Malo</span>' ),
			"8"=>$registro->Anaquel,
			"9"=>$registro->CodigoBarras,
			"10"=>"<img src='../files/articulos/".$registro->Imagen."' height='50px' width='50px'>" );
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
		//-------------------------------------------------------------------------
		//Funcion para el seleccionar el tipo de articulo
		case 'selecTipoArticulo':
		//llamar el modelo
		require_once "../models/TipoArticulo.php";
		//crear una instancia
		$tipoArticulo = new TipoArticulo();
		$rspta = $tipoArticulo->selec();
		//ciclo while para en listar los registros
		while( $reg = $rspta->fetch_object() ) {
			echo '<option value=' . $reg->idTipoArticulo . '>' . $reg->tipoArticulo . '</option>';
		}
		break;
		//-------------------------------------------------------------------------
		//Funcion para el seleccionar Anaquel
		case 'selecAnaquel':
		//llamar el modelo
		require_once "../models/Anaquel.php";
		//crear una instancia
		$anaquel = new Anaquel();
		$rspta = $anaquel->selec();
		//ciclo while para en listar los registros
		while( $reg = $rspta->fetch_object() ) {
			echo '<option value=' . $reg->idAnaquel . '>' . $reg->anaquelNumero . '</option>';
		}
		break;
	}
	?>
