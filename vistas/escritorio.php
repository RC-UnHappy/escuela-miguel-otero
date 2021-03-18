<?php
#Se activa el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION['idusuario'])) {
  header('location: login.html');
}
define('IMAGE_PATH', dirname((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 2) . '/public/img/');
require_once 'modules/header.php';

?>

<!-- Contenido -->
      <main class="main">
       
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Home</li>
          <li class="breadcrumb-item active">Escritorio</li>
        </ol>

        <div class="container-fluid">
          <div class="animated fadeIn">

            <div class="row" id="widgetContainer">

              <div class="col-sm-6 col-md-6">
                <div class="card">
                  <div class="card-body">
                    <div class="h1 text-muted text-right mb-4">
                      <i class="fas fa-calendar-alt text-info" style="font-size: 50px;"></i>
                    </div>
                    
                    <div class="row">
                      <div class="col-6">
                        <div class="text-value" id="mostrarPeriodo"></div>
                        
                        <small class="text-muted text-uppercase font-weight-bold">Período Escolar</small>

                      </div>

                      <div class="col-6">
                        <div class="text-value" id="mostrarLapso"></div>
                        
                        <small class="text-muted text-uppercase font-weight-bold" id="estatusLapso">Lapso</small>
                        
                        

                      </div>

                    </div>
                    
                    <div  class="row" >
                      <div class="col-md-12" id="alerta-periodo">
                        
                      </div>
                      <div class="col-md-12">
                        <div id="alerta-lapso">
                        
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <div class="col-sm-6 col-md-6">
                <div class="card">
                  <div class="card-body">
                    <div class="h1 text-muted text-right mb-4">
                      <i class="fas fa-venus-mars text-success" style="font-size: 50px;"></i>
                    </div>
                    <div class="text-value" id="mostrarMatricula">400</div>
                    <small class="text-muted text-uppercase font-weight-bold">Total Estudiantes</small>
                  </div>
                </div>
              </div>

              <div class="col-sm-6 <?=(isset($_SESSION['rol']) && $_SESSION['rol'] == 'Administrador') ? 'col-lg-3' : 'col-lg-6' ?>">
                <div class="card text-white bg-pink">
                  <div class="card-body pb-3">
                    <i class="fas fa-venus" style="font-size: 30px;"></i>
                    <div class="text-value" id="mostrarHembras">200</div>
                    <div>Niñas</div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6 <?=(isset($_SESSION['rol']) && $_SESSION['rol'] == 'Administrador') ? 'col-lg-3' : 'col-lg-6' ?>">
                <div class="card text-white bg-blue">
                  <div class="card-body pb-3">
                    <i class="fas fa-mars" style="font-size: 30px;"></i>
                    <div class="text-value" id="mostrarVarones">200</div>
                    <div>Niños</div>
                  </div>
                </div>
              </div>
              
              <?php 
              if ( isset($_SESSION['rol']) && $_SESSION['rol'] == 'Administrador' ) {
                
                echo '
                <div class="col-sm-6 col-lg-3">
                  <div class="card text-white bg-teal">
                    <div class="card-body pb-3">
                      <div class="btn-group float-right">
                        <button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-cog text-white"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                          <a class="dropdown-item" href="personal.php">Ir a Personal</a>
                        </div>
                      </div>
                      <i class="fas fa-chalkboard-teacher" style="font-size: 30px;"></i>
                      <div class="text-value" id="mostrarDocentes">20</div>
                      <div>Docentes de Aula</div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                  <div class="card text-white bg-indigo">
                    <div class="card-body pb-3">
                      <div class="btn-group float-right">
                        <button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-cog text-white"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                          <a class="dropdown-item" href="personal.php">Ir a Personal</a>
                        </div>
                      </div>
                      <i class="fas fa-user-md" style="font-size: 30px;"></i>
                      <div class="text-value" id="mostrarEspecialistas">7</div>
                      <div>Docentes Especialistas</div>
                    </div>
                  </div>
                </div>

                <div class="col-6 col-lg-3">
                  <div class="card">
                    <div class="card-body p-3 d-flex align-items-center">
                      <i class="fa fa-ruler bg-orange mr-3 text-white" style="font-size: 70px; padding: 20px;"></i>
                      <div>
                        <div class="text-value-sm" style="color: #f8cb00" id="mostrarAmbientes">20
                        </div>
                        <div class="text-muted text-uppercase font-weight-bold small">Ambientes
                        </div>
                      </div>
                    </div>
                    <div class="card-footer px-3 py-2">
                      <a class="btn-block text-muted d-flex justify-content-between align-items-center" href="ambiente.php">
                        <span class="small font-weight-bold">Ir a Ambiente</span>
                        <i class="fa fa-angle-right"></i>
                      </a>
                    </div>
                  </div>
                </div>

                <div class="col-6 col-lg-3">
                  <div class="card">
                    <div class="card-body p-3 d-flex align-items-center">
                      <i class="fa fa-suitcase bg-purple mr-3 text-white" style="font-size: 70px; padding: 20px;"></i>
                      <div>
                        <div class="text-value-sm" style="color: #6f42c1" id="mostrarAdministrativos">3</div>
                        <div class="text-muted text-uppercase font-weight-bold small">
                          Personal Administrativo
                        </div>
                      </div>
                    </div>
                    <div class="card-footer px-3 py-2">
                      <a class="btn-block text-muted d-flex justify-content-between align-items-center" href="personal.php">
                        <span class="small font-weight-bold">Ir a Personal</span>
                        <i class="fa fa-angle-right"></i>
                      </a>
                    </div>
                  </div>
                </div>

                <div class="col-6 col-lg-3">
                  <div class="card">
                    <div class="card-body p-3 d-flex align-items-center">
                      <i class="fas fa-hard-hat bg-blue mr-3 text-white" style="font-size: 70px; padding: 20px;"></i>
                      <div>
                        <div class="text-value-sm" style="color: #20a8d8" id="mostrarObreros">3</div>
                        <div class="text-muted text-uppercase font-weight-bold small">Personal Obrero</div>
                      </div>
                    </div>
                    <div class="card-footer px-3 py-2">
                      <a class="btn-block text-muted d-flex justify-content-between align-items-center" href="personal.php">
                        <span class="small font-weight-bold">Ir a Personal</span>
                        <i class="fa fa-angle-right"></i>
                      </a>
                    </div>
                  </div>
                </div>

                <div class="col-6 col-lg-3">
                  <div class="card">
                    <div class="card-body p-3 d-flex align-items-center">
                      <i class="fas fa-user-secret bg-red mr-3 text-white" style="font-size: 70px; padding: 20px;"></i>
                      <div>
                        <div class="text-value-sm text-danger" id="mostrarVigilantes">3</div>
                        <div class="text-muted text-uppercase font-weight-bold small">Vigilantes</div>
                      </div>
                    </div>
                    <div class="card-footer px-3 py-2">
                      <a class="btn-block text-muted d-flex justify-content-between align-items-center" href="personal.php">
                        <span class="small font-weight-bold">Ir a Personal</span>
                        <i class="fa fa-angle-right"></i>
                      </a>
                    </div>
                  </div>
                </div>

                      ';

              }

              ?>
              

            </div>

          </div>
        </div>
      </main>
<!-- Fin Contenido -->

<?php 
require_once 'modules/footer.php';
?>
<script src="scripts/escritorio.js"></script>
<?php 
ob_end_flush();
?>
    