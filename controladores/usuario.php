<?php 

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start(); 

#Se incluye el modelo de Usuario
require_once '../modelos/Usuario.php';

#Se instancia el objeto de Usuario
$Usuario = new Usuario();

#Se reciben los datos por POST y se asignan a variables

$idpersona = isset($_POST['idpersona']) ? limpiarCadena($_POST['idpersona']) : '';
$idusuario = isset($_POST['idusuario']) ? limpiarCadena($_POST['idusuario']) : '';
$cedula = isset($_POST['cedula']) ? limpiarCadena($_POST['cedula']) : '';
$p_nombre = isset($_POST['p_nombre']) ? limpiarCadena($_POST['p_nombre']) : '';
$s_nombre = isset($_POST['s_nombre']) ? limpiarCadena($_POST['s_nombre']) : '';
$p_apellido = isset($_POST['p_apellido']) ? limpiarCadena($_POST['p_apellido']) : '';
$s_apellido = isset($_POST['s_apellido']) ? limpiarCadena($_POST['s_apellido']) : '';
$genero = isset($_POST['genero']) ? limpiarCadena($_POST['genero']) : '';
$f_nac = isset($_POST['f_nac']) ? limpiarCadena($_POST['f_nac']) : '';
$email = isset($_POST['email']) ? limpiarCadena($_POST['email']) : '';
$rol = isset($_POST['rol']) ? limpiarCadena($_POST['rol']) : '';
$permisos = isset($_POST['permisos']) ? $_POST['permisos'] : [];

//Variables para inicio de sesión
$user = isset($_POST['user']) ? limpiarCadena($_POST['user']) : '';
$pass = isset($_POST['pass']) ? limpiarCadena($_POST['pass']) : '';

// Para cuando se desea cambiar el usuario o la contraseña
$idusuarioperfil = isset($_POST['idusuarioperfil']) ? limpiarCadena($_POST['idusuarioperfil']) : '';
$usuarioperfil = isset($_POST['usuarioperfil']) ? limpiarCadena($_POST['usuarioperfil']) : '';
$passwordusuarioperfil = isset($_POST['passwordusuarioperfil']) ? limpiarCadena($_POST['passwordusuarioperfil']) : '';

