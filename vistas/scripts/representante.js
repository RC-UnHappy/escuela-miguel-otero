//Funcion que se ejecutará al inicio

function init() {
	
	//Oculta el formulario al cargar la pagina
	mostrarform(false);

	//Muestra la lista de representantes
	listar();

	//Se ejecuta cuando se envia el formulario
	$([representante]).on('submit', function (event) {
		if ($([representante])[0].checkValidity()) {
			guardaryeditar(event);
		}
		else {
			scrollTo(0,100);
		}
	});

	//Se ejecuta al quitar el foco del input cedula
	$('#cedula').on('blur', function () {

		if ($('#cedula')[0].value == '') {
			$('#cedula').removeClass('is-valid');
		}
		comprobarRepresentante();
		comprobarPersona();
	});

	//Se ejecuta al seleccionar un elemento del select documento
	$('#documento').on('change', function () {
		comprobarRepresentante();
		comprobarPersona();
	});

	//Comprueba cada cambio en el select de estado de residencia
	$('#estado_residencia').on('change', function () {
		let idestadoResidencia = $('#estado_residencia')[0].value;
		if (idestadoResidencia != '') {
			let data = municipios(idestadoResidencia);

			data
				.then(function (r) {
					$('#municipio_residencia').prop('disabled', false);
					$('#municipio_residencia').html('<option value="">Seleccione</option>');
					$('#municipio_residencia').append(r);
					$('#municipio_residencia').selectpicker('refresh');

					$('#parroquia_residencia').html('<option value="">Seleccione</option>');
					$('#parroquia_residencia').prop('disabled', true);
					$('#parroquia_residencia').selectpicker('refresh');
				});
		}
		else {
			$('#municipio_residencia').html('<option value="">Seleccione</option>');
			$('#municipio_residencia').prop('disabled', true);
			$('#municipio_residencia').selectpicker('refresh');

			$('#parroquia_residencia').html('<option value="">Seleccione</option>');
			$('#parroquia_residencia').prop('disabled', true);
			$('#parroquia_residencia').selectpicker('refresh');
		}
	});

	//Comprueba cada cambio en el select municipio de residencia
	$('#municipio_residencia').on('change', function () {
		let idmunicipioResidencia = $('#municipio_residencia')[0].value;
		if (idmunicipioResidencia != '') {
			let data = parroquias(idmunicipioResidencia);

			data
				.then(function (r) {
					$('#parroquia_residencia').prop('disabled', false);
					$('#parroquia_residencia').html('<option value="">Seleccione</option>');
					$('#parroquia_residencia').append(r);
					$('#parroquia_residencia').selectpicker('refresh');
				});
		}
		else {
			$('#parroquia_residencia').html('<option value="">Seleccione</option>');
			$('#parroquia_residencia').prop('disabled', true);
			$('#parroquia_residencia').selectpicker('refresh');
		}
	});

	//Comprueba cada cambio en el select de estado de trabajo
	$('#estado_trabajo').on('change', function () {
		let idestadoResidencia = $('#estado_trabajo')[0].value;
		if (idestadoResidencia != '') {
			let data = municipios(idestadoResidencia);

			data
				.then(function (r) {
					$('#municipio_trabajo').prop('disabled', false);
					$('#municipio_trabajo').html('<option value="">Seleccione</option>');
					$('#municipio_trabajo').append(r);
					$('#municipio_trabajo').selectpicker('refresh');

					$('#parroquia_trabajo').html('<option value="">Seleccione</option>');
					$('#parroquia_trabajo').prop('disabled', true);
					$('#parroquia_trabajo').selectpicker('refresh');
				});
		}
		else {
			$('#municipio_trabajo').html('<option value="">Seleccione</option>');
			$('#municipio_trabajo').prop('disabled', true);
			$('#municipio_trabajo').selectpicker('refresh');

			$('#parroquia_trabajo').html('<option value="">Seleccione</option>');
			$('#parroquia_trabajo').prop('disabled', true);
			$('#parroquia_trabajo').selectpicker('refresh');
		}
	});

	//Comprueba cada cambio en el select municipio de residencia
	$('#municipio_trabajo').on('change', function () {
		let idmunicipioResidencia = $('#municipio_residencia')[0].value;
		if (idmunicipioResidencia != '') {
			let data = parroquias(idmunicipioResidencia);

			data
				.then(function (r) {
					$('#parroquia_trabajo').prop('disabled', false);
					$('#parroquia_trabajo').html('<option value="">Seleccione</option>');
					$('#parroquia_trabajo').append(r);
					$('#parroquia_trabajo').selectpicker('refresh');
				});
		}
		else {
			$('#parroquia_trabajo').html('<option value="">Seleccione</option>');
			$('#parroquia_trabajo').prop('disabled', true);
			$('#parroquia_trabajo').selectpicker('refresh');
		}
	});

	tabla.ajax.reload();
			
}

