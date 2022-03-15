<?php
//Incluir la conexión a la base de datos
require "../config/conexion.php";

Class ProgramaEducativo {
	//Constructor
	public function _construct() {
	}
	//Metodo para insertar
	/**
	 *@author Sergio Gpe. González Chávez
	 *@public
	 * Recibe como parámetros la designación del anaquel con su descripción para crear el registro
	 * crear un registro de los programas educativos, haciendo uso de una función SQL INSERT
	 * @param  string $programasEducativos Variable en la que se almacena de forma textual las siglas del programa educativo
	 * @return Retorna una ejecución SQL
	 */
	public function insertar( $programasEducativos ) {
		$sql = "INSERT INTO programaeducativo
		(programasEducativos)
		VALUES ('$programasEducativos')";
		return ejecutarConsulta( $sql );
	}
	//Metodo para editar el registro
	/**
	* @author Sergio Gpe. González Chávez
	* @public
	* Métodos para editar el registro de la tabla,
	* según el valor del id del registro a modificar, junto con los parámetros requeridos a modificar,
	* mediante el uso de una función SQL UPDATE
	* @param integer $idProgramaEducativo Recibe el id del registro de la tabla articulo para editar
	* @param string $programasEducativos Variable en la que se almacena de forma textual las siglas del programa educativo
	* @return Retorna una ejecución SQL
	*/
	public function editar( $idProgramaEducativo,
	$programasEducativos ) {
		$sql = "UPDATE programaeducativo SET
		programasEducativos='$programasEducativos'
		WHERE idProgramaEducativo='$idProgramaEducativo'";
		return ejecutarConsulta( $sql );
	}
	//Metodo que muestra un registro en especifico
	/**
	 * @author Sergio Gpe. González Chávez
	 * @public
	 * Permite seleccionar los campos de un registro al recibir el id, del
	 * registro como parámetro y el uso de SELECT*FROM, para seleccionar toda la fila
	 * @param  integer $idAnaquel Recibe el id del registro a mostrar sus datos
	 * @return Retorna una ejecución SQL
	 */
	public function mostrar( $idProgramaEducativo ) {
		$sql = "SELECT * FROM programaeducativo
		WHERE idProgramaEducativo='$idProgramaEducativo'";
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
		$sql = "SELECT * FROM programaeducativo";
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
		$sql = "SELECT * FROM programaeducativo";
		return ejecutarConsulta( $sql );
	}
}
?>
