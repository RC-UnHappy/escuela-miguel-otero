//Funcion que se ejecutará al inicio

function init() {

	//Muestra la lista de períodos escolares
	listar();

	//Se ejecuta cuando se envia el formulario
	$([formularioPeriodo]).on('submit', function (event) {
		if ($([formularioPeriodo])[0].checkValidity()) {
			guardaryeditar(event);
		}
		else {
			scrollTo(0,100);
		}
	});

	$('#btnAgregar').on('click', function () {
		periodo();
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
 * Verifica que la fecha de inicio del período escolar y la fecha de inicio sean iguales
 * @param {} fecha 
 */
function verificarFechaInicio(fecha) {
  if (fecha.value != '') {
    let periodoEscolar = $('#periodo')[0].value;

    let periodoEscolarArreglo = periodoEscolar.split('-');
    let inicioPeriodo = Number(periodoEscolarArreglo[0]);
    let fechaInicio = fecha.value.split('-');
    fechaInicio = Number(fechaInicio[0]);

    if (fechaInicio != inicioPeriodo) {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

      Toast.fire({
        type: 'error',
        title: 'El año del período escolar y la fecha de inicio deben ser iguales'
      });
      $('#fecha_inicio').val('');
    }
    else{
      $.post('../controladores/periodo-escolar.php?op=verificarfechainicio', { fecha_inicio: fecha.value, periodo: periodoEscolar }, function (data) {  
        if (data != 'true') {
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

          Toast.fire({
            type: 'error',
            title: 'La fecha de inicio de éste periodo choca con la fecha de fin del período anterior'
          });

          $('#fecha_inicio').val('');
        }        
      });
    }
  }
  return;
}

function verificarFechaFin(fecha) {
  if (fecha.value != '') {
    let periodoEscolar = $('#periodo')[0].value;
    let periodoEscolarArreglo = periodoEscolar.split('-');
    let finPeriodo = Number(periodoEscolarArreglo[1]);
    let fechaFin = fecha.value.split('-');
    fechaFin = Number(fechaFin[0]);
    
    if (fechaFin != finPeriodo) {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

      Toast.fire({
        type: 'error',
        title: 'El año del período escolar y la fecha de fin deben ser iguales'
      });
      $('#fecha_fin').val('');
    }
    else {
      $.post('../controladores/periodo-escolar.php?op=verificarfechafin', { fecha_fin: fecha.value, periodo: periodoEscolar }, function (data) {

        if (data != 'true') {
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

          Toast.fire({
            type: 'error',
            title: 'La fecha de fin de éste periodo choca con la fecha de inicio del período siguiente'
          });

          $('#fecha_fin').val('');
        }
      });
    }
  }
  return;
}

//Crea el siguiente periodo según el último registrado en la base de datos
function periodo() {
	$.post('../controladores/periodo-escolar.php?op=traerultimo', function (data) {
		let datos = JSON.parse(data);
		let nuevoPeriodo = '';

		if (datos != null) {
			let periodo = datos.periodo;
			periodo = periodo.split('-');
			let segundaFecha =  Number(periodo[1]) + 1;
			nuevoPeriodo = periodo[1]+'-'+segundaFecha;
			$('#periodo').html('<option value="'+nuevoPeriodo+'">'+nuevoPeriodo+'</option>');
			$('#periodo').selectpicker('refresh');
		}
		else {
			let fechaActual = new Date();
			fechaActual = fechaActual.getFullYear();
			nuevoPeriodo = fechaActual+'-'+Number(fechaActual+1);
			$('#periodo').html('<option value="'+nuevoPeriodo+'">'+nuevoPeriodo+'</option>');
			nuevoPeriodo = Number(fechaActual+1)+'-'+Number(fechaActual+2);
			$('#periodo').append('<option value="'+nuevoPeriodo+'">'+nuevoPeriodo+'</option>');
      $('#periodo').selectpicker('refresh');
		}

	});
}

//Función para guardar y editar 
function guardaryeditar(event) {
	event.preventDefault(); //Evita que se envíe el formulario automaticamente
  // 
  $('#btnGuardar').prop('disabled', true);
	var formData = new FormData($([formularioPeriodo])[0]); //Se obtienen los datos del formulario
	
	$.ajax({
		url: '../controladores/periodo-escolar.php?op=guardaryeditar', //Dirección a donde se envían los datos
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
				  title: 'Período escolar registrado exitosamente :)'
				});
      }
      else if(datos == 'update') {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });

        Toast.fire({
          type: 'success',
          title: 'Período escolar actualizado exitosamente :)'
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
			$('#periodoModal').modal('hide');
		}
	});		
}

