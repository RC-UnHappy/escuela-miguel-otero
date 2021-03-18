<?php
#Se activa el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION['idusuario'])) {
  header('location: login.html');
}
else {
  define('IMAGE_PATH', dirname((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 2) . '/public/img/');
require_once 'modules/header.php';
if (isset($_SESSION['permisos']['periodo-escolar']) && in_array('ver' , $_SESSION['permisos']['periodo-escolar'])) {
?>

<!-- Contenido -->
<main class="main">
  <div class="animated fadeIn">
    <div class="jumbotron jumbotron-fluid mb-0 fondo-degradado" >
    </div>
    <div class="container panel-principal col-sm-12">
      <div class="card border-light mb-3 shadow p-3 mb-5 bg-white rounded ">

        <div class="card-header pt-0 pb-1 bg-white mb-3"> <!-- Botonera del panel -->
        
          <!-- Botón para mostrar modal Período Escolar -->
          <h1 class="font-weight-normal h5">Período Escolar

            <?php              
              if( isset($_SESSION['permisos']['periodo-escolar']) && 
                  in_array('agregar' , $_SESSION['permisos']['periodo-escolar']) ){
                echo 
                '<button class="btn btn-outline-primary btn-pill shadow-sm" data-toggle="modal" data-target="#periodoModal" id="btnAgregar">
                  <i class="fa fa-plus-circle"></i> Agregar
                </button>';
              }       
            ?> 
            
          </h1>

        </div>
        
        <div class="row" id="listadoregistros">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-borderless table-striped" id="tblistado">
                <caption>Lista de períodos escolares</caption>
                <thead class="fondo-degradado text-white">
                  <tr>
                    <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opciones&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th scope="col">Período Escolar</th>
                    <th scope="col">Fecha inicio</th>
                    <th scope="col">Fecha fin</th>
                    <th scope="col">Estatus</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </div>
          </div>  
        </div>
        
        <!-- Modal para crear Período Escolar -->
        <div class="modal fade" id="periodoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog rounded modal-xl" role="document">
            <div class="modal-content">
              
              <form class="needs-validation" novalidate name="formularioPeriodo" id="formularioregistros"> <!-- Formulario de Período Escolar -->

                <div class="modal-header fondo-degradado rounded">
                  <h5 class="modal-title text-white" id="exampleModalLabel">Crear Período Escolar</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body">

                  <div class="row"> 

                    <input type="hidden" name="idperiodo" id="idperiodo"> <!-- Input oculto que guardará el id del periodo cuando sea necesario -->
                    <div class="form-group col-lg-4 col-xl-3">
                      <label for="periodo">Período Escolar (*)</label>
                        <div class="input-group ">
                          <select name="periodo" id="periodo" class="form-control selectpicker" required="true">
                            
                          </select>
                          <div class="invalid-feedback">
                            Campo Obligatorio
                          </div>
                        </div>
                    </div>

                    <div class="form-group col-lg-4 col-xl-3">
                      <label for="fecha_inicio">Fecha de inicio (*)</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-calendar-alt"></i>
                          </div>
                        </div>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-lg-4 col-xl-3">
                      <label for="fecha_fin">Fecha de fin (*)</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-calendar-alt"></i>
                          </div>
                        </div>
                        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-lg-12 col-xl-3">
                      <label for="estatus">Estatus (*)</label>
                      <div class="input-group">
                        
                        <select name="estatus" class="form-control selectpicker estatus" id="estatus" required>
                          <option value="">Seleccione</option>
                          <option value="Planificado">Planificado</option>
                        </select>
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

        <!-- Modal para mostrar los estudiantes que no tengan el boletín final -->
        <div class="modal fade" id="noFinalReport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog rounded " role="document">
            <div class="modal-content">

                <div class="modal-header fondo-degradado rounded">
                  <h5 class="modal-title text-white" id="tituloModal">Se necesita calificar a los siguientes estudiantes</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body" id="studentsWithoutFinalReport">
                  
                
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>

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
      }
    )
  }
</script>

<?php 
} //cierre del else
require_once 'modules/footer.php';
?>
<script src="scripts/periodo-escolar.js"></script>

<?php 
} //Cierre del else que muestra esta vista
ob_end_flush();
?>