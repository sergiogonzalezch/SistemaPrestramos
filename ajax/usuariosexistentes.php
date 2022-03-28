<?php
//Llamar al modelo
require_once "../models/UsuariosExistente.php";
//Declarar las variables que se empelaran
$usuarios = new UsuariosExistente();
$idUsuarios = isset( $_POST["idUsuarios"] )?
limpiarCadena( $_POST["idUsuarios"] ):"";
$rolUsuario = isset( $_POST["rolUsuario"] )?
limpiarCadena( $_POST["rolUsuario"] ):"";
$contrasenaUsuario = isset( $_POST["contrasenaUsuario"] )?
limpiarCadena( $_POST["contrasenaUsuario"] ):"";
$aliasUsuario = isset( $_POST["aliasUsuario"] )?
limpiarCadena( $_POST["aliasUsuario"] ):"";
$imagen = isset( $_POST["imagen"] )?
limpiarCadena( $_POST["imagen"] ):"";
$idDatosGenerales = isset( $_POST["idDatosGenerales"] )?
limpiarCadena( $_POST["idDatosGenerales"] ):"";
//---------------------------------------------------------------------------
//Switch Case para seleccionar una operación a ejecutar
switch ( $_GET["op"] ) {
	/*Case para seleccionar los datos personales que no estén en la tabla usuarios*/
	case 'selecDato':
	//llamar el modelo
	require_once "../models/Usuarios.php";
	$dato = new Usuarios();
	$rspta = $dato->selecDato();
	//en listar los registro por medio del while
	while( $reg = $rspta->fetch_object() ) {
		echo '<option value=' . $reg->idDatosGenerales . '>' . $reg->nombre. '</option>';
	}
	break;
	//---------------------------------------------------------------------------
	//Case para guardar o editar los registros
	case 'guardar':
	//Secuencia if que determina si un archivo no existe o no fue cargado al sistema
	if ( !file_exists( $_FILES['imagen']['tmp_name'] ) ||
	!is_uploaded_file( $_FILES['imagen']['tmp_name'] ) )
	{	//De ser así usara el elemento actual de imagen
		$imagen = $_POST["imagenActual"];
	//Si existe el archivo será almacenado
	} else {
		//Obtiene la extensión y los datos de la imagen
		$ext = explode( ".", $_FILES["imagen"]["name"] );
		if ( $_FILES['imagen']['type'] == "image/jpg" ||
		$_FILES['imagen']['type'] == "image/jpeg" ||
		$_FILES['imagen']['type'] == "image/png" ){
			//Renombra el archivo y lo almacena en un directorio  nuevo en el sistema
			$imagen = round( microtime( true ) ) . '.' . end( $ext );
			move_uploaded_file( $_FILES["imagen"]["tmp_name"],
			"../files/usuarios/" . $imagen );
		}
	}
	/*Encriptar el valor del input para establecer la contraseña del usuario,
	del formulario usuario y se almacena en una nueva variable
	Mediante una operación evalúa si el valor que recibo del input es mayor que cero*/
	if ( strlen( $contrasenaUsuario )>0 )
	/*Si es asi entonces encriptará la contraseña y la almacenará en una variable
	que será usada como parámetro al crear el registro, para otorgar seguridad al sistema*/
	$clavehash = hash( "SHA256", $contrasenaUsuario );
	/*Si el valor de la contraseña es vacíoentonces el valor de la variable de la
	clavehash será vacio, para evitar problemas de edición en la contraseña al
	realizar una operación update sobre un registro*/
	else
	$clavehash = "";
	/*Secuencia If en la cual se valida si el registro esta vacío mediante el id del campo.
	De ser así se llama la función insertar para crear un nuevo registro*/
	if ( empty( $idUsuarios ) ) {
		$respuesta = $usuarios->insertar( $rolUsuario,
		$clavehash,
		$aliasUsuario,
		$imagen,
		$idDatosGenerales );
		echo $respuesta?"Usuario registrado":"No se pudo registrar";
	}
	break;
}
?>
