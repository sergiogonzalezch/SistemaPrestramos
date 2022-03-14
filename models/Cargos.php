<?php
//Incluir la conexion a la base de datos
require "../config/conexion.php";
Class Cargos {
	//Constructor

	public function _construct() {
	}
	//Metodo para insertar
	/**
	 *@author Sergio Gpe. Gonzalez Chavez
	 *@public
	 * Recibe como parametros la designacion del cargo con su describcion para crear el registro
	 * crear un registro de cargos para clientes, haciendo uso de una funcion SQL INSERT
	 * @param  string $cargoCliente  Variable en la que se almacena de forma textual el numero el cargo que desempeña un cliente dentro del sistema
	 * @return Retorna una ejecucion SQL
	 */

	public function insertar( $cargoCliente ) {
		$sql = "INSERT INTO cargos (cargoCliente)
		VALUES('$cargoCliente')";
		return ejecutarConsulta( $sql );
	}
	/*Metodos para editar el registro de la tabla,
	segun el valor del id del registro a modificar*/
	//Metodo para editar el registro
	/**
	* @author Sergio Gpe. Gonzalez Chavez
	* @public
	* Metodos para editar el registro de la tabla,
	* segun el valor del id del registro a modificar, junto con los parametros requeridos a modificar,
	* mediante el uso de una funcion SQL UPDATE
	* @param  integer $idCargo  Recibe el id del registro de la tabla cargos para editar
	* @param  string $cargoCliente Variable en la que se alamacena de forma textual el numero el cargo que desempeña un cliente dentro del sistema
	* @return Retorna una ejecucion SQL
	*/
	public function editar( $idCargo, $cargoCliente ) {
		$sql = "UPDATE cargos SET
		cargoCliente='$cargoCliente'
		WHERE idCargo='$idCargo'";
		return ejecutarConsulta( $sql );
	}
	/**
	 * @author Sergio Gpe. Gonzalez Chavez
	 * @public
	 * Permite selecccionar los campos de un registro al recibir el id, del
	 * registro como parametro y el uso de SELECT*FROM, para seleccionar toda la fila
	 * @param  integer $idAnaquel Recibe el id del registro a mostrar sus datos
	 * @return Retorna una ejecucion SQL
	 */
	public function mostrar( $idCargo ) {
		$sql = "SELECT * FROM cargos
		WHERE idCargo ='$idCargo'";
		return ejecutarConsultaSimpleFila( $sql );
	}
	//Metodo para enlistar los registros
	/**
	* @author Sergio Gpe. Gonzalez Chavez
	* @public
	* Selecciona todos los registros de la tabla haciendo uso de SELECT*FROM
	* @return Retorna una ejecucion SQL
	*/

	public function listar() {
		$sql = "SELECT * FROM cargos";
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
		$sql = "SELECT * FROM cargos";
		return ejecutarConsulta( $sql );
	}
}
?>
