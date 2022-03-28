/*Crear la variable global tabla para realizar
el procedimiento de enlistar los registros*/
var tabla;
/*Establecer el contador para contar los artículos
agregados al reporte*/
var cont = 0;
//Obtener el valor del checkbox
var checkbox = document.getElementById('cbox1');
//Establecer por defecto que el checkbo este sin marcar
checkbox.addEventListener("change", checked, false);
//Init
//Función que se ejecuta al inicio
function init() {
	/*Llamar a la función mostrar el formulario con el
	valor de su parámetro como false para no visualizarlo*/
	mostrarform(false);
	/*Llamar a la función listar se ejecuta al inicio para
	visualizar todos los registros en una tabla de
	datatables*/
	listar();
	//Establecer el parámetro fechaInicio para el rango de fechas
	$("#fechaInicio").change(listar);
	//Establecer el parámetro fechaFin para el rango de fechas
	$("#fechaFin").change(listar);
	//Función para subir los datos del formulario y almacenarlos
	$("#formulario").on("submit", function (e) {
		//Llamar al metodo guardar
		guardarycerrar(e);
	});
	/*Mediante jQuerydel metodo post, indicar la
	URL del archivo y función se obtendrán
	los datos y visualizarlos en el elemento
	input de tipo select de HTML*/
	$.post("../ajax/prestamos.php?op=selecCliente", function (r) {
		$("#idClientes").html(r);
		//Refrescar el select
		$('#idClientes').selectpicker('refresh');
	});
}
//Limpiar
/*Declarar una función para
limpiar los inputs del formulario*/
function limpiar() {
	$("#idPrestamo").val("");
	$("#idClientes").val("");
	$('#idClientes').selectpicker('refresh');
	$("#edificio").val("");
	$('#edificio').selectpicker('refresh');
	$("#tipoArea").val("");
	$('#tipoArea').selectpicker('refresh');
	$("#descripcionArea").val("");
	$(".filas").remove();
	$("#cbox1").prop("checked", false);
}
//Mostrar formulario
/*Declarar la función para visualizar
los objetos del formulario (inputs y secciones)*/
function mostrarform(flag) {
	limpiar();
	if (flag) {
		/*Si el valor de la bandera (flag) es igual a verdadero
		el formulario  y sus elementos serán desplegados mientras
		que los elementos del listado de registros serán ocultados
		como aquellos elementos que no son parte del formulario*/
		$(".head").show();
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnAdd").hide();
		$("#rptgeneral").hide();
		listarDisponibles();
		$("#btnGuardar").hide();
		$("#btnCancel").show();
		$("#btnAgregarArt").show();
		$("#cbox1").hide();
		$("#label").hide();
	} else {
		/*Si el valor de la bandera (flag) es igual
		a falso entonces los elementos del formulario
		serán ocultados y el resto serán visibles*/
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnAdd").show();
		$("#rptgeneral").show();
		$(".head").hide();
	}
}
//Cancelar formulario
//Declarar la función cancelar formulario
function cancelarform() {
	/*Llamar la función para limpiar
	los campos del formulario*/
	limpiar();
	/*Llamar la función mostrarform con valor de parámetro false,
	para indicar que ocultara los elementos del formulario*/
	mostrarform(false);
}
//Listar
//Declarar la función listar
function listar() {
	//Obtener el valor de la fecha de inicio
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
					'csvHtml5' //Exportar en CSV
				],
		//Indicar si la tabla es responsive
		responsive: true,
		/*Mediante operaciones ajax recibir los valores para enlistar
		los registros de la consulta*/
		"ajax": {
			//Indicar la url del archivo y donde obtiene los datos
			url: '../ajax/prestamos.php?op=listar',
			data: {
				//Enviar los parámetros para establecer el rango de fechas
				fechaInicio: fechaInicio,
				fechaFin: fechaFin
			},
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
		"iDisplayLength": 25,
		"order": [[0, "desc"]]
	}).DataTable();
}
//Guardar y cerrar
/*Declarar la función guardar y cerrar los registros de los prestamos*/
function guardarycerrar(e) {
	//Evitar que la función se ejecute al inicio del proceso, permitiendo que los demás se ejecuten en orden
	e.preventDefault();
	//Al seleccionar el botón (#btnGuardar), se deshabilitará
	$("#btnGuardar").prop("disable", true);
	//Obtener los valores de los elementos del formulario mediante el id del formulario (#formulario)
	var formData = new FormData($("#formulario")[0]);
	//Metodo ajax para el envío de los datos del formulario
	$.ajax({
		//Indicar la dirección url del archivo para el envío de los datos
		url: "../ajax/prestamos.php?op=guardarycerrar",
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
			//Llamar a la función listar
			listar();
		}
	});
	//Instanciar la función limpiar para vaciar el formulario
	limpiar();
}
//Mostrar
/*Declarar la función mostrar, para visualizar los valores de un registro
en un formulario, al recibir el id del registro, para obtener los datos*/
function mostrar(idPrestamo) {
	/*Mediante jQuerydel metodo post, indicar la URL del archivo y
	función donde se obtendrán los datos*/
	$.post("../ajax/prestamos.php?op=mostrar", {
		idPrestamo: idPrestamo //indicar el parámetro del id del registro
	}, function (data, status) { //Función  donde obtener los valores del registro
		data = JSON.parse(data); //Convertirlos datos a un objeto JavaScript
		mostrarform(true); //Mostrar el formulario mediante la función mostrarform con el parámetro true
		//Declarar los inputs donde se devolverán los valores almacenados
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
	/*Mediante jQuery del metodo post, indicar la URL del archivo y
	función donde se obtendrán los datos*/
	$.post("../ajax/prestamos.php?op=listarDetalle&id=" + idPrestamo, function (r) {
		//Adjuntar valores a la tabla HTML del formulario con el id mostrar
		$("#mostrar").html(r);
	});
}
//Función para listar los artículos disponibles en una tabla de un elemento HTML modal
function listarDisponibles() {
	/*Establecer el elemento HTML de la tabla en la variable
	global mediante el id de la tabla (#tblarticulos)*/
	tabla = $('#tblarticulos').dataTable({
		"aProcessing": true, //Activar el procesamiento del datatables
		"aServerSide": true, //Paginación y filtrado realizados por el servidor
		dom: 'lBfrtip', //Definir los elementos del control de tabla
		//Definir los botónes para exportación de datos
		buttons: [
			/*Mantener vacio para no agregar
			los botones para exportar*/
				],
		/*Mediante operaciones ajax recibir los valores para
		enlistar los registros de la consulta*/
		"ajax": {
			//Indicar la url del archivo y donde obtiene los datos
			url: '../ajax/prestamos.php?op=listarDisponibles',
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
		"bDestroy": true,
		"iDisplayLength": 20, //Paginación
		"order": [[0, "desc"]] //Ordenar (columna,orden)
	}).DataTable();
}
//Función para agregar artículos al registro del préstamo
function agregarArticuloPrestamo(idArticulo, etiqueta) {
	//Establecer la variable para almacenar los valores de condición de entrega
	var condicionEntrega = "";
	/*Mediante una secuencia valida si el valor del id que recibe es diferente de vacío("")*/
	if (idArticulo != "") {
		/*Variable fila que permitirá visualizar un elemento de tipo HTML de filas
		y celdas de tablas para visualizar la información del articulo agregado al registro
		Los valores del idArticulo, condicionEntrega, serán enviados como arreglos indicados en
		las propiedades del identificador (id) del elemento HTML input
		y el nombre (name) único del elemento*/
		var fila =
			'<tr class="filas" id="fila' + cont + '">' +
			/*Fila y celda para la opcion de eliminar articulo al
			llamar la función elminar mediante evento onclick y
			la función eliminar()*/
			'<td><button type="button" class="btn btn-danger" onclick="eliminarArticulo(' + cont + ')">X</button></td>' +
			//Fila y celda para recibir el valor del del articulo como su id y la etiqueta
			'<td><input type="hidden" name="idArticulo[]" id=idArticulo[] value="' + idArticulo + '">' + etiqueta + '</td>' +
			/*Fila y celda para establecer un input de tipo texto para recibir
			la condiciones de entrega del articulo*/
			'<td><input class="condicionEntrega" type="text" name="condicionEntrega[]" id="condicionEntrega[]" value="' + condicionEntrega + '"></td>' +
			/*Fila y celda para la opción de validar si fue redactado correctamente
			el valor de la condición de entrega del input condicionEntrega [],
			mediante evento onclick y la función validar()*/
			'<td><button type="button" onclick="validar()" class="btn btn-info"><i class="fas fa-sync"></i></button></td>' +
			'</tr>';
		//Aumentar el valor de la variable contador
		cont++;
		/*Realizar un append para agregar las filas,
		en tiempo real a la tabla con el id detalles
		de la vista del formulario*/
		$('#detalles').append(fila);
	} else {
		/*Caso contrario si el valor que recibe
		es vacío emitirá una alerta*/
		alert("Error al ingresar el artículo, revisar los datos");
	}
}
/*Función para validar que el ingreso de la
condición este redactado de forma correcta*/
function validar() {
	var inputEntrega = document.getElementsByName('condicionEntrega[]');
	for (i = 0; i < inputEntrega.length; i++) {
		/*Evaluar si el valor es igual a "Bueno",
		desplegara el botón para guardar los cambios*/
		if (inputEntrega[i].value == 'Bueno') {
			$("#btnGuardar").show();
			/*Evaluar si el valor es igual a "Regular",
			desplegara el botón para guardar los cambios*/
		} else if (inputEntrega[i].value == 'Regular') {
			$("#btnGuardar").show();
			/*Evaluar si el valor es igual a "Malo",
			desplegara el botón para guardar los cambios*/
		} else if (inputEntrega[i].value == 'Malo') {
			$("#btnGuardar").show();
			/*Si no coincide con ninguno enviara una
			alerta de revisar la redacción*/
		} else {
			bootbox.alert("¡No fue bien escrito revise su ortografía!");
			//Ocultar el botón de guardar
			$("#btnGuardar").hide();
			return;
		}
	}
}
//Función para eliminar un artículo del registro de préstamos
function eliminarArticulo(indice) {
	//Remover una fila al recibir el índice o número de fila
	$("#fila" + indice).remove();
}
/*Función para obtener los valores del registro
de préstamos para realizar la devolución de los artículos*/
function devolucion(idPrestamo) {
	/*Mediante jQuerydel metodo post, indicar la
	URL del archivo y función donde se obtendrán los datos*/
	$.post("../ajax/prestamos.php?op=mostrar", {
		idPrestamo: idPrestamo //indicar el parámetro del id del registro
	}, function (data, status) { //Función  donde obtener los valores del registro
		data = JSON.parse(data); //Convertirlos datos a un objeto JavaScript
		//Declarar los inputs donde se devolverán los valores almacenados
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
	/*Mediante jQuerydel metodo post, indicar la URL
	del archivo y función donde se obtendrán los datos*/
	$.post("../ajax/prestamos.php?op=listarDevolucion&id=" + idPrestamo, function (r) {
		//Enviar valores a la tabla con el id recibir del formulario
		$("#recibir").html(r);
	});
}
//Función para validar que el checkbox este marcado
function checked() {
	//Obtener el valor del checkbox
	var checked = checkbox.checked;
	if (checked) {
		//Si el checkbox esta marcado desplegara el botón para guardar los datos
		$("#btnGuardar").show();
	} else {
		//Caso contrario lo ocultara en tiempo real
		$("#btnGuardar").hide();
	}
}

//Realizar el envío de datos de la devolución del artículo
function devolver() {
	//Establecer las variables para recibir la información y enviarlos como parámetros
	idAP = $('#idAP').val(); //Id articulo préstamo
	condicion = $('#condicion').val(); //Condición de devolución del artículo
	observacion = $('#observacion').val(); //Observación de devolución del artículo
	idA = $('#idA').val(); //Id del artículo
	parametros = {
		idAP: idAP, //Id artículo préstamo
		condicion: condicion, //Condición de devolución del artículo
		observacion: observacion, //Observación de devolución del articulo
		idA: idA //Id del artículo
	}
	/*Mediante operaciones ajax recibir los valores
	para enlistar los registros de la consulta*/
	$.ajax({
		//Enviar los datos almacenados en los parámetros
		data: parametros,
		//Indicar la dirección url del archivo para el envío de los datos
		url: '../ajax/prestamos.php?op=devolver',
		type: 'POST', //Envío de datos mediante el tipo post
		success: function (response) {
			/*Secuencia if que valida si la operación fue
			un éxito o no al recibir una respuesta (response)*/
			if (response == 1) {
				/*Si recibe 1, emitirá un mensaje de que
				los campos fueron actualizados correctamento*/
				bootbox.alert("Actualizado correctamente");
			} else {
				//Caso contrario enviara que se encuentran vacíos
				bootbox.alert("¡Campos vacíos!");
			}
		}
	});
}
//Obtener los valores del artículo prestado del registro
function obtenerDevolucion(idArticuloPrestamo) {
	//Enviar parámetros
	parametros = {
		idArticuloPrestamo: idArticuloPrestamo //indicar el parámetro del id del registro
	}
	//Metodo ajax para el envío de los datos del formulario
	$.ajax({
		data: parametros, //Enviar parámetros
		//Indicar la dirección url del archivo para el envío de los datos
		url: '../ajax/prestamos.php?op=obtenerDevolucion',
		type: 'POST', //Envío de datos mediante el tipo post
		dataType: "json", //Formato de los datos codificados
		success: function (response) {
			$('#idAP').val(response[0]['0']);
			$('#condicion').val(response[0]['1']);
			$('#observacion').val(response[0]['2']);
			$('#idA').val(response[0]['3']);
		}
	});
}
/*Generar reporte en formato PDF de todos los
registros de préstamos al recibir un rango
de fechas*/
function reporte() {
	//Enviar los parámetros para establecer el rango de fechas
	//Varible para indicar la fecha de inicio
	var fechaInicio = $("#fechaInicio").val();
	/*Varible para indicar la fecha de límite del rango*/
	var fechaFin = $("#fechaFin").val();
	/*Desplegar los resultados en otra ventana
	con los parámetro del rango de fechas*/
	window.open('../reportes/rptprestamos.php?fechaInicio=' + fechaInicio + '&fechaFin=' + fechaFin);
}
/*Instanciar la función init para ejecutar
al inicio y las funciones dentro de esta*/
init();
