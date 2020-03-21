//Funcion que se ejecutará al inicio
(function () {
  //Muestra la lista de planificaciones
  listar();

  traerPeriodosEscolares();

  //Se ejecuta cuando se envia el formulario
  $([formularioPlanificacion]).on('submit', function (event) {
    if ($([formularioPlanificacion])[0].checkValidity()) {
      guardaryeditar(event);
    }
    else {
      scrollTo(0, 100);
    }
  });

  //Se ejecuta cuando se envia el formulario de proyecto de aprendizaje
  $([formularioProyectoAprendizaje]).on('submit', function (event) {
    if ($([formularioProyectoAprendizaje])[0].checkValidity()) {
      guardaryEditarProyectoAprendizaje(event);
    }
    else {
      scrollTo(0, 100);
    }
  });

  //Se ejecuta cuando se envia el formulario de editar proyecto de aprendizaje
  $([formularioProyectoAprendizaje]).on('submit', function (event) {
    if ($([formularioEditarProyectoAprendizaje])[0].checkValidity()) {
      guardaryEditarProyectoAprendizaje(event);
    }
    else {
      scrollTo(0, 100);
    }
  });

  $('#btnAgregar').on('click', function () {
    $('#tituloModal').html('Crear planificación');
    traerPeriodosActivoPlanificados();
    traerGrados();
    traerAmbientes();
    traerDocentes();
  });

  $('#btnAgregarProyectoAprendizaje').on('click', function () {
    traerPlanificaciones();
    listarProyectoAprendizaje();
  });

  //Comprueba cada cambio en el select de grado
  $('#planificacion').on('change', function () {
    idplanificacion = $('#planificacion')[0].value;
    listarProyectoAprendizaje(idplanificacion);
    if (idplanificacion != '') {
      $('#lapso').prop('disabled', false);
      traerLapsos(idplanificacion);
    }
    else {
      $('#lapso').html('<option value="">Seleccione</option>');
      $('#lapso').prop('disabled', true);
      $('#lapso').selectpicker('refresh');
    }
  });

  //Comprueba cada cambio en el select de grado
  $('#grado').on('change', function () {
    idgrado = $('#grado')[0].value;
    idPeriodoEscolar = $('#periodo_escolar')[0].value;
    if (idgrado != '') {
      $('#seccion').prop('disabled', false);
      traerSecciones(idgrado, '', idPeriodoEscolar);
    }
    else {
      $('#seccion').html('<option value="">Seleccione</option>');
      $('#seccion').prop('disabled', true);
      $('#seccion').selectpicker('refresh');
    }
  });

  $('#periodo_escolar').on('change', function () {
    idPeriodoEscolar = $('#periodo_escolar')[0].value;
    $('#grado').val('');
    $('#grado').selectpicker('refresh');
    $('#seccion').html('<option value="">Seleccione</option>');
    $('#seccion').prop('disabled', true);
    $('#seccion').selectpicker('refresh');
    traerAmbientes('', idPeriodoEscolar);
    traerDocentes('', idPeriodoEscolar);
    $('#cupo').val('');
  });

  $('#periodos').on('change', function () {
    let idperiodo = $('#periodos')[0].value;
    listar(idperiodo);
  });

  $('#ambiente').on('change', function () {
    let capacidad = $('option:selected', this).attr('capacidad');
    $('#cupo').val(capacidad);
  });

  tabla.ajax.reload();
})();

function traerPlanificaciones() {  

  $.post('../controladores/gestionar-indicador.php?op=traerplanificaciones', function (data) {
    data = JSON.parse(data);

    let planificacion = '';
    if (data.length != 0) {
      data.forEach(function (indice) {
        planificacion += '<option value="' + indice.id + '">' + indice.grado + ' º - "' + indice.seccion + '" - ' + indice.nombre_docente + ' ' +indice.apellido_docente + '</option>';
      });
    }
    else {
      planificacion = '<option value="">No hay planificaciones</option>';
    }
    $('#planificacion').html('<option value="">Seleccione</option>');
    $('#planificacion').append(planificacion);
    $('#planificacion').selectpicker('refresh');
  });
}

