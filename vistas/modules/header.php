<?php
if (strlen(session_id()) < 1) 
  session_start();
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="E.B.B Miguel Otero Silva - Acarigua, Portuguesa">
    <meta name="author" content="Alexis Cáceres">
    <meta name="keyword" content="Escuela,Básica,Bolivariana,Miguel,Otero,Silva,Acarigua,Portuguesa,Venezuela">
    <link rel="icon" type="image/jpeg" href="../public/img/icono.jpg" />
    
    <title>Escuela Básica - Miguel Otero Silva</title>


    <!-- Icons-->
    <link rel="icon" type="image/ico" href="./img/favicon.ico" sizes="any" />
    <link href="../public/css/coreui-icons.min.css" rel="stylesheet">
 	  <link href="../public/css/font-awesome.min.css" rel="stylesheet">

    <!-- Main styles for this application-->
    <link href="../public/css/style.css" rel="stylesheet">
    <link href="../public/css/pace.min.css" rel="stylesheet">
    <!-- <link href="css/style.css" rel="stylesheet"> 
    <link href="vendors/pace-progress/css/pace.min.css" rel="stylesheet"> -->

    <!-- Datatable -->
    <link rel="stylesheet" href="../public/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../public/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="../public/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../public/css/scroller.bootstrap4.min.css">

    <!-- Font awesome principal -->
    <link href="../public/css/fontawesome.min.css" rel="stylesheet">
    <link href="../public/css/regular.min.css" rel="stylesheet">
    <link href="../public/css/solid.min.css" rel="stylesheet">

    <!-- Estilos principales -->
    <link rel="stylesheet" href="css/estilos.css">

    <link rel="stylesheet" href="../public/css/bootstrap-select.min.css">

  </head>
  <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show sidebar-minimized brand-minimized">
    <header class="app-header navbar">

      <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
      </button>

      <a class="navbar-brand" href="escritorio.php">
        <div class="navbar-brand-full">
          <i class="fas fa-school" style="font-size: 26px;"></i>
          <em>Escuela M.O.S</em>
        </div>
        <!-- <img class="navbar-brand-full" src="../public/img/brand/logo.svg" width="89" height="25" alt="CoreUI Logo"> -->
        <!-- <img class="navbar-brand-minimized" src="../public/img/brand/sygnet.svg" width="30" height="30" alt="CoreUI Logo"> -->
        <i class="navbar-brand-minimized fas fa-school" style="font-size: 26px;"></i>
      </a>

      <button class="navbar-toggler sidebar-minimizer brand-minimizer d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
      </button>

      <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item px-3">
          <a class="nav-link" href="escritorio.php">Escritorio</a>
        </li>
        <li class="nav-item px-3">
          <a class="nav-link" href="#">Users</a>
        </li>
        <li class="nav-item px-3">
          <a class="nav-link" href="#">Settings</a>
        </li>
      </ul>

      <ul class="nav navbar-nav ml-auto">
        <li class="nav-item d-md-down-none">
          <a class="nav-link" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-pill badge-danger">5</span>
          </a>
        </li>
        <li class="nav-item d-md-down-none">
          <a class="nav-link" href="#">
            <i class="fas fa-list"></i>
          </a>
        </li>
        <li class="nav-item d-md-down-none">
          <a class="nav-link" href="#">
            <i class="far fa-envelope-open"></i>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" id="dropdownMenuLink">
            <img class="img-avatar" src="<?php 
            if(empty($_SESSION['img'] ) && $_SESSION['genero'] == 'M') { echo '../files/perfil/hombre.jpg';} 
            elseif (empty($_SESSION['img'] ) && $_SESSION['genero'] == 'F') {echo '../files/perfil/mujer.jpg';} 
            else { echo $_SESSION['img'];}?>" alt="Imagen">
            <span class="hidden-xs"><?php echo ucfirst($_SESSION['p_nombre']).' '.ucfirst($_SESSION['p_apellido']); ?></span>

          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
            <div class="dropdown-header text-center">
              <strong>Account</strong>
            </div>
            <a class="dropdown-item" href="#">
              <i class="fa fa-tasks"></i> Tasks
              <span class="badge badge-danger">42</span>
            </a>
            <a class="dropdown-item" href="#">
              <i class="fa fa-comments"></i> Comments
              <span class="badge badge-warning">42</span>
            </a>
            <div class="dropdown-header text-center">
              <strong>Cuenta</strong>
            </div>

            <button class="dropdown-item"  onclick="actualizarPerfil(<?=$_SESSION['idusuario']?>)">
              <i class="fa fa-user"></i> Perfil
            </button>

            <a class="dropdown-item" href="#">
              <i class="fa fa-wrench"></i> Settings</a>
            <a class="dropdown-item" href="#">
              <i class="fa fa-file"></i> Projects
              <span class="badge badge-primary">42</span>
            </a>
            <a class="dropdown-item" href="../controladores/usuario.php?op=salir">
              <i class="fa fa-lock"></i> Salir</a>
          </div>
        </li>
      </ul>
      <button class="navbar-toggler aside-menu-toggler d-md-down-none" type="button" data-toggle="aside-menu-lg-show">
        <span class="navbar-toggler-icon"></span>
      </button>
      <button class="navbar-toggler aside-menu-toggler d-lg-none" type="button" data-toggle="aside-menu-show">
        <span class="navbar-toggler-icon"></span>
      </button>
    </header>

    <div class="app-body">
      <div class="sidebar">
        <nav class="sidebar-nav">
          <ul class="nav">
            
            <?php 
              if ($_SESSION['escritorio'] ==1) {
                echo '<li class="nav-item">
                        <a class="nav-link" href="escritorio.php">
                          <i class="nav-icon fas fa-tachometer-alt"></i> Escritorio
                          <!-- <span class="badge badge-primary">NEW</span> -->
                        </a>
                      </li>';
              }

            ?>
              
            
            <li class="nav-title">Institución</li>

            <li class="nav-item">
              <a class="nav-link" href="estudiante.php">
                <i class="nav-icon fas fa-user-graduate"></i> Estudiante</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="representante.php">
                <i class="nav-icon fas fa-user-tie"></i> Representante</a>
            </li>

            <li class="nav-title">Configuración</li>

            <li class="nav-item">
              <a class="nav-link" href="usuario.php">
                <i class="nav-icon fas fa-chalkboard-teacher"></i> Personal</a>
            </li>

            <?php  
              if ($_SESSION['usuario'] == 1) {
                echo '<li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                          <i class="nav-icon fas fa-users-cog"></i> Usuarios
                        </a>
                        <ul class="nav-dropdown-items">
                          <li class="nav-item">
                            <a class="nav-link" href="usuario.php">
                              <i class="nav-icon fas fa-user-plus"></i> Gestionar</a>
                          </li>
                        </ul>
                      </li>';
              }
            ?>

            <li class="nav-item nav-dropdown">
              <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon fas fa-cogs"></i> Configuración
              </a>

              <ul class="nav-dropdown-items">

                <li class="nav-item">
                  <a class="nav-link" href="ambiente.php">
                    <i class="nav-icon fas fa-ruler-vertical"></i> Ambiente
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="seccion.php">
                    <i class="nav-icon fas fa-apple-alt"></i> Sección
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="grado.php">
                    <i class="nav-icon fas fa-pencil-ruler"></i> Grado
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="institucion.php">
                    <i class="nav-icon fas fa-school"></i> Institución
                  </a>
                </li>

              </ul>
            </li>

            
            <li class="nav-item nav-dropdown">
              <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon fas fa-user"></i> Icons</a>
              <ul class="nav-dropdown-items">
                <li class="nav-item">
                  <a class="nav-link" href="icons/coreui-icons.html">
                    <i class="nav-icon icon-star"></i> CoreUI Icons
                    <span class="badge badge-success">NEW</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="icons/flags.html">
                    <i class="nav-icon icon-star"></i> Flags</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="icons/font-awesome.html">
                    <i class="nav-icon icon-star"></i> Font Awesome
                    <span class="badge badge-secondary">4.7</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="icons/simple-line-icons.html">
                    <i class="nav-icon icon-star"></i> Simple Line Icons</a>
                </li>
              </ul>
            </li>

            <li class="divider"></li>
            <li class="nav-title">Ayuda</li>
            <li class="nav-item mt-auto">
              <a class="nav-link nav-link-success" href="https://coreui.io" target="_top">
                <i class="nav-icon icon-cloud-download"></i>Manual <strong>Usuario</strong></a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-danger" href="https://coreui.io/pro/" target="_top">
                <i class="nav-icon icon-layers"></i>Manual 
                <strong>Instalación</strong>
              </a>
            </li>
          </ul>
        </nav>
      </div>