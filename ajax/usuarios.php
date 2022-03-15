<?php
//Crear la sesión
session_start();
//Llamar al modelo
require_once "../models/Usuarios.php";
//Declarar las variables que se empelaran
$usuarios = new Usuarios();
$idDatosGenerales = isset( $_POST["idDatosGenerales"] )?
limpiarCadena( $_POST["idDatosGenerales"] ):"";
$nombres = isset( $_POST["nombres"] )?
limpiarCadena( $_POST["nombres"] ):"";
$primerApellido = isset( $_POST["primerApellido"] )?
limpiarCadena( $_POST["primerApellido"] ):"";
$segundoApellido = isset( $_POST["segundoApellido"] )?
limpiarCadena( $_POST["segundoApellido"] ):"";
$correoInstitucional = isset( $_POST["correoInstitucional"] )?
limpiarCadena( $_POST["correoInstitucional"] ):"";
$rolUsuario = isset( $_POST["rolUsuario"] )?
limpiarCadena( $_POST["rolUsuario"] ):"";
$contrasenaUsuario = isset( $_POST["contrasenaUsuario"] )?
limpiarCadena( $_POST["contrasenaUsuario"] ):"";
$aliasUsuario = isset( $_POST["aliasUsuario"] )?
limpiarCadena( $_POST["aliasUsuario"] ):"";
$imagen = isset( $_POST["imagen"] )?
limpiarCadena( $_POST["imagen"] ):"";
//---------------------------------------------------------------------------
//Switch Case para seleccionar una operación a ejecutar
switch ( $_GET["op"] ) {
	//Case para guardar o editar los registros
	case 'guardaryeditar':
	//Secuencia if que determina si un archivo no existe o no fue cargado al sistema
	if ( !file_exists( $_FILES['imagen']['tmp_name'] ) ||
	!is_uploaded_file( $_FILES['imagen']['tmp_name'] ) )
	{
		//De ser así usara el elemento actual de imagen
		$imagen = $_POST["imagenactual"];
	//Si existe el archivo será almacenado
	} else {
		//Obtiene la extensión y los datos de la imagen
		$ext = explode( ".", $_FILES["imagen"]["name"] );
		if ( $_FILES['imagen']['type'] == "image/jpg" ||
		$_FILES['imagen']['type'] == "image/jpeg" ||
		$_FILES['imagen']['type'] == "image/png" ){
			//Renombra el archivo y lo almacena en un directorio nuevo en el sistema
			$imagen = round( microtime( true ) ) . '.' . end( $ext );
			move_uploaded_file( $_FILES["imagen"]["tmp_name"],
			"../files/usuarios/" . $imagen );
		}
	}
	/*Encriptar el valor del input para establecer la contraseña del usuario, del formulario usuario y se almacena  en una nueva variable
	Mediante una operación evalúa si el valor que recibo del input es mayor que cero*/
	if ( strlen( $contrasenaUsuario )>0 )
	/*Si es así entonces encriptará la contraseña y la almacenará en una variable que será usada como parámetro al crear el registro, para otorgar seguridad al sistema*/
	$clavehash = hash( "SHA256", $contrasenaUsuario );
	else
	/*Si el valor de la contraseña es vacío entonces el valor de la variable de la clavehash será vacío, para evitar problemas de edición en la contraseña al realizar una operación update sobre un registro*/
	$clavehash = "";
	/*Secuencia If en la cual se valida si el registro está vacío  mediante el id del campo.
	De ser asi se llama la función insertar para crear un nuevo registro*/
	if ( empty( $idDatosGenerales ) ) {
		$respuesta = $usuarios->insertar(
			$nombres,
			$primerApellido,
			$segundoApellido,
			$correoInstitucional,
			$rolUsuario,
			$clavehash,
			$aliasUsuario,
			$imagen );
			echo $respuesta?"Usuario registrado":"No se pudo registrar";
		/*Si el campo no está vacío llamara a la función editar
		para modificar el dato o los datos a cambiar del registro*/
		} else {
			$respuesta = $usuarios->editar( $idDatosGenerales,
			$nombres,
			$primerApellido,
			$segundoApellido,
			$correoInstitucional,
			$rolUsuario,
			$clavehash,
			$aliasUsuario,
			$imagen );
			echo $respuesta?"Usuario actualizado":"No se pudo actualizar";
		}
		break;
		//---------------------------------------------------------------------------
		//Permite mostrar los valores de un registro determinado mediante su Id
		case 'mostrar':
		$respuesta = $usuarios->mostrar( $idDatosGenerales );
		echo json_encode( $respuesta );
		break;
		//---------------------------------------------------------------------------
		//Case para listar los registros de la consulta
		case 'listar':
		$respuesta = $usuarios->listar();
		$data = Array();
		//con un ciclo while se van proyectando los campos necesarios de la tabla
		while( $registro = $respuesta->fetch_object() ) {
			$data[] = array(
				"0"=>'<button class="btn btn-warning"
			onclick="mostrar('.$registro->idDatosGenerales.')">
			<i class="fas fa-edit"></i></button>',
				"1"=>$registro->nombres,
				"2"=>$registro->primerApellido,
				"3"=>$registro->segundoApellido,
				"4"=>$registro->rolUsuario,
				"5"=>$registro->aliasUsuario,
				"6"=>$registro->correoInstitucional,
				"7"=>"<img src='../files/usuarios/".$registro->imagen."' height='auto' width='30%' >" );
			}
			$resultados = array(
				"sEcho"=>1,
				"iTotalRecords"=>count( $data ),
				"iTotalDisplayRecords"=>count( $data ),
				"aaData"=>$data
			);
			echo json_encode( $resultados );
			break;
			//---------------------------------------------------------------------------
			//Verificar que exista el usuario
			case 'verificar':
			//Recibir los valores del formulario del login
			$alias = $_POST['alias'];
			$contrasena = $_POST['contrasena'];
			//Encriptar la contraseña del login
			$clavehash = hash( "SHA256", $contrasena );
			//Verificar si ambas contraseñas encirptadas sean identicas
			$respuesta = $usuarios->verificar( $alias, $clavehash );
			//Si existe una coincidencia
			if ( $respuesta->num_rows>0 ):
			//De ser así almacenará los valores en un arreglo fetch assoc
			$datos = $respuesta->fetch_assoc();
			//Valida si los datos fueron enviados
			if ( isset( $datos ) ) {
				//Validar si el rol del usuario es diferente de retirado
				if ($datos['rolUsuario']!="Retirado"){
					//Si es diferente de retirado entonces creara la sesión del usuario
					$_SESSION['usuarios'] = $datos;
				}
			}
			/*Si no hubo error entonce enviara un mensaje de error con valor falso (false) y
			el valor del rol del usuario para verificar los accesos que tendrá el usuario*/
			echo json_encode( array( 'error'=>false, 'rol'=>$datos['rolUsuario'] ) );
			else:
			//De haber un problema enviara un valor de error que sea igual a verdadero (true)
			echo json_encode( array( 'error'=>true ) );
			endif;
			break;
			//---------------------------------------------------------------------------
			//Case salir, para cerrar la sesión de usuario y redirigir al index
			case 'salir':
			//Limpiar
			session_unset();
			//Destruir sesión
			session_destroy();
			header( "Location: ../index.php" );
			break;
		}
		?>