function traerLapsos(idplanificacion = null) {
  $.post('../controladores/gestionar-indicador.php?op=traerlapsos', {idplanificacion: idplanificacion}, function (data) {
    data = JSON.parse(data);

    let lapso = '';
    if (data.length != 0) {
      data.forEach(function (indice) {
        lapso += '<option value="' + indice.lapso + '">' + indice.lapso + 'º Lapso' +'</option>';
      });

      $('#lapso').html('<option value="">Seleccione</option>');
      $('#lapso').append(lapso);
      $('#lapso').selectpicker('refresh');
    }
    else {
      lapso = '<option value="">No hay lapsos</option>';
      $('#lapso').html(lapso);
      $('#lapso').selectpicker('refresh');
    }
  });
}

function traerPeriodosEscolares() {

  $.post('../controladores/planificacion.php?op=consultarperiodo')
    .then(function (periodoActual) {
      $.post('../controladores/planificacion.php?op=traerperiodosescolares')
        .then(function (periodos) {
          data = JSON.parse(periodos);
          periodos = '';
          if (data.length != 0) {
            let selected = '';
            data.forEach(function (indice) {
              if (indice.id == periodoActual)
                selected = 'selected';
              else
                selected = '';
              periodos += '<option value="' + indice.id + '"' + selected + '>' + indice.periodo + '</option>';
            });
          }
          else {
            periodos = '<option value="">Debe crear un período escolar</option>';
          }
          $('#periodos').append(periodos);
          $('#periodos').selectpicker('refresh');
        });
    });
}

function traerPeriodosActivoPlanificados() {

  $.post('../controladores/planificacion.php?op=consultarperiodo')
    .then(function (periodoActual) {
      $.post('../controladores/planificacion.php?op=traerperiodosactivoplanificados')
        .then(function (periodos) {
          data = JSON.parse(periodos);
          periodos = '';
          if (data.length != 0) {
            let selected = '';
            data.forEach(function (indice) {
              if (indice.id == periodoActual)
                selected = 'selected';
              else
                selected = '';
              periodos += '<option value="' + indice.id + '"' + selected + '>' + indice.periodo + '</option>';
            });
          }
          else {
            periodos = '<option value="">Debe crear un período escolar</option>';
          }
          $('#periodo_escolar').html(periodos);
          $('#periodo_escolar').selectpicker('refresh');
        });
    });
}

function traerGrados() {
  $.post('../controladores/planificacion.php?op=traergrados', function (data) {
    data = JSON.parse(data);
    let grado = '';
    if (data.length != 0) {
      data.forEach(function (indice) {
        grado += '<option value="' + indice.id + '">' + indice.grado + ' º</option>';
      });
    }
    else {
      grado = '<option value="">Debe Ingresar grados en configuración</option>';
    }
    $('#grado').html('<option value="">Seleccione</option>');
    $('#grado').append(grado);
    $('#grado').selectpicker('refresh');
  });
}

function traerSecciones(idgrado, idplanificacion, idPeriodoEscolar) {
  $.post('../controladores/planificacion.php?op=traersecciones', { idgrado: idgrado, idplanificacion: idplanificacion, idperiodo_escolar: idPeriodoEscolar }, function (data) {

    data = JSON.parse(data);
    let seccion = '';
    if (data.length != 0) {
      data.forEach(function (indice, valor) {
        seccion += '<option value="' + indice.id + '">' + indice.seccion + '</option>';
      });
    }
    else {
      seccion = '<option value="">Debe Ingresar secciones en configuración</option>';
    }
    $('#seccion').html('<option value="">Seleccione</option>');
    $('#seccion').append(seccion);
    $('#seccion').selectpicker('refresh');
  });
}

function traerAmbientes(idambiente = null, idPeriodoEscolar) {
  $.post('../controladores/planificacion.php?op=traerambientes', { idambiente: idambiente, idperiodo_escolar: idPeriodoEscolar }, function (data) {
    data = JSON.parse(data);
    let ambiente = '';
    if (data.length != 0) {
      data.forEach(function (indice, valor) {
        ambiente += '<option value="' + indice.id + '" capacidad="' + indice.capacidad + '">' + indice.ambiente + '</option>';
      });
    }
    else {
      ambiente = '<option value="">Debe ingresar ambientes en configuración</option>';
    }
    $('#ambiente').html('<option value="">Seleccione</option>');
    $('#ambiente').append(ambiente);
    $('#ambiente').selectpicker('refresh');
  });
}

