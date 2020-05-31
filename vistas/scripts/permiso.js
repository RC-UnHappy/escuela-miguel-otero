//Función que se ejecutará al inicio
function init() {
	mostrarform(false);
	listar();
}

//Función para mostrar el formulario
function mostrarform(flag) {
	if (flag) {
		$('#listadoregistros').hide();
		$('#formularioregistros').show();
		$('#btnGuardar').prop('disabled', false);
		$('#btnagregar').hide();
	}
	else {
		$('#listadoregistros').show();
		$('#formularioregistros').hide();
		$('#btnagregar').hide();
	}
}

//Función para mostrar el listado

function listar() {
	$('#tblistado').DataTable({
		"processing": true,
		// "serverSide": true,
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
			url: '../controladores/permiso.php?op=listar',
			type: 'GET',
			dataType: 'json'
		},
		'order': [[0, 'desc']]
		
	});
}

init();