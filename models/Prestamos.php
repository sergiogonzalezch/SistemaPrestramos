<?php
//Incluir la conexión a la base de datos
require "../config/conexion.php";
//Llamar a las clase Articulos para el uso de métodos estáticos dentro de Prestamos.php
require "Articulos.php";
//Llamar a las clase Servicio para el uso de métodos estáticos dentro de Prestamos.php
require "Servicio.php";

Class Prestamos {
	public function _construct() {}
	//Métodos para insertar datos
	/**
	 * @author Sergio Gpe. González Chávez
	 * @public
	 * @param  string $edificio  Almacena la información del edificio donde se usara el equipo/accesorio
	 * @param  string $tipoArea  Permite detalla el tipo de área donde se usara el articulo
	 * @param  string $descripcionArea Guarda de forma detalla el uso del equipo en la sala que será usada.
	 * @param  date $fechaPrestamo  Almacena la información de la fecha de creación de la solicitud del prestamo
	 * @param  integer $idClientes  Permite establecer una calve foránea del cliente quien solicito el articulo
	 * @param  integer $idArticulo Permite es
	 * @param  date $fechaEntrega  Almacena la información de la fecha en que se entregó el articulo
	 * @param  string $condicionEntrega Guarda la información en que condición de entregó el articulo al solicitante
	 * @param  date $fechaServico  Almacena la información de la fecha en que se devolvió el articulo
	 * @param  integer $idUsuarios Recibe el id del usuario quien atendió el préstamo de
	 *  entrega para relacionar el servicio con el préstamo.
	 * @return una consulta SQL
	 */
	public function insertar( $edificio, $tipoArea,
	$descripcionArea, $fechaPrestamo,
	$idClientes, $idArticulo,
	$fechaEntrega, $condicionEntrega,
	$fechaServico, $idUsuarios ) {
		$sql = "INSERT INTO prestamos(edificio, tipoArea,
		descripcionArea, estado, fechaPrestamo,
		fechaCierre, idClientes)
		VALUES ('$edificio','$tipoArea',
		'$descripcionArea','Aceptado',
		'$fechaPrestamo','0000-00-00','$idClientes')";
		//Retornar id para ser insertado en la tabla articulosprestamos
		$idPrestamoNuevo = ejecutarConsulta_retornarID( $sql );
		/*Para crear el número de folio el proceso es el siguiente
		mediante el retorno del id de la variable idPrestamo nuevo ser
		realiza una concatenación al convertirlo en un valor de tipo cadena*/
		$num = strval( $idPrestamoNuevo );
		//Usando el metodo @strval se convierte el valor almacenado de la variable
		//$idPrestamoNuevo a uno de tipo cadena y se almacena en la variable llamada $num.
		$folio = 'PR-'.$num;
		//Se realiza una concatenación para generar el folio en formato PR- y
		//el numero en base al id del préstamo obtenido y se almacena en la variable $folio
		$sql_folio = "UPDATE prestamos SET folio ='$folio' WHERE idPrestamo ='$idPrestamoNuevo'";
		//Se realiza un update para insertar el valor en la tabla folio
		ejecutarConsulta( $sql_folio );
		//Se realiza la consulta
		//Llamar al metodo entrega del modelo Servicio para su registro
		Servicio::entrega( $fechaServico, $idPrestamoNuevo, $idUsuarios );
		//Variable para ser usado en el ciclo
		$num_elementos = 0;
		$sw = true;
		//Ciclo while para hacer la inserción de los artículos seleccionados
		while( $num_elementos<count( $idArticulo ) ) {
			/*Llamar al metodo entregar del modelo Articulo y los agregamos usando ayuda
			de un arreglo donde la posición esta defina por el número de artículos*/
			Articulos::entregar( $idArticulo[$num_elementos] );
			//Insertar los datos a la tabla articulosprestamos
			$sql_detalle = "INSERT into articulosprestamos
			(fechaEntrega,condicionEntrega,	devuelto,
			fechaDevolucion,condicionDevolucion,
			observacionDevolucion, idArticulo, idPrestamo)
			VALUES('$fechaEntrega','$condicionEntrega[$num_elementos]',
			b'0','0000-00-00','Sin datos','Sin datos',
			'$idArticulo[$num_elementos]','$idPrestamoNuevo')";
			//Retornar valores
			ejecutarConsulta( $sql_detalle ) or $sw = false;
			$num_elementos = $num_elementos + 1;
		}

		return $sw;
	}
	/*Metodo para cerrar el préstamo, realiza un update para
	actualizar los campos de estado, fecha de cierre una vez que el préstamo
	es recibido*/
	/**
	* @author Sergio Gpe. González Chávez
	* @public
	* Actualiza la información del préstamo, cambiando el estado a cerrado y
	* actualizando la fecha de cierre y crear un registro de servicio de devolución
	* @param integer $idPrestamo recibe el id del registro de préstamo correspondiente a actualizar
	* @param date $fechaCierre actualiza la fecha de cierre del préstamo
	* @param date $fechaServico Enviar la fecha del servicio realizado
	* @param integer $idUsuarios Id del usuario que realizo el servicio
	* @return una consulta SQL
	*/
	public function cerrar( $idPrestamo, $fechaCierre,
	$fechaServico, $idUsuarios ) {
		$sql = "UPDATE prestamos SET
		estado='Cerrado',fechaCierre='$fechaServico'
		WHERE idPrestamo='$idPrestamo'";
		//Llamar al metodo devolucion del modelo Servicio
		Servicio::devolucion( $fechaServico, $idPrestamo, $idUsuarios );
		return ejecutarConsulta( $sql );
	}

	//Metodo para mostrar los datos del registro mediante su id
	/**
	* @author Sergio Gpe. González Chávez
	* @public
	* Permite seleccionar los campos de un registro al recibir el id, del
	* registro como parámetro y el uso de SELECT*FROM, para seleccionar toda la fila
	* @param integer $idPrestamo Recibe el id del registro a mostrar sus datos
	* @return Retorna una ejecución SQL
	*/
	public function mostrar( $idPrestamo ) {
		$sql = "SELECT *FROM prestamos
		WHERE idPrestamo ='$idPrestamo'";
		return ejecutarConsultaSimpleFila( $sql );
	}

	/*Metodo para en listar cada uno de los registros del prestamo
	Mediante dos parámetros definidos por las variables $fechaInicio y $fechaFin,
	permite hacer búsquedas por rango de fechas*/
	/**
	 * @author Sergio Gpe. González Chávez
	 * @public
	 * Permite
	 * @param  date $fechaInicio parámetro inicial para el filtrado de datos mediante la fecha
	 * @param  date $fechaFin parámetro final para el filtrado de datos mediante la fecha
	 * @return Retorna una ejecución SQL
	 */
	public function listar( $fechaInicio, $fechaFin )
	{
		$sql = "SELECT Prestamos.idPrestamo AS Id,
		prestamos.folio AS Folio,
		DATE_FORMAT(prestamos.fechaPrestamo,'%Y','es_MX') Año,
		DATE_FORMAT(prestamos.fechaPrestamo,'%M','es_MX')Mes,
		DATE_FORMAT(prestamos.fechaPrestamo,'%D','es_MX') Dia,
		CONCAT(datosgenerales.nombres,' ', datosgenerales.primerApellido,' ', datosgenerales.segundoApellido)AS Nombre,
		prestamos.edificio AS Edificio,
		prestamos.tipoArea AS Area,	prestamos.descripcionArea AS
		Descripcion, prestamos.estado AS Estatus
		FROM
		datosgenerales INNER JOIN(Clientes INNER JOIN Prestamos ON
		clientes.idClientes = prestamos.idClientes)ON
		datosgenerales.idDatosGenerales=clientes.idDatosGenerales
		INNER JOIN (articulos INNER JOIN articulosprestamos ON
		articulos.idArticulo = articulosPrestamos.idArticulo)
		ON prestamos.idPrestamo = articulosprestamos.idPrestamo
		WHERE fechaPrestamo>='$fechaInicio'AND fechaCierre<='$fechaFin'
		GROUP BY prestamos.folio, Year(fechaPrestamo), Month(fechaPrestamo),
		Day(fechaPrestamo), clientes.matricula, prestamos.edificio,
		prestamos.tipoArea, prestamos.descripcionArea, prestamos.estado
		ORDER BY prestamos.idPrestamo desc";
		return ejecutarConsulta( $sql );
	}
	//Metodo para enlistar los registros
	/**
	 * @author Sergio Gpe. González Chávez
	 * @public
	 * Permite listar los datos de los articulos prestados
	 * @param  integer $idPrestamo ID le préstamo para mostrar todos los registros
	 * @return Retorna una ejecución SQL
	 */
	public function listarDetalle( $idPrestamo )
	{
		$sql = "SELECT ap.idArticuloPrestamo, ap.idPrestamo,
		ap.idArticulo,a.etiqueta,ap.fechaEntrega,ap.condicionEntrega,
		ap.devuelto, ap.fechaDevolucion,ap.condicionDevolucion,
		ap.observacionDevolucion
		FROM articulosprestamos ap INNER JOIN articulos a
		ON ap.idArticulo=a.idArticulo
		WHERE ap.idPrestamo ='$idPrestamo'";
		return ejecutarConsulta( $sql );
	}
	/*Métodos para devolver*/
	/**
	* @author Sergio Gpe. González Chávez
	* @public
	* Permite hacer una actualización en la tabla articulo préstamo de los
	* artáculos devueltos al inventario, mediante un update
	* y la recolección de los datos definidos por sus parámetros
	* @param integer $idArticuloPrestamo Id del registro de la tabla asociativa para mostrar sus datos
	* @param date $fechaDevolucion Fecha de devolución del articulo
	* @param string $condicionDevolucion Permite registrar la condición de devolución del artículo
	* @param string $observacionDevolucion Registra las observaciones al artículo prestado
	* @param integer $idArticulo Id del articulo para actualizar los registros relacionados a este
	* @return Retorna una ejecución SQL
	*/
	public function devolver( $idArticuloPrestamo,
	$fechaDevolucion,
	$condicionDevolucion,
	$observacionDevolucion,
	$idArticulo ) {
		$sql = "UPDATE articulosprestamos SET
		devuelto = b'1', fechaDevolucion = '$fechaDevolucion',
		condicionDevolucion = '$condicionDevolucion',
		observacionDevolucion = '$observacionDevolucion'
		WHERE articulosprestamos.idArticuloPrestamo = '$idArticuloPrestamo'";
		//Llamar al metodo devolver del modelo Articulos, para actualizar la disponiblidad del articulo a Disponible
		Articulos::devolver( $idArticulo );
		return ejecutarConsulta( $sql );
	}
	/**
	* @author Sergio Gpe. González Chávez
	* @public
	* Devuelve los datos de la devolución del articulo por medio del id, su uso principalmente para el modal
	* @param integer $idArticuloPrestamo Id del articulo préstamo a devolver sus datos
	* @return Retorna una ejecución SQL
	*/
	public function datosDevolucionPorId( $idArticuloPrestamo ) {
		$sql = "SELECT idArticuloPrestamo,condicionDevolucion,
		observacionDevolucion,idArticulo
		FROM articulosprestamos
		WHERE idArticuloPrestamo ='$idArticuloPrestamo'";
		return ejecutarConsulta( $sql );
	}
	/**
	* Devuelve los datos de los articulo prestado
	* @param integer $idPrestamo Id del préstamo para mostrar los datos de los detalles que compartan el id.
	* @return Retorna una ejecución SQL
	*/
	public function listarDevolucion( $idPrestamo ) {
		$sql = "SELECT ap.idArticuloPrestamo, ap.idPrestamo, ap.idArticulo,
		a.etiqueta,ap.fechaEntrega,ap.condicionEntrega
		FROM articulosprestamos ap INNER JOIN articulos a
		ON ap.idArticulo=a.idArticulo
		WHERE ap.idPrestamo ='$idPrestamo' ";
		return ejecutarConsulta( $sql );
	}
}

?>
