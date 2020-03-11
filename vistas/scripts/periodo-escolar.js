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

	verificar();

	$('#btnAgregar').on('click', function () {
		periodo();
	});

	tabla.ajax.reload();
			
}

//Verifica si hay un período escolar activo
function verificar() {
	$.post('../controladores/periodo-escolar.php?op=verificar', function (data) {
		if ( data == 'null') {
			$('#btnAgregar').show();
		}
		else {
			$('#btnAgregar').hide();
		}
	});
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
      $('#estatus').html('<option value="">Seleccione</option>');
      $('#estatus').append('<option value="ACTIVO">Activo</option>');
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

			$('#btnAgregar').hide();
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
		'order': [[0, 'desc']]
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
		})

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
		  	$.post('../controladores/periodo-escolar.php?op=desactivar', {idperiodo: idperiodo}, function (e) {

				if (e == 'true') {
					const Toast = Swal.mixin({
					  toast: true,
					  position: 'top-end',
					  showConfirmButton: false,
					  timer: 3000
					});

					Toast.fire({
					  type: 'success',
					  title: 'Período escolar finalizado :)'
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
					  title: 'Ups! No se pudo finalizar el periodo escolar'
					});
				}
				verificar();
				tabla.ajax.reload();
			});  
		  } 
		});
}

init();


