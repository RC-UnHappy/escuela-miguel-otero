//Funcion que se ejecutará al inicio
(function () {
  //Muestra la lista de planificaciones
  listar();
  //Muestrs la lista de indicadores 
  listarindicadores();

  let planificaciones = traerPlanificaciones();
  planificaciones
    .then((data) => {
      data = JSON.parse(data);
      let planificacion = '';
      if (data.length != 0) {
        data.forEach(function (indice) {
          planificacion += '<option value="' + indice.id + '">' + indice.grado + ' º - "' + indice.seccion + '" - ' + indice.nombre_docente + ' ' + indice.apellido_docente + '</option>';
        });
      }
      else {
        planificacion = '<option value="">No hay planificaciones</option>';
      }
      $('#planificaciones_general').html('<option value="">Seleccione</option>');
      $('#planificaciones_general').append(planificacion);
      $('#planificaciones_general').selectpicker('refresh');
    });

  let lapsos = traerLapsosGeneral();
  lapsos
    .then((data) => {
      data = JSON.parse(data);
      let lapso = '';
      $('#lapsos_general').prop('disabled', false);
      if (data.length != 0) {
        data.forEach(function (indice) {
          lapso += '<option value="' + indice.lapso + '">' + indice.lapso + 'º Lapso' + '</option>';
        });

        $('#lapsos_general').html('<option value="">Seleccione</option>');
        $('#lapsos_general').append(lapso);
        $('#lapsos_general').selectpicker('refresh');
      }
      else {
        lapso = '<option value="">No hay lapsos</option>';
        $('#lapsos_general').html(lapso);
        $('#lapsos_general').selectpicker('refresh');
      }
    });

  //Se ejecuta cuando se envia el formulario
  $([formularioBoletinParcial]).on('submit', function (event) {
    if ($([formularioBoletinParcial])[0].checkValidity()) {
      guardaryeditar(event);
    }
    else {
      scrollTo(0, 100);
    }
  });

  $('#btnAgregar').on('click', function () {

    let planificaciones = traerPlanificaciones();
    planificaciones
      .then((data) => {
        data = JSON.parse(data);
        let planificacion = '';
        if (data.length != 0) {
          data.forEach(function (indice) {
            planificacion += '<option value="' + indice.id + '">' + indice.grado + ' º - "' + indice.seccion + '" - ' + indice.nombre_docente + ' ' + indice.apellido_docente + '</option>';
          });
        }
        else {
          planificacion = '<option value="">No hay planificaciones</option>';
        }
        $('#planificacion').html('<option value="">Seleccione</option>');
        $('#planificacion').append(planificacion);
        $('#planificacion').selectpicker('refresh');
      });

    let lapsoEnCurso = traerLapsoEnCurso();
    lapsoEnCurso
      .then((data) => {
        data = JSON.parse(data);

        let lapso = '';
        if (data.length != 0) {
          data.forEach(function (indice) {
            lapso += '<option value="' + indice.lapso + '">' + indice.lapso + 'º Lapso' + '</option>';
          });

          $('#lapso_en_curso').html(lapso);
          $('#lapso_en_curso').selectpicker('refresh');
        }
        else {
          lapso = '<option value="">No hay lapsos</option>';
          $('#lapso_en_curso').html(lapso);
          $('#lapso_en_curso').selectpicker('refresh');
        }
      });
  });

  //Comprueba cada cambio en el select de planificacion de boletin parcial
  $('#planificacion').on('change', function () {
    let idplanificacion = $('#planificacion')[0].value;
    if (idplanificacion != '') {
      /**
       * Esto es para el select de estudiantes
       */
      let estidiantes = traerEstudiantes(idplanificacion);
      estidiantes
        .then((data) => {
          data = JSON.parse(data);

          let estudiante = '';
          $('#estudiantes').prop('disabled', false);
          if (data.length != 0) {
            data.forEach(function (indice) {
              estudiante += '<option value="' + indice.id + '">' + indice.p_nombre + ' ' + indice.s_nombre + ' ' + indice.p_apellido + ' ' + indice.s_apellido +' </option>';
            });

            $('#estudiantes').html('<option value="">Seleccione</option>');
            $('#estudiantes').append(estudiante);
            $('#estudiantes').selectpicker('refresh');
          }
          else {
            estudiante = '<option value="">No hay estudiantes</option>';
            $('#estudiantes').html(estudiante);
            $('#estudiantes').selectpicker('refresh');
          }
        });
      
      /**
       * Esto es para traer los indicadores
       */
    }
    else {
      $('#estudiantes').html('<option value="">Seleccione</option>');
      $('#estudiantes').prop('disabled', true);
      $('#estudiantes').selectpicker('refresh');
    }
    listarindicadores(); 
  });

  //Comprueba cada cambio en el select de estudiante de boletin parcial
  $('#estudiantes').on('change', function () {
    let lapso_en_curso = $('#lapso_en_curso')[0].value; 
    let idplanificacion = $('#planificacion')[0].value;   
    let idestudiantes = $('#estudiantes')[0].value;   
    listarindicadores(idestudiantes); 
    let recomendacion = traerRecomendacion(idplanificacion, idestudiantes, lapso_en_curso);
    recomendacion
    .then((data) => {
      data = JSON.parse(data);
      if (data != null) {
        $('#recomendacion').val(data.recomendacion);
        $('#idrecomendacion').val(data.id);

      }
      else {
        $('#recomendacion').val('');
      }
    });
    
  });

  //Comprueba cada cambio en el select de planificaciones
  $('#planificaciones_general').on('change', function () {
    let idplanificacion = $('#planificaciones_general')[0].value;
    let lapso_en_curso = $('#lapso_en_curso')[0].value;
    
    if (idplanificacion != '') {
      let estudiante = traerEstudiantes(idplanificacion, lapso_en_curso);
      estudiante
      .then((data) => {
        data = JSON.parse(data);
        let estudiante = '';
        $('#estudiantes_general').prop('disabled', false);
        if (data.length != 0) {
          data.forEach(function (indice) {
            estudiante += '<option value="' + indice.id + '">' + indice.p_nombre + ' ' + indice.s_nombre + ' ' + indice.p_apellido + ' ' + indice.s_apellido + ' </option>';
          });

          $('#estudiantes_general').html('<option value="">Seleccione</option>');
          $('#estudiantes_general').append(estudiante);
          $('#estudiantes_general').selectpicker('refresh');
        }
        else {
          estudiante = '<option value="">No hay estudiantes</option>';
          $('#estudiantes_general').html(estudiante);
          $('#estudiantes_general').selectpicker('refresh');
        }
      });
    }
    else {
      $('#estudiantes_general').prop('disabled', true);
      $('#estudiantes_general').html('<option value="">Seleccione</option>');
      $('#estudiantes_general').selectpicker('refresh');
      $('#lapsos_general').val('');
      $('#lapsos_general').selectpicker('refresh');
      listar();
    }
  });

  //Comprueba cada cambio en el select de estudiantes_general
  $('#estudiantes_general').on('change', function () {
    let idestudiantes = $('#estudiantes_general')[0].value;
    let idplanificacion = $('#planificaciones_general')[0].value;
    let lapso = $('#lapsos_general')[0].value;
    if (idestudiantes != '' && idplanificacion != '' && lapso != '') {
      listar(idestudiantes, idplanificacion, lapso);     
    }
    else {
      listar();
    }
  });

  //Comprueba cada cambio en el select de lapso indicador
  $('#lapsos_general').on('change', function () {
    $('#estudiantes_general').val('');
    $('#estudiantes_general').selectpicker('refresh');
    listar();
  });

  tabla.ajax.reload();
})();

