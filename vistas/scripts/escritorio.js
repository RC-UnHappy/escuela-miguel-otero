//Funcion que se ejecutará al inicio
function init() {
	mostrarDatosInstitucion();	
}

//Funcion para mostrar los datos de la institución
function mostrarDatosInstitucion() {
	$.post('../controladores/institucion.php?op=mostrardatosinstitucion', function (data) {
		data = JSON.parse(data);

		$('#mostrarMatricula').html(data.estudiantes);
		$('#mostrarHembras').html(data.hembras);
		$('#mostrarVarones').html(data.varones);
		$('#mostrarAmbientes').html(data.ambientes);
		$('#mostrarDocentes').html(data.docentes);
		$('#mostrarEspecialistas').html(data.especialistas);
		$('#mostrarAdministrativos').html(data.administrativos);
		$('#mostrarObreros').html(data.obreros);
		$('#mostrarVigilantes').html(data.vigilantes);
	});
}

init();