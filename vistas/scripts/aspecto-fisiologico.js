//Funcion que se ejecutará al inicio
(function () {
  //Muestra la lista de planificaciones
  listar();

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
        planificacion = '<option value="">Debe finalizar todos los lapsos académicos</option>';
      }
      $('#planificaciones_general').html('<option value="">Seleccione</option>');
      $('#planificaciones_general').append(planificacion);
      $('#planificaciones_general').selectpicker('refresh');
    });

  //Se ejecuta cuando se envia el formulario
  $([formularioAspectoFisiologico]).on('submit', function (event) {
    if ($([formularioAspectoFisiologico])[0].checkValidity()) {
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
          planificacion = '<option value="">Debe finalizar todos los lapsos académicos</option>';
        }
        $('#planificacion').html('<option value="">Seleccione</option>');
        $('#planificacion').append(planificacion);
        $('#planificacion').selectpicker('refresh');
      });

    // let literales = traerLiterales();
    // literales
    //   .then((data) => {
    //     data = JSON.parse(data);

    //     let literal = '';
    //     if (data.length != 0) {
    //       data.forEach(function (indice) {
    //         literal += '<option value="' + indice.id + '">' + indice.literal + ' - ' + indice.interpretacion + '</option>';
    //       });

    //       $('#literal').html('<option value="">Seleccione</option>');
    //       $('#literal').append(literal);
    //       $('#literal').selectpicker('refresh');
    //     }
    //     else {
    //       literal = '<option value="">No hay literales</option>';
    //       $('#literal').html(literal);
    //       $('#literal').selectpicker('refresh');
    //     }
    //   });
  });

  //Comprueba cada cambio en el select de planificacion del modal boletin final
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
          $('#estudiante').prop('disabled', false);
          if (data.length != 0) {
            data.forEach(function (indice) {
              estudiante += '<option value="' + indice.id + '">' + indice.p_nombre + ' ' + indice.s_nombre + ' ' + indice.p_apellido + ' ' + indice.s_apellido + ' </option>';
            });

            $('#estudiante').html('<option value="">Seleccione</option>');
            $('#estudiante').append(estudiante);
            $('#estudiante').selectpicker('refresh');
          }
          else {
            estudiante = '<option value="">No hay estudiantes</option>';
            $('#estudiante').html(estudiante);
            $('#estudiante').selectpicker('refresh');
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
  });

  //Comprueba cada cambio en el select de planificaciones
  $('#planificaciones_general').on('change', function () {
    let idplanificacion = $('#planificaciones_general')[0].value;

    if (idplanificacion != '') {
      listar(idplanificacion);
      $('#botonReporte').html('<a target="_blank" href="../reporte/aspecto-fisiologico.php?idplanificacion=' + idplanificacion +'"><button class="btn btn-outline-primary btn-pill shadow-sm" title="Generar reporte de los datos fisiológicos"><i class="fa fa-file"></i> Reporte</button></a>');

    }
    else {
      listar();
      $('#botonReporte').html('');
    }
  });

  tabla.ajax.reload();
})();

const capitalize = (s) => {
  if (typeof s !== 'string') return ''
  return s.charAt(0).toUpperCase() + s.slice(1)
}

function traerPlanificaciones() {

  let planificaciones = $.post('../controladores/aspecto-fisiologico.php?op=traerplanificaciones');

  return planificaciones;
}

function traerEstudiantes(idplanificacion = null) {

  let estudiantes = $.post('../controladores/aspecto-fisiologico.php?op=traerestudiantes', { idplanificacion: idplanificacion });
  return estudiantes;
}

function traerLiterales() {
  let literales = $.post('../controladores/boletin-final.php?op=traerliterales');
  return literales;
}

//Función cancelarform
function cancelarform() {
  limpiar();
}

//Función para guardar y editar 
function guardaryeditar(event) {
  event.preventDefault(); //Evita que se envíe el formulario automaticamente
  // 
  // $('#btnGuardar').prop('disabled', true);
  var formData = new FormData($([formularioAspectoFisiologico])[0]); //Se obtienen los datos del formulario

  $.ajax({
    url: '../controladores/aspecto-fisiologico.php?op=guardaryeditar', //Dirección a donde se envían los datos
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
          title: 'Aspectos fisiológicos registrados exitosamente :)'
        });

        // Actualiza el select de estudiante
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
              $('#estudiante').prop('disabled', false);
              if (data.length != 0) {
                data.forEach(function (indice) {
                  estudiante += '<option value="' + indice.id + '">' + indice.p_nombre + ' ' + indice.s_nombre + ' ' + indice.p_apellido + ' ' + indice.s_apellido + ' </option>';
                });

                $('#estudiante').html('<option value="">Seleccione</option>');
                $('#estudiante').append(estudiante);
                $('#estudiante').selectpicker('refresh');
              }
              else {
                estudiante = '<option value="">No hay estudiantes</option>';
                $('#estudiante').html(estudiante);
                $('#estudiante').selectpicker('refresh');
              }
            });
        }
        else {
          $('#estudiante').html('<option value="">Seleccione</option>');
          $('#estudiante').prop('disabled', true);
          $('#estudiante').selectpicker('refresh');
        }

        // Permite limpiar el formulario pero mantener las misma planificación que estaba
        limpiar(idplanificacion);
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
          title: 'Aspectos fisiológicos modificados exitosamente :)'
        });

        $('#aspectoFisiologicoModal').modal('hide');
        limpiar();
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
function listar(idplanificacion) {
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
      url: '../controladores/aspecto-fisiologico.php?op=listar',
      type: 'POST',
      dataType: 'json',
      data: { idplanificacion: idplanificacion }
    },
    'order': [[1, 'asc']]
  });
}

