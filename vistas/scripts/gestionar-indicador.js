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
      planificacion = '<option value="">No hay planificaciones</option>';
    }
    $('#planificaciones').html('<option value="">Seleccione</option>');
    $('#planificaciones').append(planificacion);
    $('#planificaciones').selectpicker('refresh');
  });

  let lapsos = traerLapsosGeneral();
  lapsos
  .then((data) => {
    data = JSON.parse(data);
    let lapso = '';
    $('#lapsos').prop('disabled', false);
    if (data.length != 0) {
      data.forEach(function (indice) {
        lapso += '<option value="' + indice.lapso + '">' + indice.lapso + 'º Lapso' + '</option>';
      });

      $('#lapsos').html('<option value="">Seleccione</option>');
      $('#lapsos').append(lapso);
      $('#lapsos').selectpicker('refresh');
    }
    else {
      lapso = '<option value="">No hay lapsos</option>';
      $('#lapsos').html(lapso);
      $('#lapsos').selectpicker('refresh');
    }
  });

  //Se ejecuta cuando se envia el formulario
  $([formularioGestionarIndicador]).on('submit', function (event) {
    if ($([formularioGestionarIndicador])[0].checkValidity()) {
      guardaryeditar(event);
    }
    else {
      scrollTo(0, 100);
    }
  });

  //Se ejecuta cuando se envia el formulario de proyecto de aprendizaje
  $([formularioProyectoAprendizaje]).on('submit', function (event) {
    if ($([formularioProyectoAprendizaje])[0].checkValidity()) {
      guardarProyectoAprendizaje(event);
    }
    else {
      scrollTo(0, 100);
    }
  });

  //Se ejecuta cuando se envia el formulario de editar proyecto de aprendizaje
  $([formularioEditarProyectoAprendizaje]).on('submit', function (event) {
    if ($([formularioEditarProyectoAprendizaje])[0].checkValidity()) {
      editarProyectoAprendizaje(event);
    }
    else {
      scrollTo(0, 100);
    }
  });

  $('#btnAgregar').on('click', function () {
    $('#tituloModalIndicador').html('Crear indicador para proyecto: ');

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
      $('#planificacion_indicador').html('<option value="">Seleccione</option>');
      $('#planificacion_indicador').append(planificacion);
      $('#planificacion_indicador').selectpicker('refresh');
    });

    let lapsos = traerLapsos();
    lapsos
    .then((data) => {
      data = JSON.parse(data);

      let lapso = '';
      $('#lapso_indicador').prop('disabled', false);
      if (data.length != 0) {
        data.forEach(function (indice) {
          lapso += '<option value="' + indice.lapso + '">' + indice.lapso + 'º Lapso' + '</option>';
        });

        $('#lapso_indicador').html('<option value="">Seleccione</option>');
        $('#lapso_indicador').append(lapso);
        $('#lapso_indicador').selectpicker('refresh');
      }
      else {
        lapso = '<option value="">No hay lapsos</option>';
        $('#lapso_indicador').html(lapso);
        $('#lapso_indicador').selectpicker('refresh');
      }
    });

    let materias = traerMaterias();
    materias
    .then((data) => {
      data = JSON.parse(data);

      let materia = '';
      if (data.length != 0) {
        data.forEach(function (indice) {
          materia += '<option value="' + indice.id + '">' + indice.materia + '</option>';
        });

        $('#materia_indicador').html('<option value="">Seleccione</option>');
        $('#materia_indicador').append(materia);
        $('#materia_indicador').selectpicker('refresh');
      }
      else {
        materia = '<option value="">No hay materias</option>';
        $('#materia_indicador').html(materia);
        $('#materia_indicador').selectpicker('refresh');
      }
    });
  });

  $('#btnAgregarProyectoAprendizaje').on('click', function () {
    let planificaciones = traerPlanificaciones();
    planificaciones
    .then((data) => {
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

    listarProyectoAprendizaje();
  });

  //Comprueba cada cambio en el select de planificacion proyecto aprendizaje
  $('#planificacion').on('change', function () {
    let idplanificacion = $('#planificacion')[0].value;   
    if (idplanificacion != '') {
      let lapsos = traerLapsos(idplanificacion);
      lapsos
      .then((data) => {
        data = JSON.parse(data);
        
        let lapso = '';
        $('#lapso').prop('disabled', false);
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
    else {
      $('#lapso').html('<option value="">Seleccione</option>');
      $('#lapso').prop('disabled', true);
      $('#lapso').selectpicker('refresh');
    }
    
    listarProyectoAprendizaje(idplanificacion);
  });

  //Comprueba cada cambio en el select de planificaciones
  $('#planificaciones').on('change', function () {
    listar();
  });

  //Comprueba cada cambio en el select de lapsos
  $('#lapsos').on('change', function () {
    listar();
  });

  //Comprueba cada cambio en el select de planificacion indicador
  $('#planificacion_indicador').on('change', function () {
    $('#lapso_indicador').val('');
    $('#lapso_indicador').selectpicker('refresh');
    comprobarProyectoAprendizaje();
  });

  //Comprueba cada cambio en el select de lapso indicador
  $('#lapso_indicador').on('change', function () {
    comprobarProyectoAprendizaje();
  });

  tabla.ajax.reload();
})();

function comprobarProyectoAprendizaje() {  
  let idplanificacion_indicador = $('#planificacion_indicador')[0].value;
  let lapso_indicador = $('#lapso_indicador')[0].value;

  if (idplanificacion_indicador && lapso_indicador != '') {

    $.post('../controladores/gestionar-indicador.php?op=comprobarproyectoaprendizaje', { idplanificacion_indicador: idplanificacion_indicador, lapso_indicador: lapso_indicador}, function (data) {
      // console.log(data);
      // return;
      if (data != '') {
        let proyectoMayuscula = data.charAt(0).toUpperCase() + data.slice(1);
        $('#tituloModalIndicador').html('Crear indicador para proyecto: ' + proyectoMayuscula);
      }
      else {
        $('#tituloModalIndicador').html('Crear indicador para proyecto: ');
        $('#lapso_indicador').val('');
        $('#lapso_indicador').selectpicker('refresh');

        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });

        Toast.fire({
          type: 'error',
          title: 'Primero debe crear un proyecto de aprendizaje'
        });
      }

    });
  }
  else {
    $('#tituloModalIndicador').html('Crear indicador para proyecto: ');
  }
}

function traerPlanificaciones() {  

  let planificaciones = $.post('../controladores/gestionar-indicador.php?op=traerplanificaciones');

  return planificaciones;
}

function traerMaterias() {

  let materias = $.post('../controladores/gestionar-indicador.php?op=traermaterias');
  return materias;
}

function traerLapsos(idplanificacion = null) {
  let lapsos = $.post('../controladores/gestionar-indicador.php?op=traerlapsos', { idplanificacion: idplanificacion });

  return lapsos;
}

function traerLapsosGeneral() {
  let lapsos = $.post('../controladores/gestionar-indicador.php?op=traerlapsosgeneral');
  return lapsos;
}

//Función cancelarform
function cancelarform() {
  limpiar();
}

//Función cancelarProyectoAprendizaje 
function cancelarProyectoAprendizaje() {
  limpiarProyectoAprendizaje();
}

//Función cancelarEditarProyectoAprendizaje
function cancelarEditarProyectoAprendizaje() {
  limpiarEditarProyectoAprendizaje();
}

//Función para guardar y editar 
function guardaryeditar(event) {
  event.preventDefault(); //Evita que se envíe el formulario automaticamente
  // 
  $('#btnGuardar').prop('disabled', true);
  var formData = new FormData($([formularioGestionarIndicador])[0]); //Se obtienen los datos del formulario

  $.ajax({
    url: '../controladores/gestionar-indicador.php?op=guardaryeditar', //Dirección a donde se envían los datos
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
          title: 'Indicador registrado exitosamente :)'
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
          title: 'Indicador modificado exitosamente :)'
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
    }

  });
}

