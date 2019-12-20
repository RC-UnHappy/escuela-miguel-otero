//Funcion que se ejecutará al inicio

function init() {
	
	//Oculta el formulario al cargar la pagina
	mostrarform(false);

	//Muestra la lista de estudiantes
	listar();

	//Se ejecuta cuando se envia el formulario
	$([estudiante]).on('submit', function (event) {
		if ($([estudiante])[0].checkValidity()) {
			guardaryeditar(event);
		}
		else {
			scrollTo(0,100);
		}
	});

	//Carga los estados al select
	estados();

	//Comprueba cada cambio en el select de estado
	$('#estado').on('change', function () {
		estado = $('#estado')[0].value;
		if (estado != '') {
			$('#municipio').prop('disabled', false);
			municipios(estado);

			$('#parroquia').html('<option value="">Seleccione</option>');
			$('#parroquia').prop('disabled', true);
			$('#parroquia').selectpicker('refresh');
		}
		else {
			$('#municipio').html('<option value="">Seleccione</option>');
			$('#municipio').prop('disabled', true);
			$('#municipio').selectpicker('refresh');

			$('#parroquia').html('<option value="">Seleccione</option>');
			$('#parroquia').prop('disabled', true);
			$('#parroquia').selectpicker('refresh');
		}
	});

	//Comprueba cada cambio en el select de municipio
	$('#municipio').on('change', function () {
		municipio = $('#municipio')[0].value;
		if (municipio != '') {
			$('#parroquia').prop('disabled', false);
			parroquias(municipio);
		}
		else {
			$('#parroquia').html('<option value="">Seleccione</option>');
			$('#parroquia').prop('disabled', true);
			$('#parroquia').selectpicker('refresh');
		}
	});

	//Se ejecuta al cambiar en el select documento
	$('#documento').on('change', function () {
		comprobarTipoDocumento();
	});

	//Se ejecuta al quitar el foco del input cedula de la madre
	$('#cedula_madre').on('blur', function () {

		if ($('#documento_madre')[0].value != '' && $('#cedula_madre')[0].value != '') {
			var data = 'madre';
			comprobarPadres(data);
		}
		else {
			$('#alertaMadre').remove();
		}
	});

	//Se ejecuta al cambiar en el select documento de la madre
	$('#documento_madre').on('change', function () {
		if ($('#documento_madre')[0].value != '' && $('#cedula_madre')[0].value != '') {
			var data = 'madre';
			comprobarPadres(data);
		}
		else {
			$('#alertaMadre').remove();
		}
	});

	//Se ejecuta al quitar el foco del input cedula del padre
	$('#cedula_padre').on('blur', function () {

		if ($('#documento_padre')[0].value != '' && $('#cedula_padre')[0].value != '') {
			var data = 'padre';
			comprobarPadres(data);
		}
		else {
			$('#alertaPadre').remove();
		}
	});

	//Se ejecuta al cambiar en el select documento del padre
	$('#documento_padre').on('change', function () {
		if ($('#documento_padre')[0].value != '' && $('#cedula_padre')[0].value != '') {
			var data = 'padre';
			comprobarPadres(data);
		}
		else {
			$('#alertaPadre').remove();
		}
	});

	//Comprueba si el estudiante fue parto multiple
	$('input[name=parto]').on('click', function () {
		if (this.value == 'si') {
			$('#orden').prop('disabled', false);
		}
		else {
			$('#orden')[0].value = '';
			$('#orden').prop('disabled', true);
		}
		
	});

	//Se ejecuta al quitar el click del input f_nac
	$('#f_nac').on('blur', function () {
		crearCedulaEstudiantil();
	});

	//Se ejecuta al cambiar en el input orden
	$('#orden').on('change', function () {
		crearCedulaEstudiantil();
	});

	//Comprueba si el estudiante tiene canaima o no
	$('input[name=canaima]').on('click', function () {
		if (this.value == 'si') {
			$('#condicion_canaima').prop('disabled', false);
		}
		else {
			$('#condicion_canaima')[0].value = '';
			$('#condicion_canaima').prop('disabled', true);
		}
		
	});

	tabla.ajax.reload();
			
}

