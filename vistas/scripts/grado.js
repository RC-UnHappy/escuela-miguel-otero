//Funcion que se ejecutará al inicio

function init() {

	//Muestra la lista de grados
	listar();

	//Se ejecuta cuando se envia el formulario
	$([formularioGrado]).on('submit', function (event) {
		if ($([formularioGrado])[0].checkValidity()) {
			guardaryeditar(event);
		}
		else {
			scrollTo(0,100);
		}
	});

	//Se ejecuta al ingresar un número en el input de grado
	$('#grado').on('blur', function () {
		comprobarGrado(this);
		
	});

	$('#btnAgregar').on('click', function () {
		limpiar();
	});

	tabla.ajax.reload();
			
}

//Comprueba que no exista el grado en el base de datos

function comprobarGrado(esto) {
	var grado = esto.value;
	$.post('../controladores/grado.php?op=comprobargrado',{grado: grado}, function (data) {	
		if (data != 'null') {
			esto.value = '';
			const Toast = Swal.mixin({
				  toast: true,
				  position: 'top-end',
				  showConfirmButton: false,
				  timer: 3000
				});

				Toast.fire({
				  type: 'error',
				  title: 'El grado ya existe'
				});
		}

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
	var formData = new FormData($([formularioGrado])[0]); //Se obtienen los datos del formulario
	
	$.ajax({
		url: '../controladores/grado.php?op=guardaryeditar', //Dirección a donde se envían los datos
		type: 'POST', //Método por el cual se envían los datos
		data: formData, //Datos
		contentType: false, //Este parámetro es para mandar datos al servidor por el encabezado
		processData: false, //Evita que jquery transforme la data en un string
		success: function (datos) {
			if (datos == 'true') {
				const Toast = Swal.mixin({
				  toast: true,
				  position: 'top-end',
				  showConfirmButton: false,
				  timer: 3000
				});

				Toast.fire({
				  type: 'success',
				  title: 'Grado registrado exitosamente :)'
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
				  title: 'Grado modificado exitosamente :)'
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
			$('#gradoModal').modal('hide');
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
			url: '../controladores/grado.php?op=listar',
			type: 'GET',
			dataType: 'json',
			error: function (data) {
				
			}
		},
		'order': [[0, 'desc']]
	});
}

//Función para mostrar un registro para editar
function mostrar(idgrado) {
	$.post('../controladores/grado.php?op=mostrar',{idgrado: idgrado}, function (data) {	
		data = JSON.parse(data);

		$('#grado').val(data.grado);
		$('#estatus').val(data.estatus);
		$('#estatus').selectpicker('refresh');
		$('#idgrado').val(data.id);
	});
}

//Función para desactivar grado
function desactivar(idgrado) {

		const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-primary  mx-1 p-2',
		    cancelButton: 'btn btn-danger  mx-1 p-2'
		  },
		  buttonsStyling: false
		})

		swalWithBootstrapButtons.fire({
		  title: '¿Estas seguro?',
		  text: "¿Quieres desactivar este grado?",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Desactivar',
		  cancelButtonText: 'Cancelar',
		  reverseButtons: true
		}).then((result) => {
		  if (result.value) {
		  	$.post('../controladores/grado.php?op=desactivar', {idgrado: idgrado}, function (e) {
				if (e == 'true') {
					const Toast = Swal.mixin({
					  toast: true,
					  position: 'top-end',
					  showConfirmButton: false,
					  timer: 3000
					});

					Toast.fire({
					  type: 'success',
					  title: 'El grado ha sido desactivado :)'
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
					  title: 'Ups! No se pudo desactivar el grado'
					});
				}
				tabla.ajax.reload();
			});  
		  } 
		});
}

//Función para activar grado
function activar(idgrado) {

	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-primary  mx-1 p-2',
		    cancelButton: 'btn btn-danger  mx-1 p-2'
		  },
		  buttonsStyling: false
		})

		swalWithBootstrapButtons.fire({
		  title: '¿Estas seguro?',
		  text: "¿Quieres activar este grado?",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Activar',
		  cancelButtonText: 'Cancelar',
		  reverseButtons: true
		}).then((result) => {
		  if (result.value) {
		  	$.post('../controladores/grado.php?op=activar', {idgrado: idgrado}, function (e) {
				if (e == 'true') {
					const Toast = Swal.mixin({
					  toast: true,
					  position: 'top-end',
					  showConfirmButton: false,
					  timer: 3000
					});

					Toast.fire({
					  type: 'success',
					  title: 'El grado ha sido activado :)'
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
					  title: 'Ups! No se pudo activar el grado'
					});
				}
				tabla.ajax.reload();
			});  
		  } 
		});

}

//Función para limpiar el formulario
function limpiar() {
	$('#grado').val('');
	$('#grado').removeClass('is-invalid');
	$('#estatus').val('');
	$('#estatus').removeClass('is-invalid');
	$('#estatus').selectpicker('refresh');
	$('#idgrado').val('');
	$('#formularioregistros').removeClass('was-validated');
}

init();


