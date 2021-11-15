//Funcion que se ejecutará al inicio

function init() {
  //Muestra la lista de estudiantes
  listar();

  tabla.ajax.reload();

  $("#modalestudiante").on("hidden.bs.modal", function () {
    $(this).find(".nav-tabs a:first").tab("show");
  });
}

//Comprueba que la persona no esté registrada
function comprobarPadres(data) {
  if (data == "madre") {
    var documento = $("#documento_madre")[0].value;
    var cedula = $("#cedula_madre")[0].value;

    if (documento == "venezolano") {
      documento = "V-";
    } else if (documento == "extranjero") {
      documento = "E-";
    } else if (documento == "pasaporte") {
      documento = "P-";
    }

    cedula_madre = documento + cedula;

    $.ajax({
      url: "../../controladores/representado.php?op=comprobarpadres",
      type: "POST",
      data: { comprobarpadres: cedula_madre, generopadres: "F" },
      success: function (datos) {
        if (datos != "null") {
          datos = JSON.parse(datos);
          $("#alertaMadre").remove();
          $("#cedula_madre").removeClass("is-invalid");
          $("#cedula_madre").after(
            '<div class="alert alert-success col-md-12" role="alert" id="alertaMadre">' +
              datos.p_nombre +
              " " +
              datos.p_apellido +
              "</div>"
          );
          $("#idmadre").val(datos.id);
          crearCedulaEstudiantil();
        } else {
          $("#alertaMadre").remove();
          $("#idmadre").val("");
          $("#cedula_madre").addClass("is-invalid");
          $("#feedback-cedula-madre").html(
            "La cédula no se encuentra registrada"
          );
        }
      },
    });
  } else {
    var documento = $("#documento_padre")[0].value;
    var cedula = $("#cedula_padre")[0].value;

    if (documento == "venezolano") {
      documento = "V-";
    } else if (documento == "extranjero") {
      documento = "E-";
    } else if (documento == "pasaporte") {
      documento = "P-";
    }

    cedula_padre = documento + cedula;

    $.ajax({
      url: "../../controladores/representado.php?op=comprobarpadres",
      type: "POST",
      data: { comprobarpadres: cedula_padre, generopadres: "M" },
      success: function (datos) {
        if (datos != "null") {
          datos = JSON.parse(datos);
          $("#alertaPadre").remove();
          $("#cedula_padre").after(
            '<div class="alert alert-success col-md-12" role="alert" id="alertaPadre">' +
              datos.p_nombre +
              " " +
              datos.p_apellido +
              "</div>"
          );
          $("#idpadre").val(datos.id);
        } else {
          $("#alertaPadre").remove();
          $("#idpadre").val("");
          $("#cedula_padre").addClass("is-invalid");
          $("#feedback-cedula-padre").html(
            "La cédula no se encuentra registrada"
          );
        }
      },
    });
  }
}

//Función para crear la cédula estudiantil
function crearCedulaEstudiantil() {
  if (
    $("#documento")[0].value == "cedula_estudiantil" &&
    $("#f_nac")[0].value != "" &&
    $("#documento_madre")[0].value != "" &&
    $("#cedula_madre")[0].value != ""
  ) {
    if ($("input:radio[name=parto]:checked").val() == "si") {
      var orden_nacimiento = $("#orden")[0].value;
    } else {
      var orden_nacimiento = 1;
    }

    var ano = $("#f_nac")[0].value.substr(2, 2);

    var cedula_estudiantil =
      orden_nacimiento + ano + $("#cedula_madre")[0].value;
    $("#cedula").val("");
    $("#cedula").val(cedula_estudiantil);
  }
}

