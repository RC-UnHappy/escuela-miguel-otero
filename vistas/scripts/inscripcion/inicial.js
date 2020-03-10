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


  ////////////////////////// Eventos relacionados con el estudiante
  // Se ejecuta al seleccionar un elemento del select documento
  $('#documento_estudiante').on('change', function () {
      $('#cedula_estudiante').val(''); 
      comprobarInscripcion();
  });

  // Se ejecuta al quitar el foco del input cedula
  $('#cedula_estudiante').on('blur', function () {
      comprobarInscripcion();
  });

  //Comprueba si el estudiante fue parto multiple
  $('input[name=parto]').on('click', function () {
      if (this.value == 'si') {
          $('#orden').prop('disabled', false);
      }
      else {
          $('#orden')[0].value = '';
          $('#orden').prop('disabled', true);
          comprobarInscripcion();
      }
  });

  //Se ejecuta al cambiar en el input orden
  $('#orden').on('change', function () {
      comprobarInscripcion();
  });

  //Se ejecuta al quitar el click del input f_nac
  $('#f_nac_estudiante').on('blur', function () {
      comprobarInscripcion();
  });


  ////////////////////////// Eventos relacionados con la madre
  // Se ejecuta al seleccionar un elemento del select documento
  $('#documento_madre').on('change', function () {
      comprobarPadres('madre', 'F');
      comprobarPersona('madre', 'F');
      comprobarInscripcion();
  });

  // Se ejecuta al quitar el foco del input cedula
  $('#cedula_madre').on('blur', function () {
      comprobarPadres('madre', 'F');
      comprobarPersona('madre', 'F');
      comprobarInscripcion();
  });


  ////////////////////////// Eventos relacionados con el padre
  // Se ejecuta al seleccionar un elemento del select documento
  $('#documento_padre').on('change', function () {
      comprobarPadres('padre', 'M');
      comprobarPersona('padre', 'M');
  });

  // Se ejecuta al quitar el foco del input cedula
  $('#cedula_padre').on('blur', function () {
      comprobarPadres('padre', 'M');
      comprobarPersona('padre', 'M');
  });


  ////////////////////////// Eventos relacionados con el representante
  // Se ejecuta al seleccionar un elemento del select documento
  $('#documento_representante').on('change', function () {
      if (!comprobarRepresentante('representante')) {
          comprobarPadres('representante', null);
          comprobarPersona('representante', null);        
      }
  });

  // Se ejecuta al quitar el foco del input cedula
  $('#cedula_representante').on('blur', function () {
      if (!comprobarRepresentante('representante')) {
          comprobarPadres('representante', null);
          comprobarPersona('representante', null);           
      }
  });


  /**
   * Eventos relacionados con los selesct de pais, estado, municipio, parroquia
   */
  //Comprueba cada cambio en el select de pais de nacimiento
  $('#pais_nacimiento_estudiante').on('change', function () {
    let idpaisNacimiento = $('#pais_nacimiento_estudiante')[0].value;

    if (idpaisNacimiento != '') {
      let data = estados(idpaisNacimiento);

      data
        .then(function (r) {
          $('#estado_nacimiento_estudiante').prop('disabled', false);
          $('#estado_nacimiento_estudiante').html('<option value="">Seleccione</option>');
          $('#estado_nacimiento_estudiante').append(r);
          $('#estado_nacimiento_estudiante').selectpicker('refresh');

          $('#municipio_nacimiento_estudiante').html('<option value="">Seleccione</option>');
          $('#municipio_nacimiento_estudiante').prop('disabled', true);
          $('#municipio_nacimiento_estudiante').selectpicker('refresh');

          $('#parroquia_nacimiento_estudiante').html('<option value="">Seleccione</option>');
          $('#parroquia_nacimiento_estudiante').prop('disabled', true);
          $('#parroquia_nacimiento_estudiante').selectpicker('refresh');
        });

    }
    else {
      $('#estado_nacimiento_estudiante').html('<option value="">Seleccione</option>');
      $('#estado_nacimiento_estudiante').prop('disabled', true);
      $('#estado_nacimiento_estudiante').selectpicker('refresh');

      $('#municipio_nacimiento_estudiante').html('<option value="">Seleccione</option>');
      $('#municipio_nacimiento_estudiante').prop('disabled', true);
      $('#municipio_nacimiento_estudiante').selectpicker('refresh');

      $('#parroquia_nacimiento_estudiante').html('<option value="">Seleccione</option>');
      $('#parroquia_nacimiento_estudiante').prop('disabled', true);
      $('#parroquia_nacimiento_estudiante').selectpicker('refresh');
    }
  });

  //Comprueba cada cambio en el select de estado de nacimiento
  $('#estado_nacimiento_estudiante').on('change', function () {
    let idestadoNacimiento = $('#estado_nacimiento_estudiante')[0].value;

    if (idestadoNacimiento != '') {
      let data = municipios(idestadoNacimiento);

      data
        .then(function (r) {
          $('#municipio_nacimiento_estudiante').prop('disabled', false);
          $('#municipio_nacimiento_estudiante').html('<option value="">Seleccione</option>');
          $('#municipio_nacimiento_estudiante').append(r);
          $('#municipio_nacimiento_estudiante').selectpicker('refresh');

          $('#parroquia_nacimiento_estudiante').html('<option value="">Seleccione</option>');
          $('#parroquia_nacimiento_estudiante').prop('disabled', true);
          $('#parroquia_nacimiento_estudiante').selectpicker('refresh');
        });

    }
    else {

      $('#municipio_nacimiento_estudiante').html('<option value="">Seleccione</option>');
      $('#municipio_nacimiento_estudiante').prop('disabled', true);
      $('#municipio_nacimiento_estudiante').selectpicker('refresh');

      $('#parroquia_nacimiento_estudiante').html('<option value="">Seleccione</option>');
      $('#parroquia_nacimiento_estudiante').prop('disabled', true);
      $('#parroquia_nacimiento_estudiante').selectpicker('refresh');
    }
  });

  //Comprueba cada cambio en el select de municipio de nacimiento
  $('#municipio_nacimiento_estudiante').on('change', function () {
    let idmunicipioNacimiento = $('#municipio_nacimiento_estudiante')[0].value;

    if (idmunicipioNacimiento != '') {
      let data = parroquias(idmunicipioNacimiento);

      data
        .then(function (r) {
          $('#parroquia_nacimiento_estudiante').prop('disabled', false);
          $('#parroquia_nacimiento_estudiante').html('<option value="">Seleccione</option>');
          $('#parroquia_nacimiento_estudiante').append(r);
          $('#parroquia_nacimiento_estudiante').selectpicker('refresh');
        });

    }
    else {

      $('#parroquia_nacimiento_estudiante').html('<option value="">Seleccione</option>');
      $('#parroquia_nacimiento_estudiante').prop('disabled', true);
      $('#parroquia_nacimiento_estudiante').selectpicker('refresh');
    }
  });


  $('#btnAgregar').on('click', function () {
    traerPlanificaciones();
    paises();
    // traerEstudiantes();
    // traerRepresentantes();
  });

  tabla.ajax.reload();
})();

