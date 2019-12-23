//Funcion que se ejecutará al inicio

function init() {

	//Se ejecuta cuando se envia el formulario
	$([institucion]).on('submit', function (event) {
		if ($([institucion])[0].checkValidity()) {
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
			if (datos == 'update') {
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

//Función para mostrar un registro para editar
function mostrar(idrepresentante) {
	$.post('../controladores/representante.php?op=mostrar',{idrepresentante: idrepresentante}, function (data) {	
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
		$('#instruccion').val(data.instruccion);
		$('#instruccion').selectpicker('refresh');
		$('#oficio').val(data.oficio);
		$('#email').val(data.email);
		$('#celular').val(data.movil);
		$('#fijo').val(data.fijo);
		$('#estado').val(data.idestado);
		$('#estado').selectpicker('refresh');
		$('#municipio').html('<option value="'+data.idmunicipio+'">'+data.municipio+'</option>');
		$('#municipio').prop('disabled', false);
		$('#municipio').selectpicker('refresh');
		$('#parroquia').html('<option value="'+data.idparroquia+'">'+data.parroquia+'</option>');
		$('#parroquia').prop('disabled', false);
		$('#parroquia').selectpicker('refresh');
		$('#direccion').val(data.direccion);
		$('#idrepresentante').val(data.idrepresentante);
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
	$('#estado').val('');
	$('#estado').selectpicker('refresh');
	$('#municipio').html('<option value="">Seleccione</option>');
	$('#municipio').prop('disabled', true);
	$('#municipio').selectpicker('refresh');
	$('#parroquia').html('<option value="">Seleccione</option>');
	$('#parroquia').prop('disabled', true);
	$('#parroquia').selectpicker('refresh');
	$('#direccion').val('');
	$('#idrepresentante').val('');
	$('#idpersona').val('');
	$('#formularioregistros').removeClass('was-validated');
}

init();