//Función para mostrar los paises
function paises(idpais = null) {
  if (idpais !== null) {
    $.post(
      "../../controladores/representado.php?op=listarpaises",
      function (data) {
        $("#pais_nacimiento").append(data);
        $("#pais_nacimiento").val(idpais);
        $("#pais_nacimiento").selectpicker("refresh");
      }
    );
  } else {
    $.post(
      "../../controladores/representado.php?op=listarpaises",
      function (data) {
        $("#pais_nacimiento").append(data);
        $("#pais_nacimiento").selectpicker("refresh");

        $("#estado_nacimiento").html('<option value="">Seleccione</option>');
        $("#estado_nacimiento").prop("disabled", true);
        $("#estado_nacimiento").selectpicker("refresh");

        $("#municipio_nacimiento").html('<option value="">Seleccione</option>');
        $("#municipio_nacimiento").prop("disabled", true);
        $("#municipio_nacimiento").selectpicker("refresh");

        $("#parroquia_nacimiento").html('<option value="">Seleccione</option>');
        $("#parroquia_nacimiento").prop("disabled", true);
        $("#parroquia_nacimiento").selectpicker("refresh");
      }
    );
  }
}

//Función para traer los estados
function estados(idpais = null) {
  let estados;
  if (idpais !== null)
    estados = $.post(
      "../../controladores/representado.php?op=listarestados&idpais=" + idpais
    );
  else
    estados = $.post("../../controladores/representado.php?op=listarestados");

  return estados;
}

//Función para mostrar los municipios
function municipios(idestado) {
  let municipios;
  if (idestado !== null)
    municipios = $.post(
      "../../controladores/representado.php?op=listarmunicipios&idestado=" +
        idestado
    );
  else
    municipios = $.post(
      "../../controladores/representado.php?op=listarmunicipios"
    );

  return municipios;
}

//Función para mostrar las parroquias
function parroquias(idmunicipio) {
  let parroquias;
  if (idmunicipio !== null)
    parroquias = $.post(
      "../../controladores/representado.php?op=listarparroquias&idmunicipio=" +
        idmunicipio
    );
  else
    parroquias = $.post(
      "../../controladores/representado.php?op=listarparroquias"
    );

  return parroquias;
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
      url: "../../controladores/representado.php?op=listar",
      type: "GET",
      dataType: "json",
    },
    order: [[0, "desc"]],
  });
}

