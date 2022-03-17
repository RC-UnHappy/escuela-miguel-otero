<?php
#Se activa el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION['idusuario'])) {
  header('location: login.html');
} else {
  define('IMAGE_PATH', dirname((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 2) . '/public/img/');
  require_once 'modules/header.php';
  if (isset($_SESSION['permisos']['institucion']) && in_array('ver', $_SESSION['permisos']['institucion'])) {
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

              <h1 class="font-weight-normal h5">Institución

                <?php
                if (
                  isset($_SESSION['permisos']['institucion']) &&
                  in_array('editar', $_SESSION['permisos']['institucion'])
                ) {
                  echo
                  '<button class="btn btn-outline-primary btn-pill shadow-sm" onclick="mostrar();" id="btneditar">
                  <i class="fa fa-plus-circle"></i> Editar
                 </button>';
                }
                ?>

              </h1>
            </div>

            <div class="row" id="datosInstitucion">
              <!-- <div class="col-sm-12" > -->
              <!-- <div class="jumbotron bg-indigo  w-100">    
                
              <i class="fas fa-school text-white" style="font-size: 100px;"></i>
              <small class="text-white display-4 ml-3 text-center">Datos de la Institución</small>
                  
              <hr class="my-1 bg-white">
            </div>
 -->
              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-warning ">
                  <strong class="text-warning">Nombre de la Institución:</strong><br>
                  <p class="ml-2 " id="mostrarNombre"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-warning ">
                  <strong class="text-warning">Estado:</strong><br>
                  <p class="ml-2" id="mostrarEstado"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-warning ">
                  <strong class="text-warning">Municipio:</strong><br>
                  <p class="ml-2" id="mostrarMunicipio"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-primary ">
                  <strong class="text-primary">Parroquia:</strong><br>
                  <p class="ml-2" id="mostrarParroquia"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-primary ">
                  <strong class="text-primary">Dirección:</strong><br>
                  <p class="ml-2" id="mostrarDireccion"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-primary ">
                  <strong class="text-primary">Teléfono:</strong><br>
                  <p class="ml-2" id="mostrarTelefono"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-danger ">
                  <strong class="text-danger">Correo:</strong><br>
                  <p class="ml-2" id="mostrarCorreo"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-danger ">
                  <strong class="text-danger">Dependencia:</strong><br>
                  <p class="ml-2" id="mostrarDependencia"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-danger ">
                  <strong class="text-danger">Código DEA:</strong><br>
                  <p class="ml-2" id="mostrarCodDea"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-warning ">
                  <strong class="text-warning">Código Estadístico:</strong><br>
                  <p class="ml-2" id="mostrarCodEstadistico"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-warning ">
                  <strong class="text-warning">Código de Dependencia:</strong><br>
                  <p class="ml-2" id="mostrarCodDependencia"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-warning ">
                  <strong class="text-warning">Código Electoral:</strong><br>
                  <p class="ml-2" id="mostrarCodElectoral"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-primary ">
                  <strong class="text-primary">Fecha de Fundación:</strong><br>
                  <p class="ml-2" id="mostrarFechaFundada"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-primary ">
                  <strong class="text-primary">Fundada como Bolivariana:</strong><br>
                  <p class="ml-2" id="mostrarFechaBolivariana"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-primary ">
                  <strong class="text-primary">Clase de Plantel:</strong><br>
                  <p class="ml-2" id="mostrarClase"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-danger ">
                  <strong class="text-danger">Categoría:</strong><br>
                  <p class="ml-2" id="mostrarCategoria"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-danger ">
                  <strong class="text-danger">Condición de Estudio:</strong><br>
                  <p class="ml-2" id="mostrarCondicion"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-danger ">
                  <strong class="text-danger">Tipo de Matrícula:</strong><br>
                  <p class="ml-2" id="mostrarTipoMatricula"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-warning ">
                  <strong class="text-warning">Turno:</strong><br>
                  <p class="ml-2" id="mostrarTurno"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-warning ">
                  <strong class="text-warning">Horario:</strong><br>
                  <p class="ml-2" id="mostrarHorario"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-warning ">
                  <strong class="text-warning">Matricula Estudiantes:</strong><br>
                  <p class="ml-2" id="mostrarMatricula"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-primary ">
                  <strong class="text-primary">Cantidad de Ambientes:</strong><br>
                  <p class="ml-2" id="mostrarAmbientes"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-primary ">
                  <strong class="text-primary">Cantidad de Docentes de Aula:</strong><br>
                  <p class="ml-2" id="mostrarDocentes"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-primary ">
                  <strong class="text-primary">Cantidad de Docentes Especialistas:</strong><br>
                  <p class="ml-2" id="mostrarEspecialistas"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-danger ">
                  <strong class="text-danger">Cantidad de Personal Administrativo:</strong><br>
                  <p class="ml-2" id="mostrarAdministrativos"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-danger ">
                  <strong class="text-danger">Cantidad de Obreros:</strong><br>
                  <p class="ml-2" id="mostrarObreros"></p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="h-75 shadow-sm callout  callout-danger ">
                  <strong class="text-danger">Cantidad de Vigilantes:</strong><br>
                  <p class="ml-2" id="mostrarVigilantes"></p>
                </div>
              </div>

            </div>

            <form class="needs-validation" novalidate name="institucion" id="formularioregistros">
              <!-- Formulario de institucion -->
              <div class="row">

                <div class="col-sm-12">
                  <div class="card border-right-0 border-bottom-0 border-left-0  border-top-0 shadow mb-5 bg-white rounded">
                    <div class="card-header bg-white  shadow border-bottom-0 fondo-degradado">
                      <h5 class="m-0 p-0  font-italic font-weight-bold text-white"><i class="fas fa-school"></i> Datos de la Institución
                        <small class="text-dark">(Requerido)</small>
                      </h5>
                    </div>
                    <div class="card-body">

                      <div class="row">

                        <div class="form-group col-md-6">
                          <label for="nombre">Nombre de la Institución (*)</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                <i class="fas fa-school"></i>
                              </div>
                            </div>
                            <input type="hidden" name="idinstitucion" id="idinstitucion"> <!-- Input oculto que guardará el id de la institución cuando sea necesario -->

                            <input type="text" class="form-control" name="nombre" id="nombre" required>

                            <div class="invalid-feedback" id="mensajenombre">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-6">
                          <label for="correo">Correo Electrónico (*)</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                <i class="far fa-envelope"></i>
                              </div>
                            </div>
                            <input type="email" name="correo" id="correo" class="form-control" required>
                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-3">
                          <label for="telefono">Teléfono (*)</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                <i class="fas fa-mobile-alt"></i>
                              </div>
                            </div>
                            <input type="text" name="telefono" id="telefono" class="form-control solo_numeros guion_telefonico" maxlength="12">
                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-3">
                          <label for="dependencia">Dependencia (*)</label>
                          <div class="input-group">
                            <input type="text" class="form-control" name="dependencia" id="dependencia" required>
                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-3">
                          <label for="cod_dea">Código DEA (*)</label>
                          <div class="input-group">
                            <input type="text" class="form-control" name="cod_dea" id="cod_dea" required>
                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-3">
                          <label for="cod_estadistico">Código Estadístico (*)</label>
                          <div class="input-group">
                            <input type="text" class="form-control" name="cod_estadistico" id="cod_estadistico" required>
                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-3">
                          <label for="cod_dependencia">Código Dependencia (*)</label>
                          <div class="input-group">
                            <input type="text" class="form-control" name="cod_dependencia" id="cod_dependencia" required>
                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-3">
                          <label for="cod_electoral">Código Electoral</label>
                          <div class="input-group">
                            <input type="text" class="form-control" name="cod_electoral" id="cod_electoral">
                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-6">
                          <label for="cod_smee">Código SMEE</label>
                          <div class="input-group">
                            <input type="text" class="form-control" name="cod_smee" id="cod_smee">
                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-3">
                          <label for="idestado">Estado (*)</label>
                          <div class="input-group">
                            <select id="estado" name="idestado" class="form-control selectpicker" required>
                              <option value="">Seleccione</option>

                            </select>
                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-3">
                          <label for="idmunicipio">Municipio (*)</label>
                          <div class="input-group">
                            <select id="municipio" name="idmunicipio" class="form-control selectpicker" required disabled>
                              <option value="">Seleccione</option>

                            </select>
                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-3">
                          <label for="idparroquia">Parroquia (*)</label>
                          <div class="input-group">
                            <select id="parroquia" name="idparroquia" class="form-control selectpicker" required disabled>
                              <option value="">Seleccione</option>

                            </select>
                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-3">
                          <label for="direccion">Dirección (*)</label>
                          <div class="input-group">
                            <input type="text" name="direccion" id="direccion" class="form-control" required>
                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-3">
                          <label for="fecha_fundada">Fecha de Fundación (*)</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                <i class="fas fa-calendar-alt"></i>
                              </div>
                            </div>
                            <input type="date" name="fecha_fundada" id="fecha_fundada" class="form-control" required>
                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-3">
                          <label for="fecha_bolivariana">Fecha de Fundadción como Bolivariana </label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                <i class="fas fa-calendar-alt"></i>
                              </div>
                            </div>
                            <input type="date" name="fecha_bolivariana" id="fecha_bolivariana" class="form-control" required>
                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-3">
                          <label for="clase_plantel">Clase de Plantel (*)</label>
                          <div class="input-group">
                            <input type="text" name="clase_plantel" id="clase_plantel" class="form-control" required>
                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-3">
                          <label for="categoria">Categoría (*)</label>
                          <div class="input-group">
                            <input type="text" name="categoria" id="categoria" class="form-control" required>
                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-3">
                          <label for="condicion_estudio">Condición de Estudio (*)</label>
                          <div class="input-group">
                            <input type="text" name="condicion_estudio" id="condicion_estudio" class="form-control" required>
                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-3">
                          <label for="tipo_matricula">Tipo de Matrícula (*)</label>
                          <div class="input-group">
                            <input type="text" name="tipo_matricula" id="tipo_matricula" class="form-control" required>
                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-3">
                          <label for="turno">Turno (*)</label>
                          <div class="input-group">
                            <input type="text" name="turno" id="turno" class="form-control" required>
                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-3">
                          <label for="horario">Horario (*)</label>
                          <div class="input-group">
                            <input type="text" name="horario" id="horario" class="form-control" required>
                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-12">
                          <label for="codigo_qr">Datos para el código QR</label>
                          <div class="input-group">
                            <input type="text" name="codigo_qr" id="codigo_qr" class="form-control" required>
                            <div class="invalid-feedback">
                              Campo Obligatorio
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>

                <div class="container">
                  <div class="row d-flex justify-content-end pr-3">
                    <button class="btn btn-outline-danger btn-pill m-1 shadow-sm" type="button" onclick="cancelarform()"><i class="fas fa-times "></i> Cancelar</button>
                    <button class="btn btn-outline-success btn-pill btn-lg m-1 shadow-sm" type="submit" id="btnGuardar"><i class="fas fa-check"></i> Registrar</button>
                  </div>
                </div>

              </div> <!-- Fin row -->
            </form> <!-- Fin del formulario -->

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
  <script src="scripts/institucion.js"></script>
<?php
} //Cierre del else que muestra esta vista
ob_end_flush();
?>