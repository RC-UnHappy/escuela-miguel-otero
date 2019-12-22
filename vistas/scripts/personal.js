//Funcion que se ejecutará al inicio

function init() {
	
	//Oculta el formulario al cargar la pagina
	mostrarform(false);

	//Muestra la lista de usuarios
	listar();

	//Se ejecuta cuando se envia el formulario
	$([usuario]).on('submit', function (event) {
		if ($([usuario])[0].checkValidity()) {
			guardaryeditar(event);
		}
		else {
			scrollTo(0,100);
		}
	});

	//Se ejecuta al quitar el foco del input cedula
	$('#cedula').on('blur', function () {
		comprobarUsuario();
	});


	//Se ejecuta al quitar el foco del select rol
	$('#rol').on('change', function () {
		rol();
	})


	//Comprueba que la url 
	if ($(location).attr('href').slice(55,71) == 'actualizarPerfil'){
		actualizarPerfil();
	}

	tabla.ajax.reload();
			
}

//Comprueba que el usuario no esté registrado
function comprobarUsuario() {
	var documento = $('#documento')[0].value;
	var cedula = $('#cedula')[0].value;

	if (documento == 'venezolano') {
		documento = 'V-';
	}
	else if (documento == 'extranjero') {
		documento = 'E-';
	}
	else if (documento == 'pasaporte') {
		documento = 'P-';
	}

	cedula = documento+cedula;

	$.ajax({
		url: '../controladores/usuario.php?op=comprobarusuario',
		type: 'POST',
		data: {cedula: cedula},
		success: function (datos) {
			if (datos != 'null') {
				$('#cedula').removeClass('is-valid');
				$('#cedula').addClass('is-invalid');
				$('#mensajeCedula').html('El usuario ya se encuentra registrado');
			}
		}
	});
}

// Función para ocultar los permisos en cuestión del cargo
function rol() {

	var rol = $('#rol')[0].value;

	if (rol == 'Docente') {
		$('#permisos').hide();
	}
	else if (rol == 'Personal') {
		$('#permisos').show();
	}
	else if (rol == '') {
		$('#permisos').show();
	}

}

//Función para actualizar el perfil
function actualizarPerfil() {
	$.post('..controladores/usuario.php?op=actualizarperfil', function (datos) {
		console.log(JSON.parse(datos));
	});
}

//Función para guardar y editar 
function guardaryeditar(event) {
	event.preventDefault(); //Evita que se envíe el formulario automaticamente
	// 
	$('#btnGuardar').prop('disabled', true); //Deshabilita el botón submit para evitar que lo presionen dos veces
	var formData = new FormData($([usuario])[0]); //Se obtienen los datos del formulario
	
	var documento = formData.get('documento'); //Se obtiene el tipo de documento
	documento = tipo_documento(documento);//Se llama la función que lo transforma Ej: 'Venezolano' = V-
	
	var cedula = formData.get('cedula');// Se obtiene la cédula 
	
	formData.set('cedula', documento+cedula);//Se le asigna a la cédula del formData el tipo de documento

	$.ajax({
		url: '../controladores/usuario.php?op=guardaryeditar', //Dirección a donde se envían los datos
		type: 'POST', //Método por el cual se envían los datos
		data: formData, //Datos
		contentType: false, //Este parámetro es para mandar datos al servidor por el encabezado
		processData: false, //Evita que jquery transforme la data en un string
		success: function (datos) {
			if (datos == 'true') {
				const Toast = Swal.mixin({
				  toast: true,
				  position: 'top-end',
				  showConfirmButton: false,
				  timer: 3000
				});

				Toast.fire({
				  type: 'success',
				  title: 'Usuario registrado exitosamente :)'
				});
			}
			else {
				const Toast = Swal.mixin({
				  toast: true,
				  position: 'top-end',
				  showConfirmButton: false,
				  timer: 3000
				});

				Toast.fire({
				  type: 'error',
				  title: 'Ocurrió un error y no se pudo registrar :('
				});
			}

			mostrarform(false);
			limpiar();
			tabla.ajax.reload();//Recarga la tabla con el listado sin refrescar la página

		}

	});

		
}

