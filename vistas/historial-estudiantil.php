<?php
#Se activa el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION['idusuario'])) {
  header('location: login.html');
} else {
require_once 'modules/header.php';
if (isset($_SESSION['permisos']['historial-estudiantil']) && in_array('ver' , $_SESSION['permisos']['historial-estudiantil'])) {
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

            <div class="pl-3 col-md-4 d-flex justify-content-start">
              <!-- Botón para mostrar modal historial estudiantil -->
              <h1 class="font-weight-normal h5">Historial estudiantil
                <button class="btn btn-outline-primary btn-pill shadow-sm" data-toggle="modal" data-target="#historialEstudiantilModal" id="btnAgregar">
                  <i class="fa fa-plus-circle"></i> Agregar
                </button>
              </h1>

            </div>
            
            <div class="d-flex justify-content-end col-md-3">
              <p class="h5 font-weight-normal mt-1 mr-2">Planificación</p>
              <select name="planificaciones_general" id="planificaciones_general" class="form-control selectpicker col-8">

              </select>
            
            </div>

            <div class="d-flex justify-content-end col-md-2">
              <p class="h5 font-weight-normal mt-1 mr-2">Lapso</p>
              <select name="lapsos_general" id="lapsos_general" class="form-control selectpicker col-8" disabled>

              </select>
            
            </div>

            <div class="d-flex justify-content-end col-md-3">
              <p class="h5 font-weight-normal mt-1 mr-2">Estudiante</p>
              <select name="estudiantes_general" id="estudiantes_general" class="form-control selectpicker col-8" disabled>
                <option value="">Seleccione</option>
              </select>
            
            </div>
            
          </div>

        </div>
        
        <div class="row" id="listadoregistros">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-borderless table-striped" id="tblistado">
                <caption>Lista de historial estudiantil</caption>
                <thead class="fondo-degradado text-white">
                  <tr>
                  <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opciones&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th scope="col">Materia</th>
                    <th scope="col">Indicador</th>
                    <th scope="col">Nota</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Modal para crear historial estudiantil -->
        <div class="modal fade" id="historialEstudiantilModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog rounded modal-xl" role="document">
            <div class="modal-content">

              <form class="needs-validation" novalidate name="formularioHistorialEstudiantil" id="formularioHistorialEstudiantil">
                <!-- Formulario de indicador -->

                <div class="modal-header fondo-degradado rounded">
                  <h5 class="modal-title text-white" id="tituloModalIndicador">Registrar historial estudiantil </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body">

                  <div class="row">

                    <!-- guarda el id del historial estudiantil cuando es necesario -->
                    <!-- <input type="hidden" value="" id="idhistorialestudiantil" name="idhistorialestudiantil"> -->

                    <div class="form-group col-md-3">
                      <label for="periodo_escolar">Período escolar (*)</label>
                      <div class="input-group ">
                        <select name="periodo_escolar" id="periodo_escolar" class="form-control selectpicker" required="true" readonly>
                          <option value="">Seleccione</option>
                        </select>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>
                    
                    <div class="form-group col-md-3">
                      <label for="turno">Turno (*)</label>
                      <div class="input-group">
                        <input type="text" class="form-control" name="turno" id="turno" >
                        <div class="invalid-feedback">
                            Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="grado">Grado (*)</label>
                      <div class="input-group">
                        <input type="text" class="form-control solo_numeros" name="grado" id="grado" placeholder="Ej: 4" maxlength="1">
                        <div class="invalid-feedback">
                            Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="seccion">Sección (*)</label>
                      <div class="input-group">
                        <input type="text" class="form-control solo_letras text-uppercase" name="seccion" id="seccion" placeholder="Ej: B" maxlength="1">
                        <div class="invalid-feedback">
                            Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="documento_docente">Cédula del docente</label>
                      <div class="input-group ">
                        <div class="input-group-prepend">
                          <select name="documento_docente" id="documento_docente" class="form-control selectpicker">
                            <option value="">Seleccione</option>
                            <option value="V-">V-</option>
                            <option value="E-">E-</option>
                            <option value="P-">P-</option>
                          </select>
                        </div>

                        <input type="text" class="form-control solo_numeros" placeholder="Ej: 12345678" name="cedula_docente" id="cedula_docente" maxlength="8" minlength="7">

                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="nombre_docente">Nombre del docente (*)</label>
                      <div class="input-group">
                        <input type="text" class="form-control solo_letras" name="nombre_docente" id="nombre_docente" required>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="apellido_docente">Apellido del docente (*)</label>
                      <div class="input-group">
                        <input type="text" class="form-control solo_letras" name="apellido_docente" id="apellido_docente" required>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="documento_estudiante">Cédula del estudiante</label>
                      <div class="input-group ">
                        <div class="input-group-prepend">
                          <select name="documento_estudiante" id="documento_estudiante" class="form-control selectpicker">
                            <option value="">Seleccione</option>
                            <option value="V-">V-</option>
                            <option value="E-">E-</option>
                            <option value="CE-">CE-</option>
                          </select>
                        </div>

                        <input type="text" class="form-control solo_numeros" placeholder="Ej: 12345678" name="cedula_estudiante" id="cedula_estudiante" maxlength="8" minlength="7">

                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="p_nombre_estudiante">Primer nombre del estudiante (*)</label>
                      <div class="input-group">
                        <input type="text" class="form-control solo_letras" name="p_nombre_estudiante" id="p_nombre_estudiante" required>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="s_nombre_estudiante">Segundo nombre del estudiante</label>
                      <div class="input-group">
                        <input type="text" class="form-control solo_letras" name="s_nombre_estudiante" id="s_nombre_estudiante">
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="p_apellido_estudiante">Primer apellido del estudiante (*)</label>
                      <div class="input-group">
                        <input type="text" class="form-control solo_letras" name="p_apellido_estudiante" id="p_apellido_estudiante" required>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="s_apellido_estudiante">Segundo apellido del estudiante</label>
                      <div class="input-group">
                        <input type="text" class="form-control solo_letras" name="s_apellido_estudiante" id="s_apellido_estudiante" >
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="fecha_nacimiento_estudiante">Fecha de nacimiento del estudiante (*)</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-calendar-alt"></i>
                          </div>
                        </div>
                        <input type="date" name="fecha_nacimiento_estudiante" id="fecha_nacimiento_estudiante" class="form-control" required>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="lugar_nacimiento_estudiante">Lugar de nacimiento del estudiante (*)</label>
                      <div class="input-group">
                        <input type="text" class="form-control " name="lugar_nacimiento_estudiante" id="lugar_nacimiento_estudiante" required>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="sexo_estudiante">Género (*)</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text" id="icono_genero">
                            <i class="fas fa-venus-mars"></i>
                          </div>
                        </div>
                        <select name="sexo_estudiante" class="form-control selectpicker genero" id="sexo_estudiante" required>
                          <option value="">Seleccione</option>
                          <option value="M">Masculino</option>
                          <option value="F">Femenino</option>
                        </select>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="literal">Literal (*)</label>
                      <div class="input-group">
                        <input type="text" class="form-control solo_letras text-uppercase" name="literal" id="literal" placeholder="Ej: A" maxlength="1">
                        <div class="invalid-feedback">
                            Campo Obligatorio
                        </div>
                      </div>
                    </div>

                                
                    <div class="form-group col-md-12">
                        <label class="col-md-3 col-form-label" for="textarea-input">Observaciones</label>
                        <div class="col-md-12">
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="4" placeholder="Observaciones" required></textarea>
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
<script src="scripts/historial-estudiantil.js"></script>

<?php
} //Cierre del else que muestra esta vista
ob_end_flush();
?>