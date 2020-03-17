//Funcion que se ejecutará al inicio
(function () {  
    
    //Muestra la lista de lapsos
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
      traerUltimoLapso();
      limpiar();
    });

    tabla.ajax.reload();

})();

//Trae el último lapso y le suma uno
function traerUltimoLapso() {
  $.post('../controladores/lapso.php?op=traerultimolapso', function (data) {
    data = JSON.parse(data)
    if (data != 'null') {
      let lapso = Number(data.lapso) + 1;
      $('#lapso').html('<option value="'+lapso+'">'+lapso+'º Lapso</option>'); 
      $('#lapso').selectpicker('refresh');   
    }
    else{
      $('#lapso').html('<option value="1">1º Lapso</option>');
      $('#lapso').selectpicker('refresh');
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
  $('#btnGuardar').prop('disabled', true);
    var formData = new FormData($([formularioLapso])[0]); //Se obtienen los datos del formulario

    $.ajax({
        url: '../controladores/lapso.php?op=guardaryeditar', //Dirección a donde se envían los datos
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
                    title: 'Laspo registrado exitosamente :)'
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
                    title: 'Laspo modificado exitosamente :)'
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
            url: '../controladores/lapso.php?op=listar',
            type: 'GET',
            dataType: 'json'
        },
        'order': [[1, 'asc']]
    });
}

//Función para desactivar el lapso
function desactivar(idlapso) {

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary  mx-1 p-2',
            cancelButton: 'btn btn-danger  mx-1 p-2'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: '¿Estas seguro?',
        text: "¿Quieres desactivar este lapso?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Desactivar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            $.post('../controladores/lapso.php?op=desactivar', { idlapso: idlapso }, function (e) {
                if (e == 'true') {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    Toast.fire({
                        type: 'success',
                        title: 'El lapso ha sido desactivado :)'
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
                        title: 'Ups! No se pudo desactivar el lapso'
                    });
                }
                tabla.ajax.reload();
            });
        }
    });
}

//Función para activar el lapso
function activar(idlapso) {

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary  mx-1 p-2',
            cancelButton: 'btn btn-danger  mx-1 p-2'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: '¿Estas seguro?',
        text: "¿Quieres activar este lapso?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Activar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            $.post('../controladores/lapso.php?op=activar', { idlapso: idlapso }, function (e) {
                if (e == 'true') {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    Toast.fire({
                        type: 'success',
                        title: 'El lapso ha sido activado :)'
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
                        title: 'Ups! No se pudo activar el lapso'
                    });
                }
                tabla.ajax.reload();
            });
        }
    });

}

//Función para limpiar el formulario
function limpiar() {
    $("#formularioregistros")[0].reset();
    $('#lapso').removeClass('is-invalid');
    $('#estatus').removeClass('is-invalid');
    $('#estatus').selectpicker('val', '');
    $('#idlapso').val('');
    $('#formularioregistros').removeClass('was-validated');
}