function traerDocentes(iddocente = null, idPeriodoEscolar) {
  $.post('../controladores/planificacion.php?op=traerdocentes', { iddocente: iddocente, idperiodo_escolar: idPeriodoEscolar }, function (data) {

    data = JSON.parse(data);
    let docente = '';
    if (data.length != 0) {
      data.forEach(function (indice, valor) {
        docente += '<option value="' + indice.id + '">' + indice.p_nombre + ' ' + indice.p_apellido + '</option>';
      });
    }
    else {
      docente = '<option value="">Debe Ingresar docentes en configuración</option>';
    }
    $('#docente').html('<option value="">Seleccione</option>');
    $('#docente').append(docente);
    $('#docente').selectpicker('refresh');
  });
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
  var formData = new FormData($([formularioPlanificacion])[0]); //Se obtienen los datos del formulario

  $.ajax({
    url: '../controladores/planificacion.php?op=guardaryeditar', //Dirección a donde se envían los datos
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
          title: 'Planificación registrada exitosamente :)'
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
          title: 'Planificación modificada exitosamente :)'
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

      limpiar();
      tabla.ajax.reload();//Recarga la tabla con el listado sin refrescar la página
      traerAmbientes();
      traerDocentes();
      $('#planificacionModal').modal('hide');
      idgrado = $('#grado')[0].value;
      if (idgrado != '') {
        $('#seccion').prop('disabled', false);
        traerSecciones(idgrado);
      }
      else {
        $('#seccion').html('<option value="">Seleccione</option>');
        $('#seccion').prop('disabled', true);
        $('#seccion').selectpicker('refresh');
      }
    }

  });
}

function guardaryEditarProyectoAprendizaje(event) {
  event.preventDefault(); //Evita que se envíe el formulario automaticamente
  // 
  $('#btnGuardarProyectoAprendizaje').prop('disabled', true);
  $('#btnEditarProyectoAprendizaje').prop('disabled', true);
  var formData = new FormData($([formularioProyectoAprendizaje])[0]); //Se obtienen los datos del formulario

  $.ajax({
    url: '../controladores/gestionar-indicador.php?op=guardaryeditarproyectoaprendizaje', //Dirección a donde se envían los datos
    type: 'POST', //Método por el cual se envían los datos
    data: formData, //Datos
    contentType: false, //Este parámetro es para mandar datos al servidor por el encabezado
    processData: false, //Evita que jquery transforme la data en un string
    success: function (datos) {
      // console.log(datos);
      // return;
      $('#btnGuardarProyectoAprendizaje').prop('disabled', false);
      $('#btnEditarProyectoAprendizaje').prop('disabled', false);
      if (datos == 'true') {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });

        Toast.fire({
          type: 'success',
          title: 'Proyecto registrado exitosamente :)'
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
          title: 'Proyecto modificado exitosamente :)'
        });

        $('#proyectoAprendizajeModal').modal('hide');
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

      limpiarProyectoAprendizaje();
      tablaProyectoAprendizaje.ajax.reload();//Recarga la tabla con el listado sin refrescar la página
    }

  });
}

//Función para listar los registros
function listar(idperiodo = null) {
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
    dom: 'lfrtip',
    "destroy": true, //Elimina cualquier elemente que se encuentre en la tabla
    "ajax": {
      url: '../controladores/planificacion.php?op=listar&idperiodo=' + idperiodo,
      type: 'GET',
      dataType: 'json'
    },
    'order': [[1, 'asc']]
  });
}

//Función para listar los proyectos de aprendizaje
function listarProyectoAprendizaje(idplanificacion = null) {
  tablaProyectoAprendizaje = $('#tblistadoproyectoaprendizaje').DataTable({
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
    dom: 'lfrtip',
    "destroy": true, //Elimina cualquier elemente que se encuentre en la tabla
    "ajax": {
      url: '../controladores/gestionar-indicador.php?op=listarproyectoaprendizaje&idplanificacion=' + idplanificacion,
      type: 'GET',
      dataType: 'json',
      error: (e) => {
        console.log(e.responseText);
        
      }
    },
    'order': [[1, 'asc']]
  });
}