//Función para mostrar los datos de un estidiante
function mostrar(idestudiante) {
  $.post(
    "../../controladores/representado.php?op=mostrar",
    { idestudiante: idestudiante },
    function (data) {
      data = JSON.parse(data);

      limpiar();

      paises(data.estudiante.idpaisnacimiento);

      var idestadoresidencia = data.estudiante.idestadoresidencia;
      let estadoResidencia = estados();
      estadoResidencia.then(function (r) {
        $("#estado_residencia").html('<option value="">Seleccione</option>');
        $("#estado_residencia").append(r);
        $("#estado_residencia").selectpicker("val", idestadoresidencia);
      });

      var documento = data.estudiante.cedula.slice(0, 2);
      var cedula = data.estudiante.cedula.slice(2);

      if (documento == "V-") {
        documento = "venezolano";
      } else if (documento == "E-") {
        documento = "extranjero";
      } else {
        var documento = data.estudiante.cedula.slice(0, 3);
        if (documento == "CE-") {
          documento = "cedula_estudiantil";
          var cedula = data.estudiante.cedula.slice(3);
        }
      }

      $("#documento").val(documento);
      $("#documento").selectpicker("refresh");
      $("#idrepresentante").val(data.estudiante.idrepresentante);
      $("#cedula").val(cedula);
      $("#p_nombre").val(data.estudiante.p_nombre);
      $("#s_nombre").val(data.estudiante.s_nombre);
      $("#p_apellido").val(data.estudiante.p_apellido);
      $("#s_apellido").val(data.estudiante.s_apellido);
      $("#genero").val(data.estudiante.genero);
      $("#genero").selectpicker("refresh");
      $("#f_nac").val(data.estudiante.f_nac);

      if (data.estudiante.parto_multiple == "si") {
        $("#partoSi").attr("checked", true);
        $("#orden").prop("disabled", false);
      } else {
        $("#partoNo").attr("checked", true);
      }

      $("#orden").val(data.estudiante.orden_nacimiento);

      $("#estado_nacimiento").html(
        '<option value="' +
          data.estudiante.idestadonacimiento +
          '">' +
          data.estudiante.estadonacimiento +
          "</option>"
      );
      $("#estado_nacimiento").prop("disabled", false);
      $("#estado_nacimiento").selectpicker("refresh");
      $("#municipio_nacimiento").html(
        '<option value="' +
          data.estudiante.idmunicipionacimiento +
          '">' +
          data.estudiante.municipionacimiento +
          "</option>"
      );
      $("#municipio_nacimiento").prop("disabled", false);
      $("#municipio_nacimiento").selectpicker("refresh");
      $("#parroquia_nacimiento").html(
        '<option value="' +
          data.estudiante.idparroquianacimiento +
          '">' +
          data.estudiante.parroquianacimiento +
          "</option>"
      );
      $("#parroquia_nacimiento").prop("disabled", false);
      $("#parroquia_nacimiento").selectpicker("refresh");

      $("#municipio_residencia").html(
        '<option value="' +
          data.estudiante.idmunicipioresidencia +
          '">' +
          data.estudiante.municipioresidencia +
          "</option>"
      );
      $("#municipio_residencia").prop("disabled", false);
      $("#municipio_residencia").selectpicker("refresh");
      $("#parroquia_residencia").html(
        '<option value="' +
          data.estudiante.idparroquiaresidencia +
          '">' +
          data.estudiante.parroquiaresidencia +
          "</option>"
      );
      $("#parroquia_residencia").prop("disabled", false);
      $("#parroquia_residencia").selectpicker("refresh");
      $("#direccion").val(data.estudiante.direccion);

      var documento_madre = data.estudiante.cedulaM.slice(0, 2);
      var cedula_madre = data.estudiante.cedulaM.slice(2);

      if (documento_madre == "V-") {
        documento = "venezolano";
      } else if (documento_madre == "E-") {
        documento = "extranjero";
      } else if (documento_madre == "P-") {
        documento = "pasaporte";
      }

      $("#documento_madre").val(documento);
      $("#documento_madre").selectpicker("refresh");
      $("#cedula_madre").val(cedula_madre);

      if (data.estudiante.cedulaP != null) {
        var documento_padre = data.estudiante.cedulaP.slice(0, 2);
        var cedula_padre = data.estudiante.cedulaP.slice(2);

        if (documento_padre == "V-") {
          documento = "venezolano";
        } else if (documento_padre == "E-") {
          documento = "extranjero";
        } else if (documento_padre == "P-") {
          documento = "pasaporte";
        }

        $("#documento_padre").val(documento);
        $("#documento_padre").selectpicker("refresh");
        $("#cedula_padre").val(cedula_padre);
      }

      var tipo_vivienda = data.estudiante.tipo_vivienda;
      $("#" + tipo_vivienda).attr("checked", true);

      //Muestra los que sostienen el hogar
      if (data.estudiante.sostenes != null) {
        sosten = data.estudiante.sostenes.split(",");
        numeroSosten = $(".sosten").length;
        for (var i = 0; i < numeroSosten; i++) {
          if (jQuery.inArray($(".sosten")[i].value, sosten) != -1) {
            $(".sosten")[i].checked = "true";
          }
        }
      }

      $("#grupo_familiar").val(data.estudiante.grupo_familiar);
      $("#ingreso_mensual").val(data.estudiante.ingreso_mensual);

      if (data.estudiante.posee_canaima == "si") {
        $("#canaimaSi").attr("checked", true);
        $("#condicion_canaima").prop("disabled", false);
      } else {
        $("#canaimaNo").attr("checked", true);
      }

      $("#condicion_canaima").val(data.estudiante.condicion);

      $("#idestudiante").val(data.estudiante.id);

      // var data = 'padre';
      comprobarPadres("padre");
      // var data = 'madre';
      comprobarPadres("madre");

      var listTab = "";
      var tabContent = "";
      $.each();
      let activeId = "";
      data.inscripciones.forEach(function (element, index) {
        var active = element.estatus === "CURSANDO" ? " active" : "";

        if (element.estatus === "CURSANDO") {
          activeId = index;
        }

        listTab +=
          '<a class="list-group-item list-group-item-action" id="list-' +
          index +
          '-list" data-toggle="tab" href="#list-' +
          index +
          '" role="tab" aria-controls="list-' +
          index +
          '" aria-selected="true">' +
          element.grado +
          'º - "' +
          element.seccion +
          '" - ' +
          element.estatus +
          "</a>";

        tabContent +=
          '<div class="tab-pane fade" id="list-' +
          index +
          '" role="tabpanel" aria-labelledby="list-' +
          index +
          '-list">' +
          '<div class="row">';

        element.lapsos.forEach(function (lapso, index) {
          if (lapso.estatus == "Finalizado") {
            tabContent +=
              '<a target="_blank" href="../../reporte/boletin-informativo.php?idplanificacion=' +
              element.idplanificacion +
              "&lapso=" +
              lapso.lapso +
              "&idestudiante=" +
              element.idestudiante +
              '">' +
              '<div class="pdf-card bg-light">' +
              '<div class="icon-wrapper">' +
              '<i class="fa fa-file-pdf"></i>' +
              "</div>" +
              '<div class="project-name">' +
              "<p>Boletín informativo " +
              lapso.lapso +
              "º lapso</p>" +
              "</div>" +
              "</div>" +
              "</a>";
          }
        });

        tabContent += "</div>" + "</div>";
      });

      // <a target="_blank" href="../reporte/boletin-informativo.php?idplanificacion='.$idplanificacion.'&lapso='.$lapso.'&idestudiante='.$idestudiantes.'"> <button class="btn btn-primary" title="Boletín Informativo"><i class="fa fa-file"></i></button></a>

      $("#list-tab").html(listTab);

      $("#nav-tabContent").html(tabContent);

      $("#tabReportes").on("click", function () {
        var list = document.getElementById("list-" + activeId + "-list");
        $(list).tab("show");
      });

      $("#modalestudiante").modal("show");
    }
  );
}

