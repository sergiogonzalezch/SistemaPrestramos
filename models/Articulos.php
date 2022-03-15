<?php
//Incluir la conexión a la base de datos
require "../config/conexion.php";
//Llmar la clase Bajar articulo para importar funciones
require "BajaArticulo.php";
Class Articulos {
	//Constructor
	public function _construct() {
	}
	//Metodo para insertar
	/**
	** @author Sergio Gpe. González Chávez
	* @public
	* permite realizar un registro de un artículo nuevo al stock digital
	* @param  string $etiqueta  parámetro que recibe la designación del equipo
	* @param  date   $fechaAlta  parámetro recibe la fecha de alta del equipo
	* @param  string $numeroSerie parámetro recibe el número de serie del articulo
	* @param  string $imagen   recibe la el nombre de un archivo de imagen
	* @param  string $descripción  recibe la descripcion del equipo
	* @param  string $codigoBarras  recibe el código de barras
	* @param  string $disponibilidadArticulos recibe la disponibilidad del articulo
	* @param  string $condicionArticulo recibe la condición del articulo
	* @param  integer $idAnaquel sirve como clave foránea para asignar un anaquel
	* @param  integer $idTipoArticulo sirve como clave foránea para asignar el tipo del articulo
	* @return Retorna una ejecución SQL
	*/
	public function insertar( $etiqueta,
	$fechaAlta,
	$numeroSerie,
	$imagen,
	$descripcion,
	$codigoBarras,
	$disponibilidadArticulos,
	$condicionArticulo,
	$idAnaquel,
	$idTipoArticulo ) {
		$sql = "INSERT INTO articulos (etiqueta,fechaAlta,
		numeroSerie,imagen,descripcion,codigoBarras,
		disponibilidadArticulos,condicionArticulo,
		idAnaquel,idTipoArticulo)
		VALUES ('$etiqueta','$fechaAlta','$numeroSerie',
		'$imagen','$descripcion','$codigoBarras',
		'$disponibilidadArticulos','$condicionArticulo',
		'$idAnaquel','$idTipoArticulo')";
		return ejecutarConsulta( $sql );
	}
	/**
	* @author Sergio Gpe. González Chávez
	* @public
	* permite realizar un registro de un artículo nuevo al stock digital
	* @param integer $idArticulo Recibe el valor del registro a editar
	* @param string $etiqueta parámetro que recibe la designación del equipo
	* @param date $fechaAlta parámetro recibe la fecha de alta del equipo
	* @param string $numeroSerie parámetro recibe el número de serie del articulo
	* @param string $imagen recibe la el nombre de un archivo de imagen
	* @param string $descripcion recibe la descripción del equipo
	* @param string $codigoBarras recibe el código de barras
	* @param string $disponibilidadArticulos recibe la disponibilidad del articulo
	* @param string $condicionArticulo recibe la condición del articulo
	* @param integer $idAnaquel sirve como clave foránea para asignar un anaquel
	* @param integer $idTipoArticulo sirve como clave foránea para asignar el tipo
	* @return Retorna una ejecución SQL
	*/
	public function editar( $idArticulo, $etiqueta,
	$numeroSerie, $imagen, $descripcion,
	$codigoBarras, $disponibilidadArticulos,
	$condicionArticulo, $idAnaquel, $idTipoArticulo ) {
		$sql = "UPDATE articulos SET etiqueta='$etiqueta',
		numeroSerie='$numeroSerie',imagen='$imagen',
		descripcion='$descripcion',codigoBarras='$codigoBarras',
		disponibilidadArticulos='$disponibilidadArticulos',
		condicionArticulo='$condicionArticulo',idAnaquel='$idAnaquel',
		idTipoArticulo='$idTipoArticulo'
		WHERE idArticulo='$idArticulo'";
		return ejecutarConsulta( $sql );
	}
	//*Metodo para seleccionar un registro y mostrar sus datos*/
	/**
	 * @author Sergio Gpe. González Chávez
	 * @public
	 * Permite seleccionar los campos de un registro al recibir el id, del
	 * registro como parámetro y el uso de SELECT*FROM, para seleccionar toda la fila
	 * @param  integer $idArticulo Recibe el id del registro a mostras sus datos
	 * @return Retorna una ejecución SQL
	 */
	public function mostrar( $idArticulo ) {
		$sql = "SELECT * FROM articulos
		WHERE idArticulo ='$idArticulo'";
		return ejecutarConsultaSimpleFila( $sql );
	}
	//Metodo para realizar baja de  articulo
	/**
	 * @author Sergio Gpe. González Chávez
	 * @public
	 * Permite crear un registro de un artículo a dar de baja
	 * @param  integer $idArticulo es el parámetro que permite relacionar un registro de baja con el artículo en cuestión
	 * @param  string $observacionBaja es la observación o motivo de baja del artículo
	 * @return Retorna una ejecución SQL
	 */
	public function baja( $idArticulo, $observacionBaja ) {
		/*Actualizar la disponibilidad del artículo a baja
		al recibir el id del artículo*/
		$sql = "UPDATE articulos SET
		disponibilidadArticulos = 'Baja'
		WHERE articulos.idArticulo ='$idArticulo'";
		/*Tomar la fecha mediante el comando date
		y enviarlo mediante el formato año, mes y día*/
		$fechaBaja = date( 'Y-m-d' );
		/*Llamar la función insertar de la clase bajar artículo
		para realizar el proceso de captura de datos de la baja*/
		BajaArticulo::insertar( $fechaBaja, $observacionBaja, $idArticulo );
		return ejecutarConsulta( $sql );
	}
	//Metodo para realizar la reactivación
	/**
	* @author Sergio Gpe. González Chávez
	* @public
	* Permite realizar la acción de reactivar el articulo
	* @param integer $idArticulo id del registro del articulo para reactivar
	* @return Retorna una ejecución SQL
	*/
	public function reactivar( $idArticulo ) {
		//Cambiar la disponibilidad a disponible
		$sql = "UPDATE articulos SET
		disponibilidadArticulos = 'Disponible'
		WHERE articulos.idArticulo ='$idArticulo'";
		//Eliminar el registro del articulo del articulo reactivado
		BajaArticulo::eliminar( $idArticulo );
		return ejecutarConsulta( $sql );
	}
	//Cambiar disponibilidad al hacer una entrega
	/**
	 *@author Sergio Gpe. González Chávez
	 *@static
	 * Permite cambiar la disponibilidad del artículo a "NoDisponible" cuando el articulo fue entregado
	 * @param  integer $idArticulo a cambiar su disponibilidad
	 * @return Retorna una ejecución SQL
	 */
	static function entregar( $idArticulo ) {
		$sql = "UPDATE articulos SET
		disponibilidadArticulos = 'NoDisponible'
		WHERE articulos.idArticulo ='$idArticulo'";
		return ejecutarConsulta( $sql );
	}

	//Cambiar disponibilidad al hacer una devolución
	/**
	*@author Sergio Gpe. González Chávez
	*@static
	* Permite cambiar la disponibilidad del artículo a Disponible cuando el articulo fue devuelto
	* @param integer $idArticulo a cambiar su disponibilidad
	* @return Retorna una ejecución SQL
	*/
	static function devolver( $idArticulo ) {
		$sql = "UPDATE articulos SET
		disponibilidadArticulos = 'Disponible'
		WHERE articulos.idArticulo ='$idArticulo'";
		return ejecutarConsulta( $sql );
	}
	//Metodo para enlistar los registros
	/**
	* @author Sergio Gpe. González Chávez
	* @public
	* Selecciona todos los registros de la tabla haciendo uso de SELECT*FROM
	* para este caso selecciona igual campos requeridos de otras tablas mediante
	* el uso de un inner join que hace referencia al valor de la clave foránea y
	* los campos deseados de las tablas relacionadas.
	* @return Retorna una ejecución SQL
	*/
	public function listar() {
		$sql = "SELECT articulos.idArticulo AS Id,
		tipoArticulo.tipoArticulo AS TipoArticulo,
		articulos.etiqueta AS Etiqueta,
		articulos.codigoBarras AS CodigoBarras,
		articulos.imagen AS Imagen,
		articulos.fechaAlta AS AltaArticulo,
		articulos.numeroSerie AS NumSerie,
		articulos.descripcion AS Descripcion,
		articulos.condicionArticulo AS Condicion,
		articulos.disponibilidadArticulos AS Disponible,
		anaquel.anaquelNumero AS Anaquel
		FROM (tipoArticulo INNER JOIN (anaquel INNER JOIN articulos
		ON anaquel.idAnaquel = articulos.idAnaquel)
		ON tipoArticulo.idTipoArticulo = articulos.idTipoArticulo)";
		return ejecutarConsulta( $sql );
	}
	//Metodo para enlistar los registros
	/**
	* @author Sergio Gpe. González Chávez
	* @public
	* Selecciona todos los registros de la tabla haciendo uso de SELECT*FROM
	* para este caso selecciona igual campos requeridos de otras tablas mediante
	* el uso de un inner join que hace referencia al valor de la clave foránea y
	* los campos deseados de las tablas relacionadas.
	* Esta función permite ser usada para desplegar los datos en un modal para realizar la asignación de equipos al préstamo.
	* @return Retorna una ejecución SQL
	*/
	public function listarDisponibles() {
		$sql = "SELECT articulos.idArticulo AS Id,
		tipoArticulo.tipoArticulo AS TipoArticulo,
		articulos.etiqueta AS Etiqueta,
		articulos.codigoBarras AS CodigoBarras,
		articulos.condicionArticulo AS Condicion,
		anaquel.anaquelNumero AS Anaquel
		FROM (tipoArticulo INNER JOIN (anaquel INNER JOIN articulos
		ON anaquel.idAnaquel = articulos.idAnaquel)
		ON tipoArticulo.idTipoArticulo = articulos.idTipoArticulo)
		WHERE articulos.disponibilidadArticulos ='Disponible'";
		return ejecutarConsulta( $sql );
	}
}
?>