//Función para mostrar un registro para editar
function mostrar(idplanificacion) {
  $('#tituloModal').html('Modificar planificación');
  $.post('../controladores/planificacion.php?op=mostrar', { idplanificacion: idplanificacion }, function (planificacion) {
    planificacion = JSON.parse(planificacion);

    $('#periodo_escolar').html('<option value="' + planificacion.idperiodo_escolar + '">' + planificacion.periodo + '</option>');
    $('#periodo_escolar').prop('readonly', true);
    $('#periodo_escolar').selectpicker('refresh');

    $.post('../controladores/planificacion.php?op=traergrados', function (grados) {
      grados = JSON.parse(grados);
      let grado = '';
      if (grados.length != 0) {
        grados.forEach(function (indice, valor) {
          grado += '<option value="' + indice.id + '">' + indice.grado + ' º</option>';
        });
      }
      else {
        grado = '<option value="">Debe Ingresar grados en configuración</option>';
      }
      $('#grado').html('<option value="">Seleccione</option>');
      $('#grado').append(grado);
      $('#grado').selectpicker('refresh');
    }).then(function () {
      $('#grado').selectpicker('val', planificacion.idgrado);
    });

    $.post('../controladores/planificacion.php?op=traersecciones', { idgrado: planificacion.idgrado, idplanificacion: planificacion.id, idperiodo_escolar: planificacion.idperiodo_escolar }, function (data) {
      data = JSON.parse(data);
      let seccion = '';
      if (data.length != 0) {
        data.forEach(function (indice, valor) {
          seccion += '<option value="' + indice.id + '">' + indice.seccion + '</option>';
        });
      }
      else {
        seccion = '<option value="">Debe Ingresar secciones en configuración</option>';
      }
      $('#seccion').prop('disabled', false);
      $('#seccion').html('<option value="">Seleccione</option>');
      $('#seccion').append(seccion);
      $('#seccion').selectpicker('refresh');
    })
      .then(() => {
        $('#seccion').selectpicker('val', planificacion.idseccion);
      });

    $.post('../controladores/planificacion.php?op=traerambientes', { idambiente: planificacion.idambiente, idperiodo_escolar: planificacion.idperiodo_escolar }, function (data) {
      data = JSON.parse(data);
      let ambiente = '';
      if (data.length != 0) {
        data.forEach(function (indice, valor) {
          ambiente += '<option value="' + indice.id + '" capacidad="' + indice.capacidad + '">' + indice.ambiente + '</option>';
        });
      }
      else {
        ambiente = '<option value="">Debe ingresar ambientes en configuración</option>';
      }
      $('#ambiente').html('<option value="">Seleccione</option>');
      $('#ambiente').append(ambiente);
      $('#ambiente').selectpicker('refresh');
    }).then(() => {
      $('#ambiente').selectpicker('val', planificacion.idambiente);
    });

    $.post('../controladores/planificacion.php?op=traerdocentes', { iddocente: planificacion.iddocente, idperiodo_escolar: planificacion.idperiodo_escolar }, function (data) {
      data = JSON.parse(data);
      let docente = '';
      if (data.length != 0) {
        data.forEach(function (indice, valor) {
          docente += '<option value="' + indice.id + '">' + indice.p_nombre + ' ' + indice.p_apellido + '</option>';
        });
      }
      else {
        docente = '<option value="">Debe Ingresar docentes en configuración</option>';
      }
      $('#docente').html('<option value="">Seleccione</option>');
      $('#docente').append(docente);
      $('#docente').selectpicker('refresh');
    }).then(() => {
      $('#docente').selectpicker('val', planificacion.iddocente);
    });

    $('#cupo').val(planificacion.cupo);
    $('#idplanificacion').val(planificacion.id);
  });
}