//Función para crear la cédula estudiantil
function crearCedulaEstudiantil() {
    if ($('#documento_estudiante')[0].value == 'cedula_estudiantil' && $('#f_nac_estudiante')[0].value != '' && $('#documento_madre')[0].value != '' && $('#cedula_madre')[0].value != '') {
        if ($('input:radio[name=parto]:checked').val() == 'si') 
            var orden_nacimiento = $('#orden')[0].value;
        else 
            var orden_nacimiento = 1;

        let ano = $('#f_nac_estudiante')[0].value.substr(2, 2);
        let cedula_estudiantil = orden_nacimiento + ano + $('#cedula_madre')[0].value;

        return cedula_estudiantil;
    }
    return null;
}

/**
 * Función para verificar si el estudiante tiene una inscripción activa
 */
function comprobarInscripcion() {
    let documento = $('#documento_estudiante')[0].value;
    let cedula = $('#cedula_estudiante')[0].value;

    if (documento == '' || documento == 'venezolano' || documento == 'extranjero') {        
        $('#cedula_estudiante').prop('readonly', false);
    }
    else {
        $('#cedula_estudiante').prop('readonly', true);
        cedula = crearCedulaEstudiantil();
        $('#cedula_estudiante').val('');
        $('#cedula_estudiante').val(cedula);
    }
    
    if (documento != '' && cedula != '') { 
        documento = tipoDocumento(documento);
        cedula = documento + cedula;

        $.ajax({
            url: '../../controladores/inscripcion/inicial.php?op=comprobarinscripcion',
            type: 'POST',
            data: { cedula: cedula},
            success: function (datos) {
                datos = JSON.parse(datos);
                if (datos != null) {
                    $('#estudianteYaRegistrado').remove();
                    $('#comienzoFormulario').before('<div class="alert alert-danger col-md-12" role="alert" id="estudianteYaRegistrado">El estudiante ya se encuentra inscrito, debe inscribirlo en prosecución.</div>');
                    $('#cedula_estudiante').addClass('is-invalid');
                }
                else {
                    $('#cedula_estudiante').removeClass('is-invalid');
                    $('#estudianteYaRegistrado').remove();
                }
            }
        });

    }
    else {
        $('#cedula_estudiante').removeClass('is-invalid');
        $('#estudianteYaRegistrado').remove();
    }
    return;
}

