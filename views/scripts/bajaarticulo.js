/*Crear la variable global tabla para realizar el
procedimiento de enlistar los registros*/
var tabla;
//Init
//Función que se ejecuta al inicio
function init() {
	/*Llamar función mostrar el formulario con el
	valor de su parámetro como false para no visualizarlo*/
	/*mostrarform(false);
	Llamar la función listar se ejecuta al inicio para
	visualizar todos los registros en una tabla de datatables*/
	listar();
}
//Limpiar
//Declarar la función limpiar para vaciar los campos del formulario
function limpiar() {
	//Declarar los campos a limpiar
	$("#idBaja").val("");
	$("#observacionBaja").val("");
}
//Listar
//Declarar la función listar
function listar() {
	/*Establecer el elemento HTML de la tabla en la variable
	global mediante el id de la tabla (#tbllistado)*/
	tabla = $('#tbllistado').dataTable({
		"aProcessing": true, //Activar el procesamiento del datatables
		"aServerSide": true, //Paginación y filtrado realizados por el servidor
		dom: 'lBfrtip', //Definimos los elementos del control de tabla
		buttons: [
					'copyHtml5',
					'excelHtml5',
					'csvHtml5',
					'pdf'
				],
		responsive: true,

		"ajax": {
			url: '../ajax/bajaarticulo.php?op=listar',
			type: "get",
			dataType: "json",
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
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"bDestroy": true,
		"iDisplayLength": 25, //Paginación
		"order": [[0, "desc"]] //Ordenar (columna,orden)
	}).DataTable();
}
//Guardar y editar
/*Declarar la función guardar y editar para la creación o edición de registros*/
function guardaryeditar() {
	//Al seleccionar el botón (#btnGuardar), se deshabilitará
	$("#btnGuardar").prop("disable", true);
	//Obtener los valores de los elementos del formulario mediante el id del formulario (#formulario)
	var formData = new FormData($("#formulario")[0]);
	//Metodo ajax para el envío de los datos del formulario
	$.ajax({
		//Indicar la dirección url del archivo para el envío de los datos
		url: "../ajax/bajaarticulo.php?op=guardaryeditar",
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
/*Declarar la función mostrar, para visualizar los valores de un
registro en un formulario, al recibir el id del registro,
para obtener los datos*/
function mostrar(idBaja) {
	/*Mediante jQuerydel metodo post, indicar la URL del archivo
	y función donde se obtendrán los datos*/
	$.post("../ajax/bajaarticulo.php?op=mostrar", {
		idBaja: idBaja //indicar el parámetro del id del registro
	}, function (data, status) { //Función  donde obtener los valores del registro
		data = JSON.parse(data); //Convertirlos datos a un objeto JavaScript
		//Declarar los inputs donde se devolverán los valores almacenados
		$("#idBaja").val(data.idBaja);
		$("#fechaBaja").val(data.fechaBaja);
		$("#observacionBaja").val(data.observacionBaja);
		$("#idArticulo").val(data.idArticulo);
	})
}
//Instanciar la función init para ejecutar al inicio y las funciones dentro de esta
init();
