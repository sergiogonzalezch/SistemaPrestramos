<?php
//Incluir la conexion a la base de datos
require "../config/conexion.php";
Class Prestarios {
	//Constructor

	public function _construct() {
	}
	//Metodos para insertar
	/**
	 *@author Sergio Gpe. Gonzalez Chavez
	 *@public
	 *Recibe como parametros nombre, primer apaellido, segundo apellido y correo institucional para crear el registro crear un registro de datos personales, haciendo uso de una funcion SQL INSERT
	 * @param  string $nombres  Parametro que almacena la informacion del nombre( s ) de la persona a registrar
	 * @param  string $primerApellido parametro que recibe el primer apellido de la persona
	 * @param  string $segundoApellido parametro que recibe el segundo apellido de la persona
	 * @param  string $correoInstitucional recibe como valor el correo de contacto de la persona
	 * @param  integer $matricula recibe el numero de empleado del solicitante
	 * @param  integer $idProgramaEducativo clave foranea del programa educativo al que pertenece
	 * @param  integer $idCargo clave foranea del cargo al que pertenece
	 * @return Retorna una ejecucion SQL
	 */
	public function insertar( $nombres,
	$primerApellido,
	$segundoApellido,
	$correoInstitucional,
	$matricula,
	$idProgramaEducativo,
	$idCargo ) {
		//Insertar datos generales de la persona
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
		//almacena el id del nuevo registreo en una variable al ejecutar la consulta que retorna el id
		$idPersona = ejecutarConsulta_retornarID( $sqlDatos );
		//Codigo para insertar los datos a la tabla cliente
		$sqlCliente = "INSERT INTO clientes
			(matricula,
			idDatosGenerales,
			idProgramaEducativo,
			idCargo)
		VALUES
			('$matricula',
			'$idPersona',
			'$idProgramaEducativo',
			'$idCargo')";
		return ejecutarConsulta( $sqlCliente );

	}
	//Metodos para editar registros
	/**
	* @author Sergio Gpe. Gonzalez Chavez
	* @public
	Metodos para editar el registro de la tabla,
	* segun el valor del id del registro a modificar, junto con los parametros requeridos a modificar, mediante el uso de una funcion SQL UPDATE
	* @param  integer $idDatosGenerales  Recibe el id del registro de la tabla datosgenerales para editar
	* @param  string $nombres  Parametro que almacena la informacion del nombre( s ) de la persona a registrar
	* @param  string $primerApellido parametro que recibe el primer apellido de la persona
	* @param  string $segundoApellido parametro que recibe el segundo apellido de la persona
	* @param  string $correoInstitucional recibe como valor el correo de contacto de la persona
	* @param  integer $matricula recibe el numero de empleado del solicitante
	* @param  integer $idProgramaEducativo clave foranea del programa educativo al que pertenece
	* @param  integer $idCargo clave foranea del cargo al que pertenece
	* @return Retorna una ejecucion SQL
	*/

	public function editar( $idDatosGenerales,
	$nombres,
	$primerApellido,
	$segundoApellido,
	$correoInstitucional,
	$matricula,
	$idProgramaEducativo,
	$idCargo ) {
		$sqlDatos = "UPDATE datosgenerales SET
		nombres='$nombres',
		primerApellido='$primerApellido',
		segundoApellido='$segundoApellido',
		correoInstitucional='$correoInstitucional'
		WHERE idDatosGenerales='$idDatosGenerales'";
		ejecutarConsulta( $sqlDatos );
		$sqlCliente = "UPDATE clientes SET
		matricula='$matricula',
		idProgramaEducativo='$idProgramaEducativo',
		idCargo='$idCargo'
		WHERE clientes.idDatosGenerales='$idDatosGenerales'";
		return ejecutarConsulta( $sqlCliente );
	}
	//Metodo que muestra un regirso en especifico
	/**
	* @author Sergio Gpe. Gonzalez Chavez
	* @public
	* Permite selecccionar los campos de un registro al recibir el id, del registro como parametro y el uso de SELECT*FROM, para seleccionar toda la fila
	* @param  integer $idDatosGenerales Recibe el id del registro a mostrar sus datos
	* @return Retorna una ejecucion SQL
	*/

	public function mostrar( $idDatosGenerales ) {
		$sqlDatos = "SELECT
		datosgenerales.idDatosGenerales,
		datosgenerales.nombres,
		datosgenerales.primerApellido,
		datosgenerales.segundoApellido,
		clientes.matricula,
		datosgenerales.correoInstitucional,
		programaeducativo.idProgramaEducativo,
		cargos.idCargo
		FROM programaeducativo INNER JOIN
		(datosgenerales INNER JOIN
		(cargos INNER JOIN clientes
		ON cargos.idCargo = clientes.idCargo)
		ON datosgenerales.idDatosGenerales = clientes.idDatosGenerales)
		ON programaeducativo.idProgramaEducativo = clientes.idProgramaEducativo
		WHERE datosgenerales.idDatosGenerales ='$idDatosGenerales'";
		return ejecutarConsultaSimpleFila( $sqlDatos );
	}
	//Metodo para enlistar los registros
	/**
	* @author Sergio Gpe. Gonzalez Chavez
	* @public
	* Selecciona todos los registros de la tabla haciendo uso de SELECT*FROM
	* @return Retorna una ejecucion SQL
	*/

	public function listar() {
		$sql = "SELECT
		clientes.idDatosGenerales,
		datosgenerales.nombres,
		datosgenerales.primerApellido,
		datosgenerales.segundoApellido,
		clientes.matricula,
		datosgenerales.correoInstitucional,
		programaeducativo.programasEducativos,
		cargos.cargoCliente
		FROM programaeducativo INNER JOIN
		(datosgenerales INNER JOIN
		(cargos INNER JOIN clientes
		ON cargos.idCargo = clientes.idCargo)
		ON datosgenerales.idDatosGenerales = clientes.idDatosGenerales)
		ON programaeducativo.idProgramaEducativo = clientes.idProgramaEducativo";
		return ejecutarConsulta( $sql );
	}
	//Metodo para seleccionar los registros
	/**
	* @author Sergio Gpe. Gonzalez Chavez
	* @public
	* Selecciona todos los registros de la tabla haciendo uso de SELECT*FROM
	* para el ser usado con la herramiena selectpicker
	* @return Retorna una ejecucion SQL
	*/

	public function selec() {
		$sql = "SELECT clientes.idClientes, CONCAT(datosgenerales.nombres,' ', datosgenerales.primerApellido,' ', datosgenerales.segundoApellido)AS nombre FROM datosgenerales INNER JOIN clientes ON datosgenerales.idDatosGenerales = clientes.idDatosGenerales";
		return ejecutarConsulta( $sql );
	}

	public function selecDato() {
		$sql = "SELECT datosgenerales.idDatosGenerales, CONCAT(datosgenerales.nombres,' ', datosgenerales.primerApellido,' ', datosgenerales.segundoApellido)AS nombre FROM datosgenerales WHERE NOT EXISTS( SELECT*FROM clientes WHERE datosgenerales.idDatosGenerales=clientes.idDatosGenerales )";
		return ejecutarConsulta( $sql );
	}
}
?>
