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

  $.post('../controladores/periodo-escolar.php?op=verificar_periodo_activo',function (data) {

		if (data != '') {
      		$('#mostrarPeriodo').html(data);
		}
		else {
      		$('#alerta-periodo').html('<a class="badge badge-danger text-white col-md-12 p-2 m-1" href="periodo-escolar.php">Click para ir al módulo período escolar</a>');
		}
  })
  
  $.post('../controladores/periodo-escolar.php?op=verificar_lapso_activo', function (data) {
  	// console.log(data);
  	// return;
  	data = JSON.parse(data);

    if (data != '') {
      $('#mostrarLapso').html(data.lapso);
      $('#estatusLapso').html('Lapso ' + data.estatus);
    }
    else {
      $('#alerta-lapso').html('<a class="badge badge-danger text-white col-md-12 p-2 m-1" href="lapso-academico.php">Click para ir al módulo lapso académico</a>');
    }
  })
}

init();