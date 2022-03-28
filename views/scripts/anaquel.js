/*Crear variable tabla para realizar el
procedimiento de enlistar los registros*/
var tabla;
//Init
//Función que se ejecuta al inicio
function init() {
	/*Llamar a la función listar se ejecuta al inicio
	para visualizar todos los registros en una tabla
	de datatables*/
	listar();
}
//Limpiar
//Declarar una función para limpiar los inputs del formulario
function limpiar() {
	//Declarar los campos a limpiar
	$("#idAnaquel").val("");
	$("#anaquelNumero").val("");
	$("#descripcionAnaquel").val("");
}
//Listar
/*Declarar función listar que permite visualizar
los registro de un a consulta*/
function listar() {
	/*Establecer el elemento HTML de la tabla en la variable
	global mediante el id de la tabla(#tbllistado)*/
	tabla = $('#tbllistado').dataTable({
		"aProcessing": true, //Activar el procesamiento del datatables
		"aServerSide": true, //Paginación y filtrado realizados por el servidor
		dom: 'lBfrtip', //Definir los elementos del control de tabla
		//Definir los botones para exportación de datos
		buttons: [
					'copyHtml5', //Exportar en HTML
					'excelHtml5', //Exportar en Excel
					'csvHtml5', //Exportar en CSV
					'pdf' //Exportar en PDF
				],
		//Indicar si la tabla es responsive
		responsive: true,
		/*Mediante operaciones ajax recibir los valores para
		enlistar los registros de la consulta*/
		"ajax": {
			//Indicar la url del archivo y donde obtiene los datos
			url: '../ajax/anaquel.php?op=listar',
			//Indicar el tipo de operación para obtener los datos
			type: "get",
			//Formato de los datos codificados
			dataType: "json",
			//Desplegar un mensaje de error
			error: function (e) {
				console.log(e.responseText);
			}
		},
		//Desplegar la información del datatables en español
		"autoWidth": false,
		"language": {
			"lengthMenu": "Mostrando _MENU_ registros por página",
			"zeroRecords": "No se encontraron resultados",
			"info": "Mostrando página _PAGE_ de _PAGES_",
			"infoEmpty": "Registros no hábiles",
			"infoFiltered": "(Filtrado desde _MAX_ el total de registros)",
			"search": "Buscar:",
			"paginate": {
				"first": "Primero",
				"last": "Último",
				"next": "Siguiente",
				"previous": "Anterior"
			}
		},
		//Paginación de los resultados del datatables
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"bDestroy": true,
		"iDisplayLength": 15, //Paginación
		"order": [[0, "desc"]] //Ordenar (columna,orden)
	}).DataTable();
}
//Guardar y editar
/*Declarar la función guardar y editar para la creación
o edición de registros*/
function guardaryeditar() {
	//Al seleccionar el botón (#btnGuardar), se deshabilitará
	$("#btnGuardar").prop("disable", true);
	/*Obtener los valores de los elementos del formulario
	mediante el id del formulario(#formulario)*/
	var formData = new FormData($("#formulario")[0]);
	//Metodo ajax para el envío de los datos del formulario
	$.ajax({
		//Indicar la dirección url del archivo para el envío de los datos
		url: "../ajax/anaquel.php?op=guardaryeditar",
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
//Mostrar
/*Declarar la función mostrar, para visualizar los valores
de un registro en un formulario, al recibir el id del registro,
para obtener los datos*/
function mostrar(idAnaquel) {
	/*Mediante jQuerydel metodo post, indicar la URL del archivo
	y función donde se obtendrán los datos*/
	$.post("../ajax/anaquel.php?op=mostrar", {
		idAnaquel: idAnaquel //indicar el parámetro del id del registro
	}, function (data, status) { //Función  donde obtener los valores del registro
		data = JSON.parse(data); //Convertirlos datos a un objeto JavaScript
		//Declarar los inputs donde se devolverán los valores almacenados
		$("#anaquelNumero").val(data.anaquelNumero);
		$("#descripcionAnaquel").val(data.descripcionAnaquel);
		$("#idAnaquel").val(data.idAnaquel);
	})
}
//Instanciar la función init para ejecutar al inicio y las funciones dentro de esta
init();
