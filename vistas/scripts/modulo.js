//Funcion que se ejecutará al inicio

function init() {

  //Muestra la lista de modulos
  listar();

  tabla.ajax.reload();

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
      url: '../controladores/modulo.php?op=listar',
      type: 'GET',
      dataType: 'json'
    },
    'order': [[1, 'asc']]
  });
}

init();


