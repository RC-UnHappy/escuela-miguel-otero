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

    //Se ejecuta al quitar el foco en el input de lapso
    $('#lapso').on('blur', function () {
        comprobarLapso(this);
    });

    $('#btnAgregar').on('click', function () {
        limpiar();
    });

    tabla.ajax.reload();

})();

//Comprueba que no exista el lapso en el base de datos
function comprobarLapso(esto) {
    var lapso = esto.value;
    $.post('../controladores/lapso.php?op=comprobarlapso', { lapso: lapso }, function (data) {
        
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
                title: 'El lapso ya existe'
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
    var formData = new FormData($([formularioLapso])[0]); //Se obtienen los datos del formulario

    $.ajax({
        url: '../controladores/lapso.php?op=guardaryeditar', //Dirección a donde se envían los datos
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
        'order': [[0, 'desc']]
    });
}

//Función para mostrar un registro para editar
function mostrar(idlapso) {
    $.post('../controladores/lapso.php?op=mostrar', { idlapso: idlapso }, function (data) {
        data = JSON.parse(data);

        $('#lapso').val(data.lapso);
        $('#estatus').selectpicker('val', data.estatus);
        $('#idlapso').val(data.id);
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



