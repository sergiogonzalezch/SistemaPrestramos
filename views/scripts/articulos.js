/*Crear variable tabla para realizar el
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
	})
	/*Mediante jQuerydel metodo post, indicar la URL del archivo
	y función donde se obtendrán los datos y visualizarlos en el elemento
	input de tipo select de HTML*/
	$.post("../ajax/articulos.php?op=selecTipoArticulo", function (r) {
		$("#idTipoArticulo").html(r);
		//Refrescar el select
		$('#idTipoArticulo').selectpicker('refresh');

	});
	/*Código para el selectPicker, que permite visualizar los tipos
	de artículos en el input HTML select*/
	$.post("../ajax/articulos.php?op=selecAnaquel", function (r) {
		$("#idAnaquel").html(r);
		//Refrescar el select
		$('#idAnaquel').selectpicker('refresh');
	});
	/*Código para ocultar el elemento de formulario
	para visualizar la imagen del artículo*/
	$("#imagenMuestra").hide();
}
//Limpiar
//Declarar la función limpiar para vaciar los campos del formulario
function limpiar() {
	//Declarar los campos a limpiar
	$("#idArticulo").val("");
	$("#etiqueta").val("");
	$("#fechaAlta").val("");
	$("#numeroSerie").val("");
	$("#descripcion").val("");
	$("#disponibilidadArticulos").val("");
	$("#disponibilidadArticulos").selectpicker('refresh');
	$("#condicionArticulo").val("");
	$("#condicionArticulo").selectpicker('refresh');
	$("#idAnaquel").val("");
	$("#idAnaquel").selectpicker('refresh');
	$("#idTipoArticulo").val("");
	$("#idTipoArticulo").selectpicker('refresh');
	$("#imagenMuestra").attr("src", "");
	$("#imagenActual").val("");
	$("#imagen").val("");
	$("#codigoBarras").val("");
	$("#print").hide();
}
//Mostrar formulario
/*Declarar la función para visualizar los objetos del
formulario (inputs y secciones)*/
function mostrarform(flag) {
	//Llamar la función limpiar
	limpiar();
	if (flag) {
		/*Si el valor de la bandera (flag) es igual a verdadero
		el formulario  y sus elementos serán desplegados mientras
		que los elementos del listado de registros serán ocultados
		como aquellos elementos que no son parte del formulario*/
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disable", false);
		$("#btnAdd").hide();
	} else {
		/*Si el valor de la bandera (flag) es igual a falso entonces
		los elementos del formulario serán ocultados y el resto serán visibles*/
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnAdd").show();
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
		dom: 'lBfrtip', //Definir los elementos del control de tabla
		//Definir los botones para exportación de datos
		buttons: [
					'copyHtml5', //Exportar en HTML
					'excelHtml5', //Exportar en Excel
					'csvHtml5' //Exportar en CSV
				],
		//Indicar si la tabla es responsive
		responsive: true,
		/*Mediante operaciones ajax recibir los valores para enlistar
		los registros de la consulta*/
		"ajax": {
			//Indicar la url del archivo y donde obtiene los datos
			url: '../ajax/articulos.php?op=listar',
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
	/*Evitar que la función se ejecute al inicio del proceso,
	permitiendo que los demás se ejecuten en orden*/
	e.preventDefault();
	//Al seleccionar el botón (#btnGuardar), se deshabilitará
	$("#btnGuardar").prop("disable", true);
	/*Obtener los valores de los elementos del formulario
	mediante el id del formulario (#formulario)*/
	var formData = new FormData($("#formulario")[0]);
	//Metodo ajax para el envío de los datos del formulario
	$.ajax({
		//Indicar la dirección url del archivo para el envío de los datos
		url: "../ajax/articulos.php?op=guardaryeditar",
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
function mostrar(idArticulo) {
	/*Mediante jQuerydel metodo post, indicar la URL del archivo y
	función donde se obtendrán los datos*/
	$.post("../ajax/articulos.php?op=mostrar", {
		idArticulo: idArticulo //indicar el parámetro del id del registro
	}, function (data, status) { //Función  donde obtener los valores del registro
		data = JSON.parse(data); //Convertirlos datos a un objeto JavaScript
		mostrarform(true); //Mostrar el formulario mediante la función mostrarform con el parámetro true
		//Declarar los inputs donde se devolverán los valores almacenados
		$("#etiqueta").val(data.etiqueta);
		$("#fechaAlta").val(data.fechaAlta);
		$("#numeroSerie").val(data.numeroSerie);
		$("#descripcion").val(data.descripcion);
		$("#disponibilidadArticulos").val(data.disponibilidadArticulos);
		$("#disponibilidadArticulos").selectpicker('refresh');
		$("#condicionArticulo").val(data.condicionArticulo);
		$("#condicionArticulo").selectpicker('refresh');
		$("#codigoBarras").val(data.codigoBarras);
		$("#imagenMuestra").show();
		$("#imagenMuestra").attr("src", "../files/articulos/" + data.imagen);
		$("#imagenActual").val(data.imagen);
		$("#idAnaquel").val(data.idAnaquel);
		$("#idAnaquel").selectpicker('refresh');
		$("#idTipoArticulo").val(data.idTipoArticulo);
		$("#idTipoArticulo").selectpicker('refresh');
		$("#idArticulo").val(data.idArticulo);
	})
}
//Baja
//Declarar la función baja del artículo
function baja(idArticulo, observacionBaja) {
	/*Enviar un mensaje de alerta por medio de bootbox,
	en cual tendrá la función de obtener una respuesta (result)
	de confirmación de baja del artículo*/
	bootbox.confirm("¿Está Seguro de dar de baja el artículo?", function (result) {
		//Secuencia if que evalúa la respuesta (result)
		if (result) {
			/*Si la respuesta es afirmativa, se realizará la
			baja del artículo, desplegando una alertade tipo
			formulario de campo de texto*/
			bootbox.prompt({
				title: "Escriba el motivo de la baja", //Titulo del arte
				centerVertical: true, //Alinear verticalmente
				inputType: 'textarea', //Tipo de input, área de texto
				callback: function (result) { //Retornara valor del formulario
					//Almacena valor del formulario en la variable observacionBaja
					observacionBaja = result;
					//Mediante otro if evaluara si fue enviado un valor.
					if (result) {
						/*Si la respuesta (result), es afirmativa entonces guardara
						el registro de baja del artículo*/
						/*Mediante jQuery del metodo post, indicar la URL del archivo
						y función donde se obtendrán los datos*/
						$.post("../ajax/articulos.php?op=baja", {
							//Declarar los valores que obtendrá
							idArticulo: idArticulo,
							observacionBaja: observacionBaja
						}, function (e) {
							bootbox.alert(e); //Enviar un mensaje de alerta
							tabla.ajax.reload(); //Recargar la tabla
						});
					}
				}
			});
		}
	})
}
//Reactivar
//Declarar la función para reactivar un artículo dado de baja
function reactivar(idArticulo) {
	/*Envía un mensaje de alerta por medio de bootbox, en cual
	tendrá la función de obtener una respuesta (result) de
	confirmación de reactivar del artículo*/
	bootbox.confirm("¿Está Seguro de reactivar el artículo?", function (result) {
		//Secuencia if que   evalúa   la respuesta (result)
		if (result) {
			/*Si la respuesta (result), es afirmativa entonces procederá
			a llamar la función para reactivar el artículo*/
			/*Mediante jQuery del metodo post, indicar la URL
			del archivo y función a ejecutar*/
			$.post("../ajax/articulos.php?op=reactivar", {
				//Valor a recibir
				idArticulo: idArticulo
			}, function (e) {
				bootbox.alert(e); //Enviar un mensaje de alerta
				tabla.ajax.reload(); //Recargar la tabla
			});
		}
	})
}
//Generar barcode
//Función para generar el código de barras
function generarbarcode() {
	//Obtener el valor del input con el id (#codigoBarra), para crear el código de barras
	codigoBarras = $("#codigoBarras").val();
	//Hacer uso del metodo de la librería JsBarcode, para generar el código de barras
	JsBarcode("#barcode", codigoBarras);
	//Desplegar el código generado mediante del elemento HTML con el id #print del formulario
	$("#print").show();
}
//Imprimir
//Función para imprimir el código de barras generado
function imprimir() {
	//Hacer uso de la librería printArea para imprimir el código de barras generado
	$("#print").printArea();
}
//Instanciar la función init para ejecutar al inicio y las funciones dentro de esta
init();