//Comprueba que el representante no esté registrado
function comprobarRepresentante() {
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
			url: '../controladores/representante.php?op=comprobarrepresentante',
			type: 'POST',
			data: {cedula: cedula},
			success: function (datos) {
				if (datos != 'null') {
					$('#cedula').removeClass('is-valid');
					$('#cedula').addClass('is-invalid');
					$('#mensajeCedula').html('El representante ya se encuentra registrado');
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
			url: '../controladores/representante.php?op=comprobarrepresentante',
			type: 'POST',
			data: {cedula: cedula},
			success: function (datos) {
				datosRepresentante = datos;
				$.ajax({
					url: '../controladores/representante.php?op=comprobarpersona',
					type: 'POST',
					data: {cedula: cedula},
					success: function (datosPersona) {
						if (datosRepresentante == 'null' && datosPersona != 'null') {
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
							$('#estado').val(data.idestado);
							$('#estado').selectpicker('refresh');
							if (data.idmunicipio != null) {
								$('#municipio').html('<option value="'+data.idmunicipio+'">'+data.municipio+'</option>');
								$('#municipio').prop('disabled', false);
								$('#municipio').selectpicker('refresh');	
							}
							if (data.idparroquia != null) {
								$('#parroquia').html('<option value="'+data.idparroquia+'">'+data.parroquia+'</option>');
								$('#parroquia').prop('disabled', false);
								$('#parroquia').selectpicker('refresh');
							}
							$('#direccion').val(data.direccion);
							$('#idpersona').val(data.id);
						}
					}
				});
			}
		});
	}
}

//Función para traer los estados
function estados(idpais = null) {
	let estados;
	if (idpais !== null)
		estados = $.post('../controladores/representante.php?op=listarestados&idpais=' + idpais);
	else
		estados = $.post('../controladores/representante.php?op=listarestados');

	return estados;
}

//Función para mostrar los municipios
function municipios(idestado) {

	let municipios;
	if (idestado !== null)
		municipios = $.post('../controladores/representante.php?op=listarmunicipios&idestado=' + idestado);
	else
		municipios = $.post('../controladores/representante.php?op=listarmunicipios');

	return municipios;
}

//Función para mostrar las parroquias
function parroquias(idmunicipio) {

	let parroquias;
	if (idmunicipio !== null)
		parroquias = $.post('../controladores/representante.php?op=listarparroquias&idmunicipio=' + idmunicipio);
	else
		parroquias = $.post('../controladores/representante.php?op=listarparroquias');

	return parroquias;
}

//Función para guardar y editar 
function guardaryeditar(event) {
	event.preventDefault(); //Evita que se envíe el formulario automaticamente
	// 
	$('#btnGuardar').prop('disabled', true); //Deshabilita el botón submit para evitar que lo presionen dos veces
	var formData = new FormData($([representante])[0]); //Se obtienen los datos del formulario
	
	var documento = formData.get('documento'); //Se obtiene el tipo de documento
	documento = tipo_documento(documento);//Se llama la función que lo transforma Ej: 'Venezolano' = V-
	
	var cedula = formData.get('cedula');// Se obtiene la cédula 
	
	formData.set('cedula', documento+cedula);//Se le asigna a la cédula del formData el tipo de documento

	$.ajax({
		url: '../controladores/representante.php?op=guardaryeditar', //Dirección a donde se envían los datos
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
				  title: 'Representante registrado exitosamente :)'
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
				  title: 'Representante actualizado exitosamente :)'
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
			url: '../controladores/representante.php?op=listar',
			type: 'GET',
			dataType: 'json'
		},
		'order': [[0, 'desc']]
	});
}

