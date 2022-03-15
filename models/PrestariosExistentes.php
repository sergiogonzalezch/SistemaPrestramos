<?php
//Incluir la conexión a la base de datos
require "../config/conexion.php";
Class PrestariosExistentes {
	//Constructor

	public function _construct() {
	}
	//Métodos para insertar datos a la tabla
	/**
	 ** @author Sergio Gpe. González Chávez
	 * @public
	 * Permite crear un registro de un solicitante nuevo en base a un personal existente, relacionándolo
	 * con campos de la tabla datos generales, programa educativo y el cargo.
	 * siendo el único campo propio la matricula del cliente además del id del registro del cliente.
	 * @param  integer $matricula  parámetro que recive la matricula asigna del cliente.
	 * @param  integer $idDatosGenerales campo que sirve como clave foránea que relación el registro id datos generales con el registro del solicitante
	 * @param  integer $idProgramaEducativo campo que sirve como clave foránea que relación el registro id programa educativo con el registro del cliente
	 * @param  integer $idCargo campo que sirve como clave foránea que relación el registro id cargo con el registro del cliente
	 * @return Retorna una ejecución SQL
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
