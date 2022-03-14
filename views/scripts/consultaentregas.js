/*Crear variable tabla para realiar el procedimiento de enlistar los registros*/
var tabla;
//Init
//Funcion que se ejecuta al inicio
function init() {
	/*Llamar a la funcion listar se ejecuta al incio para visualizar todos los registros en una tabla de datatables*/
	listar();
	//Establecer el parametro fechaInicio para el rango de fechas
	$("#fechaInicio").change(listar);
	//Establecer el parametro fechaFin para el rango de fechas
	$("#fechaFin").change(listar);
}
//Listar
/*Declarar funcion listar que permite visualizar los registro sde un a consulta*/
function listar() {
	//Obtener  el valor de la fecha de incio
	var fechaInicio = $("#fechaInicio").val();
	//Establecer la fecha fin
	var fechaFin = $("#fechaFin").val();
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
		responsive: true,
		//Establecer la tabla como responsive
		/*Mediante operaciones ajax recibir los valores para enlistar los registros de la consulta*/
		"ajax": {
			url: '../ajax/consulta.php?op=consultaEntregas',
			data: {
				//Enviar los parametros paraestablecer  el rango de fechas
				fechaInicio: fechaInicio,
				fechaFin: fechaFin
			},
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
//Instaciar la funcion init para ejecutar al inicio y las funcion dentro de esta
init();