#Se ejecuta un caso dependiendo del valor del parámetro GET
switch ($_GET['op']) {
  case 'guardaryeditar':
		#Se incluye el modelo de Persona
		require_once '../modelos/Persona.php';
		$Persona = new Persona();
    
		#Se deshabilita el guardado automático de la base de datos
		autocommit(FALSE);
    
		if (!empty($idpersona) && empty($idusuario)) {
      
			#Variable para comprobar que todo salió bien al final
			$sw = TRUE;

			// #Se registra la persona y se devuelve el id del registro
			// $idpersona = $Persona->insertar($cedula, $p_nombre, $s_nombre, $p_apellido, $s_apellido, $genero, $f_nac, $email) or $sw = FALSE;

			#Se obtiene la cédula sin el tipo de documento
			list($documento, $cedula) = explode('-', $cedula);

			#Se encripta la clave con el algoritmo SHA256
      $clavehash = hash('SHA256', $cedula);
      
			#Se registra el usuario
			$rspta = $Usuario->insertar($idpersona, $cedula, $clavehash, $rol, 0, 1, $permisos) or $sw = FALSE;
			#Se verifica que todo saliío bien y se guardan los datos o se eliminan todos
			if ($sw) {
				commit();
				echo 'true';
			}
			else {
				rollback();
				echo 'false';
			}

    }
    elseif(!empty($idpersona) && !empty($idusuario)) {

      $sw = TRUE;
      $Usuario->eliminar_permisos_usuario($idusuario) or $sw = FALSE;
      $rspta = $Usuario->editar($idusuario, $rol, $permisos) or $sw = FALSE;
      #Se verifica que todo saliío bien y se guardan los datos o se eliminan todos
			if ($sw) {
				commit();
				echo 'update';
			}
			else {
				rollback();
				echo 'false';
			}
    }
		break;

  case 'permisos':  

    $modulos_objeto = $Usuario->traermodulos();
    $modulos = [];
    if ($modulos_objeto->num_rows != 0) {
      while ($fila = $modulos_objeto->fetch_object()) {
        $modulos[$fila->modulo] = ['id' => $fila->id, 'modulo' => $fila->modulo];
      }
    }

    $acciones_objeto = $Usuario->traeracciones();
    $acciones = [];
    if ($acciones_objeto->num_rows != 0) {
      while ($fila = $acciones_objeto->fetch_object()) {
        $acciones[$fila->accion] = ['id' => $fila->id];
      }
    }

    if (empty($idusuario)) {

      $permisos_excluidos_para_rol_docente = ['ambiente', 'grado', 'lapso', 'expresion-literal','lapso-academico', 'materia', 'modulo', 'periodo-escolar', 'pic', 'planificacion', 'seccion', 'usuario', 'accion', 'institucion', 'historial-estudiantil', 'estudiante', 'personal', 'representante'];

      $permisos = '';
      if ($rol == 'Docente') {
        foreach ($modulos as $key => $value) {
          if (!in_array($key, $permisos_excluidos_para_rol_docente)) {
            $permisos .= '
              <div class="input-group-prepend">
                <div>
                  <label>'.ucfirst($key).'</label>
                </div>
              </div>
              <div class="input-group pl-3  pb-3">';

              // Aquí se permite excluir algunas de las acciones, porque algunos módulos no las tienen
              if ($value['modulo'] == 'escritorio' || $value['modulo'] == 'modulo' || $value['modulo'] == 'accion') {
                foreach ($acciones as $accioneskey => $accionesvalue) {
                  if ($accioneskey == 'ver') {
                    $permisos .= '
                    <div class="custom-control custom-checkbox pr-2">
                      <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                      <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                    </div>';                 
                  }
                }
              }
              else if ($value['modulo'] == 'institucion') {

                foreach ($acciones as $accioneskey => $accionesvalue) {
                  if ($accioneskey == 'ver') {
                    $permisos .= '
                    <div class="custom-control custom-checkbox pr-2">
                      <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                      <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                    </div>';                 
                  }
                  else if ($accioneskey == 'editar') {
                    $permisos .= '
                    <div class="custom-control custom-checkbox pr-2">
                      <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                      <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                    </div>';                 
                  }

                }
              }
              else if ($value['modulo'] == 'aspecto-fisiologico') {

                foreach ($acciones as $accioneskey => $accionesvalue) {
                  if ($accioneskey == 'ver') {
                    $permisos .= '
                    <div class="custom-control custom-checkbox pr-2">
                      <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                      <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                    </div>';                 
                  }
                  else if ($accioneskey == 'editar') {
                    $permisos .= '
                    <div class="custom-control custom-checkbox pr-2">
                      <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                      <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                    </div>';                 
                  }
                  else if ($accioneskey == 'agregar') {
                    $permisos .= '
                    <div class="custom-control custom-checkbox pr-2">
                      <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                      <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                    </div>';                 
                  }
                }
              }
              else if ($value['modulo'] == 'boletin-final') {

                foreach ($acciones as $accioneskey => $accionesvalue) {
                  if ($accioneskey == 'ver') {
                    $permisos .= '
                    <div class="custom-control custom-checkbox pr-2">
                      <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                      <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                    </div>';                 
                  }
                  else if ($accioneskey == 'editar') {
                    $permisos .= '
                    <div class="custom-control custom-checkbox pr-2">
                      <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                      <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                    </div>';                 
                  }
                  else if ($accioneskey == 'agregar') {
                    $permisos .= '
                    <div class="custom-control custom-checkbox pr-2">
                      <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                      <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                    </div>';                 
                  }
                }
              }
              else if ($value['modulo'] == 'boletin-parcial') {

                foreach ($acciones as $accioneskey => $accionesvalue) {
                  if ($accioneskey == 'ver') {
                    $permisos .= '
                    <div class="custom-control custom-checkbox pr-2">
                      <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                      <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                    </div>';                 
                  }
                  else if ($accioneskey == 'editar') {
                    $permisos .= '
                    <div class="custom-control custom-checkbox pr-2">
                      <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                      <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                    </div>';                 
                  }
                  else if ($accioneskey == 'agregar') {
                    $permisos .= '
                    <div class="custom-control custom-checkbox pr-2">
                      <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                      <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                    </div>';                 
                  }
                }
              }
              else {
                foreach ($acciones as $accioneskey => $accionesvalue) {
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                    <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                    <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                }
              }
              $permisos .='</div>';         
          }      
        }
      }
      // Si no es docente
      else {
        foreach ($modulos as $key => $value) {
          $permisos .= '
            <div class="input-group-prepend">
              <div>
                <label>'.ucfirst($key).'</label>
              </div>
            </div>
            <div class="input-group pl-3  pb-3">';

            /**
             * A las opciones de éste if solo se les mostrará la acción de ver
             */
          if ($value['modulo'] == 'escritorio' || $value['modulo'] == 'modulo' || $value['modulo'] == 'accion') {
            foreach ($acciones as $accioneskey => $accionesvalue) {
              if ($accioneskey == 'ver') {
                $permisos .= '
                <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                </div>';                 
              }
            }
          }
          else if ($value['modulo'] == 'institucion') {
                
            foreach ($acciones as $accioneskey => $accionesvalue) {
              if ($accioneskey == 'ver') {
                $permisos .= '
                <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                </div>';                 
              }
              else if ($accioneskey == 'editar') {
                $permisos .= '
                <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                </div>';                 
              }
            }
          }
          else if ($value['modulo'] == 'lapso') {

            foreach ($acciones as $accioneskey => $accionesvalue) {
              if ($accioneskey == 'ver') {
                $permisos .= '
                <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                </div>';                 
              }
              else if ($accioneskey == 'agregar') {
                    $permisos .= '
                    <div class="custom-control custom-checkbox pr-2">
                      <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                      <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                    </div>';                 
                  }
              else if ($accioneskey == 'activar-desactivar') {
                $permisos .= '
                <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                </div>';                 
              }
            }
          }
          else if ($value['modulo'] == 'aspecto-fisiologico') {

            foreach ($acciones as $accioneskey => $accionesvalue) {
              if ($accioneskey == 'ver') {
                $permisos .= '
                <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                </div>';                 
              }
              else if ($accioneskey == 'editar') {
                $permisos .= '
                <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                </div>';                 
              }
              else if ($accioneskey == 'agregar') {
                $permisos .= '
                <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                </div>';                 
              }
            }
          }
          else if ($value['modulo'] == 'boletin-final') {

            foreach ($acciones as $accioneskey => $accionesvalue) {
              if ($accioneskey == 'ver') {
                $permisos .= '
                <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                </div>';                 
              }
              else if ($accioneskey == 'editar') {
                $permisos .= '
                <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                </div>';                 
              }
              else if ($accioneskey == 'agregar') {
                $permisos .= '
                <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                </div>';                 
              }
            }
          }
          else if ($value['modulo'] == 'boletin-parcial') {

            foreach ($acciones as $accioneskey => $accionesvalue) {
              if ($accioneskey == 'ver') {
                $permisos .= '
                <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                </div>';                 
              }
              else if ($accioneskey == 'editar') {
                $permisos .= '
                <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                </div>';                 
              }
              else if ($accioneskey == 'agregar') {
                $permisos .= '
                <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                </div>';                 
              }
            }
          }
          else {
            foreach ($acciones as $accioneskey => $accionesvalue) {
              $permisos .= '
              <div class="custom-control custom-checkbox pr-2">
                <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" >
                <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
              </div>';
            }
          }
          $permisos .='</div>';             
        }
      }
    }
    // Aquí debería hacer unos arreglos para que trajera todos los permisos dependiendo del rol docente o administrador y los marcara si el usuario tiene el permiso pero que traiga todos
    else {
      $rol = $_SESSION['rol'];
      $permisos_usuario = $Usuario->traer_permisos_usuario($idusuario);
      $permisos_usuario_arreglo = [];
      $modulo_usuario = [];
      $accion_usuario = [];
      if ($permisos_usuario->num_rows != 0) {
        while ($fila = $permisos_usuario->fetch_object()) {
          $modulo_usuario[] = $fila->idmodulo;
           $permisos_usuario_arreglo[$fila->idmodulo][] = $fila->idaccion;
        }
      }
    
    // He visto hasta aquí, primero se declara el rol del usuario, despues se traen los permisos que tiene de la tabla usuario_modulo_accion que guarda los módulos a los que tiene acceso el usuario junto con los permisos que tenga, despues se guarda en el arreglo modulo_usuario solo el id del modulo, y en permisos_usuario_arreglo el id de las acciones que tenga el usuario agrupadas por el id del módulo.
      $permisos = '';
      foreach ($modulos as $key => $value) {
        if (in_array($value['id'], $modulo_usuario)) {
          $permisos .= '
          <div class="input-group-prepend">
          <div>
          <label>'.ucfirst($key).'</label>
          </div>
          </div>
          <div class="input-group pl-3  pb-3">';

          if ($value['modulo'] == 'escritorio' || $value['modulo'] == 'modulo' || $value['modulo'] == 'accion') {
            foreach ($acciones as $accioneskey => $accionesvalue) {
              $checked = '';
              if ($accioneskey == 'ver') {
              /**
               * Comprueba que el usuario posea la accion para así mostrar el checkbox seleccionado
               */
                if (in_array($accionesvalue['id'], $permisos_usuario_arreglo[$value['id']])) {
                  
                  $checked = 'checked';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                  $checked = '';
                }
                else {
                  $checked = '';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                }
              }
            }
          }
          else if ($value['modulo'] == 'institucion') {
                
            foreach ($acciones as $accioneskey => $accionesvalue) {
              $checked = '';
              if ($accioneskey == 'ver') {
              /**
               * Comprueba que el usuario posea la accion para así mostrar el checkbox seleccionado
               */
                if (in_array($accionesvalue['id'], $permisos_usuario_arreglo[$value['id']])) {
                  
                  $checked = 'checked';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                  $checked = '';
                }
                else {
                  $checked = '';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                }
              }
              else if ($accioneskey == 'editar') {
                /**
               * Comprueba que el usuario posea la accion para así mostrar el checkbox seleccionado
               */
                if (in_array($accionesvalue['id'], $permisos_usuario_arreglo[$value['id']])) {
                  
                  $checked = 'checked';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                  $checked = '';
                }
                else {
                  $checked = '';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                }
              }
            }
          }
          else if ($value['modulo'] == 'lapso') {
                
            foreach ($acciones as $accioneskey => $accionesvalue) {
              $checked = '';
              if ($accioneskey == 'ver') {
              /**
               * Comprueba que el usuario posea la accion para así mostrar el checkbox seleccionado
               */
                if (in_array($accionesvalue['id'], $permisos_usuario_arreglo[$value['id']])) {
                  
                  $checked = 'checked';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                  $checked = '';
                }
                else {
                  $checked = '';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                }
              }
              else if ($accioneskey == 'activar-desactivar') {
                /**
               * Comprueba que el usuario posea la accion para así mostrar el checkbox seleccionado
               */
                if (in_array($accionesvalue['id'], $permisos_usuario_arreglo[$value['id']])) {
                  
                  $checked = 'checked';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                  $checked = '';
                }
                else {
                  $checked = '';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                }
              }
              else if ($accioneskey == 'agregar') {
                /**
               * Comprueba que el usuario posea la accion para así mostrar el checkbox seleccionado
               */
                if (in_array($accionesvalue['id'], $permisos_usuario_arreglo[$value['id']])) {
                  
                  $checked = 'checked';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                  $checked = '';
                }
                else {
                  $checked = '';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                }
              }
            }
          }
          else if ($value['modulo'] == 'aspecto-fisiologico') {
                
            foreach ($acciones as $accioneskey => $accionesvalue) {
              $checked = '';
              if ($accioneskey == 'ver') {
              /**
               * Comprueba que el usuario posea la accion para así mostrar el checkbox seleccionado
               */
                if (in_array($accionesvalue['id'], $permisos_usuario_arreglo[$value['id']])) {
                  
                  $checked = 'checked';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                  $checked = '';
                }
                else {
                  $checked = '';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                }
              }
              else if ($accioneskey == 'editar') {
                /**
               * Comprueba que el usuario posea la accion para así mostrar el checkbox seleccionado
               */
                if (in_array($accionesvalue['id'], $permisos_usuario_arreglo[$value['id']])) {
                  
                  $checked = 'checked';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                  $checked = '';
                }
                else {
                  $checked = '';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                }
              }

              else if ($accioneskey == 'agregar') {
                /**
               * Comprueba que el usuario posea la accion para así mostrar el checkbox seleccionado
               */
                if (in_array($accionesvalue['id'], $permisos_usuario_arreglo[$value['id']])) {
                  
                  $checked = 'checked';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                  $checked = '';
                }
                else {
                  $checked = '';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                }
              }
            }
          }
          else if ($value['modulo'] == 'boletin-final') {
                
            foreach ($acciones as $accioneskey => $accionesvalue) {
              $checked = '';
              if ($accioneskey == 'ver') {
              /**
               * Comprueba que el usuario posea la accion para así mostrar el checkbox seleccionado
               */
                if (in_array($accionesvalue['id'], $permisos_usuario_arreglo[$value['id']])) {
                  
                  $checked = 'checked';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                  $checked = '';
                }
                else {
                  $checked = '';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                }
              }
              else if ($accioneskey == 'editar') {
                /**
               * Comprueba que el usuario posea la accion para así mostrar el checkbox seleccionado
               */
                if (in_array($accionesvalue['id'], $permisos_usuario_arreglo[$value['id']])) {
                  
                  $checked = 'checked';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                  $checked = '';
                }
                else {
                  $checked = '';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                }
              }

              else if ($accioneskey == 'agregar') {
                /**
               * Comprueba que el usuario posea la accion para así mostrar el checkbox seleccionado
               */
                if (in_array($accionesvalue['id'], $permisos_usuario_arreglo[$value['id']])) {
                  
                  $checked = 'checked';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                  $checked = '';
                }
                else {
                  $checked = '';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                }
              }
            }
          }
          else if ($value['modulo'] == 'boletin-parcial') {
                
            foreach ($acciones as $accioneskey => $accionesvalue) {
              $checked = '';
              if ($accioneskey == 'ver') {
              /**
               * Comprueba que el usuario posea la accion para así mostrar el checkbox seleccionado
               */
                if (in_array($accionesvalue['id'], $permisos_usuario_arreglo[$value['id']])) {
                  
                  $checked = 'checked';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                  $checked = '';
                }
                else {
                  $checked = '';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                }
              }
              else if ($accioneskey == 'editar') {
                /**
               * Comprueba que el usuario posea la accion para así mostrar el checkbox seleccionado
               */
                if (in_array($accionesvalue['id'], $permisos_usuario_arreglo[$value['id']])) {
                  
                  $checked = 'checked';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                  $checked = '';
                }
                else {
                  $checked = '';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                }
              }

              else if ($accioneskey == 'agregar') {
                /**
               * Comprueba que el usuario posea la accion para así mostrar el checkbox seleccionado
               */
                if (in_array($accionesvalue['id'], $permisos_usuario_arreglo[$value['id']])) {
                  
                  $checked = 'checked';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                  $checked = '';
                }
                else {
                  $checked = '';
                  $permisos .= '
                  <div class="custom-control custom-checkbox pr-2">
                  <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                  <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                  </div>';
                }
              }
            }
          }
          else {
            foreach ($acciones as $accioneskey => $accionesvalue) {
              $checked = '';
              /**
               * Comprueba que el usuario posea la accion para así mostrar el checkbox seleccionado
               */
              if (in_array($accionesvalue['id'], $permisos_usuario_arreglo[$value['id']])) {
                
                $checked = 'checked';
                $permisos .= '
                <div class="custom-control custom-checkbox pr-2">
                <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                </div>';
                $checked = '';
              }
              else {
                $checked = '';
                $permisos .= '
                <div class="custom-control custom-checkbox pr-2">
                <input type="checkbox" class="custom-control-input seleccionar" id="'.$key.$accioneskey.'" name="permisos[]" value="'.$value['id'].'-'.$accionesvalue['id'].'" '.$checked.'>
                <label class="custom-control-label" for="'.$key.$accioneskey.'">'.ucfirst($accioneskey).'</label>
                </div>';
              }
            }
          }
          $permisos .='</div>';  
        }                 
      }
      // var_dump($permisos);
      // die;
    }  
    
    echo $permisos;
    
  break;

	case 'listar':

		$rspta = $Usuario->listar();
    
    if ($rspta->num_rows != 0) {
      while ($reg = $rspta->fetch_object()) {

        $badge = '';
        if ($reg->estatus == 1) 
          $badge = '<span class="badge badge-pill badge-success">Activo</span>';
        else 
          $badge = '<span class="badge badge-pill badge-danger">Desactivado</span>';

        $data[] = array('0' => 

          ($reg->estatus) ? 

          ( ( isset($_SESSION['permisos']['usuario']) && 
                      in_array('editar' , $_SESSION['permisos']['usuario']) ) ?

          '<button class="btn btn-outline-primary " title="Editar" onclick="mostrar('.$reg->id.')"><i class="fas fa-edit"></i></button>' : '').

          ( ( isset($_SESSION['permisos']['usuario']) && 
                      in_array('activar-desactivar' , $_SESSION['permisos']['usuario']) ) ?

          ' <button class="btn btn-outline-danger" title="Desactivar" onclick="desactivar('.$reg->id.')"> <i class="fas fa-times"> </i></button> ' : '').

          ( ( isset($_SESSION['permisos']['usuario']) && 
                      in_array('editar' , $_SESSION['permisos']['usuario']) ) ? 

          ' <button class="btn btn-outline-warning" title="Resetear" onclick="resetear('.$reg->id.')"> <i class="fa fa-undo"> </i></button> ' : '')
          

          :

          ( ( isset($_SESSION['permisos']['usuario']) && 
                      in_array('editar' , $_SESSION['permisos']['usuario']) ) ?

          '<button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')"><i class="fa fa-edit"></i></button>' : '').

          ( ( isset($_SESSION['permisos']['usuario']) && 
                      in_array('activar-desactivar' , $_SESSION['permisos']['usuario']) ) ?

          ' <button class="btn btn-outline-success" title="Activar" onclick="activar('.$reg->id.')"><i class="fa fa-check"></i></button> ' : ''). 


          ( ( isset($_SESSION['permisos']['usuario']) && 
                      in_array('editar' , $_SESSION['permisos']['usuario']) ) ?
          ' <button class="btn btn-outline-warning" title="Resetear" onclick="resetear('.$reg->id.')"> <i class="fa fa-undo"> </i></button> ' : '')
          ,

            '1' => $reg->usuario,
            '2' => $reg->p_nombre,
            '3' => $reg->p_apellido,
            '4' => ucfirst($reg->rol),
            '5' => $reg->intentos_fallidos,
            '6' => $badge);
      }

      $results = array(
        "draw" => 0, #Esto tiene que ver con el procesamiento del lado del servidor
        "recordsTotal" => count($data), #Se envía el total de registros al datatable
        "recordsFiltered" => count($data), #Se envía el total de registros a visualizar
        "data" => $data #datos en un array

      );
    }
    else {
      $results = array(
        "draw" => 0, #Esto tiene que ver con el procesamiento del lado del servidor
        "recordsTotal" => count($data), #Se envía el total de registros al datatable
        "recordsFiltered" => count($data), #Se envía el total de registros a visualizar
        "data" => $data #datos en un array

      );
    }

		echo json_encode($results);

		break;

	case 'mostrar':
	
		$rspta = $Usuario->mostrar($idusuario);
		#Se codifica el resultado utilizando Json
		echo json_encode($rspta);

		break;

	case 'verificar':
		
		#Se encripta la contraseña con el algoritmo SHA256
    $clavehash = hash('SHA256', $pass);
    
    $usuario = $Usuario->verificar_usuario($user);

    if (!empty($usuario) && $usuario['intentos_fallidos'] < 5) {
      $rspta = $Usuario->verificar($user, $clavehash);
  
      $fetch = $rspta->fetch_object();
      
      if (isset($fetch)) {
        
        #Declaramos las variables de sesión
        $_SESSION['idusuario'] = $fetch->id;
        $_SESSION['usuario'] = $fetch->usuario;
        $_SESSION['p_nombre'] = $fetch->p_nombre;
        $_SESSION['p_apellido'] = $fetch->p_apellido;
        // $_SESSION['email'] = $fetch->email;
        $_SESSION['genero'] = $fetch->genero;
        // $_SESSION['img'] = $fetch->img;
        $_SESSION['rol'] = $fetch->rol;
        
        #Obtenemos los permisos del usuario 
        $marcados = $Usuario->traer_permisos_usuario_nombre($fetch->id);
        
        #Declaramos el array para almacenar todos los permios marcados
        $valores = array();
        
        #Almacenamos los permisos marcados en el array
        while ($per = $marcados->fetch_object()) {
          $valores[$per->modulo][] = $per->accion;
          // array_push($valores, $per->idpermiso);
        }
        $_SESSION['permisos'] = $valores;
        // #Determinamos los accesos del usuario
        // in_array(1, $valores) ? $_SESSION['escritorio'] = 1 : $_SESSION['escritorio'] = 0; 
        // in_array(2, $valores) ? $_SESSION['usuario'] = 1 : $_SESSION['almacen'] = 0;
        $Usuario->intento_fallido($usuario['id'], 0);
        echo 'true';     
      }
      else {

        if ($usuario['rol'] != 'Administrador') {
          $Usuario->intento_fallido($usuario['id'], ($usuario['intentos_fallidos'] + 1));
        }
        echo 'false';
      }
    }
    else if (empty($usuario)) {
      echo 'false';
      die;
    }
    else {
      echo 'intentos_fallidos';
      die;
    }



		break;

	case 'salir':
		#Limpiamos las variables de sesión
		session_unset();

		#Destruimos la sesión
		session_destroy();

		#Redireccionamos al login
		header('location: ../index.php');
		
		break;

	case 'desactivar': 

		$rspta = $Usuario->desactivar($idusuario);
		echo $rspta ? 'true' : 'false';
		break;

	case 'activar': 

		$rspta = $Usuario->activar($idusuario);
		echo $rspta ? 'true' : 'false';
    break;
    
  case 'resetear': 
    $datos = $Usuario->mostrar($idusuario);
    $cedula = $datos['cedula'];
    #Se obtiene la cédula sin el tipo de documento
		list($documento, $cedula) = explode('-', $cedula);

    #Se encripta la clave con el algoritmo SHA256
    $clavehash = hash('SHA256', $cedula);

		$rspta = $Usuario->resetear($idusuario, $cedula, $clavehash);
		echo $rspta ? 'true' : 'false';
		break;

	case 'comprobarpersona': 
		$rspta = $Usuario->comprobarpersona($cedula);
		echo json_encode($rspta->fetch_object());
    break;
    
  case 'traerperfil': 
    $rspta = $Usuario->traerperfil($idusuario);
    
		echo json_encode($rspta);
  break;
  
  case 'editarperfil':
    
    #Se deshabilita el guardado automático de la base de datos
		autocommit(FALSE);   
		if (!empty($idusuarioperfil)) {
			#Variable para comprobar que todo salió bien al final
			$sw = TRUE;

      $respuesta = $Usuario->seleccionar_por_usuario($usuarioperfil);

      if (empty($respuesta) || $respuesta['id'] == $idusuarioperfil) {
        #Se encripta la clave con el algoritmo SHA256
        $clavehash = hash('SHA256', $passwordusuarioperfil);
        
        #Se edita el usuario
        $rspta = $Usuario->editarusuario($idusuarioperfil, $usuarioperfil, $clavehash) or $sw = FALSE;
        #Se verifica que todo saliío bien y se guardan los datos o se eliminan todos
        
        if ($sw) {
          commit();
          $_SESSION['usuario'] = $usuarioperfil;
          echo 'true';
        }
        else {
          rollback();
          echo 'false';
        }
      }
      else {
        echo 'usuario_tomado';
      }

    } 

  break;
	
}