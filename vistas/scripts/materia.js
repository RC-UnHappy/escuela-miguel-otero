//Funcion que se ejecutará al inicio

function init() {

	//Muestra la lista de materias
	listar();

	//Se ejecuta cuando se envia el formulario
	$([formularioMateria]).on('submit', function (event) {
		if ($([formularioMateria])[0].checkValidity()) {
			guardaryeditar(event);
		}
		else {
			scrollTo(0,100);
		}
	});

	//Se ejecuta al quitar el foco en el input de materia
	$('#materia').on('blur', function () {
		comprobarMateria(this);
		
	});

	$('#btnAgregar').on('click', function () {
		limpiar();
	});

	tabla.ajax.reload();
			
}

//Comprueba que no exista la materia en el base de datos
function comprobarMateria(esto) {
	var materia = esto.value;
	$.post('../controladores/materia.php?op=comprobarmateria',{materia: materia}, function (data) {	
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
				  title: 'La materia ya existe'
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
	var formData = new FormData($([formularioMateria])[0]); //Se obtienen los datos del formulario
	
	$.ajax({
		url: '../controladores/materia.php?op=guardaryeditar', //Dirección a donde se envían los datos
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
				  title: 'Materia registrada exitosamente :)'
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
				  title: 'Materia modificada exitosamente :)'
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
			$('#materiaModal').modal('hide');
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
			url: '../controladores/materia.php?op=listar',
			type: 'GET',
			dataType: 'json'
		},
		'order': [[0, 'desc']]
	});
}

//Función para mostrar un registro para editar
function mostrar(idmateria) {
	$.post('../controladores/materia.php?op=mostrar',{idmateria: idmateria}, function (data) {	
		data = JSON.parse(data);

		$('#materia').val(data.materia);
		$('#estatus').val(data.estatus);
		$('#estatus').selectpicker('refresh');
		$('#idmateria').val(data.id);
	});
}

//Función para desactivar la materia
function desactivar(idmateria) {

		const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-primary  mx-1 p-2',
		    cancelButton: 'btn btn-danger  mx-1 p-2'
		  },
		  buttonsStyling: false
		})

		swalWithBootstrapButtons.fire({
		  title: '¿Estas seguro?',
		  text: "¿Quieres desactivar esta materia?",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Desactivar',
		  cancelButtonText: 'Cancelar',
		  reverseButtons: true
		}).then((result) => {
		  if (result.value) {
		  	$.post('../controladores/materia.php?op=desactivar', {idmateria: idmateria}, function (e) {
				if (e == 'true') {
					const Toast = Swal.mixin({
					  toast: true,
					  position: 'top-end',
					  showConfirmButton: false,
					  timer: 3000
					});

					Toast.fire({
					  type: 'success',
					  title: 'La materia ha sido desactivada :)'
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
					  title: 'Ups! No se pudo desactivar la materia'
					});
				}
				tabla.ajax.reload();
			});  
		  } 
		});
}

//Función para activar la materia
function activar(idmateria) {

	const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-primary  mx-1 p-2',
		    cancelButton: 'btn btn-danger  mx-1 p-2'
		  },
		  buttonsStyling: false
		})

		swalWithBootstrapButtons.fire({
		  title: '¿Estas seguro?',
		  text: "¿Quieres activar esta materia?",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonText: 'Activar',
		  cancelButtonText: 'Cancelar',
		  reverseButtons: true
		}).then((result) => {
		  if (result.value) {
		  	$.post('../controladores/materia.php?op=activar', {idmateria: idmateria}, function (e) {
				if (e == 'true') {
					const Toast = Swal.mixin({
					  toast: true,
					  position: 'top-end',
					  showConfirmButton: false,
					  timer: 3000
					});

					Toast.fire({
					  type: 'success',
					  title: 'La materia ha sido activada :)'
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
					  title: 'Ups! No se pudo activar la materia'
					});
				}
				tabla.ajax.reload();
			});  
		  } 
		});

}

//Función para limpiar el formulario
function limpiar() {
	$('#materia').val('');
	$('#materia').removeClass('is-invalid');
	$('#estatus').val('');
	$('#estatus').removeClass('is-invalid');
	$('#estatus').selectpicker('refresh');
	$('#idmateria').val('');
	$('#formularioregistros').removeClass('was-validated');
}

init();


