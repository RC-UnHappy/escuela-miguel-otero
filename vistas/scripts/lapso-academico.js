//Funcion que se ejecutará al inicio

function init() {

  //Muestra la lista de períodos escolares
  listar();

  //Se ejecuta cuando se envia el formulario
  $([formularioLapso]).on('submit', function (event) {
    if ($([formularioLapso])[0].checkValidity()) {
      guardaryeditar(event);
    }
    else {
      scrollTo(0, 100);
    }
  });

  $('#btnAgregar').on('click', function () {
    $('#tituloModal').html('Crear lapso académico');
    $('#estatus').html('<option value="">Seleccione</option>');
    $('#estatus').append('<option value="Planificado">Planificado</option>');
    $('#estatus').selectpicker('refresh');
    traerPeriodoActivo();
    traerLapsos();
  });

  $('#fecha_inicio').on('blur', function () {
    verificarFechaInicio(this);
  });

  $('#fecha_fin').on('blur', function () {
    verificarFechaFin(this);
  });

  tabla.ajax.reload();
}

/**
 * Trae el período escolar activo 
 */
function traerPeriodoActivo() {
  $.post('../controladores/lapso-academico.php?op=traerperiodoactivo')
    .then(function (periodo) {

      periodo = JSON.parse(periodo);
      datos = '';
      if (periodo != null) {
        datos = '<option value="' + periodo.id + '" periodo="'+periodo.periodo+'">' + periodo.periodo + '</option>';
      }
      else {
        datos = '<option value="">Debe activar un período escolar</option>';
      }
      $('#periodo_escolar').html(datos);
      $('#periodo_escolar').selectpicker('refresh');
    });
}

/**
 * Verifica que la fecha de inicio del período escolar y la fecha de inicio sean iguales
 * @param {} fecha
 */
function verificarFechaInicio(fecha) {

  // Cuando recibe la fecha de inicio del lapso académico
  if (fecha.value != '') {

    let periodo_escolar = $('option:selected', $('#periodo_escolar')).attr('periodo');
    let periodoEscolarArreglo = periodo_escolar.split('-');
    let inicioPeriodo = Number(periodoEscolarArreglo[0]);
    let finPeriodo = Number(periodoEscolarArreglo[1]);
    let fechaInicio = fecha.value.split('-');
    fechaInicio = Number(fechaInicio[0]);
    
    
    if (fechaInicio < inicioPeriodo || fechaInicio > finPeriodo) {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
      
      Toast.fire({
        type: 'error',
        title: 'La fecha del período escolar y la del lapso deben coincidir'
      });
      $('#fecha_inicio').val('');
    }
    else {
      let lapso_academico = $('#lapso_academico')[0].value;
      if (lapso_academico != '') {
        $.post('../controladores/lapso-academico.php?op=verificarfechainicio', {fecha_inicio: fecha.value, lapso_academico: lapso_academico, periodo_escolar: periodo_escolar}, function (data) {

          if (data == 'false') {
            const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000
            });
  
            Toast.fire({
              type: 'error',
              title: 'La fecha de inicio de éste lapso choca con la fecha de fin del lapso anterior'
            });
  
            $('#fecha_inicio').val('');
          }
          else if (data == 'fecha_inicio_erronea') {
            const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000
            });

            Toast.fire({
              type: 'error',
              title: 'La fecha de inicio de este lapso no puede ser anterior a la fecha de inicio del período escolar'
            });

            $('#fecha_inicio').val('');
          }

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
          title: 'Primero seleccione un lapso'
        });
        $('#fecha_inicio').val('');
      }
    }
  }
  return;
}

function verificarFechaFin(fecha) {
  if (fecha.value != '') {
    
    let periodo_escolar = $('option:selected', $('#periodo_escolar')).attr('periodo');
    let periodoEscolarArreglo = periodo_escolar.split('-');
    let inicioPeriodo = Number(periodoEscolarArreglo[0]);
    let finPeriodo = Number(periodoEscolarArreglo[1]);
    let fechaInicio = fecha.value.split('-');
    fechaInicio = Number(fechaInicio[0]);
    
    if (fechaInicio < inicioPeriodo || fechaInicio > finPeriodo) {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
      
      Toast.fire({
        type: 'error',
        title: 'La fecha del período escolar y la del lapso deben coincidir'
      });
      $('#fecha_fin').val('');
    }
    else {
      let lapso_academico = $('#lapso_academico')[0].value;
      if (lapso_academico != '') {
        $.post('../controladores/lapso-academico.php?op=verificarfechafin', {fecha_fin: fecha.value, lapso_academico: lapso_academico, periodo_escolar: periodo_escolar}, function (data) {

          if (data == 'false') {
            const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000
            });
            
            Toast.fire({
              type: 'error',
              title: 'La fecha de fin de éste lapso choca con la fecha de inicio del lapso siguiente'
            });
  
            $('#fecha_fin').val('');
          }

          else if (data == 'fecha_fin_erronea') {
            const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000
            });

            Toast.fire({
              type: 'error',
              title: 'La fecha de fin de este lapso no puede ser mayor a la fecha de fin del período escolar'
            });

            $('#fecha_fin').val('');
          }
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
          title: 'Primero seleccione un lapso'
        });
        $('#fecha_fin').val('');
      }
    }
  }
  return;
}


