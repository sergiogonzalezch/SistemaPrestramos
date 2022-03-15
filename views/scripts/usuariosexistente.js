/*Crear la variable global tabla para realizar el procedimiento
de enlistar los registros*/
var tabla;
//Init
//Función que se ejecuta al inicio
function init() {
	//Función para subir los datos del formulario y almacenarlos
	$("#formulario").on("submit", function (e) {
		//Llamar al metodo guardar
		guardar(e);
	});
	/*Mediante Jquery del metodo post, indicar la URL del archivo y
	función donde se obtendrán los datos y visualizarlos en el elemento input
	de tipo select de HTML*/
	$.post("../ajax/usuariosexistentes.php?op=selecDato", function (r) {
		$("#idDatosGenerales").html(r);
		$("#idDatosGenerales").val("");
		$('#idDatosGenerales').selectpicker('refresh');
	});
	//Ocultat la imagen de perfil
	$("#imagenmuestra").hide();
	//Visualizar los valores del select
	$("#rolUsuario").val("");
	//Refrescar el select
	$("#rolUsuario").selectpicker('refresh');
}
//Limpiar
//Declarar una función para limpiar los inputs del formulario
function limpiar() {
	$("#idUsuarios").val("");
	$("#rolUsuario").val("");
	$("#rolUsuario").selectpicker('refresh');
	$("#contrasenaUsuario").val("");
	$("#aliasUsuario").val("");
	$("#imagenmuestra").attr("src", "");
	$("#imagenactual").val("");
	$("#idDatosGenerales").val("");
	$("#idDatosGenerales").selectpicker('refresh');
}
//Guardar
/*Declarar la función guardar para la creación de registros*/
function guardar(e) {
	//Evitar que la función se ejecute al inicio del proceso,
	permitiendo que los demás se ejecuten en orden
	e.preventDefault();
	//Al seleccionar el botón (#btnGuardar), se deshabilitará
	$("#btnGuardar").prop("disable", true);
	//Obtener los valores de los elementos del formulario mediante el
	id del formulario(#formulario)
	var formData = new FormData($("#formulario")[0]);
	//Metodo ajax para el envío de los datos del formulario
	$.ajax({
		url: "../ajax/usuariosexistentes.php?op=guardar",
		type: "POST", //Envío de datos mediante el tipo post
		data: formData, //Enviar los datos almacenados de la variable formData
		contentType: false,
		processData: false,
		success: function (datos) {
			//Enviara un mensaje de alerta
			bootbox.alert(datos);
			//Recargar la tabla de los registros
			tabla.ajax.reload();
		}
	});
	//Instanciar la función limpiar para vaciar el formulario
	limpiar();
}
//Instanciar la función init para ejecutar al inicio y las funciones dentro de esta
init();