function guardarProyectoAprendizaje(event) {
  event.preventDefault(); //Evita que se envíe el formulario automaticamente
  // 
  $('#btnGuardarProyectoAprendizaje').prop('disabled', true);
  var formData = new FormData($([formularioProyectoAprendizaje])[0]); //Se obtienen los datos del formulario

  $.ajax({
    url: '../controladores/gestionar-indicador.php?op=guardaryeditarproyectoaprendizaje', //Dirección a donde se envían los datos
    type: 'POST', //Método por el cual se envían los datos
    data: formData, //Datos
    contentType: false, //Este parámetro es para mandar datos al servidor por el encabezado
    processData: false, //Evita que jquery transforme la data en un string
    success: function (datos) {
      $('#btnGuardarProyectoAprendizaje').prop('disabled', false);
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

function editarProyectoAprendizaje(event) {
  event.preventDefault(); //Evita que se envíe el formulario automaticamente
  // 
  $('#btnEditarProyectoAprendizaje').prop('disabled', true);
  var formData = new FormData($([formularioEditarProyectoAprendizaje])[0]); //Se obtienen los datos del formulario

  $.ajax({
    url: '../controladores/gestionar-indicador.php?op=guardaryeditarproyectoaprendizaje', //Dirección a donde se envían los datos
    type: 'POST', //Método por el cual se envían los datos
    data: formData, //Datos
    contentType: false, //Este parámetro es para mandar datos al servidor por el encabezado
    processData: false, //Evita que jquery transforme la data en un string
    success: function (datos) {
      $('#btnEditarProyectoAprendizaje').prop('disabled', false);
      if (datos == 'update') {
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

        $('#editarProyectoAprendizajeModal').modal('hide');
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
          title: 'Ocurrió un error y no se pudo editar :('
        });
      }

      limpiarEditarProyectoAprendizaje();
      tablaProyectoAprendizaje.ajax.reload();//Recarga la tabla con el listado sin refrescar la página
    }

  });
}

//Función para listar los registros
function listar() {
  let idplanificaciones = $('#planificaciones')[0].value;
  let lapsos = $('#lapsos')[0].value;
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
      url: '../controladores/gestionar-indicador.php?op=listar&idplanificaciones=' + idplanificaciones + '&lapsos=' +lapsos,
      type: 'GET',
      dataType: 'json'
    },
    'order': [[1, 'asc'], [2, 'asc']]
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
      dataType: 'json'
    },
    'order': [[1, 'asc']]
  });
}