function mostrarProyectoAprendizaje(idproyectoaprendizaje) {    
  $.post('../controladores/gestionar-indicador.php?op=mostrarproyectoaprendizaje', { idproyectoaprendizaje: idproyectoaprendizaje }, function (proyecto) {
    proyecto = JSON.parse(proyecto);

    $('#editar_planificacion').html('<option value="' + proyecto.idplanificacion + '">' + proyecto.planificacion + '</option>');
    $('#periodo_escolar').prop('readonly', true);
    $('#periodo_escolar').selectpicker('refresh');

    $.post('../controladores/planificacion.php?op=traergrados', function (grados) {
      grados = JSON.parse(grados);
      let grado = '';
      if (grados.length != 0) {
        grados.forEach(function (indice, valor) {
          grado += '<option value="' + indice.id + '">' + indice.grado + ' º</option>';
        });
      }
      else {
        grado = '<option value="">Debe Ingresar grados en configuración</option>';
      }
      $('#grado').html('<option value="">Seleccione</option>');
      $('#grado').append(grado);
      $('#grado').selectpicker('refresh');
    }).then(function () {
      $('#grado').selectpicker('val', planificacion.idgrado);
    });

    $.post('../controladores/planificacion.php?op=traersecciones', { idgrado: planificacion.idgrado, idplanificacion: planificacion.id, idperiodo_escolar: planificacion.idperiodo_escolar }, function (data) {
      data = JSON.parse(data);
      let seccion = '';
      if (data.length != 0) {
        data.forEach(function (indice, valor) {
          seccion += '<option value="' + indice.id + '">' + indice.seccion + '</option>';
        });
      }
      else {
        seccion = '<option value="">Debe Ingresar secciones en configuración</option>';
      }
      $('#seccion').prop('disabled', false);
      $('#seccion').html('<option value="">Seleccione</option>');
      $('#seccion').append(seccion);
      $('#seccion').selectpicker('refresh');
    })
      .then(() => {
        $('#seccion').selectpicker('val', planificacion.idseccion);
      });

    $.post('../controladores/planificacion.php?op=traerambientes', { idambiente: planificacion.idambiente, idperiodo_escolar: planificacion.idperiodo_escolar }, function (data) {
      data = JSON.parse(data);
      let ambiente = '';
      if (data.length != 0) {
        data.forEach(function (indice, valor) {
          ambiente += '<option value="' + indice.id + '" capacidad="' + indice.capacidad + '">' + indice.ambiente + '</option>';
        });
      }
      else {
        ambiente = '<option value="">Debe ingresar ambientes en configuración</option>';
      }
      $('#ambiente').html('<option value="">Seleccione</option>');
      $('#ambiente').append(ambiente);
      $('#ambiente').selectpicker('refresh');
    }).then(() => {
      $('#ambiente').selectpicker('val', planificacion.idambiente);
    });

    $.post('../controladores/planificacion.php?op=traerdocentes', { iddocente: planificacion.iddocente, idperiodo_escolar: planificacion.idperiodo_escolar }, function (data) {
      data = JSON.parse(data);
      let docente = '';
      if (data.length != 0) {
        data.forEach(function (indice, valor) {
          docente += '<option value="' + indice.id + '">' + indice.p_nombre + ' ' + indice.p_apellido + '</option>';
        });
      }
      else {
        docente = '<option value="">Debe Ingresar docentes en configuración</option>';
      }
      $('#docente').html('<option value="">Seleccione</option>');
      $('#docente').append(docente);
      $('#docente').selectpicker('refresh');
    }).then(() => {
      $('#docente').selectpicker('val', planificacion.iddocente);
    });

    $('#cupo').val(planificacion.cupo);
    $('#idplanificacion').val(planificacion.id);
  });
}

//Función para eliminar una planificación
function eliminar(idplanificacion) {

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-primary  mx-1 p-2',
      cancelButton: 'btn btn-danger  mx-1 p-2'
    },
    buttonsStyling: false
  })

  swalWithBootstrapButtons.fire({
    title: '¿Estas seguro?',
    text: "¿Quieres eliminar esta planificación?",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Eliminar',
    cancelButtonText: 'Cancelar',
    reverseButtons: true
  }).then((result) => {
    if (result.value) {
      $.post('../controladores/planificacion.php?op=eliminar', { idplanificacion: idplanificacion }, function (e) {

        if (e == 'true') {
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

          Toast.fire({
            type: 'success',
            title: 'La planificación ha sido eliminada :)'
          });
        }
        else if (e == 'inscritos') {
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

          Toast.fire({
            type: 'error',
            title: 'Hay estudiantes inscritos en ésta planificación y no se puede eliminar'
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
            title: 'Ups! No se pudo eliminar la planificación'
          });
        }
        tabla.ajax.reload();
      });
    }
  });
}

//Función para limpiar el formulario
function limpiar() {
  // $('#periodo_escolar').val('');
  $('#periodo_escolar').selectpicker('refresh');
  $('#seccion').val('');
  $('#seccion').prop('disabled', true);
  $('#seccion').selectpicker('refresh');
  $('#cupo').val('');
  $('#idplanificacion').val('');
  $('#formularioregistros').removeClass('was-validated');
}

//Función para limpiar el formulario proyecto de aprendizaje
function limpiarProyectoAprendizaje() {
  $([formularioProyectoAprendizaje])[0].reset();
  $('#planificacion').selectpicker('refresh');
  $('#lapso').prop('disabled', true);
  $('#lapso').selectpicker('refresh');
  $('#formularioProyectoAprendizaje').removeClass('was-validated');
}