//Comprueba que el padre o la madre no esté registrado como representante
function comprobarPadres(tipo = null, genero = null) {

    let documento = $('#documento_'+tipo)[0].value;
    let cedula = $('#cedula_'+tipo)[0].value;

    if (documento != '' && cedula != '') {      
        documento = tipoDocumento(documento);
        cedula = documento + cedula;
        
        $.ajax({
            url: '../../controladores/inscripcion/inicial.php?op=comprobarrepresentante',
            type: 'POST',
            data: { cedula: cedula, genero: genero},
            success: function (datos) {
              datos = JSON.parse(datos);
              if (datos != null) {                    
                $('#oficio_' + tipo).val(datos.oficio);
                $('#id' + tipo).val(datos.id);
                $('#idpersona' + tipo).val(datos.idpersona);
              }
              else {
                $('#oficio_' + tipo).val('');
                $('#id' + tipo).val('');       
              }
              comprobarRepresentante('representante');
            }
        });
    } 
    else {
        $('#oficio_' + tipo).val('');
        $('#id' + tipo).val(''); 
    }
    return;        
}

//Comprueba que la persona no esté registrada
function comprobarPersona(tipo = null, genero = null) {

    let documento = $('#documento_' + tipo)[0].value;
    let cedula = $('#cedula_' + tipo)[0].value;

    if (documento != '' && cedula != '') {
        documento = tipoDocumento(documento);
        cedula = documento + cedula;

        $.ajax({
            url: '../../controladores/inscripcion/inicial.php?op=comprobarpersona',
            type: 'POST',
            data: { cedula: cedula, genero: genero },
            success: function (datos) {
                datos = JSON.parse(datos);
                if (datos != null) {
                    $('#p_nombre_' + tipo).val(datos.p_nombre);
                    $('#s_nombre_' + tipo).val(datos.s_nombre);
                    $('#p_apellido_' + tipo).val(datos.p_apellido);
                    $('#s_apellido_' + tipo).val(datos.s_apellido);
                    $('#celular_' + tipo).val(datos.celular);
                    $('#direccion_residencia_' + tipo).val(datos.direccion_residencia);
                    $('#direccion_trabajo_' + tipo).val(datos.direccion_trabajo);
                    $('#idpersona' + tipo).val(datos.id);
                }
                else {
                    $('#p_nombre_' + tipo).val('');
                    $('#s_nombre_' + tipo).val('');
                    $('#p_apellido_' + tipo).val('');
                    $('#s_apellido_' + tipo).val('');
                    $('#celular_' + tipo).val('');
                    $('#direccion_residencia_' + tipo).val('');
                    $('#direccion_trabajo_' + tipo).val('');
                    $('#idpersona' + tipo).val('');
                }
                comprobarRepresentante('representante');
            }
        });
    }
    else {
      $('#p_nombre_' + tipo).val('');
      $('#s_nombre_' + tipo).val('');
      $('#p_apellido_' + tipo).val('');
      $('#s_apellido_' + tipo).val('');
      $('#celular_' + tipo).val('');
      $('#direccion_residencia_' + tipo).val('');
      $('#direccion_trabajo_' + tipo).val('');
      $('#idpersona' + tipo).val('');
    }
    return; 
}

/**
 * Comprueba si el padre o la madre es el representante y copia la información en representante
 * @param {string} tipo 
 */
