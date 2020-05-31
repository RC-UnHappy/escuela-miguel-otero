<?php
#Se activa el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION['usuario'])) {
  header('location: login.html');
}
else {
require_once 'modules/header.php';
if (isset($_SESSION['permisos']['pic']) && in_array('ver' , $_SESSION['permisos']['pic'])) {
?>

<!-- Contenido -->
<main class="main">
  <div class="animated fadeIn">
    <div class="jumbotron jumbotron-fluid mb-0 fondo-degradado" >
    </div>
    <div class="container panel-principal col-sm-12">
      <div class="card border-light mb-3 shadow p-3 mb-5 bg-white rounded ">

        <div class="card-header pt-0 pb-1 bg-white mb-3"> <!-- Botonera del panel -->
        
          <!-- Botón para mostrar modal pic -->
          <h1 class="font-weight-normal h5">PIC

            <?php              
              if( isset($_SESSION['permisos']['pic']) && 
                  in_array('agregar' , $_SESSION['permisos']['pic']) ){
                echo 
                '<button class="btn btn-outline-primary btn-pill shadow-sm" data-toggle="modal" data-target="#picModal" id="btnAgregar">
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
                <caption>Lista de PIC</caption>
                <thead class="fondo-degradado text-white">
                  <tr>
                    <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opciones&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th scope="col">Período escolar</th>
                    <th scope="col">PIC</th>
                    <th scope="col">Estatus</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </div>
          </div>  
        </div>
        
        <!-- Modal para crear pic -->
        <div class="modal fade" id="picModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog rounded modal-lg" role="document">
            <div class="modal-content">
              
              <form class="needs-validation" novalidate name="formularioPic" id="formularioregistros"> <!-- Formulario de pic -->

                <div class="modal-header fondo-degradado rounded">
                  <h5 class="modal-title text-white" id="exampleModalLabel">Crear PIC</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body">

                  <div class="row"> 

                    <div class="form-group col-md-3">
                      <label for="periodo_escolar">Período escolar (*)</label>
                      <div class="input-group ">
                        <select name="idperiodo_escolar" id="periodo_escolar" class="form-control selectpicker" required="true">

                        </select>
                        <div class="invalid-feedback">
                          Campo Obligatorio
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="pic">PIC (*)</label>

                      <div class="input-group">

                        <input type="text" class="form-control pic "  name="pic"  id="pic" required>

                        <input type="hidden" name="idpic" id="idpic"> <!-- Input oculto que guardará el id del pic cuando sea necesario -->
                        
                        <div class="invalid-feedback" >
                            Campo Obligatorio
                        </div>

                      </div>
                    </div>

                    <div class="form-group col-md-3">
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

} //cierre
require_once 'modules/footer.php';
?>
<script src="scripts/pic.js"></script>

<?php 
} //Cierre del else que muestra esta vista
ob_end_flush();
?>