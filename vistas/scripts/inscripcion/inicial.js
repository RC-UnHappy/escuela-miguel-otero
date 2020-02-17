//Funcion que se ejecutará al inicio
(function () {
    //Muestra la lista de planificaciones
    listar();

    //Se ejecuta cuando se envia el formulario
    $([formularioInscripcion]).on('submit', function (event) {
        if ($([formularioInscripcion])[0].checkValidity()) {
            guardaryeditar(event);
        }
        else {
            scrollTo(0, 100);
        }
    });

    $('#btnAgregar').on('click', function () {
        traerPlanificaciones();
        traerEstudiantes();
        traerRepresentantes();
    });

    tabla.ajax.reload();
})();

function traerPlanificaciones() {
    $.post('../../controladores/inscripcion/inicial.php?op=traerplanificaciones', function (data) {        
        data = JSON.parse(data);
        
        let planificacion = '';
        if (data.length != 0) {
            data.forEach(function (indice) {
                planificacion += '<option value="' + indice.id + '">' + indice.grado + ' º - "' + indice.seccion + '"</option>';
            });
        }
        else {
            planificacion = '<option value="">Debe crear planificaciones en configuración</option>';
        }
        
        $('#planificacion').html('<option value="">Seleccione</option>');
        $('#planificacion').append(planificacion);
        $('#planificacion').selectpicker('refresh');
    });
}

function traerEstudiantes() {
    $.post('../../controladores/inscripcion/inicial.php?op=traerestudiantes', function (data) {

        data = JSON.parse(data);
        
        let estudiante = '';
        if (data.length != 0) {
            data.forEach(function (indice) {
                estudiante += '<option value="' + indice.id + '">' + indice.cedula + ' - '+ indice.nombre + ' '+ indice.apellido +'</option>';
            });
        }
        else {
            estudiante = '<option value="">Debe registrar estudiantes</option>';
        }
        $('#estudiante').html('<option value="">Seleccione</option>');
        $('#estudiante').append(estudiante);
        $('#estudiante').selectpicker('refresh');
    });
}

function traerRepresentantes() {
    $.post('../../controladores/inscripcion/inicial.php?op=traerrepresentantes', function (data) {
        
        data = JSON.parse(data);
        let representante = '';
        if (data.length != 0) {
            data.forEach(function (indice) {
                representante += '<option value="' + indice.id + '">' + indice.cedula + ' - ' + indice.nombre + ' ' + indice.apellido + '</option>';
            });
        }
        else {
            representante = '<option value="">Debe registrar representantes</option>';
        }
        $('#representante').html('<option value="">Seleccione</option>');
        $('#representante').append(representante);
        $('#representante').selectpicker('refresh');
    });
}

//Función cancelarform
function cancelarform() {
    limpiar();
}

//Función para inscribir
function guardaryeditar(event) {
    event.preventDefault(); //Evita que se envíe el formulario automaticamente
    // 
    var formData = new FormData($([formularioInscripcion])[0]); //Se obtienen los datos del formulario

    $.ajax({
        url: '../../controladores/inscripcion/inicial.php?op=guardaryeditar', //Dirección a donde se envían los datos
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
                    title: 'Inscripción registrada exitosamente :)'
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
                    title: 'Inscripción modificada exitosamente :)'
                });

                $('#planificacionModal').modal('hide');
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

            traerPlanificaciones();
            traerEstudiantes();
            traerRepresentantes();
            limpiar();
            tabla.ajax.reload();//Recarga la tabla con el listado sin refrescar la página

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
        "destroy": true, //Elimina cualquier elemento que se encuentre en la tabla
        "ajax": {
            url: '../../controladores/inscripcion/inicial.php?op=listar',
            type: 'GET',
            dataType: 'json'
        },
        'order': [[0, 'desc']],
    });
}

//Función para mostrar los estudiantes inscritos en una planificación
function mostrar(idplanificacion) {
    // $.post('../../controladores/inscripcion/inicial.php?op=mostrar', { idplanificacion: idplanificacion }, function (dataEstudiantes) {
        // console.log(dataEstudiantes);

        tablaEstudiantes = $('#tblistadoEstudiantes').DataTable({
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
            "destroy": true, //Elimina cualquier elemento que se encuentre en la tabla
            "ajax": {
                url: '../../controladores/inscripcion/inicial.php?op=mostrar&idplanificacion='+idplanificacion,
                type: 'GET',
                dataType: 'json',
                error : function (e) {
                    console.log(e);
                  }
            },
            'order': [[0, 'desc']],
        });
        
        tablaEstudiantes.ajax.reload();
    // });
    
}

//Función para eliminar una planificación
function eliminar(idplanificacion) {

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary  mx-1 p-2',
            cancelButton: 'btn btn-danger  mx-1 p-2'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: '¿Estas seguro?',
        text: "¿Quieres eliminar esta planificación?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            $.post('../controladores/planificacion.php?op=eliminar', { idplanificacion: idplanificacion }, function (e) {
                if (e == 'true') {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    Toast.fire({
                        type: 'success',
                        title: 'La planificación ha sido eliminada :)'
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
                        title: 'Ups! No se pudo eliminar la planificación'
                    });
                }
                tabla.ajax.reload();
            });
        }
    });
}

//Función para limpiar el formulario
function limpiar() {
    $('#planificacion').selectpicker('val', '');
    $('#estudiante').selectpicker('val', '');
    $('#representante').selectpicker('val', '');
    $('#estatus').selectpicker('val', '');
    $('#formularioregistros').removeClass('was-validated');
}

