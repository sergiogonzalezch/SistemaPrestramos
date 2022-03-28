//Archivo JavaScript para validar el login del usuario
/*Mediante operaciones jQueryse indica el tipo de evento a
realizar siendo submit para envío de datos, el id del objeto
formulario(#fmrAcceso)
del login.html, para obtenter los datos*/
jQuery(document).on('submit', '#frmAcceso', function (event) {
	/*Evitar que la operación se ejecute al inicio, debido a que
	la operación será realizada por operaciones ajax*/
	event.preventDefault();
	/*Mediante operaciónes jquery y ajax inciar el archivo
	donde se enviaran los datos y el formato*/
	jQuery.ajax({
			//Indicar la url del archivo y metodo para enviar los datos
			url: '../ajax/usuarios.php?op=verificar',
			//Enviar mediante operaciones post
			type: 'POST',
			//Recibir datos en tipo json
			dataType: 'json',
			/*Enviar los datos al archivo ajax php, serealizados
			para enviar una cadena de información*/
			data: $(this).serialize(),
			//Accion despues del envío de datos
			beforeSend: function () {
				//Cambiara el valor del texto del botón a valiando
				$('.botonLogin').val('Validando......');
			}
		})
		//Si la operación fue exitosa
		.done(function (respuesta) {
			//Obtendra una respuesta del archivo ajax
			//Validar si no hubo error en la respuesta
			if (!respuesta.error) {
				//Validar si el rol es igual a Administrador o Prestador, para otorgale acceso al sistema
				if (respuesta.rol == 'Administrador' || respuesta.rol == 'Prestador') {
					//Si los roles son correctos entonces redirecciónar al escritorio
					window.location.replace('escritorio.php');
					//Si es diferente a administrador o  prestador, no otorgara el acceso
				} else {
					setTimeout(function () {
						//Enviar un mensaje
						bootbox.alert("Sin acceso al sistema");

					}, 500);
					//Restaurar el valor del botón
					$('.botonLogin').val('Iniciar Sesión');
				}
				//Si hubo error no otorgara acceso al sistema
			} else {
				setTimeout(function () {
					//Enviar un mensaje
					bootbox.alert("Usuario y/o contraseña son incorrectos");
				}, 500);
				//Restaurar el valor del botón
				$('.botonLogin').val('Iniciar Sesión');
			}
		})
		//Si la operación falla
		.fail(function (resp) {
			//Enviar la falla en consola
			console.log(resp.responseText);
		})
		//Si la operación fue completada
		.always(function () {
			console.log("Operación completa");
		});
});
