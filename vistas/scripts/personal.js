//Funcion que se ejecutará al inicio

function init() {
	
	//Oculta el formulario al cargar la pagina
	mostrarform(false);

	//Muestra la lista de usuarios
	listar();

	//Se ejecuta cuando se envia el formulario
	$([personal]).on('submit', function (event) {
		if ($([personal])[0].checkValidity()) {
			guardaryeditar(event);
		}
		else {
			scrollTo(0,100);
		}
	});

	//Se ejecuta al quitar el foco del input cedula
	$('#cedula').on('blur', function () {
		comprobarPersonal();
		comprobarPersona();
	});

	//Se ejecuta al seleccionar un elemento del select documento
	$('#documento').on('change', function () {
		comprobarPersonal();
		comprobarPersona();
	});

	tabla.ajax.reload();			
}

//Comprueba que el personal no esté registrado
function comprobarPersonal() {
	var documento = $('#documento')[0].value;
	var cedula = $('#cedula')[0].value;


	if (documento != '' && cedula != '') {

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
			url: '../controladores/personal.php?op=comprobarpersonal',
			type: 'POST',
			data: {cedula: cedula},
			success: function (datosPersonal) {
				if (datosPersonal != 'null') {
					$('#cedula').removeClass('is-valid');
					$('#cedula').addClass('is-invalid');
					$('#mensajeCedula').html('El personal ya se encuentra registrado');
				}
				else {
					$('#cedula').removeClass('is-invalid');
					$('#cedula').addClass('is-valid');
				}
			}
		});
	}
}

//Comprueba que la persona no esté registrada
function comprobarPersona() {
	var documento = $('#documento')[0].value;
	var cedula = $('#cedula')[0].value;

	if (documento != '' && cedula != '') {

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
			url: '../controladores/personal.php?op=comprobarpersonal',
			type: 'POST',
			data: {cedula: cedula},
			success: function (datos) {
				datosPersonal = datos;
				$.ajax({
					url: '../controladores/personal.php?op=comprobarpersona',
					type: 'POST',
					data: {cedula: cedula},
					success: function (datosPersona) {
						if (datosPersonal == 'null' && datosPersona != 'null') {
							data = JSON.parse(datosPersona);
							$('#p_nombre').val(data.p_nombre);
							$('#s_nombre').val(data.s_nombre);
							$('#p_apellido').val(data.p_apellido);
							$('#s_apellido').val(data.s_apellido);
							$('#genero').val(data.genero);
							$('#genero').selectpicker('refresh');
							$('#f_nac').val(data.f_nac);
							$('#email').val(data.email);
							$('#celular').val(data.celular);
							$('#fijo').val(data.fijo);
							$('#idpersona').val(data.id);
						}
					}
				});
			}
		});
	}
}

//Función para guardar y editar 
function guardaryeditar(event) {
	event.preventDefault(); //Evita que se envíe el formulario automaticamente
	// 
	$('#btnGuardar').prop('disabled', true); //Deshabilita el botón submit para evitar que lo presionen dos veces
	var formData = new FormData($([personal])[0]); //Se obtienen los datos del formulario
	
	var documento = formData.get('documento'); //Se obtiene el tipo de documento
	documento = tipo_documento(documento);//Se llama la función que lo transforma Ej: 'Venezolano' = V-
	
	var cedula = formData.get('cedula');// Se obtiene la cédula 
	
	formData.set('cedula', documento+cedula);//Se le asigna a la cédula del formData el tipo de documento

	$.ajax({
		url: '../controladores/personal.php?op=guardaryeditar', //Dirección a donde se envían los datos
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
				  title: 'Personal registrado exitosamente :)'
				});
			}
			else if (datos == 'update') {
				const Toast = Swal.mixin({
				  toast: true,
				  position: 'top-end',
				  showConfirmButton: false,
				  timer: 3000
				});

				Toast.fire({
				  type: 'success',
				  title: 'Personal actualizado exitosamente :)'
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
			url: '../controladores/personal.php?op=listar',
			type: 'GET',
			dataType: 'json'
		},
		'order': [[0, 'desc']]
	});
}

//Función para mostrar un registro para editar
function mostrar(idpersonal) {
	$.post('../controladores/personal.php?op=mostrar',{idpersonal: idpersonal}, function (data) {	
		data = JSON.parse(data);
		mostrarform(true);

		var documento = data.cedula.slice(0,2);
		var cedula = data.cedula.slice(2);

		if (documento == 'V-') {
			documento = 'venezolano';
		}
		else if (documento == 'E-') {
			documento = 'extranjero';
		}
		else if (documento == 'P-') {
			documento = 'pasaporte';
		}

		$('#documento').val(documento);
		$('#documento').selectpicker('refresh');
		$('#cedula').val(cedula);
		$('#p_nombre').val(data.p_nombre);
		$('#s_nombre').val(data.s_nombre);
		$('#p_apellido').val(data.p_apellido);
		$('#s_apellido').val(data.s_apellido);
		$('#genero').val(data.genero);
		$('#genero').selectpicker('refresh');
		$('#f_nac').val(data.f_nac);
		$('#email').val(data.email);
		$('#celular').val(data.movil);
		$('#fijo').val(data.fijo);
		$('#cargo').val(data.cargo);
		$('#cargo').selectpicker('refresh');
		$('#idpersonal').val(data.id);
	});
}

//Función para eliminar(desactivar) personal
function desactivar(idpersonal) {

		const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-primary  mx-1 p-2',
		    cancelButton: 'btn btn-danger  mx-1 p-2'
		  },
		  buttonsStyling: false
		})

		swalWithBootstrapButtons.fire({
		  title: '¿Estas seguro?',
		  text: "¿Quieres desactivar a esta persona?",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Desactivar',
		  cancelButtonText: 'Cancelar',
		  reverseButtons: true
		}).then((result) => {
		  if (result.value) {
		  	$.post('../controladores/personal.php?op=desactivar', {idpersonal: idpersonal}, function (e) {
				if (e == 'true') {
					const Toast = Swal.mixin({
					  toast: true,
					  position: 'top-end',
					  showConfirmButton: false,
					  timer: 3000
					});

					Toast.fire({
					  type: 'success',
					  title: 'El personal ha sido desactivado :)'
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
					  title: 'Ups! No se pudo desactivar el personal'
					});
				}
				tabla.ajax.reload();
			});  
		  } 
		});
}

//Función para activar personal
function activar(idpersonal) {

	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-primary  mx-1 p-2',
		    cancelButton: 'btn btn-danger  mx-1 p-2'
		  },
		  buttonsStyling: false
		})

		swalWithBootstrapButtons.fire({
		  title: '¿Estas seguro?',
		  text: "¿Quieres activar a esta persona?",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Activar',
		  cancelButtonText: 'Cancelar',
		  reverseButtons: true
		}).then((result) => {
		  if (result.value) {
		  	$.post('../controladores/personal.php?op=activar', {idpersonal: idpersonal}, function (e) {
				if (e == 'true') {
					const Toast = Swal.mixin({
					  toast: true,
					  position: 'top-end',
					  showConfirmButton: false,
					  timer: 3000
					});

					Toast.fire({
					  type: 'success',
					  title: 'El personal ha sido activado :)'
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
					  title: 'Ups! No se pudo activar el personal'
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
	$('#cargo').val('');
	$('#cargo').selectpicker('refresh');
	$('#idpersonal').val('');
	$('#idpersona').val('');
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