//Función para mostrar un registro para editar
function mostrar(idrepresentante) {
	$.post('../controladores/representante.php?op=mostrar',{idrepresentante: idrepresentante}, function (data) {	
		data = JSON.parse(data);

		// console.log(data.idestadotrabajo);
		// return;
		mostrarform(true, data.idestadoresidencia, data.idestadotrabajo);

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
		$('#instruccion').val(data.instruccion);
		$('#instruccion').selectpicker('refresh');
		$('#oficio').val(data.oficio);
		$('#email').val(data.email);
		$('#celular').val(data.movil);
		$('#fijo').val(data.fijo);

		// Los estados de residencia se cargan desde la función mostrarform
		$('#municipio_residencia').html('<option value="' + data.idmunicipioresidencia + '">' + data.municipioresidencia + '</option>');
		$('#municipio_residencia').prop('disabled', false);
		$('#municipio_residencia').selectpicker('refresh');
		$('#parroquia_residencia').html('<option value="' + data.idparroquiaresidencia+ '">' + data.parroquiaresidencia + '</option>');
		$('#parroquia_residencia').prop('disabled', false);
		$('#parroquia_residencia').selectpicker('refresh');
		$('#direccion_residencia').val(data.direccionresidencia);

		// Los estados de trabajo se cargan desde la función mostrarform
		$('#municipio_trabajo').html('<option value="' + data.idmunicipiotrabajo + '">' + data.municipiotrabajo + '</option>');
		$('#municipio_trabajo').prop('disabled', false);
		$('#municipio_trabajo').selectpicker('refresh');
		$('#parroquia_trabajo').html('<option value="' + data.idparroquiatrabajo + '">' + data.parroquiatrabajo + '</option>');
		$('#parroquia_trabajo').prop('disabled', false);
		$('#parroquia_trabajo').selectpicker('refresh');
		$('#direccion_trabajo').val(data.direcciontrabajo);

		$('#idrepresentante').val(data.idrepresentante);
	});
}

//Función para eliminar(desactivar) representantes
function desactivar(idrepresentante) {

		const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-primary  mx-1 p-2',
		    cancelButton: 'btn btn-danger  mx-1 p-2'
		  },
		  buttonsStyling: false
		})

		swalWithBootstrapButtons.fire({
		  title: '¿Estas seguro?',
		  text: "¿Quieres desactivar a este representante?",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Desactivar',
		  cancelButtonText: 'Cancelar',
		  reverseButtons: true
		}).then((result) => {
		  if (result.value) {
		  	$.post('../controladores/representante.php?op=desactivar', {idrepresentante: idrepresentante}, function (e) {
				if (e == 'true') {
					const Toast = Swal.mixin({
					  toast: true,
					  position: 'top-end',
					  showConfirmButton: false,
					  timer: 3000
					});

					Toast.fire({
					  type: 'success',
					  title: 'El representante ha sido desactivado :)'
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
					  title: 'Ups! No se pudo desactivar el representante'
					});
				}
				tabla.ajax.reload();
			});  
		  } 
		});
}

//Función para activar usuarios
function activar(idrepresentante) {

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
		  	$.post('../controladores/representante.php?op=activar', {idrepresentante: idrepresentante}, function (e) {
				if (e == 'true') {
					const Toast = Swal.mixin({
					  toast: true,
					  position: 'top-end',
					  showConfirmButton: false,
					  timer: 3000
					});

					Toast.fire({
					  type: 'success',
					  title: 'El representante ha sido activado :)'
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
					  title: 'Ups! No se pudo activar el representante'
					});
				}
				tabla.ajax.reload();
			});  
		  } 
		});

}

