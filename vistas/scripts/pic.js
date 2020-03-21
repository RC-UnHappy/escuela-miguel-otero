//Funcion que se ejecutará al inicio

function init() {

  //Muestra la lista de materias
  listar();

  //Se ejecuta cuando se envia el formulario
  $([formularioPic]).on('submit', function (event) {
    if ($([formularioPic])[0].checkValidity()) {
      guardaryeditar(event);
    }
    else {
      scrollTo(0, 100);
    }
  });

  $('#btnAgregar').on('click', function () {
    traerPeriodosSinProyecto();
    // limpiar();
  });

  tabla.ajax.reload();

}

function traerPeriodosSinProyecto() {

  $.post('../controladores/pic.php?op=consultarperiodo')
    .then(function (periodoActual) {
      $.post('../controladores/pic.php?op=traerperiodossinproyecto')
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

//Función cancelarform
function cancelarform() {
  limpiar();
}

//Función para guardar y editar 
function guardaryeditar(event) {
  event.preventDefault(); //Evita que se envíe el formulario automaticamente
  // 
  $('#btnGuardar').prop('disabled', true);
  var formData = new FormData($([formularioPic])[0]); //Se obtienen los datos del formulario

  $.ajax({
    url: '../controladores/pic.php?op=guardaryeditar', //Dirección a donde se envían los datos
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
          title: 'Pic registrado exitosamente :)'
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
          title: 'Pic modificado exitosamente :)'
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
      $('#picModal').modal('hide');
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
      url: '../controladores/pic.php?op=listar',
      type: 'GET',
      dataType: 'json'
    },
    'order': [[1, 'desc']]
  });
}

//Función para mostrar un registro para editar
function mostrar(idpic) {
  $.post('../controladores/pic.php?op=mostrar', { idpic: idpic }, function (data) {

    data = JSON.parse(data);

    $('#periodo_escolar').html('<option value="' + data.idperiodo_escolar + '"> ' + data.periodo + '</option >');
    $('#periodo_escolar').prop('readonly', true);
    $('#periodo_escolar').selectpicker('refresh');
    $('#pic').val(data.pic);
    $('#estatus').val(data.estatus);
    $('#estatus').selectpicker('refresh');
    $('#idpic').val(data.id);
  });
}

//Función para activar la materia
function activar(idpic) {

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-primary  mx-1 p-2',
      cancelButton: 'btn btn-danger  mx-1 p-2'
    },
    buttonsStyling: false
  })

  swalWithBootstrapButtons.fire({
    title: '¿Estas seguro?',
    text: "¿Quieres activar este PIC?",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Activar',
    cancelButtonText: 'Cancelar',
    reverseButtons: true
  }).then((result) => {
    if (result.value) {
      $.post('../controladores/pic.php?op=activar', { idpic: idpic }, function (e) {
        if (e == 'true') {
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

          Toast.fire({
            type: 'success',
            title: 'El PIC ha sido activado :)'
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
            title: 'Ups! No se pudo activar el PIC'
          });
        }
        tabla.ajax.reload();
      });
    }
  });

}

//Función para limpiar el formulario
function limpiar() {
  $('#periodo_escolar').val('');
  $('#periodo_escolar').removeClass('is-invalid');
  $('#periodo_escolar').selectpicker('refresh');
  $('#pic').val('');
  $('#pic').removeClass('is-invalid');
  $('#estatus').val('');
  $('#estatus').removeClass('is-invalid');
  $('#estatus').selectpicker('refresh');
  $('#idpic').val('');
  $('#formularioregistros').removeClass('was-validated');
}

init();