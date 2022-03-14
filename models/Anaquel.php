<?php
//Incluir la conexion a la base de datos

require "../config/conexion.php";
Class Anaquel {
	//Constructor

	public function _construct() {
	}
	//Metodo para insertar
	/**
	 *@author Sergio Gpe. Gonzalez Chavez
	 *@public
	 * Recibe como parametros la designacion del anaquel con su describcion para
	 * crear el registro crear un registro de anaqueles disponibles, haciendo uso de una funcion SQL INSERT
	 * @param  string $anaquelNumero Variable en la que se alamacena de forma textual el numero del anaquel
	 * @param  string $descripcionAnaquel Variable en la que se almacena la descripcion o proposito del anaquel
	 * @return Retorna una ejecucion SQL
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
	* @author Sergio Gpe. Gonzalez Chavez
	* @public
	* Metodos para editar el registro de la tabla,
	* segun el valor del id del registro a modificar, junto con los parametros
	* requeridos a modificar, mediante el uso de una funcion SQL UPDATE
	* @param  integer $idAnaquel  Recibe el id del registro de la tabla anaquel para editar
	* @param  string $anaquelNumero  Variable en la que se almacena de forma textual el numero del anaquel
	* @param  string $descripcionAnaquel Variable en la que se almacena la descripcion o proposito del anaquel
	* @return Retorna una ejecucion SQL
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
	//Metodo que muestra un regirso en especifico
	/**
	 * @author Sergio Gpe. Gonzalez Chavez
	 * @public
	 * Permite selecccionar los campos de un registro al recibir el id, del
	 * registro como parametro y el uso de SELECT*FROM, para seleccionar toda la fila
	 * @param  integer $idAnaquel Recibe el id del registro a mostrar sus datos
	 * @return Retorna una ejecucion SQL
	 */
	public function mostrar( $idAnaquel ) {
		$sql = "SELECT * FROM anaquel
		WHERE idAnaquel ='$idAnaquel'";
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
		$sql = "SELECT * FROM anaquel";
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
		$sql = "SELECT * FROM anaquel";
		return ejecutarConsulta( $sql );
	}
}
?>
