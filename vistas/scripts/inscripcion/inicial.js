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

//Función para mostrar un registro para editar
function mostrar(idplanificacion) {
    $.post('../controladores/planificacion.php?op=mostrar', { idplanificacion: idplanificacion }, function (planificacion) {
        planificacion = JSON.parse(planificacion);

        $.post('../controladores/planificacion.php?op=traergrados', function (grados) {
            grados = JSON.parse(grados);
            let grado = '';
            if (grados.length != 0) {
                grados.forEach(function (indice, valor) {
                    grado += '<option value="' + indice.id + '">' + indice.grado + ' º</option>';
                });
            }
            else {
                grado = '<option value="">Debe Ingresar grados en configuración</option>';
            }
            $('#grado').html('<option value="">Seleccione</option>');
            $('#grado').append(grado);
            $('#grado').selectpicker('refresh');
        }).then(function () {
            $('#grado').selectpicker('val', planificacion.idgrado);
        });

        $.post('../controladores/planificacion.php?op=traersecciones', { idgrado: planificacion.idgrado, idplanificacion: planificacion.id }, function (data) {
            data = JSON.parse(data);
            let seccion = '';
            if (data.length != 0) {
                data.forEach(function (indice, valor) {
                    seccion += '<option value="' + indice.id + '">' + indice.seccion + '</option>';
                });
            }
            else {
                seccion = '<option value="">Debe Ingresar secciones en configuración</option>';
            }
            $('#seccion').prop('disabled', false);
            $('#seccion').html('<option value="">Seleccione</option>');
            $('#seccion').append(seccion);
            $('#seccion').selectpicker('refresh');
        })
            .then(() => {
                $('#seccion').selectpicker('val', planificacion.idseccion);
            });

        $.post('../controladores/planificacion.php?op=traerambientes', { idambiente: planificacion.idambiente }, function (data) {
            data = JSON.parse(data);
            let ambiente = '';
            if (data.length != 0) {
                data.forEach(function (indice, valor) {
                    ambiente += '<option value="' + indice.id + '">' + indice.ambiente + '</option>';
                });
            }
            else {
                ambiente = '<option value="">Debe ingresar ambientes en configuración</option>';
            }
            $('#ambiente').html('<option value="">Seleccione</option>');
            $('#ambiente').append(ambiente);
            $('#ambiente').selectpicker('refresh');
        }).then(() => {
            $('#ambiente').selectpicker('val', planificacion.idambiente);
        });

        $.post('../controladores/planificacion.php?op=traerdocentes', { iddocente: planificacion.iddocente }, function (data) {
            data = JSON.parse(data);
            let docente = '';
            if (data.length != 0) {
                data.forEach(function (indice, valor) {
                    docente += '<option value="' + indice.id + '">' + indice.p_nombre + ' ' + indice.p_apellido + '</option>';
                });
            }
            else {
                docente = '<option value="">Debe Ingresar docentes en configuración</option>';
            }
            $('#docente').html('<option value="">Seleccione</option>');
            $('#docente').append(docente);
            $('#docente').selectpicker('refresh');
        }).then(() => {
            $('#docente').selectpicker('val', planificacion.iddocente);
        });

        $('#cupo').val(planificacion.cupo);
        $('#idplanificacion').val(planificacion.id);
    });
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