//Función para limpiar el formulario
function limpiar() {
  $("#formularioregistros")[0].reset();
  $("#documento_madre").val("");
  $("#documento_madre").selectpicker("refresh");
  $("#idmadre").val("");
  $("#alertaMadre").remove();
  $("#documento_padre").val("");
  $("#documento_padre").selectpicker("refresh");
  $("#idpadre").val("");
  $("#alertaPadre").remove();
  $("#documento").val("");
  $("#documento").selectpicker("refresh");
  $("#genero").val("");
  $("#genero").selectpicker("refresh");
  $("#icono_genero").removeClass("bg-primary");
  $("#icono_genero").removeClass("bg-danger");
  $('input[name="parto"]').attr("checked", false);
  $("#orden").attr("disabled", true);
  $("#pais_nacimiento").val("");
  $("#pais_nacimiento").selectpicker("refresh");
  $("#estado_nacimiento").html('<option value="">Seleccione</option>');
  $("#estado_nacimiento").prop("disabled", true);
  $("#estado_nacimiento").selectpicker("refresh");
  $("#municipio_nacimiento").html('<option value="">Seleccione</option>');
  $("#municipio_nacimiento").prop("disabled", true);
  $("#municipio_nacimiento").selectpicker("refresh");
  $("#parroquia_nacimiento").html('<option value="">Seleccione</option>');
  $("#parroquia_nacimiento").prop("disabled", true);
  $("#parroquia_nacimiento").selectpicker("refresh");
  $("#estado_residencia").val("");
  $("#estado_residencia").selectpicker("refresh");
  $("#municipio_residencia").html('<option value="">Seleccione</option>');
  $("#municipio_residencia").prop("disabled", true);
  $("#municipio_residencia").selectpicker("refresh");
  $("#parroquia_residencia").html('<option value="">Seleccione</option>');
  $("#parroquia_residencia").prop("disabled", true);
  $("#parroquia_residencia").selectpicker("refresh");
  // $('input[name="vacunas"]').attr('checked', false);
  // $('input[name="alergia"]').attr('checked', false);
  $('input[name="vivienda"]').attr("checked", false);
  $('input[name="canaima"]').attr("checked", false);
  $("#condicion_canaima").prop("disabled", true);
  $("#formularioregistros").removeClass("was-validated");
  $("#cedula_padre").removeClass("is-invalid");
  $("#idestudiante").val("");
}

//Determinar documento
function tipo_documento(documento) {
  if (documento == "venezolano") {
    return "V-";
  } else if (documento == "extranjero") {
    return "E-";
  } else if (documento == "cedula_estudiantil") {
    return "CE-";
  }
}

init();
