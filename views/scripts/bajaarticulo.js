/*Crear la variable global tabla para realizar el procedimiento de enlistar los registros*/
var tabla;
//Init
//Funcion que se ejecuta al inicio
function init() {
	/*Llamar funcion mostrar el formulario con el
	valor de su parametro como false para no visualizarlo*/
	mostrarform(false);
	/*Llamar la funcion listar se ejecuta al incio para visualizar todos los registros en una tabla de datatables*/
	listar();
	//Funcion para subir los datos del formulario y almacenarlos
	$("#formulario").on("submit", function (e) {
		//Llamar al metodo guardar
		guardaryeditar(e);
	});
}
//Limpiar
//Declarar la funcion limpiar para vaciar los campos del formulario
function limpiar() {
	//Declarar los campos a limpiar
	$("#idBaja").val("");
	$("#fechaBaja").val("");
	$("#observacionBaja").val("");
	$("#idArticulo").val("");
}
//Mostar formulario
//Declarar la funcion para visulalizar los objetos del formulario (inputs y secciones)
function mostrarform(flag) {
	limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disable", false);
		$("#btnadd").hide();
	} else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnadd").show();
	}
}
//Cancelar formulario
//Declarar la funcion cancelar formulario
function cancelarform() {
	limpiar();
	mostrarform(false);
}
//Listar
//Declarar la funcion listar
function listar() {
	//Establecer el elemento HTML de la tabla en la variable global mediante el id de la tabla (#tbllistado)
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
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"bDestroy": true,
		"iDisplayLength": 25, //Paginación
		"order": [[0, "desc"]] //Ordenar (columna,orden)
	}).DataTable();
}
//Guardar y editar
/*Declarar la funcion guardar y editar para la creacion o edicion de resgitros*/
function guardaryeditar(e) {
	//Evitar que la funcion se ejecute al inicio del proceso, permitiendo que los demas se ejecuten en orden
	e.preventDefault();
	//Al seleccionar el boton (#btnGuardar), se desahabilitara
	$("#btnGuardar").prop("disable", true);
	//Obtener los valores de lo elementos del formulario mediante el id del formulario (#formulario)
	var formData = new FormData($("#formulario")[0]);
	//Metodo ajax para el envio de los datos del formulario
	$.ajax({
		//Indicar la direccion url del archivo para el envio de los datos
		url: "../ajax/bajaarticulo.php?op=guardaryeditar",
		type: "POST", //Envio de datos mediante el tipo post
		data: formData, //Enviar los datos almacenoados de la variable formData
		contentType: false,
		processData: false,
		success: function (datos) {
			//Enviar un alert
			bootbox.alert(datos);
			//Ocular el formulario mediante la funcion mostrarform
			mostrarform(false);
			//Recargar la tabla de los registros
			tabla.ajax.reload();
		}
	});
	//Instanciar la funcion limpiar para vaciar el formulario
	limpiar();
}
//Mostrar
/*Declarar la funcion mostrar, para visulaizar los valores de un registro en un formulario, al recibir el id del registro, para obtener los datos*/
function mostrar(idBaja) {
	/*Mediante Jquery del metodo post, indicar la URL del archivo y funcion se obtendran los datos*/
	$.post("../ajax/bajaarticulo.php?op=mostrar", {
		idBaja: idBaja //indicar el parametro del id del registro
	}, function (data, status) { //Funcion  donde obtener los valores del registro
		data = JSON.parse(data); //Converitr los datos a un objeto javascript
		mostrarform(true); //Mostrar el formulario mediante la funcion mostrarform con el parametro true
		//Declarar los inputs donde se devolveran los valores almacenados
		$("#idBaja").val(data.idBaja);
		$("#fechaBaja").val(data.fechaBaja);
		$("#observacionBaja").val(data.observacionBaja);
		$("#idArticulo").val(data.idArticulo);
	})
}
//Instaciar la funcion init para ejecutar al inicio y las funcion dentro de esta
init();