function comprobarTipoDocumento() {
	var documento = $('#documento')[0].value;

	if (documento == '' || documento == 'venezolano' || documento == 'extranjero') {
		$('#cedula')[0].value = '';
		$('#cedula').prop('readonly', false);
	}
	else {
		$('#cedula').prop('readonly', true);
		crearCedulaEstudiantil();
	}
}

//Comprueba que la persona no esté registrada
function comprobarPadres(data) {
	if (data == 'madre') {
		var documento = $('#documento_madre')[0].value;
		var cedula = $('#cedula_madre')[0].value;

		if (documento == 'venezolano') {
			documento = 'V-';
		}
		else if (documento == 'extranjero') {
			documento = 'E-';
		}
		else if (documento == 'pasaporte') {
			documento = 'P-';
		}

		cedula_madre = documento+cedula;

		$.ajax({
			url: '../controladores/estudiante.php?op=comprobarpadres',
			type: 'POST',
			data: {comprobarpadres: cedula_madre, generopadres: 'F'},
			success: function (datos) {
				if (datos != 'null') {
					datos = JSON.parse(datos);	
					$('#alertaMadre').remove();
					$('#cedula_madre').removeClass('is-invalid');
					$('#cedula_madre').after('<div class="alert alert-success col-md-12" role="alert" id="alertaMadre">'+datos.p_nombre+' '+datos.p_apellido+'</div>');
					$('#idmadre').val(datos.id);
					crearCedulaEstudiantil();
				}
				else {
					$('#alertaMadre').remove();
					$('#idmadre').val('');
					$('#cedula_madre').addClass('is-invalid');
				}
			}
		});
	}
	else {
		var documento = $('#documento_padre')[0].value;
		var cedula = $('#cedula_padre')[0].value;

		if (documento == 'venezolano') {
			documento = 'V-';
		}
		else if (documento == 'extranjero') {
			documento = 'E-';
		}
		else if (documento == 'pasaporte') {
			documento = 'P-';
		}

		cedula_padre = documento+cedula;

		$.ajax({
			url: '../controladores/estudiante.php?op=comprobarpadres',
			type: 'POST',
			data: {comprobarpadres: cedula_padre, generopadres: 'M'},
			success: function (datos) {
				if (datos != 'null') {				
					datos = JSON.parse(datos);
					$('#alertaPadre').remove();
					$('#cedula_padre').after('<div class="alert alert-success col-md-12" role="alert" id="alertaPadre">'+datos.p_nombre+' '+datos.p_apellido+'</div>');
					$('#idpadre').val(datos.id);
				}
				else {
					$('#alertaPadre').remove();
					$('#idpadre').val('');
				}
			}
		});
	}
}

//Función para crear la cédula estudiantil
function crearCedulaEstudiantil() {
	if ($('#documento')[0].value == 'cedula_estudiantil' && $('#f_nac')[0].value != '' && $('#documento_madre')[0].value != '' && $('#cedula_madre')[0].value != '') {
		if ($('input:radio[name=parto]:checked').val() == 'si') {
			var orden_nacimiento = $('#orden')[0].value;
		}
		else {
			var orden_nacimiento = 1;
		}

		var ano = $('#f_nac')[0].value.substr(2,2);
		
		var cedula_estudiantil = orden_nacimiento+ano+$('#cedula_madre')[0].value;
		$('#cedula').val('');
		$('#cedula').val(cedula_estudiantil);
	}
}

//Función para mostrar los estados
function estados() {
	$.post('../controladores/representante.php?op=listarestados', function (data) {
		$('#estado').append(data);
	});
}

//Función para mostrar los municipios
function municipios(idestado) {
	$.post('../controladores/representante.php?op=listarmunicipios&idestado='+idestado, function (data) {
		$('#municipio').html('<option value="">Seleccione</option>');
		$('#municipio').append(data);
		$('#municipio').selectpicker('refresh');
	});
}

//Función para mostrar las parroquias
function parroquias(idmunicipio) {
	$.post('../controladores/representante.php?op=listarparroquias&idmunicipio='+idmunicipio, function (data) {
		$('#parroquia').html('<option value="">Seleccione</option>');
		$('#parroquia').append(data);
		$('#parroquia').selectpicker('refresh');
	});
}

