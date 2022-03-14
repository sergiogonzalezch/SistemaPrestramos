<?php
//Incluir la conexion a la base de datos
require "../config/conexion.php";
//Llmar la clase Bajar articulo para importar funciones
require "BajaArticulo.php";
Class Articulos {
	//Constructor

	public function _construct() {
	}
	//Metodo para insertar
	/**
	** @author Sergio Gpe. Gonzalez Chavez
	* @public
	* permite realizar un registro de un articulo nuevo al stock digital
	* @param  string $etiqueta  parametro que recibe la designacion del equipo
	* @param  date   $fechaAlta  parametro recibe la fecha de alta del equipo
	* @param  string $numeroSerie parametro recibe el numero de serie del articulo
	* @param  string $imagen   recibe la el nombre de un archivo de imagen
	* @param  string $descripcion  recibe la descripcion del equipo
	* @param  string $codigoBarras  recibe el codigo de barras
	* @param  string $disponibilidadArticulos recibe la disponibilidad del articulo
	* @param  string $condicionArticulo recibe la condicion del articulo
	* @param  integer $idAnaquel sirve como clave foranea para asignar un anaquel
	* @param  integer $idTipoArticulo sirve como clave foranea para asignar el tipo del articulo
	* @return Retorna una ejecucion SQL
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
	 * @author Sergio Gpe. Gonzalez Chavez
	 * @public
	 * permite realizar un registro de un articulo nuevo al stock digital
	 * @param  integer $idArticulo  Recibe el valor del registro a editar
	 * @param  string $etiqueta  parametro que recibe la designacion del equipo
	 * @param  date	  $fechaAlta  parametro recibe la fecha de alta del equipo
	 * @param  string $numeroSerie parametro recibe el numero de serie del articulo
	 * @param  string $imagen   recibe la el nombre de un archivo de imagen
	 * @param  string $descripcion  recibe la descripcion del equipo
	 * @param  string $codigoBarras  recibe el codigo de barras
	 * @param  string $disponibilidadArticulos recibe la disponibilidad del articulo
	 * @param  string $condicionArticulo recibe la condicion del articulo
	 * @param  integer $idAnaquel sirve como clave foranea para asignar un anaquel
	 * @param  integer $idTipoArticulo sirve como clave foranea para asignar el tipo
	 * @return Retorna una ejecucion SQL
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
	 * @author Sergio Gpe. Gonzalez Chavez
	 * @public
	 * Permite selecccionar los campos de un registro al recibir el id, del
	 * registro como parametro y el uso de SELECT*FROM, para seleccionar toda la fila
	 * @param  integer $idArticulo Recibe el id del registro a mostras sus datos
	 * @return Retorna una ejecucion SQL
	 */
	public function mostrar( $idArticulo ) {
		$sql = "SELECT * FROM articulos
		WHERE idArticulo ='$idArticulo'";
		return ejecutarConsultaSimpleFila( $sql );
	}
	//Metodo para realizar baja de  articulo
	/**
	 * @author Sergio Gpe. Gonzalez Chavez
	 * @public
	 * Permite crear un registro de un articulo a dar de baja
	 * @param  integer $idArticulo es el parametro que permite relacionar un registro de baja con el articulo en cuestion
	 * @param  string $observacionBaja es la observacion o motivo de baja del articulo
	 * @return Retorna una ejecucion SQL
	 */
	public function baja( $idArticulo, $observacionBaja ) {
		/*Actualizar la disponibilidad del articulo a baja
		al recibir el id del articulo*/
		$sql = "UPDATE articulos SET
		disponibilidadArticulos = 'Baja'
		WHERE articulos.idArticulo ='$idArticulo'";
		/*Tomar la fecha mdiante el comando date
		y enviarlo mediante el formato año, mes y dia*/
		$fechaBaja = date( 'Y-m-d' );
		/*LLamar la funcion insertar de la clase bajar articulo
		para realizar el proceso de captura de datos de la baja*/
		BajaArticulo::insertar( $fechaBaja, $observacionBaja, $idArticulo );
		return ejecutarConsulta( $sql );
	}
	//Metodo para realizar la reactivacion
	/**
	 * @author Sergio Gpe. Gonzalez Chavez
	 * @public
	 * Permite realizar la accion de reactivar el articulo
	 * @param  integer $idArticulo id del registro del articulo para reactivar
	 * @return Retorna una ejecucion SQL
	 */
	public function reactivar( $idArticulo ) {
		//Camabiar la disponibilidad a disponible
		$sql = "UPDATE articulos SET
		disponibilidadArticulos = 'Disponible'
		WHERE articulos.idArticulo ='$idArticulo'";
		//Eliminar el registro del articulo del articulo reactivado
		BajaArticulo::eliminar( $idArticulo );
		return ejecutarConsulta( $sql );
	}
	//Cambiar disponibilidad al hacer una entrega
	/**
	 *@author Sergio Gpe. Gonzalez Chavez
	 *@static
	 * Permite cambiar la disponibilidad del articulo a NoDisponible cuando el articulo fue entregado
	 * @param  integer $idArticulo a cambiar su disponibilidad
	 * @return Retorna una ejecucion SQL
	 */
	static function entregar( $idArticulo ) {
		$sql = "UPDATE articulos SET
		disponibilidadArticulos = 'NoDisponible'
		WHERE articulos.idArticulo ='$idArticulo'";
		return ejecutarConsulta( $sql );
	}

	//Cambiar disponibilidad al hacer una devolucion
	/**
	 *@author Sergio Gpe. Gonzalez Chavez
	 *@static
	 * Permite cambiar la disponibilidad del articulo a Disponible cuando el articulo fue devuelto
	 * @param  integer $idArticulo a cambiar su disponibilidad
	 * @return Retorna una ejecucion SQL
	 */
	static function devolver( $idArticulo ) {
		$sql = "UPDATE articulos SET
		disponibilidadArticulos = 'Disponible'
		WHERE articulos.idArticulo ='$idArticulo'";
		return ejecutarConsulta( $sql );
	}
	//Metodo para enlistar los registros
	/**
	* @author Sergio Gpe. Gonzalez Chavez
	* @public
	* Selecciona todos los registros de la tabla haciendo uso de SELECT*FROM
	* para este caso selecciona igual campos requeridos de otras tablas mediante
	* el uso de un inner join que hace refernecia al valor de la clave foranea y
	* los campos deseados de las tablas relacionadas.
	* @return Retorna una ejecucion SQL
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
	* @author Sergio Gpe. Gonzalez Chavez
	* @public
	* Selecciona todos los registros de la tabla haciendo uso de SELECT*FROM
	* para este caso selecciona igual campos requeridos de otras tablas mediante
	* el uso de un inner join que hace refernecia al valor de la clave foranea y
	* los campos deseados de las tablas relacionadas.
	* Esta funcion permite ser usada para desplgegar los datos en un modal para realizar la asignacion de equipos al prestamo.
	* @return Retorna una ejecucion SQL
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
