/*Crear la variable global tabla para realizar el procedimiento de enlistar los registros*/
var tabla;
//Init
//Funcion que se ejecuta al inicio
function init() {
	//Funcion para subir los datos del formulario y almacenarlos
	$("#formulario").on("submit", function (e) {
		//Llamar al metodo guardar
		guardar(e);
	});
	/*Mediante Jquery del metodo post, indicar la URL del archivo y funcion se obtendran los datos y visulizarlos en el elemento input de tipo select de HTML*/
	$.post("../ajax/prestariosexistentes.php?op=selecDato", function (r) {
		$("#idDatosGenerales").html(r);
		$("#idDatosGenerales").val("");
		$('#idDatosGenerales').selectpicker('refresh');
	});
	/*Mediante Jquery del metodo post, indicar la URL del archivo y funcion se obtendran los datos y visulizarlos en el elemento input de tipo select de HTML*/
	$.post("../ajax/prestariosexistentes.php?op=selecPrograma", function (r) {
		$("#idProgramaEducativo").html(r);
		$("#idProgramaEducativo").val("");
		$('#idProgramaEducativo').selectpicker('refresh');
	});
	/*Mediante Jquery del metodo post, indicar la URL del archivo y funcion se obtendran los datos y visulizarlos en el elemento input de tipo select de HTML*/
	$.post("../ajax/prestariosexistentes.php?op=selecCargo", function (r) {
		$("#idCargo").html(r);
		$("#idCargo").val("");
		$('#idCargo').selectpicker('refresh');
	});

}
//Limpiar
//Declarar una funcion para limpiar los inputs del formulario
function limpiar() {
	$("#idClientes").val("");
	$("#matricula").val("");
	$("#idDatosGenerales").val("");
	$("#idDatosGenerales").selectpicker('refresh');
	$("#idProgramaEducativo").val("");
	$("#idProgramaEducativo").selectpicker('refresh');
	$("#idCargo").val("");
	$("#idCargo").selectpicker('refresh');
}
//Guardar
/*Declarar la funcion guardar para la creacion de resgitros*/
function guardar(e) {
	//Evitar que la funcion se ejecute al inicio del proceso, permitiendo que los demas se ejecuten en orden
	e.preventDefault();
	//Al seleccionar el boton (#btnGuardar), se desahabilitara
	$("#btnGuardar").prop("disable", true);
	//Obtener los valores de lo elementos del formulario mediante el id del formulario (#formulario)
	var formData = new FormData($("#formulario")[0]);
	//Metodo ajax para el envio de los datos del formulario
	$.ajax({
		//Indicar la direccion url del archivo para el envio de los datos
		url: "../ajax/prestariosexistentes.php?op=guardar",
		type: "POST", //Envio de datos mediante el tipo post
		data: formData, //Enviar los datos almacenados de la variable formData
		contentType: false,
		processData: false,
		success: function (datos) {
			//Enviar un alert
			bootbox.alert(datos);
			//Recargar la tabla de los registros
			tabla.ajax.reload();
		}
	});
	//Instanciar la funcion limpiar para vaciar el formulario
	limpiar();
}
//Instaciar la funcion init para ejecutar al inicio y las funcion dentro de esta
init();
