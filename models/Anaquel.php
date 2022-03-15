<?php
//Incluir la conexión a la base de datos
require "../config/conexion.php";
Class Anaquel {
	//Constructor
	public function _construct() {
	}
	//Metodo para insertar
	/**
	 *@author Sergio Gpe. González Chávez
	 *@public
	 * Recibe como parámetros la designación del anaquel con su descripción  para
	 * crear el registro crear un registro de anaqueles disponibles, haciendo uso de una función SQL INSERT
	 * @param  string $anaquelNumero Variable en la que se almacena  de forma textual el número del anaquel
	 * @param  string $descripcionAnaquel Variable en la que se almacena la descripción o propósito del anaquel
	 * @return Retorna una ejecución SQL
	 */
	public function insertar( $anaquelNumero,
	$descripcionAnaquel ) {
		$sql = "INSERT INTO anaquel
		(anaquelNumero,	descripcionAnaquel)
		VALUES('$anaquelNumero','$descripcionAnaquel')";
		return ejecutarConsulta( $sql );
	}
	//Metodo para editar el registro
	/**
	* @author Sergio Gpe. González Chávez
	* @public
	* Métodos para editar el registro de la tabla,
	* según el valor del id del registro a modificar, junto con los parámetros
	* requeridos a modificar, mediante el uso de una función SQL UPDATE
	* @param  integer $idAnaquel  Recibe el id del registro de la tabla anaquel para editar
	* @param  string $anaquelNumero  Variable en la que se almacena de forma textual el numero del anaquel
	* @param  string $descripcionAnaquel Variable en la que se almacena la descripción o propósito del anaquel
	* @return Retorna una ejecución SQL
	*/
	public function editar( $idAnaquel,
	$anaquelNumero,
	$descripcionAnaquel ) {
		$sql = "UPDATE anaquel SET
		anaquelNumero='$anaquelNumero',
		descripcionAnaquel='$descripcionAnaquel
		'WHERE idAnaquel='$idAnaquel'";
		return ejecutarConsulta( $sql );
	}
	//Metodo que muestra un registro en especifico
	/**
	* @author Sergio Gpe. González Chávez
	* @public
	* Permite seleccionar los campos de un registro al recibir el id, del
	* registro como parámetro y el uso de SELECT*FROM, para seleccionar toda la fila
	* @param integer $idAnaquel Recibe el id del registro a mostrar sus datos
	* @return Retorna una ejecución SQL
	 */
	public function mostrar( $idAnaquel ) {
		$sql = "SELECT * FROM anaquel
		WHERE idAnaquel ='$idAnaquel'";
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
		$sql = "SELECT * FROM anaquel";
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
		$sql = "SELECT * FROM anaquel";
		return ejecutarConsulta( $sql );
	}
}
?>
