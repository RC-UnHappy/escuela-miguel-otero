//Funcion que se ejecutará al inicio

function init() {

  //Oculta el formulario al cargar la pagina
  mostrarform(false);

  //Muestra la lista de usuarios
  listar();

  //Se ejecuta cuando se envia el formulario
  $([usuario]).on('submit', function (event) {
    if ($([usuario])[0].checkValidity()) {
      guardaryeditar(event);
    }
    else {
      scrollTo(0, 100);
    }
  });

  //Se ejecuta al quitar el foco del input cedula
  $('#documento').on('change', function () {
    if (this.value != '') {
      comprobarPersona();  
    }
    else {
      $([usuario])[0].reset();
      $('.selectpicker').selectpicker('refresh');
    }
  });

  //Se ejecuta al quitar el foco del input cedula
  $('#cedula').on('blur', function () {
    comprobarPersona();
  });

  //Se ejecuta al hacer un cambio en rol
  $('#rol').on('change', function () {
    let rol = $('#rol')[0].value;
    if (rol != '') {
      $('#permisos').show();
      //Mostramos los permisos 
      $.post('../controladores/usuario.php?op=permisos', { rol: rol}, function (response) {
        $('#permisos').html(response);
      });     
    }
    else {
      $('#permisos').html('');
    }
  });

  $("#seleccionarTodos").on("click", function () {
    $(".seleccionar").prop("checked", this.checked);
  });

  // if all checkbox are selected, check the selectall checkbox and viceversa  
  $("#permisos").on("click", "input.seleccionar" ,function () {
    if ($(".seleccionar").length == $(".seleccionar:checked").length) {
      $("#seleccionarTodos").prop("checked", true);
    } else {
      $("#seleccionarTodos").prop("checked", false);
    }
  });

  tabla.ajax.reload();

}

//Comprueba que el usuario no esté registrado
function comprobarPersona() {
  var documento = $('#documento')[0].value;
  var cedula = $('#cedula')[0].value;

  if (documento != '' && cedula != '') {
    cedula = documento + '-' + cedula;
  
    $.ajax({
      url: '../controladores/usuario.php?op=comprobarpersona',
      type: 'POST',
      data: { cedula: cedula },
      success: function (datos) {    
        datos = JSON.parse(datos);
        if (datos != null) {
          $('#p_nombre').val(datos.p_nombre);
          $('#s_nombre').val(datos.s_nombre);
          $('#p_apellido').val(datos.p_apellido);
          $('#s_apellido').val(datos.s_apellido);
          $('#genero').val(datos.genero);
          $('#f_nac').val(datos.f_nac);
          $('#email').val(datos.email);
          $('#idpersona').val(datos.id);
          $('.selectpicker').selectpicker('refresh');
        }
        else{
          $([usuario])[0].reset();
          $('.selectpicker').selectpicker('refresh');

          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

          Toast.fire({
            type: 'error',
            title: 'La persona no se encuentra registrada'
          });
        }
      }
    });  
  }
}

//Función para guardar y editar 
function guardaryeditar(event) {
  event.preventDefault(); //Evita que se envíe el formulario automaticamente
  // 
  $('#btnGuardar').prop('disabled', true); //Deshabilita el botón submit para evitar que lo presionen dos veces

  let documento = $('#documento')[0].value;
  let cedula = $('#cedula')[0].value;
  cedula = documento + '-' + cedula;

  var formData = new FormData($([usuario])[0]); //Se obtienen los datos del formulario

  formData.set('cedula', cedula);//Se le asigna a la cédula del formData el tipo de documento

  $.ajax({
    url: '../controladores/usuario.php?op=guardaryeditar', //Dirección a donde se envían los datos
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
          title: 'Usuario registrado exitosamente :)'
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
          title: 'Usuario actualizado exitosamente :)'
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

      mostrarform(false);
      limpiar();
      tabla.ajax.reload();//Recarga la tabla con el listado sin refrescar la página

    }

  });


}

//Función para listar los registros
function listar() {
  tabla = $('#tblistado').DataTable({
    "processing": true,
    // "serverSide": true,
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
      url: '../controladores/usuario.php?op=listar',
      type: 'GET',
      dataType: 'json'
    },
    'order': [[0, 'desc']]
  });
}