function traerPlanificaciones() {

  let planificaciones = $.post('../controladores/boletin-parcial.php?op=traerplanificaciones');

  return planificaciones;
}

function traerEstudiantes(idplanificacion = null, lapso_en_curso = null) {

  let estudiantes = $.post('../controladores/boletin-parcial.php?op=traerestudiantes', { idplanificacion: idplanificacion, lapso_en_curso: lapso_en_curso });
  return estudiantes;
}

function traerIndicadores(idplanificacion, lapso) {

  if (idplanificacion != '' && lapso != '') {
    let indicadores = $.post('../controladores/boletin-parcial.php?op=traerindicadores', {idplanificacion: idplanificacion, lapso: lapso});
    return indicadores;   
  }
  return;
}

function traerLapsoEnCurso() {
  let lapsos = $.post('../controladores/boletin-parcial.php?op=traerlapsoencurso');
  return lapsos;
}

function traerRecomendacion(idplanificacion, idestudiantes, lapso_en_curso) {
  let recomendacion = $.post('../controladores/boletin-parcial.php?op=traerrecomendacion', {idplanificacion: idplanificacion, idestudiantes: idestudiantes, lapso_en_curso: lapso_en_curso});
  return recomendacion;
}

function traerLapsosGeneral() {
  let lapsos = $.post('../controladores/boletin-parcial.php?op=traerlapsosgeneral');
  return lapsos;
}

