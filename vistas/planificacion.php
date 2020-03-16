<?php
#Se activa el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION['usuario'])) {
  header('location: login.html');
} else {
  require_once 'modules/header.php';
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
                <!-- Botón para mostrar modal planificación -->
                <h1 class="font-weight-normal h5">Planificación
                  <button class="btn btn-outline-primary btn-pill shadow-sm" data-toggle="modal" data-target="#planificacionModal" id="btnAgregar">
                    <i class="fa fa-plus-circle"></i> Agregar
                  </button>
                </h1>
              </div>
              
              <div class="d-flex justify-content-end col-md-6">
                <p class="h5 font-weight-normal mt-1 mr-2">Período escolar</p>
                <select name="periodos" id="periodos" class="form-control selectpicker col-4">

                </select>
              
              </div>

            </div>

          </div>
          
          <div class="row" id="listadoregistros">
            <div class="col-sm-12">
              <div class="table-responsive">
                <table class="table table-borderless table-striped" id="tblistado">
                  <caption>Lista de planificaciones</caption>
                  <thead class="fondo-degradado text-white">
                    <tr>
                      <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opciones&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                      <th scope="col">Grado</th>
                      <th scope="col">Sección</th>
                      <th scope="col">Ambiente</th>
                      <th scope="col">Docente</th>
                      <th scope="col">Cupo</th>
                      <th scope="col">Período Escolar</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Modal para crear planificación -->
          <div class="modal fade" id="planificacionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog rounded modal-xl" role="document">
              <div class="modal-content">

                <form class="needs-validation" novalidate name="formularioPlanificacion" id="formularioregistros">
                  <!-- Formulario de planificación -->

                  <div class="modal-header fondo-degradado rounded">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Crear Planificación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-body">

                    <div class="row">
                      
                      <div class="form-group col-md-2">
                        <label for="periodo_escolar">Período escolar (*)</label>
                        <div class="input-group ">
                          <select name="idperiodo_escolar" id="periodo_escolar" class="form-control selectpicker" required="true">
                            <option value="">Seleccione</option>

                          </select>
                          <div class="invalid-feedback">
                            Campo Obligatorio
                          </div>
                        </div>
                      </div>

                      <!-- guarda el id de la planificación cuando es necesario -->
                      <input type="hidden" value="" id="idplanificacion" name="idplanificacion">
                      <div class="form-group col-md-2">
                        <label for="grado">Grado (*)</label>
                        <div class="input-group ">
                          <select name="idgrado" id="grado" class="form-control selectpicker" required="true">
                            <option value="">Seleccione</option>

                          </select>
                          <div class="invalid-feedback">
                            Campo Obligatorio
                          </div>
                        </div>
                      </div>

                      <div class="form-group col-md-2">
                        <label for="seccion">Sección (*)</label>
                        <div class="input-group ">
                          <select name="idseccion" id="seccion" class="form-control selectpicker" required="true" disabled>
                            <option value="">Seleccione</option>

                          </select>
                          <div class="invalid-feedback">
                            Campo Obligatorio
                          </div>
                        </div>
                      </div>

                      <div class="form-group col-md-2">
                        <label for="ambiente">Ambiente (*)</label>
                        <div class="input-group ">
                          <select name="idambiente" id="ambiente" class="form-control selectpicker" required="true">
                            <option value="">Seleccione</option>

                          </select>
                          <div class="invalid-feedback">
                            Campo Obligatorio
                          </div>
                        </div>
                      </div>

                      <div class="form-group col-md-2">
                        <label for="docente">Docente (*)</label>
                        <div class="input-group ">
                          <select name="iddocente" id="docente" class="form-control selectpicker " required="true" data-live-search="true">
                            <option value="">Seleccione</option>

                          </select>
                          <div class="invalid-feedback">
                            Campo Obligatorio
                          </div>
                        </div>
                      </div>

                      <div class="form-group col-md-2">
                        <label for="cupo">Cupo (*)</label>
                        <div class="input-group">

                          <input type="text" class="form-control solo_numeros" placeholder="Ej: 30" name="cupo" id="cupo" maxlength="2" required>

                          <div class="invalid-feedback">
                            Campo Obligatorio
                          </div>
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

    require_once 'modules/footer.php';
    ?>
  <script src="scripts/planificacion.js"></script>

<?php
} //Cierre del else que muestra esta vista
ob_end_flush();
?>