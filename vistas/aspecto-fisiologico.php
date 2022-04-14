<?php
#Se activa el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION['idusuario'])) {
  header('location: login.html');
} else {
  define('IMAGE_PATH', dirname((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 2) . '/public/img/');
  require_once 'modules/header.php';
  if (isset($_SESSION['permisos']['aspecto-fisiologico']) && in_array('ver', $_SESSION['permisos']['aspecto-fisiologico'])) {
?>

    <!-- Contenido -->
    <main class="main">
      <div class="animated fadeIn">
        <div class="jumbotron jumbotron-fluid mb-0 fondo-degradado">
        </div>
        <div class="container panel-principal col-sm-12">
          <div class="card border-light mb-3 shadow p-3 mb-5 bg-white rounded ">

            <div class="card-header pt-0 pb-1 bg-white mb-3">
              <!-- Botonera del panel -->
              <div class="row">

                <div class="pl-3 col-md-6 d-flex justify-content-start">
                  <!-- Botón para mostrar modal aspecto fisiologico -->
                  <h1 class="font-weight-normal h5">Aspecto fisiológico

                    <?php
                    if (
                      isset($_SESSION['permisos']['aspecto-fisiologico']) &&
                      in_array('agregar', $_SESSION['permisos']['aspecto-fisiologico'])
                    ) {
                      echo
                      '<button class="btn btn-outline-primary btn-pill shadow-sm" data-toggle="modal" data-target="#aspectoFisiologicoModal" id="btnAgregar">
                    <i class="fa fa-plus-circle"></i> Agregar
                  </button>';
                    }
                    ?>

                  </h1>

                </div>

                <div class="d-flex justify-content-end col-md-5">
                  <p class="h5 font-weight-normal mt-1 mr-2">Planificación</p>
                  <select name="planificaciones_general" id="planificaciones_general" class="form-control selectpicker col-8">

                  </select>

                </div>

                <div id="botonReporte">

                </div>

              </div>

            </div>

            <div class="row" id="listadoregistros">
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table class="table table-borderless table-striped" id="tblistado">
                    <caption>Lista de aspecto fisiológico</caption>
                    <thead class="fondo-degradado text-white">
                      <tr>
                        <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opciones&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th scope="col">Apellidos y nombres</th>
                        <th scope="col">Edad</th>
                        <th scope="col">Sexo</th>
                        <th scope="col">Peso</th>
                        <th scope="col">Talla</th>
                        <th scope="col">¿Todas las vacunas?</th>
                        <th scope="col">¿Alergia Especial?</th>
                        <th scope="col">Diversidad Funcional</th>
                        <th scope="col">C</th>
                        <th scope="col">Alimentos</th>
                        <th scope="col">Útiles</th>
                        <th scope="col">Enfermedades</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <!-- Modal para registrar aspecto fisiológico -->
            <div class="modal fade" id="aspectoFisiologicoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog rounded " role="document">
                <div class="modal-content">

                  <form class="needs-validation" novalidate name="formularioAspectoFisiologico" id="formularioAspectoFisiologico">
                    <!-- Formulario de aspecto fisiológico -->

                    <div class="modal-header fondo-degradado rounded">
                      <h5 class="modal-title text-white" id="tituloModalIndicador">Registrar aspectos fisiológicos </h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                    <div class="modal-body">

                      <div class="row">

                        <!-- guarda el id del aspecto fisiológico cuando es necesario -->
                        <input type="hidden" value="" id="idaspectofisiologico" name="idaspectofisiologico">

                        <div class="form-group col-md-6">
                          <label for="planificacion">Planificación (*)</label>
                          <div class="input-group ">
                            <select name="idplanificacion" id="planificacion" class="form-control selectpicker" required="true">

                            </select>
                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-6">
                          <label for="estudiante">Estudiante (*)</label>
                          <div class="input-group ">
                            <select name="idestudiante" id="estudiante" class="form-control selectpicker" required="true" disabled="true">
                              <option value="">Seleccione</option>
                            </select>
                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-6">
                          <label for="peso">Peso (Kilos)</label>
                          <div class="input-group">

                            <div class="input-group">
                              <input type="text" class="form-control punto_peso solo_numeros" name="peso" id="peso" maxlength="5">

                            </div>

                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-6">
                          <label for="talla">Talla (Metros)</label>
                          <div class="input-group">

                            <div class="input-group">
                              <input type="text" class="form-control talla punto_talla solo_numeros " name="talla" id="talla" maxlength="4">

                            </div>

                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-6">
                          <label for="">¿Todas las vacunas? (*)</label>
                          <div class="input-group">

                            <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="vacunasSi" name="todas_vacunas" class="custom-control-input" required value="1">
                              <label class="custom-control-label" for="vacunasSi">Si</label>
                              <div class="invalid-feedback">
                              </div>
                            </div>



                            <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="vacunasNo" name="todas_vacunas" class="custom-control-input" required value="0">
                              <label class="custom-control-label" for="vacunasNo">No</label>
                              <div class="invalid-feedback">
                              </div>
                            </div>


                          </div>

                          <textarea class="form-control" name="vacunas" id="vacunas" rows="5" placeholder="Ingrese las vacunas"></textarea>
                        </div>

                        <div class="form-group col-md-6">
                          <label for="">¿Alergico? (*)</label>
                          <div class="input-group">

                            <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="alergicoSi" name="alergia" class="custom-control-input" required value="1">
                              <label class="custom-control-label" for="alergicoSi">Si</label>
                              <div class="invalid-feedback">
                              </div>
                            </div>

                            <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="alergicoNo" name="alergia" class="custom-control-input" required value="0">
                              <label class="custom-control-label" for="alergicoNo">No</label>
                              <div class="invalid-feedback">
                              </div>
                            </div>


                          </div>
                          <textarea class="form-control" name="alergias" id="alergias" rows="5" placeholder="Ingrese las alergias"></textarea>
                        </div>

                        <div class="form-group col-md-12">
                          <label for="">¿Diversidad funcional? (*)</label>
                          <div class="input-group">

                            <div id="listaDiversidad">

                            </div>

                            <!-- <div class="custom-control custom-checkbox custom-control-inline">
                          <input type="checkbox" class="custom-control-input diversidad" id="motora" value="motora" name="diversidad[]">
                          <label class="custom-control-label" for="motora">Motora</label>
                        </div>

                        <div class="custom-control custom-checkbox custom-control-inline">
                          <input type="checkbox" class="custom-control-input diversidad" id="autismo" value="autismo" name="diversidad[]">
                          <label class="custom-control-label" for="autismo">Autismo</label>
                        </div>

                        <div class="custom-control custom-checkbox custom-control-inline">
                          <input type="checkbox" class="custom-control-input diversidad" id="asperger" value="asperger" name="diversidad[]">
                          <label class="custom-control-label" for="asperger">Asperger</label>
                        </div> -->

                          </div>
                        </div>

                        <div class="form-group col-md-6">
                          <label for="">C (*)</label>
                          <div class="input-group">

                            <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="cSi" name="c" class="custom-control-input" required value="1">
                              <label class="custom-control-label" for="cSi">Si</label>
                              <div class="invalid-feedback">
                              </div>
                            </div>



                            <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="cNo" name="c" class="custom-control-input" required value="0">
                              <label class="custom-control-label" for="cNo">No</label>
                              <div class="invalid-feedback">
                              </div>
                            </div>


                          </div>
                        </div>

                        <div class="form-group col-md-6">
                          <label for="">Alimentos (*)</label>
                          <div class="input-group">

                            <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="alimentosSi" name="alimentos" class="custom-control-input" required value="1">
                              <label class="custom-control-label" for="alimentosSi">Si</label>
                              <div class="invalid-feedback">
                              </div>
                            </div>



                            <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="alimentosNo" name="alimentos" class="custom-control-input" required value="0">
                              <label class="custom-control-label" for="alimentosNo">No</label>
                              <div class="invalid-feedback">
                              </div>
                            </div>


                          </div>
                          <textarea class="form-control" name="alimentostxt" id="alimentostxt" rows="5" placeholder="Ingrese los alimentos"></textarea>
                        </div>

                        <div class="form-group col-md-6">
                          <label for="">Útiles (*)</label>
                          <div class="input-group">

                            <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="utilesSi" name="utiles" class="custom-control-input" required value="1">
                              <label class="custom-control-label" for="utilesSi">Si</label>
                              <div class="invalid-feedback">
                              </div>
                            </div>



                            <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="utilesNo" name="utiles" class="custom-control-input" required value="0">
                              <label class="custom-control-label" for="utilesNo">No</label>
                              <div class="invalid-feedback">
                              </div>
                            </div>


                          </div>
                          <textarea class="form-control" name="utilestxt" id="utilestxt" rows="5" placeholder="Ingrese los útiles"></textarea>
                        </div>

                        <div class="form-group col-md-12">
                          <label for="">¿Enfermedad? (*)</label>
                          <div class="input-group">

                            <div id="listaEnfermedad">

                            </div>

                            <!-- <div class="custom-control custom-checkbox custom-control-inline">
                              <input type="checkbox" class="custom-control-input enfermedad" id="repiratoria" value="respiratoria" name="enfermedad[]">
                              <label class="custom-control-label" for="repiratoria">Respiratoria</label>
                            </div>

                            <div class="custom-control custom-checkbox custom-control-inline">
                              <input type="checkbox" class="custom-control-input enfermedad" id="renal" value="renal" name="enfermedad[]">
                              <label class="custom-control-label" for="renal">Renal</label>
                            </div>

                            <div class="custom-control custom-checkbox custom-control-inline">
                              <input type="checkbox" class="custom-control-input enfermedad" id="visual" value="visual" name="enfermedad[]">
                              <label class="custom-control-label" for="visual">Visual</label>
                            </div>

                            <div class="custom-control custom-checkbox custom-control-inline">
                              <input type="checkbox" class="custom-control-input enfermedad" id="auditiva" value="auditiva" name="enfermedad[]">
                              <label class="custom-control-label" for="auditiva">Auditiva</label>
                            </div> -->

                          </div>
                        </div>



                      </div> <!-- Fin row -->

                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cancelarform()">Cancelar</button>
                      <button type="submit" id="btnGuardar" class="btn btn-primary">Guardar</button>
                    </div>


                  </form> <!-- Fin del formulario -->
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </main>
    <!-- Fin Contenido -->

  <?php

  } //Cierre del if que determina el acceso
  else {
  ?>
    <script>
      window.onload = function noacceso() {
        Swal.fire({
          type: 'warning',
          title: 'Restringido',
          text: 'Usted no tiene acceso a esta sección',
          showConfirmButton: false,
          allowOutsideClick: false,
          footer: '<a href="escritorio.php">Volver al escritorio</a>'
        })
      }
    </script>

  <?php
  } //cierre del else
  require_once 'modules/footer.php';
  ?>
  <script src="scripts/aspecto-fisiologico.js"></script>

<?php
} //Cierre del else que muestra esta vista
ob_end_flush();
?>