//Trae los lapsos registrados en el maestro de lapso
function traerLapsos() {
  $.post('../controladores/lapso-academico.php?op=traerlapsos', function (data) {
    data = JSON.parse(data);
    let lapsos = '';
    if (data.length != 0) {
      data.forEach(function (indice) {
        lapsos += '<option value="' + indice.lapso + '">' + indice.lapso + 'º Lapso</option>';
      });
    }
    else {
      lapsos = '<option value="">Debe ingresar lapsos en configuración</option>';
    }
    $('#lapso_academico').html('<option value="">Seleccione</option>');
    $('#lapso_academico').append(lapsos);
    $('#lapso_academico').selectpicker('refresh');

  });
}

//Función para guardar y editar 
function guardaryeditar(event) {
  event.preventDefault(); //Evita que se envíe el formulario automaticamente
  // 
  $('#btnGuardar').prop('disabled', true);
  var formData = new FormData($([formularioLapso])[0]); //Se obtienen los datos del formulario

  $.ajax({
    url: '../controladores/lapso-academico.php?op=guardaryeditar', //Dirección a donde se envían los datos
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
          title: 'Lapso académico registrado exitosamente :)'
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
          title: 'Lapso académico actualizado exitosamente :)'
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
      limpiar();
      tabla.ajax.reload();//Recarga la tabla con el listado sin refrescar la página
      $('#lapsoModal').modal('hide');
    }
  });
}

//Función para listar los registros
function listar() {
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
      url: '../controladores/lapso-academico.php?op=listar',
      type: 'GET',
      dataType: 'json'
    },
    'order': [[1, 'asc']]
  });
}

//Función para mostrar un registro para editar
function mostrar(idlapsoacademico) {
  $.post('../controladores/lapso-academico.php?op=mostrar', { idlapsoacademico: idlapsoacademico }, function (data) {
    data = JSON.parse(data);
    $('#tituloModal').html('Modificar lapso académico');
    $('#periodo_escolar').html('<option value="' + data.id + '" periodo="'+data.periodo+'"  selected>' + data.periodo + '</option>');
    $('#periodo_escolar').selectpicker('refresh');
    $('#lapso_academico').html('<option value="' + data.lapso+ '" selected>' + data.lapso + '</option>');
    $('#lapso_academico').selectpicker('refresh');
    $('#fecha_inicio').val(data.fecha_inicio);
    $('#fecha_fin').val(data.fecha_fin);
    $('#estatus').html('<option value="' + data.estatus + '">' + data.estatus + '</option>');
    $('#estatus').selectpicker('refresh');
    $('#idlapsoacademico').val(data.id);
  });
}

//Función para activar el lapso académico
function activar(idlapsoacademico, lapso) {

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-primary  mx-1 p-2',
      cancelButton: 'btn btn-danger  mx-1 p-2'
    },
    buttonsStyling: false
  });

  swalWithBootstrapButtons.fire({
    title: '¿Estas seguro?',
    text: "¡Ésta acción activará un nuevo lapso!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Activar',
    cancelButtonText: 'Cancelar',
    reverseButtons: true
  }).then((result) => {
    if (result.value) {
      $.post('../controladores/lapso-academico.php?op=activar', { idlapsoacademico: idlapsoacademico, lapso_academico:lapso }, function (e) {
       
        if (e == 'true') {
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

          Toast.fire({
            type: 'success',
            title: 'Lapso activado :)'
          });
          tabla.ajax.reload();
        }
        else if (e == 'false'){
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

          Toast.fire({
            type: 'error',
            title: 'Ups! No se pudo activar el lapso'
          });
          tabla.ajax.reload();
        }

        else if (e == 'estudiantes_no_inscritos') {
          Swal.fire({
            type: 'warning',
            title: 'Advertencia',
            text: 'Hay estudiantes que no han sido reinscritos',
            showConfirmButton: false,
            allowOutsideClick: false,
            footer: '<a href="inscripcion/inscripcion.php">Ir al módulo de inscripción</a>'
          })
        }      
      });
    }
  });
}

//Función para finalizar el lapso académico
function finalizar(idlapsoacademico) {

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-primary  mx-1 p-2',
      cancelButton: 'btn btn-danger  mx-1 p-2'
    },
    buttonsStyling: false
  });

  swalWithBootstrapButtons.fire({
    title: '¿Estas seguro?',
    text: "¡Finalizar el lapso académico cerrará todos los indicadores de éste lapso!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Finalizar',
    cancelButtonText: 'Cancelar',
    reverseButtons: true
  }).then((result) => {
    if (result.value) {
      $.post('../controladores/lapso-academico.php?op=finalizar', { idlapsoacademico: idlapsoacademico }, function (e) {
        
        if (e == 'true') {
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

          Toast.fire({
            type: 'success',
            title: 'Lapso académico finalizado :)'
          });
          tabla.ajax.reload();
        }
        else if (e == 'false'){
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

          Toast.fire({
            type: 'error',
            title: 'Ups! No se pudo finalizar el lapso académico'
          });
          tabla.ajax.reload();
        }
        else {
          $('#estudiantesSinNotas').html(e);
          $('#noCompletaModal').modal('show');
        }
      });
    }
  });
}

//Función para limpiar el formulario
function limpiar() {
  $("#formularioregistros")[0].reset();
  $('#periodo_escolar').selectpicker('refresh');
  $('#lapso').selectpicker('refresh');
  $('#estatus').selectpicker('refresh');
  $('#idlapsoacademico').val('');
  $('#formularioregistros').removeClass('was-validated');
}

//Función cancelarform
function cancelarform() {
  limpiar();
}

init();


