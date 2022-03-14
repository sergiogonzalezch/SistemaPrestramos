<?php
//Incluir la conexion a la base de datos
require "../config/conexion.php";
Class UsuariosExistente {
	//Constructor

	public function _construct() {
	}
	//Metodos para insertar
	/**
	 *@author Sergio Gpe. Gonzalez Chavez
	 *@public
	 * Metodo que permite registrar un nuevo usuario en base a un solicitante existente,
	 * para acceder al sistema.
	 * @param  string $rolUsuario   rol que desempeñara en el sistema sea un
	 * administrador o prestamista
	 * @param  string $contrasenaUsuario contraseña del usuario
	 * @param  string $aliasUsuario  nombre con el cual el usuario estara dentro del sistema
	 * @param  string $imagen  nombre de la imagen
	 * @param  integer $idDatosGenerales  id que permite la relacion entre los datos
	 * del usuario y los datos gernerales
	 * @return Retorna una ejecucion SQL
	 */
	public function insertar( $rolUsuario,
	$contrasenaUsuario,
	$aliasUsuario,
	$imagen,
	$idDatosGenerales ) {
		$sql = "INSERT INTO usuarios(rolUsuario,
		contrasenaUsuario,
		aliasUsuario,
		imagen,
		idDatosGenerales)
		VALUES ('$rolUsuario',
		'$contrasenaUsuario',
		'$aliasUsuario',
		'$imagen',
		'$idDatosGenerales')";
		return ejecutarConsulta( $sql );
	}
}
?>
