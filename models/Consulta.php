<?php
//Incluir la conexion a la base de datos
require "../config/conexion.php";
Class Consulta {
	//Constructor

	public function _construct() {
	}
	//FUNCIONES PARA CONSULTAS
	/*Consulta prestamos usuarios: permite realizar la consulta de
	los servicios atendidos por los usuarios*/
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@public
	* Funcion que permite realizar consulta entre la relacion del usuario
	* y el servicio realizado
	* sea una entrega o una devolucion a un prestamo correspondiente,
	* filtrando los datos por un rango de fecha
	* al recibir valores del tipo date mediante sus dos paramentros.
	* @param  date $fechaInicio parametro que recibe un dato de fecha inicial
	* @param  date $fechaFin   parametro que recibe un dato de fecha final
	* @return ejecucion SQL, con datos de la consulta.
	*/

	public function consultaServicios( $fechaInicio, $fechaFin ) {
		$sql = "SELECT
		DATE_FORMAT(servicio.fechaServicio,'%Y','es_MX')Año,
		DATE_FORMAT(servicio.fechaServicio,'%M','es_MX')Mes,
		DATE_FORMAT(servicio.fechaServicio,'%D','es_MX')Dia,
		usuarios.aliasUsuario,
		servicio.tipoServicio, prestamos.folio
		FROM usuarios INNER JOIN (prestamos INNER JOIN servicio ON
		prestamos.idPrestamo = servicio.idPrestamo) ON
		usuarios.idUsuarios = servicio.idUsuarios
		WHERE servicio.fechaServicio>='$fechaInicio'
		AND servicio.fechaServicio<='$fechaFin'
		GROUP BY servicio.idServicio, usuarios.aliasUsuario,
		servicio.fechaServicio, servicio.tipoServicio,
		prestamos.folio
		ORDER BY servicio.fechaServicio DESC ";
		return ejecutarConsulta( $sql );
	}
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@public
	* Articulos Entregados: realiza una consulta del total de articulos entregados
	* durante un rango de fechas y agruparlos por el tipo de articulo.
	* Ademas de filtrar los datos mediante rango de fechas.
	* DATE_FORMAT: es una funcion SQL, que permite aplicar un formato de fecha tradicional
	* a campos o valores de tipo date.
	* %Y para año, %M para mes, %D para establecer el dia y es_MX
	* paraestablecer  el formato en español mexico.
	* @param  date $fechaInicio parametro que recibe un dato de fecha inicial
	* @param  date $fechaFin   parametro que recibe un dato de fecha final
	* @return ejecucion SQL, con datos de la consulta.
	*/

	public function consultaEntregas( $fechaInicio, $fechaFin ) {
		$sql = "SELECT DATE_FORMAT( articulosprestamos.fechaEntrega,'%Y','es_MX')Año,
		DATE_FORMAT( articulosprestamos.fechaEntrega,'%M','es_MX')Mes,
		DATE_FORMAT( articulosprestamos.fechaEntrega,'%D','es_MX')Dia,
		tipoArticulo.tipoArticulo,Count(articulos.etiqueta) AS NumEntregas
		FROM tipoArticulo INNER JOIN (articulos INNER JOIN articulosprestamos
		ON articulos.idArticulo = articulosprestamos.idArticulo)
		ON tipoArticulo.idTipoArticulo = articulos.idTipoArticulo
		WHERE articulosprestamos.fechaEntrega>='$fechaInicio'
		AND articulosprestamos.fechaEntrega<='$fechaFin'
		GROUP BY ArticulosPrestamos.fechaEntrega, TipoArticulo.tipoArticulo";
		return ejecutarConsulta( $sql );
	}
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@public
	* Prestamos edificio area: realiza una consulta y un total
	* de los prestamos realizados segun el edificio y tipo de area de uso, por mes.
	* Ademas de filtrar los datos mediante rango de fechas.
	* DATE_FORMAT: es una funcion SQL, que permite
	* aplicar un formato de fecha tradicional a campos o valores de tipo date.
	* %Y para año, %M para mes, %D para establecer el dia y es_MX
	* paraestablecer  el formato en español mexico.
	* @param  date $fechaInicio parametro que recibe un dato de fecha inicial
	* @param  date $fechaFin   parametro que recibe un dato de fecha final
	* @return ejecucion SQL, con datos de la consulta.
	*/

	public function consultaUbicaciones( $fechaInicio, $fechaFin ) {
		$sql = "SELECT DATE_FORMAT( prestamos.fechaPrestamo,'%Y','es_MX')Año,
		DATE_FORMAT( prestamos.fechaPrestamo,'%M','es_MX')Mes,
		prestamos.edificio, prestamos.tipoArea, prestamos.descripcionArea,
		tipoarticulo.tipoArticulo, Count(prestamos.folio) AS TotalPrestamos
		FROM (articulos INNER JOIN (prestamos INNER JOIN articulosprestamos
		ON prestamos.idPrestamo = articulosprestamos.idPrestamo)
		ON articulos.idArticulo = articulosprestamos.idArticulo)
		INNER JOIN tipoarticulo ON articulos.idTipoArticulo = tipoarticulo.idTipoArticulo
		WHERE prestamos.fechaPrestamo>='$fechaInicio'
		AND prestamos.fechaPrestamo<='$fechaFin'
		GROUP BY MONTH(prestamos.fechaPrestamo), prestamos.edificio,
		prestamos.tipoArea,prestamos.descripcionArea, tipoarticulo.tipoArticulo
		ORDER BY prestamos.fechaPrestamo DESC";
		return ejecutarConsulta( $sql );
	}
	/*Articulos devueltos condicion: realizar una consuta del
	total de articulos pertados y condciones en que fueron entregados*/
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@public
	* Articulos devueltos condicion: realizar una consuta del
	* total de articulos pertados y condciones en que fueron devueltos por mes.
	* Ademas de filtrar los datos mediante rango de fechas.
	* DATE_FORMAT: es una funcion SQL, que permite aplicar un formato de fecha tradicional
	* a campos o valores de tipo date.
	* %Y para año, %M para mes, %D para establecer el dia y es_MX paraestablecer
	* el formato en español mexico.
	* @param  date $fechaInicio parametro que recibe un dato de fecha inicial
	* @param  date $fechaFin   parametro que recibe un dato de fecha final
	* @return ejecucion SQL, con datos de la consulta.
	*/

	public function consultaDevolucion( $fechaInicio, $fechaFin ) {
		$sql = "SELECT DATE_FORMAT( articulosprestamos.fechaDevolucion,'%Y','es_MX')Año,
		DATE_FORMAT( articulosprestamos.fechaDevolucion,'%M','es_MX')Mes,
		tipoarticulo.tipoArticulo AS TipoArticulo,
		articulosprestamos.condicionDevolucion AS Condicion, Count(articulos.etiqueta) AS Total
		FROM TipoArticulo INNER JOIN (articulos INNER JOIN articulosprestamos
		ON articulos.idArticulo = articulosprestamos.idArticulo)
		ON tipoArticulo.idTipoArticulo = articulos.idTipoArticulo
		WHERE articulosprestamos.devuelto='1'
		AND articulosprestamos.fechaDevolucion>='$fechaInicio'
		AND articulosprestamos.fechaDevolucion<='$fechaFin'
		GROUP BY MONTH(articulosprestamos.fechaDevolucion),
		articulosprestamos.condicionDevolucion,
		tipoArticulo.tipoArticulo, articulosprestamos.devuelto;";
		return ejecutarConsulta( $sql );
	}
	//Consulta prestamos por clientes
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@public
	* Consulta que contabiliza, los prestamos realizados por un cliente,
	* filtrando los datos por un rango de fecha
	* al recibir valores del tipo date mediante sus dos paramentros.
	* @param  date $fechaInicio parametro que recibe un dato de fecha inicial
	* @param  date $fechaFin   parametro que recibe un dato de fecha final
	* @return ejecucion SQL, con datos de la consulta.
	*/

	public function consultaPrestarios( $fechaInicio, $fechaFin ) {
		$sql = "SELECT DATE_FORMAT(prestamos.fechaPrestamo,'%Y','es_MX')Año,
		DATE_FORMAT(prestamos.fechaPrestamo,'%M','es_MX')Mes,
		clientes.matricula AS MatriculaCliente,
		CONCAT(datosgenerales.nombres,' ', datosgenerales.primerApellido,
		' ', datosgenerales.segundoApellido)AS Nombre,
		tipoarticulo.tipoArticulo AS Tipo,
		Count(articulos.etiqueta) AS NoArticulos
		FROM ((datosgenerales INNER JOIN clientes
		ON datosgenerales.idDatosGenerales = clientes.idDatosGenerales)
		INNER JOIN prestamos ON clientes.idClientes = prestamos.idClientes)
		INNER JOIN (tipoarticulo  INNER JOIN(Articulos INNER JOIN ArticulosPrestamos
		ON articulos.idArticulo = articulosprestamos.idArticulo)
		ON tipoarticulo.idTipoArticulo=articulos.idTipoArticulo)
		ON prestamos.idPrestamo = articulosprestamos.idPrestamo
		WHERE prestamos.fechaPrestamo>='$fechaInicio'
		AND prestamos.fechaPrestamo<='$fechaFin'
		GROUP BY Year(fechaPrestamo), Month(fechaPrestamo),
		clientes.matricula, tipoarticulo.idTipoArticulo";
		return ejecutarConsulta( $sql );
	}
	//FUNCIONES PARA ESTADISTICAS
	//Funciones para estadisticas del escritorio
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@public
	* Consulta para la estadistica de condciones devuelto, contabilizando
	* el total de condiciones segun el tipo de condicion
	* @return ejecucion SQL, con datos de la consulta.
	*/

	public function estadisticoCondicionDevueltoMes() {
		$sql = "SELECT  Count(articulos.etiqueta)
		AS Total, articulosprestamos.condicionDevolucion
		AS CondicionDevuelto
		FROM tipoarticulo
		INNER JOIN (articulos INNER JOIN articulosprestamos ON
		articulos.idArticulo = articulosprestamos.idArticulo) ON
		tipoArticulo.idTipoArticulo = articulos.idTipoArticulo
		WHERE MONTH(articulosprestamos.fechaDevolucion)=MONTH(CURRENT_DATE)
		GROUP BY articulosprestamos.condicionDevolucion";
		return ejecutarConsulta( $sql );
	}
	//Estadistico total prestamos
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@public
	* Total de prestamos permite contar el total de articulos prestados
	* segun su tipo, esta conuslta selecciona los datos del mes actual
	* @return ejecucion SQL, con datos de la estadistica.
	*/

	public function estadisticoArticulosMes() {
		$sql = "SELECT Count(prestamos.folio) AS TotalPrestamos,
		tipoarticulo.tipoArticulo AS Tipo
		FROM tipoarticulo INNER JOIN (articulos INNER JOIN
		(prestamos INNER JOIN articulosprestamos ON
		prestamos.idPrestamo = articulosprestamos.idPrestamo)
		ON articulos.idArticulo = articulosprestamos.idArticulo)
		ON tipoarticulo.idTipoArticulo = articulos.idTipoArticulo
		WHERE MONTH(prestamos.fechaPrestamo)=MONTH(CURRENT_DATE)
		GROUP BY tipoarticulo.tipoArticulo;";
		return ejecutarConsulta( $sql );
	}
	//Estadistico Ubicacion
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@public
	*Edificio y area, permite realizar un consulta del total de prestamos por edificion en base al mes actual
	* @return ejecucion SQL, con datos de la estadistica.
	*/

	public function estadisticoUbicacion() {
		$sql = "SELECT Prestamos.edificio,  Count(Prestamos.folio)AS Total
		FROM Prestamos
		WHERE MONTH(prestamos.fechaPrestamo)=MONTH(CURRENT_DATE)
		GROUP BY Prestamos.edificio";
		return ejecutarConsulta( $sql );
	}
	//Entregas por usuario
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@public
	* Esta estadistica filtra los usuarios que atendieron prestamos en el mes
	* haciendo el servicio de entrega de equipos y contabilizando el total por usuario.
	* @return ejecucion SQL, con datos de la estadistica.
	*/

	public function estadisticoEntrega() {
		$sql = "SELECT usuarios.aliasUsuario, servicio.tipoServicio,
		COUNT( prestamos.folio) as total FROM usuarios
		INNER JOIN (prestamos INNER JOIN servicio ON
		prestamos.idPrestamo = servicio.idPrestamo)
		ON usuarios.idUsuarios = servicio.idUsuarios
		WHERE MONTH(servicio.fechaServicio)=MONTH(CURRENT_DATE)
		AND servicio.tipoServicio='Entrega'
		GROUP BY usuarios.aliasUsuario, servicio.tipoServicio";
		return ejecutarConsulta( $sql );
	}
	//Devoluciones por usuario
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@public
	* Esta estadistica filtra los usuarios que atendieron prestamos en el mes
	* haciendo el servicio de devolucion de equipos y contabilizando el total por usuario.
	* @return ejecucion SQL, con datos de la estadistica.
	*/

	public function estadisticoDevolucion() {
		$sql = "SELECT usuarios.aliasUsuario, servicio.tipoServicio,
		COUNT( prestamos.folio) as total FROM usuarios INNER JOIN
		(prestamos INNER JOIN servicio
		ON prestamos.idPrestamo = servicio.idPrestamo)
		ON usuarios.idUsuarios = servicio.idUsuarios
		WHERE MONTH(servicio.fechaServicio)=MONTH(CURRENT_DATE)
		AND servicio.tipoServicio='Devolucion'
		GROUP BY usuarios.aliasUsuario, servicio.tipoServicio;";
		return ejecutarConsulta( $sql );
	}
	//Estadistica totales
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@public
	* Estadistica que contabiliza el total de prestamos durante doce mese ( año )por mes
	* @return ejecucion SQL, con datos de la estadistica.
	*/

	public function estadisticoTotales() {
		$sql = "SELECT DATE_FORMAT(prestamos.fechaPrestamo,'%M','es_MX') AS Fecha,
		COUNT(prestamos.folio) AS EntregasTotales FROM prestamos
		WHERE YEAR(prestamos.fechaPrestamo)=YEAR(CURRENT_DATE)
		GROUP BY MONTH(prestamos.fechaPrestamo)
		ORDER BY prestamos.fechaPrestamo ASC LIMIT 0,12;";
		return ejecutarConsulta( $sql );
	}

	//Funciones para informacion, permite proyectar datos rapidos de los prestamos por dia.
	//Prestamos totales en el año
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@public
	* Consulta rapido de lo prestamos realizados durante el año
	* @return ejecucion SQL, con datos de la cpnsulta rapida.
	*/

	public function totalAnual() {
		$sql = "SELECT
		COUNT(prestamos.folio) AS TotalAnual FROM prestamos
		WHERE YEAR(prestamos.fechaPrestamo)=YEAR(CURRENT_DATE)";
		return ejecutarConsulta( $sql );
	}
	//Prestamos entregados
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@public
	* Consulta rapido de lo prestamos entregados durante el dia
	* @return ejecucion SQL, con datos de la cpnsulta rapida.
	*/

	public function prestamosEntregados() {
		$sql = "SELECT IFNULL(COUNT(prestamos.folio),0 )AS TotalEntregas
		FROM prestamos WHERE prestamos.fechaPrestamo=CURRENT_DATE;";
		return ejecutarConsulta( $sql );
	}
	//Prestamos cerrados
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@public
	* Consulta rapido de lo prestamos devueltos durante el dia
	* @return ejecucion SQL, con datos de la estadistica.
	*/

	public function prestamosCerrados() {
		$sql = "SELECT IFNULL(COUNT(prestamos.folio),0 )AS TotalCerrados
		FROM prestamos WHERE prestamos.estado='Cerrado'
		AND prestamos.fechaCierre=CURRENT_DATE";
		return ejecutarConsulta( $sql );
	}
	//Consulta rapido de lo articulos entregados durante el dia
	//Entregados
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@public
	* [[Description]]
	* @return ejecucion SQL, con datos de la estadistica.
	*/

	public function articulosEntregados() {
		$sql = "SELECT IFNULL(COUNT(articulosprestamos.idArticulo),0 )
		AS EntregasTotales
		FROM articulosprestamos
		WHERE articulosprestamos.fechaEntrega=CURRENT_DATE";
		return ejecutarConsulta( $sql );
	}
	//Consulta rapido de lo articulos devueltos durante el dia
	//Devueltos
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@public
	* [[Description]]
	* @return ejecucion SQL, con datos de la estadistica.
	*/

	public function articulosDevueltos() {
		$sql = "SELECT IFNULL(COUNT(articulosprestamos.idArticulo),0 )
		AS DevueltosTotales
		FROM articulosprestamos
		WHERE articulosprestamos.devuelto='1'
		AND articulosprestamos.fechaDevolucion=CURRENT_DATE";
		return ejecutarConsulta( $sql );
	}
	//Consultas para reportes
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@public
	* Consulta para el reporte de los prestamos realizados que recibe
	* como parametros un rago de fechas definido por las variables $fechaInicio y $fechaFin
	* @param  date $fechaInicio parametro que recibe un dato de fecha inicial
	* @param  date $fechaFin   parametro que recibe un dato de fecha final
	* @return ejecucion SQL, con datos de la consulta.
	*/

	public function reporte( $fechaInicio, $fechaFin ) {
		$sql = "SELECT prestamos.folio AS NumFolio,
		Year(fechaPrestamo) AS Año,
		Month(fechaPrestamo) AS Mes,
		Day(fechaPrestamo) AS Dia,
		clientes.matricula AS Matricula,
		datosgenerales.nombres AS Nombre,
		datosgenerales.primerApellido AS PrimerApellido,
		datosgenerales.segundoApellido AS SegundoApellido,
		prestamos.edificio AS Edificio,
		prestamos.tipoArea AS TipoArea,
		prestamos.descripcionArea AS Area,
		prestamos.estado AS Finalizado,
		Count(articulos.etiqueta) AS NumArticulos
		FROM ((datosgenerales INNER JOIN clientes ON
		datosgenerales.idDatosGenerales = clientes.idDatosGenerales)
		INNER JOIN Prestamos ON
		clientes.idClientes = prestamos.idClientes)
		INNER JOIN (articulos INNER JOIN articulosprestamos ON
		articulos.idArticulo = articulosprestamos.idArticulo) ON
		prestamos.idPrestamo = articulosprestamos.idPrestamo
		WHERE fechaPrestamo>='$fechaInicio'AND fechaCierre<='$fechaFin'
		GROUP BY prestamos.folio,
		Year(fechaPrestamo),
		Month(fechaPrestamo),
		Day(fechaPrestamo), clientes.matricula,
		datosgenerales.nombres,
		datosgenerales.primerApellido ,
		datosgenerales.segundoApellido,
		prestamos.edificio,
		prestamos.tipoArea,
		prestamos.descripcionArea,
		prestamos.estado";
		return ejecutarConsulta( $sql );
	}
	//Cabecera
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@public
	* Consulta para el reporte indivual del prestamo realizado donde recolecta
	* los datos para la cabecera de la tabla prestamos, datos del prestamo realizo
	* como cliente, ubicacion fecha de realizacion y cierre
	* @param  integer $idPrestamo parametro que recibe el id del prestamo para
	*  desplegar todos los datos relacionados al registro del prestamo.
	* @return ejecucion SQL, con datos de la consulta.
	*/

	public function cabecera( $idPrestamo ) {
		$sql = "SELECT prestamos.folio AS NumFolio,
		prestamos.fechaPrestamo AS Fecha,
		clientes.matricula AS Matricula,
		datosgenerales.nombres AS Nombre,
		datosgenerales.primerApellido AS PrimerApellido,
		datosgenerales.segundoApellido AS SegundoApellido,
		prestamos.edificio AS Edificio, prestamos.tipoArea AS TipoArea,
		prestamos.descripcionArea AS Area,
		prestamos.estado AS Finalizado,
		prestamos.fechaCierre AS FechaCierre,
		Count(articulos.etiqueta) AS NumArticulos
		FROM ((datosgenerales INNER JOIN clientes ON
		datosgenerales.idDatosGenerales = clientes.idDatosGenerales)
		INNER JOIN Prestamos
		ON clientes.idClientes = prestamos.idClientes)
		INNER JOIN (articulos INNER JOIN articulosprestamos ON
		articulos.idArticulo = articulosprestamos.idArticulo) ON
		prestamos.idPrestamo = articulosprestamos.idPrestamo
		WHERE prestamos.idPrestamo='$idPrestamo'
		GROUP BY prestamos.folio, Year(fechaPrestamo),
		Month(fechaPrestamo),
		Day(fechaPrestamo), clientes.matricula,
		datosgenerales.nombres, datosgenerales.primerApellido,
		datosgenerales.segundoApellido, prestamos.edificio,
		prestamos.tipoArea,
		prestamos.descripcionArea,
		prestamos.estado";
		return ejecutarConsulta( $sql );
	}
	//Cuerpo
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@public
	* Consulta que en lista los datos de los articulos prestados
	* para el reporte y ser insertados posteriormente en una tabla
	* @param  integer $idPrestamo parametro que recibe el id del
	* prestamo para desplgegar los registro que cotengar
	* como clave foranea el valor del parametro establecido.
	* @return ejecucion SQL, con datos de la consulta.
	*/

	public function cuerpo( $idPrestamo ) {
		$sql = "SELECT articulosPrestamos.idArticuloPrestamo AS Identificador,
		articulos.etiqueta AS Articulo, articulosprestamos.condicionEntrega AS
		CondicionEntrega , articulosprestamos.fechaDevolucion AS FechaDevolucion,
		articulosprestamos.condicionDevolucion AS CondicionDevolucion,
		articulosprestamos.observacionDevolucion AS Observaciones
		FROM articulos INNER JOIN (prestamos INNER JOIN articulosprestamos
		ON prestamos.idPrestamo = articulosprestamos.idPrestamo)
		ON articulos.idArticulo = articulosprestamos.idArticulo
		WHERE articulosprestamos.idPrestamo='$idPrestamo'";
		return ejecutarConsulta( $sql );
	}
	//Servicio entrega
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@public
	* Consulta que permite obtener el usuario que atendido
	* el prestamo como servicio de entrega
	* @param  integer $idPrestamo, parametro que desplega informacion
	* relacionado a su clave foranea establecido por el id del prestamo.
	* @return ejecucion SQL, con datos de la consulta.
	*/

	public function servicioEntrega( $idPrestamo ) {
		$sql = "SELECT usuarios.aliasUsuario AS Alias ,
		servicio.tipoServicio AS Servicio,
		servicio.fechaServicio AS FechaServicio
		FROM usuarios INNER JOIN servicio
		ON usuarios.idUsuarios = servicio.idUsuarios
		WHERE servicio.idPrestamo='$idPrestamo'
		AND tipoServicio='Entrega'";
		return ejecutarConsulta( $sql );
	}
	//Servicio devolucion
	/**
	*@author Sergio Gpe. Gonzalez Chavez
	*@public
	* Consulta que permite obtener el usuario que atendido el prestamo como servicio de devolucion
	* @param  integer $idPrestamo, parametro que desplega informacion relacionado a su
	* clave foranea establecido por el id del prestamo.
	* @return ejecucion SQL, con datos de la consulta.
	*/

	public function servicioDevolucion( $idPrestamo ) {
	$sql = "SELECT usuarios.aliasUsuario AS Alias ,
		servicio.tipoServicio AS Servicio,
		servicio.fechaServicio AS FechaServicio
		FROM usuarios INNER JOIN servicio
		ON usuarios.idUsuarios = servicio.idUsuarios
		WHERE servicio.idPrestamo='$idPrestamo'
		AND tipoServicio='Devolucion'";
		return ejecutarConsulta( $sql );
	}
}
?>
