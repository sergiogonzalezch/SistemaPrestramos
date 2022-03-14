/*Crear la variable global tabla para realizar el procedimiento
de enlistar los registros*/
var tabla;
//Establcer el contador para contar los articulos agregados el reporte
var cont = 0;
//Obtener el valor del checkbox
var checkbox = document.getElementById('cbox1');
//Establcer por defecto que este sin marcar
checkbox.addEventListener("change", checked, false);
//Init
//Funcion que se ejecuta al inicio
function init() {
	/*Llamar a la funcion mostrar el formulario con el
	valor de su parametro como false para no visualizarlo*/
	mostrarform(false);
	/*Llamar a la funcion listar se ejecuta al incio para visualizar todos los
	registros en una tabla de datatables*/
	listar();
	//Establecer el parametro fechaInicio para el rango de fechas
	$("#fechaInicio").change(listar);
	//Establecer el parametro fechaFin para el rango de fechas
	$("#fechaFin").change(listar);
	//Funcion para subir los datos del formulario y almacenarlos
	$("#formulario").on("submit", function (e) {
		//Llamar al metodo guardar
		guardarycerrar(e);
	});
	/*Mediante Jquery del metodo post, indicar la URL del archivo y funcion se obtendran
	los datos y visulizarlos en el elemento input de tipo select de HTML*/
	$.post("../ajax/prestamos.php?op=selecCliente", function (r) {
		$("#idClientes").html(r);
		//Refrescar el select
		$('#idClientes').selectpicker('refresh');
	});
}
//Limpiar
//Declarar una funcion para limpiar los inputs del formulario
function limpiar() {
	$("#idPrestamo").val("");
	$("#idClientes").val("");
	$('#idClientes').selectpicker('refresh');
	$("#fechaPrestamo").val("");
	$("#fechaAlta").val("");
	$("#folio").val("");
	$("#edificio").val("");
	$('#edificio').selectpicker('refresh');
	$("#condicion").val("");
	$('#condicion').selectpicker('refresh');
	$("#tipoArea").val("");
	$('#tipoArea').selectpicker('refresh');
	$("#descripcionArea").val("");
	$(".filas").remove();
	$("#cbox1").prop("checked", false);
}
//Mostrar formulario
//Declarar la funcion para visulalizar los objetos del formulario (inputs y secciones)
function mostrarform(flag) {
	limpiar();
	if (flag) {
		/*Si el valor de la bandera (flag) es igual a verdadero
		el formulario  y sus elementos seran desplegados mientras
		que los elementos del listado de registros seran ocultados
		como aquellos elementos que no son parte del formulario*/
		$(".head").show();
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnadd").hide();
		$("#rptgeneral").hide();
		listarDisponibles();
		$("#btnGuardar").hide();
		$("#btnCancel").show();
		$("#btnAgregarArt").show();
		$("#cbox1").hide();
		$("#label").hide();
	} else {
		/*Si el valor de la bandera (flag) es igual a falso entonces los
		elementos del formulario seran ocultados y el resto seran visibles*/
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnadd").show();
		$("#rptgeneral").show();
		$(".head").hide();
	}
}
//Cancelar formulario
//Declarar la funcion cancelar formulario
function cancelarform() {
	/*Llamar la funcion para limpiar los campos del formulario*/
	limpiar();
	/*Llamar la funcion mostrarform con valor de parametro false,
	para indicar que ocultara los elementos del formulario*/
	mostrarform(false);
}
//Listar
//Declarar la funcion listar
function listar() {
	//Obtener  el valor de la fecha de incio
	var fechaInicio = $("#fechaInicio").val();
	//Establecer la fecha fin
	var fechaFin = $("#fechaFin").val()
	/*Establecer el elemento HTML de la tabla en la variable global
	mediante el id de la tabla (#tbllistado)*/
	tabla = $('#tbllistado').dataTable({
		/*Establecer el elemento HTML de la tabla en la variable
		global mediante el id de la tabla (#tbllistado)*/
		"aProcessing": true, //Activar el procesamiento del datatables
		"aServerSide": true, //Paginación y filtrado realizados por el servidor
		dom: 'lBfrtip',
		buttons: [
					'copyHtml5', //Exportar en HTML
					'excelHtml5', //Exportar en Excel
					'csvHtml5', //Exportar en CSV
				],
		//Indicar si la tabla es responsive
		responsive: true,
		/*Mediante operaciones ajax recibir los valores para enlistar
		los registros de la consulta*/
		"ajax": {
			//Indicar la url del archivo y donde obtivene los datos
			url: '../ajax/prestamos.php?op=listar',
			data: {
				//Enviar los parametros paraestablecer  el rango de fechas
				fechaInicio: fechaInicio,
				fechaFin: fechaFin
			},
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
		"iDisplayLength": 25,
		"order": [[0, "desc"]]
	}).DataTable();
}
//Guardar y cerrar
/*Declarar la funcion guardar y cerrar los registros de los prestamos*/
function guardarycerrar(e) {
	//Evitar que la funcion se ejecute al inicio del proceso, permitiendo que los demas se ejecuten en orden
	e.preventDefault();
	//Al seleccionar el boton (#btnGuardar), se desahabilitara
	$("#btnGuardar").prop("disable", true);
	//Obtener los valores de lo elementos del formulario mediante el id del formulario (#formulario)
	var formData = new FormData($("#formulario")[0]);
	//Metodo ajax para el envio de los datos del formulario
	$.ajax({
		//Indicar la direccion url del archivo para el envio de los datos
		url: "../ajax/prestamos.php?op=guardarycerrar",
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
			//Llamar a la funcion listar
			listar();
		}
	});
	//Instanciar la funcion limpiar para vaciar el formulario
	limpiar();
}
//Mostrar
/*Declarar la funcion mostrar, para visulaizar los valores de un registro
en un formulario, al recibir el id del registro, para obtener los datos*/
function mostrar(idPrestamo) {
	/*Mediante Jquery del metodo post, indicar la URL del archivo y
	funcion se obtendran los datos*/
	$.post("../ajax/prestamos.php?op=mostrar", {
		idPrestamo: idPrestamo //indicar el parametro del id del registro
	}, function (data, status) { //Funcion  donde obtener los valores del registro
		data = JSON.parse(data); //Converitr los datos a un objeto javascript
		mostrarform(true); //Mostrar el formulario mediante la funcion mostrarform con el parametro true
		//Declarar los inputs donde se devolveran los valores almacenados
		$("#edificio").val(data.edificio);
		$("#edificio").selectpicker('refresh')
		$("#tipoArea").val(data.tipoArea);
		$("#tipoArea").selectpicker('refresh');
		$("#descripcionArea").val(data.descripcionArea);
		$("#idClientes").val(data.idClientes);
		$("#idClientes").selectpicker('refresh');
		$("#idPrestamo").val(data.idPrestamo);
		$("#btnGuardar").hide();
		$("#btnCancel").show();
		$("#btnAgregarArt").hide();
		$(".head").hide();
		$("#cbox1").hide();
		$("#label").hide();

	});
	/*Mediante Jquery del metodo post, indicar la URL del archivo y
	funcion se obtendran los datos*/
	$.post("../ajax/prestamos.php?op=listarDetalle&id=" + idPrestamo, function (r) {
		//Adjuntar valores a la tabla HTML del formulario con el id mostrar
		$("#mostrar").html(r);
	});
}
//Funcion para listar los articulos disponibles en una tabla de un elemento HTML modal
function listarDisponibles() {
	/*Establecer el elemento HTML de la tabla en la variable
	global mediante el id de la tabla (#tblarticulos)*/
	tabla = $('#tblarticulos').dataTable({
		"aProcessing": true, //Activar el procesamiento del datatables
		"aServerSide": true, //Paginación y filtrado realizados por el servidor
		dom: 'lBfrtip', //Definir los elementos del control de tabla
		//Definir los botones para exportacion de datos
		buttons: [
			//Mantenervacio para no agreger los botones de exportacion
				],
		/*Mediante operaciones ajax recibir los valores para enlistar los registros de la consulta*/
		"ajax": {
			//Indicar la url del archivo y donde obtivene los datos
			url: '../ajax/prestamos.php?op=listarDisponibles',
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
		"bDestroy": true,
		"iDisplayLength": 20, //Paginación
		"order": [[0, "desc"]] //Ordenar (columna,orden)
	}).DataTable();
}
//Funcion para agregar articulos al registro del prestamo
function agregarArticuloPrestamo(idArticulo, etiqueta) {
	//Establecer la variable para almacenar los valores de condicion de entrega
	var condicionEntrega = "";
	/*Mediante una secuencia valida si el valor del id que recibe es diferente de vacio ("")*/
	if (idArticulo != "") {
		/*Variable fila que permitira visualizar un elemento de tipo HTML de filas
		y celdas de tablas para visualizar la informacion del articulo agregado al registro*/
		/*Los valores del idArticulo, condicionEntrega, seran enviados como arreglos indicados en
		las propiedades del identificador (id) del elemento HTML input
		y el el nombre (name) unico del elemento*/
		var fila =
			'<tr class="filas" id="fila' + cont + '">' +
			/*Fila y celda para la opcion de eliminar articulo al
			llamar la funcion elminar mediante evento onclick y
			la funcion eliminar()*/
			'<td><button type="button" class="btn btn-danger" onclick="eliminarArticulo(' + cont + ')">X</button></td>' +
			//Fila y celda para recibir el valor del del articulo como su id y la etiqueta
			'<td><input type="hidden" name="idArticulo[]" id=idArticulo[] value="' + idArticulo + '">' + etiqueta + '</td>' +
			//Fila y celda para establcer un input de tipo texto para recibir la condiciones de entrega del articulo
			'<td><input class="condicionEntrega" type="text" name="condicionEntrega[]" id="condicionEntrega[]" value="' + condicionEntrega + '"></td>' +
			/*Fila y celda para la opcion de validar si fue redactado correctamente
			el valor de la condicion de entrega del input condicionEntrega [],
			mediante evento onclick y la funcion validar()*/
			'<td><button type="button" onclick="validar()" class="btn btn-info"><i class="fas fa-sync"></i></button></td>' +
			'</tr>';
		//Aumentar el valor de la variable contador
		cont++;
		//Realizar un append para agregar las filas, en tiempo real a la tabla con el id detalles de la vista del formulario.
		$('#detalles').append(fila);
	} else {
		//Caso contrario si el valor que recibe es vacio emitira un alerta
		alert("Error al ingresar el articulo, revisar los datos");
	}
}
//Funcion para validar que el ingreso de la condicion este redactado de forma correcta
function validar() {
	var inputEntrega = document.getElementsByName('condicionEntrega[]');
	for (i = 0; i < inputEntrega.length; i++) {
		//Evaluar si el valor es igual a "Bueno", desplegara el boton para guardar los cambios
		if (inputEntrega[i].value == 'Bueno') {
			$("#btnGuardar").show();
			//Evaluar si el valor es igual a "Regular", desplegara el boton para guardar los cambios
		} else if (inputEntrega[i].value == 'Regular') {
			$("#btnGuardar").show();
			//Evaluar si el valor es igual a "Malo", desplegara el boton para guardar los cambios
		} else if (inputEntrega[i].value == 'Malo') {
			$("#btnGuardar").show();
			//Si no conincide con ninguno enviara un alert de revisar  la redaccion
		} else {
			bootbox.alert("¡No fue bien escrito revise su ortografia!");
			//Ocultara el boton de guardar
			$("#btnGuardar").hide();
			return;
		}
	}
}
//Funcion para elminar un articulo del registro de prestamos
function eliminarArticulo(indice) {
	//Remover una fila al recibir el indice o numero de fila
	$("#fila" + indice).remove();
}
//Funcion para obtener los valores del registrode prestamos para realizar la devolucion de los articulos
function devolucion(idPrestamo) {
	/*Mediante Jquery del metodo post, indicar la URL del archivo y
	funcion se obtendran los datos*/
	$.post("../ajax/prestamos.php?op=mostrar", {
		idPrestamo: idPrestamo //indicar el parametro del id del registro
	}, function (data, status) { //Funcion  donde obtener los valores del registro
		data = JSON.parse(data); //Converitr los datos a un objeto javascript
		//Declarar los inputs donde se devolveran los valores almacenados
		mostrarform(true);
		$("#edificio").val(data.edificio);
		$("#edificio").selectpicker('refresh')
		$("#tipoArea").val(data.tipoArea);
		$("#tipoArea").selectpicker('refresh');
		$("#descripcionArea").val(data.descripcionArea);
		$("#idClientes").val(data.idClientes);
		$("#idClientes").selectpicker('refresh');
		$("#idPrestamo").val(data.idPrestamo);
		$("#btnGuardar").hide();
		$("#btnCancel").show();
		$("#btnAgregarArt").hide();
		$(".head").hide();
		$("#cbox1").show();
		$("#label").show();
	});
	/*Mediante Jquery del metodo post, indicar la URL del archivo y
	funcion se obtendran los datos*/
	$.post("../ajax/prestamos.php?op=listarDevolucion&id=" + idPrestamo, function (r) {
		//Enviar valores a la tabla con el id recibir del formulario
		$("#recibir").html(r);
	});
}
//Funcion para validar que el checkbox este marcado
function checked() {
	//Obtener el valor del checkbox
	var checked = checkbox.checked;
	if (checked) {
		//Si el checkbox esta marcado desplegara el boton para guardar los datos
		$("#btnGuardar").show();
	} else {
		//Caso contrario lo ocultara en tiempo real
		$("#btnGuardar").hide();
	}
}
//Obtener los valores del articulo prestado del registro
function obtenerDevolucion(idArticuloPrestamo) {
	//Enviar parametros
	parametros = {
		idArticuloPrestamo: idArticuloPrestamo //indicar el parametro del id del registro
	}
	//Metodo ajax para el envio de los datos del formulario
	$.ajax({
		data: parametros, //Enviar parametros
		//Indicar la direccion url del archivo para el envio de los datos
		url: '../ajax/prestamos.php?op=obtenerDevolucion',
		type: 'POST', //Envio de datos mediante el tipo post
		dataType: "json", //Formato de los datos codificados
		success: function (response) {
			$('#idAP').val(response[0]['0']);
			$('#condicion').val(response[0]['1']);
			$('#observacion').val(response[0]['2']);
			$('#idA').val(response[0]['3']);
		}
	});
}
//Realizar el envio de datos de la devolucion del articulo
function devolver() {
	//Establecer la variables para recibir la informacion y enviarlos como parametros
	idAP = $('#idAP').val(); //Id articulo prestamo
	condicion = $('#condicion').val(); //Condicion de devolucion del articulo
	observacion = $('#observacion').val(); //Observacion de devolucion del articulo
	idA = $('#idA').val(); //Id del articulo
	parametros = {
		idAP: idAP, //Id articulo prestamo
		condicion: condicion, //Condicion de devolucion del articulo
		observacion: observacion, //Observacion de devolucion del articulo
		idA: idA //Id del articulo
	}
	/*Mediante operaciones ajax recibir los valores para enlistar los registros de la consulta*/
	$.ajax({
		//Enviar los datos almacenados en los parametros
		data: parametros,
		//Indicar la direccion url del archivo para el envio de los datos
		url: '../ajax/prestamos.php?op=devolver',
		type: 'POST', //Envio de datos mediante el tipo post
		success: function (response) {
			//Secuencia if que valida si la operacion fue un exito o no al recibir ina respuesta (response)
			if (response == 1) {
				//Si recibe 1, emitira un mensaje de que los campos fueron actualizados correctamento
				bootbox.alert("Actualizado correctamente");
			} else {
				//Caso contrario enviara que se encuentran vacios
				bootbox.alert("¡Campos vacios!");
			}
		}
	});
}
//Generar reporte en formato PDF de todos los registros de prestamos al recibir un rango de fechas
function reporte() {
	//Enviar los parametros paraestablecer  el rango de fechas
	//Varible para indicar la fecha de inicio
	var fechaInicio = $("#fechaInicio").val();
	//Varible para indicar la fecha de limite del rango
	var fechaFin = $("#fechaFin").val();
	//Desplegar los resultado en otra ventana con los parametro del rango de fechas
	window.open('../reportes/rptprestamos.php?fechaInicio=' + fechaInicio + '&fechaFin=' + fechaFin);
}
//Instaciar la funcion init para ejecutar al inicio y las funcion dentro de esta
init();