//Función para mostrar un registro para editar
function mostrar(idaspectofisiologico) {
  $.post('../controladores/aspecto-fisiologico.php?op=mostrar', { idaspectofisiologico: idaspectofisiologico }, function (data) {
    
    data = JSON.parse(data);

    $('#planificacion').html('<option value="' + data.idplanificacion + '">' + data.grado + ' º - "' + data.seccion + '" - ' + data.p_nombre + ' ' + data.p_apellido + '</option>');
    $('#planificacion').selectpicker('refresh');

    $('#estudiante').html('<option value="' + data.idestudiante + '">' + capitalize(data.p_nombre_estudiante) + ' ' + capitalize(data.s_nombre_estudiante) + ' ' + capitalize(data.p_apellido_estudiante) + ' ' + capitalize(data.s_apellido_estudiante) + '</option>');
    $('#estudiante').selectpicker('refresh');

    $('#peso').val(data.peso);
    $('#talla').val(data.talla);

    if (data.todas_vacunas == 1) {
      $('#vacunasSi').attr('checked', true)
    }
    else {
      $('#vacunasNo').attr('checked', true)
    }

    if (data.alergia == 1) {
      $('#alergicoSi').attr('checked', true)
    }
    else {
      $('#alergicoNo').attr('checked', true)
    }

    //Muestra las diversidades_funcionales funcionales
    if (data.diversidades_funcionales != null) {
      diversidad = data.diversidades_funcionales.split(',');
      numeroDiversidad = $('.diversidad').length;
      for (var i = 0; i < numeroDiversidad; i++) {
        if (jQuery.inArray($('.diversidad')[i].value, diversidad) != -1) {
          $('.diversidad')[i].checked = 'true';
        }
      }
    }

    if (data.c == 1) 
      $('#cSi').attr('checked', true)  
    else 
      $('#cNo').attr('checked', true)

    if (data.alimentos == 1) 
      $('#alimentosSi').attr('checked', true)  
    else 
      $('#alimentosNo').attr('checked', true)

    if (data.utiles == 1) 
      $('#utilesSi').attr('checked', true)  
    else 
      $('#utilesNo').attr('checked', true)
    

    //Muestra las enfermedades
    if (data.enfermedades != null) {
      enfermedad = data.enfermedades.split(',');
      numeroEnfermedad = $('.enfermedad').length;
      for (var i = 0; i < numeroEnfermedad; i++) {
        if (jQuery.inArray($('.enfermedad')[i].value, enfermedad) != -1) {
          $('.enfermedad')[i].checked = 'true';
        }
      }
    }

    $('#idaspectofisiologico').val(data.id);
  });
}

//Función para limpiar el formulario
function limpiar(idplanificacion = '') {
  $([formularioAspectoFisiologico])[0].reset();

  let planificaciones = traerPlanificaciones();
  planificaciones
    .then((data) => {
      data = JSON.parse(data);
      let planificacion = '';
      if (data.length != 0) {
        data.forEach(function (indice) {
          let selected = (idplanificacion == indice.id) ? 'selected' : '';
          planificacion += '<option value="' + indice.id + '" '+selected+' >' + indice.grado + ' º - "' + indice.seccion + '" - ' + indice.nombre_docente + ' ' + indice.apellido_docente + '</option>';
        });
      }
      else {
        planificacion = '<option value="">Debe finalizar todos los lapsos académicos</option>';
      }
      $('#planificacion').html('<option value="">Seleccione</option>');
      $('#planificacion').append(planificacion);
      $('#planificacion').selectpicker('refresh');
    });


  $('#estudiante').html('<option value="">Seleccione</option>');
  $('#estudiante').prop('readonly', false);
  $('.selectpicker').selectpicker('refresh');

  $('input[name="todas_vacunas"]').attr('checked', false);
  $('input[name="alergia"]').attr('checked', false);
  $('input[name="c"]').attr('checked', false);
  $('input[name="alimentos"]').attr('checked', false);
  $('input[name="utiles"]').attr('checked', false);
  $('#idaspectofisiologico').val('');
  $('#formularioAspectoFisiologico').removeClass('was-validated');
}



