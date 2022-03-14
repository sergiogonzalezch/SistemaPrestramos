<?php
//Incluir la conexion a la base de datos
require "../config/conexion.php";
Class BajaArticulo {
	//Constructor

	public function _construct() {
	}
	//Metodos para insertar
	/**
	 * @author Sergio Gpe. Gonzalez Chavez
	 * @static
	 * Este metodo tiene como principal funcion ser usado por otra clase mediante la declaracion static, con el fin de crear el registro del articulo dado de baja
	 * @param  date $fechaBaja parametro que recibe la fecha de baja del articulo
	 * @param  string $observacionBaja parametro que recibe el motivo de baja del articulo
	 * @param  integer $idArticulo parametro que sirve para la cracion de la clave foranea para relacionar el articulo con el registro
	 *  @return Retorna una ejecucion SQL
	 */
	static function insertar( $fechaBaja,
	$observacionBaja,
	$idArticulo ) {
		$sql = "INSERT INTO baja (fechaBaja,
		observacionBaja,idArticulo)
		VALUES ('$fechaBaja','$observacionBaja',
		'$idArticulo')";
		return ejecutarConsulta( $sql );
	}
	//Metodo para eliminar
	/**
	 * @author Sergio Gpe. Gonzalez Chavez
	 * @static
	 * Este metodo tiene como principal funcion ser usado por otra clase mediante la declaracion static, en la cual elimina el registro, del articulo dado de baja.
	 * @param  integer $idArticulo parametro del id del articulo a eliminar
	 *  @return Retorna una ejecucion SQL
	 */
	static function eliminar( $idArticulo ) {
		$sql = "DELETE FROM baja
		WHERE idArticulo='$idArticulo'";
		return ejecutarConsulta( $sql );
	}
	//Metodos para editar el registro
	/**
	 *@author Sergio Gpe. Gonzalez Chavez
	 *@public
	 * Metodos para editar el registro de la tabla,
	 * segun el valor del id del registro a modificar, junto con los parametros requeridos a modificar,
	 * mediante el uso de una funcion SQL UPDATE
	 * @param  integer $idBaja parametro del id del registro requerido a modificar
	 * @param  string $observacionBaja parametro que recibe el motivo de baja del articulo
	 * @return Retorna una ejecucion SQL
	 */
	public function editar( $idBaja, $observacionBaja ) {
		$sql = "UPDATE baja SET
		observacionBaja='$observacionBaja'
		WHERE idBaja='$idBaja'";
		return ejecutarConsulta( $sql );
	}
	//Metodo que muestra un regirso en especifico

	/**
	 * @author Sergio Gpe. Gonzalez Chavez
	 * @public
	 * Permite selecccionar los campos de un registro al recibir el id, del
	 * registro como parametro y el uso de SELECT*FROM, para seleccionar toda la fila
	 * @param  integer $idBaja Recibe el id del registro a mostrar sus datos
	 * @return Retorna una ejecucion SQL
	 */
	public function mostrar( $idBaja ) {
		$sql = "SELECT * FROM baja
		WHERE idBaja ='$idBaja'";
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
		$sql = "SELECT baja.idBaja AS Id,
		baja.fechaBaja AS FechaBaja,
		baja.observacionBaja AS Observaciones,
		articulos.etiqueta AS Articulo
		FROM articulos INNER JOIN baja
		ON articulos.idArticulo = baja.idArticulo";
		return ejecutarConsulta( $sql );
	}
}
?>