//Función para mostrar o ocultar el formulario
function mostrarform(flag, idestadoresidencia = null, idestadotrabajo = null) {
	limpiar();
	if (flag) {
		$('#listadoregistros').hide();
		$('#formularioregistros').show();
		$('#btnGuardar').prop('disabled', false);
		$('#btnagregar').hide();

		//Carga los estados al select estado de residencia
		if (idestadoresidencia != null) {
			let estadoResidencia = estados();
			estadoResidencia
				.then(function (r) {
					$('#estado_residencia').html('<option value="">Seleccione</option>');
					$('#estado_residencia').append(r);
					$('#estado_residencia').val(idestadoresidencia);
					$('#estado_residencia').selectpicker('refresh');
				});
		}
		else {
			let estadoResidencia = estados();
			estadoResidencia
				.then(function (r) {
					$('#estado_residencia').html('<option value="">Seleccione</option>');
					$('#estado_residencia').append(r);
					$('#estado_residencia').selectpicker('refresh');

					$('#municipio_residencia').html('<option value="">Seleccione</option>');
					$('#municipio_residencia').prop('disabled', true);
					$('#municipio_residencia').selectpicker('refresh');

					$('#parroquia_residencia').html('<option value="">Seleccione</option>');
					$('#parroquia_residencia').prop('disabled', true);
					$('#parroquia_residencia').selectpicker('refresh');
				});
		}

		//Carga los estados al select estado de trabajo
		if (idestadotrabajo != null) {
			let estadoTrabajo = estados();
			estadoTrabajo
				.then(function (r) {
					$('#estado_trabajo').html('<option value="">Seleccione</option>');
					$('#estado_trabajo').append(r);
					$('#estado_trabajo').val(idestadotrabajo);
					$('#estado_trabajo').selectpicker('refresh');
				});
		}
		else {
			let estadoResidencia = estados();
			estadoResidencia
				.then(function (r) {
					$('#estado_trabajo').html('<option value="">Seleccione</option>');
					$('#estado_trabajo').append(r);
					$('#estado_trabajo').selectpicker('refresh');

					$('#municipio_trabajo').html('<option value="">Seleccione</option>');
					$('#municipio_trabajo').prop('disabled', true);
					$('#municipio_trabajo').selectpicker('refresh');

					$('#parroquia_trabajo').html('<option value="">Seleccione</option>');
					$('#parroquia_trabajo').prop('disabled', true);
					$('#parroquia_trabajo').selectpicker('refresh');
				});
		}
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
	$('#cedula').removeClass('is-valid');
	$('#cedula').val('');
	$('#p_nombre').val('');
	$('#s_nombre').val('');
	$('#p_apellido').val('');
	$('#s_apellido').val('');
	$('#genero').val('');
	$('#genero').selectpicker('refresh');
	$('#icono_genero').removeClass('bg-primary');
	$('#icono_genero').removeClass('bg-danger');
	$('#instruccion').val('');
	$('#instruccion').selectpicker('refresh');
	$('#oficio').val('');
	$('#f_nac').val('');
	$('#email').val('');
	$('#celular').val('');
	$('#fijo').val('');
	$('#estado_trabajo').val('');
	$('#estado_trabajo').selectpicker('refresh');
	$('#municipio_trabajo').html('<option value="">Seleccione</option>');
	$('#municipio_trabajo').prop('disabled', true);
	$('#municipio_trabajo').selectpicker('refresh');
	$('#parroquia_trabajo').html('<option value="">Seleccione</option>');
	$('#parroquia_trabajo').prop('disabled', true);
	$('#parroquia_trabajo').selectpicker('refresh');
	$('#direccion_trabajo').val('');
	$('#estado_residencia').val('');
	$('#estado_residencia').selectpicker('refresh');
	$('#municipio_residencia').html('<option value="">Seleccione</option>');
	$('#municipio_residencia').prop('disabled', true);
	$('#municipio_residencia').selectpicker('refresh');
	$('#parroquia_residencia').html('<option value="">Seleccione</option>');
	$('#parroquia_residencia').prop('disabled', true);
	$('#parroquia_residencia').selectpicker('refresh');
	$('#direccion_residencia').val('');
	$('#idrepresentante').val('');
	$('#idpersona').val('');
	$('#formularioregistros').removeClass('was-validated');
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