//Función para mostrar un registro para editar
function mostrar(idindicador) {
  $('#tituloModal').html('Modificar indicador');
  $.post('../controladores/gestionar-indicador.php?op=mostrar', { idindicador: idindicador }, function (indicador) {

    indicador = JSON.parse(indicador);
    $('#planificacion_indicador').html('<option value="' + indicador.idplanificacion + '">' + indicador.grado + 'º - "' + indicador.seccion + '" - ' + indicador.p_nombre + ' ' + indicador.p_apellido + '</option>');
    $('#planificacion_indicador').prop('disabled', true);
    $('#planificacion_indicador').selectpicker('refresh');

    $('#lapso_indicador').html('<option value="' + indicador.lapso_academico + '">' + indicador.lapso_academico + '</option>');
    $('#lapso_indicador').prop('readonly', true);
    $('#lapso_indicador').selectpicker('refresh');

    $('#materia_indicador').html('<option value="' + indicador.idmateria + '">' + indicador.materia + '</option>');
    $('#materia_indicador').prop('disabled', true);
    $('#materia_indicador').selectpicker('refresh');

    $('#indicador').val(indicador.indicador);
    $('#idindicador').val(indicador.id);
 
  });
}

function mostrarProyectoAprendizaje(idproyecto_aprendizaje) {    
  $.post('../controladores/gestionar-indicador.php?op=mostrarproyectoaprendizaje', { idproyecto_aprendizaje: idproyecto_aprendizaje }, function (proyecto) {
    proyecto = JSON.parse(proyecto);
    $('#editar_planificacion').html('<option value="' + proyecto.idplanificacion + '">' + proyecto.grado + 'º - "'+ proyecto.seccion +'" - '+ proyecto.p_nombre+ ' ' + proyecto.p_apellido+ '</option>');
    $('#editar_planificacion').prop('disabled', true);
    $('#editar_planificacion').selectpicker('refresh');

    $('#editar_lapso').html('<option value="' + proyecto.lapso_academico + '">' + proyecto.lapso_academico + '</option>');
    $('#editar_lapso').prop('readonly', true);
    $('#editar_lapso').selectpicker('refresh');

    $('#editar_proyecto_aprendizaje').val(proyecto.proyecto_aprendizaje);
    $('#idproyecto_aprendizaje').val(proyecto.id);
  });
}

//Función para eliminar un indicador
function eliminar(idindicador) {

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-primary  mx-1 p-2',
      cancelButton: 'btn btn-danger  mx-1 p-2'
    },
    buttonsStyling: false
  })

  swalWithBootstrapButtons.fire({
    title: '¿Estas seguro?',
    text: "¿Quieres eliminar este indicador?",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Eliminar',
    cancelButtonText: 'Cancelar',
    reverseButtons: true
  }).then((result) => {
    if (result.value) {
      $.post('../controladores/gestionar-indicador.php?op=eliminar', { idindicador: idindicador }, function (e) {

        if (e == 'true') {
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

          Toast.fire({
            type: 'success',
            title: 'El indicador ha sido eliminado :)'
          });
        }
        // else if (e == 'inscritos') {
        //   const Toast = Swal.mixin({
        //     toast: true,
        //     position: 'top-end',
        //     showConfirmButton: false,
        //     timer: 3000
        //   });

        //   Toast.fire({
        //     type: 'error',
        //     title: 'Hay estudiantes inscritos en ésta planificación y no se puede eliminar'
        //   });
        // }
        else {
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

          Toast.fire({
            type: 'error',
            title: 'Ups! No se pudo eliminar el indicador'
          });
        }
        tabla.ajax.reload();
      });
    }
  });
}

//Función para limpiar el formulario
function limpiar() {
  $([formularioGestionarIndicador])[0].reset();
  $('#planificacion_indicador').selectpicker('refresh');
  $('#lapso_indicador').selectpicker('refresh');
  $('#materia_indicador').selectpicker('refresh');
  $('#idindicador').val('');
  $('#formularioGestionarIndicador').removeClass('was-validated');
}

//Función para limpiar el formulario proyecto de aprendizaje
function limpiarProyectoAprendizaje() {
  $([formularioProyectoAprendizaje])[0].reset();
  $('#planificacion').selectpicker('refresh');
  $('#lapso').prop('disabled', true);
  $('#lapso').selectpicker('refresh');
  $('#formularioProyectoAprendizaje').removeClass('was-validated');
}

//Función para limpiar el formulario proyecto de aprendizaje
function limpiarEditarProyectoAprendizaje() {
  $([formularioEditarProyectoAprendizaje])[0].reset();
  $('#editar_planificacion').selectpicker('refresh');
  $('#editar_lapso').selectpicker('refresh');
  $('#idproyecto_aprendizaje').val('');
  $('#formularioProyectoAprendizaje').removeClass('was-validated');
}


