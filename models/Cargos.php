<?php
//Incluir la conexión a la base de datos
require "../config/conexion.php";
Class Cargos {
	//Constructor
	public function _construct() {
	}
	//Metodo para insertar
	/**
	*@author Sergio Gpe. González Chávez
	*@public
	* Recibe como parámetros la designación del cargo con su descripción para crear el registro
	* crear un registro de cargos para clientes, haciendo uso de una función SQL INSERT
	* @param string $cargoCliente Variable en la que se almacena de forma textual el numero el cargo que desempeña un cliente dentro del sistema
	* @return Retorna una ejecución SQL
	*/
	public function insertar( $cargoCliente ) {
		$sql = "INSERT INTO cargos (cargoCliente)
		VALUES('$cargoCliente')";
		return ejecutarConsulta( $sql );
	}
	/*Métodos para editar el registro de la tabla,
	según el valor del id del registro a modificar*/
	//Metodo para editar el registro
	/**
	* @author Sergio Gpe. González Chávez
	* @public
	* Métodos para editar el registro de la tabla,
	* según el valor del id del registro a modificar, junto con los parámetros requeridos a modificar,
	* mediante el uso de una función SQL UPDATE
	* @param integer $idCargo Recibe el id del registro de la tabla cargos para editar
	* @param string $cargoCliente Variable en la que se almacena de forma textual el numero el cargo que desempeña un cliente dentro del sistema
	* @return Retorna una ejecución SQL
	*/
	public function editar( $idCargo, $cargoCliente ) {
		$sql = "UPDATE cargos SET
		cargoCliente='$cargoCliente'
		WHERE idCargo='$idCargo'";
		return ejecutarConsulta( $sql );
	}
	/**
	 * @author Sergio Gpe. González Chávez
	 * @public
	 * Permite seleccionar los campos de un registro al recibir el id, del
	 * registro como parámetro y el uso de SELECT*FROM, para seleccionar toda la fila
	 * @param  integer $idAnaquel Recibe el id del registro a mostrar sus datos
	 * @return Retorna una ejecución SQL
	 */
	public function mostrar( $idCargo ) {
		$sql = "SELECT * FROM cargos
		WHERE idCargo ='$idCargo'";
		return ejecutarConsultaSimpleFila( $sql );
	}
	//Metodo para enlistar los registros
	/**
	* @author Sergio Gpe. González Chávez
	* @public
	* Selecciona todos los registros de la tabla haciendo uso de SELECT*FROM
	* @return Retorna una ejecución SQL
	*/
	public function listar() {
		$sql = "SELECT * FROM cargos";
		return ejecutarConsulta( $sql );
	}
	//Metodo para seleccionar los registros
	/**
	* @author Sergio Gpe. González Chávez
	* @public
	* Selecciona todos los registros de la tabla haciendo uso de SELECT*FROM
	* para el ser usado con la herramienta selectpicker
	* @return Retorna una ejecución SQL
	*/
	public function selec() {
		$sql = "SELECT * FROM cargos";
		return ejecutarConsulta( $sql );
	}
}
?>
