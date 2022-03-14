<?php
//Incluir la conexion a la base de datos
require "../config/conexion.php";
Class Usuarios {
	//Constructor
	public function _construct() {
	}
	//Metodos para insertar
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@public
	* Metodo que permite registrar un nuevo usuario,
	* para acceder al sistema.
	* @param  string $nombres  Parametro que almacena la informacion del nombre( s ) de la persona a registrar
	* @param  string $primerApellido parametro que recibe el primer apellido de la persona
	* @param  string $segundoApellido parametro que recibe el segundo apellido de la persona
	* @param  string $correoInstitucional recibe como valor el correo de contacto de la persona
	* @param  string $rolUsuario   rol que desempeñara en el sistema sea un
	* administrador o prestamista
	* @param  string $contrasenaUsuario contraseña del usuario
	* @param  string $aliasUsuario  nombre con el cual el usuario estara dentro del sistema
	* @param  string $imagen  nombre de la imagen
	* @param  integer $idDatosGenerales  id que permite la relacion entre los datos
	* del usuario y los datos gernerales
	* @return Retorna una ejecucion SQL
	*/

	public function insertar( $nombres,
	$primerApellido,
	$segundoApellido,
	$correoInstitucional,
	$rolUsuario,
	$contrasenaUsuario,
	$aliasUsuario,
	$imagen ) {
		$sqlDatos = "INSERT INTO datosgenerales
		(nombres,
		primerApellido,
		segundoApellido,
		correoInstitucional)
		VALUES
		('$nombres',
		'$primerApellido',
		'$segundoApellido',
		'$correoInstitucional')";
		//return ejecutarConsulta( $sql );
		$idPersona = ejecutarConsulta_retornarID( $sqlDatos );
		$sqlUsuario = "INSERT INTO usuarios(rolUsuario,
		contrasenaUsuario,
		aliasUsuario,
		imagen,
		idDatosGenerales)
		VALUES ('$rolUsuario',
		'$contrasenaUsuario',
		'$aliasUsuario',
		'$imagen',
		'$idPersona')";
		return ejecutarConsulta( $sqlUsuario );
	}
	//Metodos para editar registros
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@public
	* Metodos para editar el registro de la tabla,
	* segun el valor del id del registro a modificar, junto con los parametros
	* requeridos a modificar, mediante el uso de una funcion SQL UPDATE
	* @param  integer $idUsuarios Recibe el id del registro de la tabla usuario para editar
	* @param  string $nombres  Parametro que almacena la informacion del nombre( s ) de la persona a registrar
	* @param  string $primerApellido parametro que recibe el primer apellido de la persona
	* @param  string $segundoApellido parametro que recibe el segundo apellido de la persona
	* @param  string $correoInstitucional recibe como valor el correo de contacto de la persona
	* @param  string $rolUsuario   rol que desempeñara en el sistema sea un
	* administrador o prestamista
	* @param  string $contrasenaUsuario contraseña del usuario
	* @param  string $aliasUsuario  nombre con el cual el usuario estara dentro del sistema
	* @param  string $imagen  nombre de la imagen
	* @param  integer $idDatosGenerales  id que permite la relacion entre los datos
	* del usuario y los datos gernerales
	* @return Retorna una ejecucion SQL
	*/

	public function editar( $idDatosGenerales,
	$nombres,
	$primerApellido,
	$segundoApellido,
	$correoInstitucional,
	$rolUsuario,
	$contrasenaUsuario,
	$aliasUsuario,
	$imagen ) {
		$sqlDatos = "UPDATE datosgenerales SET
		nombres='$nombres',
		primerApellido='$primerApellido',
		segundoApellido='$segundoApellido',
		correoInstitucional='$correoInstitucional'
		WHERE idDatosGenerales='$idDatosGenerales'";
		ejecutarConsulta( $sqlDatos );
	if ( strlen( $contrasenaUsuario )>0 )
		$sql = "UPDATE usuarios SET rolUsuario='$rolUsuario',
		contrasenaUsuario='$contrasenaUsuario',
		aliasUsuario='$aliasUsuario',
		imagen='$imagen'
		WHERE idDatosGenerales='$idDatosGenerales'";
		else
		$sql = "UPDATE usuarios SET rolUsuario='$rolUsuario',
		aliasUsuario='$aliasUsuario',
		imagen='$imagen'
		WHERE idDatosGenerales='$idDatosGenerales'";
		return ejecutarConsulta( $sql );}



	//Metodo que muestra un regirso en especifico
	/**
	* @author Sergio Gpe. Gonzalez Chavez
	* @public
	* Permite selecccionar los campos de un registro al recibir el id, del
	* registro como parametro y el uso de SELECT*FROM, para seleccionar toda la fila
	* @param  integer $idAnaquel Recibe el id del registro a mostrar sus datos
	* @return Retorna una ejecucion SQL
	*/

	public function mostrar( $idDatosGenerales ) {
		$sqlDatos = "SELECT datosgenerales.idDatosGenerales,
		datosgenerales.nombres,
		datosGenerales.primerApellido,
		datosGenerales.segundoApellido,
		datosgenerales.correoInstitucional,
		usuarios.aliasUsuario,
		usuarios.rolUsuario,
		usuarios.imagen
		FROM datosgenerales INNER JOIN Usuarios ON
		datosgenerales.idDatosGenerales = Usuarios.idDatosGenerales
		WHERE datosgenerales.idDatosGenerales ='$idDatosGenerales'";
		return ejecutarConsultaSimpleFila( $sqlDatos );
	}
	//Metodo para enlistar los registros
	/**
	* @author Sergio Gpe. Gonzalez Chavez
	* @public
	* Selecciona todos los registros de la tabla haciendo uso de SELECT*FROM,
	* junto con datos de otras tablas mediante inner join
	* @return Retorna una ejecucion SQL
	*/

	public function listar() {
		$sql = "SELECT usuarios.idDatosGenerales,
		datosgenerales.nombres,
		datosGenerales.primerApellido,
		datosGenerales.segundoApellido,
		datosgenerales.correoInstitucional,
		usuarios.aliasUsuario,
		usuarios.rolUsuario,
		usuarios.imagen
		FROM datosgenerales INNER JOIN Usuarios ON
		datosgenerales.idDatosGenerales = Usuarios.idDatosGenerales";
		return ejecutarConsulta( $sql );
	}
	//Metodo para verificar la existencia del usuario
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	* @public
	* Metodo, que permite la validacion si existe el registro del
	* usuario al recibir el alias y la contraseña de usuario, este
	* metodo es utilizado para el login
	* @param  string $contrasenaUsuario contraseña del usuario
	* @param  string $aliasUsuario  nombre con el cual el usuario estara dentro del sistema
	* @return Retorna una ejecucion SQL
	*/

	public function verificar( $aliasUsuario, $contrasenaUsuario ) {
		//Retrasar dos segundos la validacion
		sleep(1);
		$sql = "SELECT idUsuarios,
		rolUsuario,
		aliasUsuario,
		imagen
		FROM usuarios
		WHERE aliasUsuario ='$aliasUsuario'
		AND contrasenaUsuario='$contrasenaUsuario'";
		return ejecutarConsulta( $sql );
	}

	public function selecDato() {
		$sql = "SELECT datosgenerales.idDatosGenerales, CONCAT(datosgenerales.nombres,' ', datosgenerales.primerApellido,' ', datosgenerales.segundoApellido)AS nombre FROM datosgenerales WHERE NOT EXISTS( SELECT*FROM usuarios WHERE datosgenerales.idDatosGenerales=usuarios.idDatosGenerales);";
		return ejecutarConsulta( $sql );
	}
}
?>
