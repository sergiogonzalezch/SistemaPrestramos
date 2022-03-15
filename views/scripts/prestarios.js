/*Crear la variable global tabla para realizar el
procedimiento de enlistar los registros*/
var tabla;
//Init
//Función que se ejecuta al inicio
function init() {
	/*Llamar a la función mostrar el formulario con el
	valor de su parámetro como false para no visualizarlo*/
	mostrarform(false);
	/*Llamar a la función listar se ejecuta al inicio
	para visualizar todos los registros en una tabla de datatables*/
	listar();
	//Función para subir los datos del formulario y almacenarlos
	$("#formulario").on("submit", function (e) {
		//Llamar al metodo guardar
		guardaryeditar(e);
	});
	/*Mediante Jquery del metodo post, indicar la URL del
	archivo y función donde se obtendrán los datos y visualizarlos
	en el elemento input de tipo select de HTML*/
	$.post("../ajax/prestarios.php?op=selecPrograma", function (r) {
		$("#idProgramaEducativo").html(r);
		//Refrescar el select
		$('#idProgramaEducativo').selectpicker('refresh');
	});
	/*Mediante Jquery del metodo post, indicar la URL del archivo
	y función donde se obtendrán los datos y visualizarlos en el elemento
	input de tipo select de HTML*/
	$.post("../ajax/prestarios.php?op=selecCargo", function (r) {
		$("#idCargo").html(r);
		//Refrescar el select
		$('#idCargo').selectpicker('refresh');
	});
}
//Limpiar
//Declarar una función para limpiar los inputs del formulario
function limpiar() {
	$("#idDatosGenerales").val("");
	$("#idClientes").val("");
	$("#nombres").val("");
	$("#primerApellido").val("");
	$("#segundoApellido").val("");
	$("#correoInstitucional").val("");
	$("#matricula").val("");
	$("#idProgramaEducativo").val("");
	$("#idProgramaEducativo").selectpicker('refresh');
	$("#idCargo").val("");
	$("#idCargo").selectpicker('refresh');
}
//Mostrar formulario
//Declarar la función para visualizar los objetos del formulario (inputs y secciones)
function mostrarform(flag) {
	limpiar();
	if (flag) {
		/*Si el valor de la bandera (flag) es igual a verdadero
		el formulario  y sus elementos serán desplegados mientras
		que los elementos del listado de registros serán ocultados
		como aquellos elementos que no son parte del formulario*/
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disable", false);
		$("#btnadd").hide();
		$("#btnnew").hide();
	} else {
		/*Si el valor de la bandera (flag) es igual a falso
		entonces los elementos del formulario serán ocultados
		y el resto serán visibles*/
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnadd").show();
		$("#btnnew").show();
	}
}
//Cancelar formulario
//Declarar la función cancelar formulario
function cancelarform() {
	/*Llamar la función para limpiar los campos del formulario*/
	limpiar();
	/*Llamar la función mostrarform con valor de parámetro false,
	para indicar que ocultara los elementos del formulario*/
	mostrarform(false);
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
					'copyHtml5', //Exportar en HTML
					'excelHtml5', //Exportar en Excel
					'csvHtml5', //Exportar en CSV
					'pdf' //Exportar en PDF
				],
		//Indicar si la tabla es responsive
		responsive: true,
		/*Mediante operaciones ajax recibir los valores para enlistar
		los registros de la consulta*/
		"ajax": {
			//Indicar la url del archivo y donde obtiene los datos
			url: '../ajax/prestarios.php?op=listar',
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
		"iDisplayLength": 25, //Paginación
		"order": [[0, "desc"]] //Ordenar (columna,orden)
	}).DataTable();
}
//Guardar y editar
/*Declarar la función guardar y editar para la creación o edición de registros*/
function guardaryeditar(e) {
	//Evitar que la función se ejecute al inicio del proceso, permitiendo que los demás se ejecuten en orden
	e.preventDefault();
	//Al seleccionar el botón (#btnGuardar), se deshabilitará
	$("#btnGuardar").prop("disable", true);
	//Obtener los valores de los elementos del formulario mediante el id del formulario (#formulario)
	var formData = new FormData($("#formulario")[0]);
	//Metodo ajax para el envío de los datos del formulario
	$.ajax({
		//Indicar la dirección url del archivo para el envío de los datos
		url: "../ajax/prestarios.php?op=guardaryeditar",
		type: "POST", //Envío de datos mediante el tipo post
		data: formData, //Enviar los datos almacenados de la variable formData
		contentType: false,
		processData: false,
		success: function (datos) {
			//Enviara un mensaje de alerta
			bootbox.alert(datos);
			//Ocultar el formulario mediante la función mostrarform
			mostrarform(false);
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
function mostrar(idDatosGenerales) {
	/*Mediante Jquery del metodo post, indicar la URL del archivo
	y función donde se obtendrán los datos*/
	$.post("../ajax/prestarios.php?op=mostrar", {
		idDatosGenerales: idDatosGenerales //indicar el parámetro del id del registro
	}, function (data, status) { //Función  donde obtener los valores del registro
		data = JSON.parse(data); //Convertirlos datos a un objeto JavaScript
		mostrarform(true); //Mostrar el formulario mediante la función mostrarform con el parámetro true
		//Declarar los inputs donde se devolverán los valores almacenados
		$("#idDatosGenerales").val(data.idDatosGenerales);
		$("#nombres").val(data.nombres);
		$("#primerApellido").val(data.primerApellido);
		$("#segundoApellido").val(data.segundoApellido);
		$("#correoInstitucional").val(data.correoInstitucional);
		$("#matricula").val(data.matricula);
		$("#idProgramaEducativo").val(data.idProgramaEducativo);
		//Refrescar el select
		$("#idProgramaEducativo").selectpicker('refresh');
		$("#idCargo").val(data.idCargo);
		//Refrescar el select
		$("#idCargo").selectpicker('refresh');
	})
}
//Instanciar la función init para ejecutar al inicio y las funciones dentro de esta
init();
