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
if (isset($_SESSION['permisos']['modulo']) && in_array('ver' , $_SESSION['permisos']['modulo'])) {
?>

<!-- Contenido -->
<main class="main">
  <div class="animated fadeIn">
    <div class="jumbotron jumbotron-fluid mb-0 fondo-degradado" >
    </div>
    <div class="container panel-principal col-sm-12">
      <div class="card border-light mb-3 shadow p-3 mb-5 bg-white rounded ">

        <div class="card-header pt-0 pb-1 bg-white mb-3"> <!-- Botonera del panel -->
          <h1 class="font-weight-normal h5">Módulo
            
          </h1>
        </div>
        
        <div class="row" id="listadoregistros">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-borderless table-striped" id="tblistado">
                <caption>Lista de módulos</caption>
                <thead class="fondo-degradado text-white">
                  <tr>
                    <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th scope="col">Módulo</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
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
<script src="scripts/modulo.js"></script>

<?php 
} //Cierre del else que muestra esta vista
ob_end_flush();
?>