<?php
//Incluir la conexión a la base de datos
require "../config/conexion.php";
Class BajaArticulo {
	//Constructor
	public function _construct() {
	}
	//Métodos para insertar
	/**
	 * @author Sergio Gpe. González Chávez
	 * @static
	 * Este metodo tiene como principal función ser usado por otra clase mediante la declaración static, con el fin de crear el registro del articulo dado de baja
	 * @param  date $fechaBaja parámetro que recibe la fecha de baja del articulo
	 * @param  string $observacionBaja parámetro que recibe el motivo de baja del articulo
	 * @param  integer $idArticulo parámetro que sirve para la creación de la clave foránea para relacionar el articulo con el registro
	 *  @return Retorna una ejecución SQL
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
	 * @author Sergio Gpe. González Chávez
	 * @static
	 * Este metodo tiene como principal función ser usado por otra clase mediante la declaración static, en la cual elimina el registro, del articulo dado de baja.
	 * @param  integer $idArticulo parámetro del id del articulo a eliminar
	 *  @return Retorna una ejecución SQL
	 */
	static function eliminar( $idArticulo ) {
		$sql = "DELETE FROM baja
		WHERE idArticulo='$idArticulo'";
		return ejecutarConsulta( $sql );
	}
	//Métodos para editar el registro
	/**
	 *@author Sergio Gpe. González Chávez
	 *@public
	 * Métodos para editar el registro de la tabla,
	 * según el valor del id del registro a modificar, junto con los parámetros requeridos a modificar,
	 * mediante el uso de una función SQL UPDATE
	 * @param  integer $idBaja parámetro del id del registro requerido a modificar
	 * @param  string $observacionBaja parámetro que recibe el motivo de baja del articulo
	 * @return Retorna una ejecución SQL
	 */
	public function editar( $idBaja, $observacionBaja ) {
		$sql = "UPDATE baja SET
		observacionBaja='$observacionBaja'
		WHERE idBaja='$idBaja'";
		return ejecutarConsulta( $sql );
	}
	//Metodo que muestra un registro en especifico
	/**
	 * @author Sergio Gpe. González Chávez
	 * @public
	 * Permite seleccionar los campos de un registro al recibir el id, del
	 * registro como parámetro y el uso de SELECT*FROM, para seleccionar toda la fila
	 * @param  integer $idBaja Recibe el id del registro a mostrar sus datos
	 * @return Retorna una ejecución SQL
	 */
	public function mostrar( $idBaja ) {
		$sql = "SELECT * FROM baja
		WHERE idBaja ='$idBaja'";
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
