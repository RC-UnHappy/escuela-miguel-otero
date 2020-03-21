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
                <!-- Botón para mostrar modal gestionar indicadores -->
                <h1 class="font-weight-normal h5">Gestionar indicador
                  <button class="btn btn-outline-primary btn-pill shadow-sm" data-toggle="modal" data-target="#gestionarIndicadoresModal" id="btnAgregar">
                    <i class="fa fa-plus-circle"></i> Agregar
                  </button>
                </h1>

                <!-- Botón para mostrar modal proyecto aprendizaje -->
                <h1 class="font-weight-normal h5 pl-3">Proyecto aprendizaje
                  <button class="btn btn-outline-danger btn-pill shadow-sm" data-toggle="modal" data-target="#proyectoAprendizajeModal" id="btnAgregarProyectoAprendizaje">
                    <i class="fa fa-plus-circle"></i> Agregar
                  </button>
                </h1>
              </div>
              
              <div class="d-flex justify-content-end col-md-4">
                <p class="h5 font-weight-normal mt-1 mr-0">Planificación</p>
                <select name="periodos" id="periodos" class="form-control selectpicker col-8">

                </select>
              
              </div>

              <div class="d-flex justify-content-end col-md-2">
                <p class="h5 font-weight-normal mt-1 mr-2">Lapso</p>
                <select name="lapsos" id="lapsos" class="form-control selectpicker col-8">

                </select>
              
              </div>
              
            </div>

          </div>
          
          <div class="row" id="listadoregistros">
            <div class="col-sm-12">
              <div class="table-responsive">
                <table class="table table-borderless table-striped" id="tblistado">
                  <caption>Lista de indicadores</caption>
                  <thead class="fondo-degradado text-white">
                    <tr>
                      <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opciones&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                      <th scope="col">Grado</th>
                      <th scope="col">Sección</th>
                      <th scope="col">Ambiente</th>
                      <th scope="col">Docente</th>
                      <th scope="col">Cupo</th>
                      <th scope="col">Período Escolar</th>
                      <th scope="col">Estatus</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Modal para crear planificación -->
          <div class="modal fade" id="gestionarIndicadoresModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog rounded modal-xl" role="document">
              <div class="modal-content">

                <form class="needs-validation" novalidate name="formularioPlanificacion" id="formularioregistros">
                  <!-- Formulario de planificación -->

                  <div class="modal-header fondo-degradado rounded">
                    <h5 class="modal-title text-white" id="tituloModal">Crear planificación</h5>
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

          <!-- Modal para crear proyecto aprendizaje -->
          <div class="modal fade" id="proyectoAprendizajeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog rounded modal-lg" role="document">
              <div class="modal-content">

                <form class="needs-validation" novalidate name="formularioProyectoAprendizaje" id="formularioProyectoAprendizaje">
                  <!-- Formulario de proyecto aprendizaje -->

                  <div class="modal-header fondo-degradado rounded">
                    <h5 class="modal-title text-white" id="tituloModal">Crear proyecto aprendizaje</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-body">

                    <div class="row">
                      
                      <div class="form-group col-md-4">
                        <label for="planificacion">Planificación (*)</label>
                        <div class="input-group ">
                          <select name="idplanificacion" id="planificacion" class="form-control selectpicker" required="true">

                          </select>
                          <div class="invalid-feedback">
                            Campo Obligatorio
                          </div>
                        </div>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="lapso">Lapso (*)</label>
                        <div class="input-group ">
                          <select name="lapso" id="lapso" class="form-control selectpicker" required="true" disabled>
                            <option value="">Seleccione</option>
                          </select>
                          <div class="invalid-feedback">
                            Campo Obligatorio
                          </div>
                        </div>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="proyecto_aprendizaje">Proyecto aprendizaje (*)</label>
                        <div class="input-group">

                          <input type="text" class="form-control" name="proyecto_aprendizaje" id="proyecto_aprendizaje" required>

                          <div class="invalid-feedback">
                            Campo Obligatorio
                          </div>
                        </div>
                      </div>

                    </div> <!-- Fin row -->

                    <div class="row" id="listadoproyectoaprendizaje">
                      <div class="col-sm-12">
                        <div class="table-responsive ">
                          <table class="table table-borderless table-striped w-100" id="tblistadoproyectoaprendizaje">
                            <caption>Lista de proyectos</caption>
                            <thead class="fondo-degradado text-white">
                              <tr >
                                <th scope="col" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opciones&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                <th scope="col" >Lapso</th>
                                <th scope="col" >Proyecto</th>
                              </tr>
                            </thead>
                            <tbody>

                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cancelarFormProyectoAprendizaje()">Cancelar</button>
                    <button type="submit" id="btnGuardarProyectoAprendizaje" class="btn btn-primary">Guardar</button>
                  </div>

                </form> <!-- Fin del formulario -->
              </div>
            </div>
          </div>

          <!-- Modal para editar proyecto aprendizaje -->
          <div class="modal fade" id="editarProyectoAprendizajeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog rounded modal-lg" role="document">
              <div class="modal-content">

                <form class="needs-validation" novalidate name="formularioEditarProyectoAprendizaje" id="formularioEditarProyectoAprendizaje">
                  <!-- Formulario de proyecto aprendizaje -->

                  <div class="modal-header fondo-degradado rounded">
                    <h5 class="modal-title text-white" id="tituloEditarProyectoAprendizajeModal">Editar proyecto aprendizaje</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-body">

                    <div class="row">
                      <!-- guarda el id del proyecto de aprendizaje cuando es necesario -->
                      <input type="hidden" value="" id="idproyecto_aprendizaje" name="idproyecto_aprendizaje">
                      
                      <div class="form-group col-md-4">
                        <label for="editar_planificacion">Planificación (*)</label>
                        <div class="input-group ">
                          <select name="ideditar_planificacion" id="editar_planificacion" class="form-control selectpicker" required="true">

                          </select>
                          <div class="invalid-feedback">
                            Campo Obligatorio
                          </div>
                        </div>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="editar_lapso">Lapso (*)</label>
                        <div class="input-group ">
                          <select name="editar_lapso" id="editar_lapso" class="form-control selectpicker" required="true" disabled>
                            <option value="">Seleccione</option>
                          </select>
                          <div class="invalid-feedback">
                            Campo Obligatorio
                          </div>
                        </div>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="editar_proyecto_aprendizaje">Proyecto aprendizaje (*)</label>
                        <div class="input-group">

                          <input type="text" class="form-control" name="editar_proyecto_aprendizaje" id="editar_proyecto_aprendizaje" required>

                          <div class="invalid-feedback">
                            Campo Obligatorio
                          </div>
                        </div>
                      </div>

                    </div> <!-- Fin row -->

                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btnEditarProyectoAprendizaje" class="btn btn-primary">Guardar</button>
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
  <script src="scripts/gestionar-indicador.js"></script>

<?php
} //Cierre del else que muestra esta vista
ob_end_flush();
?>