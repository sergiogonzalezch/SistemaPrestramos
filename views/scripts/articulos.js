/*Crear variable tabla para realiar el procedimiento de enlistar los registros*/
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
	/*Mediante Jquery del metodo post, indicar la URL del archivo y funcion se obtendran los datos y visulizarlos en el elemento input de tipo select de HTML*/
	$.post("../ajax/articulos.php?op=selecTipoArticulo", function (r) {
		$("#idTipoArticulo").html(r);
		//Refrescar el select
		$('#idTipoArticulo').selectpicker('refresh');

	});
	//Codigo para el selectPicker, que permite visualizar los tipos tipos de articulos en el input HTML select
	$.post("../ajax/articulos.php?op=selecAnaquel", function (r) {
		$("#idAnaquel").html(r);
		//Refrescar el select
		$('#idAnaquel').selectpicker('refresh');
	});
	//Codigo para ocultar el elemento de formulario para visaulizar la imagen del articulo
	$("#imagenmuestra").hide();
}
//Limpiar
//Declarar la funcion limpiar para vaciar los campos del formulario
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
	$("#imagenmuestra").attr("src", "");
	$("#imagenactual").val("");
	$("#codigoBarras").val("");
	$("#print").hide();
}
//Mostrar formulario
//Declarar la funcion para visulalizar los objetos del formulario (inputs y secciones)
function mostrarform(flag) {
	//Llamar la funcion limpiar
	limpiar();
	if (flag) {
		/*Si el valor de la bandera (flag) es igual a verdadero
		el formulario  y sus elementos seran desplegados mientras que los elementos del listado de registros seran ocultados como aquellos elementos que no son parte del formulario*/
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disable", false);
		$("#btnadd").hide();
	} else {
		/*Si el valor de la bandera (flag) es igual a falso entonces los elementos del formulario seran ocultados y el resto seran visibles*/
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnadd").show();
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
	//Establecer el elemento HTML de la tabla en la variable global mediante el id de la tabla (#tbllistado)
	tabla = $('#tbllistado').dataTable({
		"aProcessing": true, //Activar el procesamiento del datatables
		"aServerSide": true, //Paginación y filtrado realizados por el servidor
		dom: 'lBfrtip', //Definir los elementos del control de tabla
		//Definir los botones para exportacion de datos
		buttons: [
					'copyHtml5', //Exportar en HTML
					'excelHtml5', //Exportar en Excel
					'csvHtml5' //Exportar en CSV
				],
		//Indicar si la tabla es responsive
		responsive: true,
		/*Mediante operaciones ajax recibir los valores para enlistar los registros de la consulta*/
		"ajax": {
			//Indicar la url del archivo y donde obtivene los datos
			url: '../ajax/articulos.php?op=listar',
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
		url: "../ajax/articulos.php?op=guardaryeditar",
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
function mostrar(idArticulo) {
	/*Mediante Jquery del metodo post, indicar la URL del archivo y funcion se obtendran los datos*/
	$.post("../ajax/articulos.php?op=mostrar", {
		idArticulo: idArticulo //indicar el parametro del id del registro
	}, function (data, status) { //Funcion  donde obtener los valores del registro
		data = JSON.parse(data); //Converitr los datos a un objeto javascript
		mostrarform(true); //Mostrar el formulario mediante la funcion mostrarform con el parametro true
		//Declarar los inputs donde se devolveran los valores almacenados
		$("#etiqueta").val(data.etiqueta);
		$("#fechaAlta").val(data.fechaAlta);
		$("#numeroSerie").val(data.numeroSerie);
		$("#descripcion").val(data.descripcion);
		$("#disponibilidadArticulos").val(data.disponibilidadArticulos);
		$("#disponibilidadArticulos").selectpicker('refresh');
		$("#condicionArticulo").val(data.condicionArticulo);
		$("#condicionArticulo").selectpicker('refresh');
		$("#codigoBarras").val(data.codigoBarras);
		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src", "../files/articulos/" + data.imagen);
		$("#imagenactual").val(data.imagen);
		$("#idAnaquel").val(data.idAnaquel);
		$("#idAnaquel").selectpicker('refresh');
		$("#idTipoArticulo").val(data.idTipoArticulo);
		$("#idTipoArticulo").selectpicker('refresh');
		$("#idArticulo").val(data.idArticulo);
	})
}
//Baja
//Declarar la funcion baja del articulo
function baja(idArticulo, observacionBaja) {
	/*Enviar un mensaje de alert por medio de bootbox, en cual tendra la funcion de obtener una respuesta (result) de confirmacion de baja del articulo*/
	bootbox.confirm("¿Está Seguro de dar de baja el artículo?", function (result) {
		//Secuencia if que evalua la respueta (result)
		if (result) {
			/*Si la respuesta es afirmativa, se realizara la baja del articulo, deplegando un alert de tipo formulario de campo de texto*/
			bootbox.prompt({
				title: "Escriba el motivo de la baja", //Titulo del arte
				centerVertical: true, //Alienacion vertical verdadera
				inputType: 'textarea', //Tipo de input, area de texto
				callback: function (result) { //Respuesta de confrimacion
					observacionBaja = result;
					//Mediante otro if evalura la confirmacion de dar baja el articulo
					if (result) {
						//Si la respuesta (result), es afirmativa entonces guardara el registro de baja del articulo
						/*Mediante Jquery del metodo post, indicar la URL del archivo y funcion se obtendran los datos*/
						$.post("../ajax/articulos.php?op=baja", {
							//Declarar los valores que obtendra
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
//Declarar la funcion para reactivar un articulo dado de baja
function reactivar(idArticulo) {
	/*Enviar un mensaje de alert por medio de bootbox, en cual tendra la funcion de obtener una respuesta (result) de confirmacion de reactivar del articulo*/
	bootbox.confirm("¿Está Seguro de reactivar el artículo?", function (result) {
		//Secuencia if que evalua la respueta (result)
		if (result) {
			//Si la respuesta (result), es afirmativa entonces procera a llamar la funcion para reactivar el articulo
			/*Mediante Jquery del metodo post, indicar la URL del archivo y funcion a ejecutar*/
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
//Funcion para generar el codigo de barras
function generarbarcode() {
	//Obtener el valor del input con el id (#codigoBarra), para crear el codigo de barras
	codigoBarras = $("#codigoBarras").val();
	//Hacer uso del metodo de la liberia JsBarcode, para generar el codigo de barras
	JsBarcode("#barcode", codigoBarras);
	//Desplegar el codigo generado mediante del elemento HTML con el id #print del formulario
	$("#print").show();
}
//Imprimir
//Funcion para imprimir el codigo de barras generaro
function imprimir() {
	//Hacer uso de la liberia printArea para imprimir el codigo de barras generado
	$("#print").printArea();
}
//Instaciar la funcion init para ejecutar al inicio y las funcion dentro de esta
init();
