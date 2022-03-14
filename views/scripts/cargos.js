/*Crear la variable global tabla para realizar el procedimiento de enlistar los registros*/
var tabla;
//Init
//Funcion que se ejecuta al inicio
function init() {
	/*Llamar la funcion listar se ejecuta al incio para visualizar todos los registros en una tabla de datatables*/
	listar();
}
//Limpiar
//Declarar la funcion limpiar para vaciar los campos del formulario
function limpiar() {
	//Declarar los campos a limpiar
	$("#idCargo").val("");
	$("#cargoCliente").val("");
}
//Listar
//Declararr la funcion listar
function listar() {
	//Establecer el elemento HTML de la tabla en la variable global mediante el id de la tabla (#tbllistado)
	tabla = $('#tbllistado').dataTable({
		"aProcessing": true, //Activar el procesamiento del datatables
		"aServerSide": true, //Paginación y filtrado realizados por el servidor
		dom: 'lBfrtip', //Definimos los elementos del control de tabla
		buttons: [
					'copyHtml5', //Exportar en HTML
					'excelHtml5', //Exportar en Excel
					'csvHtml5', //Exportar en CSV
					'pdf' //Exportar en PDF
				],
		//Indicar si la tabla es responsive
		responsive: true,
		/*Mediante operaciones ajax recibir los valores para enlistar los registros de la consulta*/
		"ajax": {
			//Indicar la url del archivo y donde obtivene los datos
			url: '../ajax/cargos.php?op=listar',
			//Indicar el tipo de operacion para optener los datos
			type: "get",
			//Formato de los datos codificados
			dataType: "json",
			//Desplegar un mensaje de error
			error: function (e) {
				console.log(e.responseText);
			}
		},
		//Desplegar la informacion del data tables en español
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
		//Paginacion delos resultados del datatable
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"bDestroy": true,
		"iDisplayLength": 15, //Paginación
		"order": [[0, "desc"]] //Ordenar (columna,orden)
	}).DataTable();
}
//Guardar y editar
/*Declarar la funcion guardar y editar para la creacion o edicion de resgitros*/
function guardaryeditar() {
	//Al seleccionar el boton (#btnGuardar), se desahabilitara
	$("#btnGuardar").prop("disable", true);
	//Obtener los valores de lo elementos del formulario mediante el id del formulario (#formulario)
	var formData = new FormData($("#formulario")[0]);
	//Metodo ajax para el envio de los datos del formulario
	$.ajax({
		url: "../ajax/cargos.php?op=guardaryeditar",
		type: "POST", //Envio de datos mediante el tipo post
		data: formData,
		//Enviar los datos almacenados de la variable formData
		contentType: false,
		processData: false,

		success: function (datos) { //Enviar un alert
			bootbox.alert(datos);
			//Recargar la tabla de los registros
			tabla.ajax.reload();
		}
	});
	//Instanciar la funcion limpiar para vaciar el formulario
	limpiar();
}
//Mostrar
/*Declarar la funcion mostrar, para visulaizar los valores de un registro en un formulario, al recibir el id del registro, para obtener los datos*/
function mostrar(idCargo) {
	/*Mediante Jquery del metodo post, indicar la URL del archivo y funcion se obtendran los datos*/
	$.post("../ajax/cargos.php?op=mostrar", {
		idCargo: idCargo //indicar el parametro del id del registro
	}, function (data, status) {
		data = JSON.parse(data); //Converitr los datos a un objeto javascript
		//Declarar los inputs donde se devolveran los valores almacenados
		$("#cargoCliente").val(data.cargoCliente);
		$("#idCargo").val(data.idCargo);
	})
}
//Instaciar la funcion init para ejecutar al inicio y las funcion dentro de esta
init();
