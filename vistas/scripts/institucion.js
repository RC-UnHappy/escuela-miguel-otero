//Funcion que se ejecutará al inicio

function init() {

	mostrarform(false);

	mostrarDatosInstitucion();

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

//Funcion para mostrar los datos de la institución
function mostrarDatosInstitucion() {
	$.post('../controladores/institucion.php?op=mostrardatosinstitucion', function (data) {
		data = JSON.parse(data);

		$('#mostrarNombre').html(data.nombre);
		$('#mostrarEstado').html(data.estado);
		$('#mostrarMunicipio').html(data.municipio);
		$('#mostrarParroquia').html(data.parroquia);
		$('#mostrarDireccion').html(data.direccion);
		$('#mostrarTelefono').html(data.telefono);
		$('#mostrarCorreo').html(data.correo);
		$('#mostrarDependencia').html(data.dependencia);
		$('#mostrarCodDea').html(data.cod_dea);
		$('#mostrarCodEstadistico').html(data.cod_estadistico);
		$('#mostrarCodDependencia').html(data.cod_dependencia);
		$('#mostrarCodElectoral').html(data.cod_electoral);
		$('#mostrarFechaFundada').html(data.fecha_fundada);
		$('#mostrarFechaBolivariana').html(data.fecha_bolivariana);
		$('#mostrarClase').html(data.clase_plantel);
		$('#mostrarCategoria').html(data.categoria);
		$('#mostrarCondicion').html(data.condicion_estudio);
		$('#mostrarTipoMatricula').html(data.tipo_matricula);
		$('#mostrarTurno').html(data.turno);
		$('#mostrarHorario').html(data.horario);
		$('#mostrarMatricula').html('Total: '+data.estudiantes+' '+'Varones: '+data.varones+' '+'Hembras: '+data.hembras);
		$('#mostrarAmbientes').html(data.ambientes);
		$('#mostrarDocentes').html(data.docentes);
		$('#mostrarEspecialistas').html(data.especialistas);
		$('#mostrarAdministrativos').html(data.administrativos);
		$('#mostrarObreros').html(data.obreros);
		$('#mostrarVigilantes').html(data.vigilantes);
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
	var formData = new FormData($([institucion])[0]); //Se obtienen los datos del formulario

	$.ajax({
		url: '../controladores/institucion.php?op=guardaryeditar', //Dirección a donde se envían los datos
		type: 'POST', //Método por el cual se envían los datos
		data: formData, //Datos
		contentType: false, //Este parámetro es para mandar datos al servidor por el encabezado
		processData: false, //Evita que jquery transforme la data en un string
		success: function (datos) {
			// console.log("datos", datos);
			if (datos == 'true') {
				const Toast = Swal.mixin({
				  toast: true,
				  position: 'top-end',
				  showConfirmButton: false,
				  timer: 3000
				});

				Toast.fire({
				  type: 'success',
				  title: 'Datos de la institucion registrados exitosamente :)'
				});
			}
			else if (datos == 'update') {
				mostrarDatosInstitucion();
				const Toast = Swal.mixin({
				  toast: true,
				  position: 'top-end',
				  showConfirmButton: false,
				  timer: 3000
				});

				Toast.fire({
				  type: 'success',
				  title: 'Datos de la institucion actualizados exitosamente :)'
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
		}
	});		
}

//Función para mostrar un registro para editar
function mostrar() {
	$.post('../controladores/institucion.php?op=mostrar', function (data) {	
		data = JSON.parse(data);
		mostrarform(true);

		$('#nombre').val(data.nombre);
		$('#estado').val(data.idestado);
		$('#estado').selectpicker('refresh');
		$('#municipio').html('<option value="'+data.idmunicipio+'">'+data.municipio+'</option>');
		$('#municipio').prop('disabled', false);
		$('#municipio').selectpicker('refresh');
		$('#parroquia').html('<option value="'+data.idparroquia+'">'+data.parroquia+'</option>');
		$('#parroquia').prop('disabled', false);
		$('#parroquia').selectpicker('refresh');
		$('#direccion').val(data.direccion);
		$('#telefono').val(data.telefono);
		$('#correo').val(data.correo);
		$('#dependencia').val(data.dependencia);
		$('#cod_dea').val(data.cod_dea);
		$('#cod_estadistico').val(data.cod_estadistico);
		$('#cod_dependencia').val(data.cod_dependencia);
		$('#cod_electoral').val(data.cod_electoral);
		$('#cod_smee').val(data.cod_smee);
		$('#fecha_fundada').val(data.fecha_fundada);
		$('#fecha_bolivariana').val(data.fecha_bolivariana);
		$('#clase_plantel').val(data.clase_plantel);
		$('#categoria').val(data.categoria);
		$('#condicion_estudio').val(data.condicion_estudio);
		$('#tipo_matricula').val(data.tipo_matricula);
		$('#turno').val(data.turno);
		$('#horario').val(data.horario);
		$('#idinstitucion').val(data.id);
		$("#codigo_qr").val(data.codigo_qr);
	});
}

//Función para mostrar o ocultar el formulario
function mostrarform(flag) {
	limpiar();
	if (flag) {
		$('#datosInstitucion').hide();
		$('#formularioregistros').show();
		$('#btnGuardar').prop('disabled', false);
		$('#btneditar').hide();
	}
	else{
		$('#datosInstitucion').show();
		$('#formularioregistros').hide();
		$('#btneditar').show();
	}
}

//Función cancelarform
function cancelarform() {
	limpiar();
	mostrarform(false);
}

//Función para limpiar el formulario
function limpiar() {
		$('#nombre').val('');
		$('#estado').val('');
		$('#estado').selectpicker('refresh');
		$('#municipio').html('<option value="">Seleccione</option>');
		$('#municipio').prop('disabled', true);
		$('#municipio').selectpicker('refresh');
		$('#parroquia').html('<option value="">Seleccione</option>');
		$('#parroquia').prop('disabled', true);
		$('#parroquia').selectpicker('refresh');
		$('#direccion').val('');
		$('#telefono').val('');
		$('#correo').val('');
		$('#dependencia').val('');
		$('#cod_dea').val('');
		$('#cod_estadistico').val('');
		$('#cod_dependencia').val('');
		$('#cod_electoral').val('');
		$('#fecha_fundada').val('');
		$('#fecha_bolivariana').val('');
		$('#clase_plantel').val('');
		$('#categoria').val('');
		$('#condicion_estudio').val('');
		$('#tipo_matricula').val('');
		$('#turno').val('');
		$('#horario').val('');
		$('#idinstitucion').val('');
		$('#codigo_qr').val('');
}

init();