//Función para listar los registros
function listar() {
	tabla = $('#tblistado').DataTable({
		"processing": true,
		// "serverSide": true,
		pagingType: "first_last_numbers",
		language: {
			"info":           "Mostrando desde _START_ hasta _END_ de _TOTAL_ registros",
			"lengthMenu":     "Mostrar _MENU_ entradas",
			"loadingRecords": "Cargando...",
		    "processing":     "Procesando...",
		    "search":         "Buscar:",
			"emptyTable":     "No hay datos para mostrar",
			"infoEmpty":      "Mostrando 0 hasta 0 de 0 entradas",
			"paginate": {
	        "first":      "Primero",
	        "last":       "Último"
	    	},
		},
		dom: 'lfrtip', 
		"destroy": true, //Elimina cualquier elemente que se encuentre en la tabla
		"ajax": {
			url: '../controladores/usuario.php?op=listar',
			type: 'GET',
			dataType: 'json',
			error: function (data) {
				console.log(data.responseText);
			}
		},
		'order': [[0, 'desc']]
	});
}


/*==========================================================
=            Funciones para provover a Director            =
==========================================================*/

//Función para promover a director a un docente
function promoverdirector(idusuario) {
	$.post('../controladores/usuario.php?op=promoverdirector', {idusuario: idusuario}, function (data) {
		tabla.ajax.reload();//Recarga la tabla con el listado sin refrescar la página
		if (data) {	
			const Toast = Swal.mixin({
						  toast: true,
						  position: 'top-end',
						  showConfirmButton: false,
						  timer: 3000
						});

						Toast.fire({
						  type: 'success',
						  title: 'Operación exitosa'
						});
		}
	});
}

//Función para promover a director a un docente
function degradardirector(idusuario) {
	$.post('../controladores/usuario.php?op=degradardirector', {idusuario: idusuario}, function (data) {
		tabla.ajax.reload();//Recarga la tabla con el listado sin refrescar la página
		if (data) {			
			const Toast = Swal.mixin({
						  toast: true,
						  position: 'top-end',
						  showConfirmButton: false,
						  timer: 3000
						});

						Toast.fire({
						  type: 'success',
						  title: 'Operación exitosa'
						});
		}
	});
}

/*=====  End of Funciones para provover a Director  ======*/



/*=============================================================
=            Funciones para promover a Subdirector            =
=============================================================*/

//Función para promover a subdirector a un docente
function promoversubdirector(idusuario) {
	$.post('../controladores/usuario.php?op=promoversubdirector', {idusuario: idusuario}, function (data) {
		tabla.ajax.reload();//Recarga la tabla con el listado sin refrescar la página
		if (data) {	
			const Toast = Swal.mixin({
						  toast: true,
						  position: 'top-end',
						  showConfirmButton: false,
						  timer: 3000
						});

						Toast.fire({
						  type: 'success',
						  title: 'Operación exitosa'
						});
		}
	});
}

//Función para promover a subdirector a un docente
function degradarsubdirector(idusuario) {
	$.post('../controladores/usuario.php?op=degradarsubdirector', {idusuario: idusuario}, function (data) {
		tabla.ajax.reload();//Recarga la tabla con el listado sin refrescar la página
		if (data) {			
			const Toast = Swal.mixin({
						  toast: true,
						  position: 'top-end',
						  showConfirmButton: false,
						  timer: 3000
						});

						Toast.fire({
						  type: 'success',
						  title: 'Operación exitosa'
						});
		}
	});
}

/*=====  End of Funciones para promover a Subdirector  ======*/




//Función para mostrar un registro para editar
function mostrar(idusuario) {
	$.post('../controladores/usuario.php?op=mostrar',{idusuario: idusuario}, function (data) {	
		data = JSON.parse(data);
		mostrarform(true);

		$('#nombre').val(data.nombre);
		$('#tipo_documento').val(data.tipo_documento);
		$('#tipo_documento').selectpicker('refresh');
		$('#num_documento').val(data.num_documento);
		$('#direccion').val(data.direccion);
		$('#telefono').val(data.telefono);
		$('#email').val(data.email);
		$('#cargo').val(data.cargo);
		$('#login').val(data.login);
		$('#clave').val(data.clave);
		$('#imagenmuestra').show();
		$('#imagenmuestra').attr('src', '../files/usuarios/'+data.imagen);
		$('#imagenactual').val(data.imagen);
		$('#idusuario').val(data.idusuario);
	});

	//Mostramos los permisos
	$.post('../controladores/usuario.php?op=permisos&id='+idusuario, function (r) {
		$('#permisos').html(r);
	});
}

