//Funcion que se ejecutará al inicio

function init() {
  //Muestra la lista
  listar();

  //Se ejecuta cuando se envia el formulario
  $([formularioProfesion]).on("submit", function (event) {
    if ($([formularioProfesion])[0].checkValidity()) {
      guardaryeditar(event);
    } else {
      scrollTo(0, 100);
    }
  });

  //Se ejecuta al quitar el foco en el input de enfermedad
  $("#enfermedad").on("blur", function () {
    comprobarEnfermedad(this);
  });

  $("#btnAgregar").on("click", function () {
    limpiar();
  });

  tabla.ajax.reload();
}

//Comprueba que no exista la enfermedad en el base de datos
function comprobarEnfermedad(esto) {
  var enfermedad = esto.value;
  $.post(
    "../controladores/enfermedad.php?op=comprobarenfermedad",
    { enfermedad: enfermedad },
    function (data) {
      if (data != "null") {
        esto.value = "";
        const Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
        });

        Toast.fire({
          type: "error",
          title: "La enfermedad ya existe",
        });
      }
    }
  );
}

//Función cancelarform
function cancelarform() {
  limpiar();
}

//Función para guardar y editar
function guardaryeditar(event) {
  event.preventDefault(); //Evita que se envíe el formulario automaticamente

  //
  $("#btnGuardar").prop("disabled", true);
  var formData = new FormData($([formularioProfesion])[0]); //Se obtienen los datos del formulario

  $.ajax({
    url: "../controladores/profesion.php?op=guardaryeditar", //Dirección a donde se envían los datos
    type: "POST", //Método por el cual se envían los datos
    data: formData, //Datos
    contentType: false, //Este parámetro es para mandar datos al servidor por el encabezado
    processData: false, //Evita que jquery transforme la data en un string
    success: function (datos) {
      $("#btnGuardar").prop("disabled", false);
      if (datos == "true") {
        const Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
        });

        Toast.fire({
          type: "success",
          title: "Prefesión registrada exitosamente :)",
        });
      } else if (datos == "update") {
        const Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
        });

        Toast.fire({
          type: "success",
          title: "Profesión modificada exitosamente :)",
        });
      } else {
        const Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
        });

        Toast.fire({
          type: "error",
          title: "Ocurrió un error y no se pudo registrar :(",
        });
      }

      limpiar();
      tabla.ajax.reload(); //Recarga la tabla con el listado sin refrescar la página
      $("#profesionModal").modal("hide");
    },
  });
}

//Función para listar los registros
function listar() {
  tabla = $("#tblistado").DataTable({
    processing: true,
    pagingType: "first_last_numbers",
    language: {
      info: "Mostrando desde _START_ hasta _END_ de _TOTAL_ registros",
      lengthMenu: "Mostrar _MENU_ entradas",
      loadingRecords: "Cargando...",
      processing: "Procesando...",
      search: "Buscar:",
      emptyTable: "No hay datos para mostrar",
      infoEmpty: "Mostrando 0 hasta 0 de 0 entradas",
      paginate: {
        first: "Primero",
        last: "Último",
      },
    },
    dom: "lfrtip",
    destroy: true, //Elimina cualquier elemente que se encuentre en la tabla
    ajax: {
      url: "../controladores/profesion.php?op=listar",
      type: "GET",
      dataType: "json",
    },
    order: [[0, "desc"]],
  });
}

//Función para mostrar un registro para editar
function mostrar(idprofesion) {
  $.post(
    "../controladores/profesion.php?op=mostrar",
    { idprofesion: idprofesion },
    function (data) {
      data = JSON.parse(data);

      $("#profesion").val(data.profesion);
      $("#estatus").val(data.estatus);
      $("#estatus").selectpicker("refresh");
      $("#idprofesion").val(data.id);
    }
  );
}

//Función para desactivar
function desactivar(idprofesion) {
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-primary  mx-1 p-2",
      cancelButton: "btn btn-danger  mx-1 p-2",
    },
    buttonsStyling: false,
  });

  swalWithBootstrapButtons
    .fire({
      title: "¿Estas seguro?",
      text: "¿Quieres desactivar esta profesión?",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Desactivar",
      cancelButtonText: "Cancelar",
      reverseButtons: true,
    })
    .then((result) => {
      if (result.value) {
        $.post(
          "../controladores/profesion.php?op=desactivar",
          { idprofesion: idprofesion },
          function (e) {
            if (e == "true") {
              const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
              });

              Toast.fire({
                type: "success",
                title: "La profesión ha sido desactivada :)",
              });
            } else {
              const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
              });

              Toast.fire({
                type: "error",
                title: "Ups! No se pudo desactivar la profesión",
              });
            }
            tabla.ajax.reload();
          }
        );
      }
    });
}

//Función para activar
function activar(idprofesion) {
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-primary  mx-1 p-2",
      cancelButton: "btn btn-danger  mx-1 p-2",
    },
    buttonsStyling: false,
  });

  swalWithBootstrapButtons
    .fire({
      title: "¿Estas seguro?",
      text: "¿Quieres activar esta profesión?",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Activar",
      cancelButtonText: "Cancelar",
      reverseButtons: true,
    })
    .then((result) => {
      if (result.value) {
        $.post(
          "../controladores/profesion.php?op=activar",
          { idprofesion: idprofesion },
          function (e) {
            if (e == "true") {
              const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
              });

              Toast.fire({
                type: "success",
                title: "La profesión ha sido activada :)",
              });
            } else {
              const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
              });

              Toast.fire({
                type: "error",
                title: "Ups! No se pudo activar la profesión",
              });
            }
            tabla.ajax.reload();
          }
        );
      }
    });
}

//Función para limpiar el formulario
function limpiar() {
  $("#profesion").val("");
  $("#profesion").removeClass("is-invalid");
  $("#estatus").val("");
  $("#estatus").removeClass("is-invalid");
  $("#estatus").selectpicker("refresh");
  $("#idprofesion").val("");
  $("#formularioregistros").removeClass("was-validated");
}

init();
