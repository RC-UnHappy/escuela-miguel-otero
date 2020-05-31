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

	//Comprueba cada cambio en el select de pais de nacimiento
	$('#pais_nacimiento').on('change', function () {
		let idpaisNacimiento = $('#pais_nacimiento')[0].value;
			
		if (idpaisNacimiento != '') {
			let data = estados(idpaisNacimiento);

			data
			.then(function (r) {
				$('#estado_nacimiento').prop('disabled', false);
				$('#estado_nacimiento').html('<option value="">Seleccione</option>');
				$('#estado_nacimiento').append(r);
				$('#estado_nacimiento').selectpicker('refresh');

				$('#municipio_nacimiento').html('<option value="">Seleccione</option>');
				$('#municipio_nacimiento').prop('disabled', true);
				$('#municipio_nacimiento').selectpicker('refresh');

				$('#parroquia_nacimiento').html('<option value="">Seleccione</option>');
				$('#parroquia_nacimiento').prop('disabled', true);
				$('#parroquia_nacimiento').selectpicker('refresh');
			});
			 
		}
		else {
			$('#estado_nacimiento').html('<option value="">Seleccione</option>');
			$('#estado_nacimiento').prop('disabled', true);
			$('#estado_nacimiento').selectpicker('refresh');

			$('#municipio_nacimiento').html('<option value="">Seleccione</option>');
			$('#municipio_nacimiento').prop('disabled', true);
			$('#municipio_nacimiento').selectpicker('refresh');

			$('#parroquia_nacimiento').html('<option value="">Seleccione</option>');
			$('#parroquia_nacimiento').prop('disabled', true);
			$('#parroquia_nacimiento').selectpicker('refresh');
		}
	});

	//Comprueba cada cambio en el select de estado de nacimiento
	$('#estado_nacimiento').on('change', function () {
		let idestadoNacimiento = $('#estado_nacimiento')[0].value;

		if (idestadoNacimiento != '') {
			let data = municipios(idestadoNacimiento);
			
			data
				.then(function (r) {
					$('#municipio_nacimiento').prop('disabled', false);
					$('#municipio_nacimiento').html('<option value="">Seleccione</option>');
					$('#municipio_nacimiento').append(r);
					$('#municipio_nacimiento').selectpicker('refresh');

					$('#parroquia_nacimiento').html('<option value="">Seleccione</option>');
					$('#parroquia_nacimiento').prop('disabled', true);
					$('#parroquia_nacimiento').selectpicker('refresh');
				});

		}
		else {

			$('#municipio_nacimiento').html('<option value="">Seleccione</option>');
			$('#municipio_nacimiento').prop('disabled', true);
			$('#municipio_nacimiento').selectpicker('refresh');

			$('#parroquia_nacimiento').html('<option value="">Seleccione</option>');
			$('#parroquia_nacimiento').prop('disabled', true);
			$('#parroquia_nacimiento').selectpicker('refresh');
		}
	});

	//Comprueba cada cambio en el select de municipio de nacimiento
	$('#municipio_nacimiento').on('change', function () {
		let idmunicipioNacimiento = $('#municipio_nacimiento')[0].value;

		if (idmunicipioNacimiento != '') {
			let data = parroquias(idmunicipioNacimiento);

			data
				.then(function (r) {
					$('#parroquia_nacimiento').prop('disabled', false);
					$('#parroquia_nacimiento').html('<option value="">Seleccione</option>');
					$('#parroquia_nacimiento').append(r);
					$('#parroquia_nacimiento').selectpicker('refresh');
				});

		}
		else {

			$('#parroquia_nacimiento').html('<option value="">Seleccione</option>');
			$('#parroquia_nacimiento').prop('disabled', true);
			$('#parroquia_nacimiento').selectpicker('refresh');
		}
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
			$('#cedula_madre').removeClass('is-invalid');
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
			$('#cedula_madre').removeClass('is-invalid');
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
			$('#cedula_padre').removeClass('is-invalid');
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
			$('#cedula_padre').removeClass('is-invalid');
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
			crearCedulaEstudiantil();
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

	//Se ejecuta cuando se envia el formulario
	$([formularioRetirar]).on('submit', function (event) {
		if ($([formularioRetirar])[0].checkValidity()) {
			retirar(event);
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
					$('#feedback-cedula-madre').html('La cédula no se encuentra registrada');
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
					$('#cedula_padre').addClass('is-invalid');
					$('#feedback-cedula-padre').html('La cédula no se encuentra registrada');
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

//Función para mostrar los paises
function paises(idpais = null) {

	if (idpais !== null) {
		$.post('../controladores/estudiante.php?op=listarpaises', function (data) {
			$('#pais_nacimiento').append(data);
			$('#pais_nacimiento').val(idpais);
			$('#pais_nacimiento').selectpicker('refresh');
		});
	}
	else{
		$.post('../controladores/estudiante.php?op=listarpaises', function (data) {
			$('#pais_nacimiento').append(data);
			$('#pais_nacimiento').selectpicker('refresh');

			$('#estado_nacimiento').html('<option value="">Seleccione</option>');
			$('#estado_nacimiento').prop('disabled', true);
			$('#estado_nacimiento').selectpicker('refresh');

			$('#municipio_nacimiento').html('<option value="">Seleccione</option>');
			$('#municipio_nacimiento').prop('disabled', true);
			$('#municipio_nacimiento').selectpicker('refresh');

			$('#parroquia_nacimiento').html('<option value="">Seleccione</option>');
			$('#parroquia_nacimiento').prop('disabled', true);
			$('#parroquia_nacimiento').selectpicker('refresh');
		});
	}
}

//Función para traer los estados
function estados(idpais = null) {
	let estados;
	if (idpais !== null) 
		estados = $.post('../controladores/estudiante.php?op=listarestados&idpais='+idpais);
	else 
		estados = $.post('../controladores/estudiante.php?op=listarestados');
	
	return estados;
}

//Función para mostrar los municipios
function municipios(idestado) {

	let municipios;
	if (idestado !== null)
		municipios = $.post('../controladores/estudiante.php?op=listarmunicipios&idestado=' + idestado);
	else
		municipios = $.post('../controladores/estudiante.php?op=listarmunicipios');

	return municipios;
}

//Función para mostrar las parroquias
function parroquias(idmunicipio) {

	let parroquias;
	if (idmunicipio !== null)
		parroquias = $.post('../controladores/estudiante.php?op=listarparroquias&idmunicipio=' + idmunicipio);
	else
		parroquias = $.post('../controladores/estudiante.php?op=listarparroquias');

	return parroquias;
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
			else if (datos == 'update') {
				const Toast = Swal.mixin({
				  toast: true,
				  position: 'top-end',
				  showConfirmButton: false,
				  timer: 3000
				});

				Toast.fire({
				  type: 'success',
				  title: 'Estudiante actualizado exitosamente :)'
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
		
		mostrarform(true, data.idpaisnacimiento , data.idestadoresidencia);

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

		// El país de nacimiento se carga desde la función mostrarform
		$('#estado_nacimiento').html('<option value="' + data.idestadonacimiento + '">' + data.estadonacimiento + '</option>');
		$('#estado_nacimiento').prop('disabled', false);
		$('#estado_nacimiento').selectpicker('refresh');
		$('#municipio_nacimiento').html('<option value="' + data.idmunicipionacimiento + '">' + data.municipionacimiento + '</option>');
		$('#municipio_nacimiento').prop('disabled', false);
		$('#municipio_nacimiento').selectpicker('refresh');
		$('#parroquia_nacimiento').html('<option value="' + data.idparroquianacimiento + '">' + data.parroquianacimiento + '</option>');
		$('#parroquia_nacimiento').prop('disabled', false);
		$('#parroquia_nacimiento').selectpicker('refresh');

		// Los estados de residencia se cargan desde la función mostrarform
		$('#municipio_residencia').html('<option value="'+data.idmunicipioresidencia+'">'+data.municipioresidencia+'</option>');
		$('#municipio_residencia').prop('disabled', false);
		$('#municipio_residencia').selectpicker('refresh');
		$('#parroquia_residencia').html('<option value="'+data.idparroquiaresidencia+'">'+data.parroquiaresidencia+'</option>');
		$('#parroquia_residencia').prop('disabled', false);
		$('#parroquia_residencia').selectpicker('refresh');
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

    // console.log(data.cedulaP);
    // return;
    
    if (data.cedulaP != null) {
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
    }
    

		// $('#peso').val(data.peso);
		// $('#talla').val(data.talla);
		
		// if (data.todas_vacunas == 1) {
		// 	$('#vacunasSi').attr('checked', true)
		// }
		// else {
		// 	$('#vacunasNo').attr('checked', true)
		// }

		// if (data.alergico == 1) {
		// 	$('#alergicoSi').attr('checked', true)
		// }
		// else {
		// 	$('#alergicoNo').attr('checked', true)
		// }

		// //Muestra las diversidades funcionales
		// if (data.diversidades != null) {
		// 	diversidad = data.diversidades.split(',');
		// 	numeroDiversidad = $('.diversidad').length;
		// 	for (var i = 0; i < numeroDiversidad; i++) {
		// 		if (jQuery.inArray($('.diversidad')[i].value, diversidad) != -1) {
		// 			$('.diversidad')[i].checked = 'true';
		// 		}
		// 	}
		// }

		// //Muestra las enfermedades
		// if (data.enfermedades != null) {
		// 	enfermedad = data.enfermedades.split(',');
		// 	numeroEnfermedad = $('.enfermedad').length;
		// 	for (var i = 0; i < numeroEnfermedad; i++) {
		// 		if (jQuery.inArray($('.enfermedad')[i].value, enfermedad) != -1) {
		// 			$('.enfermedad')[i].checked = 'true';
		// 		}
		// 	}	
		// }

		var tipo_vivienda = data.tipo_vivienda;
		$('#'+tipo_vivienda).attr('checked', true);

		//Muestra los que sostienen el hogar
		if (data.sostenes != null) {
			sosten = data.sostenes.split(',');
			numeroSosten = $('.sosten').length;
			for (var i = 0; i < numeroSosten; i++) {
				if (jQuery.inArray($('.sosten')[i].value, sosten) != -1) {
					$('.sosten')[i].checked = 'true';
				}
			}

		}

		$('#grupo_familiar').val(data.grupo_familiar);
		$('#ingreso_mensual').val(data.ingreso_mensual);

		if (data.posee_canaima == 'si') {
			$('#canaimaSi').attr('checked', true)
			$('#condicion_canaima').prop('disabled', false)
		}
		else {
			$('#canaimaNo').attr('checked', true)
		}

		$('#condicion_canaima').val(data.condicion);

		$('#idestudiante').val(data.id);
		
		var data = 'padre';
		comprobarPadres(data);
		var data = 'madre';
		comprobarPadres(data);

	});
}

//Función para mostrar o ocultar el formulario
function mostrarform(flag, idpais = null, idestadoresidencia = null) {
	limpiar();
	if (flag) {
		$('#listadoregistros').hide();
		$('#formularioregistros').show();
		$('#btnGuardar').prop('disabled', false);
		$('#btnagregar').hide();

		//Carga los paises al select pais de nacimiento
		if (idpais !== null) {
			paises(idpais);
		}
		else {
			paises();
		}

		//Carga los estados al select estado de residencia
		if (idestadoresidencia !== null) {
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
	$("#formularioregistros")[0].reset();
	$('#documento_madre').val('');
	$('#documento_madre').selectpicker('refresh');
	$('#idmadre').val('');
	$('#alertaMadre').remove();
	$('#documento_padre').val('');
	$('#documento_padre').selectpicker('refresh');
	$('#idpadre').val('');
	$('#alertaPadre').remove();
	$('#documento').val('');
	$('#documento').selectpicker('refresh');
	$('#genero').val('');
	$('#genero').selectpicker('refresh');
	$('#icono_genero').removeClass('bg-primary');
	$('#icono_genero').removeClass('bg-danger');
	$('input[name="parto"]').attr('checked', false);
	$('#orden').attr('disabled', true);
	$('#pais_nacimiento').val('');
	$('#pais_nacimiento').selectpicker('refresh');
	$('#estado_nacimiento').html('<option value="">Seleccione</option>');
	$('#estado_nacimiento').prop('disabled', true);
	$('#estado_nacimiento').selectpicker('refresh');
	$('#municipio_nacimiento').html('<option value="">Seleccione</option>');
	$('#municipio_nacimiento').prop('disabled', true);
	$('#municipio_nacimiento').selectpicker('refresh');
	$('#parroquia_nacimiento').html('<option value="">Seleccione</option>');
	$('#parroquia_nacimiento').prop('disabled', true);
	$('#parroquia_nacimiento').selectpicker('refresh');
	$('#estado_residencia').val('');
	$('#estado_residencia').selectpicker('refresh');
	$('#municipio_residencia').html('<option value="">Seleccione</option>');
	$('#municipio_residencia').prop('disabled', true);
	$('#municipio_residencia').selectpicker('refresh');
	$('#parroquia_residencia').html('<option value="">Seleccione</option>');
	$('#parroquia_residencia').prop('disabled', true);
	$('#parroquia_residencia').selectpicker('refresh');
	// $('input[name="vacunas"]').attr('checked', false);
	// $('input[name="alergia"]').attr('checked', false);
	$('input[name="vivienda"]').attr('checked', false);
	$('input[name="canaima"]').attr('checked', false);
	$('#condicion_canaima').prop('disabled', true);
  $('#formularioregistros').removeClass('was-validated');
  $('#cedula_padre').removeClass('is-invalid');
	$('#idestudiante').val('');
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

//Función para eliminar estudiante
function eliminar(idestudiante, idpersona) {

	const swalWithBootstrapButtons = Swal.mixin({
	  customClass: {
	    confirmButton: 'btn btn-primary  mx-1 p-2',
	    cancelButton: 'btn btn-danger  mx-1 p-2'
	  },
	  buttonsStyling: false
	})

	swalWithBootstrapButtons.fire({
	  title: '¿Estas seguro?',
	  text: "¿Quieres eliminar este estudiante?",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonText: 'Eliminar',
	  cancelButtonText: 'Cancelar',
	  reverseButtons: true
	}).then((result) => {
	  if (result.value) {
	  	$.post('../controladores/estudiante.php?op=eliminar', {idestudiante: idestudiante, idpersona: idpersona}, function (e) {
			if (e == 'true') {
				const Toast = Swal.mixin({
				  toast: true,
				  position: 'top-end',
				  showConfirmButton: false,
				  timer: 3000
				});

				Toast.fire({
				  type: 'success',
				  title: 'El estudiante ha sido eliminado :)'
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
				  title: 'Ups! No se pudo eliminar el estudiante'
				});
			}
			tabla.ajax.reload();
		});  
	  } 
	});
}

//Función para retirar estudiante
function retirar(event) {
	event.preventDefault(); //Evita que se envíe el formulario automaticamente
	
	const swalWithBootstrapButtons = Swal.mixin({
	  customClass: {
	    confirmButton: 'btn btn-primary  mx-1 p-2',
	    cancelButton: 'btn btn-danger  mx-1 p-2'
	  },
	  buttonsStyling: false
	})

	swalWithBootstrapButtons.fire({
	  title: '¿Estas seguro?',
	  text: "¿Quieres retirar este estudiante?",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonText: 'Retirar',
	  cancelButtonText: 'Cancelar',
	  reverseButtons: true
	}).then((result) => {
		if (result.value) {
			let formData = new FormData($([formularioRetirar])[0]); //Se obtienen los datos del formulario

			let idpersona = formData.get('idpersona');
			let idestudianteretiro = formData.get('idestudianteretiro');
			let nombre_completo_estudiante = formData.get('nombre_completo_estudiante');
			let nombre_completo_representante = formData.get('nombre_completo_representante');
			let condicion = formData.get('condicion');
			let ultimo_grado_cursado = formData.get('ultimo_grado_cursado');
			let cedula_representante = formData.get('cedula_representante');
			let causa_retiro = formData.get('causa_retiro');

			window.open('../reporte/boletin-retiro.php?idpersona='+idpersona+'&idestudianteretiro='+idestudianteretiro+'&nombre_completo_estudiante='+nombre_completo_estudiante+'&condicion='+condicion+'&ultimo_grado_cursado='+ultimo_grado_cursado+'&nombre_completo_representante='+nombre_completo_representante+'&cedula_representante='+cedula_representante+'&causa_retiro='+causa_retiro, '_blank');

			$.ajax({
				url: '../controladores/estudiante.php?op=retirar', //Dirección a donde se envían los datos
				type: 'POST', //Método por el cual se envían los datos
				data: formData, //Datos
				contentType: false, //Este parámetro es para mandar datos al servidor por el encabezado
				processData: false, //Evita que jquery transforme la data en un string
				beforeSend: () => {
					$('#btnRetirar').prop('disabled', true);
					$('#btnRetirar').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Espere...<span class="sr-only"> Espere...</span>');
				},
				success: function (respuesta) {
					// console.log(respuesta);
					// return;
					if (respuesta.estatus == 1) {
						const Toast = Swal.mixin({
						  toast: true,
						  position: 'top-end',
						  showConfirmButton: false,
						  timer: 3000
						});

						Toast.fire({
						  type: 'success',
						  title: respuesta.msj
						});
					}
					else if (respuesta.estatus == 2) {

						const Toast = Swal.mixin({
						  toast: true,
						  position: 'top-end',
						  showConfirmButton: false,
						  timer: 3000
						});

						Toast.fire({
						  type: 'error',
						  title: respuesta.msj
						});
					}
				},
				complete: () =>{
					$('#retirarModal').modal('hide');
					cancelarformRetirar();
					$('#btnRetirar').prop('disabled', false);
					$('#btnRetirar').html('Retirar');
					tabla.ajax.reload();//Recarga la tabla con el listado sin refrescar la página
				}

			});	 
		}
	
	});
}

function mostrarRetirar(idestudiante, idpersona) {
	$.ajax({
		type: 'POST',
		url: '../controladores/estudiante.php?op=mostrarretirar',
		data: {idestudiante: idestudiante, idpersona: idpersona},
		// beforeSend: () => {},
		success: (data) => {
			data = JSON.parse(data);
			$("#cedula_representante").val(data.cedula_representante);
			$('#nombre_completo_representante').val(data.p_nombre_representante+' '+data.s_nombre_representante+' '+data.p_apellido_representante+' '+data.s_apellido_representante);
			$('#cedula_estudiante').val(data.cedula_estudiante);
			$('#nombre_completo_estudiante').val(data.p_nombre+' '+data.s_nombre+' '+data.p_apellido+' '+data.s_apellido);
			$('#ultimo_grado_cursado').val(data.grado);
			$('#condicion').val(data.estatus);
			$('#idestudianteretiro').val(idestudiante);
			$('#idpersona').val(idpersona);
			$('#id_ultima_planificacion').val(data.id_ultima_planificacion);
		},
		// complete: () => {

		// }

	});
}

//Función para limpiar el formulario
function cancelarformRetirar() {
	$("#formularioRetirar")[0].reset();
  	$('#formularioRetirar').removeClass('was-validated');
}

init();