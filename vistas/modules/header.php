<?php
if (strlen(session_id()) < 1)
  session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <meta name="description" content="Escuela Rómulo Gallegos">
  <meta name="author" content="Alexis Cáceres">
  <meta name="keyword" content="Escuela,Básica,Bolivariana,Miguel,Otero,Silva,Acarigua,Portuguesa,Venezuela">
  <link rel="icon" type="image/jpeg" href="<?= IMAGE_PATH; ?>escudo-romulo.jpg" />
  <!-- <link rel="icon" type="image/jpeg" href="../public/img/escudo-romulo.jpg" /> -->

  <title>Escuela Básica - Rómulo Gallegos</title>


  <!-- Icons-->
  <!-- <link rel="icon" type="image/ico" href="./img/favicon.ico" sizes="any" /> -->
  <link href="/escuela-romulo-gallegos/public/css/coreui-icons.min.css" rel="stylesheet">
  <link href="/escuela-romulo-gallegos/public/css/font-awesome.min.css" rel="stylesheet">

  <!-- Main styles for this application-->
  <link href="/escuela-romulo-gallegos/public/css/style.css" rel="stylesheet">
  <link href="/escuela-romulo-gallegos/public/css/pace.min.css" rel="stylesheet">
  <!-- <link href="css/style.css" rel="stylesheet"> 
    <link href="vendors/pace-progress/css/pace.min.css" rel="stylesheet"> -->

  <!-- Datatable -->
  <link rel="stylesheet" href="/escuela-romulo-gallegos/public/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/escuela-romulo-gallegos/public/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="/escuela-romulo-gallegos/public/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="/escuela-romulo-gallegos/public/css/scroller.bootstrap4.min.css">

  <!-- Font awesome principal -->
  <link href="/escuela-romulo-gallegos/public/css/fontawesome.min.css" rel="stylesheet">
  <link href="/escuela-romulo-gallegos/public/css/regular.min.css" rel="stylesheet">
  <link href="/escuela-romulo-gallegos/public/css/solid.min.css" rel="stylesheet">

  <!-- Estilos principales -->
  <link rel="stylesheet" href="/escuela-romulo-gallegos/vistas/css/estilos.css">

  <link rel="stylesheet" href="/escuela-romulo-gallegos/public/css/bootstrap-select.min.css">