//Función cancelarform
function cancelarform() {
  limpiar();
}

//Función para guardar y editar 
function guardaryeditar(event) {
  event.preventDefault(); //Evita que se envíe el formulario automaticamente
  // 
  $('#btnGuardar').prop('disabled', true);
  var formData = new FormData($([formularioBoletinParcial])[0]); //Se obtienen los datos del formulario

  $.ajax({
    url: '../controladores/boletin-parcial.php?op=guardaryeditar', //Dirección a donde se envían los datos
    type: 'POST', //Método por el cual se envían los datos
    data: formData, //Datos
    contentType: false, //Este parámetro es para mandar datos al servidor por el encabezado
    processData: false, //Evita que jquery transforme la data en un string
    success: function (datos) {
      $('#btnGuardar').prop('disabled', false);
      if (datos == 'true') {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });

        Toast.fire({
          type: 'success',
          title: 'Notas registradas exitosamente :)'
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
          title: 'Notas modificadas exitosamente :)'
        });

        $('#planificacionModal').modal('hide');
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

      tabla.ajax.reload();//Recarga la tabla con el listado sin refrescar la página
    }

  });
}

//Función para listar los registros
function listar(idestudiantes, idplanificacion, lapso) {
  tabla = $('#tblistado').DataTable({
    "processing": true,
    pagingType: "first_last_numbers",
    language: {
      "info": "Mostrando desde _START_ hasta _END_ de _TOTAL_ registros",
      "lengthMenu": "Mostrar _MENU_ entradas",
      "loadingRecords": "Cargando...",
      "processing": "Procesando...",
      "search": "Buscar:",
      "emptyTable": "No hay datos para mostrar",
      "infoEmpty": "Mostrando 0 hasta 0 de 0 entradas",
      "paginate": {
        "first": "Primero",
        "last": "Último"
      },
    },
    "pageLength": 25,
    dom: 'lfrtip',
    "destroy": true, //Elimina cualquier elemente que se encuentre en la tabla
    "ajax": {
      url: '../controladores/boletin-parcial.php?op=listar',
      type: 'POST',
      dataType: 'json',
      data: {idestudiantes: idestudiantes, idplanificacion: idplanificacion, lapso: lapso}
    },
    'order': [[1, 'asc']]
  });
}

//Función para listar los indicadores
function listarindicadores(idestudiantes) {
  let idplanificacion = $('#planificacion')[0].value;
  let lapso_en_curso = $('#lapso_en_curso')[0].value;
  tabla = $('#tblistadoindicadores').DataTable({
    "processing": true,
    pagingType: "first_last_numbers",
    language: {
      "info": "Mostrando desde _START_ hasta _END_ de _TOTAL_ registros",
      "lengthMenu": "Mostrar _MENU_ entradas",
      "loadingRecords": "Cargando...",
      "processing": "Procesando...",
      "search": "Buscar:",
      "emptyTable": "No hay datos para mostrar",
      "infoEmpty": "Mostrando 0 hasta 0 de 0 entradas",
      "paginate": {
        "first": "Primero",
        "last": "Último"
      },
    },
    "pageLength": 25,
    dom: '',
    "destroy": true, //Elimina cualquier elemente que se encuentre en la tabla
    "ajax": {
      url: '../controladores/boletin-parcial.php?op=listarindicadores',
      data: { idplanificacion: idplanificacion, lapso_en_curso: lapso_en_curso, idestudiantes:idestudiantes },
      type: 'POST',
      dataType: 'json'
    },
    'order': [[0, 'asc']]
  });
}

//Función para limpiar el formulario
function limpiar() {
  $([formularioBoletinParcial])[0].reset();
  $('.selectpicker').selectpicker('refresh');
  $('#formularioBoletinParcial').removeClass('was-validated');
  listarindicadores();
}



