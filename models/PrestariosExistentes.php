<?php
//Incluir la conexion a la base de datos
require "../config/conexion.php";
Class PrestariosExistentes {
	//Constructor

	public function _construct() {
	}
	//Metodos para insertar datos a la tabla
	/**
	 ** @author Sergio Gpe. Gonzalez Chavez
	 * @public
	 * Permite crear un registro de un solicitante nuevo en base a un personal existente , relacionandolo
	 * con campos de la tabla datos generales, programa educativo y el cargo.
	 * siendo el unico campo propio la matricula del cliente ademas del id del registro del cliente.
	 * @param  integer $matricula  parametro que recive la matricula asigna del cliente.
	 * @param  integer $idDatosGenerales campo que sirve como clave foranea que relacion el registro id datos generales con el registro del solicitante
	 * @param  integer $idProgramaEducativo campo que sirve como clave foranea que relacion el registro id programa educativo con el registro del cliente
	 * @param  integer $idCargo campo que sirve como clave foranea que relacion el registro id cargo con el registro del cliente
	 * @return Retorna una ejecucion SQL
	 */
	public function insertar( $matricula,
	$idDatosGenerales,
	$idProgramaEducativo,
	$idCargo ) {
		$sql = "INSERT INTO clientes
			(matricula,
			idDatosGenerales,
			idProgramaEducativo,
			idCargo)
		VALUES
			('$matricula',
			'$idDatosGenerales',
			'$idProgramaEducativo',
			'$idCargo')";
		return ejecutarConsulta( $sql );
	}
}
?>