function comprobarRepresentante(tipo = null) {
    let sw = false;
    if (tipo === 'representante') {
        let documentoMadre = $('#documento_madre')[0].value;
        let cedulaMadre = $('#cedula_madre')[0].value;
        cedulaMadre = documentoMadre + cedulaMadre;

        let documentoPadre = $('#documento_padre')[0].value;
        let cedulaPadre = $('#cedula_padre')[0].value;
        cedulaPadre = documentoPadre + cedulaPadre;

        let documentoRepresentante = $('#documento_representante')[0].value;
        let cedulaRepresentante = $('#cedula_representante')[0].value;
        cedulaRepresentante = documentoRepresentante + cedulaRepresentante;

        if (cedulaMadre == cedulaRepresentante && cedulaRepresentante != '') {
            $('#p_nombre_representante').val($('#p_nombre_madre')[0].value);
            $('#s_nombre_representante').val($('#s_nombre_madre')[0].value);
            $('#p_apellido_representante').val($('#p_apellido_madre')[0].value);
            $('#s_apellido_representante').val($('#s_apellido_madre')[0].value);
            $('#oficio_representante').val($('#oficio_madre')[0].value);
            $('#celular_representante').val($('#celular_madre')[0].value);
            $('#genero_representante').val('F');
            $('#genero_representante').selectpicker('refresh');
            $('#tiporepresentante').val('madre');
            $('#direccion_residencia_representante').val($('#direccion_residencia_madre')[0].value);
            $('#direccion_trabajo_representante').val($('#direccion_trabajo_madre')[0].value);
            $('#parentesco_representante').val('Madre');
            return sw;
        }
        else if (cedulaPadre == cedulaRepresentante && cedulaRepresentante != '') {
            $('#p_nombre_representante').val($('#p_nombre_padre')[0].value);
            $('#s_nombre_representante').val($('#s_nombre_padre')[0].value);
            $('#p_apellido_representante').val($('#p_apellido_padre')[0].value);
            $('#s_apellido_representante').val($('#s_apellido_padre')[0].value);
            $('#oficio_representante').val($('#oficio_padre')[0].value);
            $('#celular_representante').val($('#celular_padre')[0].value);
            $('#genero_representante').val('M');
            $('#genero_representante').selectpicker('refresh');
            $('#tiporepresentante').val('padre');
            $('#direccion_residencia_representante').val($('#direccion_residencia_padre')[0].value);
            $('#direccion_trabajo_representante').val($('#direccion_trabajo_padre')[0].value);
            $('#parentesco_representante').val('Padre');
            return sw;
        }
        else {
          $('#parentesco_representante').val(''); 
          $('#genero_representante').val('');
          $('#genero_representante').selectpicker('refresh');
        }
    }
    return sw;
}

//Determinar tipo de documento 
function tipoDocumento(documento = null) {
    switch (documento) {
        case 'venezolano':
            documento = 'V-';
            break;        
        case 'extranjero':
            documento = 'E-';
            break;
        case 'pasaporte':
            documento = 'P-';
            break;
        case 'cedula_estudiantil':
            documento = 'CE-';
            break;
    }
    return documento;
}

/**
 * Funciones para traer los paises, estado, municipios, parroquias
 * @param {integer} idpais 
 */
//Función para mostrar los paises
function paises(idpais = null) {

  if (idpais !== null) {
    $.post('../../controladores/inscripcion/inicial.php?op=listarpaises', function (data) {
      $('#pais_nacimiento_estudiante').append(data);
      $('#pais_nacimiento_estudiante').val(idpais);
      $('#pais_nacimiento_estudiante').selectpicker('refresh');
    });
  }
  else {
    $.post('../../controladores/inscripcion/inicial.php?op=listarpaises', function (data) {
      $('#pais_nacimiento_estudiante').append(data);
      $('#pais_nacimiento_estudiante').selectpicker('refresh');

      $('#estado_nacimiento_estudiante').html('<option value="">Seleccione</option>');
      $('#estado_nacimiento_estudiante').prop('disabled', true);
      $('#estado_nacimiento_estudiante').selectpicker('refresh');

      $('#municipio_nacimiento_estudiante').html('<option value="">Seleccione</option>');
      $('#municipio_nacimiento_estudiante').prop('disabled', true);
      $('#municipio_nacimiento_estudiante').selectpicker('refresh');

      $('#parroquia_nacimiento_estudiante').html('<option value="">Seleccione</option>');
      $('#parroquia_nacimiento_estudiante').prop('disabled', true);
      $('#parroquia_nacimiento_estudiante').selectpicker('refresh');
    });
  }
}

//Función para traer los estados
function estados(idpais = null) {
  let estados;
  if (idpais !== null)
    estados = $.post('../../controladores/inscripcion/inicial.php?op=listarestados&idpais=' + idpais);
  else
    estados = $.post('../../controladores/inscripcion/inicial.php?op=listarestados');

  return estados;
}