//Función para guardar y editar 
function guardaryeditar(event) {
	event.preventDefault(); //Evita que se envíe el formulario automaticamente
	// 
	$('#btnGuardar').prop('disabled', true); //Deshabilita el botón submit para evitar que lo presionen dos veces
	var formData = new FormData($([estudiante])[0]); //Se obtienen los datos del formulario
	
	var documento = formData.get('documento'); //Se obtiene el tipo de documento
	documento = tipo_documento(documento);//Se llama la función que lo transforma Ej: 'Venezolano' = V-
	
	var cedula = formData.get('cedula');// Se obtiene la cédula 
	
	formData.set('cedula', documento+cedula);//Se le asigna a la cédula del formData el tipo de documento

	$.ajax({
		url: '../controladores/estudiante.php?op=guardaryeditar', //Dirección a donde se envían los datos
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
			url: '../controladores/estudiante.php?op=listar',
			type: 'GET',
			dataType: 'json'
		},
		'order': [[0, 'desc']]
	});
}

//Función para mostrar un registro para editar
function mostrar(idestudiante) {
	$.post('../controladores/estudiante.php?op=mostrar',{idestudiante: idestudiante}, function (data) {	
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
		else {
			var documento = data.cedula.slice(0,3);
			if (documento == 'CE-') {
				documento = 'cedula_estudiantil';
				var cedula = data.cedula.slice(3);
			}
		}

		$('#documento').val(documento);
		$('#documento').selectpicker('refresh');
		$('#idrepresentante').val(data.idrepresentante);
		$('#cedula').val(cedula);
		$('#p_nombre').val(data.p_nombre);
		$('#s_nombre').val(data.s_nombre);
		$('#p_apellido').val(data.p_apellido);
		$('#s_apellido').val(data.s_apellido);
		$('#genero').val(data.genero);
		$('#genero').selectpicker('refresh');
		$('#f_nac').val(data.f_nac);

		if (data.parto_multiple == 'si') {
			$('#partoSi').attr('checked', true)
			$('#orden').prop('disabled', false)
		}
		else {
			$('#partoNo').attr('checked', true)
		}

		$('#orden').val(data.orden_nacimiento);

		$('#estado').val(data.idestado);
		$('#estado').selectpicker('refresh');
		$('#municipio').html('<option value="'+data.idmunicipio+'">'+data.municipio+'</option>');
		$('#municipio').prop('disabled', false);
		$('#municipio').selectpicker('refresh');
		$('#parroquia').html('<option value="'+data.idparroquia+'">'+data.parroquia+'</option>');
		$('#parroquia').prop('disabled', false);
		$('#parroquia').selectpicker('refresh');
		$('#direccion').val(data.direccion);

		var documento_madre = data.cedulaM.slice(0,2);
		var cedula_madre = data.cedulaM.slice(2);

		if (documento_madre == 'V-') {
			documento = 'venezolano';
		}
		else if (documento_madre == 'E-') {
			documento = 'extranjero';
		}
		else if (documento_madre == 'P-') {
			documento = 'pasaporte';
		}

		$('#documento_madre').val(documento);
		$('#documento_madre').selectpicker('refresh');
		$('#cedula_madre').val(cedula_madre);

		var documento_padre = data.cedulaP.slice(0,2);
		var cedula_padre = data.cedulaP.slice(2);

		if (documento_padre == 'V-') {
			documento = 'venezolano';
		}
		else if (documento_padre == 'E-') {
			documento = 'extranjero';
		}
		else if (documento_padre == 'P-') {
			documento = 'pasaporte';
		}

		$('#documento_padre').val(documento);
		$('#documento_padre').selectpicker('refresh');
		$('#cedula_padre').val(cedula_padre);
		$('#peso').val(data.peso);
		$('#talla').val(data.talla);
		
		if (data.todas_vacunas == 1) {
			$('#vacunasSi').attr('checked', true)
		}
		else {
			$('#vacunasNo').attr('checked', true)
		}

		console.log(data.alergico);
		if (data.alergico == 1) {
			$('#alergicoSi').attr('checked', true)
		}
		else {
			$('#alergicoNo').attr('checked', true)
		}


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
}

//Determinar documento 
function tipo_documento(documento) {
	if (documento == 'venezolano') {
		return 'V-';
	}
	else if (documento == 'extranjero') {
		return 'E-';
	}
	else if (documento == 'cedula_estudiantil') {
		return 'CE-';
	}
}

init();