<?php
//Incluir la conexión a la base de datos
require "../config/conexion.php";
Class Servicio {
	//Constructor

	public function _construct() {
	}
	//Métodos para insertar servicio de entrega
	/**
	*@author Sergio Gpe. González Chávez
	*@static
	* Esta función mediante la particularidad static, permite que será usada
	* en un metodo de una clase externa, para que al momento de ser llamada
	* permita insertar registro, correspondientes a una entrega.
	* @param date $fechaServicio guarda la información de la fecha del servicio realizado
	* @param integer $idPrestamo  permite establecer una relación entre el servicio
	* y el prestamo correspondiente
	* @param integer $idUsuarios  permite establecer la relación entre el servicio y el usuario que atendió
	* @return Retorna una ejecución SQL
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
	//Métodos para insertar servicio de entrega
	/**
	*@author Sergio Gpe. González Chávez
	*@static
	* Esta función mediante la particularidad static, permite que será usada
	* en un metodo de una clase externa, para que al momento de ser llamada
	* permita insertar registro, correspondientes a una devolución.
	* @param date $fechaServicio guarda la información de la fecha del servicio realizado
	* @param integer $idPrestamo permite establecer una relación entre el servicio
	* y el prestamo correspondiente
	* @param integer $idUsuarios permite establecer la relación entre el servicio y el usuario que atendió
	* @return Retorna una ejecución SQL
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
