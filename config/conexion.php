<?php
/*Llamar al archivo global.php para revcibir los valores
para laconexion a la base de datatos*/
require_once "global.php";
$conexion=new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

mysqli_query($conexion,'SET NAMES "'.DB_ENCODE.'"');
//Revisar si se establecio la conexion a la base datos fue existosa
if (mysqli_connect_errno())
{
	//Imprimir mensaje
	printf("Falló conexión a la base de datos: %$\n",mysqli_connect_error());
	exit();
}
//Función if para llamar funciones
if(!function_exists('ejecutarConsulta'))
	{
	//Ejecutar consulta SQL
		function ejecutarConsulta($sql)
		{
			global $conexion;
			$query = $conexion->query($sql);
			return $query;
		}
	//Retornar un fila
		function ejecutarConsultaSimpleFila($sql)
		{
			global $conexion;
			$query = $conexion->query($sql);
			$row =$query->fetch_assoc();
			return($row);
		}
	//Retornar el id de una consulta
		function ejecutarConsulta_retornarID($sql){
			global $conexion;
			$query = $conexion->query($sql);
			return $conexion->insert_id;
		}
	//Limpiar
		function limpiarCadena($str){
			global $conexion;
			$str = mysqli_real_escape_string($conexion,trim($str));
			return htmlspecialchars($str);
		}
	}

?>