//Función para listar los registros
function listar() {
	tabla = $('#tblistado').DataTable({
		"processing": true,
		pagingType: "first_last_numbers",
		language: {
			"info":           "Mostrando desde _START_ hasta _END_ de _TOTAL_ registros",
			"lengthMenu":     "Mostrar _MENU_ entradas",
			"loadingRecords": "Cargando...",
		    "processing":     "Procesando...",
		    "search":         "Buscar:",
			"emptyTable":     "No hay datos para mostrar",
			"infoEmpty":      "Mostrando 0 hasta 0 de 0 entradas",
			"paginate": {
	        "first":      "Primero",
	        "last":       "Último"
	    	},
		},
		dom: 'lfrtip', 
		"destroy": true, //Elimina cualquier elemente que se encuentre en la tabla
		"ajax": {
			url: '../controladores/periodo-escolar.php?op=listar',
			type: 'GET',
      dataType: 'json'	
    },
		'order': [[1, 'desc']]
	});
}

//Función para mostrar un registro para editar
function mostrar(idperiodo) {
  $.post('../controladores/periodo-escolar.php?op=mostrar', { idperiodo: idperiodo }, function (data) {
    data = JSON.parse(data);
    $('#periodo').html('<option value="' + data.periodo + '">' + data.periodo + '</option>');
    $('#periodo').selectpicker('refresh');
    $('#fecha_inicio').val(data.fecha_creacion);
    $('#fecha_fin').val(data.fecha_finalizacion);
    $('#estatus').html('<option value="' + data.estatus + '">' + data.estatus + '</option>');
    $('#estatus').selectpicker('refresh');
    $('#idperiodo').val(data.id);
  });
}

//Función para activar el período escolar
function activar(idperiodo) {

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-primary  mx-1 p-2',
      cancelButton: 'btn btn-danger  mx-1 p-2'
    },
    buttonsStyling: false
  });

  swalWithBootstrapButtons.fire({
    title: '¿Estas seguro?',
    text: "¡Ésta acción activará un nuevo período escolar!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Activar',
    cancelButtonText: 'Cancelar',
    reverseButtons: true
  }).then((result) => {
    if (result.value) {
      $.post('../controladores/periodo-escolar.php?op=activar', { idperiodo: idperiodo }, function (e) {

        if (e == 'true') {
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

          Toast.fire({
            type: 'success',
            title: 'Período escolar activado :)'
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
            title: 'Ups! No se pudo activar el periodo escolar'
          });
        }
        tabla.ajax.reload();
      });
    }
  });
}

//Función para finalizar el período escolar
function finalizar(idperiodo) {

		const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-primary  mx-1 p-2',
		    cancelButton: 'btn btn-danger  mx-1 p-2'
		  },
		  buttonsStyling: false
		});

		swalWithBootstrapButtons.fire({
		  title: '¿Estas seguro?',
		  text: "¡Finalizar el período escolar cerrará toda la planificación del año en curso!",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Finalizar',
		  cancelButtonText: 'Cancelar',
		  reverseButtons: true
		}).then((result) => {
		  if (result.value) {
		  	$.post('../controladores/periodo-escolar.php?op=finalizar', {idperiodo: idperiodo}, function (response) {

          response = JSON.parse(response);

  				if (response.code === 1 ) {

  					const Toast = Swal.mixin({
  					  toast: true,
  					  position: 'top-end',
  					  showConfirmButton: false,
  					  timer: 3000
  					});

  					Toast.fire({
  					  type: 'success',
  					  title: response.message
  					});

				    tabla.ajax.reload();

          }
          else if ( response.code === 2 ) {
            const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000
            });

            Toast.fire({
              type: 'error',
              title: response.message
            });
          }
  				else if ( response.code === 3){

  					$('#studentsWithoutFinalReport').html(response.message);
            $('#noFinalReport').modal('show');

  				}
			});  
		} 
	});
}

//Función para limpiar el formulario
function limpiar() {
  $("#formularioregistros")[0].reset();
  $('#fecha_inicio').val('');
  $('#fecha_fin').val('');
  $('#estatus').html('<option value="">Seleccione</option>');
  $('#estatus').append('<option value="Planificado">Planificado</option>');
  $('#estatus').selectpicker('refresh');
  $('#idperiodo').val('');
  $('#formularioregistros').removeClass('was-validated');
}

//Función cancelarform
function cancelarform() {
  limpiar();
}

init();


