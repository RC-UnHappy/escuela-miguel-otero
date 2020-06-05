//Funcion que se ejecutará al inicio
(function () {
  //Muestra la lista de planificaciones
  listar();

  let fechaFundada = traerFechaCreacion();
    fechaFundada
    .then((data) => {
      
    let periodos = '';
    let fechaFundada = JSON.parse(data);
    let fechaActual = new Date();
    fechaActual = fechaActual.getFullYear();
    periodoActual = Number(fechaActual - 1) + '-' + fechaActual;

    if (fechaFundada != null) {

      let periodoEscolar = fechaFundada.split('-');
      periodoEscolar = periodoEscolar[0];
      periodoEscolar = periodoEscolar + '-' + (Number(periodoEscolar) + 1);

      let arregloPeriodos = [];

      while (periodoEscolar < periodoActual) {
        arregloPeriodos.push(periodoEscolar);
        periodoEscolar = periodoEscolar.split('-');
        let primeraFecha = Number(periodoEscolar[0]) + 1;
        let segundaFecha = Number(periodoEscolar[1]) + 1;
        periodoEscolar = primeraFecha + '-' + segundaFecha;
      }

      arregloPeriodos.reverse();

      arregloPeriodos.forEach((data) => {
        periodos += '<option value="' + data + '">' + data + '</option>';         
      });

    }
    else {
      periodos = '<option value="">Debe establecer el año de fundación de la escuela en configuración > institución</option>';
    }
    
    $('#periodo_escolar_general').html(periodos);
    $('#periodo_escolar_general').selectpicker('refresh');
  });

  //Se ejecuta cuando se envia el formulario
  $([formularioHistorialEstudiantil]).on('submit', function (event) {
    if ($([formularioHistorialEstudiantil])[0].checkValidity()) {
      event.preventDefault();
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-primary  mx-1 p-2',
          cancelButton: 'btn btn-danger  mx-1 p-2'
        },
        buttonsStyling: false
      })

      swalWithBootstrapButtons.fire({
        title: '¡Atención!',
        text: "Verifique la información, esta no podrá ser editada en un futuro",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Verificar',
        reverseButtons: true
      }).then((result) => {
        if (result.value) {
          guardaryeditar(event);
        } 
      });
    }
    else {
      scrollTo(0, 100);
    }
  });

  $('#btnAgregar').on('click', function () {

    let fechaFundada = traerFechaCreacion();
    fechaFundada
    .then((data) => {
      
      let periodos = '';
      let fechaFundada = JSON.parse(data);
      let fechaActual = new Date();
      fechaActual = fechaActual.getFullYear();
      periodoActual = Number(fechaActual - 1) + '-' + fechaActual;

      if (fechaFundada != null) {

        let periodoEscolar = fechaFundada.split('-');
        periodoEscolar = periodoEscolar[0];
        periodoEscolar = periodoEscolar + '-' + (Number(periodoEscolar) + 1);

        let arregloPeriodos = [];

        while (periodoEscolar < periodoActual) {
          arregloPeriodos.push(periodoEscolar);
          periodoEscolar = periodoEscolar.split('-');
          let primeraFecha = Number(periodoEscolar[0]) + 1;
          let segundaFecha = Number(periodoEscolar[1]) + 1;
          periodoEscolar = primeraFecha + '-' + segundaFecha;
        }

        arregloPeriodos.reverse();

        arregloPeriodos.forEach((data) => {
          periodos += '<option value="' + data + '">' + data + '</option>';         
        });

      }
      else {
        periodos = '<option value="">Debe establecer el año de fundación de la escuela en configuración > institución</option>';
      }
      
      $('#periodo_escolar').html(periodos);
      $('#periodo_escolar').selectpicker('refresh');
    });

    let turno = traerTurno();
    turno
    .then((data) => {
      
      let turno = JSON.parse(data);
      $('#turno').val(turno);
    });
  });

  //Comprueba cada cambio en el select de periodo_escolar_general
  $('#periodo_escolar_general').on('change', function () {
    let periodo_escolar_general = $('#periodo_escolar_general')[0].value;
    if (periodo_escolar_general != '') {
      listar(periodo_escolar_general);
    }
    else {
      listar();
    }
  });

  tabla.ajax.reload();
  
})();


