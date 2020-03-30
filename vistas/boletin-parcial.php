<?php
#Se activa el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION['idusuario'])) {
  header('location: login.html');
} else {
require_once 'modules/header.php';
if (isset($_SESSION['permisos']['boletin-parcial']) && in_array('ver' , $_SESSION['permisos']['boletin-parcial'])) {
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
              <!-- Botón para mostrar modal gestionar indicadores -->
              <h1 class="font-weight-normal h5">Boletín parcial
                <button class="btn btn-outline-primary btn-pill shadow-sm" data-toggle="modal" data-target="#boletinParcialModal" id="btnAgregar">
                  <i class="fa fa-plus-circle"></i> Agregar
                </button>
              </h1>

            </div>
            
            <div class="d-flex justify-content-end col-md-3">
              <p class="h5 font-weight-normal mt-1 mr-0">Planificación</p>
              <select name="planificaciones_general" id="planificaciones_general" class="form-control selectpicker col-8">

              </select>
            
            </div>

            <div class="d-flex justify-content-end col-md-3">
              <p class="h5 font-weight-normal mt-1 mr-0">Estudiante</p>
              <select name="estudiantes_general" id="estudiantes_general" class="form-control selectpicker col-8">

              </select>
            
            </div>

            <div class="d-flex justify-content-end col-md-2">
              <p class="h5 font-weight-normal mt-1 mr-2">Lapso</p>
              <select name="lapsos_general" id="lapsos_general" class="form-control selectpicker col-8">

              </select>
            
            </div>
            
          </div>

        </div>
        
        <div class="row" id="listadoregistros">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-borderless table-striped" id="tblistado">
                <caption>Lista de boletín parcial</caption>
                <thead class="fondo-degradado text-white">
                  <tr>
                    <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opciones&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th scope="col">Lapso</th>
                    <th scope="col">Materia</th>
                    <th scope="col">Indicador</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Modal para crear boletín parcial -->
        <div class="modal fade" id="boletinParcialModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog rounded modal-xl" role="document">
            <div class="modal-content">

              <form class="needs-validation" novalidate name="formularioBoletinParcial" id="formularioBoletinParcial">
                <!-- Formulario de indicador -->

                <div class="modal-header fondo-degradado rounded">
                  <h5 class="modal-title text-white" id="tituloModalIndicador">Crear boletín parcial </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body">

                  <div class="row">

                    <!-- guarda el id del indicador cuando es necesario -->
                    <input type="hidden" value="" id="idboletinparcial" name="idboletinparcial">
                    
                    <div class="form-group col-md-2">
                      <label for="lapso_en_curso">Lapso (*)</label>
                      <div class="input-group ">
                        <select name="lapso_en_curso" id="lapso_en_curso" class="form-control selectpicker" required="true" readonly>
                          <option value="">Seleccione</option>
                        </select>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="planificacion">Planificación (*)</label>
                      <div class="input-group ">
                        <select name="idplanificacion" id="planificacion" class="form-control selectpicker" required="true">

                        </select>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="estudiantes">Estudiante (*)</label>
                      <div class="input-group ">
                        <select name="idestudiantes" id="estudiantes" class="form-control selectpicker" required="true" disabled="true">
                          <option value="">Seleccione</option>
                        </select>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>
                  
                    <div class="col-sm-12 pt-4">
                      <div class="table-responsive">
                        <table class="table table-borderless table-striped" id="tblistadoindicadores">
                          <thead class="fondo-degradado text-white">
                            <tr>
                              <th scope="col">Materia</th>
                              <th scope="col">Indicador</th>
                              <th scope="col">Nota</th>
                            </tr>
                          </thead>
                          <tbody id="listaIndicadores">
                            
                          </tbody>
                        </table>
                      </div>
                    </div>
                                
                    <div class="form-group col-md-12">
                        <label class="col-md-3 col-form-label" for="textarea-input">Recomendaciones</label>
                        <div class="col-md-12">
                            <textarea class="form-control" id="recomendacion" name="recomendacion" rows="4" placeholder="Recomendaciones" required></textarea>
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
<script src="scripts/boletin-parcial.js"></script>

<?php
} //Cierre del else que muestra esta vista
ob_end_flush();
?>