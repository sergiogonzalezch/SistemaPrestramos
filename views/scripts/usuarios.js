/*Crear la variable global tabla para realizar el procedimiento de enlistar los registros*/
var tabla;
//Init
//Funcion que se ejecuta al inicio
function init() {
	/*Llamar a la funcion mostrar el formulario con el
	valor de su parametro como false para no visualizarlo*/
	mostrarform(false);
	/*Llamar a la funcion listar se ejecuta al incio para visualizar todos los registros en una tabla de datatables*/
	listar();
	//Funcion para subir los datos del formulario y almacenarlos
	$("#formulario").on("submit", function (e) {
		//Llamar al metodo guardar
		guardaryeditar(e);
	})
	//Codigo para ocultar el elemento de formulario para visaulizar la imagen del articulo
	$("#imagenmuestra").hide();
}
//Limpiar
//Declarar una funcion para limpiar los inputs del formulario
function limpiar() {
	$("#idDatosGenerales").val("");
	$("#idClientes").val("");
	$("#nombres").val("");
	$("#primerApellido").val("");
	$("#segundoApellido").val("");
	$("#correoInstitucional").val("");
	$("#rolUsuario").val("");
	$("#rolUsuario").selectpicker('refresh');
	$("#contrasenaUsuario").val("");
	$("#aliasUsuario").val("");
	$("#imagenmuestra").attr("src", "");
	$("#imagenactual").val("");
}
//Mostrar formulario
//Declarar la funcion para visulalizar los objetos del formulario (inputs y secciones)
function mostrarform(flag) {
	limpiar();
	if (flag) {
		/*Si el valor de la bandera (flag) es igual a verdadero
		el formulario  y sus elementos seran desplegados mientras que los elementos del listado de registros seran ocultados como aquellos elementos que no son parte del formulario*/
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disable", false);
		$("#btnadd").hide();
		$("#btnusuario").hide();
	} else {
		/*Si el valor de la bandera (flag) es igual a falso entonces los elementos del formulario seran ocultados y el resto seran visibles*/
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnadd").show();
		$("#btnusuario").show();
	}
}
//Cancelar formulario
//Declarar la funcion cancelar formulario
function cancelarform() {
	/*Llamar la funcion para limpiar los campos del formulario*/
	limpiar();
	/*Llamar la funcion mostrarform con valor de parametro false, para indicar que ocultara los elementos del formulario*/
	mostrarform(false);
}
//Listar
//Declarar la funcion listar
function listar() {
	tabla = $('#tbllistado').dataTable({
		//Establecer el elemento HTML de la tabla en la variable global mediante el id de la tabla (#tbllistado)
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
			url: '../ajax/usuarios.php?op=listar',
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
		url: "../ajax/usuarios.php?op=guardaryeditar",
		type: "POST", //Envio de datos mediante el tipo post
		data: formData, //Enviar los datos almacenados de la variable formData
		contentType: false,
		processData: false,
		success: function (datos) {
			//Enviar un alert
			bootbox.alert(datos);
			//Ocultar el formulario mediante la funcion mostrarform
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
function mostrar(idDatosGenerales) {
	/*Mediante Jquery del metodo post, indicar la URL del archivo y funcion se obtendran los datos*/
	$.post("../ajax/usuarios.php?op=mostrar", {
		idDatosGenerales: idDatosGenerales //indicar el parametro del id del registro
	}, function (data, status) { //Funcion  donde obtener los valores del registro
		data = JSON.parse(data); //Converitr los datos a un objeto javascript
		mostrarform(true); //Mostrar el formulario mediante la funcion mostrarform con el parametro true
		//Declarar los inputs donde se devolveran los valores almacenados
		$("#idDatosGenerales").val(data.idDatosGenerales);
		$("#nombres").val(data.nombres);
		$("#primerApellido").val(data.primerApellido);
		$("#segundoApellido").val(data.segundoApellido);
		$("#correoInstitucional").val(data.correoInstitucional);
		$("#rolUsuario").val(data.rolUsuario);
		$("#rolUsuario").selectpicker('refresh');
		$("#aliasUsuario").val(data.aliasUsuario);
		$("#contrasenaUsuario").val("");
		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src", "../files/usuarios/" + data.imagen);
		$("#imagenactual").val(data.imagen);
	})
}
//Instaciar la funcion init para ejecutar al inicio y las funcion dentro de esta
init();