//Función para eliminar(desactivar) usuarios
function desactivar(idusuario) {

		const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-primary  mx-1 p-2',
		    cancelButton: 'btn btn-danger  mx-1 p-2'
		  },
		  buttonsStyling: false
		})

		swalWithBootstrapButtons.fire({
		  title: '¿Estas seguro?',
		  text: "¿Quieres desactivar a este usuario?",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Desactivar',
		  cancelButtonText: 'Cancelar',
		  reverseButtons: true
		}).then((result) => {
		  if (result.value) {
		  	$.post('../controladores/usuario.php?op=desactivar', {idusuario: idusuario}, function (e) {
				console.log(e);
				if (e == 'true') {
					const Toast = Swal.mixin({
					  toast: true,
					  position: 'top-end',
					  showConfirmButton: false,
					  timer: 3000
					});

					Toast.fire({
					  type: 'success',
					  title: 'El usuario ha sido desactivado :)'
					});
				}
				else {
					const Toast = Swal.mixin({
					  toast: true,
					  position: 'top-end',
					  showConfirmButton: false,
					  timer: 3000
					});

					Toast.fire({
					  type: 'error',
					  title: 'Ups! No se pudo desactivar el usuario'
					});
				}
				tabla.ajax.reload();
			});  
		  } 
		});
}

//Función para activar usuarios
function activar(idusuario) {

	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-primary  mx-1 p-2',
		    cancelButton: 'btn btn-danger  mx-1 p-2'
		  },
		  buttonsStyling: false
		})

		swalWithBootstrapButtons.fire({
		  title: '¿Estas seguro?',
		  text: "¿Quieres activar a este usuario?",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Activar',
		  cancelButtonText: 'Cancelar',
		  reverseButtons: true
		}).then((result) => {
		  if (result.value) {
		  	$.post('../controladores/usuario.php?op=activar', {idusuario: idusuario}, function (e) {
				if (e == 'true') {
					const Toast = Swal.mixin({
					  toast: true,
					  position: 'top-end',
					  showConfirmButton: false,
					  timer: 3000
					});

					Toast.fire({
					  type: 'success',
					  title: 'El usuario ha sido activado :)'
					});
				}
				else {
					const Toast = Swal.mixin({
					  toast: true,
					  position: 'top-end',
					  showConfirmButton: false,
					  timer: 3000
					});

					Toast.fire({
					  type: 'error',
					  title: 'Ups! No se pudo activar el usuario'
					});
				}
				tabla.ajax.reload();
			});  
		  } 
		});

}

//Función para mostrar o ocultar el formulario
function mostrarform(flag) {
	limpiar();
	if (flag) {
		$('#listadoregistros').hide();
		$('#formularioregistros').show();
		$('#btnGuardar').prop('disabled', false);
		$('#btnagregar').hide();

		//Mostramos los permisos 
		$.post('../controladores/usuario.php?op=permisos', function (response) {
			$('#permisos').html(response);
		});

	}
	else{
		$('#listadoregistros').show();
		$('#formularioregistros').hide();
		$('#btnagregar').show();
	}
}

//Función cancelarform
function cancelarform() {
	limpiar();
	mostrarform(false);
}

//Función para limpiar el formulario
function limpiar() {
	$('#documento').val('');
	$('#documento').selectpicker('refresh');
	$('#cedula').removeClass('is-invalid');
	$('#cedula').val('');
	$('#p_nombre').val('');
	$('#s_nombre').val('');
	$('#p_apellido').val('');
	$('#s_apellido').val('');
	$('#genero').val('');
	$('#genero').selectpicker('refresh');
	$('#icono_genero').removeClass('bg-primary');
	$('#icono_genero').removeClass('bg-danger');
	$('#f_nac').val('');
	$('#email').val('');
	$('#celular').val('');
	$('#fijo').val('');
	$('#formularioregistros').removeClass('was-validated');
	$('#rol').val('');
	$('#rol').selectpicker('refresh');
	// $('#').attr('src', '');
}

//Determinar documento 
function tipo_documento(documento) {
	if (documento == 'venezolano') {
		return 'V-';
	}
	else if (documento == 'extranjero') {
		return 'E-';
	}
	else if (documento == 'pasaporte') {
		return 'P-';
	}
}


init();


