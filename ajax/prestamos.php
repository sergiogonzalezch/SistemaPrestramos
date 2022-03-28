<?php
//Establcer una sesión para obtenr infromacion de la sesión del usuario
session_start();
//Llamar el modelo
require_once "../models/Prestamos.php";
//Crear una instancia del modelo
$prestamos = new Prestamos();
//Declarar las variables que se usaran
$idPrestamo = isset( $_POST["idPrestamo"] )?
limpiarCadena( $_POST["idPrestamo"] ):"";
$edificio = isset( $_POST["edificio"] )?
limpiarCadena( $_POST["edificio"] ):"";
$tipoArea = isset( $_POST["tipoArea"] )?
limpiarCadena( $_POST["tipoArea"] ):"";
$descripcionArea = isset( $_POST["descripcionArea"] )?
limpiarCadena( $_POST["descripcionArea"] ):"";
$idClientes = isset( $_POST["idClientes"] )?
limpiarCadena( $_POST["idClientes"] ):"";
$fecha = isset( $_POST["fecha"] )?
limpiarCadena( $_POST["fecha"] ):"";
$fechaE = isset( $_POST["fechaE"] )?
limpiarCadena( $_POST["fechaE"] ):"";
$idArticuloPrestamo = isset( $_POST["idArticuloPrestamo"] )?
limpiarCadena( $_POST["idArticuloPrestamo"] ):"";
$condicionDevolucion = isset( $_POST["condicionDevolucion"] )?
limpiarCadena( $_POST["condicionDevolucion"] ):"";
$observacionDevolucion = isset( $_POST["observacionDevolucion"] )?
limpiarCadena( $_POST["observacionDevolucion"] ):"";
$fechaS = isset( $_POST["fechaS"] )?
limpiarCadena( $_POST["fechaS"] ):"";
$idUsuario = $_SESSION['usuarios']['idUsuarios'];
//---------------------------------------------------------------------------
//Switch Case para seleccionar una operación a ejecutar
switch ( $_GET["op"] ) {
	//Case para guardar y cerrar los prestamos
	case 'guardarycerrar':
	/*Secuencia If en la cual se validan si el registro está vacío mediante el id del campo.
	De ser así se llama la función insertar para crear un nuevo registro*/
	if ( empty( $idPrestamo ) ) {
		//Declarar la zona horaria
		$time = date_default_timezone_set( 'America/Mexico_city' );
		//Almacenar la fecha
		$fecha = date( 'Y-m-d' );
		//Llamar el metodo insertar
		$respuesta = $prestamos->insertar( $edificio,
		$tipoArea,
		$descripcionArea,
		$fecha, $idClientes,
		//Recibir el idArticulo mediante post
		$_POST["idArticulo"],
		$fecha,
		//Recibir la condición mediante post
		$_POST["condicionEntrega"],
		$fecha,
		$idUsuario );
		//Mediante una operación ternaria evalúa si la operación fue exitosa o no.
		echo $respuesta?"Prestamo registrado":"No se pudo registrar";
	/*Si el campo no está vacío llama a la función
	cerrar para finalizar el préstamo modificando sus datos*/
	} else {
		//Declarar la zona horaria
		$time = date_default_timezone_set( 'America/Mexico_city' );
		//Almacenar la fecha
		$fecha = date( 'Y-m-d' );
		//Llamar el metodo cerrar
		$respuesta = $prestamos->cerrar( $idPrestamo,
		$fecha,
		$fecha,
		$idUsuario );
		//Mediante una operación ternaria evalúa si la operación fue exitosa o no.
		echo $respuesta?"Prestamo cerrado":"Error al cerrar el registro";
	}
	break;
	//---------------------------------------------------------------------------
	//Permite mostrar los valores de un registro determinado mediante su Id
	case 'mostrar':
	//Llamar la función
	$respuesta = $prestamos->mostrar( $idPrestamo );
	//Enviar los valores mediante JSON
	echo json_encode( $respuesta );
	//Llamar la función listar de detalle para visualizar los datos de los artículo prestados
	$rspt = $prestamos->listarDetalle( $idPrestamo );
	break;
	//---------------------------------------------------------------------------
	//Función para seleccionar un cliente
	case 'selecCliente':
	//Importar el modelo
	require_once "../models/Prestarios.php";
	//Crear instancial del modelo
	$clientes = new Prestarios();
	//llamar el metodo de la clase externa
	$rspta = $clientes->selec();
	//Enlistar los registros por medio del while
	while( $reg = $rspta->fetch_object() ) {
		//Mediante echo crear un elemento HTML con los valores de la consulta del metodo
		echo '<option value=' . $reg->idClientes. '>' . $reg->nombre . '</option>';
	}
	break;
	//---------------------------------------------------------------------------
	//Case listar
	case 'listar':
	//Declarar las variables como parámetros para rango de fechas
	$fechaInicio = $_REQUEST["fechaInicio"];
	$fechaFin = $_REQUEST["fechaFin"];
	//Llamar el metodo listar
	$respuesta = $prestamos->listar( $fechaInicio, $fechaFin );
	//Declarar una variable para hacer funciones de arreglo
	$data = Array();
	while( $registro = $respuesta->fetch_object() ) {
		$data[] = array(
			/*Permite crear un botón con el valor del id del registro
			donde se llama la función para editar el campo*/
			/*Operador ternario que   evalúa   el valor del campo Estatus*/
			"0"=>$registro->Estatus == 'Aceptado'?
			/*Si el valor del campo es igual a Aceptado entonces se visualizarán dos botones HTML
			concatenados un permitira las funciones para mostrar con onclick mostrar
			y el id del registro la información de los préstamos.
			Y el segundo botón para realizar el cierre y devolución de los
			artículos con onclick devolucion y el id del préstamo*/
			'<button class="btn btn-primary" onclick="mostrar('.$registro->Id.')"><i class="fas fa-eye"></i></button>'.' <button class="btn btn-success" onclick="devolucion('.$registro->Id.')"><i class="fas fa-check"></i></button>':
			/*Si el valor del campo es diferente de Aceptado entonces se visualizarán dos elementos HTML
			concatenados un permitira las funciones para mostrar con el evento onclick mostrar
			y el id del registro la información de los préstamos.
			Y el segundo botón será un elemento de tipo enlace con propiedades de botón y
			permite llamar a un archivo php de la carpeta reportes para desplegar
			la información de los préstamos en un archivo PDF al recibir id del préstamo*/
			'<button class="btn btn-primary" onclick="mostrar('.$registro->Id.')"><i class="fas fa-eye"></i></button>'.
			' <a target="_blank" type="button" class="btn btn-info" href="../reportes/rptpdetalles.php?Id='.$registro->Id.'"><i class="fas fa-download"></i></a>',
			"1"=>$registro->Folio,
			"2"=>$registro->Año,
			"3"=>$registro->Mes,
			"4"=>$registro->Dia,
			"5"=>$registro->Nombre,
			"6"=>$registro->Edificio,
			"7"=>$registro->Area,
			"8"=>$registro->Descripcion,
			/*Operador ternario que   evalúa   el valor del campo Estatus, para desplegar un texto editado según el estatus del prestamos*/
			"9"=>$registro->Estatus == 'Aceptado'?
			/*Si el valor del campo es igual a "Aceptado" entonces desplegara un
			span de color amarrillo con el texto que dice "En préstamo" dando a
			entender que el préstamo esta vigente*/
			'<span class="align-middle badge badge-warning text-wrap">En préstamo</span>':
			/*Si el valor es diferente, entonces desplegara un span de color verde
			con el texto "Concluido"" dando a entender que el préstamo a sido finalizado*/
			'<span class="align-middle badge badge-success text-wrap">Concluido</span>'
		);
	}
	//Almacenar los datos en un arreglo
	$resultados = array(
		"sEcho"=>1, //Información para el datatables
		"iTotalRecords"=>count( $data ), //envía el total registros al datatable
		"iTotalDisplayRecords"=>count( $data ), //envía el total registros a visualizar
		"aaData"=>$data
	);
	//Se envían los datos JSON
	echo json_encode( $resultados );
	break;
	//---------------------------------------------------------------------------
	//Función que permite listar los articulos que estén disponibles para ser prestados
	case 'listarDisponibles':
	//Importar el modelo
	require_once "../models/Articulos.php";
	//Crear instancia del modelo
	$articulos = new Articulos();
	//Llamar la función del modelo externo
	$respuesta = $articulos->listarDisponibles();
	//Declarar una variable para funciones de arreglo
	$data = Array();
	while( $registro = $respuesta->fetch_object() ) {
		$data[] = array(
			/*Permite crear un botón HTML, que tiene como propósito agregar
			el articulo al registro mediante el evento onclick llamando a la
			función agregraArticuloPrestamo*/
			"0"=>'<button class="btn btn-success" onclick="agregarArticuloPrestamo
					('.$registro->Id.',\''.$registro->Etiqueta.'\')"><i class="fas fa-plus"></i></button>',
			"1"=>$registro->TipoArticulo,
			"2"=>$registro->Etiqueta,
			/*Operación ternaria que verifica el valor de la condición del
			registro representado que el artículo esta en condiciones óptimas*/
			"3"=>$registro->Condicion == 'Bueno'?
			/*Si el valor es igual a Bueno desplegara un span de color verde,
			con la leyenda de Bueno*/
			'<span class="align-middle badge badge-success text-wrap">Bueno</span>':
			/*Operación ternaria anidada que verifica el valor de la
			condición del registro representado que el artículo es igual a regular*/
			( $registro->Condicion == 'Regular'?
			/*Si el valor es igual a Regular desplegara un span de color amarrillo,
			con la leyenda de Regular*/
			'<span class="align-middle badge badge-warning text-wrap">Regular</span>':
			/*Si el valor no coincide con ninguno de los dos anteriores entonces,
			desplegara un span de color y la leyenda de malo, debido a que el
			artículo está en mal estado*/
			'<span class="align-middle badge badge-danger text-wrap">Malo</span>' ),
			"4"=>$registro->Anaquel,
			"5"=>$registro->CodigoBarras );
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
		//-------------------------------------------------------------------------
		/*Permite listar los artículos prestados y sus datos de entrega
		como los datos delavolución*/
		case 'listarDetalle':
		//Obtener el id del registro articuloprestamo
		$id = $_GET["id"];
		//Llamar el metodo y enviar el id del registro artiuloprestamo
		$respuesta = $prestamos->listarDetalle( $id );
		/*Despliega un elemento HTML de tipo tabla, para visualizar las cabeceras
		de cada una de las celdas y los campos con información de los
		artículos prestados en el registro del préstamo*/
		echo 	'<thead class="filas">
					<th>Préstamo</th>
					<th>Artículo</th>
					<th>Entregado</th>
					<th>Condición de entrega</th>
					<th>Devuelto</th>
					<th>Devolución</th>
					<th>Condición de devolución</th>
					<th>Observaciones</th>
				</thead>';
		/*Mediante un ciclo while los valores serán desplegados en celda con código php
		adentro para visualizar los valores respectivos en las celdas
		dentro del arreglo del comando mysqli_fetch_assoc*/
		while( $registro = mysqli_fetch_assoc( $respuesta ) ) {
			?>
<tr class="filas" id="<?php echo $registro['idPrestamo']?>">
	<td><?php echo $registro['idPrestamo'];
			?></td>
	<td><?php echo $registro['etiqueta'];
			?></td>
	<td><?php echo $registro['fechaEntrega'];
			?></td>
	<td><?php echo $registro['condicionEntrega'];
			?></td>

	<?php /*Realiza una operación ternaria donde si el valor de devuelto es igual a uno
	desplegara un span de color verde con la leyenda Devuelto.
	Caso contrario visualizar un span rojo con el texto No Devuelt0*/
			echo( $registro['devuelto'] == 1 )?'<td><span class="align-middle badge badge-success text-wrap"><i class=" fas fa-check"></i> Devuelto</span></td>':
			'<td><span class="align-middle badge badge-danger text-wrap"><i class="fas fa-times"></i> No Devuelto</span></td>';
			?>
	<td><?php echo $registro['fechaDevolucion'];
			?></td>
	<td><?php echo $registro['condicionDevolucion'];
			?></td>
	<td><?php echo $registro['observacionDevolucion'];
			?></td>
</tr>;
<?php
		}
		break;
		//-------------------------------------------------------------------------
		//Permite listar los artículos prestados a devolver de un prestamo en especifico
		case 'listarDevolucion':
		//Operación get, para obtener el id del préstamo
		$id = $_GET["id"];
		//Llamar el metodo y enviar el id del préstamo
		$respuesta = $prestamos->listarDevolucion( $id );
		/*Despliega un elemento HTML de tipo tabla, para visualizar las cabeceras
		de cada una de las celdas y los campos con información de los
		artículos prestados en el registro del préstamo*/
		echo '<thead class="filas">
			<th>Opciones</th>
			<th>Artículo</th>
			<th>Fecha de entrega</th>
			<th>Condiciones de entrega</th>
			</thead>';
		/*Mediante un ciclo while los valores serán desplegados en celda con
		código php adentro para visualizar los valores respectivos en las celdas
		dentro del arreglo del comando mysqli_fetch_assoc*/
		while( $registro = mysqli_fetch_assoc( $respuesta ) ) {
			?>
<tr class="filas" id="<?php echo $registro['idPrestamo']?>">
	<?php	/*Crea un enlace HTML con propiedades de botón para desplegar un modal con un
	formulario que permite registrar y actualizar la devolución de los artículos
	al recibir el id del registro articulosprestamos ( idArticuloPrestamo )*/
			echo '<td><a type = "button" name = "devolucion"  data-toggle = "modal" href = "#modalDevolucion" data-target = "#modalDevolucion" class = "btn btn-success" onclick = "obtenerDevolucion('.$registro['idArticuloPrestamo'].')"><i class = "fas fa-check"></i> Devolver</a></td>';
			?>
	<td><?php echo $registro['etiqueta'];
			?></td>
	<td><?php echo $registro['fechaEntrega'];
			?></td>
	<td><?php echo $registro['condicionEntrega'];
			?></td>
</tr>';
<?php
		}
		break;
		//-------------------------------------------------------------------------
		//Permite los datos de devolución de los artículos que fueron prestados
		case'obtenerDevolucion':
		$respuesta = $prestamos->datosDevolucionPorId(
		//Mediante el metodo post, devolverá los valores de los registros
		$_POST["idArticuloPrestamo"] );
		while( $registro = mysqli_fetch_assoc( $respuesta ) ) {
			$data[] = array(
				"0"=>$registro['idArticuloPrestamo'],
				"1"=>$registro['condicionDevolucion'],
				"2"=>$registro['observacionDevolucion'],
				"3"=>$registro['idArticulo'] );
			}
			//Almacenar en un arreglo
			$resultados = array(
				"sEcho"=>1,//Información para el datatables
				"iTotalRecords"=>count( $data ),//envía el total registros al datatable
				"iTotalDisplayRecords"=>count( $data ),//envía el total registros a visualizar
				"aaData"=>$data
			);
			//Se envían los datos JSON
			echo json_encode( $data );
			break;
		//-------------------------------------------------------------------------
		//Permite registrar los datos de devolución de los artículos prestados
			case'devolver':
		//Mediante una función if valida si fue enviado el idArticulosPrestamos del registro
			if ( isset( $_POST['idAP'] ) ) {
			//Valida si recibió valores de los inputs, para realizar la actualización del registro
				if ( !empty( $_POST['condicion'] ) && !empty( $_POST['observacion'] ) && !empty( $_POST['idA'] ) ) {
					$idAP = $_POST['idAP'];
					$time = date_default_timezone_set( 'America/Mexico_city' );
					$fecha = date( 'Y-m-d' );
					$condicion = $_POST['condicion'];
					$observacion = $_POST['observacion'];
					$idA = $_POST['idA'];
			$respuesta = $prestamos->devolver( $idAP, $fecha,
			$condicion, $observacion,
			$idA );
			//Si se cumplieron las condiciones de los if, entonces al terminar la actualización devolverá el valor de 1
			echo 1;
		} else {
			//Si no se cumplió la condición entonces devolverá el valor de cero
			echo 0;
		}
		//Si no fue enviado el id, devolverá un valor de cero
	} else {
		echo 0;
	}
	break;
}

?>
