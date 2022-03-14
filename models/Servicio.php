<?php
//Incluir la conexion a la base de datos
require "../config/conexion.php";
Class Servicio {
	//Constructor

	public function _construct() {
	}
	//Metodos para insertar servicio de entrega
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@static
	* Esta funcion mediante la particularidad static, permite que sera usada
	* en un metodo de una clase externa, para que al momento de ser llamada
	* permita insertar registro, correspondientes a una entrega.
	* @param  date $fechaServicio guarda la informacion de la fecha del servicio realizado
	* @param  integer $idPrestamo  permite establecer una relacion entre el servicio
	* y el prestamo correspondiente
	* @param  integer $idUsuarios  permite establecer la relacion entre el servicio y el usuario que atendio
	* @return Retorna una ejecucion SQL
	*/
	static function entrega( $fechaServicio,
	$idPrestamo,
	$idUsuarios ) {
		$sql = "INSERT INTO servicio
		(tipoServicio,
		fechaServicio,
		idPrestamo,
		idUsuarios)
		VALUES
		('Entrega',
		'$fechaServicio',
		'$idPrestamo',
		'$idUsuarios')";
		return ejecutarConsulta( $sql );
	}
	//Metodos para insertar servicio de entrega
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@static
	* Esta funcion mediante la particularidad static, permite que sera usada
	* en un metodo de una clase externa, para que al momento de ser llamada
	* permita insertar registro, correspondientes a una devolucion.
	* @param  date $fechaServicio guarda la informacion de la fecha del servicio realizado
	* @param  integer $idPrestamo  permite establecer  una relacion entre el servicio
	* y el prestamo correspondiente
	* @param  integer $idUsuarios  permite establacer la relacion entre el servicio y el usuario que atendio
	* @return Retorna una ejecucion SQL
	*/
	static function devolucion( $fechaServicio,
	$idPrestamo,
	$idUsuarios ) {
		$sql = "INSERT INTO servicio
		(tipoServicio,
		fechaServicio,
		idPrestamo,
		idUsuarios)
		VALUES ('Devolucion',
		'$fechaServicio',
		'$idPrestamo',
		'$idUsuarios')";
		return ejecutarConsulta( $sql );
	}
}
?>
