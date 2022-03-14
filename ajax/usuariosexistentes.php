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
//Switch Case para selecionar una operacion a ejecturar
switch ( $_GET["op"] ) {
	/*Case para selecionar los datos personales que no esten en la tabla usaurios*/
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
	{	//De ser asi usara el elemtno actual de imagen
		$imagen = $_POST["imagenactual"];
	//Si existe el archivo sera almacenado
	} else {
		//Obtiene la extension y los datos de la imagen
		$ext = explode( ".", $_FILES["imagen"]["name"] );
		if ( $_FILES['imagen']['type'] == "image/jpg" ||
		$_FILES['imagen']['type'] == "image/jpeg" ||
		$_FILES['imagen']['type'] == "image/png" ){
			//Renombra el archivo y lo alamcena en un directorio  nuevo en el sistema
			$imagen = round( microtime( true ) ) . '.' . end( $ext );
			move_uploaded_file( $_FILES["imagen"]["tmp_name"],
			"../files/usuarios/" . $imagen );
		}
	}
	/*Encriptar el valor del input paraestablecer  la contraseña del usuario, del formulario usuario y se alamacena en una nueva variable
	Mediante una operacion evalua si el valor que recibo del input es mayo que cero*/
	if ( strlen( $contrasenaUsuario )>0 )
	/*Si es asi entonces encriptara la contraseña y la almacenara en una variable que sera usada como parametro al crear el registro, para otorgar seguridad al sistema*/
	$clavehash = hash( "SHA256", $contrasenaUsuario );
	/*Si el valor de la contraseña es vacio entonces el valor de la variable de la clavehash sera vacio, para evitar problemas de edicon en la contraseña al realizar una operacion update sobre un registro*/
	else
	$clavehash = "";
	/*Secuencia If en la cual se validan si el registro esta vacio mediante el id del campo.
	De ser asi se llama la funcion insertan para crear un nuevo registro*/
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