//Función para mostrar un registro para editar
function mostrar(idusuario) {
  $.post('../controladores/usuario.php?op=mostrar', { idusuario: idusuario }, function (data) {
    data = JSON.parse(data);
    mostrarform(true);
    let arregloCedula = data.cedula.split('-');
    $('#documento').val(arregloCedula[0]);
    $('#documento').prop('disabled', true);
    $('#cedula').val(arregloCedula[1]);
    $('#cedula').prop('disabled', true);
    $('#p_nombre').val(data.p_nombre);
    $('#s_nombre').val(data.s_nombre);
    $('#p_apellido').val(data.p_apellido);
    $('#s_apellido').val(data.s_apellido);
    $('#genero').val(data.genero);
    $('#f_nac').val(data.f_nac);
    $('#email').val(data.email);
    $('#usuario_sistema').val(data.usuario);
    $('#rol').val(data.rol_usuario);
    $('#idpersona').val(data.id);
    $('#idusuario').val(data.idusuario);
    $('.selectpicker').selectpicker('refresh');
  });

  //Traemos los permisos del usuario
  $.post('../controladores/usuario.php?op=permisos', { idusuario: idusuario }, function (response) {
    $('#permisos').html(response);
  });  

}

//Función para eliminar(desactivar) usuarios
function desactivar(idusuario) {

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-primary  mx-1 p-2',
      cancelButton: 'btn btn-danger  mx-1 p-2'
    },
    buttonsStyling: false
  })

  swalWithBootstrapButtons.fire({
    title: '¿Estas seguro?',
    text: "¿Quieres desactivar a este usuario?",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Desactivar',
    cancelButtonText: 'Cancelar',
    reverseButtons: true
  }).then((result) => {
    if (result.value) {
      $.post('../controladores/usuario.php?op=desactivar', { idusuario: idusuario }, function (e) {
        
        if (e == 'true') {
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

          Toast.fire({
            type: 'success',
            title: 'El usuario ha sido desactivado :)'
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
            title: 'Ups! No se pudo desactivar el usuario'
          });
        }
        tabla.ajax.reload();
      });
    }
  });
}

//Función para activar usuarios
function activar(idusuario) {

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-primary  mx-1 p-2',
      cancelButton: 'btn btn-danger  mx-1 p-2'
    },
    buttonsStyling: false
  })

  swalWithBootstrapButtons.fire({
    title: '¿Estas seguro?',
    text: "¿Quieres activar a este usuario?",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Activar',
    cancelButtonText: 'Cancelar',
    reverseButtons: true
  }).then((result) => {
    if (result.value) {
      $.post('../controladores/usuario.php?op=activar', { idusuario: idusuario }, function (e) {
        
        if (e == 'true') {
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

          Toast.fire({
            type: 'success',
            title: 'El usuario ha sido activado :)'
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
            title: 'Ups! No se pudo activar el usuario'
          });
        }
        tabla.ajax.reload();
      });
    }
  });

}

//Función para resetear usuarios
function resetear(idusuario) {

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-primary  mx-1 p-2',
      cancelButton: 'btn btn-danger  mx-1 p-2'
    },
    buttonsStyling: false
  })

  swalWithBootstrapButtons.fire({
    title: '¿Estas seguro?',
    text: "¿Quieres resetear a este usuario?",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Si',
    cancelButtonText: 'Cancelar',
    reverseButtons: true
  }).then((result) => {
    if (result.value) {
      $.post('../controladores/usuario.php?op=resetear', { idusuario: idusuario }, function (e) {
        if (e == 'true') {
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

          Toast.fire({
            type: 'success',
            title: 'El usuario ha sido reseteado :)'
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
            title: 'Ups! No se pudo resetear el usuario'
          });
        }
        tabla.ajax.reload();
      });
    }
  });

}

//Función para mostrar o ocultar el formulario
function mostrarform(flag) {
  limpiar();
  if (flag) {
    $('#listadoregistros').hide();
    $('#formularioregistros').show();
    $('#btnGuardar').prop('disabled', false);
    $('#btnagregar').hide();
  }
  else {
    $('#listadoregistros').show();
    $('#formularioregistros').hide();
    $('#btnagregar').show();
  }
}

//Función cancelarform
function cancelarform() {
  limpiar();
  mostrarform(false);
}

//Función para limpiar el formulario
function limpiar() {  
  $([usuario])[0].reset();
  $('.selectpicker').selectpicker('refresh');
  $('#formularioregistros').removeClass('was-validated');
  $('#permisos').html('');
}

init();


