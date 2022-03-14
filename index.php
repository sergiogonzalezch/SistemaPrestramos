<?php
session_start();
if ( isset( $_SESSION['usuarios'] ) ) {
	if ( $_SESSION['usuarios']['rolUsuario'] == "Administrador" ||
	$_SESSION['usuarios']['rolUsuario'] == "Prestador" ) {
		header( 'Location:views/escritorio.php' );
	}
} else {
	header( 'Location:views/login.html' );
}

?>