//Función para mostrar los municipios
function municipios(idestado) {

  let municipios;
  if (idestado !== null)
    municipios = $.post('../../controladores/inscripcion/inicial.php?op=listarmunicipios&idestado=' + idestado);
  else
    municipios = $.post('../../controladores/inscripcion/inicial.php?op=listarmunicipios');

  return municipios;
}

//Función para mostrar las parroquias
function parroquias(idmunicipio) {

  let parroquias;
  if (idmunicipio !== null)
    parroquias = $.post('../../controladores/inscripcion/inicial.php?op=listarparroquias&idmunicipio=' + idmunicipio);
  else
    parroquias = $.post('../../controladores/inscripcion/inicial.php?op=listarparroquias');

  return parroquias;
}

function traerPlanificaciones() {
    $.post('../../controladores/inscripcion/inicial.php?op=traerplanificaciones', function (data) {        
        data = JSON.parse(data);
        
        let planificacion = '';
        if (data.length != 0) {
            data.forEach(function (indice) {
                planificacion += '<option value="' + indice.id + '">' + indice.grado + ' º - "' + indice.seccion + '" - Cupo disponible: '+indice.cupo_disponible+'</option>';
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


//Función cancelarform
function cancelarform() {
    limpiar();
}

//Función para inscribir
function guardaryeditar(event) {
    event.preventDefault(); //Evita que se envíe el formulario automaticamente
    // 
    // $('#btnGuardar').prop('disabled', true);
    var formData = new FormData($([formularioInscripcion])[0]); //Se obtienen los datos del formulario

    /**
     * Se formatea la cédula del estudiante
     */
    var documento_estudiante = formData.get('documento_estudiante');
    documento_estudiante = tipoDocumento(documento_estudiante);
    var cedula_estudiante = formData.get('cedula_estudiante');
    formData.set('cedula_estudiante', documento_estudiante + cedula_estudiante);

    /**
     * Se formatea la cédula de la madre
     */
    var documento_madre = formData.get('documento_madre');
    documento_madre = tipoDocumento(documento_madre);
    var cedula_madre = formData.get('cedula_madre');
    formData.set('cedula_madre', documento_madre + cedula_madre);

    /**
     * Se formatea la cédula del padre
     */
    var documento_padre = formData.get('documento_padre');
    documento_padre = tipoDocumento(documento_padre);
    var cedula_padre = formData.get('cedula_padre');
    formData.set('cedula_padre', documento_padre + cedula_padre);

    /**
     * Se formatea la cédula del representante
     */
    var documento_representante = formData.get('documento_representante');
    documento_representante = tipoDocumento(documento_representante);
    var cedula_representante = formData.get('cedula_representante');
    formData.set('cedula_representante', documento_representante + cedula_representante);

    $.ajax({
        url: '../../controladores/inscripcion/inicial.php?op=inscribir', //Dirección a donde se envían los datos
        type: 'POST', //Método por el cual se envían los datos
        data: formData, //Datos
        contentType: false, //Este parámetro es para mandar datos al servidor por el encabezado
        processData: false, //Evita que jquery transforme la data en un string
        success: function (datos) {
            console.log(datos);
            
            if (datos == 'true') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                Toast.fire({
                    type: 'success',
                    title: 'Inscripción realizada exitosamente :)'
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
                    title: 'Ocurrió un error y no se pudo inscribir :('
                });
            }

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
                dataType: 'json'
            },
            'order': [[0, 'desc']],
        });
        
        tablaEstudiantes.ajax.reload();
}

//Función para limpiar el formulario
function limpiar() {
  $([formularioInscripcion])[0].reset();
  $('#documento_estudiante').selectpicker('val', '');
  $('#genero_estudiante').selectpicker('val', '');
  $('#pais_nacimiento_estudiante').selectpicker('val', '');
  $('#estado_nacimiento_estudiante').selectpicker('val', '');
  $('#municipio_nacimiento_estudiante').selectpicker('val', '');
  $('#parroquia_nacimiento_estudiante').selectpicker('val', '');
  $('#documento_madre').selectpicker('val', '');
  $('#documento_padre').selectpicker('val', '');
  $('#documento_representante').selectpicker('val', '');
  $('#genero_representante').selectpicker('val', '');
  $('#planificacion').selectpicker('val', '');
  $([formularioInscripcion]).removeClass('was-validated');
}