//Consulta la fecha de creación de la escuela 
function traerFechaCreacion() {
  let fechaFundada = $.post('../controladores/historial-estudiantil.php?op=fecha_creacion_escuela');
 
  return fechaFundada;
}

//Consulta el turno de la escuela 
function traerTurno() {
  let turno = $.post('../controladores/historial-estudiantil.php?op=traer_turno');
 
  return turno;
}

//Función cancelarform
function cancelarform() {
  limpiar();
}

//Función para guardar y editar 
function guardaryeditar(event) {
  event.preventDefault(); //Evita que se envíe el formulario automaticamente
  // 
  var formData = new FormData($([formularioHistorialEstudiantil])[0]); //Se obtienen los datos del formulario

  var documento_estudiante = formData.get('documento_estudiante'); //Se obtiene el tipo de documento

  var cedula_estudiante = formData.get('cedula_estudiante');// Se obtiene la cédula 

  formData.set('cedula_estudiante', documento_estudiante + cedula_estudiante);//Se le asigna a la cédula del formData el tipo de documento

  var documento_docente = formData.get('documento_docente'); //Se obtiene el tipo de documento

  var cedula_docente = formData.get('cedula_docente');// Se obtiene la cédula 

  formData.set('cedula_docente', documento_docente + cedula_docente);//Se le asigna a la cédula del formData el tipo de documento

  $.ajax({
    url: '../controladores/historial-estudiantil.php?op=guardaryeditar', //Dirección a donde se envían los datos
    type: 'POST', //Método por el cual se envían los datos
    data: formData, //Datos
    contentType: false, //Este parámetro es para mandar datos al servidor por el encabezado
    processData: false, //Evita que jquery transforme la data en un string
    beforeSend: () => {
      $('#btnGuardar').prop('disabled', true);
      $('#btnGuardar').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Espere...<span class="sr-only"> Espere...</span>');
    },
    success: function (datos) {
      datos = JSON.parse(datos);
      
      if (datos.estatus === 1) {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });

        Toast.fire({
          type: 'success',
          title: datos.msj
        });
      }
      else if (datos.estatus === 3){
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });

        Toast.fire({
          type: 'error',
          title: datos.msj
        });
      }

    },
    complete: () => {
      limpiar();
      $('#btnGuardar').prop('disabled', false);
      $('#btnGuardar').html('Guardar');
      tabla.ajax.reload();//Recarga la tabla con el listado sin refrescar la página
    }

  });
}

//Función para listar los registros
function listar(periodo_escolar_general = null) {
  tabla = $('#tblistado').DataTable({
    // "processing": true,
    // "serverSide": true,
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
    "searching": true,
    "pageLength": 25,
    "deferRender": true,
    dom: 'lfrtip',
    "destroy": true, //Elimina cualquier elemente que se encuentre en la tabla
    "ajax": {
      url: '../controladores/historial-estudiantil.php?op=listar',
      type: 'POST',
      dataType: 'json',
      data: { periodo_escolar: periodo_escolar_general},
      error: (e) => {
        console.log(e.responseText);
      }
    },
    'order': []
  });
}

//Función para limpiar el formulario
function limpiar() {
  $([formularioHistorialEstudiantil])[0].reset();
  $('.selectpicker').selectpicker('refresh');
  $('#formularioHistorialEstudiantil').removeClass('was-validated');
  $('#icono_genero').removeClass('bg-primary');
  $('#icono_genero').removeClass('bg-danger');
  $('#icono_genero').addClass('bg-light');
}



