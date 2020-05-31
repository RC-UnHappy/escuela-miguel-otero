<?php
#Se activa el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION['idusuario'])) {
  header('location: login.html');
}
else {
require_once 'modules/header.php';
if (isset($_SESSION['permisos']['materia']) && in_array('ver' , $_SESSION['permisos']['materia'])) {
?>

<!-- Contenido -->
<main class="main">
  <div class="animated fadeIn">
    <div class="jumbotron jumbotron-fluid mb-0 fondo-degradado" >
    </div>
    <div class="container panel-principal col-sm-12">
      <div class="card border-light mb-3 shadow p-3 mb-5 bg-white rounded ">

        <div class="card-header pt-0 pb-1 bg-white mb-3"> <!-- Botonera del panel -->
        
          <!-- Botón para mostrar modal materia -->
          <h1 class="font-weight-normal h5">Materia
            <?php              
              if( isset($_SESSION['permisos']['materia']) && 
                  in_array('agregar' , $_SESSION['permisos']['materia']) ){
                echo 
                '<button class="btn btn-outline-primary btn-pill shadow-sm" data-toggle="modal" data-target="#materiaModal" id="btnAgregar">
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
                <caption>Lista de materias</caption>
                <thead class="fondo-degradado text-white">
                  <tr>
                    <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opciones&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th scope="col">Materia</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </div>
          </div>  
        </div>
        
        <!-- Modal para crear materia -->
        <div class="modal fade" id="materiaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog rounded" role="document">
            <div class="modal-content">
              
              <form class="needs-validation" novalidate name="formularioMateria" id="formularioregistros"> <!-- Formulario de materia -->

                <div class="modal-header fondo-degradado rounded">
                  <h5 class="modal-title text-white" id="exampleModalLabel">Crear Materia</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body">

                  <div class="row"> 

                      <div class="form-group col-md-6">
                        <label for="materia">Materia (*)</label>

                        <div class="input-group">

                          <input type="text" class="form-control materia text-uppercase"  name="materia"  id="materia" required>

                          <input type="hidden" name="idmateria" id="idmateria"> <!-- Input oculto que guardará el id de la materia cuando sea necesario -->
                          
                          <div class="invalid-feedback" >
                              Campo Obligatorio
                          </div>

                        </div>
                      </div>

                      <div class="form-group col-md-6">
                        <label for="estatus">Estatus (*)</label>
                          <div class="input-group ">
                            <select name="estatus" id="estatus" class="form-control selectpicker" required="true">
                              <option value="">Seleccione</option>
                              <option value="1">Activo</option>
                              <option value="0">Inactivo</option>
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
} //cierre del else
require_once 'modules/footer.php';
?>
<script src="scripts/materia.js"></script>

<?php 
} //Cierre del else que muestra esta vista
ob_end_flush();
?>