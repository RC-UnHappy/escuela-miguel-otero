<?php
#Se activa el almacenamiento en el buffer
ob_start();
session_start();

require_once 'modules/header.php';

?>

<!-- Contenido -->
      <main class="main">
        <div class="animated fadeIn">
          <div class="jumbotron jumbotron-fluid mb-0 fondo-degradado" >
          </div>
          <div class="container panel-principal col-sm-12">
            <div class="card border-light mb-3 shadow p-3 mb-5 bg-white rounded ">

              <div class="card-header pt-0 pb-1 bg-white mb-3"> <!-- Botonera del panel -->
              
                <h1 class="font-weight-normal h5">Permiso
                  
                </h1>
              </div>

              

	          <div class="row">
	            <div class="col-sm-12">
	            	<div class="table-responsive">
	            		<table class="table table-borderless table-striped" id="tblistado">
							<caption>Lista de persmisos</caption>
		            		<thead class="fondo-degradado text-white">
		            			<tr>
		            				<th scope="col">Permiso</th>
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
require_once 'modules/footer.php';
?>
<script src="scripts/permiso.js"></script>

<?php 
ob_end_flush();
?>