</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show sidebar-minimized brand-minimized">
  <header class="app-header navbar">

    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
      <span class="navbar-toggler-icon"></span>
    </button>

    <a class="navbar-brand" href="/escuela-romulo-gallegos/vistas/escritorio.php">
      <div class="navbar-brand-full">
        <!-- <i class="fas fa-school" style="font-size: 26px;"></i> -->
        <img src="<?= IMAGE_PATH; ?>escudo-romulo.jpg" style="height: 40px;">
        <em>Escuela R.G</em>
      </div>

      <!-- <i class="navbar-brand-minimized fas fa-school" style="font-size: 26px;"></i> -->
      <img class="navbar-brand-minimized" src="<?= IMAGE_PATH; ?>escudo-romulo.jpg" style="height: 40px;">
    </a>

    <button class="navbar-toggler sidebar-minimizer brand-minimizer d-md-down-none" type="button" data-toggle="sidebar-lg-show">
      <span class="navbar-toggler-icon"></span>
    </button>

    <ul class="nav navbar-nav d-md-down-none">
      <li class="nav-item px-3">
        <a class="nav-link" href="/escuela-romulo-gallegos/vistas/escritorio.php">Escritorio</a>
      </li>

    </ul>

    <ul class="nav navbar-nav ml-auto">
      <!-- <li class="nav-item d-md-down-none">
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
      </li> -->
      <li class="nav-item dropdown mr-4">
        <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" id="dropdownMenuLink">

          <img class="img-avatar" src="<?php
                                        if ($_SESSION['genero'] == 'M') {
                                          echo '/escuela-romulo-gallegos/files/perfil/hombre.jpg';
                                        } elseif ($_SESSION['genero'] == 'F') {
                                          echo '/escuela-romulo-gallegos/files/perfil/mujer.jpg';
                                        } ?>" alt="Imagen">


          <span class="hidden-xs"><?php echo ucfirst($_SESSION['usuario']) ?></span>

        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
          <div class="dropdown-header text-center">
            <strong>Cuenta</strong>
          </div>
          <button class="dropdown-item" data-toggle="modal" data-target="#perfilModal" onclick="mostrarPerfil(<?= $_SESSION['idusuario'] ?>)">
            <i class="fa fa-user"></i> Perfil
          </button>

          <a class="dropdown-item" href="/escuela-romulo-gallegos/controladores/usuario.php?op=salir">
            <i class="fa fa-lock"></i> Salir</a>
        </div>
      </li>
    </ul>
    <!-- <button class="navbar-toggler aside-menu-toggler d-md-down-none" type="button" data-toggle="aside-menu-lg-show">
      <span class="navbar-toggler-icon"></span>
    </button> -->
    <!-- <button class="navbar-toggler aside-menu-toggler d-lg-none" type="button" data-toggle="aside-menu-show">
      <span class="navbar-toggler-icon"></span>
    </button> -->
  </header>

  <div class="app-body">

    <!-- Modal para editar el perfil del usuario -->
    <div class="modal fade" id="perfilModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog rounded" role="document">
        <div class="modal-content">

          <form class="needs-validation" novalidate name="formularioPerfil" id="formularioPerfil">

            <div class="modal-header fondo-degradado rounded">
              <h5 class="modal-title text-white" id="exampleModalLabel">Editar perfil</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">

              <div class="row">

                <div class="form-group col-md-6">
                  <label for="usuarioperfil">Usuario (*)</label>

                  <div class="input-group">

                    <input type="text" class="form-control usuarioperfil" name="usuarioperfil" id="usuarioperfil" required>

                    <input type="hidden" name="idusuarioperfil" id="idusuarioperfil"> <!-- Input oculto que guardará el id del usuario cuando sea necesario -->

                    <div class="invalid-feedback">
                      Campo Obligatorio
                    </div>

                  </div>
                </div>

                <div class="form-group col-md-6">
                  <label for="passwordusuarioperfil">Contraseña (*)</label>

                  <div class="input-group">

                    <input type="password" class="form-control passwordusuarioperfil" name="passwordusuarioperfil" id="passwordusuarioperfil" required>

                    <div class="invalid-feedback">
                      Campo Obligatorio
                    </div>

                  </div>
                </div>

              </div> <!-- Fin row -->

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" id="btnGuardarPerfil" class="btn btn-primary">Guardar</button>
            </div>

          </form> <!-- Fin del formulario -->
        </div>
      </div>
    </div>

    <div class="sidebar">
      <nav class="sidebar-nav">
        <ul class="nav">

          <?php
          if (isset($_SESSION['permisos']['escritorio']) && in_array('ver', $_SESSION['permisos']['escritorio'])) {
            echo '<li class="nav-item">
                        <a class="nav-link" href="/escuela-romulo-gallegos/vistas/escritorio.php">
                          <i class="nav-icon fas fa-tachometer-alt"></i> Escritorio
                          <!-- <span class="badge badge-primary">NEW</span> -->
                        </a>
                      </li>';
          }

          ?>


          <li class="nav-title">Institución</li>

          <?php
          echo (isset($_SESSION['permisos']['estudiante']) && in_array('ver', $_SESSION['permisos']['estudiante'])) ?
            '<li class="nav-item">
              <a class="nav-link" href="/escuela-romulo-gallegos/vistas/estudiante.php">
              <i class="nav-icon fas fa-user-graduate"></i> Estudiante</a>
            </li>'
            :
            '';

          echo (isset($_SESSION['permisos']['representante']) && in_array('ver', $_SESSION['permisos']['representante'])) ?
            '<li class="nav-item">
              <a class="nav-link" href="/escuela-romulo-gallegos/vistas/representante.php">
              <i class="nav-icon fas fa-user-tie"></i> Padres y representantes</a>
            </li>'
            :
            '';

          echo (isset($_SESSION['permisos']['representado']) && in_array('ver', $_SESSION['permisos']['representado'])) ?
            '<li class="nav-item">
              <a class="nav-link" href="/escuela-romulo-gallegos/vistas/representado/">
              <i class="nav-icon fas fa-users"></i> Representado(s)</a>
            </li>'
            :
            '';

          echo (isset($_SESSION['permisos']['personal']) && in_array('ver', $_SESSION['permisos']['personal'])) ?
            '<li class="nav-item">
              <a class="nav-link" href="/escuela-romulo-gallegos/vistas/personal.php">
              <i class="nav-icon fas fa-chalkboard-teacher"></i> Personal</a>
            </li>'
            :
            '';

          ?>

          <?php
          if (isset($_SESSION['permisos']['usuario']) && in_array('ver', $_SESSION['permisos']['usuario'])) {
            echo '<li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                          <i class="nav-icon fas fa-users-cog"></i> Usuarios
                        </a>
                        <ul class="nav-dropdown-items">
                          <li class="nav-item">
                            <a class="nav-link" href="/escuela-romulo-gallegos/vistas/usuario.php">
                              <i class="nav-icon fas fa-user-plus"></i> Gestionar</a>
                          </li>
                        </ul>
                      </li>';
          }
          ?>

          <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] != 'Representante') : ?>
            <li class="nav-item nav-dropdown">
              <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon fas fa-money-check"></i> Operaciones
              </a>

              <ul class="nav-dropdown-items">

                <?php

                echo (isset($_SESSION['permisos']['aspecto-fisiologico']) && in_array('ver', $_SESSION['permisos']['aspecto-fisiologico'])) ?
                  '<li class="nav-item">
                  <a class="nav-link" href="/escuela-romulo-gallegos/vistas/aspecto-fisiologico.php">
                    <i class="nav-icon fas fa-child"></i> Aspecto fisiológico
                  </a>
                </li>'
                  :
                  '';

                echo (isset($_SESSION['permisos']['boletin-final']) && in_array('ver', $_SESSION['permisos']['boletin-final'])) ?
                  '<li class="nav-item">
                  <a class="nav-link" href="/escuela-romulo-gallegos/vistas/boletin-final.php">
                    <i class="nav-icon fas fa-book-open"></i> Boletín final
                  </a>
                </li>'
                  :
                  '';

                echo (isset($_SESSION['permisos']['boletin-parcial']) && in_array('ver', $_SESSION['permisos']['boletin-parcial'])) ?
                  '<li class="nav-item">
                  <a class="nav-link" href="/escuela-romulo-gallegos/vistas/boletin-parcial.php">
                    <i class="nav-icon fas fa-columns"></i> Boletín parcial
                  </a>
                </li>'
                  :
                  '';

                echo (isset($_SESSION['permisos']['gestionar-indicador']) && in_array('ver', $_SESSION['permisos']['gestionar-indicador'])) ?
                  '<li class="nav-item">
                  <a class="nav-link" href="/escuela-romulo-gallegos/vistas/gestionar-indicador.php">
                    <i class="nav-icon fas fa-tasks"></i> Gestionar indicador
                  </a>
                </li>'
                  :
                  '';

                echo (isset($_SESSION['permisos']['inscripcion']) && in_array('ver', $_SESSION['permisos']['inscripcion'])) ?
                  '<li class="nav-item">
                  <a class="nav-link" href="/escuela-romulo-gallegos/vistas/inscripcion/inscripcion.php">
                    <i class="nav-icon fas fa-address-card"></i> Inscripción
                  </a>
                </li>'
                  :
                  '';

                echo (isset($_SESSION['permisos']['lapso-academico']) && in_array('ver', $_SESSION['permisos']['lapso-academico'])) ?
                  '<li class="nav-item">
                  <a class="nav-link" href="/escuela-romulo-gallegos/vistas/lapso-academico.php">
                    <i class="nav-icon fas fa-cut"></i> Lapso académico
                  </a>
                </li>'
                  :
                  '';

                echo (isset($_SESSION['permisos']['periodo-escolar']) && in_array('ver', $_SESSION['permisos']['periodo-escolar'])) ?
                  '<li class="nav-item">
                  <a class="nav-link" href="/escuela-romulo-gallegos/vistas/periodo-escolar.php">
                    <i class="nav-icon fas fa-calendar-alt"></i> Período escolar
                  </a>
                </li>'
                  :
                  '';

                echo (isset($_SESSION['permisos']['pic']) && in_array('ver', $_SESSION['permisos']['pic'])) ?
                  '<li class="nav-item">
                  <a class="nav-link" href="/escuela-romulo-gallegos/vistas/pic.php">
                    <i class="nav-icon fas fa-tasks"></i> PIC
                  </a>
                </li>'
                  :
                  '';

                echo (isset($_SESSION['permisos']['planificacion']) && in_array('ver', $_SESSION['permisos']['planificacion'])) ?
                  '<li class="nav-item">
                  <a class="nav-link" href="/escuela-romulo-gallegos/vistas/planificacion.php">
                    <i class="nav-icon fas fa-tasks"></i> Planificación
                  </a>
                </li>'
                  :
                  '';
                ?>

              </ul>
            </li>
          <?php endif; ?>

          <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] != 'Representante') : ?>
            <li class="nav-title">Configuración</li>
          <?php endif; ?>

          <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] != 'Representante') : ?>
            <li class="nav-item nav-dropdown">
              <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon fas fa-cogs"></i> Configuración
              </a>

              <ul class="nav-dropdown-items">
                <?php
                echo (isset($_SESSION['permisos']['ambiente']) && in_array('ver', $_SESSION['permisos']['ambiente'])) ?
                  '<li class="nav-item">
                  <a class="nav-link" href="/escuela-romulo-gallegos/vistas/ambiente.php">
                    <i class="nav-icon fas fa-ruler-vertical"></i> Ambiente
                  </a>
                </li>'
                  :
                  '';

                echo (isset($_SESSION['permisos']['grado']) && in_array('ver', $_SESSION['permisos']['grado'])) ?
                  '<li class="nav-item">
                  <a class="nav-link" href="/escuela-romulo-gallegos/vistas/grado.php">
                    <i class="nav-icon fas fa-pencil-ruler"></i> Grado
                  </a>
                </li>'
                  :
                  '';

                echo (isset($_SESSION['permisos']['institucion']) && in_array('ver', $_SESSION['permisos']['institucion'])) ?
                  '<li class="nav-item">
                  <a class="nav-link" href="/escuela-romulo-gallegos/vistas/institucion.php">
                    <i class="nav-icon fas fa-school"></i> Institución
                  </a>
                </li>'
                  :
                  '';


                echo (isset($_SESSION['permisos']['lapso']) && in_array('ver', $_SESSION['permisos']['lapso'])) ?
                  '<li class="nav-item">
                  <a class="nav-link" href="/escuela-romulo-gallegos/vistas/lapso.php">
                    <i class="nav-icon fas fa-cut"></i> Lapso
                  </a>
                </li>'
                  :
                  '';

                echo (isset($_SESSION['permisos']['expresion-literal']) && in_array('ver', $_SESSION['permisos']['expresion-literal'])) ?
                  '<li class="nav-item">
                  <a class="nav-link" href="/escuela-romulo-gallegos/vistas/expresion-literal.php">
                    <i class="nav-icon fas fa-ad"></i> Literal
                  </a>
                </li>'
                  :
                  '';

                echo (isset($_SESSION['permisos']['materia']) && in_array('ver', $_SESSION['permisos']['materia'])) ?
                  '<li class="nav-item">
                  <a class="nav-link" href="/escuela-romulo-gallegos/vistas/materia.php">
                    <i class="nav-icon fas fa-book"></i> Materia
                  </a>
                </li>'
                  :
                  '';

                echo (isset($_SESSION['permisos']['modulo']) && in_array('ver', $_SESSION['permisos']['modulo'])) ?
                  '<li class="nav-item">
                  <a class="nav-link" href="/escuela-romulo-gallegos/vistas/modulo.php">
                    <i class="nav-icon fas fa-check"></i> Módulo
                  </a>
                </li>'
                  :
                  '';

                echo (isset($_SESSION['permisos']['seccion']) && in_array('ver', $_SESSION['permisos']['seccion'])) ?
                  '<li class="nav-item">
                  <a class="nav-link" href="/escuela-romulo-gallegos/vistas/seccion.php">
                    <i class="nav-icon fas fa-apple-alt"></i> Sección
                  </a>
                </li>'
                  :
                  '';

                echo (isset($_SESSION['permisos']['accion']) && in_array('ver', $_SESSION['permisos']['accion'])) ?
                  '<li class="nav-item">
                  <a class="nav-link" href="/escuela-romulo-gallegos/vistas/accion.php">
                    <i class="nav-icon fas fa-check"></i> Acción
                  </a>
                </li>'
                  :
                  '';

                ?>

              </ul>
            </li>
          <?php endif; ?>

          <?php
          echo (isset($_SESSION['permisos']['historial-estudiantil']) && in_array('ver', $_SESSION['permisos']['historial-estudiantil'])) ?
            '<li class="nav-item">
              <a class="nav-link" href="/escuela-romulo-gallegos/vistas/historial-estudiantil.php">
              <i class="nav-icon fas fa-book"></i> Historial estudiantil</a>
            </li>'
            :
            '';
          ?>

          <li class="divider"></li>
          <!-- <li class="nav-title">Ayuda</li> -->
          <!-- <li class="nav-item mt-auto">
            <a class="nav-link nav-link-success" href="https://coreui.io" target="_top">
              <i class="nav-icon icon-cloud-download"></i>Manual <strong>Usuario</strong></a>
          </li> -->
          <!-- <li class="nav-item">
            <a class="nav-link nav-link-danger" href="https://coreui.io/pro/" target="_top">
              <i class="nav-icon icon-layers"></i>Manual
              <strong>Instalación</strong>
            </a>
          </li> -->
        </ul>
      </nav>
    </div>